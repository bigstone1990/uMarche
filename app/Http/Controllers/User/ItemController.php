<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Facades\DB; // QueryBuilder
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;
use App\Models\PrimaryCategory;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Jobs\SendThanksMail;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:users');

        $this->middleware(function ($request, $next) {

            $id = $request->route()->parameter('item');
            if (!is_null($id))
            {
                $itemId = Product::availableItems()->where('products.id', $id)->exists();
                
                if (!$itemId)
                {
                    abort(404);
                }
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        // 同期メール送信テスト
        // Mail::to('test@example.com')
        //     ->send(new TestMail());

        //非同期メール送信テスト
        // SendThanksMail::dispatch();

        // dd($request);
        $sort = $request->sort;
        $pagination = $request->pagination;

        $category = $request->category;
        $keyword = $request->keyword;

        // dd($sort);

        if ($sort === null) {
            $sort = \Constant::SORT_ORDER['recommend'];
        }

        if ($pagination === null) {
            $pagination = "8";
        }

        if ($category === null) {
            $category = "0";
        }

        if ($keyword === null) {
            $keyword = "";
        }

        $products = Product::availableItems()
            ->selectCategory($category ?? '0')
            ->searchKeyword($keyword)
            ->sortOrder($sort)
            ->paginate($pagination);
        
        // dd($products);

        // $stocks = DB::table('t_stocks')
        //     ->select('product_id', DB::raw('sum(quantity) as quantity'))
        //     ->groupBy('product_id')
        //     ->having('quantity', '>=', 1);
        
        // dd($stocks);
        
        // $products = DB::table('products')
        //     ->joinSub($stocks, 'stock', function($join){
            //         $join->on('products.id', '=', 'stock.product_id');
            //     })
            //     ->join('shops', 'products.shop_id', '=', 'shops.id')
            //     ->join('secondary_categories', 'products.secondary_category_id', '=', 'secondary_categories.id')
            //     ->join('images as image1', 'products.image1', '=', 'image1.id')
            //     ->join('images as image2', 'products.image2', '=', 'image2.id')
            //     ->join('images as image3', 'products.image3', '=', 'image3.id')
            //     ->join('images as image4', 'products.image4', '=', 'image4.id')
            //     ->where('shops.is_selling', true)
            //     ->where('products.is_selling', true)
            //     ->select('products.id as id', 'products.name as name', 'products.price as price', 'products.sort_order as sort_order', 'products.information as information', 'secondary_categories.name as category', 'image1.filename as filename')
            //     ->get();
            
            // dd($products);
            
            // $products = Product::with(['imageFirst', 'category'])->get();
        
            // dd($sort);
        
            $categories = PrimaryCategory::with('secondary')
            ->get();

            return Inertia::render('User/Index', [
            'products' => $products,
            'sort' => $sort,
            'pagination' => $pagination,
            'constants' => \Constant::SORT_ORDER,
            'categories' => $categories,
            'category' => $category,
            'keyword' => $keyword,
        ]);
    }

    public function show($id)
    {
        $product = Product::with(['imageFirst', 'imageSecond', 'imageThird', 'imageFourth', 'category', 'shop'])->findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)->sum('quantity');

        
        if ($quantity > 9)
        {
            $quantity = "9";
        }    

        return Inertia::render('User/Show', [
            'product' => $product,
            'quantity' => $quantity,
        ]);
    }
}
