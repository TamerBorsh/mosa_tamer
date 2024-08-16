<?php

namespace App\Http\Controllers\Nominate;

use App\Http\Controllers\Controller;
use App\Models\Nominate;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportNominateController extends Controller
{
    public function importExcelForm()
    {
        return response()->view('dash.nominates.import-excel');
    }

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

}
