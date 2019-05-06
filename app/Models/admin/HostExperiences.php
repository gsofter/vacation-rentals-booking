<?php


namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class HostExperiences extends Model
{
    protected $table = 'host_experiences';

    public $timestamps = true;

    protected $appends = ['is_reviewed', 'provides_count', 'packing_lists_count', 'changes_saved','photo_name','session_price','link','reviews_count','overall_star_rating','host_name'];

}
