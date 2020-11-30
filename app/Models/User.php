<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use Traits\LastActivedAtHelper;
    use Traits\ActiveUserHelper;
    use DefaultDatetimeFormat;
    use Notifiable {
        notify as protected laravelNotify;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password','introduction','avatar'
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
            return "https://cdn.learnku.com/uploads/images/201710/14/1/s5ehp11z6s.png";
        }
        return $value;
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    // public function notify($instance)
    // {
    //     // 如果要通知的人是当前用户，就不必通知了！
    //     if ($this->id == Auth::id()) {
    //         return;
    //     }

    //     // 只有数据库类型通知才需提醒，直接发送 Email 或者其他的都 Pass
    //     if (method_exists($instance, 'toDatabase')) {
    //         $this->increment('notification_count');
    //     }

    //     $this->laravelNotify($instance);
    // }

    // Notify改进
    public function topicNotify($instance)
{
    // 如果要通知的人是当前用户，就不必通知了！
    if ($this->id == Auth::id()) {
        return;
    }
    $this->increment('notification_count');
    $this->notify($instance);
}

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }

}
