<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_jabatan_pro extends Model
{
  protected $table = 'm_jabatan_pro';
  protected $primaryKey = 'c_id';
  protected $fillable = [ 'c_id',
                          'c_jabatan_pro',
                          'c_isactive'
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'created_at';
  const UPDATED_AT = 'updated_at';
}
