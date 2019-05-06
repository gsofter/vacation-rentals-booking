<?php

namespace App\Http\Controllers\Front\Help;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\admin\Help;
use App\Models\admin\HelpCategory;
use App\Models\admin\HelpSubCategory;

class HelpController extends Controller
{
    //

    public function searchHelp(Request $request){
       
            return Help::where('question', 'like', "%{$request["query"]}%")->get();
    }
    public function getQuestions(Request $request){
        return Help::where('subcategory_id', $request['sub_category_id'])->get();
    }
    public function getHelpListByCategory(){
        $help_categories = HelpCategory::all();
        $result_array = array();
        $category_array = array();
        foreach ($help_categories as $help_category) {
            # code...
            $sub_category_array = array();
            $help_subcategories = HelpSubCategory::where('category_id', $help_category->id)->get();
            foreach ($help_subcategories as $subcategory) {
                # code...
                $help_list = Help::where('category_id', $help_category->id)->where('subcategory_id', $subcategory->id)->get();
                $sub_category_array[] = array(
                    'category_id' => $help_category->id,
                    'category_name' => $help_category->name,
                    'category_description' => $help_category->description,
                    'sub_category_id' => $subcategory->id,
                    'sub_category_name' => $subcategory->name,
                    'sub_category_description' => $subcategory->description,
                    'questions' => $help_list

                );
            }
            $result_array[] = array(
                'category_id' => $help_category->id,
                'category_name' => $help_category->name,
                'category_description' => $help_category->description,
                'subcategories' => $sub_category_array
            );
        }
        return $result_array;
    }

    public function getSubcategories(Request $request){
        return HelpSubCategory::where('category_id', 1)->get();
    }
}
