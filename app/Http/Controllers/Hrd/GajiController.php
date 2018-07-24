<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GajiManajemen;
use DB;
use DataTables;
class GajiController extends Controller
{
    public function payroll(){
        return view('hrd/payroll/payroll');
    }
    public function settingGajiMan(){
        return view('hrd/payroll/setting_manajemen');
    }
    public function gajiManData(){
        $list = DB::table('m_gaji_man')
                ->get();
        $data = collect($list);
        return Datatables::of($data)           
                ->addColumn('action', function ($data) {
                         return  '<button id="edit" onclick="edit('.$data->c_id.')" class="btn btn-warning btn-sm" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button>'.'
                                        <button id="delete" onclick="hapus('.$data->c_id.')" class="btn btn-danger btn-sm" title="Hapus"><i class="glyphicon glyphicon-trash"></i></button>';
                })
                ->addColumn('none', function ($data) {
                    return '-';
                })
                ->addColumn('sma', function ($data) {
                    return '<div>Rp.
                      <span class="pull-right">
                        '.number_format( $data->c_sma ,2,',','.').'
                      </span>
                    </div>';
                })
                ->addColumn('d3', function ($data) {
                    return '<div>Rp.
                      <span class="pull-right">
                        '.number_format( $data->c_d3 ,2,',','.').'
                      </span>
                    </div>';
                })
                ->addColumn('s1', function ($data) {
                    return '<div>Rp.
                      <span class="pull-right">
                        '.number_format( $data->c_s1 ,2,',','.').'
                      </span>
                    </div>';
                })
                ->addColumn('pangkat', function ($data) {
                    if($data->c_jabatan == 1){
                        $pangkat = "Leader";
                    }elseif($data->c_jabatan == 2){
                        $pangkat = "Staf";
                    }else{
                        $pangkat = "Semua";
                    }
                    return $pangkat;
                })
                ->rawColumns(['action','sma','d3','s1'])
                ->make(true);
    }
    public function tambahGajiMan(){
        return view('hrd/payroll/tambah_set_manajemen');
    }
    public function simpanGajiMan(Request $request){
        $input = $request->all();
        $data = GajiManajemen::create($input);
        
        return redirect('/hrd/payroll/setting-gaji-man');
    }
    public function editGajiMan($id){
        $data = DB::table('m_gaji_man')->where('c_id', $id)->first();
        
        return view('hrd/payroll/edit_set_manajemen',['data' => $data]);
    }
    public function updateGajiMan(Request $request, $id){
        $input = $request->except('_token', '_method','jumlah');
        $data = GajiManajemen::where('c_id', $id)->update($input);
        
        return redirect('/hrd/payroll/setting-gaji-man');
    }
    public function deleteGajiMan($id){
        $data = DB::table('m_gaji_man')->where('c_id', $id)->delete();

        return redirect('/hrd/payroll/setting-gaji-man');
    }
}
