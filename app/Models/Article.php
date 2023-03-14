<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    public $table='articles';

    public function categories(){
    	return $this->belongsToMany('App\Models\Category', 'article_category', 'article_id', 
    		'category_id');
    }
}
