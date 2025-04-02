<?php

namespace App\DataTables\Admin;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Product> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('product', function (Product $product) {
                $image = '<img src="' . asset('storage/' . $product->thumbnail) . '" alt="' . $product->name . '" width="60px" height="60px" class="mr-2">';
                return '<div class="d-flex align-items-center">' . $image . '<span>' . $product->name . '</span></div>';
            })
            ->addColumn('price', function (Product $product) {
                return number_format($product->price) . ' đ';
            })
            ->addColumn('stock', '{{$stock}}')
            ->addColumn('category', function (Product $product) {
                return $product->category ? $product->category->name : 'Không có';
            })
            ->addColumn('status', function (Product $product) {
                $status = $product->status ? 'Hiển thị' : 'Ẩn';
                $statusClass = $product->status ? 'badge-success' : 'badge-danger';
                return '<span class="badge ' . $statusClass . '">' . $status . '</span>';
            })
            ->addColumn('actions', function ($product) {
                return view('admin.product.partials.actions', compact('product'));
            })
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('name', $order);
            })
            ->orderColumn('price', function ($query, $order) {
                $query->orderBy('price', $order);
            })
            ->orderColumn('category', function ($query, $order) {
                $query->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                    ->orderBy('categories.name', $order)
                    ->select('products.*');
            })
            ->rawColumns(['actions', 'thumbnail', 'status', 'product']);
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Product>
     */
    public function query(Product $model): QueryBuilder
    {
        $searchValue = $this->request->input('search.value');
        if (!empty($searchValue)) {
            return $model->where('name', 'LIKE', "%{$searchValue}%")
                ->orWhere('sku', 'LIKE', "%{$searchValue}%")
                ->orWhereHas('category', function ($query) use ($searchValue) {
                    $query->where('name', 'LIKE', "%{$searchValue}%");
                })
                ->orderBy('created_at', 'desc');
        }

        return $model->orderBy('created_at', 'desc')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('products-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->selectStyleSingle()
            ->language([
                'url' => asset('admin/plugins/datatables/vn.json'),
                'searchPlaceholder' => 'Tìm kiếm theo tên, mã SKU hoặc danh mục...',
            ])
            ->buttons(
                Button::raw([
                    'text' => '<i class="fas fa-plus mr-1"></i> Tạo mới',
                    'action' => 'function (e, dt, node, config) {
                        window.location.href = "' . route('admin.products.create') . '";
                    }',
                ])->addClass('btn-sm'),
                Button::make('pdf')
                    ->addClass('btn-sm')
                    ->text('<i class="fas fa-file-pdf mr-1"></i> PDF')
                    ->exportOptions([
                        'columns' => [0, 1, 2, 3, 4],
                    ]),
                Button::make('excel')
                    ->addClass('btn-sm')
                    ->text('<i class="fas fa-file-excel mr-1"></i> Excel')
                    ->exportOptions([
                        'columns' => [0, 1, 2, 3, 4],
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
                'processing' => '
                    <div class="d-flex align-items-center">
                        <strong>Đang xử lý........</strong>
                        <div class="spinner-border ml-2" role="status" aria-hidden="true"></div>
                    </div>
                ',
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('product')
                ->orderable(true)
                ->title('Sản phẩm')
                ->addClass('align-middle')
                ->width(450),
            Column::make('price')
                ->orderable(true)
                ->title('Giá')
                ->addClass('align-middle'),
            Column::make('stock')
                ->orderable(true)
                ->title('Tồn kho')
                ->addClass('align-middle'),
            Column::make('category')
                ->title('Danh mục')
                ->addClass('align-middle'),
            Column::make('status')
                ->title('Trạng thái')
                ->width(60)
                ->addClass('align-middle text-center'),
            Column::computed('actions')
                ->title('Thao tác')
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
        return 'Products_' . date('YmdHis');
    }
}
