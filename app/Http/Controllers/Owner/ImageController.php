<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use GuzzleHttp\Promise\Each;

class ImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {

            $id = $request->route()->parameter('image'); // imageのid取得
            if (!is_null($id)) // null判定
            {
                $imagesOwnerId = Image::findOrFail($id)->owner->id;
                $imageId = (int)$imagesOwnerId; // キャスト 文字列→数値に型変換
                if ($imageId !== Auth::id()) // 同じでなかったら
                {
                    abort(404); // 404画面表示
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
        $images = Image::where('owner_id', Auth::id())
        ->orderBy('updated_at', 'desc')
        ->paginate(8);

        return Inertia::render('Owner/Images/Index', [
            'images' => $images
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Owner/Images/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadImageRequest $request)
    {
        // dd($request);
        $imageFiles = $request->file('files');
        if (!is_null($imageFiles))
        {
            foreach ($imageFiles as $imageFile)
            {
                $fileNameToStore = ImageService::upload($imageFile, 'products');
                Image::create([
                    'owner_id' => Auth::id(),
                    'filename' => $fileNameToStore,
                ]);
            }
        }

        return to_route('owner.images.index')->with([
            'message' => '画像登録しました。',
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
        $image = Image::findOrFail($id);

        return Inertia::render('Owner/Images/Edit', [
            'image' => $image
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'string|max:50',
        ]);

        $image = Image::findOrFail($id);
        $image->title = $request->title;

        $image->save();

        return to_route('owner.images.index')->with([
            'message' => '画像情報を更新しました。',
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $image = Image::findOrFail($id);

        $imageInProducts = Product::where('image1', $image->id)
            ->orWhere('image2', $image->id)
            ->orWhere('image3', $image->id)
            ->orWhere('image4', $image->id)
            ->get();

        if($imageInProducts){
            $imageInProducts->each(function($product) use($image) {
                if($product->image1 === $image->id)
                {
                    $product->image1 = null;
                    $product->save();
                }
                if($product->image2 === $image->id)
                {
                    $product->image2 = null;
                    $product->save();
                }
                if($product->image3 === $image->id)
                {
                    $product->image3 = null;
                    $product->save();
                }
                if($product->image4 === $image->id)
                {
                    $product->image4 = null;
                    $product->save();
                }
            });
        }

        $filePath = 'public/products/'.$image->filename;

        if (Storage::exists($filePath))
        {
            Storage::delete($filePath);
        }

        Image::findOrFail($id)->delete();

        return to_route('owner.images.index')->with([
            'message' => '画像削除しました',
            'status' => 'alert'
        ]);
    }
}
