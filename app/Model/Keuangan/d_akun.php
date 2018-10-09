<?php

namespace App\Model\Keuangan;

use Illuminate\Database\Eloquent\Model;

class d_akun extends Model
{
     protected $table = "d_akun";
	  protected $primaryKey = "id_akun";
	  public $incrementing = false;

     public function group(){
      return $this->hasMany('App\Model\Keuangan\d_akun', 'kelompok_akun', 'kelompok_akun');
     }

	  public function jurnal_detail(){
         return $this->hasMany('App\Model\Keuangan\d_jurnal_dt', 'jrdt_acc', 'id_akun');
      }

      public function mutasi_bank_debet(){
         return $this->hasMany('App\Model\Keuangan\d_jurnal_dt', 'jrdt_acc', 'id_akun');
      }

      public function mutasi_bank_kredit(){
         return $this->hasMany('App\Model\Keuangan\d_jurnal_dt', 'jrdt_acc', 'id_akun');
      }

      public function mutasi_kas_debet(){
         return $this->hasMany('App\Model\Keuangan\d_jurnal_dt', 'jrdt_acc', 'id_akun');
      }

      public function mutasi_kas_kredit(){
         return $this->hasMany('App\Model\Keuangan\d_jurnal_dt', 'jrdt_acc', 'id_akun');
      }

      public function mutasi_memorial_debet(){
         return $this->hasMany('App\Model\Keuangan\d_jurnal_dt', 'jrdt_acc', 'id_akun');
      }

      public function mutasi_memorial_kredit(){
         return $this->hasMany('App\Model\Keuangan\d_jurnal_dt', 'jrdt_acc', 'id_akun');
      }
}
