<?php

namespace App\Http\Controllers\Nominate;

use App\Http\Controllers\Controller;
use App\Models\Nominate;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportNominateController extends Controller
{
    public function ExportEcel(Request $request)
    {
        $ids = $request->input('selectedIds');

        $nominates = Nominate::whereIn('id', $ids)->get();
        // إنشاء ملف Excel جديد
        $spreadsheet = new Spreadsheet();
        // إضافة الصف الأول (رؤوس الأعمدة)
        $headerRow = [
            'رقم الكابون',
            'الهوية',
            'الاسم',
            'تاريخ الميلاد',
            'عدد الأفراد',
            'جوال 1',
            'جوال 2',
            'المحافظة',
            'المنطقة',
            'أقرب مسجد',
            'الجنس',
            'الحالة الاجتماعية'
        ];
        $spreadsheet->getActiveSheet()->fromArray($headerRow, null, 'A1');
        // إضافة البيانات
        $dataRows = [];
        foreach ($nominates as $nominate) {

            $city = optional($nominate->user->state)->name ?? '';
            $region = optional($nominate->user->region)->name ?? '';
            $mosque = optional($nominate->user->mosque)->name ?? '';

            $dataRow = [
                $nominate->number_copon,
                $nominate->user->{'id-number'},
                $nominate->user->name,
                $nominate->user->{'barh-of-date'},
                $nominate->user->count_childern,
                $nominate->user->phone,
                $nominate->user->phone2,
                $city,
                $region,
                $mosque,
                $nominate->user->gender,
                $nominate->socialst
            ];
            $dataRows[] = $dataRow;
        }
        $spreadsheet->getActiveSheet()->fromArray($dataRows, null, 'A2');

        // حفظ الملف في الذاكرة
        $writer = new Xlsx($spreadsheet);
        $fileName = time() . rand(1, 500) . '.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        $writer->save($temp_file);
        // إرجاع الملف للمستخدم وتحذف بعد الإرسال
        return response()->download($temp_file, $fileName)->deleteFileAfterSend(true);
    }
}
