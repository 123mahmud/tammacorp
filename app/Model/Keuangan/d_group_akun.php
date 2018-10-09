<?php

namespace App\Model\keuangan;

use Illuminate\Database\Eloquent\Model;

class d_group_akun extends Model
{
    protected $table = "d_group_akun";
	protected $primaryKey = "id_group";
	public $incrementing = false;

	public function akun_neraca(){
		return $this->hasMany('App\Model\Keuangan\d_akun', 'group_neraca', 'no_group');
	}

	public function akun_laba_rugi(){
		return $this->hasMany('App\Model\Keuangan\d_akun', 'group_laba_rugi', 'no_group');
	}
}
