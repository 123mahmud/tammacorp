<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class abs_pegawai_man extends Model
{
  protected $table = 'abs_pegawai_man';
  protected $primaryKey = 'apm_id';
  protected $fillable = [ 'apm_id',
                          'apm_pm',
                          'apm_tanggal',
                          'apm_jam_kerja',
                          'apm_jam_masuk',
                          'apm_jam_pulang',
                          'apm_scan_masuk',
                          'apm_scan_pulang',
                          'apm_terlambat',
                          'apm_plg_cepat',
                          'apm_absent',
                          'apm_lembur',
                          'apm_jml_jamkerja',
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'apm_insert';
  const UPDATED_AT = 'apm_update';
}
