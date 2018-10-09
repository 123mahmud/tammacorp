<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_pengajuan_pelatihan extends Model
{
  protected $table = 'd_pengajuan_pelatihan';
  protected $primaryKey = 'pp_id';
  protected $fillable = [ 'pp_id',
                          'pp_code',
                          'pp_pm',
                          'pp_jabatan',
                          'pp_jenis_pelatihan',
                          'pp_nama_atasan',
                          'pp_status'
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'pp_created';
  const UPDATED_AT = 'pp_updated';
}
