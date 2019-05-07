<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Infrastructure;
use App\Models\ScheduleWeek;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeAdminController extends Controller
{
    public function index()
    {   $sumOfDepartments = Department::where('is_active',config('setting.active.is_active'))->get()->count();
        $sumOfUsers = User::where('is_active',config('setting.active.is_active'))->get()->count();
        $sumOfAdminDepartments = User::where(['is_active' => config('setting.active.is_active'), 'role' => 2])->get()->count();
        $sumOfInfrastructures = Infrastructure::where('is_active',config('setting.active.is_active'))->get()->count();
        $schedule = ScheduleWeek::where('is_active', config('setting.active.is_active'))
            ->where(DB::raw('DATEDIFF(scheduleweek.end,CURRENT_DATE())'),'<=','6')
            ->where(DB::raw('DATEDIFF(scheduleweek.end,CURRENT_DATE())'),'>','0')
            ->first();
        if(isset($schedule->content)){
            $timeTable = json_decode($schedule->content);
        }
        else {
            $timeTable = array();
            for($i=2; $i<=8 ; $i++){
                $timeTable['thu'.$i.'S'] =  null;
                $timeTable['thu'.$i.'C'] =  null;
                $timeTable['thu'.$i.'T'] =  null;
            }
        }

        return view('home_admin', compact('schedule', 'timeTable', 'sumOfDepartments', 'sumOfUsers', 'sumOfAdminDepartments', 'sumOfInfrastructures'));
    }
}
