<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
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
            ->editColumn('region_id', function ($row) {
                return $row->region ? $row->region->name : '';
            })
            ->editColumn('is_active', function ($row) {
                return $row->isactive();
            })
            ->addColumn('check', function ($row) {
                return $row->check();
            })
            ->setRowId('id')->rawColumns(['is_active', 'check', 'action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Request $request): QueryBuilder
    {
        return User::Filter($request->query());
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('user-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->language([
                'url' => '/datatables_ar.json'
            ])->lengthMenu([[25, 50, 100, 200, 300, 400, 500], [25, 50, 100, 200, 300, 400, 500]])
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

            // ['title' => '#', 'data' =>   'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => "الهوية", 'data' =>   'id-number'],
            ['title' => "الاسم", 'data' =>   'name'],
            ['title' => "المنطقة", 'data' =>   'region_id'],
            ['title' => "تاريخ الميلاد", 'data' =>   'barh-of-date'],
            ['title' => "عدد الأفراد", 'data' =>   'count_childern'],
            ['title' => "الحالة", 'data' =>   'is_active', 'searchable' => false],
            ['title' => "التعديل أو الحذف", 'data' => 'action', 'orderable' => false, 'searchable' => false]
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
