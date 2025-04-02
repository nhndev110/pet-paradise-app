<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\CategoriesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Admin\UploadImageService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(CategoriesDataTable $dataTable)
    {
        return $dataTable->render('admin.category.index');
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.category.create', compact(
            'categories',
        ));
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = UploadImageService::uploadImage($request->file('thumbnail'), 'categories');
        }

        Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Thêm danh mục thành công');
    }

    public function edit(Category $category)
    {
        $categories = Category::all();
        return view('admin.category.edit', compact(
            'category',
            'categories',
        ));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($category->thumbnail) {
                UploadImageService::deleteImage($category->thumbnail);
            }
            $data['thumbnail'] = UploadImageService::uploadImage($request->file('thumbnail'), 'categories');
        }

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy(Category $category)
    {
        if ($category->thumbnail) {
            UploadImageService::deleteImage($category->thumbnail);
        }

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa danh mục thành công',
        ]);
    }
}
