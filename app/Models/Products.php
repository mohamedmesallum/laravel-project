<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['id','name','name_ar','image','description','description_ar','priec',
    'status','oldpriec','discount','categories_id','count','created_at','updated_at'
    ];
}
//	priec	status	oldpriec	discount	categories_id	image	count	created_at	updated_at	
