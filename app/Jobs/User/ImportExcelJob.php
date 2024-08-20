<?php

namespace App\Jobs\User;

use App\Models\Location;
use App\Models\Region;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportExcelJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    /**
     * Create a new job instance.
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // تحميل الملف باستخدام PhpSpreadsheet
            $spreadsheet = IOFactory::load($this->filePath);
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

                // محاولة تحليل تاريخ الميلاد باستخدام تنسيقات متعددة
                $birthdate = $this->parseDate($row[5]);

                // التحقق من وجود المستخدم
                $user = User::where('id-number', $row[0])->first();

                if ($user) {
                    // تحديث المستخدم إذا كان موجودًا
                    $user->update($this->prepareUserData($row, $birthdate));
                } else {
                    // إضافة المستخدم الجديد إلى الدفعة
                    $batchData[] = $this->prepareUserData($row, $birthdate);

                    // إذا وصلت الدفعة إلى الحجم المحدد، أدخل البيانات إلى قاعدة البيانات
                    if (count($batchData) >= $batchSize) {
                        User::insert($batchData);
                        $batchData = []; // إفراغ الدفعة
                    }
                }
            }

            // إدخال أي بيانات متبقية في الدفعة الأخيرة
            if (!empty($batchData)) {
                User::insert($batchData);
            }

            // return redirect()->back()->with('success', 'Data imported successfully!');
        } catch (\Exception $e) {
            \Log::error('Error processing the file: ' . $e->getMessage());
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

    private function prepareUserData($row, $birthdate)
    {
        return [
            'id-number' => $row[0],
            'name' => $row[1] ?? null,
            'state_id' =>  $this->getStateId($row[2]),
            'region_id' => $this->getRegionId($row[3]),
            'count_childern' => $row[4] ?? null,
            'name-wife' => $row[6] ?? null,
            'id-number-wife' => $row[7] ?? null,
            'name-wife2' => $row[8] ?? null,
            'id-number-wife2' => $row[9] ?? null,
            'name-wife3' => $row[10] ?? null,
            'id-number-wife3' => $row[11] ?? null,
            'name-wife4' => $row[12] ?? null,
            'id-number-wife4' => $row[13] ?? null,
            'barh-of-date' => $birthdate,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    private function getlocationId($name)
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

    private function getRegionId($name)
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

    private function getStateId($name)
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
}
