<?php

namespace App\Model\Hrd;

use Illuminate\Database\Eloquent\Model;

class d_payroll_mandt extends Model
{
    protected $table = 'd_payroll_mandt';
    protected $primaryKey = 'd_pmdt_id';
    const CREATED_AT = 'd_pmdt_created';
    const UPDATED_AT = 'd_pmdt_updated';
    
    protected $fillable = [
        'd_pmdt_id', 
        'd_pmdt_pmid',
        'd_pmdt_type', 
        'd_pmdt_typeid',
        'd_pmdt_nilai'
    ];
}
