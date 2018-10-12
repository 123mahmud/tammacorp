<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class abs_pegawai_pro extends Model
{
  protected $table = 'abs_pegawai_pro';
  protected $primaryKey = 'app_id';
  protected $fillable = [ 'app_pp',
                          'app_pm',
                          'app_tanggal',
                          'app_jam_kerja',
                          'app_jam_masuk',
                          'app_jam_pulang',
                          'app_scan_masuk',
                          'app_scan_pulang',
                          'app_terlambat',
                          'app_plg_cepat',
                          'app_absent',
                          'app_lembur',
                          'app_jml_jamkerja',
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'app_insert';
  const UPDATED_AT = 'app_updated';
}
