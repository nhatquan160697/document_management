<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeAvatarRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\DepartmentAdmin\UserManagementRequest;
use App\Http\Requests\InformationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Uploaders\Uploader;

class Information extends Controller
{
    protected $uploader;

    public function __construct(Uploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function index(){
        return view('information');
    }

    public function indexAdmin(){
        return view('information_admin');
    }

    public function changePass(ChangePasswordRequest $request){
        $input = $request->all();
        $oldPass = User::where('id',Auth::user()->id)->first();
        if(Hash::check($input['oldpassword'],$oldPass['password']) == true){
            if ($input['newpassword'] == $input['confirmpassword']){
                User::where('id', Auth::user()->id)->update(['password' => bcrypt($input['newpassword'])]);

                if( Auth::user()->role == config('setting.roles.system_admin'))
                    return redirect()->route('profile.index-admin')->with('messageSuccess', 'Cập Nhật Thành Công');
                else
                    return redirect()->route('profile')->with('messageSuccess', 'Cập Nhật Thành Công');
            }
        }
        else{
            if( Auth::user()->role == config('setting.roles.system_admin'))
                return redirect()->route('profile.index-admin')->with('messageFail', 'Cập Nhật Thất Bại, Mật Khẩu Cũ Không Đúng');
            else
                return redirect()->route('profile')->with('messageFail', 'Cập Nhật Thất Bại, Mật Khẩu Cũ Không Đúng');
        }

    }

    public function ajaxFormEdit(){

        return view('ajax.information_form');
    }

    public function updateInfo(InformationRequest $request){
        $input = $request->all();
        User::where('id', Auth::user()->id)->update(['name' => $input['name'],'birth_date' => $input['birth_date'],'gender' => $input['gender'],'address' => $input['address'],'phone' => $input['phone']]);
        try {
            if (Auth::user()->role == config('setting.roles.system_admin')) {
                return redirect()->route('profile.index-admin')
                    ->with('messageSuccess', 'Cập Nhật Thành Công');
            }
            else {
                return redirect()->route('profile')
                    ->with('messageSuccess', 'Cập Nhật Thành Công');
            }
        }
        catch (Exception $exception)
        {
            if (Auth::user()->role == config('setting.roles.system_admin')) {
                return redirect()->route('profile.index-admin')
                    ->with('messageFail', 'Cập Nhật Thất Bại');
            }
            else {
                return redirect()->route('profile')
                    ->with('messageFail', 'Cập Nhật Thất Bại');
            }
        }
    }

    public function changeAvatar(ChangeAvatarRequest $request){
        $input = $request->avatar;
        $input = $this->uploader->saveImg($input);
        try {
            $dataOfUser = User::where('id', Auth::user()->id)->first()->avatar;
            $this->uploader->checkOldImg($dataOfUser,false,'/upload/images');
            User::where('id', Auth::user()->id)->update(['avatar' => $input]);
            if (Auth::user()->role == config('setting.roles.system_admin')) {
                return redirect()->route('profile.index-admin')
                    ->with('messageSuccess', 'Cập Nhật Thành Công');
            }
            else {
                return redirect()->route('profile')
                    ->with('messageSuccess', 'Cập Nhật Thành Công');
            }
        }
        catch (Exception $exception)
        {
            if (Auth::user()->role == config('setting.roles.system_admin')) {
                return redirect()->route('profile.index-admin')
                    ->with('messageFail', 'Cập Nhật Thất Bại');
            }
            else {
                return redirect()->route('profile')
                    ->with('messageFail', 'Cập Nhật Thất Bại');
            }
        }
    }
}
