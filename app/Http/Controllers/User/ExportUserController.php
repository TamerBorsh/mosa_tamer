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
            'المحافظة',
            'المنطقة',
            'جوال 1',
            'جوال 2',
            'عدد الأفراد',
            'تاريخ الميلاد',
            'الجنس',
            'الحالة الاجتماعية',
            'اسم الزوجة',
            'هوية الزوجة',
            'اسم الزوجة 2',
            'هوية الزوجة 2',
            'اسم الزوجة 3',
            'هوية الزوجة 3',
            'اسم الزوجة 4',
            'هوية الزوجة 4',
        ];
        $sheet->fromArray($headerRow, null, 'A1');

        $batchSize = 500; // حجم الدفعة
        $rowIndex = 2; // بداية الصفوف بعد الهيدر

        // استخدم chunks للحصول على البيانات على دفعات
        User::Filter($request->query())->chunk($batchSize, function ($users) use ($sheet, &$rowIndex) {
            $batchData = [];
            foreach ($users as $user) {
                $state = optional($user->state)->name;
                $region = optional($user->region)->name;
                $mosque = optional($user->mosque)->name;

                $batchData[] = [
                    $user->{'id-number'},
                    $user->name,
                    $state,
                    $region,
                    $user->phone,
                    $user->phone2,
                    $user->count_childern,
                    $user->{'barh-of-date'},
                    $user->gender,
                    $user->socialst,
                    $user->{'name-wife'},
                    $user->{'id-number-wife'},
                    $user->{'name-wife2'},
                    $user->{'id-number-wife2'},
                    $user->{'name-wife3'},
                    $user->{'id-number-wife3'},
                    $user->{'name-wife4'},
                    $user->{'id-number-wife4'},
                    // $mosque,
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
