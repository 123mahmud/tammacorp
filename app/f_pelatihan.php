<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class f_pelatihan extends Model
{
  protected $table = 'f_pelatihan';
  protected $primaryKey = 'fp_id';
  protected $fillable = [ 'fp_id',
                          'fp_soal',
                          'fp_status'
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'fp_insert';
  const UPDATED_AT = 'fp_update';
}
