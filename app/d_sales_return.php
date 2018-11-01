<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales_return extends Model
{
	protected $table = 'd_sales_return';
    protected $primaryKey = 'dsr_id';
    
	protected $fillable = [	'dsr_id',
							'dsr_sid',
							'dsr_cus', 
							'dsr_code',
							'dsr_method',
							'dsr_jenis_return',
							'dsr_type_sales',
							'dsr_date',
							'dsr_price_return',
							'dsr_sgross',
							'dsr_disc_vpercent',
							'dsr_disc_value',
							'dsr_net',
							'dsr_status'];

	const CREATED_AT = 'dsr_created';
    const UPDATED_AT = 'dsr_updated';
	public $timestamps = false;
}
