<?php

namespace App\DataTables\Admin;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class SuppliersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Supplier> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('name', '{{$name}}')
            ->addColumn('email', '{{$email}}')
            ->addColumn('phone', '{{$phone}}')
            ->addColumn('status', function (Supplier $supplier) {
                return $supplier->status
                    ? '<span class="badge badge-success">Hoạt động</span>'
                    : '<span class="badge badge-danger">Không hoạt động</span>';
            })
            ->addColumn('actions', function ($supplier) {
                return view('admin.supplier.partials.actions', compact('supplier'));
            })
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('name', $order);
            })
            ->orderColumn('email', function ($query, $order) {
                $query->orderBy('email', $order);
            })
            ->orderColumn('phone', function ($query, $order) {
                $query->orderBy('phone', $order);
            })
            ->rawColumns(['actions', 'status']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Supplier>
     */
    public function query(Supplier $model): QueryBuilder
    {
        $name = $this->request->name;
        if (!empty($name)) {
            $model = $model->where('name', 'LIKE', "%{$name}%");
        }

        $email = $this->request->email;
        if (!empty($email)) {
            $model = $model->where('email', 'LIKE', "%{$email}%");
        }

        $phone = $this->request->phone;
        if (!empty($phone)) {
            $model = $model->where('phone', 'LIKE', "%{$phone}%");
        }

        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('suppliers-table')
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
     */
    public function getColumns(): array
    {
        return [
            Column::make('name')
                ->searchable(true)
                ->orderable(true)
                ->title('Tên nhà cung cấp')
                ->addClass('align-middle'),
            Column::make('email')
                ->searchable(true)
                ->orderable(true)
                ->title('Email')
                ->addClass('align-middle'),
            Column::make('phone')
                ->searchable(true)
                ->orderable(true)
                ->title('Số điện thoại')
                ->width(90)
                ->addClass('align-middle'),
            Column::make('status')
                ->orderable(true)
                ->searchable(false)
                ->title('Trạng thái')
                ->width(80)
                ->addClass('text-center align-middle'),
            Column::computed('actions')
                ->title('')
                ->searchable(false)
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->width(40)
                ->addClass('text-center align-middle'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Suppliers_' . date('YmdHis');
    }
}
