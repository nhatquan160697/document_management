<?php

namespace App\Http\Controllers\DepartmentAdmin;

use App\Http\Requests\SystemAdmin\ScheduleWeekRequest;
use App\Models\ScheduleWeek;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScheduleManagementController extends Controller
{
    public function index(){
        $schedule = ScheduleWeek::where('is_active', config('setting.active.is_active'))->get();

        return view('department_admin.schedule_week.index', compact('schedule'));
    }

    public function create(){
        return view('department_admin.schedule_week.add');

    }

    public function store(ScheduleWeekRequest $request){
        $input = $request->all();
        try {
            $array = array();
            for($i=2; $i<=8 ; $i++){
                $array['thu'.$i.'S'] =  $input['thu'.$i.'S'];
                $array['thu'.$i.'C'] =  $input['thu'.$i.'C'];
                $array['thu'.$i.'T'] =  $input['thu'.$i.'T'];

            }
            $dateConvert = date('Y-m-d', strtotime($input['start'] . ' +6 day'));
            $array = json_encode($array);
            $input['content'] = $array;
            $input['end'] = $dateConvert;
            $input['user_id'] = Auth::user()->id;
            $input['is_active'] = config('setting.active.is_active');
            ScheduleWeek::create($input);

            return redirect()->route('schedule-admin.index')->with('messageSuccess', 'Thêm Thành Công');
        }
        catch (Exception $exception)
        {
            return redirect()->route('schedule-admin.index')->with('messageFail', 'Thêm Thất Bại');
        }
    }

    public function show($id)
    {
        try
        {
            $schedule = ScheduleWeek::where('is_active', config('setting.active.is_active'))
                ->where('id',$id)
                ->first();
            $timeTable = json_decode($schedule->content);

            return view('department_admin.schedule_week.edit', compact('schedule', 'timeTable'));
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('messageFail', "Lỗi Hệ Thống");
        }
    }

    public function update(ScheduleWeekRequest $request, $id){
        $input = $request->all();
        try
        {
            $array = array();
            for($i=2; $i<=8 ; $i++){
                $array['thu'.$i.'S'] =  $input['thu'.$i.'S'];
                $array['thu'.$i.'C'] =  $input['thu'.$i.'C'];
                $array['thu'.$i.'T'] =  $input['thu'.$i.'T'];

            }
            $dateConvert = date('Y-m-d', strtotime($input['start'] . ' +6 day'));
            $array = json_encode($array);
            $input['content'] = $array;
            $input['end'] = $dateConvert;
            $input['user_id'] = Auth::user()->id;
            ScheduleWeek::find($id)->update($input);

            return redirect()->route('schedule-admin.index')->with('messageSuccess', 'Sửa Thành Công');
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('messageFail', "Lỗi Hệ Thống");
        }
    }

    public function archive(){
        $schedule = ScheduleWeek::where('is_active',config('setting.active.no_active'))->get();

        return view('department_admin.schedule_week.archive', compact( 'schedule'));
    }

    public function restore($id){
        DB::beginTransaction();
        try
        {
            ScheduleWeek::find($id)->update(['is_active' => config('setting.active.is_active')]);
            DB::commit();

            return redirect()->route('schedule-archived')->with('messageSuccess', 'Hoàn Tác Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('schedule-archived')->with('messageFail', 'Hoàn Tác Thất Bại');
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try
        {
            $schedule = ScheduleWeek::findOrFail($id);
            $schedule->update(['is_active' => config('setting.active.no_active')]);
            DB::commit();

            return redirect()->route('schedule-admin.index')->with('messageSuccess', 'Xóa Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->back()->with('messageFail', 'Xóa Thất Bại');
        }
    }
}
