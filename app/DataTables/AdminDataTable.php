<?php

namespace App\DataTables;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

class AdminDataTable extends DataTable
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
            ->setRowId('id')->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Admin $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('admin-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->language([
                'url' => '/datatables_ar.json'
            ])
            ->lengthMenu([[25, 50, 100], [25, 50, 100]])
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
            ['title' => "اليوزرنيم", 'data' =>   'username'],
            ['title' => "التعديل أو الحذف", 'data' => 'action', 'orderable' => false, 'searchable' => false]
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Admin_' . date('YmdHis');
    }
}
