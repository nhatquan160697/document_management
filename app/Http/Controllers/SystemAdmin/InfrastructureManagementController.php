<?php

namespace App\Http\Controllers\SystemAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Infrastructure;
use App\Models\Department;
use App\Uploaders\Uploader;
use App\Http\Requests\SystemAdmin\InfrastructureRequest;
use File;

class InfrastructureManagementController extends Controller
{
    protected $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index()
    {

        $infrastructure = Infrastructure::where('is_active',config('setting.active.is_active'))->get();
        $department = Department::pluck('name', 'id');

        return view('system_admin.infrastructure.index', compact( 'infrastructure', 'department'));
    }

    public function changeDepartment(Request $request, $id){
        $input = $request->all();
        DB::beginTransaction();
        try
        {
            Infrastructure::where('id', $id)->update(['department_id' => $input['department_id']]);
            DB::commit();

            return redirect()->route('infrastructure.index')->with('messageSuccess', 'Cập Nhật Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('infrastructure.index')->with('messageFail', 'Cập Nhật Thất Bại');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = Department::pluck('name', 'id');

        return view('system_admin.infrastructure.add', compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InfrastructureRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try
        {
            if(!isset($input['picture'])){
                Infrastructure::create(['name' => $input['name'], 'department_id' => $input['department_id'], 'amount' => $input['amount']]);
            }
            else {
                $input['picture'] = $this->uploader->saveImg($input['picture']);
                Infrastructure::create($input);
            }
            DB::commit();

            return redirect()->route('infrastructure.index')->with('messageSuccess', 'Thêm Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('infrastructure.index')->with('messageFail', 'Thêm Thất Bại');
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
        DB::beginTransaction();
        try
        {
            $infrastructure = Infrastructure::FindOrFail($id);
            $department = Department::pluck('name', 'id');
            DB::commit();

            return view('system_admin.infrastructure.edit', compact('infrastructure', 'department'));
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('infrastructure.index')->with('messageSuccess', 'Cập Nhật Thất Bại');
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InfrastructureRequest $request, $id)
    {
        $input = $request->all();
        DB::beginTransaction();
        try
        {
            $updateInfrastructure = Infrastructure::FindOrFail($id);
            if(!isset($input['picture'])){
                $updateInfrastructure->update(['name' => $input['name'], 'department_id' => $input['department_id'], 'amount' => $input['amount']]);
            }
            else {
                $input['picture'] = $this->uploader->saveImg($input['picture']);
                $updateInfrastructure->update($input);
            }
            DB::commit();

            return redirect()->route('infrastructure.index')->with('messageSuccess', 'Cập Nhật Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('infrastructure.index')->with('messageFail', 'Cập Nhật Thất Bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archiveIndex(){
        $infrastructure = Infrastructure::where('is_active',config('setting.active.no_active'))->get();
        $department = Department::pluck('name', 'id');

        return view('system_admin.infrastructure.archive', compact( 'infrastructure', 'department'));
    }

    public function restore($id){
        DB::beginTransaction();
        try
        {
            Infrastructure::find($id)->update(['is_active' => config('setting.active.is_active')]);
            DB::commit();

            return redirect()->route('infrastructure.archive')->with('messageSuccess', 'Hoàn Tác Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('infrastructure.archive')->with('messageFail', 'Hoàn Tác Thất Bại');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try
        {
            $infrastructure = Infrastructure::findOrFail($id);
            $infrastructure->update(['is_active' => config('setting.active.no_active')]);
            DB::commit();

            return redirect()->route('infrastructure.index')->with('messageSuccess', 'Xóa Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->back()->with('messageFail', 'Xóa Thất Bại');
        }
    }
}
