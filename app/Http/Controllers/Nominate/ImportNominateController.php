<?php

namespace App\Http\Controllers\Nominate;

use App\Http\Controllers\Controller;
use App\Jobs\Nominate\ImportExcelJob;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportNominateController extends Controller
{
    //import Excel Form for refresh status
    public function importExcelForm()
    {
        return response()->view('dash.nominates.import-excel');
    }

    //Update refresh status
    public function import(Request $request)
    {
        // التحقق من وجود الملف في الطلب
        if ($request->hasFile('excel_file')) {
            try {
                $path = $request->file('excel_file')->path();
                // تحميل الملف باستخدام PhpSpreadsheet
                $spreadsheet = IOFactory::load($path);
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray();

                // الآن لديك البيانات في مصفوفة $data، يمكنك معالجتها كما تريد
                foreach ($data as $index => $row) {
                    // تجاوز صف الهيدر
                    if ($index == 0) {
                        continue;
                    }
                    // البحث عن الكابون وتحديث حالته
                    $copon = Nominate::where('number_copon', $row[0])->first();
                    if ($copon) {
                        $copon->update(['is_recive' => $row[1]]);
                    }
                }

                return redirect()->back()->with('success', 'تم رفع الملف وتحديث حالة المستفيد بنجاح');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'حدث خطأ أثناء معالجة الملف: ' . $e->getMessage());
            }
        }
        return redirect()->back()->with('error', 'لم يتم تحميل أي ملف');
    }

    //import Excel Form for import Nominates
    public function importFormNominates()
    {
        return response()->view('dash.nominates.importFormNominates');
    }

    //Store
    public function importExcel(Request $request)
    {
        if (!$request->hasFile('file')) {
            return redirect()->back()->with('error', 'No file uploaded');
        }

        try {
            $filePath = $request->file('file')->store('temp');

            // إرسال الوظيفة إلى الطابور
            ImportExcelJob::dispatch(storage_path('app/' . $filePath));

            return redirect()->back()->with('success', 'تم تحميل الملف وجاري استيراده ..');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error processing the file: ' . $e->getMessage());
        }
    }
}
