<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [[
            'name'      => 'التفاح الشرقي',
            'state_id'  => '4'
        ], [
            'name' => 'التفاح الغربي',
            'state_id'  => '4'
        ], [
            'name' => 'الدرج الشرقي',
            'state_id'  => '4'
        ], [
            'name' => 'الدرج الغربية',
            'state_id'  => '4'
        ], [
            'name' => 'الرمال الشمالي',
            'state_id'  => '4'
        ], [
            'name' => 'الشاطئ الجنوبي',
            'state_id'  => '4'
        ], [
            'name' => 'الشاطئ الشمالي والنصر',
            'state_id'  => '4'
        ], [
            'name' => 'الشجاعية',
            'state_id'  => '4'
        ], [
            'name' => 'الشيخ رضوان',
            'state_id'  => '4'
        ], [
            'name' => 'بيت حانون',
            'state_id'  => '3'
        ], [
            'name' => 'بيت لاهيا',
            'state_id'  => '3'
        ], [
            'name' => 'تل الهوا',
            'state_id'  => '4'
        ], [
            'name' => 'جباليا النزلة',
            'state_id'  => '3'
        ], [
            'name' => 'جنوب الصبرة',
            'state_id'  => '4'
        ], [
            'name' => 'شرق الزيتون',
            'state_id'  => '4'
        ], [
            'name' => 'شرق المعسكر',
            'state_id'  => '3'
        ], [
            'name' => 'شرق جباليا',
            'state_id'  => '3'
        ], [
            'name' => 'شمال الصبرة',
            'state_id'  => '4'
        ], [
            'name' => 'غرب الزيتون',
            'state_id'  => '4'
        ], [
            'name' => 'غرب المعسكر',
            'state_id'  => '3'
        ], [
            'name' => 'غرب جباليا',
            'state_id'  => '3'
        ], [
            'name' => 'مشروع عامر',
            'state_id'  => '4'
        ], [
            'name' => 'وسط الزيتون',
            'state_id'  => '4'
        ], [
            'name' => 'وسط المعسكر',
            'state_id'  => '3'
        ]];
        foreach ($data as $item) {
            Region::create($item);
        }
    }
}
