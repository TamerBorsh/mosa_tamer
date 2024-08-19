<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportUserController extends Controller
{
    public function ExportExcel(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setRightToLeft(true);

        // Add header row
        $headerRow = [
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
        $sheet->fromArray($headerRow, null, 'A1');

        $batchSize = 1000; // حجم الدفعة
        $rowIndex = 2; // بداية الصفوف بعد الهيدر

        // استخدم chunks للحصول على البيانات على دفعات
        User::Filter($request->query())->chunk($batchSize, function ($users) use ($sheet, &$rowIndex) {
            $batchData = [];
            foreach ($users as $user) {
                $city = optional($user->state)->name;
                $region = optional($user->region)->name;
                $mosque = optional($user->mosque)->name;

                $batchData[] = [
                    $user->{'id-number'},
                    $user->name,
                    $user->{'barh-of-date'},
                    $user->count_childern,
                    $user->phone,
                    $user->phone2,
                    $city,
                    $region,
                    $mosque,
                    $user->gender,
                    $user->socialst
                ];
            }

            // أضف البيانات إلى الورقة
            $sheet->fromArray($batchData, null, 'A' . $rowIndex);
            $rowIndex += count($batchData); // تحديث المؤشر
        });

        $writer = new Xlsx($spreadsheet);
        $fileName = 'users_export_' . time() . '.xlsx';
        $writer->save($fileName);

        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}
