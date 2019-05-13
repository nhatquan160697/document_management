<?php

namespace App\Http\Controllers\DepartmentAdmin;

use App\Models\Department;
use App\Models\DepartmentUser;
use App\Models\Form;
use App\Uploaders\Uploader;
use App\Models\Position;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\DepartmentAdmin\FormManagementRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use File;

class FormManagementController extends Controller
{
    protected $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index()
    {
  		$idDepartment = DepartmentUser::where('user_id', Auth::user()->id)->first()->department_id;
        $forms = Form::where('is_active', config('setting.active.is_active'))->where('approved_by', '!=', config('setting.approval.no_approved'))
        ->where('department_id', $idDepartment)
        ->get();

        return view('department_admin.forms.index', compact( 'forms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('department_admin.forms.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveForm($input){
        if(Auth::user()->role == config('setting.roles.admin_department')){
            $input['approved_by'] = Auth::user()->id;
            $idDepartment = DepartmentUser::where('user_id', Auth::user()->id)->first();
            $input['department_id'] = $idDepartment->department_id ;
            $input['sent_date'] = Carbon::now();
        }
        else {
            $idDepartment = DepartmentUser::where('user_id', Auth::user()->id)->first();
            $input['department_id'] = $idDepartment->department_id ;
        }

        return $input;
    }

    public function store(FormManagementRequest $request)
    {
        $input = $request->all();
        DB::beginTransaction();
        try {
            if(!isset($input['link'])){
                $input['link'] = null;
                $input = $this->saveForm($input);

                Form::create($input);
            }
            else {
                $path = 'upload/files/form';
                $arrFiles = $this->uploader->saveFileAttach($input['link'],$path);
                $input['link'] = json_encode($arrFiles);
                $input = $this->saveForm($input);

                Form::create($input);
            }
            DB::commit();

            return redirect()->route('forms.index')->with('messageSuccess', 'Thêm Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('forms.index')->with('messageFail', 'Thêm Thất Bại');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approval(){
        $idDepartment = DepartmentUser::where('user_id', Auth::user()->id)->first();
        $form = Form::where('is_active', config('setting.active.is_active'))
            ->where('department_id', $idDepartment->department_id)
            ->where('approved_by', config('setting.approval.no_approved'))
            ->get();

        return view('department_admin.forms.approval', compact('form'));
    }

    public function detailApproval($id){
        $form = Form::where('is_active', config('setting.active.is_active'))->where('id',$id)->first();
        //array file attachment
        $fileString = Form::where('id', $id)->first();
        $arrayFileDecode = array();
        if(isset($fileString['link'])){
            $arrayFileDecode = json_decode($fileString['link']);
        }

        return view('department_admin.forms.detail_approval', compact('form', 'arrayFileDecode'));
    }
    public function acceptApproval($id){
        try
        {
            Form::where('id',$id)->update(['approved_by' => Auth::user()->id, 'sent_date' => Carbon::now()]);

            return redirect()->route('forms.approval')->with('messageSuccess', 'Duyệt Thành Công');
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('messageFail', "Duyệt Thất Bại");
        }
    }

    public function cancelApproval($id){
        try
        {
        	Form::findorFail($id)->delete();
            return redirect()->route('forms.approval')->with('messageSuccess', 'Hủy Duyệt Thành Công');
        }
        catch (Exception $exception)
        {
            return redirect()->back()->with('messageFail', "Hủy Duyệt Thất Bại");
        }
    }

    public function archiveIndex(){
    	$idDepartment = DepartmentUser::where('user_id', Auth::user()->id)->first()->department_id;
        $forms = Form::where(['is_active' => config('setting.active.no_active'), 'department_id' => $idDepartment ])->get();

        return view('department_admin.forms.archive', compact( 'forms'));
    }

    public function restore($id){
        DB::beginTransaction();
        try
        {
            Form::find($id)->update(['is_active' => config('setting.active.is_active')]);
            DB::commit();

            return redirect()->route('forms.archive')->with('messageSuccess', 'Hoàn Tác Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('forms.archive')->with('messageFail', 'Hoàn Tác Thất Bại');
        }
    }

    public function show($id)
    {
        try
        {
            //array file attachment
            $fileString = Form::where('id', $id)->first();
            $arrayFileDecode = array();
            if(isset($fileString['link'])){
                $arrayFileDecode = json_decode($fileString['link']);
            }

            $forms = Form::where('id',$id)->first() ;

            return view('department_admin.forms.edit', compact('forms', 'arrayFileDecode'));
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
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FormManagementRequest $request, $id)
    {
        $input = $request->all();
        DB::beginTransaction();
        try
        {
            if(!isset($input['link'])){
                Form::find($id)->update(['name' => $input['name'], 'description' => $input['description']]);
            }
            else {
                $path = 'upload/files/form';
                $dataOfForm = Form::find($id)->link;
                $this->uploader->checkOldImg($dataOfForm, true, $path);
                $arrFiles = $this->uploader->saveFileAttach($input['link'],$path);
                $input['link'] = json_encode($arrFiles);
                Form::find($id)->update($input);
            }
            DB::commit();

            return redirect()->route('forms.index')->with('messageSuccess', 'Cập Nhật Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->route('forms.index')->with('messageFail', 'Cập Nhật Thất Bại');
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
            $forms = Form::findOrFail($id);
            $forms->update(['is_active' => config('setting.active.no_active')]);
            DB::commit();

            return redirect()->route('forms.index')->with('messageSuccess', 'Xóa Thành Công');
        }
        catch (Exception $exception)
        {
            DB::rollBack();
            return redirect()->back()->with('messageFail', 'Xóa Thất Bại');
        }
    }
}
