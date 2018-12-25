<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class m_item_price extends Model
{
    protected $table = 'm_item_price';
    protected $primaryKey = 'ip_group';
    protected $fillable = [ 'ip_group', 
                            'ip_item',
                            'ip_price'
                        ];

    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
}
