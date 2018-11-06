<?php

namespace App\Http\Controllers\ManUser;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\d_access;
use App\d_group;
use App\d_mem_access;
use App\mMember;
use App\m_jabatan;
use Auth;
use DB;
use App\Http\Controllers\Controller;

class aksesUserController extends Controller
{
    public function indexAksesUser()
    {
        //mMember::with('access')
    	$mem=mMember::Leftjoin('d_mem_access','m_id','=','ma_mem')
    		 ->Leftjoin('d_group',function($join){
                    $join->on('ma_group','=','g_id');
                  })
             ->where('ma_type','=',DB::raw("'M'"))
    		 ->groupBy('m_id')
             ->get();

        return view('/system/hakuser/user',compact('mem'));
    }

    public function tambah_user()
    {
    	$group =d_group::get();
    	$access=d_access::get();
        $jabatan = m_jabatan::all();
        return view('/system/hakuser/tambah_user',compact('access','group','jabatan'));
    }

    public function simpanUser(Request $request){
        //dd($request->all());
        DB::beginTransaction();
        try 
        {
            $tgl_raw = explode(',', $request->TanggalLahir);
            $arr_tgl = explode(' ', trim($tgl_raw[1]));
            $tgl = $arr_tgl[0];
            $bln = $this->convertMonthToBulan($arr_tgl[1]);
            $thn = $arr_tgl[2];
            $hasilTgl = $thn.'-'.$bln.'-'.$tgl;

 			$passwd= sha1(md5('passwordAllah').$request->password);
            $m_id=(int)mMember::max('m_id')+1;
 			mMember::create([
                'm_id'=>$m_id,
                'm_pegawai_id' => $request->IdPegawai,
 				'm_username' => $request->username,
 				'm_passwd' => $passwd,
 				'm_name' => $request->NamaLengkap,
                'm_birth_tgl' => $hasilTgl,
                'm_addr' => $request->alamat,
 			]);

 			$hakAkses=d_group::join('d_group_access','ga_group','=','g_id')
			  ->join('d_access','a_id','=','ga_access')
			  ->where('g_id',$request->groupAkses)->get();


			for ($i=0; $i < count($hakAkses) ; $i++) {
				// $ma_id=d_mem_access::max('ma_id')+1;
				d_mem_access::create([
					   // 'ma_id' =>$ma_id,
					   'ma_mem' =>$m_id,
					   'ma_access'=>$hakAkses[$i]->a_id,
					   'ma_group' =>$hakAkses[$i]->g_id ,
					   'ma_type' =>'G',
					   'ma_read'=> $hakAkses[$i]->ga_read,
					   'ma_insert' =>$hakAkses[$i]->ga_insert,
					   'ma_update' =>$hakAkses[$i]->ga_update,
					   'ma_delete' =>$hakAkses[$i]->ga_delete
				]);
			}


            if($request->groupAkses==null){
                $hakAkses=d_access::get();

                // $ma_id=d_mem_access::max('ma_id')+1;
                d_mem_access::create([
                       // 'ma_id' =>$ma_id,
                       'ma_mem' =>$m_id,
                       'ma_access'=>$hakAkses[$i]->a_id,
                       'ma_group' =>0 ,
                       'ma_type' =>'G'
                ]);

            }

            for ($i=0; $i < count($request->id_access) ; $i++) {
                d_mem_access::create([
                        'ma_mem' =>$m_id,
                        'ma_access' => $request->id_access[$i],
                        'ma_type'  =>'M',
                        'ma_read'=>$request->view[$i],
                        'ma_insert'=>$request->insert[$i],
                        'ma_update'=>$request->update[$i],
                        'ma_delete'=>$request->delete[$i],
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 'sukses'
            ]);
        } 
        catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'data' => $e
            ]);
        }
     }


    public function editUserAkses($id){
        return DB::transaction(function () use ($id) {
		    $mem = mMember::where('m_id',$id)->first();
            $posisi = DB::table('m_pegawai_man')->select('c_jabatan_id')->where('c_id', $mem->m_pegawai_id)->first();
            $group = d_group::get();

    		$mem_group=d_mem_access::join('d_group',function($join) use ($id){
                $join->on('ma_mem','=',DB::raw("'$id'"));
    		    $join->on('ma_group','=','g_id');
            })->groupBy('g_id')->first();


    		$mem_access=d_access::Leftjoin('d_mem_access',function($join) use ($id){
                $join->on('ma_mem','=',DB::raw("'$id'"));
    			$join->on('ma_access','=','a_id');
    			$join->on('ma_type','=',DB::raw("'M'"));
            })->orderBy('a_id')->get();

            $jabatan = m_jabatan::all();

            $data = [
                'mem' => $mem,
                'group' => $group,
                'mem_group' => $mem_group,
                'mem_access' => $mem_access,
                'jabatan' => $jabatan,
                'posisi' => $posisi->c_jabatan_id
            ];

            //return response()->json($data);
            // dd($data);
            // return view('/system/hakuser/edit_user', ['mem' => $mem, 'group' => $group, 'mem_access' => $mem_access, 'mem_group' => $mem_group ]);

    		return view('/system/hakuser/edit_user', $data);
    	});
    }

    public function perbaruiUser(Request $request, $m_id)
    {
        //dd($request->all());
        // DB::beginTransaction();
        // try 
        // {  
            $pass_lama = sha1(md5('passwordAllah').trim($request->PassLama));
            $mem_access = d_mem_access::where('ma_mem', $m_id)->first();
            //dd($mem_access);
            if (!empty($mem_access)) {
                $mMember = mMember::find($m_id);
                $mMember->m_username = $request->Username;
                $mMember->m_name = $request->NamaLengkap;
                $mMember->m_birth_tgl = Carbon::createFromFormat('Y-m-d', $request->TanggalLahir);
                $mMember->m_addr = $request->alamat;
                $mMember->m_update = Carbon::now('Asia/Jakarta');
                if ($pass_lama == $mMember->m_passwd) {
                    $mMember->m_passwd = sha1(md5('passwordAllah').trim($request->PassBaru));
                }
                $mMember->save();

                DB::table('d_mem_access')->where('ma_mem','=',$m_id)->delete();
                
                $hakAkses=d_group::join('d_group_access','ga_group','=','g_id')
                  ->join('d_access','a_id','=','ga_access')
                  ->where('g_id',$request->groupAkses)->get();

                for ($i=0; $i < count($hakAkses) ; $i++) {
                    d_mem_access::create([
                       'ma_mem' =>$m_id,
                       'ma_access'=>$hakAkses[$i]->a_id,
                       'ma_group' =>$hakAkses[$i]->g_id ,
                       'ma_type' =>'G',
                       'ma_read'=> $hakAkses[$i]->ga_read,
                       'ma_insert' =>$hakAkses[$i]->ga_insert,
                       'ma_update' =>$hakAkses[$i]->ga_update,
                       'ma_delete' =>$hakAkses[$i]->ga_delete
                    ]);
                }

                if($request->groupAkses==null)
                {
                    $hakAkses=d_access::get();
                    d_mem_access::create([
                       'ma_mem' => $m_id,
                       'ma_access'=> $hakAkses[$i]->a_id,
                       'ma_group' => 0,
                       'ma_type' => 'G'
                    ]);
                }

                for ($i=0; $i < count($request->id_access); $i++) { 
                    d_mem_access::create([
                       'ma_mem' =>$m_id,
                       'ma_access'=>$request->id_access[$i],
                       'ma_type' =>'M',
                       'ma_read'=> $request->view[$i]
                    ]);
                }

                return response()->json([
                    'status' => 'sukses',
                    'pesan' => 'Berhasil Update data Hak Akses User'
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 'gagal',
                    'pesan' => 'Tidak terdapat data yang akan diubah'
                ]); 
            }
        // }
        // catch (\Exception $e) 
        // {
        //   DB::rollback();
        //   return response()->json([
        //         'status' => 'gagal',
        //         'pesan' => $e->getMessage()."\n at file: ".$e->getFile()."\n line: ".$e->getLine()
        //     ]); 
        // }    
    }

    public function hapusUser(Request $request)
    {
        DB::beginTransaction();
        try {  
          $mem_access = DB::table('d_mem_access')->where('ma_mem','=',$request->id)->delete();
          $d_mem = DB::table('d_mem')->where('m_id','=',$request->id)->delete();

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

    public function autocompletePegawai(Request $request)
    {
        $term = $request->term;
        $results = array();
        $queries = DB::table('m_pegawai_man')
            ->select('m_pegawai_man.c_id','m_pegawai_man.c_nama', 'm_pegawai_man.c_jabatan_id', 'm_pegawai_man.c_ktp_alamat', 'm_pegawai_man.c_lahir', 'm_jabatan.c_posisi')
            ->join('m_jabatan', function($join) {
                $join->on('m_pegawai_man.c_jabatan_id','=','m_jabatan.c_id');
            })
            ->where('c_nama', 'LIKE', '%'.$term.'%')
            ->take(10)->get();
      
        foreach ($queries as $val) {
            if ($queries == null) {
                $results[] = [ 'id' => null, 'label' => 'tidak di temukan data terkait'];
            } 
            else {
                $results[] = [ 
                    'id' => $val->c_id,
                    'label' => $val->c_nama,
                    'jabatan_id' => $val->c_jabatan_id,
                    'jabatan_txt' => $val->c_posisi,
                    'lahir_txt' => $val->c_lahir,
                    'alamat_txt' => $val->c_ktp_alamat
                ];
            }
        }

        return response()->json($results);
    }

    public function convertMonthToBulan($bulan)
    {
        switch ($bulan) {
            case "Januari":
                return "01";
                break;
            case "Februari":
                return "02";
                break;
            case "Maret":
                return "03";
                break;
            case "April":
                return "04";
                break;
            case "Mei":
                return "05";
                break;
            case "Juni":
                return "06";
                break;
            case "Juli":
                return "07";
                break;
            case "Agustus":
                return "08";
                break;
            case "September":
                return "09";
                break;
            case "Oktober":
                return "10";
                break;
            case "November":
                return "11";
                break;
            case "Nopember":
                return "11";
                break;
            case "Desember":
                return "12";
                break;
            default:
                return "masukan format bulan dengan benar";
        }
    }

}
