<?php

namespace App\Http\Controllers\master;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use DataTables;
use URL;
use App\m_customer;

// use App\mmember

class custController extends Controller
{

    public function cust()
    {
        return view('master.datacust.cust');
    }

    public function datatable_cust()
    {
        $list = DB::table('m_customer')
            ->select('c_id',
                    'c_code', 
                    'c_name', 
                    'c_birthday',
                    'c_email', 
                    'c_hp1',
                    'c_hp2', 
                    'c_region',
                    'c_address',
                    'c_group',
                    'c_class',
                    'c_type',
                    'c_isactive',
                    'pg_name')
            ->leftJoin('m_price_group','m_price_group.pg_id','=','c_group')
            ->get();
        // return $list;
        $data = collect($list);

        // return $data;

        return Datatables::of($data)
            ->addColumn('action', function ($data) {
                if ($data->c_isactive == 'TRUE') 
                {
                    return '<button id="edit" 
                            onclick="edit(this)" 
                            class="btn btn-warning btn-sm" 
                            title="Edit">
                            <i class="glyphicon glyphicon-pencil"></i>
                        </button>' . '
                        <button id="status'.$data->c_id.'" 
                            onclick="ubahStatus('.$data->c_id.')" 
                            class="btn btn-primary btn-sm" 
                            title="Aktif">
                            <i class="fa fa-check-square" aria-hidden="true"></i>
                        </button>';
                }
                else
                {
                    return  '<div class="text-center">'.
                        '<button id="status'.$data->c_id.'" 
                            onclick="ubahStatus('.$data->c_id.')" 
                            class="btn btn-danger btn-sm" 
                            title="Tidak Aktif">
                            <i class="fa fa-minus-square" aria-hidden="true"></i>
                        </button>'.
                    '</div>';
                }
                
            })
            ->addColumn('c_group', function ($data) {
                return $data->pg_name;
            })
            ->addColumn('c_hp1', function ($data) {
                return $data->c_hp1 .' / '. $data->c_hp2;
            })
            ->editColumn('c_birthday', function ($data) {
                return date('d M Y', strtotime($data->c_birthday));
            })
            ->editColumn('c_type', function ($data) {
                if ($data->c_type == "RT") {
                    return 'Retail';
                } elseif ($data->c_type == "GR") {
                    return 'Grosir';
                }
            })
            ->rawColumns(['action', 'confirmed', 'c_birthday'])
            ->make(true);
    }

    public function tambah_cust()
    {
        $groupPrice = DB::table('m_price_group')->where('pg_active','TRUE')->get();

        return view('/master/datacust/tambah_cust', compact('id_cust','groupPrice'));
    }

    public function simpan_cust(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $year = carbon::now()->format('y');
            $month = carbon::now()->format('m');
            $date = carbon::now()->format('d');
            $tanggal = date("Y-m-d h:i:s");

            $kode = DB::Table('m_customer')->max('c_id');

            if ($kode <= 0 || $kode <= '') {
                $kode = 1;
            } else {
                $kode += 1;
            }
            $id_cust = 'CUS' . $month . $year . '/' . 'C001' . '/' . $kode;
            if ($request->tgl_lahir == '') {
                DB::table('m_customer')
                    ->insert([
                        'c_id' => $kode,
                        'c_code' => $id_cust,
                        'c_name' => $request->nama_cus,
                        'c_type' => $request->tipe_cust,
                        'c_email' => $request->email,
                        'c_hp1' => '+62' . $request->no_hp1,
                        'c_hp2' => '+62' . $request->no_hp2,
                        'c_region' => $request->wilayah,
                        'c_address' => $request->alamat,
                        'c_group' => $request->c_group,
                        'c_class' => $request->c_class,
                        'c_insert' => $tanggal,
                    ]);
            } else {
                DB::table('m_customer')
                    ->insert([
                        'c_id' => $kode,
                        'c_code' => $id_cust,
                        'c_name' => $request->nama_cus,
                        'c_type' => $request->tipe_cust,
                        'c_birthday' => date('Y-m-d', strtotime($request->tgl_lahir)),
                        'c_email' => $request->email,
                        'c_hp1' => '+62' . $request->no_hp1,
                        'c_hp2' => '+62' . $request->no_hp2,
                        'c_region' => $request->wilayah,
                        'c_address' => $request->alamat,
                        'c_group' => $request->c_group,
                        'c_class' => $request->c_class,
                        'c_insert' => $tanggal,
                    ]);
            }


            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function hapus_cust(Request $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $edit_cust = DB::table('m_customer')
                ->where('c_code', '=', $request->id)
                ->delete();
            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
        return response()->json(['status' => 1]);
    }

    public function edit_cust(Request $request)
    {
        $edit_cust = DB::table('m_customer')->where('c_code', '=', $request->id)->first();
        $groupPrice = DB::table('m_price_group')->where('pg_active','TRUE')->get();
        json_encode($edit_cust);
        return view('master/datacust/edit_cust', compact('edit_cust','groupPrice'));
    }

    public function update_cust(Request $request)
    {
        DB::beginTransaction();
        try {
            $tanggal = date("Y-m-d h:i:s");
            if ($request->tgl_lahir == '') {
                DB::table('m_customer')
                    ->where('c_id', '=', $request->id_cus_ut)
                    ->update([
                        'c_name' => $request->nama_cus,
                        'c_type' => $request->tipe_cust,
                        'c_birthday' => null,
                        'c_email' => $request->email,
                        'c_hp1' => '+62' . $request->no_hp1,
                        'c_hp2' => '+62' . $request->no_hp2,
                        'c_region' => $request->wilayah,
                        'c_class' => $request->c_class,
                        'c_address' => $request->alamat,
                        'c_group' => $request->c_group,
                        'c_update' => $tanggal,
                    ]);
            }else{
                DB::table('m_customer')
                    ->where('c_id', '=', $request->id_cus_ut)
                    ->update([
                        'c_name' => $request->nama_cus,
                        'c_type' => $request->tipe_cust,
                        'c_birthday' => date('Y-m-d', strtotime($request->tgl_lahir)),
                        'c_email' => $request->email,
                        'c_hp1' => '+62' . $request->no_hp1,
                        'c_hp2' => '+62' . $request->no_hp2,
                        'c_region' => $request->wilayah,
                        'c_class' => $request->c_class,
                        'c_address' => $request->alamat,
                        'c_group' => $request->c_group,
                        'c_update' => $tanggal,
                    ]);
            }

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }

    public function ubahStatus(Request $request)
    {
        DB::beginTransaction();
        try {
        $cek = m_customer::select('c_isactive')
            ->where('c_id',$request->id)
            ->first();
        
        if ($cek->c_isactive == 'TRUE') 
        {
            m_customer::where('c_id',$request->id)
                ->update([
                    'c_isactive' => 'FALSE'                    
                ]);
        }
        else
        {
            m_customer::where('c_id',$request->id)
                ->update([
                    'c_isactive' => 'TRUE'
                ]);
        }
        DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
    }    


}
