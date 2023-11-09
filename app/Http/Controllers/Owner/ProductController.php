<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Image;
use App\Models\Shop;
use App\Models\PrimaryCategory;
use App\Models\Owner;
use Illuminate\Support\Facades\DB; // QueryBuilder
use Illuminate\Support\Facades\Log;
use App\Models\Stock;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {

            $id = $request->route()->parameter('product');
            if (!is_null($id))
            {
                $productsOwnerId = Product::findOrFail($id)->shop->owner->id;
                $productId = (int)$productsOwnerId;
                if ($productId !== Auth::id())
                {
                    abort(404);
                }
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ownerInfo = Owner::with('shop.product.imageFirst')
        ->where('id', Auth::id())
        ->get();

        // dd($ownerInfo);

        // foreach ($ownerInfo as $owner)
        // {
        //     foreach ($owner->shop->product as $product)
        //     {
        //         dd($product->imageFirst->filename);
        //     }
        // }

        return Inertia::render('Owner/Products/Index', [
            'ownerInfo' => $ownerInfo,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $shops = Shop::where('owner_id', Auth::id())
        ->select('id', 'name')
        ->get();

        $images = Image::where('owner_id', Auth::id())
        ->select('id', 'title', 'filename')
        ->orderBy('updated_at', 'desc')
        ->get();

        $categories = PrimaryCategory::with('secondary')
        ->get();

        return Inertia::render('Owner/Products/Create', [
            'shops' => $shops,
            'images' => $images,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // dd($request);
        

        try {
            DB::transaction(function () use($request) {
                $product = Product::create([
                    'name' => $request->name,
                    'information' => $request->information,
                    'price' => $request->price,
                    'sort_order' => $request->sort_order,
                    'information' => $request->information,
                    'shop_id' => $request->shop_id,
                    'secondary_category_id' => $request->category,
                    'image1' => $request->image1,
                    'image2' => $request->image2,
                    'image3' => $request->image3,
                    'image4' => $request->image4,
                    'is_selling' => $request->is_selling,
                ]);

                Stock::create([
                    'product_id' => $product->id,
                    'type' => 1,
                    'quantity' => $request->quantity,
                ]);
            }, 2);
        } catch (\Throwable $th) {
            Log::error($th);
            throw $th;
        }

        return to_route('owner.products.index')->with([
            'message' => '登録しました',
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with(['imageFirst', 'imageSecond', 'imageThird', 'imageFourth'])->findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)->sum('quantity');

        $shops = Shop::where('owner_id', Auth::id())
        ->select('id', 'name')
        ->get();

        $images = Image::where('owner_id', Auth::id())
        ->select('id', 'title', 'filename')
        ->orderBy('updated_at', 'desc')
        ->get();

        $categories = PrimaryCategory::with('secondary')
        ->get();

        return Inertia::render('Owner/Products/Edit', [
            'product' => $product,
            'quantity' => $quantity,
            'shops' => $shops,
            'images' => $images,
            'categories' => $categories,
            'constants' => \Constant::PRODUCT_LIST,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $request->validate([
            'current_quantity' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);

        $quantity = Stock::where('product_id', $product->id)->sum('quantity');

        if($request->current_quantity !== $quantity)
        {
            $id = $request->route()->parameter('product');

            return to_route('owner.products.edit', ['product' => $id])->with([
                'message' => '在庫数が変更されています。再度確認してください。',
                'status' => 'alert'
            ]);
        }
        else
        {
            try {
                DB::transaction(function () use($request, $product) {
                    $product->name = $request->name;
                    $product->information = $request->information;
                    $product->price = $request->price;
                    $product->sort_order = $request->sort_order;
                    $product->information = $request->information;
                    $product->shop_id = $request->shop_id;
                    $product->secondary_category_id = $request->category;
                    $product->image1 = $request->image1;
                    $product->image2 = $request->image2;
                    $product->image3 = $request->image3;
                    $product->image4 = $request->image4;
                    $product->is_selling = $request->is_selling;
                    $product->save();
                    
                    // dd($request->type, $request->quantity);

                    if($request->type === \Constant::PRODUCT_LIST['add'])
                    {
                        $newQuantity = $request->quantity;
                    }
                    if($request->type === \Constant::PRODUCT_LIST['reduce'])
                    {
                        $newQuantity = $request->quantity * -1;
                    }
                    Stock::create([
                        'product_id' => $product->id,
                        'type' => $request->type,
                        'quantity' => $newQuantity,
                    ]);
                }, 2);
            } catch (\Throwable $th) {
                Log::error($th);
                throw $th;
            }
    
            return to_route('owner.products.index')->with([
                'message' => '更新しました',
                'status' => 'success'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::findOrFail($id)->delete();

        return to_route('owner.products.index')->with([
            'message' => '商品削除しました',
            'status' => 'alert'
        ]);
    }
}
