<?php

namespace App\Http\Controllers;

use App\Models\DepartmentUser;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormsController extends Controller
{
    public function index()
    {
        $idDepartment = DepartmentUser::where('user_id', Auth::user()->id)->first()->department_id;
        $form = Form::where(['is_active' =>  config('setting.active.is_active'), 'department_id' => $idDepartment])
            ->where('approved_by', '!=', config('setting.approval.no_approved'))
            ->get();

        return view('forms.index', compact('form'));
    }

    public function show($id)
    {
        $form = Form::where('is_active', config('setting.active.is_active'))->where('id',$id)->first();
        //array file attachment
        $fileString = Form::where('id', $id)->first();
        $arrayFileDecode = array();
        if(isset($fileString['link'])){
            $arrayFileDecode = json_decode($fileString['link']);
        }

        return view('forms.detail', compact('form', 'arrayFileDecode'));
    }
}
