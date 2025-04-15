<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\EmployeesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Employee\StoreEmployeeRequest;
use App\Http\Requests\Admin\Employee\UpdateEmployeeRequest;
use App\Mail\EmployeeCreatedMail;
use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
use App\Services\Admin\UploadImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EmployeesDataTable $dataTable)
    {
        return $dataTable->render('admin.employee.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $positions = Position::all();

        return view('admin.employee.create', compact(
            'positions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();

        $data['is_locked'] = $request->has('is_locked');

        $data['plain_password'] = Str::password(8);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = UploadImageService::uploadImage($request->file('avatar'), 'employees');
        }

        $user = new User();
        DB::transaction(function () use ($data, $user) {
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['plain_password']);
            $user->phone_number = $data['phone_number'];
            $user->save();

            Employee::create([
                'user_id' => $user->id,
                'position_id' => $data['position_id'],
                'hire_date' => $data['hire_date'],
                'is_male' => $data['is_male'],
                'birth_date' => $data['birth_date'],
                'address' => $data['address'],
                'bio' => $data['bio'],
                'is_locked' => $data['is_locked'],
                'avatar' => $data['avatar'] ?? null,
            ]);
        });

        try {
            Mail::to($user->email)->send(new EmployeeCreatedMail($user, $data['plain_password']));
        } catch (\Exception $e) {
            \Log::error('Không thể gửi email cho nhân viên mới: ' . $e->getMessage());
        }

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Thêm nhân viên thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('admin.employee.show', [
            'employee' => $employee,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $positions = Position::all();

        return view('admin.employee.edit', compact(
            'employee',
            'positions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($employee->avatar) {
                UploadImageService::deleteImage($employee->avatar);
            }
            $data['avatar'] = UploadImageService::uploadImage($request->file('avatar'), 'employees');
        }

        $employee->update($data);

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Cập nhật nhân viên thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        if ($employee->avatar) {
            UploadImageService::deleteImage($employee->avatar);
        }

        $employee->delete();

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Xóa nhân viên thành công');
    }
}
