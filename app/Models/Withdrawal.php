<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'client',
        'currency_type',
        'cypto_network',
        'wallet_address',
        'withdraw_amount',
        'transaction_fee',
        'recieving_amount',
    ];

    public $timestamps = false;

    protected $table = 'withdrawal';

    
    public function withdrawStatus()
    {
        if ($this->status==0) {
            return "Pending";
        }else if ($this->status==1) {
            return "Approved";
        }else{
            return "Not Approved";
        } 
    }

    public function getUser()
    {
        return $this->hasOne(User::class,'id','client');
    }


}
