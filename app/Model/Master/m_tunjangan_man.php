<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class m_tunjangan_man extends Model
{
    protected $table = 'm_tunjangan_man';
    protected $primaryKey = 'tman_id';
    const CREATED_AT = 'tman_created';
    const UPDATED_AT = 'tman_updated';
    
    protected $fillable = [
        'tman_id', 
        'tman_levelpeg',
        'tman_nama',
        'tman_periode',
        'tman_value'
    ];
}
