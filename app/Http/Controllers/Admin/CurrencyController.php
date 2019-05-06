<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;

use App\Models\admin\Currency;
use App\Models\admin\RoomsPrice;
use App\Models\admin\SiteSettings;

class CurrencyController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }



    /**
     * @des: Manage  Currency 
     * @param: 
     * @return: view-> admin/currency/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function index()
    {           
        $data = Currency::get();        
        return view('admin/currency/index', compact('data'));
        
    }

    /**
     * @des: add  Property Type 
     * @param: Currency Add Form Data
     * @return: view-> admin/currency/add.blade.php  ///////  view-> admin/currency/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function add(Request $request)
	{
        if(!$_POST){
            
            return view('admin/currency/add');
            
		}else{
           
            $currency                     = new Currency;
            
            $currency->name               = $request->name;           
            $currency->code               = $request->code;     
            $currency->symbol             = $request->symbol;     
            $currency->rate               = $request->rate;     
            $currency->default_currency   = "0";     
            $currency->status             = $request->status;     
            $currency->save();           
            
            return redirect()->route('admin.currency')
                    ->with('success','New  Currency Added!');
			
		}
    }
        

    /**
     * @des: update  Currency 
     * @param: Currency Edit Form Data
     * @return: view-> admin/currency/edit.blade.php  ///////   view-> admin/currency/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function update(Request $request)
	{
		if(!$_POST){

			$currency       = Currency::find($request->id);	
            return view('admin/currency/edit', compact('currency'));
            
		}else{		           
           
            $currency                     = Currency::find($request->id);
            
            $currency->name               = $request->name;           
            $currency->code               = $request->code;     
            $currency->symbol             = $request->symbol;     
            $currency->rate               = $request->rate;     
            $currency->default_currency   = "0";     
            $currency->status             = $request->status;
            
            $currency->save();          

            return redirect()->route('admin.currency')
                    ->with('success','Currency Updated!');
			
		}
		
    }

    /**
     * @des: delete  Currency 
     * @param: delete
     * @return: view-> admin/currency/index.blade.php
     * @dev: Artemova
     * @date:2019/10/15 
    */
    public function delete(Request $request){

        Currency::find($request->did)->delete();
        return redirect()->route('admin.currency')
                ->with('success','Currency Deleted!');
    }
    



}