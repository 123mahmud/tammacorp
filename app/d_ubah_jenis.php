<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_ubah_jenis extends Model
{
    protected $table = 'd_ubah_jenis';
    protected $primaryKey = 'd_uj_id';
    const CREATED_AT = 'd_uj_created';
    const UPDATED_AT = 'd_uj_updated';
    
    protected $fillable = [
        'd_uj_id', 
        'd_uj_code', 
        'd_uj_date',
        'd_uj_staff',
        'd_uj_gdg'
    ];
}
