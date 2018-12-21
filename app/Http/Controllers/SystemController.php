<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use File;
use Auth;

class SystemController extends Controller
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
    public function user()
    {
        return view('/system/hakuser/user');
    }

    public function akses()
    {
        return view('/system/hakakses/akses');
    }

    public function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            return false;
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public function profil()
    {
        $data = DB::table('d_company_profile')
            ->first();
        return view('/system/profilperusahaan/profil', compact('data'));
    }

    public function updateProfil(Request $request)
    {
        DB::beginTransaction();
        try {
            $nama = $request->companyname;
            $owner = $request->ownername;
            $since = Carbon::createFromFormat('d-m-Y', $request->companydate)->format('Y-m-d');
            $alamat = $request->companyaddress;
            $telp = $request->telp;
            $telp2 = $request->telp2;
            $fax = $request->fax;
            $email = $request->email;
            $imagePath = null;
            $file = $request->file('fileImage');
            $tgl = carbon::now('Asia/Jakarta');
            $folder = $tgl->year . $tgl->month . $tgl->timestamp;
            $dir = 'assets/images/uploads/profil/';
            $this->deleteDir($dir);
            $childPath = $dir . '/';
            $path = $childPath;
            $name = null;
            if ($file != null) {
                $name = $folder . '.' . $file->getClientOriginalExtension();
                if (!File::exists($path)) {
                    if (File::makeDirectory($path, 0777, true)) {
                        $file->move($path, $name);
                        $imagePath = $childPath . $name;
                    } else
                        $imgPath = null;
                } else {
                    return 'already exist';
                }
            }

            DB::table('d_company_profile')
                ->where('cp_id', '=', 1)
                ->update([
                    'cp_name' => $nama,
                    'cp_owner' => $owner,
                    'cp_address' => $alamat,
                    'cp_date' => $since,
                    'cp_telp' => $telp,
                    'cp_telp2' => $telp2,
                    'cp_fax' => $fax,
                    'cp_email' => $email,
                    'cp_image' => $imagePath
                ]);
            DB::commit();
            return redirect(url('profil-perusahaan'));
        } catch (\Exception $e){
            DB::rollback();
            return redirect(url('profil-perusahaan'));
        }
    }

    public function finansial()
    {
        return view('/system/thnfinansial/finansial');
    }
    public function tambah_user()
    {
        return view('/system/hakuser/tambah_user');
    }
    public function tambah_akses()
    {
        return view('/system/hakakses/tambah_akses');
    }
}
