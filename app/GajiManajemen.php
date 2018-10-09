<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GajiManajemen extends Model
{
    protected $table = 'm_gaji_man' ;
    
    protected $fillable = [
        'nm_gaji','c_sd','c_smp','c_sma','c_smk','c_d1','c_d2','c_d3','c_s1','c_jabatan'
    ];
}
