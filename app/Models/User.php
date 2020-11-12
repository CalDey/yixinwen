<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Encore\Admin\Traits\DefaultDatetimeFormat;

class User extends Authenticatable
{
    use Notifiable;
    use DefaultDatetimeFormat;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','introduction','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute($value)
    {
        if(empty($value)){
            return "https://cdn.learnku.com/uploads/images/201709/20/1/PtDKbASVcz.png?imageView2/1/w/600/h/600";
        }
        return $value;
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

}
