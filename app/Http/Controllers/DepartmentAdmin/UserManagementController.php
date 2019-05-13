<?php

namespace App\Http\Controllers\DepartmentAdmin;

use App\Http\Requests\DepartmentAdmin\UpdateUserManagementRequest;
use App\Http\Requests\SystemAdmin\UserRequest;
use App\Models\DepartmentUser;
use App\Models\Position;
use App\Models\User;
use App\Models\Department;
use App\Uploaders\Uploader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentAdmin\UserManagementRequest;
use Illuminate\Support\Facades\Auth;
use File;

class UserManagementController extends Controller
{
    protected $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index()
    {
        $departmentID = DepartmentUser::where('user_id', Auth::user()->id)->first()->department_id;
        $departmentUser = User::join('department_users', 'department_users.user_id', '=', 'users.id')
            ->join('positions', 'positions.id', 'department_users.position_id')
            ->where(['department_users.department_id' => $departmentID, 'users.is_active' => config('setting.active.is_active')])
            ->select('users.*', 'department_users.*', 'positions.name as position_name')
            ->get();
        return view('department_admin.users.index', compact('departmentUser'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('department_admin.users.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserManagementRequest $request)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        if(isset($input['avatar'])){
            $input['avatar'] = $this->uploader->saveImg($input['avatar']);
        }
        $input['role'] = config('setting.position.secretary');
        if($request->no_end_date == 1){
            $input['end_date'] = null;
        }
        DB::beginTransaction();
        try
        {
            $departmentID = DepartmentUser::where('user_id',Auth::user()->id)->first();
            User::create($input);
            $id = User::select('id')->where('email', $input['email'])->first();
            DepartmentUser::insert(['user_id' => $id->id, 'start_date' => Carbon::now(), 'end_date' => $input['end_date'], 'department_id' => $departmentID['department_id'], 'position_id' => config('setting.position.instructor')]);
            DB::commit();

            return redirect()->route('users.index')->with('messageSuccess', 'Thêm Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('users.index')->with('messageFail', 'Thêm Thất Bại');
        }
    }

    public function indexOfAdd(){
        $listUsers = DB::table('users')->join('department_users', 'users.id', '=', 'department_users.user_id')
            ->where('department_users.department_id', config('setting.department.no_department'))
            ->where('users.is_active', config('setting.active.is_active'))
            ->pluck('users.name', 'users.id');

        return view('department_admin.users.add_user_exists', compact('listUsers'));
    }

    public function addUserExist(Request $request){
        $input = $request->departments;
        $departmentID = DepartmentUser::where('user_id',Auth::user()->id)->first();
        foreach($input as $value){
            DepartmentUser::where('user_id', $value)->update(['department_id' => $departmentID['department_id']]);
        }

        return redirect()->route('users.index')->with('messageSuccess', 'Thêm Thành Công');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function archiveIndex(){
        $departmentID = DepartmentUser::where('user_id',Auth::user()->id)->first()->department_id;
        $departmentUser = User::join('department_users','users.id' ,'=' , 'department_users.user_id')
            ->where(['users.is_active' => config('setting.active.no_active'),  'department_users.department_id' => $departmentID])->get();

        return view('department_admin.users.archive', compact( 'position', 'department', 'departmentUser'));
    }

    public function restore($id){
        DB::beginTransaction();
        try
        {
            User::find($id)->update(['is_active' => config('setting.active.is_active')]);
            DB::commit();

            return redirect()->route('users.archive')->with('messageSuccess', 'Hoàn Tác Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('users.archive')->with('messageFail', 'Hoàn Tác Thất Bại');
        }
    }

    public function show($id)
    {
        try
        {
            $user = User::with('departmentUser')->where('users.id',$id)->first();
            $department = DepartmentUser::where('user_id',$id)->first();

            return view('department_admin.users.edit', compact('user', 'department'));
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('messageFail', "Lỗi Hệ Thống");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    public function ajaxEmail(){
        $user = User::where('is_active',config('setting.active.is_active'))->get();
        return response()->json($user);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserManagementRequest $request, $id)
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        if($request->no_end_date == 1){
            $input['end_date'] = null;
        }
        DB::beginTransaction();
        try
        {
            if(!isset($input['avatar'])){
                User::find($id)->update(['password' => $input['password'], 'name' => $input['name'], 'birth_date' => $input['birth_date'], 'gender' => $input['gender'], 'address' => $input['address'], 'phone' => $input['phone']]);
                DepartmentUser::where('user_id', $id)->update(['start_date' => Carbon::now(),'end_date' => $input['end_date']]);
            }
            else {
                $dataOfUser = User::where('id', Auth::user()->id)->first()->avatar;
                $this->uploader->checkOldImg($dataOfUser,false,'/upload/images');
                $input['avatar'] = $this->uploader->saveImg($input['avatar']);
                User::find($id)->update($input);
                DepartmentUser::where('user_id', $id)->update(['start_date' => Carbon::now(),'end_date' => $input['end_date']]);
            }
            DB::commit();

            return redirect()->route('users.index')->with('messageSuccess', 'Cập Nhật Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('users.index')->with('messageFail', 'Cập Nhật Thất Bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try
        {
            $user = User::findOrFail($id);
            $user->update(['is_active' => config('setting.active.no_active')]);
            DB::commit();

            return redirect()->route('users.index')->with('messageSuccess', 'Xóa Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->back()->with('messageFail', 'Xóa Thất Bại');
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try
        {
            DepartmentUser::where('user_id', $id)->delete();
            $user = User::findOrFail($id);
            $this->uploader->checkOldImg($user->avatar,false,'/upload/images');
            $user->delete();
            DB::commit();

            return redirect()->route('users.index')->with('messageSuccess', 'Xóa Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->back()->with('messageFail', 'Xóa Thất Bại');
        }
    }
}
