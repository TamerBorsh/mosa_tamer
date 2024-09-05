<?php

namespace App\Http\Controllers\Coupon;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Institution;
use App\Models\Location;
use App\Models\Nominate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CouponDataTable $datatable)
    {
        $locations = Location::get(['id', 'name']);
        $institutions = Institution::where('is_support', '0')->get(['id', 'name']);
        $institutionSupport = Institution::where('is_support', '1')->get(['id', 'name']);
        
        return $datatable->render('dash.coupons.index', [
            'locations'             => $locations,
            'institutions'          => $institutions,
            'institutionSupport'    => $institutionSupport
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['admin_id' => Auth::id()]);
        $isSave = Coupon::create($request->all());
        if ($isSave)
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return $coupon;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $coupon = Coupon::find($request->id);
        $isSave = $coupon->update($request->all());
        if ($isSave)
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $isDelete = $coupon->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    // public function checkQuantity(Request $request)
    // {
    //     $userIdCount = count($request->input('selectedIds'));
    //     // الحصول على معلومات الكوبونات المحددة
    //     $availableQuantity = Coupon::whereId($request->input('coupon_id'))->first();
    //     $quantity = $availableQuantity->quantity;

    //     $nominates = Nominate::where('coupon_id', $request->input('coupon_id'))->where('is_recive', '!=', '4')->count();

    //     if ($userIdCount <= $quantity && $nominates <= $userIdCount) {
    //         return response()->json([
    //             'success' => true,
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'الكمية المطلوبة تتجاوز الكمية المتاحة.'
    //         ]);
    //     }
    // }
    public function checkQuantity(Request $request)
    {
        // التحقق من صحة المدخلات
        $request->validate([
            'selectedIds'   => 'required|array',
            'coupon_id'     => 'required|integer|exists:coupons,id',
        ]);

        $userIdCount = count($request->input('selectedIds'));

        // الحصول على معلومات القسيمة بناءً على المعرف
        $availableQuantity = Coupon::find($request->input('coupon_id'));

        // التحقق من وجود القسيمة
        if (!$availableQuantity) {
            return response()->json([
                'success' => false,
                'message' => 'الكوبون غير موجود.'
            ]);
        }

        $quantity = $availableQuantity->quantity;

        // حساب عدد الترشيحات للقسيمة مستثنيًا أولئك الذين لديهم 'is_recive' = '4'
        $nominates = Nominate::where('coupon_id', $request->input('coupon_id'))
            ->where('is_recive', '!=', '4')
            ->count();
        // return $quantity - $nominates;

        // التحقق من أن عدد المستخدمين المحددين أقل من أو يساوي الكمية المتاحة وأن عدد الترشيحات أقل من أو يساوي عدد المستخدمين المحددين
        if ($userIdCount <= ($quantity - $nominates)) {
            return response()->json([
                'success' => true,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'الكمية المطلوبة تتجاوز الكمية المتاحة.'
            ]);
        }
    }
}
