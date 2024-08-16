<?php

namespace App\DataTables;

use App\Models\Copon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CoponDataTable extends DataTable
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
            ->editColumn('type', function ($row) {
                return $row->copon_type;
            })
            ->editColumn('admin_id', function ($row) {
                return $row->admin->name;
            })
            ->addColumn('check', function ($row) {
                return $row->check();
            })
            ->setRowId('id')->rawColumns(['is_recive', 'check', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Copon $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('copon-table')
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
            [
                'title' => '<div class="custom-control custom-checkbox">' .
                    '<input type="checkbox" id="check-all" class="custom-control-input">' .
                    '<label class="custom-control-label" for="check-all"></label>' .
                    '</div>',
                'data' => 'check',
                'orderable' => false,
                'searchable' => false
            ],
            ['title' => "رقم الكوبون", 'data' =>   'number_copon'],
            ['title' => "الهوية", 'data' =>   'id_nubmer'],
            ['title' => "الاسم", 'data' =>   'name'],
            ['title' => "الاسم", 'data' =>   'type'],
            ['title' => "الحالة", 'data' =>   'is_recive', 'searchable' => false],
            ['title' => "بواسطة", 'data' =>   'admin_id', 'searchable' => false],
            ['title' => " الحذف", 'data' => 'action', 'orderable' => false, 'searchable' => false]
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Copon_' . date('YmdHis');
    }
}
