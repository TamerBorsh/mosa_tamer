<?php

namespace App\Http\Controllers\Institution;

use App\DataTables\InstitutionDataTable;
use App\Http\Controllers\Controller;
use App\Models\Institution;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InstitutionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(InstitutionDataTable $datatable)
    {
        return $datatable->render('dash.institutions.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isSave = Institution::create($request->all());
        if ($isSave)
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Institution $institution)
    {
        return $institution;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $institution = Institution::find($request->id);
        $isSave = $institution->update($request->all());
        if ($isSave)
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institution $institution)
    {
        $isDelete = $institution->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
