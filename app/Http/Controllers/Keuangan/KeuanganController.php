<?php

namespace App\Http\Controllers\Keuangan;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use DataTables;

class KeuanganController extends Controller
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
    public function transaksi()
    {
        return view('/keuangan/p_inputtransaksi/transaksi');
    }

    /*public function hutang()
    {
        return view('/keuangan/l_hutangpiutang/hutang');
    }*/

    public function jurnal()
    {
        return view('/keuangan/l_jurnal/jurnal');
    }

    public function analisa()
    {
        return view('/keuangan/analisaprogress/analisa');
    }

    // public function analisa2()
    // {
    //     return view('/keuangan/analisaocf/analisa2');
    // }

    public function analisa2a()
    {
        return view('/keuangan/analisaocf/analisa2a');
    }

    public function analisa2b()
    {
        return view('/keuangan/analisaocf/analisa2b');
    }

    // public function analisa3()
    // {
    //     return view('/keuangan/analisaaset/analisa3');
    // }

    public function analisa3a()
    {
        return view('/keuangan/analisaaset/analisa3a');
    }

    public function analisa3b()
    {
        return view('/keuangan/analisaaset/analisa3b');
    }

    public function analisa4()
    {
        return view('/keuangan/analisacashflow/analisa4');
    }

    public function analisa5()
    {
        return view('/keuangan/analisaindex/analisa5');
    }

    public function analisa6()
    {
        return view('/keuangan/analisarasio/analisa6');
    }

    public function analisa7()
    {
        return view('/keuangan/analisabottom/analisa7');
    }

    public function analisa8()
    {
        return view('/keuangan/analisaroe/analisa8');
    }

    public function analisa9()
    {
        return view('/keuangan/analisahutangpiutang/analisa9');
    }

    public function pembatalanPenerimaan()
    {
        return view('/keuangan/pembatalan_penerimaan/batal_terima');
    }

    public function ubahStatusTransaksi($dod_do, $dod_detailid)
    {
        //get recent status DO
        $recentStatusDo = DB::table('d_delivery_orderdt')
                            ->where('dod_do',$dod_do)
                            ->where('dod_detailid',$dod_detailid)
                            ->first();

        if ($recentStatusDo->dod_status == "WT") 
        {
            //update status to FN
            DB::table('d_delivery_orderdt')
                ->where('dod_do',$dod_do)
                ->where('dod_detailid',$dod_detailid)
                ->update(['dod_status' => "FN"]);
        }
        else
        {
            //update status to WT
            DB::table('d_delivery_orderdt')
                ->where('dod_do',$dod_do)
                ->where('dod_detailid',$dod_detailid)
                ->update(['dod_status' => "WT"]);
        }

        //get recent status Product Result detail
        $recentStatusPrdt = DB::table('d_productresult_dt')
                                ->where('prdt_productresult',$recentStatusDo->dod_prdt_productresult)
                                ->where('prdt_detail',$recentStatusDo->dod_prdt_detail)
                                ->first();

        if ($recentStatusPrdt->prdt_status != "RC") 
        {
            //update status to RC
            DB::table('d_productresult_dt')
                ->where('prdt_productresult',$recentStatusPrdt->prdt_productresult)
                ->where('prdt_detail',$recentStatusPrdt->prdt_detail)
                ->update(['prdt_status' => "RC"]);
        }
        else
        {
            //update status to SN
            DB::table('d_productresult_dt')
                ->where('prdt_productresult',$recentStatusPrdt->prdt_productresult)
                ->where('prdt_detail',$recentStatusPrdt->prdt_detail)
                ->update(['prdt_status' => "SN"]);
        }
        
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Status penerimaan telah berhasil diubah',
        ]);
    }
}
