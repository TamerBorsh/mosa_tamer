<?php

namespace App\DataTables;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

class CouponDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $row->control;
            })
            ->editColumn('type', function ($row) {
                return $row->CouponType;
            })
            ->editColumn('admin_id', function ($row) {
                return $row->admin->name;
            })
            ->editColumn('institution_id', function ($row) {
                return $row->institution->name;
            })
            ->editColumn('institution_support', function ($row) {
                return $row->institutionsupport ? $row->institutionsupport->name: '';
            })
            ->editColumn('location_id', function ($row) {
                return $row->location->name;
            })
            ->setRowId('id')->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Coupon $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('coupon-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->language([
                'url' => '/datatables_ar.json'
            ])
            ->lengthMenu([[25, 50, 100, 200, 300, 400, 500], [25, 50, 100, 200, 300, 400, 500]])
            ->pageLength(25); // Set default page length
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            ['title' => '#', 'data' =>   'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => "الاسم", 'data' =>   'name'],
            ['title' => "المؤسسة المنفذة", 'data' =>   'institution_id'],
            ['title' => "المؤسسة الداعمة", 'data' =>   'institution_support'],
            ['title' => "البركس", 'data' =>   'location_id'],
            ['title' => "الكمية", 'data' =>   'quantity'],
            ['title' => "النوع", 'data' =>   'type'],
            ['title' => "بواسطة", 'data' =>   'admin_id', 'searchable' => false],
            ['title' => " الحذف", 'data' => 'action', 'orderable' => false, 'searchable' => false]
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Coupon_' . date('YmdHis');
    }
}
