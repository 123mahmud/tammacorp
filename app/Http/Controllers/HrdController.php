<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

class HrdController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function rekrut()
    {
        $query = DB::table('d_pelamar')->get();
        $statusApply = DB::table('d_pelamar_status')->get();
        //dd($status);
        return view('hrd/recruitment/rekrut', compact('query', 'statusApply'));
    }

    public function kpi()
    {
        return view('hrd/manajemenkpipegawai/kpi');

    }
    
    public function payroll()
    {
        return view('hrd/payroll/payroll');

    }
    public function tambah_payroll()
    {
        return view('hrd/payroll/tambah_payroll');

    }
    public function table()
    {
        return view('hrd/payroll/table');

    }

    public function karyawan()
    {
        return view('hrd/datakaryawan/karyawan');

    }
    public function admin()
    {
        return view('hrd/dataadministrasi/admin');

    }
    public function lembur()
    {
        return view('hrd/datalembur/lembur');

    }
    public function score()
    {
        return view('hrd/scoreboard/score');

    }
    public function training()
    {
        return view('hrd/training/training');

    }
	public function tambah_training()
    {
        return view('hrd/training/tambah_training');

    }
    
        public function datajabatan()
    {
        return view('hrd/datajabatan/datajabatan');

    }
    public function tambah_jabatan()
    {
        return view('hrd/datajabatan/tambah_jabatan');

    }
    public function edit_jabatan()
    {
        return view('hrd/datajabatan/edit_jabatan');

    }
    /*public function process_rekrut(){
        return view('hrd/recruitment/process_rekrut');
    }
    public function preview_rekrut(){
        return view('hrd/recruitment/preview_rekrut');
    }*/
}
