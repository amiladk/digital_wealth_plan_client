<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'membership_no',
        'is_active',
        'email',
        'first_name',
        'last_name',
        'full_name',
        'country',
        'password',
        'sponsor',
        'sponsor_side',
        'left_child',
        'right_child',
        'parent',
        'client_title',
        'dob',
        'phone_number',
        'address',
        'nic_no',
        'identity_doc_type',
        'id_front',
        'id_back',
        'selfie',
        'client_fund_source',
        'kyc_submit_date',
        'kyc_approved_date',
        'kyc_status',
        'wallet',
        'holding_wallet',
        'left_bv_rewards',
        'right_bv_rewards',
        'left_head_count',
        'right_head_count',
        'kyc_status',
        'preffered_theme',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $table = 'client';


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */


    public function leftChild()
    {
        return $this->hasOne(self::class,'id','left_child');
    }

    public function rightChild()
    {
        return $this->hasOne(self::class,'id','right_child');
    }

    public function getParent()
    {
        return $this->hasOne(self::class,'id','parent');
    }

    public function country()
    {
        return $this->hasOne(Country::class,'id','country');
    }

    public function getClientTitle()
    {
        return $this->hasOne(ClientTitle::class,'id','client_title');
    }

    public function getClientFundSource()
    {
        return $this->hasOne(ClientFundSource::class,'id','client_fund_source');
    }

    public function getIdentityDocType()
    {
        return $this->hasOne(IdentityDocType::class,'id','identity_doc_type');
    }

    public function getSponsor()
    {
        return $this->hasOne(self::class,'id','sponsor');
    }

    public function getSponsorSide()
    {
        if ($this->sponsor_side==1) {
            return "Right";
        }else{
            return "Left";
        } 
    }

    public function headStatus()
    {
        if ($this->is_active==1) {
            return "Active";
        }else{
            return "Not Active";
        } 
    }

    public function getKyckycStatus()
    {
        return $this->hasOne(User::class,'id','kyc_status');
    }

    public function getFrontImage()
    {
        return $this->hasOne(Image::class,'id','id_front');
    }

    public function getBackImage()
    {
        return $this->hasOne(Image::class,'id','id_back');
    }

    public function getSelfieImage()
    {
        return $this->hasOne(Image::class,'id','selfie');
    }

}
