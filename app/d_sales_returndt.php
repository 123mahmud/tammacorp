<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales_returndt extends Model
{
    protected $table = 'd_sales_returndt';
    protected $primaryKey = 'dsrdt_idsr';
    
	protected $fillable = [	
							'dsrdt_idsr',
							'dsrdt_smdt', 
							'dsrdt_item',
							'dsrdt_qty',
							'dsrdt_qty_confirm',
							'dsrdt_price',
							'dsrdt_disc_percent',
							'dsrdt_disc_vpercent',
							'dsrdt_disc_vpercentreturn',
							'dsrdt_disc_value',
							'dsrdt_return_price',
							'dsrdt_hasil'];

	const CREATED_AT = 'dsrdt_created';
    const UPDATED_AT = 'dsrdt_updated';
	public $timestamps = false;
}
