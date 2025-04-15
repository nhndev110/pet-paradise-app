<?php

namespace App\DataTables\Admin;

use App\Models\Position;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PositionsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Position> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('name', '{{$name}}')
            ->addColumn('is_active', function (Position $position) {
                return $position->is_active
                    ? '<span class="badge badge-success">Hoạt động</span>'
                    : '<span class="badge badge-danger">Không hoạt động</span>';
            })
            ->addColumn('actions', function ($position) {
                return view('admin.position.partials.actions', compact('position'));
            })
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('name', $order);
            })
            ->rawColumns(['actions', 'is_active']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Position>
     */
    public function query(Position $model): QueryBuilder
    {
        $searchValue = $this->request->input('search.value');
        if (!empty($searchValue)) {
            return $model->where('name', 'LIKE', "%{$searchValue}%")
                ->orWhere('description', 'LIKE', "%{$searchValue}%");
        }

        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('positions-table')
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
                ->title('Tên chức vụ')
                ->addClass('align-middle'),
            Column::make('is_active')
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
        return 'Positions_' . date('YmdHis');
    }
}
