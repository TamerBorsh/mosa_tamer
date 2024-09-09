<?php

namespace App\Http\Controllers\User;

use App\DataTables\ProblemDataTable;
use App\Http\Controllers\Controller;
use App\Models\Nominate;
use App\Models\Problem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserProfileController extends Controller
{
    public function updatePhone(Request $request)
    {
        $isSave = Auth::user()->update(['phone' => $request->input('phone')]);
        if ($isSave)
            return response()->json(['message' => $isSave ? 'تم تحديث البيانات بنجاح' : 'هناك خطأ ما'], $isSave ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function detalies()
    {
        $user = Auth::user()->id;

        // استرجاع استلامات الزوج باستخدام user_id
        $userReceives = Nominate::where('user_id', $user)->with('coupon.location')->get();

        // استرجاع استلامات الزوجة إذا كانت موجودة
        // $wifeReceives = collect();
        // if ($user->{'id-number-wife'}) {
        //     $wifeId = User::where('id-number-wife', $user->{'id-number'})->pluck('id')->first();
        //     if ($wifeId) {
        //         $wifeReceives = Nominate::where('user_id', $wifeId)->with('coupon.location')->get();
        //     }
        // }

        // دمج الاستلامات في مجموعة واحدة
        // $data = $userReceives->concat($wifeReceives);

        // إرجاع البيانات بصيغة DataTable
        return DataTables::of($userReceives)
            ->addIndexColumn()
            ->addColumn('location_id', function ($row) {
                return $row->coupon->location ? $row->coupon->location->name : '';
            })
            ->editColumn('is_recive', function ($row) {
                return $row->recive;
            })
            ->addColumn('type', function ($row) {
                return $row->coupon->CouponType;
            })
            ->rawColumns(['is_recive']) // تأكد من أن 'action' ليس مذكورًا إذا لم يكن لديك عمود action
            ->make(true);
    }

    public function problem(ProblemDataTable $datatable)
    {
        return Auth::guard('admin')->check() ? $datatable->render('dash.users.user.reply') : $datatable->render('dash.users.user.problem');
    }

    public function store(Request $request)
    {
        $request->merge([
            'user_id' => Auth::id(),
        ]);
        $isSave = Problem::create($request->all());
        if ($isSave)
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    public function show($id)
    {
        return response()->view('dash.users.user.show', ['problem' => Problem::where('user_id', Auth::id())->whereId($id)->first()]);
    }
}
