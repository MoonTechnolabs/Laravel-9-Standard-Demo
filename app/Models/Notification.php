<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

class Notification extends Model{

    
    
    protected $status_code = 'status_code';
    protected $mes = 'message';
    
    protected $table = 'notification';
    protected $primaryKey = 'id';
    
    public function users(){
        return $this->hasOne(User::class,'id','user_id');
    }
    
    public function notifyuser(){
        return $this->hasOne(User::class,'id','notify_user_id');
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->setTimezone(auth()->user()->timezone)->format(config('const.phpDisplayDateTimeFormatWithAMPM')),
        );
    }

    
}
