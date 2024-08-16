<?php

namespace App\Http\Controllers\User;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Location;
use App\Models\Mosque;
use App\Models\Nominate;
use App\Models\Region;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $datatable)
    {
        return $datatable->render('dash.users.index', [
            'states' => State::get(['id', 'name']),
            'regions' => Region::get(['id', 'name']),
            'mosques' => Mosque::get(['id', 'name']),
            'locations' => Location::get(['id', 'name']),
            'coupons' => Coupon::get(['id', 'name'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = State::get(['id', 'name']);
        $regions = Region::get(['id', 'name']);
        $mosques = Mosque::get(['id', 'name']);
        return response()->view('dash.users.create', ['states' => $states, 'regions' => $regions, 'mosques' => $mosques]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $isSave = User::create($request->all());
        if ($isSave)
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $isDelete = $user->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    // Show details of the user in DataTable
    public function detalies($id)
    {
        $user = User::findOrFail($id);

        // استرجاع استلامات الزوج باستخدام user_id
        $userReceives = Nominate::where('user_id', $id)->with('coupon.location')->get();

        // استرجاع استلامات الزوجة إذا كانت موجودة
        $wifeReceives = collect();
        if ($user->{'id-number-wife'}) {
            $wifeId = User::where('id-number-wife', $user->{'id-number'})->pluck('id')->first();
            if ($wifeId) {
                $wifeReceives = Nominate::where('user_id', $wifeId)->with('coupon.location')->get();
            }
        }

        // دمج الاستلامات في مجموعة واحدة
        $data = $userReceives->concat($wifeReceives);

        // إرجاع البيانات بصيغة DataTable
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('location_id', function ($row) {
                return $row->coupon->location ? $row->coupon->location->name : '';
            })
            ->editColumn('is_recive', function ($row) {
                return $row->recive;
            })
            ->rawColumns(['is_recive']) // تأكد من أن 'action' ليس مذكورًا إذا لم يكن لديك عمود action
            ->make(true);
    }
}
