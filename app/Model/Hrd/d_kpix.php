<?php

namespace App\Model\Hrd;

use Illuminate\Database\Eloquent\Model;

class d_kpix extends Model
{
    protected $table = 'd_kpix';
    protected $primaryKey = 'd_kpix_id';
    const CREATED_AT = 'd_kpix_created';
    const UPDATED_AT = 'd_kpix_updated';
    
    protected $fillable = [
        'd_kpix_id', 
        'd_kpix_code',
        'd_kpix_pid', 
        'd_kpix_date',
        'd_kpix_dateconfirm',
        'd_kpix_isconfirm',
        'd_kpix_scoretotal'
    ];
}
