<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales_dt extends Model
{
    protected $table = 'd_sales_dt';
    protected $primaryKey = 'sd_sales';
    
      protected $fillable = ['sd_sales',
      						 'sd_item',
      						 'sd_qty', 
      						 'sd_price',
      						 'sd_disc_percent',
                   'sd_disc_vpercent',
      						 'sd_disc_value',
      						 'sd_total'];
		public $timestamps = false;
}
