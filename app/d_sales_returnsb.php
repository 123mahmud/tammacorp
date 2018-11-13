<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_sales_returnsb extends Model
{
	protected $table = 'd_sales_returnsb';
    protected $primaryKey = 'dsrs_sr';
    protected $fillable = [ 'dsrs_sr', 
                            'dsrs_detailid', 
                            'dsrs_item', 
                            'dsrs_qty'
                        	];

    public $incrementing = false;
    public $remember_token = false;

    const CREATED_AT = 'dsrs_created';
    const UPDATED_AT = 'dsrs_updated';
}
