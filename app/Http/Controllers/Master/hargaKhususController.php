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
use App\m_item_price;
use App\m_price_group;

class hargaKhususController extends Controller
{
    public function index()
    {
    	$group = m_price_group::all();

    	return view('master.harga_khusus.index',compact('group'));
    }

    public function tableGroup($id){
    	$item = m_item_price::select('ip_item',
    								'i_name',
    								'ip_price')
    		->join('m_item','m_item.i_id','=','ip_item')
    		->where('ip_group',$id)
    		->get();
    	
    	return DataTables::of($item)

    	->editColumn('ip_price', function ($data)
        {
            return '<div>
                      <span class="pull-right">
                        '.number_format( $data->ip_price ,2,',','.').'
                      </span>
                    </div>';
        })

    	->addColumn('action', function($data)
		{
		  return '<div class="text-center">
		            <a href=""
		              class="btn btn-warning btn-sm"
		              title="Edit">
		              <i class="fa fa-pencil"></i>
		            </a>
		            <a onclick="distroyNota()"
		              class="btn btn-danger btn-sm"
		              title="Hapus">
		              <i class="fa fa-trash-o"></i>
		            </a>
		          </div>';

		})
    	->rawColumns(['ip_price','action'])
        ->make(true);

    }

    public function tableMasterGroup(){
    	$masterGroup = m_price_group::all();

    	return DataTables::of($masterGroup)
    	->addIndexColumn()
    	->addColumn('action', function($data)
		{
		  return '<div class="text-center">
		            <a href=""
		              class="btn btn-warning btn-sm"
		              title="Edit">
		              <i class="fa fa-pencil"></i>
		            </a>
		            <a onclick="distroyNota()"
		              class="btn btn-danger btn-sm"
		              title="Hapus">
		              <i class="fa fa-trash-o"></i>
		            </a>
		          </div>';

		})
		->rawColumns(['action'])
    	->make(true);
    }
    
}
