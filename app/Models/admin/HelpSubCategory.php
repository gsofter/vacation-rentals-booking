<?php

namespace App\Models\admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\admin\HelpCategory;

class HelpSubCategory extends Model
{
	
	protected $table = 'help_subcategory';

    public $timestamps = false;

    public function getCategoryNameByCategoryID(){
        return HelpCategory::where('id', $this->category_id)->first()->name;
    }
}
