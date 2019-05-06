<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\admin\AmenitiesType;

class Amenities extends Authenticatable
{
    protected $table = 'amenities';

    public $timestamps = false;

    public function getTypeNameByTypeID(){
        return AmenitiesType::where('id', $this->type_id)->first()->name;
    }
}