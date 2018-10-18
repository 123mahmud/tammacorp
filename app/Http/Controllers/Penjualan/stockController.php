<?php 

namespace App\Http\Controllers\Penjualan;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Auth;
use Response;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\m_item;
use App\d_stock;
use DataTables;
use App\mMember;

class stockController extends Controller
{
  public function tableStock(){
    $data = m_item::
      select('i_name',
             'i_type',
             'm_gname',
             's_qty')
      ->join('m_group','m_group.m_gcode','=','i_code_group')
      ->leftjoin('d_stock',function($join){
        $join->on('i_id', '=', 's_item');        
        $join->on('s_comp', '=', 's_position');                
        $join->on('s_comp', '=',DB::raw("'1'"));           
      })    
      ->where('i_type', '=',DB::raw("'BJ'"))
      ->orWhere('i_type', '=',DB::raw("'BP'"))   
      ->where('i_isactive','TRUE')
      ->get();
      // dd($data[3]);
    return DataTables::of($data)
    ->editColumn('s_qty', function ($data)  {
          if ($data->s_qty == null) {
              return '0';
          }else{
              return $data->s_qty;
          }
      })
    ->addIndexColumn()
    ->make(true);
  }

  public function transferItem(Request $request){
    $term = $request->term;

    $results = array();

    $queries = m_item::where('i_type', '=', DB::raw("'BP'"))
    ->where('i_name', 'like', DB::raw('"%'.$request->term.'%"'))        
    ->orWhere('i_type', '=', DB::raw("'BJ'"))
    ->where('i_name', 'like', DB::raw('"%'.$request->term.'%"')) 
    ->where('i_isactive','TRUE')      
    ->take(25)->get();
    
    if ($queries == null) {
      $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
    } else {
      foreach ($queries as $query) 
      {
        if($query->s_qty=='')

          $query->s_qty=0;

          $results[] = [  'id' => $query->i_id, 
                          'label' =>$query->i_code.'-'. $query->i_name, 
                          'code' => $query->i_code,
                          'name' => $query->i_name ];
      }
    }
 
    return Response::json($results);
  }

  public function transferItemGrosir(Request $request){
    
    $term = $request->term;

    $results = array();

    $queries = m_item::leftjoin('d_stock',function($join) use ($request){
        $join->on('i_id', '=', 's_item');        
        $join->on('s_comp', '=', 's_position');                
        $join->on('s_comp', '=',DB::raw("'2'"));                   
    })   
    ->where('i_isactive','TRUE') 
    ->where('i_type', '=',DB::raw("'BJ'"))    
    ->where('i_name', 'like',DB::raw('"%'.$request->term.'%"')) 
    ->orWhere('i_type', '=',DB::raw("'BP'"))       
    ->where('i_name', 'like',DB::raw('"%'.$request->term.'%"'))
    ->orderBy('i_name')
    ->take(25)
    ->get();   
    
    if ($queries == null) {
      $results[] = [ 'id' => null, 'label' =>'tidak di temukan data terkait'];
    } else {
      foreach ($queries as $query) 
      {
        if($query->s_qty=='')
        $query->s_qty=0;
        $results[] = [  'id' => $query->i_id, 'label' =>$query->i_code.' - '. $query->i_name, 
                        'code' => $query->i_code,
                        'name' => $query->i_name,
                        'qty' => $query->s_qty ];
      }
    }
 
    return Response::json($results);
  }
}

