<?php

namespace App\Jobs\User;

use App\Models\Location;
use App\Models\Log;
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

            foreach ($data as $index => $row) {
                // تجاوز صف الهيدر
                if ($index == 0) {
                    continue;
                }

                // محاولة تحليل تاريخ الميلاد باستخدام تنسيقات متعددة
                $birthdate = $this->parseDate($row['7']);

                // التحقق من وجود المستخدم
                $user = User::where('id-number', $row[0])->first();

                $userData = $this->prepareUserData($row, $birthdate);

                if ($user) {
                    // تحديث المستخدم إذا كان موجودًا
                    $user->update($userData);
                } else {
                    // إنشاء مستخدم جديد إذا لم يكن موجودًا
                    User::create($userData);
                }
            }
        } catch (\Exception $e) {
            Log::create([
                'level' => 'error',
                'message' => $e->getMessage(),
                'context' => json_encode([
                    'file_path' => $this->filePath,
                    'row' => $row,
                ]),
            ]);
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
            'id-number' => $row['0'],
            'name' => $row['1'] ?? null,
            'state_id' =>  $this->getStateId($row['2']),
            'region_id' => $this->getRegionId($row['3']),
            'phone' => $this->getRegionId($row['4']),
            'phone2' => $this->getRegionId($row['5']),
            'count_childern' => $row[6] ?? null,
            'barh-of-date' => $birthdate,
            'gender' => $row['8'] ?? null,
            'socialst' => $row['9'] ?? null,
            'name-wife' => $row['10'] ?? null,
            'id-number-wife' => $row['11'] ?? null,
            'name-wife2' => $row['12'] ?? null,
            'id-number-wife2' => $row['13'] ?? null,
            'name-wife3' => $row['14'] ?? null,
            'id-number-wife3' => $row['15'] ?? null,
            'name-wife4' => $row['16'] ?? null,
            'id-number-wife4' => $row['17'] ?? null,
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
