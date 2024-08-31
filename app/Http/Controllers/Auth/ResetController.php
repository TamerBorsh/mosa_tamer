<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ResetController extends Controller
{
    public function index(): Response
    {
        return response()->view('auth.forget');
    }

    public function isFound(ResetPassword $request)
    {
        // افترض أن العمود في قاعدة البيانات هو 'id_number'
        $user = User::where('id-number', $request->input('id-number'))->first();
        if (!$user) {
            return redirect()->back()->with('error', 'المستفيد غير مسجل ضمن أسماء المستفيدين');
        }

        $userBirthYear = Carbon::parse($user->{'barh-of-date'})->year;
        $inputBirthYear = Carbon::parse($request->input('barh-of-date'))->year;

        if ($userBirthYear !== $inputBirthYear) {
            return redirect()->back()->with('error', 'سنة ميلادك غير صحيحة');
        }
        if (!is_null($user->{'id-number-wife'})) {
            if ($user->{'id-number-wife'} !== $request->input('id-number-wife')) {
                return redirect()->back()->with('error', 'رقم هوية الزوجة غير صحيح');
            }
        }
        $user->password = $request->input('password');
        $user->save();

        return redirect()->back()->with('success', 'تم تحديث كلمة السر بنجاح');

    }

}
