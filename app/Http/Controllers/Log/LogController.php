<?php

namespace App\Http\Controllers\Log;

use App\DataTables\LogDataTable;
use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LogDataTable $dataTable)
    {
        return $dataTable->render('dash.logs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Log $log)
    {
        $isDelete = $log->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
