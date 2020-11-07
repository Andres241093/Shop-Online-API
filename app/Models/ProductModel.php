<?php 
use \Illuminate\Database\Eloquent\Model;

class Product extends Model {
     
    protected $table = 'products';
    protected $fillable = ['name','price','star_1','star_2','star_3','star_4','star_5'];

}