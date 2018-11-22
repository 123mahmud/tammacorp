<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
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
    public function home()
    {

        $today = date('Y-m').'-01';
        $date = [];

        for ($i = 5; $i >= 1; $i--) {
            array_push($date, date('M Y', strtotime('-'.$i.' months', strtotime($today))));
        }

        $date_1 = json_encode($date);
        // return json_encode($date);

        return view('/home', compact('date_1'));
    }
}
