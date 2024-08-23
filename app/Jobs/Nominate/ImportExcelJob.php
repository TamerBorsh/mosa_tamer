<?php

namespace App\Jobs\Nominate;

use App\Models\Coupon;
use App\Models\Institution;
use App\Models\Location;
use App\Models\Log;
use App\Models\Nominate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filePath;
    protected $adminId;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
        $this->adminId = Auth::id();
    }

    /**
     * Execute the job.
     */
    // public function handle(): void
    // {
    //     try {
    //         // تحميل الملف باستخدام PhpSpreadsheet
    //         $spreadsheet = IOFactory::load($this->filePath);
    //         $sheet = $spreadsheet->getActiveSheet();
    //         $data = $sheet->toArray();

    //         $batchSize = 500; // حجم الدفعة
    //         $batchData = [];

    //         // الآن لديك البيانات في مصفوفة $data، يمكنك معالجتها كما تريد
    //         foreach ($data as $index => $row) {
    //             // تجاوز صف الهيدر
    //             if ($index == 0) {
    //                 continue;
    //             }

    //             $user = User::where('id-number', $row[0])->first();

    //             if ($user) {
    //                 $institutionName = $row[6]; // Assuming institution name is in column 7 (index 6)
    //                 $locationName = $row[5]; // Assuming location name is in column 6 (index 5)

    //                 $batchData[] = $this->prepareUserData($row, $user->id, $locationName, $institutionName);

    //                 // إذا وصلت الدفعة إلى الحجم المحدد، أدخل البيانات إلى قاعدة البيانات
    //                 if (count($batchData) >= $batchSize) {
    //                     Nominate::insert($batchData);
    //                     $batchData = []; // إفراغ الدفعة
    //                 }
    //             } else {
    //                 // تسجيل خطأ إذا لم يتم العثور على المستخدم
    //                 Log::create([
    //                     'level' => 'error',
    //                     'message' => 'User not found for id-number: ' . $row[0],
    //                     'context' => json_encode([
    //                         'file_path' => $this->filePath,
    //                         'row' => $row,
    //                     ]),
    //                 ]);
    //             }
    //         }

    //         // إدخال أي بيانات متبقية في الدفعة الأخيرة
    //         if (!empty($batchData)) {
    //             Nominate::insert($batchData);
    //         }
    //     } catch (\Exception $e) {
    //         Log::create([
    //             'level' => 'error',
    //             'message' => 'Error processing the file: ' . $e->getMessage(),
    //             'context' => json_encode([
    //                 'file_path' => $this->filePath,
    //                 'line' => $e->getLine(),
    //                 'file' => $e->getFile(),
    //             ]),
    //         ]);
    //     }
    // }

    public function handle(): void
    {
        try {
            // تحميل الملف باستخدام PhpSpreadsheet
            $spreadsheet = IOFactory::load($this->filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // تحديد حجم الجزء
            $chunkSize = 5000; // يمكنك تعديل الحجم وفقًا لحاجتك
            $chunks = array_chunk($data, $chunkSize);

            foreach ($chunks as $chunkIndex => $chunk) {
                foreach ($chunk as $index => $row) {
                    // تجاوز صف الهيدر
                    if ($index == 0 && $chunk === reset($chunks)) {
                        continue;
                    }

                    if ($row[2] != null) {
                        $user = User::where('id-number', $row[0])->first();

                        if ($user) {
                            $institutionName = $row[6]; // Assuming institution name is in column 7 (index 6)
                            $locationName = $row[5]; // Assuming location name is in column 6 (index 5)

                            $userData = $this->prepareUserData($row, $user->id, $locationName, $institutionName);

                            // إنشاء سجل باستخدام create بدلاً من insert
                            Nominate::create($userData);
                        } else {
                            // تسجيل خطأ إذا لم يتم العثور على المستخدم
                            Log::create([
                                'level' => 'error',
                                'message' => 'User not found for id-number: ' . $row[0],
                                'context' => json_encode([
                                    'file_path' => $this->filePath,
                                    'row' => $row,
                                ]),
                            ]);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::create([
                'level' => 'error',
                'message' => 'Error processing the file: ' . $e->getMessage(),
                'context' => json_encode([
                    'file_path' => $this->filePath,
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                ]),
            ]);
        }
    }


    private function prepareUserData($row, $userId, $locationName, $institutionName)
    {
        $couponId = $this->getCouponId($row[1], $locationName, $institutionName);

        return [
            'coupon_id'     => $couponId,
            'user_id'       => $userId,
            'admin_id'      => $this->adminId,
            'recive_date'   => $this->parseDate($row[2]),
            'redirect_date' => $this->parseDate($row[3]),
            'is_recive'     => $row[4],
        ];
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

    private function getCouponId($name, $locationName, $institutionName)
    {
        if (empty($name)) {
            return null;
        }

        $coupon = Coupon::where('name', $name)->first();

        $locationId = $this->getLocationId($locationName);
        $institutionId = $this->getInstitutionId($institutionName);

        if ($coupon) {
            $updateData = [];
            if ($locationId !== null && $coupon->location_id != $locationId) {
                $updateData['location_id'] = $locationId;
            }
            if ($institutionId !== null && $coupon->institution_id != $institutionId) {
                $updateData['institution_id'] = $institutionId;
            }
            if (!empty($updateData)) {
                $coupon->update($updateData);
            }

            return $coupon->id;
        } else {
            if ($locationId === null) {
                throw new \Exception('Location name is required to create a new coupon.');
            }

            if ($institutionId === null) {
                throw new \Exception('Institution name is required to create a new coupon.');
            }

            $newCoupon = Coupon::create([
                'institution_id' => $institutionId,
                'location_id' => $locationId,
                'admin_id' => $this->adminId,
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
