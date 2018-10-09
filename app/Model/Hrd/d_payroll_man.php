<?php

namespace App\Model\Hrd;

use Illuminate\Database\Eloquent\Model;

class d_payroll_man extends Model
{
    protected $table = 'd_payroll_man';
    protected $primaryKey = 'd_pm_id';
    const CREATED_AT = 'd_pm_created';
    const UPDATED_AT = 'd_pm_updated';
    
    protected $fillable = [
        'd_pm_id', 
        'd_pm_code',
        'd_pm_pid', 
        'd_pm_date',
        'd_pm_periode',
        'd_pm_gapok',
        'd_pm_totaltun',
        'd_pm_totalpot',
        'd_pm_totalnett',
        'd_pm_iscetak',
        'd_pm_datecetak'
    ];
}
