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
            // Load the spreadsheet using PhpSpreadsheet
            $spreadsheet = IOFactory::load($this->filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // Define the chunk size
            $chunkSize = 5000; // Adjust the chunk size as needed
            $chunks = array_chunk($data, $chunkSize);

            foreach ($chunks as $chunk) {
                foreach ($chunk as $index => $row) {
                    // Skip the header row
                    if ($index == 0 && $chunk === reset($chunks)) {
                        continue;
                    }

                    // Attempt to parse the birth date with multiple formats
                    $birthdate = $this->parseDate($row['7']);

                    // Check if the user exists
                    $user = User::where('id-number', $row[0])->first();

                    $userData = $this->prepareUserData($row, $birthdate);

                    if ($user) {
                        // Filter out null values from the update
                        $filteredData = array_filter($userData, function ($value) {
                            return $value !== null;
                        });

                        $user->update($filteredData);
                    } else {
                        // Create a new user if not exists
                        User::create($userData);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::create([
                'level' => 'error',
                'message' => $e->getMessage(),
                'context' => json_encode([
                    'file_path' => $this->filePath,
                    'row' => isset($row) ? $row : null,
                ]),
            ]);
        }
    }

    private function prepareUserData($row, $birthdate)
    {
        return [
            'id-number' => $row['0'],
            'name' => $row['1'] !== '' ? $row['1'] : null,
            'state_id' =>  $this->getStateId($row['2']),
            'region_id' => $this->getRegionId($row['3']),
            'phone' => $row['4'] !== '' ? $row['4'] : null,
            'phone2' => $row['5'] !== '' ? $row['5'] : null,
            'count_childern' => $row['6'] !== '' ? $row['6'] : null,
            'barh-of-date' => $birthdate,
            'gender' => $row['8'] !== '' ? $row['8'] : null,
            'socialst' => $row['9'] !== '' ? $row['9'] : null,
            'name-wife' => $row['10'] !== '' ? $row['10'] : null,
            'id-number-wife' => $row['11'] !== '' ? $row['11'] : null,
            'name-wife2' => $row['12'] !== '' ? $row['12'] : null,
            'id-number-wife2' => $row['13'] !== '' ? $row['13'] : null,
            'name-wife3' => $row['14'] !== '' ? $row['14'] : null,
            'id-number-wife3' => $row['15'] !== '' ? $row['15'] : null,
            'name-wife4' => $row['16'] !== '' ? $row['16'] : null,
            'id-number-wife4' => $row['17'] !== '' ? $row['17'] : null,
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
