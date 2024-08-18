<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Mosque;
use App\Models\Region;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Response;

class ExportController extends Controller
{
    public function getlocationId($name)
    {
        $location = Location::where('name', $name)->first();
        if ($location) {
            return $location->id;
        } else {
            $showlocation = Location::create(['name' => $name]);
            return $showlocation->id;
        }
    }
    public function getRegionId($name)
    {
        if (empty($name)) {
            return null; // إذا كان الاسم فارغًا، أعد قيمة null
        }

        // البحث عن المنطقة باستخدام الاسم
        $region = Region::where('name', $name)->first();

        // إذا كانت المنطقة موجودة، إرجاع معرفها
        if ($region) {
            return $region->id;
        } else {
            // إنشاء منطقة جديدة وإرجاع معرفها
            $newRegion = Region::create(['name' => $name]);
            return $newRegion->id;
        }
    }

    public function getStateId($name)
    {
        if (empty($name)) {
            return null; // إذا كان الاسم فارغًا، أعد قيمة null
        }

        // البحث عن المنطقة باستخدام الاسم
        $state = State::where('name', $name)->first();

        if ($state) {
            return $state->id;
        } else {
            $newstate = State::create(['name' => $name]);
            return $newstate->id;
        }
    }

    protected function getMosqueId($name)
    {
        // البحث عن المسجد باستخدام الاسم
        $mosque = Mosque::where('name', $name)->first();

        // إذا كان المسجد موجودًا، إرجاع معرفه
        if ($mosque) {
            return $mosque->id;
        } else {
            // إنشاء مسجد جديد وإرجاع معرفه
            $newMosque = Mosque::create(['name' => $name]);
            return $newMosque->id;
        }
    }
    protected function getMosqueName($name)
    {
        // البحث عن المسجد باستخدام الاسم
        $mosque = Mosque::where('name', $name)->first();

        // إذا كان المسجد موجودًا، إرجاع معرفه
        if ($mosque) {
            return $mosque->id;
        } else {
            // إنشاء مسجد جديد وإرجاع معرفه
            $newMosque = Mosque::create(['name' => $name]);
            return $newMosque->id;
        }
    }
    // Form Upload
    public function importExcelForm(): Response
    {
        return response()->view('dash.users.import-excel');
    }

    public function ImportEcel(Request $request)
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

                    $user_exit = User::where('id-number', $row[0])->first();

                    if ($user_exit) {
                        // محاولة تحليل تاريخ الميلاد باستخدام تنسيقات متعددة
                        $birthdate = null;
                        $dateFormats = ['d/m/Y', 'Y-m-d', 'Y/m/d']; // تنسيقات متعددة لتواريخ الميلاد
                        foreach ($dateFormats as $format) {
                            try {
                                $birthdate = Carbon::createFromFormat($format, $row[1])->format('Y-m-d');
                                break;
                            } catch (\Exception $e) {
                                // إذا لم يكن التاريخ بهذا التنسيق، حاول التنسيق التالي
                                continue;
                            }
                        }
                        // إذا كان المستخدم موجودًا بالفعل، يمكنك تحديثه أو تنفيذ عملية أخرى هنا
                        $user_exit->update([
                            'barh-of-date'              => $birthdate,
                            'gender'              => $row[2] ?? null,
                            'socialst'              => $row[3] ?? null,
                        ]);
                    } else {
                        $state_id   = $this->getStateId($row[2]);
                        $region_id  = $this->getRegionId($row[3]);
                        // $birthdate = isset($row[7]) ? Carbon::createFromFormat('d/m/Y', $row[7])->format('Y-m-d') : null;

                        // محاولة تحليل تاريخ الميلاد باستخدام تنسيقات متعددة
                        // $birthdate = null;
                        // $dateFormats = ['d/m/Y', 'Y-m-d', 'Y/m/d']; // تنسيقات متعددة لتواريخ الميلاد
                        // foreach ($dateFormats as $format) {
                        //     try {
                        //         $birthdate = Carbon::createFromFormat($format, $row[7])->format('Y-m-d');
                        //         break;
                        //     } catch (\Exception $e) {
                        //         // إذا لم يكن التاريخ بهذا التنسيق، حاول التنسيق التالي
                        //         continue;
                        //     }
                        // }

                        // إنشاء مستخدم جديد إذا لم يكن موجودًا
                        // $user = User::create([
                        //     'id-number'         => $row[0],
                        //     'name'              => $row[1] ?? null,
                        //     // 'phone'             => $row[2] ?? null,
                        //     'state_id'          => $state_id,
                        //     'region_id'         => $region_id,
                        //     'count_childern'    => $row['5'] ?? null,

                        //     'name-wife'        =>$row['6'] ?? null,
                        //     'id-number-wife'        =>$row['7'] ?? null,

                        //     'name-wife2'        =>$row['8'] ?? null,
                        //     'id-number-wife2'        =>$row['9'] ?? null,

                        //     'name-wife3'        =>$row['10'] ?? null,
                        //     'id-number-wife3'        =>$row['11'] ?? null,

                        //     'name-wife4'        =>$row['12'] ?? null,
                        //     'id-number-wife4'        =>$row['13'] ?? null,

                        //     // 'barh-of-date'      => $birthdate,
                        //     // 'socialst'          => $row['8'] ?? null,
                        //     // 'notes'             => $row['9'] ?? null,
                        // ]);
                    }
                }
                return redirect()->back()->with('success', 'Data imported successfully!');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error processing the file: ' . $e->getMessage());
            }
        }

        return redirect()->back()->with('error', 'No file uploaded');
    }

    public function ExportEcel(Request $request)
    {
        $users = User::Filter($request->query())->get();
        // return response()->json($users);

        $spreadsheet = new Spreadsheet();

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
        $spreadsheet->getActiveSheet()->fromArray($headerRow, null, 'A1');

        // Add data rows
        $dataRows = [];
        foreach ($users as $user) {
            $city = $user->state ? $user->state->pluck('name')->implode(', ') : '';
            $region = $user->region ? $user->region->pluck('name')->implode(', ') : '';
            $mosque = $user->mosque ? $user->mosque->pluck('name')->implode(', ') : '';

            $dataRow = [$user->{'id-number'}, $user->name, $user->{'barh-of-date'}, $user->count_childern, $user->phone, $user->phone2, $city, $region, $mosque, $user->gender, $user->socialst];
            $dataRows[] = $dataRow;
        }
        $spreadsheet->getActiveSheet()->fromArray($dataRows, null, 'A2');

        $writer = new Xlsx($spreadsheet);
        $fileName = time() . rand(1, 500) . '.xlsx';
        $writer->save($fileName);

        return redirect(url('/') . '/' . $fileName);
    }
}
