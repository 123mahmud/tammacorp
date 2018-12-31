<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_customer extends Model
{
	protected $table = 'm_customer';
    protected $primaryKey = 'c_id';
    protected $fillable = [	'c_id', 
    						'c_code', 
    						'c_name', 
    						'c_birthday',
                            'c_email', 
    						'c_hp1',
    						'c_hp2', 
    						'c_region',
                            'c_address',
                            'c_group',
                            'c_class',
                            'c_type',
                        	'c_isactive'];
                            
    //public $timestamps = false;
    const CREATED_AT = 'c_insert';
    const UPDATED_AT = 'c_update';
}
