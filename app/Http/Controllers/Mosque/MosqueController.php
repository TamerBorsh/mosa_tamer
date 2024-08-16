<?php

namespace App\Http\Controllers\Mosque;

use App\DataTables\MosqueDataTable;
use App\Http\Controllers\Controller;
use App\Models\Mosque;
use App\Models\Region;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MosqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MosqueDataTable $datatable)
    {
        $region = Region::get(['id', 'name']);
        return $datatable->render('dash.mosques.index', ['regions' => $region]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isSave = Mosque::create($request->all());
        if ($isSave)
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mosque $mosque)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mosque $mosque)
    {
        return $mosque;
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateData(Request $request)
    {
        $mosque = Mosque::find($request->id);
        $isSave = $mosque->update($request->all());
        if ($isSave)
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mosque $mosque)
    {
        $isDelete = $mosque->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
