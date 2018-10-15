<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_ubah_jenisdt extends Model
{
    protected $table = 'd_ubah_jenisdt';
    protected $primaryKey = 'd_ujdt_id';
    const CREATED_AT = 'd_ujdt_created';
    const UPDATED_AT = 'd_ujdt_updated';
    
    protected $fillable = [
        'd_ujdt_id', 
        'd_ujdt_ujid', 
        'd_ujdt_item',
        'd_ujdt_sat',
        'd_ujdt_qty',
        'd_ujdt_price',
        'd_ujdt_pricetotal',
        'd_ujdt_keterangan'
    ];
}
