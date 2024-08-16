<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\AppHelpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __construct()
    {
        // return $this->middleware('guest')->except('logout');
    }

    public function login(Request $request, $guard)
    {
        return Auth::guard($guard)->check() ? to_route('dash.index') : response()->view('auth.login', ['guard' => $guard]);
    }

    public function authenticate(LoginRequest $request)
    {
        // الحصول على بيانات المدخلات
        $loginField = $request->input('login_type');
        $password = $request->input('password');
        $guard = $request->input('guard');
        $rememberMe = $request->boolean('remember_me'); // تحويل القيمة إلى Boolean بشكل مباشر


        // Determine the login field based on the input
        // if (filter_var($loginField, FILTER_VALIDATE_EMAIL)) {
        //     $loginType = 'email';
        // } elseif (ctype_digit($loginField)) {
        //     $loginType = 'phone';
        // } else {
        //     $loginType = 'username';
        // }
        // تحديد نوع تسجيل الدخول بناءً على المدخلات
        $loginType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : (ctype_digit($loginField) ? 'phone' : 'username');
        // return $loginType;

        // التحقق من صحة الـ guard
        if (!in_array($guard, ['admin'])) {
            return response()->json(['message' => __('Guard غير صحيح.')], Response::HTTP_BAD_REQUEST);
        }

        // Construct the credentials array for authentication
        $credentials = [
            $loginType => $loginField,
            'password' => $request->post('password')
        ];
        // محاولة التوثيق وتجديد الجلسة إذا نجحت
        if (Auth::guard($guard)->attempt($credentials, $rememberMe)) {
            $request->session()->regenerate();
            return response()->json(['message' => __('تم تسجيل الدخول بنجاح.')], Response::HTTP_OK);
        }

        // إرجاع رسالة خطأ إذا فشل التوثيق
        return response()->json(['message' => __('البيانات المدخلة غير صحيحة.')], Response::HTTP_BAD_REQUEST);
    

        // return Auth::guard($request->post('guard'))->attempt($credentials, $request->input('remember_me')) ? $request->session()->regenerate() : response()->json(['message' => __('The data entered is incorrect')], Response::HTTP_BAD_REQUEST);
    }
    public function authenticate33(LoginRequest $request)
    {
        // الحصول على بيانات المدخلات
        $loginField = $request->input('login_type');
        $password = $request->input('password');
        $guard = $request->input('guard');
        $rememberMe = $request->boolean('remember_me'); // تحويل القيمة إلى Boolean بشكل مباشر

        // تحديد نوع تسجيل الدخول بناءً على المدخلات
        $loginType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : (ctype_digit($loginField) ? 'phone' : 'username');

        // إنشاء مصفوفة بيانات الاعتماد للتوثيق
        $credentials = [
            $loginType => $loginField,
            'password' => $password,
        ];

        // التحقق من صحة الـ guard
        if (!in_array($guard, ['api', 'web'])) {
            return response()->json(['message' => __('Guard غير صحيح.')], Response::HTTP_BAD_REQUEST);
        }

        // محاولة التوثيق وتجديد الجلسة إذا نجحت
        if (Auth::guard($guard)->attempt($credentials, $rememberMe)) {
            $request->session()->regenerate();
            return response()->json(['message' => __('تم تسجيل الدخول بنجاح.')], Response::HTTP_OK);
        }

        // إرجاع رسالة خطأ إذا فشل التوثيق
        return response()->json(['message' => __('البيانات المدخلة غير صحيحة.')], Response::HTTP_BAD_REQUEST);
    
    }


    public function logout(Request $request)
    {
        $guard = AppHelpers::guardName();
        Auth::guard($guard)->logout();
        $request->session()->invalidate();
        return to_route('login', $guard);
    }
}
