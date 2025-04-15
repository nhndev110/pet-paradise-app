<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ProductsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Supplier;
use App\Services\Admin\UploadImageService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductsDataTable $dataTable)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        return $dataTable->render('admin.product.index', compact(
            'categories',
            'suppliers',
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
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = UploadImageService::uploadImage($request->file('thumbnail'), 'products');
        }

        $data['slug'] .= '-' . time();

        $product = Product::create($data);

        if ($request->hasFile('gallery')) {
            $gallery = UploadImageService::uploadMultipleImages($request->file('gallery'), 'products');
            $galleryCount = count($gallery);

            for ($i = 0; $i < $galleryCount; $i++) {
                $product->images()->create([
                    'image_url' => $gallery[$i],
                    'display_order' => $i,
                ]);
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được tạo thành công.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $suppliers = Supplier::all();
        $allProducts = Product::all();
        $gallery = $product->images()->orderBy('display_order', 'asc')->get();

        return view('admin.product.edit', compact(
            'product',
            'allProducts',
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
        $data = $request->validated();

        $data['featured'] = $request->has('featured');

        if ($data['slug'] !== $product->slug) {
            $data['slug'] .= '-' . time();
        }

        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail) {
                UploadImageService::deleteImage($product->thumbnail);
            }

            $data['thumbnail'] = UploadImageService::uploadImage($request->file('thumbnail'), 'products');
        } else {
            $data['thumbnail'] = $product->thumbnail;
        }

        $currentGallery = $product->images()->get();
        $oldGalleryUrls = $request->old_gallery ?? [];
        foreach ($currentGallery as $image) {
            if (!in_array($image->image_url, $oldGalleryUrls)) {
                ProductImage::destroy($image->id);
                UploadImageService::deleteImage($image->image_url);
            }
        }

        $maxOrder = $product->images()->max('display_order') ?? -1;
        if ($request->hasFile('gallery')) {
            $galleryFiles = $request->file('gallery');
            $uploadedGallery = UploadImageService::uploadMultipleImages($galleryFiles, 'products');

            // Thêm các ảnh mới vào với display_order tăng dần
            foreach ($uploadedGallery as $imageUrl) {
                $maxOrder++;
                $product->images()->create([
                    'image_url' => $imageUrl,
                    'display_order' => $maxOrder,
                ]);
            }
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->images()->each(function ($image) {
            UploadImageService::deleteImage($image->image_url);
            $image->delete();
        });

        if ($product->thumbnail) {
            UploadImageService::deleteImage($product->thumbnail);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Sản phẩm đã được xóa thành công.'
        ]);
    }
}
