<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Cart;

class CartService
{
  public static function getItemsInCart($items)
  {
    $products = [];

    // dd($items);

    foreach ($items as $item)
    {
      $p = Product::findOrFail($item->product_id);
      $owner = $p->shop->owner->select('name', 'email')->first()->toArray();  // オーナー情報
      $values = array_values($owner); // 連想配列の値を取得
      $keys = ['ownerName', 'email'];
      $ownerInfo = array_combine($keys, $values); // オーナー情報のキーを変更

      // dd($ownerInfo);

      $product = Product::where('id', $item->product_id)
        ->select('id', 'name', 'price')->get()->toArray();  // 商品情報の配列
      $quantity = Cart::where('product_id', $item->product_id)
        ->select('quantity')->get()->toArray(); // 在庫数の配列

      // dd($product, $quantity);

      $result = array_merge($product[0], $ownerInfo, $quantity[0]); // 配列の結合
      
      // dd($result);

      array_push($products, $result);
    }

    // dd($products);

    return $products;
  }
}