<?php

namespace App\Http\Controllers;

use App\Models\ScheduleWeek;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleWeekController extends Controller
{
    public function index(){
        $schedule = ScheduleWeek::where('is_active', config('setting.active.is_active'))
            ->get();

        return view('schedule_week.index', compact('schedule'));
    }

    public function show($id){
        try
        {
            $schedule = ScheduleWeek::where('is_active', config('setting.active.is_active'))
                ->where('id',$id)
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
            $scheduleRandom = ScheduleWeek::where('is_active', config('setting.active.is_active'))
                ->where('id', '!=', $id)
                ->orderBy(DB::raw('RAND()'))
                ->limit(5)
                ->get();
            $countSchedule =  $scheduleRandom->count();

            return view('schedule_week.detail', compact('schedule', 'timeTable', 'scheduleRandom', 'countSchedule'));
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('messageFail', "Lỗi Hệ Thống");
        }
    }

    public function indexNoLogin(){
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

        return view('common.schedule_week', compact('schedule', 'timeTable'));
    }
}
