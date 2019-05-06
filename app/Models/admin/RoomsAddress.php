<?php


namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;


class RoomsAddress extends Model
{
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'rooms_address';

	public $timestamps = false;

	protected $primaryKey = 'room_id';

	protected $appends = ['country_name','steps_count'];

	protected $fillable = ['city', 'state'];


}
