<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Jobs\User\ImportExcelJob;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImportUserController extends Controller
{
    // Form Upload
    public function importExcelForm(): Response
    {
        return response()->view('dash.users.import-excel');
    }

    //Store
    public function ImportExcel(Request $request)
    {
        if (!$request->hasFile('excel_file')) {
            return redirect()->back()->with('error', 'No file uploaded');
        }

        try {
            $filePath = $request->file('excel_file')->store('temp');

            // إرسال الوظيفة إلى الطابور
            ImportExcelJob::dispatch(storage_path('app/' . $filePath));

            return redirect()->back()->with('success', 'تم تحميل الملف وجاري استيراده ..');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error processing the file: ' . $e->getMessage());
        }
    }
}
