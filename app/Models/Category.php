<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    protected $table = 'categories';
    protected $guarded = [];

    public function children() {
		return $this->hasMany(static::class, 'parent_id');
    }
    
    public function allCategories()
	{
		return $this::with(array(
    				'children' => function ($query) {
        			$query->orderBy('category', 'asc');
   		 			}
					))->where('parent_id', 0)
					->orderBy('category', 'asc')->get();
	}
}