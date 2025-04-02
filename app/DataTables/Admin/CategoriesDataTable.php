<?php

namespace App\DataTables\Admin;

use App\Models\Category;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CategoriesDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Category> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('name', '{{$name}}')
            ->addColumn('slug', '{{$slug}}')
            ->addColumn('thumbnail', function (Category $category) {
                return '<img src="' . asset('storage/' . $category->thumbnail) . '" alt="' . $category->name . '" width="100px" height="100px">';
            })
            ->addColumn('parentName', function (Category $category) {
                return $category->parent ? $category->parent->name : 'Không có';
            })
            ->addColumn('actions', function ($category) {
                return view('admin.category.partials.actions', compact('category'));
            })
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('name', $order);
            })
            ->orderColumn('slug', function ($query, $order) {
                $query->orderBy('slug', $order);
            })
            ->orderColumn('parentName', function ($query, $order) {
                $query->leftJoin('categories as parent', 'categories.parent_id', '=', 'parent.id')
                    ->orderBy('parent.name', $order)
                    ->select('categories.*');
            })
            ->rawColumns(['actions', 'thumbnail']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Category>
     */
    public function query(Category $model): QueryBuilder
    {
        $searchValue = $this->request->input('search.value');
        if (!empty($searchValue)) {
            return $model->where('name', 'LIKE', "%{$searchValue}%")
                ->orWhere('slug', 'LIKE', "%{$searchValue}%");
        }

        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('categories-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->selectStyleSingle()
            ->language([
                'url' => asset('admin/plugins/datatables/vn.json'),
            ])
            ->buttons(
                Button::raw([
                    'text' => '<i class="fas fa-plus mr-1"></i> Tạo mới',
                    'action' => 'function (e, dt, node, config) {
                        window.location.href = "' . route('admin.categories.create') . '";
                    }',
                ])->addClass('btn-sm'),
                Button::make('pdf')
                    ->addClass('btn-sm')
                    ->text('<i class="fas fa-file-pdf mr-1"></i> PDF')
                    ->exportOptions([
                        'columns' => [0, 1, 2, 3],
                    ]),
                Button::make('excel')
                    ->addClass('btn-sm')
                    ->text('<i class="fas fa-file-excel mr-1"></i> Excel')
                    ->exportOptions([
                        'columns' => [0, 1, 2, 3],
                    ]),
                Button::raw([
                    'text' => '<i class="fas fa-sync-alt mr-1"></i> Làm mới',
                    'action' => 'function (e, dt, node, config) {
                        dt.ajax.reload(null, false);
                    }'
                ])->addClass('btn-sm'),
            )
            ->parameters([
                'dom' => '<"row"<"col-md-6"B><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
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
                ->title('Tên danh mục')
                ->addClass('align-middle'),
            Column::make('slug')
                ->searchable(true)
                ->orderable(true)
                ->title('Slug')
                ->addClass('align-middle'),
            Column::make('thumbnail')
                ->orderable(false)
                ->searchable(false)
                ->title('Hình ảnh')
                ->addClass('text-center align-middle'),
            Column::make('parentName')
                ->title('Danh mục cha')
                ->addClass('align-middle'),
            Column::computed('actions')
                ->title('Thao tác')
                ->searchable(false)
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->width(80)
                ->addClass('text-center align-middle'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Categories_' . date('YmdHis');
    }
}
