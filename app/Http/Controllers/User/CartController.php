<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Stock;
use Stripe\Terminal\Location;
use App\Services\CartService;
use App\Jobs\SendThanksMail;
use App\Jobs\SendOrderedMail;

class CartController extends Controller
{
    public function add(Request $request)
    {
        // dd($request);
        $itemInCart = Cart::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();

        if ($itemInCart) {
            $itemInCart->quantity += $request->quantity;
            $itemInCart->save();
        }
        else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return to_route('user.cart.index')->with([
            'message' => 'カートに商品を追加しました。',
            'status' => 'success'
        ]);
    }

    public function index() {
        $user = User::with(['products.imageFirst'])->findOrFail(Auth::id());
        $products = $user->products;
        $totalPrice = 0;

        foreach ($products as $product) {
            $totalPrice += $product->price * $product->pivot->quantity;
        }

        return Inertia::render('User/Cart', [
            'products' => $products,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function delete($id)
    {
        Cart::where('product_id', $id)->where('user_id', Auth::id())->delete();
        return to_route('user.cart.index')->with([
            'message' => 'カートから商品を削除しました。',
            'status' => 'alert'
        ]);
    }

    public function checkout()
    {
        $user = User::with(['products.imageFirst'])->findOrFail(Auth::id());
        $products = $user->products;

        $lineItems = [];

        // \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        foreach ($products as $product)
        {
            $quantity = '';
            $quantity = Stock::where('product_id', $product->id)->sum('quantity');
            $quantity = intval($quantity);

            if ($product->pivot->quantity > $quantity) {
                return to_route('user.cart.index')->with([
                    'message' => '在庫が不足しています。',
                    'status' => 'alert'
                ]);
            }
            else {
                // $stripe_product = \Stripe\Product::create([
                //     'name' => $product->name,
                //     'description' => $product->information,
                // ]);

                // $stripe_price = \Stripe\Price::create([
                //     'product' => $stripe_product,
                //     'unit_amount' => $product->price,
                //     'currency' => 'jpy',
                // ]);

                // $lineItem = [
                //     'price' => $stripe_price,
                //     'quantity' => $product->pivot->quantity,
                // ];

                $lineItem = [
                    'price_data' => [
                        'unit_amount' => $product->price,
                        'currency' => 'JPY',
                        'product_data' => [
                            'name' => $product->name,
                            'description' => $product->information,
                        ],
                    ],
                    'quantity' => $product->pivot->quantity,
                ];
                array_push($lineItems, $lineItem);
            }
        }

        foreach ($products as $product) {
            Stock::create([
                'product_id' => $product->id,
                'type' => \Constant::PRODUCT_LIST['reduce'],
                'quantity' => $product->pivot->quantity * -1,
            ]);
        }

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // dd(\Stripe\Stripe::getApiKey());

        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('user.cart.success'),
            'cancel_url' => route('user.cart.cancel'),
        ]);

        // $publicKey = env('STRIPE_PUBLIC_KEY');

        // dd($session, $publicKey);

        // return Inertia::render('User/Checkout', [
        //     'session' => $session,
        //     'publicKey' => $publicKey,
        // ]);

        // return Inertia::render('User/Checkout', [
        //     'line_items' => $lineItems,
        //     'mode' => 'payment',
        //     'success_url' => route('user.items.index'),
        //     'cancel_url' => route('user.cart.index'),
        //     'publicKey' => $publicKey,
        // ]);
        
        // dd($session);
        // return redirect($session->url, 303, ['Content-Type' => 'application/json' ]);
        return Inertia::location($session->url);
    }

    public function success()
    {
        ///////
        $items = Cart::where('user_id', Auth::id())->get();
        $products = CartService::getItemsInCart($items);

        $user = User::findOrFail(Auth::id());
        SendThanksMail::dispatch($products, $user);

        foreach ($products as $product)
        {
            SendOrderedMail::dispatch($product, $user);
        }

        // dd('ユーザーメール送信テスト');
        ///////

        Cart::where('user_id', Auth::id())->delete();

        return to_route('user.items.index')->with([
            'message' => '購入完了しました',
            'status' => 'success'
        ]);
    }

    public function cancel()
    {
        $user = User::findOrFail(Auth::id());
        foreach ($user->products as $product) {
            Stock::create([
                'product_id' => $product->id,
                'type' => \Constant::PRODUCT_LIST['add'],
                'quantity' => $product->pivot->quantity,
            ]);
        }

        return to_route('user.items.index')->with([
            'message' => '購入キャンセルしました',
            'status' => 'alert'
        ]);
    }
}
