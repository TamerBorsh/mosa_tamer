<?php

namespace App\DataTables;

use App\Models\Problem;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Str;

class ProblemDataTable extends DataTable
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
            })->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d');
            })->editColumn('content', function ($row) {
                return Str::limit($row->content, 30);
            })->editColumn('title', function ($row) {
                return Str::limit($row->title, 30);
            })
            ->setRowId('id')->rawColumns(['action']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Problem $model): QueryBuilder
    {
        return $model->newQuery()->where('user_id', Auth::id());
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('problem-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->selectStyleSingle()->language([
                'url' => '/datatables_ar.json'
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            ['title' => '#', 'data' =>   'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => "عنوان الشكوى", 'data' =>   'title'],
            ['title' => 'تفاصيل الشكوى', 'data' =>   'content', 'orderable' => false],
            ['title' => "أنشئ في", 'data' => 'created_at', 'orderable' => false, 'searchable' => false],
            ['title' => "الرد", 'data' => 'action', 'orderable' => false, 'searchable' => false]
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Problem_' . date('YmdHis');
    }
}
