<?php

namespace App\Model\Hrd;

use Illuminate\Database\Eloquent\Model;

class d_potongan extends Model
{
    protected $table = 'd_potongan';
    protected $primaryKey = 'd_pot_id';
    const CREATED_AT = 'd_pot_created';
    const UPDATED_AT = 'd_pot_updated';
    
    protected $fillable = [
        'd_pot_id', 
        'd_pot_pid',
        'd_pot_prollid',
        'd_pot_keterangan',
        'd_pot_date',
        'd_pot_value'
    ];
}
