<?php

namespace App\Http\Controllers\Produksi;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Auth;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;

class RencanaProduksiController extends Controller
{
  public function tabel(){
    $pp = DB::Table('m_item')
          ->join('d_productplan','m_item.i_id','=','d_productplan.pp_item')
          ->where('pp_isspk','N')
          ->get();

    $datax = $this->setData($pp);

    echo json_encode($datax);
  }

  public function produksi(){
    if (Auth::user()->punyaAkses('Rencana Produksi','ma_read')) {
      return view('produksi.rencanaproduksi.index');
    }else{
      return view('system.hakakses.errorakses');
    }
  }

  public function save(Request $request){
    // dd($request->all());
    $i_name = DB::Table('m_item')
            ->where('i_name',$request->namaitem)
            ->get();

    $maxid = DB::Table('d_productplan')->select('pp_id')->max('pp_id')+1;

    $date = date("Y-m-d", strtotime($request->pp_date));
    $data = array(
              'pp_id'   => $maxid,
              'pp_date' => $date,
              'pp_item' => $i_name[0]->i_id,
              'pp_qty'  => $request->pp_qty,
            );
    //return $data;
    //*dd($data);/*
    $crud = $request->crud;
    if($crud == 'tambah'){
      $simpan = DB::Table('d_productplan')
            ->insert($data);
    }
    if($crud == 'edit'){
      $data['pp_id'] = $request->pp_id;
      $simpan = DB::Table('d_productplan')
            ->where('pp_id',$request->pp_id)
            ->update($data);
    }
    if($simpan == TRUE){
            $result['error']='';
            $result['result']=1;
    }else{
            $result['error']=$data;
            $result['result']=0;
    }
    $result['crud']=$crud;
    echo json_encode($result);

  }

  public function hapus_rencana($id){
    $hapus = DB::Table('d_productplan')
            ->where('d_productplan.pp_id',$id)
            ->delete();

    if($hapus == TRUE){
            $result['error']='';
            $result['result']=1;
    }else{
            $result['error']=$hapus;
            $result['result']=0;
    }
    echo json_encode($result);
  }

  public function edit_rencana(Request $request){
    $i_name = DB::Table('m_item')
            ->where('i_name',$request->namaitem)
            ->get();

    $pplan = DB::Table('d_productplan')
            ->where('pp_id',$request->pp_id)
            ->update([
              'pp_item' => $i_name[0]->i_id,
              'pp_qty'  => $request->pp_qty,
            ]);

    return redirect('produksi/rencanaproduksi/produksi');

  }

  public function autocomplete(Request $request){
      $term = $request->term;
      $results = array();
      $queries = DB::table('m_item')
        ->where('m_item.i_name', 'LIKE', '%'.$term.'%')
        ->where('i_isactive','TRUE')
        ->where('i_type','BP')
        ->take(150)->get();

      if ($queries == null) {
        $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
      } else {
        foreach ($queries as $query)
        {
          $results[] = [ 'id' => $query->i_id, 'label' => $query->i_name];
        }
      }

      return Response::json($results);
  }

  public function setData($pp){
    $data = array();
    foreach ($pp as $r) {
      $data[] = (array) $r;
    }
    $i=0;
    foreach ($data as $key) {
            // add new button
      $data[$i]['button'] = ' <div class="text-center">
                                   <button class="btn btn-warning btn-sm btn-flat fa fa-edit edit"
                                                  data-toggle="modal"
                                                  data-target="#myModal"
                                                  data-name="'.$key['i_name'].'"
                                                  data-id="'.$key['pp_id'].'"
                                                  data-qty="'.$key['pp_qty'].'">
                                      </button>
                                      <button class="btn btn-info btn-sm"
                                              title="Buat SPK"
                                              onclick=BuatSpk("'.$key['pp_id'].'","'.date('d-m-Y',strtotime($key['pp_date'])).'","'.$key['pp_qty'].'","'.$key['pp_item'].'")>
                                              <i class="fa fa-plus"></i>
                                      </button>
                                      <button id="hapus"
                                                  data-name="'.$key['i_name'].'"
                                                  data-id="'.$key['pp_id'].'"
                                                  class="fa fa-trash-o hapus btn btn-danger btn-sm">
                                      </button>
                              </div> ';
      $data[$i]['pp_date']='<span class="hide">'.$key['pp_date'].'</span>'.Date('d M Y', strtotime($key['pp_date']));
      $i++;
    }
    $datax = array('data' => $data);
    return $datax;

  }
}
