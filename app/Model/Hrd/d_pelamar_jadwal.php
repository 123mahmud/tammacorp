<?php

namespace App\Model\Hrd;

use Illuminate\Database\Eloquent\Model;

class d_pelamar_jadwal extends Model
{
    protected $table = 'd_pelamar_jadwal';
    protected $primaryKey = 'pj_id';
    const CREATED_AT = 'pj_created';
    const UPDATED_AT = 'pj_updated';
    
    protected $fillable = [
        'pj_id', 
        'pj_pid', 
        'pj_pmid',
        'pj_date',
        'pj_time',
        'pj_lokasi',
        'pj_isactive',
        'pj_review_i',
        'pj_review_p',
        'pj_created',
        'pj_updated'
    ];
}
