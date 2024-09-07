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
    public $timeout = 3600; // 1 ساعة بالثواني

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

                    // التأكد من أن الحقول الضرورية تحتوي على بيانات
                    if (empty($row[1]) || empty($row[5]) || empty($row[6])) {
                        // تسجيل رسالة خطأ إذا كانت البيانات غير مكتملة
                        Log::create([
                            'level' => 'error',
                            'message' => 'Incomplete data: Coupon name, location name, or institution name is missing.',
                            'context' => json_encode([
                                'file_path' => $this->filePath,
                                'row' => $row,
                            ]),
                        ]);
                        continue; // الانتقال إلى الصف التالي
                    }

                    if (!empty($row[2])) {
                        $user = User::where('id-number', $row[0])->first();

                        if ($user) {
                            $institutionName = $row[6];
                            $locationName = $row[5];
                            $couponName = $row[1];
                            $receiveDate = $this->parseDate($row[2]);
                            $redirectDate = $this->parseDate($row[3]);

                            $couponId = $this->getCouponId($couponName, $locationName, $institutionName);

                            $userData = [
                                'coupon_id'     => $couponId,
                                'user_id'       => $user->id,
                                'admin_id'      => $this->adminId,
                                'recive_date'   => $receiveDate,
                                'redirect_date' => $redirectDate,
                                'is_recive'     => $row[4],
                            ];

                            // تحقق من وجود سجل الترشيح
                            $nominate = Nominate::where('user_id', $user->id)
                                ->where('coupon_id', $couponId)
                                ->where('recive_date', $receiveDate)
                                ->first();

                            if ($nominate) {
                                // تحديث السجل الموجود
                                $nominate->update($userData);
                            } else {
                                // إنشاء سجل جديد إذا لم يكن موجودًا
                                Nominate::create($userData);
                            }
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
        // النمط الذي يحتوي على تاريخ ووقت (صباحاً/مساءً/ظهراً مع "الساعة" أو "س")
        $patternWithTime = '/\w+\s(\d{1,2}\/\d{1,2}\/\d{4})\s(?:الساعة|س)\s(\d{1,2})\s(صباحاً|مساءً|ظهراً)/u';
        if (preg_match($patternWithTime, $dateString, $matches)) {
            $datePart = $matches[1]; // التاريخ
            $timePart = $matches[2]; // الساعة
            $period = $matches[3];   // الفترة (صباحاً/مساءً/ظهراً)

            // تحويل الوقت إلى صيغة 24 ساعة
            if ($period === 'مساءً' && $timePart < 12) {
                $timePart += 12;
            } elseif ($period === 'ظهراً' && $timePart < 12) {
                $timePart += 12;
            } elseif ($period === 'صباحاً' && $timePart == 12) {
                $timePart = 0;
            }

            // دمج التاريخ والوقت
            $dateTimeString = $datePart . ' ' . $timePart . ':00:00';

            // استخدام Carbon لتحليل التاريخ والوقت
            return Carbon::createFromFormat('d/m/Y H:i:s', $dateTimeString)->format('Y-m-d H:i:s');
        }

        // النمط الذي يحتوي على تاريخ فقط
        $patternWithDateOnly = '/\w+\s(\d{1,2}\/\d{1,2}\/\d{4})/u';
        if (preg_match($patternWithDateOnly, $dateString, $matches)) {
            $datePart = $matches[1]; // التاريخ

            // استخدام Carbon لتحليل التاريخ
            return Carbon::createFromFormat('d/m/Y', $datePart)->format('Y-m-d');
        }

        // التعامل مع الأنماط الأخرى المحتملة
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
        if (empty($name) || empty($locationName) || empty($institutionName)) {
            return null;
        }

        $locationId = $this->getLocationId($locationName);
        $institutionId = $this->getInstitutionId($institutionName);

        // البحث عن الكوبون بناءً على الاسم
        $coupon = Coupon::where('name', $name)
            ->where('location_id', $locationId)
            ->where('institution_id', $institutionId)
            ->first();

        if ($coupon) {
            return $coupon->id;
        } else {
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
