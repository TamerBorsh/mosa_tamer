<?php

namespace App\Jobs\User;

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

            // تحديد حجم الجزء
            $chunkSize = 5000; // يمكنك تعديل الحجم وفقًا لحاجتك
            $chunks = array_chunk($data, $chunkSize);

            // جلب جميع المعرّفات الموجودة مسبقًا
            $userIds = array_column($data, '0');
            $existingUsers = User::whereIn('id-number', $userIds)->pluck('id-number')->toArray();

            foreach ($chunks as $chunkIndex => $chunk) {
                foreach ($chunk as $index => $row) {
                    // تجاوز صف الهيدر
                    if ($index == 0 && $chunk === reset($chunks)) {
                        continue;
                    }

                    // Check if the row contains the expected columns
                    $birthdate = isset($row['7']) ? $this->parseDate($row['7']) : null;

                    // Check if the user exists
                    $userId = $row['0'] ?? null;

                    // Prepare user data
                    $userData = $this->prepareUserData($row, $birthdate);

                    if (in_array($userId, $existingUsers)) {
                        // Update existing user
                        $filteredData = array_filter($userData, fn($value) => $value !== null);
                        User::where('id-number', $userId)->update($filteredData);
                    } else {
                        // Create a new user if not exists
                        User::create($userData);
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


    private function prepareUserData($row, $birthdate)
    {
        return [
            'id-number' => $row['0'] ?? null,
            'name' => $row['1'] ?? null,
            'state_id' => $this->getStateId($row['2'] ?? null),
            'region_id' => $this->getRegionId($row['3'] ?? null),
            'phone' => $row['4'] ?? null,
            'phone2' => $row['5'] ?? null,
            'count_childern' => $row['6'] ?? null,
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
            'created_at'    => now(),
            'updated_at'    => now(),

        ];
    }

    // Analyze date from multiple formats
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
    private function getRegionId($name)
    {
        if (empty($name)) {
            return null; // Return null if the name is empty
        }

        // Search for the region by name
        $region = Region::where('name', $name)->first();

        // Return the ID if the region exists
        if ($region) {
            return $region->id;
        } else {
            // Create a new region and return its ID
            $newRegion = Region::create(['name' => $name]);
            return $newRegion->id;
        }
    }

    private function getStateId($name)
    {
        if (empty($name)) {
            return null; // Return null if the name is empty
        }

        // Search for the state by name
        $state = State::where('name', $name)->first();

        if ($state) {
            return $state->id;
        } else {
            $newState = State::create(['name' => $name]);
            return $newState->id;
        }
    }
}
