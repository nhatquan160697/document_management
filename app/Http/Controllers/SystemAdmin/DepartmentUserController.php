<?php

namespace App\Http\Controllers\SystemAdmin;

use App\Uploaders\Uploader;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\DepartmentUser;
use App\Models\Position;
use Carbon\Carbon;

class DepartmentUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index()
    {
        $depUsers = DB::table('users')
                    ->select('department_users.user_id as department_user_id', 'start_date', 'end_date', 'users.name as username', 'departments.name as depname', 'positions.name as posname')
                    ->join('department_users', 'users.id', '=', 'department_users.user_id')
                    ->join('departments', 'department_users.department_id', '=', 'departments.id')
                    ->join('positions', 'positions.id', '=', 'department_users.position_id')
                    ->where('users.role', '!=', config('setting.roles.system_admin'))
                    ->where('department_users.position_id', '!=', config('setting.position.admin_department'))
                    ->where('users.is_active', '=', 1)
                    ->get();


        return view('system_admin.department_user.index', compact('depUsers'));
    }

    public function trash() {
        $depUsers = DB::table('users')
            ->select('department_users.user_id as department_user_id', 'start_date', 'end_date', 'users.name as username', 'departments.name as depname', 'positions.name as posname')
            ->join('department_users', 'users.id', '=', 'department_users.user_id')
            ->join('departments', 'department_users.department_id', '=', 'departments.id')
            ->join('positions', 'positions.id', '=', 'department_users.position_id')
            ->where('users.role', '!=', config('setting.roles.system_admin'))
            ->where('department_users.position_id', '!=', config('setting.position.admin_department'))
            ->where('users.is_active', '=', 0)
            ->get();

        return view('system_admin.department_user.trash', compact('depUsers'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $searchDepartment = DB::table('departments')
            ->whereIn('departments.id',
                DepartmentUser::where('position_id', config('setting.position.admin_department'))->pluck('department_id'))
            ->pluck('name', 'id');
        $searchPosition = Position::where('id', '!=', config('setting.position.admin_department'))->pluck('name' , 'id');

        return view('system_admin.department_user.create_user', compact('searchDepartment', 'searchPosition'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|numeric',
            'avatar' => 'mimes:jpeg,png,bmp,gif,svg,jpg|max:10000',
        ],
        [
            'email.required' => "Bạn vui lòng nhập email",
            'email.email' => "Vui lòng nhập đúng định dạng email",
            'email.unique' => "Đã tồn tại email này",
            'password.required' => "Vui lòng nhập mật khẩu",
            'name.required' => "Vui lòng nhập họ tên",
            'address.required' => "Vui lòng nhập địa chỉ",
            'phone.required' => "Vui lòng nhập số điện thoại",
            'phone.numeric' => "Số điện thoại chỉ bao gồm số",
            'avatar.mimes' => "Ảnh đại diện phải là một tệp loại: jpeg, png, bmp, gif, svg, jpg.",
            'avatar.max' => 'giới hạn upload file là 10 MB',
        ]);
        $dataUser = $request->only('name', 'username', 'email', 'password', 'birth_date', 'gender', 'address', 'phone', 'avatar');
        $date = Carbon::createFromFormat('d/m/Y', $dataUser['birth_date']);
        $dataUser['birth_date'] = Carbon::parse($date)->format('Y-m-d');
        $dataUser['password'] = bcrypt($dataUser['password']);
        if(isset($dataUser['avatar'])){
            $dataUser['avatar'] = $this->uploader->saveImg($dataUser['avatar']);
        }
        $dataUser['role'] = config('setting.position.secretary');
        $dataDepartmentUser = $request->only('no_end_date', 'end_date', 'position_id', 'department_id');
        $dataDepartmentUser['start_date'] = Carbon::now();
        if($request->no_end_date == 1){
            $dataDepartmentUser['end_date'] = null;
        } else {
            $date = \DateTime::createFromFormat('d/m/Y', $request->end_date);
            $date = $date->format('Y-m-d');
            $dataDepartmentUser['end_date'] = $date;
        }
        DB::beginTransaction();
        try {
            $id = User::create($dataUser);
            $dataDepartmentUser['user_id'] = $id->id;
            DepartmentUser::create($dataDepartmentUser);
            DB::commit();

            return redirect()->route('department-user.index')->with('messageSuccess', 'Thêm Thành Công');
        } catch ( Exception $e) {
            DB::rollBack();

            return redirect()->route('department-user.index')->with('messageFail', 'Thêm Thất Bại');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $select = [
            DB::raw("DATE_FORMAT(department_users.end_date, '%d/%m/%Y') as 'end_date'"),
            'users.id',
            'users.name',
            'users.username',
            'users.email',
            DB::raw("DATE_FORMAT(users.birth_date, '%d/%m/%Y') as 'birth_date'"),
            'users.gender',
            'users.address',
            'users.phone',
            'users.avatar',
            'users.is_active',
        ];
        $depUsers = User::select($select)->join('department_users', 'department_users.user_id', '=', 'users.id')->where('users.id', $id)->first();

        return view('system_admin.department_user.edit_user', compact('depUsers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $depUsers = User::findOrFail($id);
        $currentDepartment = DepartmentUser::with('department')
            ->where('user_id', $id)
            ->first()
            ->toArray();
        $searchDepartment = DB::table('departments')
            ->whereIn('departments.id',
            DepartmentUser::where('position_id', config('setting.position.admin_department'))->pluck('department_id'))
            ->pluck('name', 'id');
        $searchPosition = Position::where('id', '!=', config('setting.position.admin_department'))->pluck('name' , 'id');

        return view('system_admin.department_user.edit', compact('depUsers', 'currentDepartment', 'searchDepartment', 'searchPosition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $dataUpdate = $request->only('department_id', 'position_id');

            $result = DepartmentUser::where('user_id', $id)->update($dataUpdate);

            if ($result) {

                return redirect(route('department-user.index', ['id' => $id] ))->with('messageSuccess', 'Sửa thành công');
            } else{

                return redirect(route('department-user.edit', ['id' => $id] ))->with('messageFail', 'Dữ liệu không được sửa đổi');
            }


        } catch (Exception $e) {

            return redirect(route('department-user.edit', ['id' => $id]))->with('messageFail', 'Sửa thất bại');
        }
    }

    public function updateUser(Request $request, $id) {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|numeric',
            'avatar' => 'mimes:jpeg,png,bmp,gif,svg,jpg|max:10000',
        ],
            [
                'email.required' => "Bạn vui lòng nhập email",
                'email.email' => "Vui lòng nhập đúng định dạng email",
                'name.required' => "Vui lòng nhập họ tên",
                'address.required' => "Vui lòng nhập địa chỉ",
                'phone.required' => "Vui lòng nhập số điện thoại",
                'phone.numeric' => "Số điện thoại chỉ bao gồm số",
                'avatar.mimes' => "Ảnh đại diện phải là một tệp loại: jpeg, png, bmp, gif, svg, jpg.",
                'avatar.max' => 'giới hạn upload file là 10 MB',
            ]);
        $user = User::select('email')->where('id', '!=' , $id)->where('email', $request->email)->first();
        if (isset($user) && $user->count() > 0) {
            return redirect()->back()->withErrors(['email' => 'Đã tồn tại email này trong hệ thống'])->withInput();
        }
        $dataUser = [];
        $dataDepartmentUser = [];
        $dataUser = $request->only('name', 'username', 'email', 'birth_date', 'gender', 'address', 'phone', 'avatar');
        $birthDate = \DateTime::createFromFormat('d/m/Y', $request->birth_date);
        $birthDate = $birthDate->format('Y-m-d');
        $dataUser['birth_date'] = $birthDate;
        if($request->no_end_date == 1) {
            $dataDepartmentUser['end_date'] = null;
        }
        else {
            $date = \DateTime::createFromFormat('d/m/Y', $request->end_date);
            $date = $date->format('Y-m-d');
            $dataDepartmentUser['end_date'] = $date;
        }
        if ($request->checkPass == 0) {
            $request->validate([
                'passwordEdit' => 'required',
            ],
                [
                    'passwordEdit.required' => 'Vui lòng nhập mật khẩu',
                ]);
            $dataUser['password'] = bcrypt($request->passwordEdit);
        }
        if(isset($dataUser['avatar'])){
            $img = User::select('avatar')->where('id', $id)->first()->avatar;
            if (file_exists('/upload/images/'.$img)) {
                unlink('/upload/images/'.$img);
            }

            $dataUser['avatar'] = $this->uploader->saveImg($dataUser['avatar']);
        }
        DB::beginTransaction();
        try {
            User::where('id', $id)->update($dataUser);
            DepartmentUser::where('user_id', $id)->update($dataDepartmentUser);
            DB::commit();

            return redirect()->route('department-user.index')->with('messageSuccess', 'Sửa Thành Công');
        } catch ( Exception $e) {
            DB::rollBack();

            return redirect()->route('department-user.index')->with('messageFail', 'Sửa Thất Bại');
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
        $user = User::where('id', $id)->first();
        if (isset($user) && $user->count() > 0) {
            User::where('id', $id)->update(['is_active' => 0]);
            return redirect()->route('department-user.index')->with('messageSuccess', 'Xoá Thành Công');
        }
        else {
            abort(404);
        }
    }

    public function restore($id)
    {
        $user = User::where('id', $id)->first();
        if (isset($user) && $user->count() > 0) {
            User::where('id', $id)->update(['is_active' => 1]);
            return redirect()->route('department-user.trash')->with('messageSuccess', 'Khôi phục Thành Công');
        }
        else {
            abort(404);
        }
    }
}
