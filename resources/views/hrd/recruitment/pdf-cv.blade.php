<!DOCTYPE html>
<html>
<head>
  <title>FORM PERMINTAAN HARIAN</title>
  <style type="text/css">
      *:not(h1):not(h2):not(h3):not(h4):not(h5):not(h6):not(small):not(label){
        font-size: 12px;
      }
      .s16{
        font-size: 16px !important;
      }
      .div-width{
        margin: 10px;
        width: 95vw;
      }
      .underline{
        text-decoration: underline;
      }
      .italic{
        font-style: italic;
      }
      .bold{
        font-weight: bold;
      }
      .text-center{
        text-align: center;
      }
      .text-left{
        text-align: left;
      }
      .text-right{
        text-align: right;
      }
      .border-none-right{
        border-right: hidden;
      }
      .border-none-left{
        border-left:hidden;
      }
      .border-none-top{
        border-top: hidden;
      }
      .border-none-bottom{
        border-bottom: hidden;
      }
      .border-none-all{
        border: hidden;
      }
      .float-left{
        float: left;
      }
      .float-right{
        float: right;
      }
      .top{
        vertical-align: text-top;
      }
      .vertical-baseline{
        vertical-align: baseline;
      }
      .bottom{
        vertical-align: text-bottom;
      }
      .ttd{
        top: 0;
        position: absolute;
      }
      .relative{
        position: relative;
      }
      .absolute{
        position: absolute;
      }
      .empty{
        height: 15px;
      }
      table,td{
        border:1px solid black;
      }
      table{
        border-collapse: collapse;
      }
      table.border-none ,.border-none td, .border-none tr{
        border:none !important;
      }
      @media print{
        .btn-print{
          display: none;
        }
      }
      @page{
        size: landscape;
        margin: 0;
      }
      .div-page-break{
        page-break-after: always;
      }
      .border-hidden tr, .border-hidden td{
        border: hidden;
      }
      .btn-print{
        right: 10px;
        position: absolute;
      }
      .img-logo {
        width: 100px;
        height: 50px;
      }
      .img-foto {
        width: 200px;
        height: 200px;
      }
      .tbl-outer{
        color:#070707;
        margin-bottom: 10px;
        border: hidden;
      } 
  </style>
</head>
<body>
  <div class="div-width">
    <div class="div-page-break">
      <table class="tbl-outer">
        <tr>
          <td align="left" class="outer-left" style="border: hidden;">
            <img src="{{ asset('assets/img/logo.png')}}" alt="Foto" class="img-logo">
          </td>
          <td align="right" class="outer-left" style="border: hidden;">
            <p style="text-align: left; font-size: 14px" class="outer-left">
              <strong> TAMMA ROBAH INDONESIA</strong>
            </p>
            <p style="text-align: left; font-size: 12px" class="outer-left"> Jl. Randu No.51, Sidotopo Wetan, Kenjeran, Kota SBY, Jawa Timur 60128</p>
          </td>
        </tr>
      </table>
      <h1 class="s16 tebal" style="padding-top: 20px; color: blue;">Curriculum Vitae</h1>
      <table width="100%" cellpadding="3px" class="tabel" border="1px" style="margin-right: 20px;">
        <tr class="text-left">
          <td style="width: 20%;"><strong>Nama Lengkap</strong></td>
          <td style="width: auto;">{{$pelamar->p_name}}</td>
          <td rowspan="8" style="text-align: center;width: 1%">
              <img src="{{ public_path('assets/berkas/foto-pelamar/'.$foto->bks_name)}}" alt="Foto" class="img-foto" width="200px" height="200px">
          </td>
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>No. KTP</strong></td>
          <td style="width: auto;">{{$pelamar->p_nip}}</td>
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Tempat/Tgl Lahir</strong></td>
          <td style="width: auto;">{{$pelamar->p_birth_place.' / '.date('d-m-Y', strtotime($pelamar->p_birthday))}}</td>
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Alamat</strong></td>
          <td style="width: auto;">{{$pelamar->p_address}}</td>
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Alamat Saat Ini</strong></td>
          <td style="width: auto;">{{$pelamar->p_address_now}}</td>
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Telp/Wa</strong></td>
          <td style="width: auto;">{{$pelamar->p_tlp}}</td>
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Email</strong></td>
          <td style="width: auto;">{{$pelamar->p_email}}</td>
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Agama</strong></td>
          <td style="width: auto;">{{$pelamar->p_religion}}</td>
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Pendidikan Terakhir</strong></td>
          <td style="width: auto;" colspan="2">{{$pelamar->p_education}}</td>
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Nama Sekolah</strong></td>
          <td style="width: auto;" colspan="2">{{$pelamar->p_schoolname}}</td>
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Tahun Masuk</strong></td>
          <td style="width: auto;" colspan="2">{{$pelamar->p_yearin}}</td>
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Tahun Lulus</strong></td>
          <td style="width: auto;" colspan="2">{{$pelamar->p_yearout}}</td>
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Jurusan</strong></td>
          <td style="width: auto;" colspan="2">{{$pelamar->p_jurusan}}</td>
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Nilai</strong></td>
          <td style="width: auto;" colspan="2">{{$pelamar->p_nilai}}</td>
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Status</strong></td>
          @if ($pelamar->p_status == 'M')
            <td style="width: auto;" colspan="2">Menikah</td>
          @else
            <td style="width: auto;" colspan="2">Belum Menikah</td>
          @endif
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Nama Pasangan</strong></td>
          @if ($pelamar->p_wife_name == '' || $pelamar->p_wife_name == null)
            <td style="width: auto;" colspan="2"> - </td>
          @else
            <td style="width: auto;" colspan="2">{{$pelamar->p_wife_name}}</td>
          @endif
        </tr>
        <tr class="text-left">
          <td style="width: 20%;"><strong>Jumlah Anak</strong></td>
          @if ($pelamar->p_child == '' || $pelamar->p_child == null)
            <td style="width: auto;" colspan="2"> - </td>
          @else
            <td style="width: auto;" colspan="2">{{$pelamar->p_child}}</td>
          @endif
        </tr>
      </table>
      
      @if (count($cv) > 0)
        <h1 class="s16 tebal" style="padding-top: 20px; color: blue;">Pengalaman Bekerja</h1>
        @foreach ($cv as $val)
          <table width="100%" cellpadding="3px" class="tabel" border="1px" style="margin-right: 20px; margin-top: 10px;">
            <tr class="text-left">
              <td style="width: 20%;"><strong>Nama Perusahaan</strong></td>
              <td style="width: 80%;">{{$val->d_cv_company}}</td>
            </tr>
            <tr class="text-left">
              <td style="width: 20%;"><strong>Masa Bekerja</strong></td>
              <td style="width: 80%;">{{$val->d_cv_thnmasuk.' s/d '.$val->d_cv_thnkeluar}}</td>
            </tr>
            <tr class="text-left">
              <td style="width: 20%;" rowspan="4"><strong>Job Desc</strong></td>
              <td style="width: 80%;" rowspan="4">{{$val->d_cv_jobdesc}}</td>
            </tr>
            <tr class="text-left">
            </tr>
            <tr class="text-left">
            </tr>
            <tr class="text-left">
            </tr>
          </table>
        @endforeach
      @endif
    </div>
  </div>
</body>
</html>