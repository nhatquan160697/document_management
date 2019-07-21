<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\DepartmentUser;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'birth_date',
        'gender',
        'address',
        'phone',
        'avatar',
        'is_active',
        'role',
        'delegacy',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function departmentUser()
    {
        return $this->hasMany(DepartmentUser::class);
    }

    public function reply()
    {
        return $this->hasMany(ReplyDocument::class);
    }

    public function documentUser()
    {
        return $this->hasMany(DocumentUser::class);
    }

    public function form()
    {
        return $this->hasMany(Form::class);
    }

    public function timeTable()
    {
        return $this->hasMany(TimeTable::class);
    }

    public function scheduleWeek()
    {
        return $this->hasMany( ScheduleWeek::class);
    }
}
