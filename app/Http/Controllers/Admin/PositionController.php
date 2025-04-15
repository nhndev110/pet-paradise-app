<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PositionsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Position\StorePositionRequest;
use App\Http\Requests\Admin\Position\UpdatePositionRequest;
use App\Models\Position;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PositionsDataTable $dataTable)
    {
        return $dataTable->render('admin.position.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.position.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionRequest $request)
    {
        $data = $request->validated();

        $data['is_active'] = $request->has('is_active');

        Position::create($data);

        return redirect()
            ->route('admin.positions.index')
            ->with('success', 'Chức vụ đã được tạo thành công.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Position $position)
    {
        return view('admin.position.edit', compact(
            'position',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePositionRequest $request, Position $position)
    {
        $data = $request->validated();

        $data['is_active'] = $request->has('is_active');

        $position->update($data);

        return redirect()
            ->route('admin.positions.index')
            ->with('success', 'Chức vụ đã được cập nhật thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $position)
    {
        $position->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Chức vụ đã được xóa thành công.',
        ]);
    }
}
