<?php

namespace App\Http\Controllers\ManUser;

use Illuminate\Http\Request;

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
             ->where('ma_type','=',DB::raw("'G'"))
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
        // dd($request->all());
        DB::beginTransaction();
            try {
                $tgl1 = $request->TanggalLahir;
                $y = substr($tgl1, -4);
                $m = substr($tgl1, -7,-5);
                $d = substr($tgl1,0,2);
                 $tgll = $y.'-'.$m.'-'.$d;
     			$m_id=(int)mMember::max('m_id')+1;
     			$passwd= sha1(md5('passwordAllah').$request->password);
                // $passwd= md5($request->Password);
                // dd($passwd);
     			mMember::create([
     				'm_id'=>$m_id,
                    'm_pegawai_id' => $request->pp_jabatan,
     				'm_username' => $request->username,
     				'm_passwd' => $passwd,
     				'm_name' => $request->NamaLengkap,
                    'm_birth_tgl' => $tgll,
                    'm_addr' => $request->alamat,

     			]);

         			$hakAkses=d_group::join('d_group_access','ga_group','=','g_id')
        			  ->join('d_access','a_id','=','ga_access')
        			  ->where('g_id',$request->groupAkses)->get();


    			for ($i=0; $i < count($hakAkses) ; $i++) {
    				$ma_id=d_mem_access::max('ma_id')+1;
    				d_mem_access::create([
    					   'ma_id' =>$ma_id,
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

                    $ma_id=d_mem_access::max('ma_id')+1;
                    d_mem_access::create([
                           'ma_id' =>$ma_id,
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
        } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
            'status' => 'gagal',
            'data' => $e
          ]);
        }
     }


    public function editUserAkses($id){
        return DB::transaction(function () use ($id) {
    			$mem=mMember::where('m_id',$id)->first();
                $group=d_group::get();

    			$mem_group=d_mem_access::join('d_group',function($join) use ($id){
                    $join->on('ma_mem','=',DB::raw("'$id'"));
    				$join->on('ma_group','=','g_id');
                  })->groupBy('g_id')->first();


    			$mem_access=d_access::Leftjoin('d_mem_access',function($join) use ($id){
                    $join->on('ma_mem','=',DB::raw("'$id'"));
    				$join->on('ma_access','=','a_id');
    				$join->on('ma_type','=',DB::raw("'M'"));
                  })->orderBy('a_order')->get();

    			   return view('/system/hakuser/edit_user',compact('mem','group','mem_access','mem_group'));

    	});
    			}

    public function perbaruiUser($m_id,Request $request){
    return DB::transaction(function () use ($m_id,$request) {

        $mMember=mMember::where('m_id',$m_id);
        $mMember->update([
                    'm_username' =>$request->Username,
                    'm_name' =>$request->NamaLengkap,
                ]);

        $mem_access=d_mem_access::where('ma_mem',$m_id)
                    ->where('ma_type','=',DB::raw("'G'"));

         $hakAkses=d_group::join('d_group_access','ga_group','=','g_id')
                          ->join('d_access','a_id','=','ga_access')
                          ->where('g_id',$request->groupAkses)->get();



        if($mem_access->first()){
                if($mem_access->first()->ma_group!=$request->groupAkses){
                    $mem_access=d_mem_access::where('ma_mem',$m_id)
                                ->where('ma_type','=',DB::raw("'G'"));
                    $mem_access->delete();
                   if($request->groupAkses!=''){



                        for ($i=0; $i < count($hakAkses) ; $i++) {
                            $ma_id=d_mem_access::max('ma_id')+1;
                            d_mem_access::create([
                                   'ma_id' =>$ma_id,
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

                   }

                elseif($request->groupAkses==null){
                    $hakAkses=d_access::get();
                for ($i=0; $i < count($hakAkses) ; $i++) {
                    $ma_id=d_mem_access::max('ma_id')+1;
                    d_mem_access::create([
                           'ma_id' =>$ma_id,
                           'ma_mem' =>$m_id,
                           'ma_access'=>$hakAkses[$i]->a_id,
                           'ma_group' =>0 ,
                           'ma_type' =>'G'
                    ]);

                }
            }

                }

        }else{

                   for ($i=0; $i < count($hakAkses) ; $i++) {
                            $ma_id=d_mem_access::max('ma_id')+1;
                            d_mem_access::create([
                                   'ma_id' =>$ma_id,
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

        }


                for ($i=0; $i < count($request->id_access) ; $i++) {
                    $mem_access=d_mem_access::where('ma_mem',$m_id)
                                ->where('ma_access',$request->id_access[$i])
                                ->where('ma_type','=',DB::raw("'M'"));
                    if($mem_access->first()){
                    $mem_access->update([
                                'ma_read'=>$request->view[$i],
                                'ma_insert'=>$request->insert[$i],
                                'ma_update'=>$request->update[$i],
                                'ma_delete'=>$request->delete[$i]
                                ]);

                    }else{
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

                }

                $data=['status'=>'sukses'];
                return json_encode($data);
            });
    }

    }
