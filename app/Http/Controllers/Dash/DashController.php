<?php

namespace App\Http\Controllers\Dash;

use App\Http\Controllers\Controller;
use App\Models\Nominate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DashController extends Controller
{
    use AuthorizesRequests;

    public function index(): Response
    {
        if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->hasPermissionTo('Read-Admins')) {
            // الحصول على عدد الأعضاء الإجماليين
            $usersCount = User::count();

            // الحصول على عدد الأعضاء الذين تم إنشاؤهم في الشهر الحالي
            $usersInCurrentMonthCount = User::whereHas('nominates', function ($query) {
                $query->whereMonth('recive_date', Carbon::now()->month);
                //   ->where('is_recive', '3');
            })->count();


            // الحصول على عدد الأعضاء الذين لم يتم إنشاؤهم في الشهر الحالي
            $usersNotInCurrentMonthCount = User::whereDoesntHave('nominates', function ($query) {
                $query->whereMonth('recive_date',  Carbon::now()->month);
            })->count();

            $userInActive = User::whereIs_active('0')->count();

            return response()->view('dash.index', [
                'users' => $usersCount,
                'usersInCurrentMonthCount'  => $usersInCurrentMonthCount,
                'usersNotInCurrentMonth'    => $usersNotInCurrentMonthCount,
                'userInActive'              => $userInActive
            ]);
        } else {
            return abort(403, 'لا يوجد لديك صلاحيات');
        }

        if (Auth::guard('web')->check() && Auth::guard('web')->user()->hasPermissionTo('Read-Admins')) {
            
        } else {
        }
    }

    public function ChartNominates()
    {
        $entries = Nominate::whereYear('recive_date', date('Y'))
            ->select(
                DB::raw("MONTH(recive_date) as month_number"),
                DB::raw("MONTHNAME(recive_date) as month_name"),
                DB::raw("
                    COUNT(CASE WHEN is_recive = 1 THEN 1 END) as candidate_count,
                    COUNT(CASE WHEN is_recive = 2 THEN 1 END) as printed_count,
                    COUNT(CASE WHEN is_recive = 3 THEN 1 END) as received_count,
                    COUNT(CASE WHEN is_recive = 4 THEN 1 END) as not_received_count
                ")
            )
            ->whereHas('user')
            ->groupBy('month_number', 'month_name')
            ->orderBy('month_number')
            ->get();

        $labels = [];
        $candidateCounts = [];
        $printedCounts = [];
        $receivedCounts = [];
        $notReceivedCounts = [];

        foreach ($entries as $entry) {
            $labels[] = "{$entry->month_name} ({$entry->month_number})";
            $candidateCounts[] = $entry->candidate_count;
            $printedCounts[] = $entry->printed_count;
            $receivedCounts[] = $entry->received_count;
            $notReceivedCounts[] = $entry->not_received_count;
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'مرشح',
                    'data' => $candidateCounts,
                ],
                [
                    'label' => 'مطبوع',
                    'data' => $printedCounts,
                ],
                [
                    'label' => 'مستلم',
                    'data' => $receivedCounts,
                ],
                [
                    'label' => 'غير مستلم',
                    'data' => $notReceivedCounts,
                ]
            ]
        ];
    }

    public function ChartLocation()
    {
        $entries = Nominate::with(['coupon.location:id,name']) // تضمين العلاقة مع `location` عبر `coupon`
            ->select(
                DB::raw("MONTHNAME(recive_date) as month"),
                'coupon_id',
                DB::raw("COUNT(*) as total_count"),
                DB::raw("MONTH(recive_date) as month_number")
            )
            //->where('is_recive', '3') // أزل تعليق هذا السطر إذا كان مطلوباً
            ->whereYear('recive_date', date('Y'))
            ->groupBy(['month', 'month_number', 'coupon_id'])
            ->orderBy('month_number')
            ->get();

        $labels = [];
        $counts = [];
        $backgroundColors = [];

        // Define a list of colors
        $colors = [
            'rgba(75, 192, 192, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(199, 199, 199, 1)'
        ];

        foreach ($entries as $entry) {
            $month_number = $entry->month_number;
            $location_name = $entry->coupon->location->name; // الوصول إلى اسم الموقع عبر `coupon`
            $total_count = $entry->total_count;

            $label = "شهر - $month_number - $location_name";

            if (!in_array($label, $labels)) {
                $labels[] = $label;
            }

            if (!isset($counts[$label])) {
                $counts[$label] = 0;
            }
            $counts[$label] += $total_count;

            // Assign a random color to each bar
            $backgroundColors[] = $colors[array_rand($colors)];
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'عدد المستفيدين',
                    'data' => array_values($counts),
                    'backgroundColor' => $backgroundColors,
                ]
            ]
        ];
    }
}
