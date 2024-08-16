<?php

namespace App\DataTables;

use App\Models\Nominate;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

class NominateDataTable extends DataTable
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
            ->addColumn('id_nubmer', function ($row) {
                return $row->user->{'id-number'};
            })
            ->addColumn('name', function ($row) {
                return $row->user->name;
            })
            ->editColumn('is_recive', function ($row) {
                return $row->recive;
            })
            ->editColumn('admin_id', function ($row) {
                return $row->admin->name;
            })
            ->addColumn('check', function ($row) {
                return $row->check();
            })
            ->addColumn('type', function ($row) {
                return "<span class='badge badge-secondary  '>" . $row->coupon->CouponType . "</span>";
            })
            ->setRowId('id')->rawColumns(['is_recive', 'check', 'action', 'type']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Request $request): QueryBuilder
    {
        return Nominate::Filter($request->query());
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('nominate-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->language([
                'url' => '/datatables_ar.json'
            ])
            ->lengthMenu([[25, 50, 100, 200, 300, 400, 500, 1000], [25, 50, 100, 200, 300, 400, 500, 1000]])
            ->pageLength(25); // Set default page length
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            [
                'title' => '<div class="custom-control custom-checkbox">' .
                    '<input type="checkbox" id="check-all" class="custom-control-input">' .
                    '<label class="custom-control-label" for="check-all"></label>' .
                    '</div>',
                'data' => 'check',
                'orderable' => false,
                'searchable' => false
            ],
            ['title' => "رقم الكوبون", 'data' => 'number_copon'],
            ['title' => "الهوية", 'data' => 'id_nubmer'],
            ['title' => "الاسم", 'data' => 'name'],
            ['title' => "نوع الطرد", 'data' => 'type'],
            ['title' => "الحالة", 'data' => 'is_recive', 'searchable' => false],
            ['title' => "بواسطة", 'data' => 'admin_id', 'searchable' => false],
            ['title' => "الحذف", 'data' => 'action', 'orderable' => false, 'searchable' => false]
        ];
    }


    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Nominate_' . date('YmdHis');
    }
}
