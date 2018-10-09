<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class d_pelatihan extends Model
{
  protected $table = 'd_pelatihan';
  protected $primaryKey = 'dp_id';
  protected $fillable = [ 'dp_id',
                          'dp_name'
                        ];

  public $incrementing = false;
  public $remember_token = false;
  //public $timestamps = false;
  const CREATED_AT = 'dp_created';
  const UPDATED_AT = 'dp_updated';
}
