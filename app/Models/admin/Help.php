<?php

namespace App\Models\admin;
use Illuminate\Database\Eloquent\Model;
use DB;
use App\Models\admin\HelpCategory;
use App\Models\admin\HelpSubCategory;

class Help extends Model
{	
	protected $table = 'help';

	public function getCategoryNameByCategoryID(){
        return HelpCategory::where('id', $this->category_id)->first()->name;
	}
	
	public function getSubCategoryNameByCategoryID(){
		$result = HelpSubCategory::where('id', $this->subcategory_id)->first();
		if($result) return $result->name;
		else return "";
    }
}
