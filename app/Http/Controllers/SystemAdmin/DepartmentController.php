<?php

namespace App\Http\Controllers\SystemAdmin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\DepartmentUser;
use App\Http\Requests\SystemAdmin\DepartmentRequest;
use Carbon\Carbon;


class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::where('is_active', config('setting.active.is_active'))->get();

        return view('system_admin.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::where('is_active', config('setting.active.is_active'))->get();

        return view('system_admin.department.add', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        try {
            DB::beginTransaction();

            $input = $request->only('name');
            $input['is_active'] = config('setting.active.is_active');

            $getAllDepartments = Department::all();
            $inputRequest = trim(str_replace('-', '', str_slug($input['name'])));
            foreach ($getAllDepartments as $department) {
                $departmentName = trim(str_replace('-', '', str_slug($department->name)));
                if ($inputRequest == $departmentName) {

                    return redirect()->route('department.create')->with('alert', 'Tên phòng ban bạn nhập đã bị trùng! Vui lòng nhập tên phòng ban khác!');
                }
            } 
            Department::create($input);
            
            DB::commit();

            return redirect(route('department.index'))->with('alert', 'Thêm thành công');
        } catch (Exception $e) {
            DB::rollBack();

            return redirect(route('department.create'))->with('alert', 'Thêm thất bại');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::findOrFail($id);

        return view('system_admin.department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, $id)
    {
        try {
            $dataUpdate = $request->only('name');
            $result = Department::whereId($id)->update($dataUpdate);

            if ($result) {

                return redirect(route('department.index'))->with('alert', 'Sửa thành công');
            } else{

                return redirect(route('department.index'))->with('alert', 'Dữ liệu không được sửa đổi');
            }


        } catch (Exception $e) {

            return redirect(route('department.edit'))->with('alert', 'Sửa thất bại');
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
        try {
            $dataActive = config('setting.active.no_active');
            $result = Department::whereId($id)->update(['is_active' => $dataActive]);

            if ($result) {

                return redirect(route('department.index'))->with('alert', 'Xóa thành công');
            } else {

                return redirect(route('department.index'))->with('alert', 'Xóa thất bại');
            }

        } catch (Exception $e) {

            return redirect(route('department.index'))->with('alert', 'Xóa thất bại');
        }
    }   

    public function archive()
    {
        $departments = Department::where('is_active', config('setting.active.no_active'))->get();

        return view('system_admin.department.archive', compact('departments'));
    }

    public function restore($id)
    {
        try {
            $active = config('setting.active.is_active');
            $result = Department::whereId($id)->update(['is_active' => $active]);

            if ($result) {

                return redirect(route('department-archived'))->with('alert', 'Khôi phục thành công');
            } else {

                return redirect(route('department-archived'))->with('alert', 'Không tìm thấy id');
            }

        } catch (Exception $e) {

            return redirect(route('department-archived'))->with('alert', 'Khôi phục thất bại');
        }
    }
}
