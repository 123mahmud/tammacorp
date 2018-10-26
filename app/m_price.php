<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_price extends Model
{
    protected $table = 'm_price';
    protected $primaryKey = 'm_pid';
    protected $fillable = [ 'm_pid', 
                            'm_pitem', 
                            'm_pbuy1',
                            'm_pbuy2',
                            'm_pbuy3', 
                            'm_psell1',
                            'm_psell2',
                            'm_psell3',
                            'm_hpp',
                            'm_barang_rusak'];
                            
    const CREATED_AT = 'm_pcreated';
    const UPDATED_AT = 'm_pupdated';
}
