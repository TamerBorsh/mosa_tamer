<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class AppHelpers
{
    public static function guardName()
    {
        return Auth::guard('admin')->check() ? 'admin' : 'web';
    }

    public static function defaultLangForUser()
    {
        return Auth::user()->locale ? Auth::user()->locale : config('app.locale');
    }

    public static function UploadFile($photo, $folder)
    {
        $file = $photo;
        $fileName = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path($folder), $fileName);

        return $fileName;
    }
}



define('PAGEINATION_COUNT', 1);
