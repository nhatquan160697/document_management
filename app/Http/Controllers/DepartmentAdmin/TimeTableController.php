<?php

namespace App\Http\Controllers\DepartmentAdmin;

use App\Http\Requests\DepartmentAdmin\TimetableRequest;
use App\Models\DepartmentUser;
use App\Models\TimeTable;
use App\Uploaders\Uploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimeTableController extends Controller
{
    protected $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index(){
        $departmentUser = DepartmentUser::where('user_id', Auth::user()->id)->first();
        $timeTable = TimeTable::where('is_active', config('setting.active.is_active'))
            ->where('department_id', $departmentUser->department_id)
            ->get();

        return view('department_admin.timetable.index', compact('timeTable'));
    }

    public function saveTimeTable($input){
        $departmentUser = DepartmentUser::where('user_id', Auth::user()->id)->first();
        $input['user_id'] = Auth::user()->id;
        $input['is_active'] = config('setting.active.is_active');
        $input['department_id'] = $departmentUser->department_id;

        return $input;
    }

    public function create()
    {
        return view('department_admin.timetable.add');
    }

    public function store(TimetableRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            if(!isset($input['file_attachment'])){
                $input = $this->saveTimeTable($input);
                TimeTable::create($input);
            }
            else {
                $path = 'upload/files/schedule';
                $arrFiles = $this->uploader->saveFileAttach($input['file_attachment'],$path);
                $input['file_attachment'] = json_encode($arrFiles);
                $input = $this->saveTimeTable($input);
                TimeTable::create($input);
            }
            DB::commit();

            return redirect()->route('timetable.index')->with('messageSuccess', 'Thêm Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('timetable.index')->with('messageFail', 'Thêm Thất Bại');
        }

    }

    public function show($id)
    {
        try
        {
            //array file attachment
            $fileString = TimeTable::where('id', $id)->first();
            $arrayFileDecode = array();
            if(isset($fileString['file_attachment'])){
                $arrayFileDecode = json_decode($fileString['file_attachment']);
            }

            $timeTable = TimeTable::where('id',$id)->first() ;

            return view('department_admin.timetable.edit', compact('timeTable', 'arrayFileDecode'));
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('messageFail', "Lỗi Hệ Thống");
        }
    }

    public function update(TimetableRequest $request, $id)
    {
        $input = $request->all();
        DB::beginTransaction();
        try
        {
            if(!isset($input['file_attachment'])){
                TimeTable::find($id)->update(['name' => $input['name'], 'description' => $input['description']]);
            }
            else {
                $path = 'upload/files/schedule';
                $dataOfTimetable = TimeTable::find($id)->file_attachment;
                $this->uploader->checkOldImg($dataOfTimetable,true, $path);
                $arrFiles = $this->uploader->saveFileAttach($input['file_attachment'],$path);
                $input['file_attachment'] = json_encode($arrFiles);
                TimeTable::find($id)->update($input);
            }
            DB::commit();

            return redirect()->route('timetable.index')->with('messageSuccess', 'Cập Nhật Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('timetable.index')->with('messageFail', 'Cập Nhật Thất Bại');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try
        {
            $timeTable = TimeTable::findOrFail($id);
            $timeTable->update(['is_active' => config('setting.active.no_active')]);
            DB::commit();

            return redirect()->route('timetable.index')->with('messageSuccess', 'Xóa Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->back()->with('messageFail', 'Xóa Thất Bại');
        }
    }

    public function archiveIndex(){
        $timeTable = TimeTable::where('is_active',config('setting.active.no_active'))->get();

        return view('department_admin.timetable.archive', compact( 'timeTable'));
    }

    public function restore($id){
        DB::beginTransaction();
        try
        {
            TimeTable::find($id)->update(['is_active' => config('setting.active.is_active')]);
            DB::commit();

            return redirect()->route('timetable.archive')->with('messageSuccess', 'Hoàn Tác Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('timetable.archive')->with('messageFail', 'Hoàn Tác Thất Bại');
        }
    }

}
