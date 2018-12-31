<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_price_group extends Model
{
    protected $table = 'm_price_group';
    protected $primaryKey = 'pg_id';
    protected $fillable = [ 'pg_id', 
                            'pg_name',
                            'pg_active'
                        ];

    public $incrementing = false;
    public $remember_token = false;
    //public $timestamps = false;
    const CREATED_AT = 'pg_created';
    const UPDATED_AT = 'pg_updated';
}
