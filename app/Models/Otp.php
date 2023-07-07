<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    protected $fillable = [

        'id',
        'client',
        'otp_code',
        'created_at',
    ];

    protected $table = 'otp';

    public $timestamps = true;

    // public $timestamps = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

} 
