<?php

namespace App\Http\Controllers\Master;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use DataTables;
use URL;

// use App\mmember

class BrgsupController extends Controller
{
    public function index()
    {
        return view('master.databrgsup.index');
    }

    public function get_datatable_index()
    {
        $data = DB::table('d_barang_sup')
                ->join('m_item', 'd_barang_sup.d_bs_itemid', '=', 'm_item.i_id')
                ->join('d_supplier', 'd_barang_sup.d_bs_supid', '=', 'd_supplier.s_id')
                ->select('d_barang_sup.*',
                         'm_item.i_name',
                         'm_item.i_code',
                         'd_supplier.s_name',
                         DB::raw('count(d_bs_detailid) as qty_sup'))
                ->where('m_item.i_isactive', 'TRUE')
                ->groupBy('d_bs_itemid')
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($data) 
        {  
           return  '<button onclick=detail("'.$data->d_bs_itemid.'") class="btn btn-success btn-sm" title="Detail">
                        <i class="fa fa-info-circle"></i>
                    </button>
                    <button onclick=edit("'.$data->d_bs_itemid.'") class="btn btn-warning btn-sm" title="Edit">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button onclick=hapus("'.$data->d_bs_itemid.'") class="btn btn-danger btn-sm" title="Hapus">
                        <i class="fa fa-times-circle"></i>
                    </button>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function tambah_barang()
    {
        $sup = DB::table('d_supplier')->count();
        $mod = $sup % 2;
        if ($mod == 0) {
            $part = $sup / 2;
            $data_sup1 = DB::table('d_supplier')->select('s_id', 's_company')->orderBy('s_company', 'ASC')->limit($part)->get();
            $data_sup2 = DB::table('d_supplier')->select('s_id', 's_company')->orderBy('s_company', 'DESC')->limit($part)->get();
        }else{
            $part1 = ($sup-$mod) / 2;
            $part2 = $part1 + $mod;
            $data_sup1 = DB::table('d_supplier')->select('s_id', 's_company')->orderBy('s_company', 'ASC')->limit($part1)->get();
            $data_sup2 = DB::table('d_supplier')->select('s_id', 's_company')->orderBy('s_company', 'DESC')->limit($part2)->get();
        }
        return view('master.databrgsup.tambah_barang', [ 'data1' => $data_sup1, 'data2' => $data_sup2 ]);
    }

    public function tambah_supplier()
    {
        return view('master.databrgsup.tambah_supplier');
    }

    public function autocompleteBarang(Request $request)
    {
        $term = $request->term;
        $results = array();
        $queries = DB::table('m_item')
            ->select('i_id','i_type','i_sat1','i_sat2','i_sat3','i_code','i_name')
            ->where('i_name', 'LIKE', '%'.$term.'%')
            ->where('i_type', '<>', 'BP')
            ->take(10)->get();

        foreach ($queries as $val) {
            if ($queries == null) {
                $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
            } 
            else {
                $results[] = [ 'id' => $val->i_id, 'label' => $val->i_code .'  '.$val->i_name, 'kode' => $val->i_code ];
            }
        }

        return Response::json($results);
    }

    public function autocompleteSupplier(Request $request)
    {
        $term = $request->term;
        $results = array();
        $queries = DB::table('d_supplier')
            ->select('s_id','s_company')
            ->where('s_company', 'LIKE', '%'.$term.'%')
            ->take(10)->get();
      
        foreach ($queries as $val) {
            if ($queries == null) {
                $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
            } 
            else {
                $results[] = [ 'id' => $val->s_id, 'label' => $val->s_company ];
            }
        }

        return Response::json($results);
    }

    public function simpan_barang(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {               
            for ($i=0; $i < count($request->form_cek); $i++) 
            { 
                $lastIdDet = DB::select(DB::raw("SELECT IFNULL((SELECT d_bs_detailid FROM d_barang_sup where d_bs_itemid = '$request->idbrg' ORDER BY d_bs_detailid DESC LIMIT 1) ,'0') as zz"));
                if ($lastIdDet[0]->zz == 0 || $lastIdDet[0]->zz == '0') {
                    $detailid = 1;
                }
                else {
                    $detailid = (int)$lastIdDet[0]->zz + 1;
                }

                $simpan = DB::table('d_barang_sup')
                    ->insert([
                        'd_bs_itemid'   => $request->idbrg,
                        'd_bs_detailid' => $detailid,
                        'd_bs_supid'    => $request->form_cek[$i],
                        'd_bs_created'  => Carbon::now('Asia/Jakarta')
                    ]);
            }

            DB::commit();
            if ($simpan) {
                $request->session()->flash('sukses', 'Data relasi barang ke supplier berhasil disimpan');
            }
            
            return redirect('master/databrgsup/index');
        } 
        catch (\Exception $e) 
        {
          DB::rollback();
          $request->session()->flash('gagal', 'Data relasi barang ke supplier gagal disimpan');
          return redirect('master/databrgsup/index');
        }
    }

    public function edit_barang(Request $request)
    {
        $sup = DB::table('d_supplier')->count();
        $mod = $sup % 2;
        if ($mod == 0) {
            $part = $sup / 2;
            $data_sup1 = DB::table('d_supplier')->select('s_id', 's_company')->orderBy('s_company', 'ASC')->limit($part)->get();
            $data_sup2 = DB::table('d_supplier')->select('s_id', 's_company')->orderBy('s_company', 'DESC')->limit($part)->get();
        }else{
            $part1 = ($sup-$mod) / 2;
            $part2 = $part1 + $mod;
            $data_sup1 = DB::table('d_supplier')->select('s_id', 's_company')->orderBy('s_company', 'ASC')->limit($part1)->get();
            $data_sup2 = DB::table('d_supplier')->select('s_id', 's_company')->orderBy('s_company', 'DESC')->limit($part2)->get();
        }

        $data = DB::table('d_barang_sup')
                    ->join('m_item', 'd_barang_sup.d_bs_itemid', '=', 'm_item.i_id')
                    ->join('d_supplier', 'd_barang_sup.d_bs_supid', '=', 'd_supplier.s_id')
                    ->select('d_barang_sup.*', 'm_item.i_name', 'm_item.i_code', 'd_supplier.s_name')
                    ->where('d_bs_itemid','=',$request->id)->get();

        return view('master/databrgsup/edit-barang', ['data' => $data, 'datasup1' => $data_sup1, 'datasup2' => $data_sup2 ]);
    }

    public function detail_barang(Request $request)
    {
        $data = DB::table('d_barang_sup')
                    ->join('d_supplier', 'd_barang_sup.d_bs_supid', '=', 'd_supplier.s_id')
                    ->join('m_item', 'd_barang_sup.d_bs_itemid', '=', 'm_item.i_id')
                    ->select('d_barang_sup.*', 'm_item.i_name', 'm_item.i_code', 'd_supplier.s_company', 'd_supplier.s_address')
                    ->where('d_bs_itemid','=',$request->id)->get();

        return response()->json([
          'data' => $data
      ]);
    }

    public function update_barang(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            $dt_created = DB::table('d_barang_sup')->select('d_bs_created')->where('d_bs_itemid','=',$request->idbrg)->first();
            DB::Table('d_barang_sup')->where('d_bs_itemid','=',$request->idbrg)->delete();
            
            for ($i=0; $i < count($request->form_cek); $i++) 
            { 
                $lastIdDet = DB::select(DB::raw("SELECT IFNULL((SELECT d_bs_detailid FROM d_barang_sup where d_bs_itemid = '$request->idbrg' ORDER BY d_bs_detailid DESC LIMIT 1) ,'0') as zz"));
                if ($lastIdDet[0]->zz == 0 || $lastIdDet[0]->zz == '0') {
                    $detailid = 1;
                }
                else {
                    $detailid = (int)$lastIdDet[0]->zz + 1;
                }

                $simpan = DB::table('d_barang_sup')
                    ->insert([
                        'd_bs_itemid'   => $request->idbrg,
                        'd_bs_detailid' => $detailid,
                        'd_bs_supid'    => $request->form_cek[$i],
                        'd_bs_created'  => $dt_created->d_bs_created,
                        'd_bs_updated'  => Carbon::now('Asia/Jakarta')
                    ]);
            }

            DB::commit();
            if ($simpan) {
                $request->session()->flash('sukses', 'Data relasi barang ke supplier berhasil diupdate');
            }
            return redirect('master/databrgsup/index');
        }
        catch (\Exception $e) 
        {
          DB::rollback();
          $request->session()->flash('gagal', 'Data relasi barang ke supplier gagal diupdate');
          return redirect('master/databrgsup/index');
        }
    }

    public function delete_barang(Request $request)
    {
        DB::beginTransaction();
        try 
        {   
            DB::Table('d_barang_sup')->where('d_bs_itemid','=',$request->id)->delete();
            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Berhasil Dihapus'
            ]);          
        }
        catch (\Exception $e) 
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }
    }

    // =======================================================================================================================

    public function get_datatable_supplier()
    {
        $data = DB::table('d_supplier_brg')
                ->join('d_supplier', 'd_supplier_brg.d_sb_supid', '=', 'd_supplier.s_id')
                ->join('m_item', 'd_supplier_brg.d_sb_itemid', '=', 'm_item.i_id')
                ->select('d_supplier_brg.*',
                         'd_supplier.s_address',
                         'd_supplier.s_company',
                         DB::raw('count(d_sb_detailid) as qty_brg'))
                ->where('m_item.i_isactive', 'TRUE')
                ->groupBy('d_sb_supid')
                ->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($data) 
        {  
           return  '<button onclick=detailSup("'.$data->d_sb_supid.'") class="btn btn-success btn-sm" title="Detail">
                        <i class="fa fa-info-circle"></i>
                    </button>
                    <button onclick=editSup("'.$data->d_sb_supid.'") class="btn btn-warning btn-sm" title="Edit">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button onclick=hapusSup("'.$data->d_sb_supid.'") class="btn btn-danger btn-sm" title="Hapus">
                        <i class="fa fa-times-circle"></i>
                    </button>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function simpan_supplier(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {               
            for ($i=0; $i < count($request->ipid); $i++) 
            { 
                $lastIdDet = DB::select(DB::raw("SELECT IFNULL((SELECT d_sb_detailid FROM d_supplier_brg where d_sb_supid = '$request->idsup' ORDER BY d_sb_detailid DESC LIMIT 1) ,'0') as zz"));
                if ($lastIdDet[0]->zz == 0 || $lastIdDet[0]->zz == '0') {
                    $detailid = 1;
                }
                else {
                    $detailid = (int)$lastIdDet[0]->zz + 1;
                }

                $simpan = DB::table('d_supplier_brg')
                    ->insert([
                        'd_sb_supid'   => $request->idsup,
                        'd_sb_detailid' => $detailid,
                        'd_sb_itemid'    => $request->ipid[$i],
                        'd_sb_created'  => Carbon::now('Asia/Jakarta')
                    ]);
            }

            DB::commit();
            if ($simpan) {
                $request->session()->flash('sukses', 'Data relasi supplier ke barang berhasil disimpan');
            }
            return redirect('master/databrgsup/index');
        } 
        catch (\Exception $e) 
        {
          DB::rollback();
          $request->session()->flash('gagal', 'Data relasi supplier ke barang gagal disimpan');
          return redirect('master/databrgsup/index');
        }
    }

    public function edit_supplier(Request $request)
    {
        $data = DB::table('d_supplier_brg')
                    ->join('d_supplier', 'd_supplier_brg.d_sb_supid', '=', 'd_supplier.s_id')
                    ->join('m_item', 'd_supplier_brg.d_sb_itemid', '=', 'm_item.i_id')
                    ->select('d_supplier_brg.*', 'm_item.i_name', 'm_item.i_code', 'd_supplier.s_address',
                         'd_supplier.s_company')
                    ->where('d_sb_supid','=',$request->id)->get();

        return view('master/databrgsup/edit-supplier', ['data' => $data]);
    }

    public function get_form_supplier(Request $request)
    {
        $data = DB::table('d_supplier_brg')
                    ->join('m_item', 'd_supplier_brg.d_sb_itemid', '=', 'm_item.i_id')
                    ->select('d_supplier_brg.*', 'm_item.i_name', 'm_item.i_code')
                    ->where('d_sb_supid','=',$request->id)->get();

        return response()->json([
            'status' => 'sukses',
            'data' => $data
        ]);
    }

    public function update_supplier(Request $request)
    {
        //dd($request->all());
        DB::beginTransaction();
        try 
        {   
            $dt_created = DB::table('d_supplier_brg')->select('d_sb_created')->where('d_sb_supid','=',$request->idsup)->first();
            DB::Table('d_supplier_brg')->where('d_sb_supid','=',$request->idsup)->delete();
            
            for ($i=0; $i < count($request->ipid); $i++) 
            { 
                $lastIdDet = DB::select(DB::raw("SELECT IFNULL((SELECT d_sb_detailid FROM d_supplier_brg where d_sb_supid = '$request->idsup' ORDER BY d_sb_detailid DESC LIMIT 1) ,'0') as zz"));
                if ($lastIdDet[0]->zz == 0 || $lastIdDet[0]->zz == '0') {
                    $detailid = 1;
                }
                else {
                    $detailid = (int)$lastIdDet[0]->zz + 1;
                }

                $simpan = DB::table('d_supplier_brg')
                    ->insert([
                        'd_sb_supid'   => $request->idsup,
                        'd_sb_detailid' => $detailid,
                        'd_sb_itemid'    => $request->ipid[$i],
                        'd_sb_created'  => $dt_created->d_sb_created,
                        'd_sb_updated'  => Carbon::now('Asia/Jakarta')
                    ]);
            }

            DB::commit();
            if ($simpan) {
                $request->session()->flash('sukses', 'Data relasi supplier ke barang berhasil diupdate');
            }
            return redirect('master/databrgsup/index');
        }
        catch (\Exception $e) 
        {
          DB::rollback();
          $request->session()->flash('gagal', 'Data relasi supplier ke barang gagal diupdate');
          return redirect('master/databrgsup/index');
        }
    }

    public function delete_supplier(Request $request)
    {
        DB::beginTransaction();
        try 
        {
            DB::Table('d_supplier_brg')->where('d_sb_supid','=',$request->id)->delete();
            DB::commit();
            return response()->json([
              'status' => 'sukses',
              'pesan' => 'Data Berhasil Dihapus'
            ]);          
        }
        catch (\Exception $e) 
        {
          DB::rollback();
          return response()->json([
              'status' => 'gagal',
              'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
          ]);
        }
    }

    public function detail_supplier(Request $request)
    {
        $data = DB::table('d_supplier_brg')
                    ->join('d_supplier', 'd_supplier_brg.d_sb_supid', '=', 'd_supplier.s_id')
                    ->join('m_item', 'd_supplier_brg.d_sb_itemid', '=', 'm_item.i_id')
                    ->select('d_supplier_brg.*', 'm_item.i_name', 'm_item.i_code', 'd_supplier.s_company', 'd_supplier.s_address')
                    ->where('d_sb_supid','=',$request->id)->get();

        return response()->json([
          'data' => $data
      ]);
    }

}