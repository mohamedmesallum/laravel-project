<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestUser extends Model
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = [
        'id','name','email'	,'email_verified_at','password'	,'created_at','updated_at','image'
    ];
}
