<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales extends Model
{
    protected $table = 'd_sales';
    protected $primaryKey = 's_id';
    const CREATED_AT = 's_insert';
    const UPDATED_AT = 's_update';
    
	protected $fillable = [	's_id',
							's_channel',
							's_date', 
							's_note',
							's_staff',
							's_customer',
							's_gross',
							's_disc_percent',
							's_disc_value',
							's_tax',
							's_jatuh_tempo',
							's_net',
							's_sisa',
							's_status'];
		public $timestamps = false;
}
