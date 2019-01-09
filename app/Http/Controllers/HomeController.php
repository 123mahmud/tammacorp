<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use DB;

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
        $montsAfter = date('Y-m-d', strtotime('+1 months', strtotime($today)));

        $sales = DB::table('d_sales')
                        ->where('s_status', 'FN')
                        ->select(DB::raw('sum(s_net) as total_sales'))
                        ->first();

        $purchase = DB::table('d_purchasing')
                            ->where('d_pcs_status', 'RC')
                            ->select(DB::raw('sum(d_pcs_total_net) as total_pembelian'))
                            ->first();

        $spk = DB::table('d_spk')
                    ->where('spk_date', '>=', $today)->where('spk_date', '<', $montsAfter)
                    ->select(DB::raw('count(spk_id) as total_spk'))
                    ->first();

        $produksi = DB::table('d_productresult_dt')
                            ->whereIn('prdt_productresult', function($query) use ($today, $montsAfter){
                                $query->select('pr_id')
                                            ->from('d_productresult')
                                            ->where('pr_date', '>=', $today)
                                            ->where('pr_date', '<', $montsAfter)
                                            ->get();
                            })
                            ->select(DB::raw('sum(prdt_qty) as total_produksi'))->first();

        $data = [
            "total_sales"   => $sales,
            "total_purchase" => $purchase,
            "total_spk" => $spk,
            "total_produksi" => $produksi 
        ];

        $date = [];

        for ($i = 5; $i >= 1; $i--) {
            array_push($date, date('M Y', strtotime('-'.$i.' months', strtotime($today))));
        }

        $date_1 = json_encode($date);
        // return json_encode($date);

        return view('/home', compact('date_1', 'data'));
    }
}
