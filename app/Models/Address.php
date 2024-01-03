<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model{


    use HasFactory;
  
    protected $table = 'addresses';
    protected $fillable = [
        'id_addres','id_user','name','Latitude','Longitude','created_at','updated_at','phone_addres','nots_addres'
    ];

 
}
