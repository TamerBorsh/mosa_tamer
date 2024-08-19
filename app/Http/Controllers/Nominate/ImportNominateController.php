<?php

namespace App\Http\Controllers\Nominate;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Institution;
use App\Models\Location;
use App\Models\Nominate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // التحقق من وجود الملف في الطلب
        if (!$request->hasFile('file')) {
            return redirect()->back()->with('error', 'No file uploaded');
        }

        try {
            $path = $request->file('file')->path();

            // تحميل الملف باستخدام PhpSpreadsheet
            $spreadsheet = IOFactory::load($path);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            $batchSize = 1000; // حجم الدفعة
            $batchData = [];

            // الآن لديك البيانات في مصفوفة $data، يمكنك معالجتها كما تريد
            foreach ($data as $index => $row) {
                // تجاوز صف الهيدر
                if ($index == 0) {
                    continue;
                }

                $user = User::where('id-number', $row[0])->first();

                if ($user) {
                    $institutionName = $row[6]; // Assuming institution name is in column 5 (index 4)
                    $locationName = $row[5]; // Assuming location name is in column 6 (index 5)

                    $batchData[] = $this->prepareUserData($row, $user->id, $locationName, $institutionName);

                    // إذا وصلت الدفعة إلى الحجم المحدد، أدخل البيانات إلى قاعدة البيانات
                    if (count($batchData) >= $batchSize) {
                        Nominate::insert($batchData);
                        $batchData = []; // إفراغ الدفعة
                    }
                } else {
                    return redirect()->back()->with('error', 'تأكد من وجود الأسماء بقائمة المستفيدين أولا!');
                }
            }

            // إدخال أي بيانات متبقية في الدفعة الأخيرة
            if (!empty($batchData)) {
                Nominate::insert($batchData);
            }

            return redirect()->back()->with('success', 'تم استيراد الملف بنجاح!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error processing the file: ' . $e->getMessage());
        }
    }

    // تحليل التاريخ من تنسيقات متعددة
    private function parseDate($dateString)
    {
        $dateFormats = ['d/m/Y', 'Y-m-d', 'Y/m/d'];
        foreach ($dateFormats as $format) {
            try {
                return Carbon::createFromFormat($format, $dateString)->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }
        }
        return null;
    }

    private function prepareUserData($row, $userId, $locationName, $institutionName)
    {
        $couponId = $this->getCouponId($row[1], $locationName, $institutionName);

        return [
            'coupon_id'     => $couponId,
            'user_id'       => $userId,
            'admin_id'      => Auth::id(),
            'recive_date'   => $this->parseDate($row[2]),
            'redirect_date' => $this->parseDate($row[3]),
            'is_recive'     => $row[4],
            'number_copon'  => Nominate::getNextCoponNumber(), // هنا تستدعي الدالة لإنشاء رقم القسيمة
            'created_at'    => now(),
            'updated_at'    => now(),
        ];
    }

    private function getCouponId($name, $locationName, $institutionName)
    {
        if (empty($name)) {
            return null; // إذا كان الاسم فارغًا، أعد قيمة null
        }

        $coupon = Coupon::where('name', $name)->first();

        if ($coupon) {
            return $coupon->id;
        } else {
            $locationId = $this->getLocationId($locationName);
            $institutionId = $this->getInstitutionId($institutionName);

            if (is_null($locationId)) {
                throw new \Exception('Location name is required to create a new coupon.');
            }

            if (is_null($institutionId)) {
                throw new \Exception('Institution name is required to create a new coupon.');
            }

            $newCoupon = Coupon::create([
                'institution_id' => $institutionId,
                'location_id' => $locationId,
                'admin_id' => Auth::id(),
                'name' => $name,
            ]);
            return $newCoupon->id;
        }
    }

    private function getLocationId($name)
    {
        if (empty($name)) {
            return null; // إذا كان الاسم فارغًا، أعد قيمة null
        }

        $location = Location::where('name', $name)->first();

        if ($location) {
            return $location->id;
        } else {
            $newLocation = Location::create(['name' => $name]);
            return $newLocation->id;
        }
    }

    private function getInstitutionId($name)
    {
        if (empty($name)) {
            return null; // إذا كان الاسم فارغًا، أعد قيمة null
        }

        $institution = Institution::where('name', $name)->first();

        if ($institution) {
            return $institution->id;
        } else {
            $newInstitution = Institution::create(['name' => $name]);
            return $newInstitution->id;
        }
    }
}
