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
        $name = $this->request->name;
        if (!empty($name)) {
            $model = $model->where('name', 'LIKE', "%{$name}%");
        }

        $categoryId = $this->request->category_id;
        if (!empty($categoryId)) {
            $model = $model->whereHas('category', function ($query) use ($categoryId) {
                $query->where('id', $categoryId);
            });
        }

        $supplierId = $this->request->supplier_id;
        if (!empty($supplierId)) {
            $model = $model->whereHas('supplier', function ($query) use ($supplierId) {
                $query->where('id', $supplierId);
            });
        }

        $minPrice = $this->request->min_price;
        if (!empty($minPrice)) {
            $model = $model->where('price', '>=', $minPrice);
        }

        $maxPrice = $this->request->max_price;
        if (!empty($maxPrice)) {
            $model = $model->where('price', '<=', $maxPrice);
        }

        $status = $this->request->status;
        if (!empty($status)) {
            $model = $model->where('status', $status);
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
            ])
            ->buttons(
                Button::raw([
                    'text' => '<i class="fas fa-sync-alt mr-1"></i>',
                    'action' => 'function (e, dt, node, config) {
                        dt.ajax.reload(null, false);

                        $("html, body").animate({
                            scrollTop: $("#products-table").offset().top - 100
                        }, 200);
                    }'
                ]),
            )
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
                ->title('')
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
        return 'Products_' . date('YmdHis');
    }
}
