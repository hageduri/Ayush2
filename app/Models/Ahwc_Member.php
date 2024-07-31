<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ahwc_Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'nin',
        'name',
        'gender',
        'dob',
        'address',
        'contact_1',
        'contact_2',
        'email',
        'designation',
        'bank_name',
        'account_no',
        'ifsc_code',
        'status',
    ];
}
