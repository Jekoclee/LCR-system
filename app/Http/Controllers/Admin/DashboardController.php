<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $roomsSummary = [
            'total' => 0,
            'with_units' => 0,
            'zero_units' => 0,
            'units_sum' => 0,
        ];
        $con = @mysqli_connect('localhost', 'root', '', 'lcrwebsite');
        if ($con) {
            $unitsCol = null;
            foreach (['units', 'room_units', 'room_unit', 'quantity', 'qty', 'stock'] as $c) {
                $exists = @mysqli_query($con, "SHOW COLUMNS FROM `rooms` LIKE '" . mysqli_real_escape_string($con, $c) . "'");
                if ($exists && mysqli_num_rows($exists) > 0) {
                    $unitsCol = $c;
                    break;
                }
            }
            $resTotal = @mysqli_query($con, "SELECT COUNT(*) AS c FROM rooms WHERE removed=0 AND status=1");
            if ($resTotal) {
                $row = mysqli_fetch_assoc($resTotal);
                $roomsSummary['total'] = (int) ($row['c'] ?? 0);
            }
            if ($unitsCol) {
                $resWithUnits = @mysqli_query($con, "SELECT COUNT(*) AS c FROM rooms WHERE removed=0 AND status=1 AND `" . $unitsCol . "` > 0");
                if ($resWithUnits) {
                    $row = mysqli_fetch_assoc($resWithUnits);
                    $roomsSummary['with_units'] = (int) ($row['c'] ?? 0);
                }
                $resZeroUnits = @mysqli_query($con, "SELECT COUNT(*) AS c FROM rooms WHERE removed=0 AND status=1 AND `" . $unitsCol . "` <= 0");
                if ($resZeroUnits) {
                    $row = mysqli_fetch_assoc($resZeroUnits);
                    $roomsSummary['zero_units'] = (int) ($row['c'] ?? 0);
                }
                $resUnitsSum = @mysqli_query($con, "SELECT SUM(`" . $unitsCol . "`) AS s FROM rooms WHERE removed=0 AND status=1");
                if ($resUnitsSum) {
                    $row = mysqli_fetch_assoc($resUnitsSum);
                    $roomsSummary['units_sum'] = (int) ($row['s'] ?? 0);
                }
            }
            mysqli_close($con);
        }
        $recentBookings = \App\Models\Booking::latest()->take(5)->get();

        // Statistics
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'total_bookings' => \App\Models\Booking::count(),
            'pending_bookings' => \App\Models\Booking::where('status', 'pending')->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'total_superadmins' => User::where('role', 'superadmin')->count(),
            'recent_users' => User::latest()->take(5)->get(),
            'rooms_summary' => $roomsSummary,
            'recent_bookings' => $recentBookings,
        ];

        return view('admin.dashboard', compact('stats', 'user'));
    }
}
