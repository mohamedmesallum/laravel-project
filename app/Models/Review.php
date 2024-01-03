<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
   protected $table = 'review';
    protected $fillable = [
        'id','id_user','ratings','comment','id_product','created_at','updated_at'
    ];
    //id	id_user	ratings	comment	creationTime	updated_at	id_product	

}
