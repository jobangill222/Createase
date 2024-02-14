<?php

namespace App\Models;

use App\Base\Model\BaseModel;

use App\Components\Helper;
use App\Constants\LogConstants;
use App\Constants\UserConstants;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    MustVerifyEmailContract,
    JWTSubject
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'phone_number',
        'phone_number_verified_at',
        'password',
        'country_id',
        'state_id',
        'city_id',
        'user_role_id',
        'status',
        'profile_pic',
        'referral_code',
        'referred_by',
        'user_agent',
        'remember_token',
        'created_at',
        'updated_at',
        'created_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        // 'phone_number_verified_at',
        // 'country_id',
        // 'state_id',
        // 'city_id',
        // 'user_role_id',
        'profile_pic',
        // 'referral_code',
        // 'referred_by',
        // 'user_agent',
        // 'created_ip',
        // 'created_at',
        // 'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function statusHtml()
    {
        $status = UserConstants::STATUS_PROPERTIES[$this->status];
        return Helper::printBadge($status['text'], $status['class']);
    }

    public function getProfilePicAttribute($bgColor = '')
    {
        if ($bgColor == null) {
            $bgColor = 'C7002B';
        }
        return 'https://ui-avatars.com/api/?size=450&background=' . $bgColor . '&color=fff&name=' . urlencode($this->display_name);
    }

    public function getDisplayNameAttribute()
    {
        if (trim($this->name) == null) {
            $emailExploded = explode('@', $this->email);
            return ucwords($emailExploded[0]);
        }
        return ucwords($this->name);
    }

    public function getIdentityNameAttribute()
    {
        return $this->username . ' (#' . $this->id . ')';
    }

    public function onCreating()
    {
        if ($this->status == null) {
            $this->status = UserConstants::STATUS_ACTIVE;
        }
        if ($this->referral_code == null) {
            $this->referral_code = Str::random(10);
        }
        $this->remember_token = Str::random(50);
        $this->password = Hash::make($this->password);
        parent::onCreating();
    }

    public function updatePassword($password)
    {
        $this->password = Hash::make($password);
        $this->save();
        $log = Log::create([
            'user_id' => $this->id,
            'particulars' => 'Password has been changed',
            'type' => LogConstants::USER_PASSWORD_CHANGE,
        ]);
        //Mail::to($this)->send(new PasswordChanged($log));
    }

    public function userLoginHistory()
    {
        return $this->hasMany(UserLoginHistory::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->hasOne(UserRole::class, 'id', 'user_role_id');
    }

    public function isAdmin()
    {
        if ($this->user_role_id == UserConstants::ROLE_ADMIN) {
            return true;
        }
        return false;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }


    public function userImages()
    {
        return $this->hasMany(UserImage::class, 'user_id');
    }


    public function getCurrentPartyAttribute()
    {
        if ($this->attributes['current_party']) {
            // return $this->belongsTo(Parties::class);
            return Parties::where('id', $this->attributes['current_party'])->first();
        }
    }

}
