<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Supplier;
use App\Services\Admin\UploadImageService;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('admin.product.index', compact(
            'products',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('admin.product.create', compact(
            'categories',
            'suppliers',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image'] = UploadImageService::uploadImage($request->file('image'), 'guest/products');
        }

        $validated['slug'] .= '-' . time();

        $product = Product::create($validated);

        if ($request->hasFile('gallery')) {
            $gallery = UploadImageService::uploadMultipleImages($request->file('gallery'), 'guest/products');
            $validated['gallery'] = json_encode($gallery);

            foreach ($gallery as $image) {
                $product->images()->create([
                    'image_url' => $image,
                    'display_order' => array_search($image, $gallery),
                ]);
            }
        }

        return redirect()->route('admin.products.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $gallery = $product->images()->orderBy('display_order', 'asc')->get();

        return view('admin.product.edit', compact(
            'product',
            'categories',
            'suppliers',
            'gallery',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $validated['featured'] = $request->has('featured');

        if ($validated['slug'] !== $product->slug) {
            $validated['slug'] .= '-' . time();
        }

        if ($request->hasFile('image')) {
            $validated['image'] = UploadImageService::uploadImage($request->file('image'), 'guest/products');
        } else {
            $validated['image'] = $product->image;
        }

        $currentGallery = $product->images()->get();
        $oldGalleryUrls = $request->old_gallery ?? [];
        foreach ($currentGallery as $image) {
            if (!in_array($image->image_url, $oldGalleryUrls)) {
                // $image->forceDelete();
                ProductImage::destroy($image->id);
                UploadImageService::deleteImage($image->image_url);
            }
        }

        $maxOrder = $product->images()->max('display_order') ?? -1;
        if ($request->hasFile('gallery')) {
            $galleryFiles = $request->file('gallery');
            $uploadedGallery = UploadImageService::uploadMultipleImages($galleryFiles, 'guest/products');

            // Thêm các ảnh mới vào với display_order tăng dần
            foreach ($uploadedGallery as $imageUrl) {
                $maxOrder++;
                $product->images()->create([
                    'image_url' => $imageUrl,
                    'display_order' => $maxOrder,
                ]);
            }
        }

        $product->update($validated);

        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index');
    }
}
