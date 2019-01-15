<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class spk_formula extends Model
{
	protected $table = 'spk_formula';
    protected $fillable = [	'fr_spk', 
    						'fr_detailid', 
    						'fr_formula', 
    						'fr_value',
    						'fr_scale',
    						'fr_hpp'];
    public $timestamps = false;
}
