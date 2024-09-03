<?php

namespace App\Http\Controllers\Nominate;

use App\DataTables\NominateDataTable;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Location;
use App\Models\Mosque;
use App\Models\Nominate;
use App\Models\Region;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NominateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(NominateDataTable $datatable)
    {
        return $datatable->render('dash.nominates.index', [
            'states' => State::get(['id', 'name']),
            'regions' => Region::get(['id', 'name']),
            'mosques' => Mosque::get(['id', 'name']),
            'locations' => Location::get(['id', 'name'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function couponRedemption()
    {
        return response()->view('dash.nominates.coupon_redemption');
    }

    public function search(Request $request)
    {
        $number = $request->input('number');

        // البحث في نموذج Nominate مع تحميل بيانات المستخدم
        $results = Nominate::with(['user:id,id-number,name,phone,barh-of-date']) // تحديث اسم العمود هنا
            ->whereIn('is_recive', [1, 2]) // الشرط الأساسي: إما 1 أو 2
            ->where(function ($query) use ($number) {
                $query->where('number_copon', $number)
                    ->orWhereHas('user', function ($query) use ($number) {
                        $query->where('id-number', $number);
                    });
            })
            ->get();

        // التحقق من وجود نتائج
        if ($results->isEmpty()) {
            return response()->json(['message' => 'لا توجد نتائج مطابقة'], 404);
        }

        return response()->json($results);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // للحصول على البيانات من الطلب
        $ids = $request->input('selectedIds');
        $recive_date = $request->input('recive_date');
        $redirect_date = $request->input('redirect_date');
        $coupon_id = $request->input('coupon_id');

        if ($ids && is_array($ids)) {
            foreach ($ids as $item) {
                Nominate::create([
                    'coupon_id'     => $coupon_id,
                    'user_id'       => $item, // استخدام ID مباشرة هنا
                    'admin_id'      => Auth::id(),
                    'recive_date'   => $recive_date,
                    'redirect_date' => $redirect_date,
                    'is_recive'     => '1',
                ]);
            }
            return response()->json(['message' => 'تم ترشيح الأسماء بنجاح'], Response::HTTP_OK);
        }
        return response()->json(['message' => 'لم يتم اختيار أي مستفيد'], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(Nominate $nominate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nominate $nominate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nominate $nominate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nominate $nominate)
    {
        $isDelete = $nominate->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
    public function refreshStatus(Request $request)
    {
        $ids = $request->input('selectedIds');
        $isRecive = $request->input('is_recive');

        // التحقق من أن $ids هو مصفوفة غير فارغة
        if (!empty($ids) && is_array($ids) && !is_null($isRecive)) {
            foreach ($ids as $item) {
                if (is_numeric($item)) {
                    $nominate = Nominate::find($item);
                    if ($nominate) {
                        $nominate->update([
                            'is_recive' => $isRecive,
                        ]);
                    }
                }
            }
            return response()->json(['message' => 'تم تحديث الحالة بنجاح'], Response::HTTP_OK);
        }

        return response()->json(['message' => 'لم يتم اختيار أي مرشحين أو القيمة غير صحيحة'], Response::HTTP_BAD_REQUEST);
    }
}
