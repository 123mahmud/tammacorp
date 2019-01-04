<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_satuan extends Model
{
    protected $table = 'm_satuan';
    protected $primaryKey = 'm_sid';
    protected $fillable = [ 'm_sid', 
                            'm_scode', 
                            'm_sname', 
                            'm_sdetname',
                        	'm_isactive'];

    //public $timestamps = false;
    const CREATED_AT = 'm_screate';
    const UPDATED_AT = 'm_supdate';
}
