<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_pegawai_pro extends Model
{
  protected $table = 'm_pegawai_pro';
  protected $primaryKey = 'd_hg_id';
  protected $fillable = [ 'd_hg_id',
                          'd_hg_pid',
                          'd_hg_tgl',
                          'd_hg_jumbo_r',
                          'd_hg_jumbo_l',
                          'd_hg_tb_r',
                          'd_hg_tb_l',
                          'd_hg_ts_r',
                          'd_hg_ts_l',
                          'd_hg_tm_r',
                          'd_hg_tm_l',
                          'd_hg_tc_r',
                          'd_hg_tc_l'
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'd_hg_created';
  const UPDATED_AT = 'd_hg_updated';
}
