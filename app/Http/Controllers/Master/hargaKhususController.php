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

class hargaKhususController extends Controller
{
    public function index()
    {

    	return view('master.harga_khusus.index');
    }
    
}
