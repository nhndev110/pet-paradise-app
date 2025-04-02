<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\SuppliersDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Supplier\StoreSupplierRequest;
use App\Http\Requests\Admin\Supplier\UpdateSupplierRequest;
use App\Models\Supplier;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SuppliersDataTable $dataTable)
    {
        return $dataTable->render('admin.supplier.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.supplier.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        $data = $request->validated();

        $data['status'] = $request->has('status');

        Supplier::create($data);

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Nhà cung cấp đã được tạo thành công!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('admin.supplier.edit', compact(
            'supplier',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $data = $request->validated();

        $data['status'] = $request->has('status');

        $supplier->update($data);

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Nhà cung cấp đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Nhà cung cấp đã được xóa thành công!'
        ]);
    }

    /**
     * Toggle supplier status
     */
    public function toggleStatus(Supplier $supplier)
    {
        $supplier->status = !$supplier->status;
        $supplier->save();

        return redirect()
            ->route('admin.suppliers.index')
            ->with('success', 'Trạng thái nhà cung cấp đã được cập nhật thành công!');
    }
}
