<?php

namespace App\Model\Hrd;

use Illuminate\Database\Eloquent\Model;

class d_kpix_dt extends Model
{
    protected $table = 'd_kpix_dt';
    protected $primaryKey = 'd_kpixdt_id';
    const CREATED_AT = 'd_kpixdt_created';
    const UPDATED_AT = 'd_kpixdt_updated';
    
    protected $fillable = [
        'd_kpixdt_id', 
        'd_kpixdt_dkpix_id',
        'd_kpixdt_mkpix_id', 
        'd_kpixdt_value',
        'd_kpixdt_score',
        'd_kpixdt_scoreakhir',
        'd_kpixdt_created',
        'd_kpixdt_updated'
    ];
}
