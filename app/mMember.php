<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;
use Auth;

class mMember extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        CanResetPassword;

    protected $table = 'd_mem';
    protected $primaryKey = 'm_id';

    protected $fillable = [ 'm_id',
                            'm_pegawai_id',
                            'm_username',
                            'm_passwd',
                            'm_name',
                            'm_birth_tgl',
                            'm_addr',
                            'm_reff',
                            'm_lastlogin',
                            'm_lastlogout'];

    public $incrementing = false;
    public $remember_token = false;

    const UPDATED_AT = 'm_update';
    const CREATED_AT = 'm_insert';


    public function punyaAkses($menu,$field){

        $auth=Auth::user()->m_id;
        $cek = DB::select("select * from d_mem join d_mem_access
          on d_mem.m_id=d_mem_access.ma_mem
          join d_access on d_access.a_id=d_mem_access.ma_access
          where a_name='$menu' and ".$field."='Y' and ma_mem='$auth'");
        // dd($cek);

        if(count($cek) != 0)
            return true;
        else
            return false;

    }

}
