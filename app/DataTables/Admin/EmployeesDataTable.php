<?php

namespace App\DataTables\Admin;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EmployeesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('name', function ($employee) {
                return $employee->user->name;
            })
            ->addColumn('email', function ($employee) {
                return $employee->user->email;
            })
            ->addColumn('phone_number', function ($employee) {
                return $employee->user->phone_number;
            })
            ->addColumn('position', function ($employee) {
                return $employee->position->name;
            })
            ->addColumn('status', function ($employee) {
                $lockStatus = $employee->is_locked
                    ? '<span class="badge badge-danger">Đã khóa</span>'
                    : '<span class="badge badge-success">Đang hoạt động</span>';

                $verifyStatus = $employee->user->email_verified_at
                    ? '<span class="badge badge-info">Đã xác thực</span>'
                    : '<span class="badge badge-warning">Chưa xác thực</span>';

                return $lockStatus . '<br>' . $verifyStatus;
            })
            ->addColumn('actions', function ($employee) {
                return view('admin.employee.partials.actions', compact('employee'));
            })
            ->orderColumn('employee', function ($query, $order) {
                $query->join('users', 'employees.user_id', '=', 'users.id')
                    ->orderBy('users.name', $order)
                    ->select('employees.*');
            })
            ->orderColumn('position', function ($query, $order) {
                $query->join('positions', 'employees.position_id', '=', 'positions.id')
                    ->orderBy('positions.name', $order)
                    ->select('employees.*');
            })
            ->rawColumns(['employee', 'status', 'actions']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param Employee $model
     * @return QueryBuilder
     */
    public function query(Employee $model): QueryBuilder
    {
        $query = $model->newQuery()->with(['user', 'position']);

        $name = $this->request->name;
        if (!empty($name)) {
            $query->whereHas('user', function ($subquery) use ($name) {
                $subquery->where('name', 'LIKE', "%{$name}%");
            });
        }

        $email = $this->request->email;
        if (!empty($email)) {
            $query->whereHas('user', function ($subquery) use ($email) {
                $subquery->where('email', 'LIKE', "%{$email}%");
            });
        }

        $phone = $this->request->phone_number;
        if (!empty($phone)) {
            $query->whereHas('user', function ($subquery) use ($phone) {
                $subquery->where('phone_number', 'LIKE', "%{$phone}%");
            });
        }

        $positionId = $this->request->position_id;
        if (!empty($positionId)) {
            $query->where('position_id', $positionId);
        }

        $status = $this->request->status;
        if (!empty($status)) {
            $query->where('is_locked', $status === 'locked' ? 1 : 0);
        }

        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return HtmlBuilder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('employees-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->selectStyleSingle()
            ->language([
                'url' => asset('admin/plugins/datatables/vn.json'),
            ])
            ->parameters([
                'dom' => 'rt<"row"<"col-md-6"i><"col-md-6"p>>',
                'pageLength' => 10,
                'processing' => true,
                'serverSide' => true,
                'ordering' => true,
                'order' => [],
                'responsive' => true,
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('name')
                ->title('Họ tên')
                ->width(250)
                ->addClass('align-middle'),
            Column::make('email')
                ->title('Email')
                ->orderable(false)
                ->addClass('align-middle'),
            Column::make('phone_number')
                ->title('SĐT')
                ->orderable(false)
                ->addClass('align-middle'),
            Column::make('position')
                ->title('Chức vụ')
                ->addClass('align-middle'),
            Column::make('status')
                ->title('Trạng thái')
                ->addClass('align-middle')
                ->width(80),
            Column::computed('actions')
                ->title('')
                ->exportable(false)
                ->printable(false)
                ->width(40)
                ->addClass('text-center align-middle'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Employee_' . date('YmdHis');
    }
}
