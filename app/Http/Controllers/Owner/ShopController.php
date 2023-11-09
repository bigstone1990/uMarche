<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use Illuminate\Support\Facades\Storage;
use InterventionImage;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {
            // dd($request->route()->parameter('shop')); // 文字列
            // dd(Auth::id()); // 数値

            $id = $request->route()->parameter('shop'); // shopのid取得
            if (!is_null($id)) // null判定
            {
                $shopsOwnerId = Shop::findOrFail($id)->owner->id;
                $shopId = (int)$shopsOwnerId; // キャスト 文字列→数値に型変換
                $ownerId = Auth::id();
                if ($shopId !== $ownerId) // 同じでなかったら
                {
                    abort(404); // 404画面表示
                }
            }

            return $next($request);
        });
    }

    public function index()
    {
        // phpinfo();
        // $ownerId = Auth::id();
        $shops = Shop::where('owner_id', Auth::id())->get();

        return Inertia::render('Owner/Shops/Index', [
            'shops' => $shops
        ]);
    }

    public function edit(string $id)
    {
        $shop = Shop::findOrFail($id);

        return Inertia::render('Owner/Shops/Edit', [
            'shop' => $shop
        ]);
    }

    public function update(UploadImageRequest $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'information' => 'required|string|max:1000',
            'is_selling' => 'required',
        ]);

        $imageFile = $request->file;
        // dd($imageFile);
        if (!is_null($imageFile) && $imageFile->isValid())
        {
            $fileNameToStore = ImageService::upload($imageFile, 'shops');
            // // Storage::putFile('public/shops', $imageFile); // リサイズなし
            // $fileName = uniqid(rand().'_');
            // $extension = $imageFile->extension();
            // $fileNameToStore = $fileName.'.'.$extension;

            // $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();
            // // dd($imageFile, $resizedImage);
            // Storage::put('public/shops/'.$fileNameToStore, $resizedImage);
        }

        $shop = Shop::findOrFail($id);
        $shop->name = $request->name;
        $shop->information = $request->information;
        $shop->is_selling = $request->is_selling;
        if (!is_null($imageFile) && $imageFile->isValid())
        {
            $shop->filename = $fileNameToStore;
        }

        $shop->save();

        return to_route('owner.shops.index')->with([
            'message' => '店舗情報を更新しました。',
            'status' => 'success'
        ]);
    }
}
