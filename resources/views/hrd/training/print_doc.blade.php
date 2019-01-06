<!DOCTYPE html>
<html>
<head>
  <title>Document Training</title>
  <style type="text/css">
    *{
      font-size: 12px;
    }
    .s16{
      font-size: 14px !important;
    }
    .div-width{
      margin: auto;
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
    .text-right{
      text-align: right;
    }
    .border-none-right{
      border-right: none;
    }
    .border-none-left{
      border-left:none;
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
    table.border-none ,.border-none td{
      border:none !important;
          }
    .tabel table, .tabel td{
      border:1px solid black;
    }
    
    @media print{
      .btn-group{
        display: none;
      }
    }
    @page{
      size: landscape;
      margin: 0;
    }

    @media print{
      .btn-print{
        display: none;
      }
    }
    
    table.tabel th{
      white-space: nowrap;
      width: auto;
    }
    .no-border-head{
      border-top:hidden !important;
      border-left: hidden !important;
      border-right: hidden !important;
    }
    table.tabel tr {
      page-break-inside:auto; 
      page-break-after:avoid;
    }
    table.tabel {
      page-break-inside:auto;
    }

    .btn-group{
      right: 10px;
      position: absolute;
    }

  </style>
</head>
<body>
  <div class="button-group float-right">
    <button onclick="prints()">Print</button>
  </div>
  
    <div class="div-width">
    
            <div class="s16 bold">
              TAMMA ROBAH INDONESIA
            </div>
            <div>
              Jl. Raya Randu no.74<br>
              Sidotopo Wetan - Surabaya 60123<br>
            </div>
            <div class="bold" style="margin-top: 15px;">
              Laporan : Document Training <br>
            </div>  
            <div class="bold" style="margin-top: 15px;">
            </div>  

            <table width="100%" cellpadding="5px" class="tabel" border="1px" style="margin-bottom: 10px;">
              <thead>
                <tr>
                  <th align="left" style="font-size: 15px;">Nama: {{$pegawai->b_nama}}</th>
                  <th align="left" style="font-size: 15px;">Jabatan/Posisi: {{$pegawai->c_posisi}}</th>
                </tr>
              </thead>
              <thead>
                <tr>
                  <th align="left" style="font-size: 15px;">Jenis Pelatihan:  {{$pegawai->dp_name}}</th>
                  <th align="left" style="font-size: 15px;">Nama Atasan:  {{$pegawai->a_nama}}</th>
                </tr>

              </thead>

            </table>

            @foreach ($soal as $index => $dataSoal)
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group bold">
                  <span style="font-size: 20px;">{{$index+1}}. {{$dataSoal->fp_soal}}</span>
                  <input type="hidden" name="fp_id[]" value="{{$dataSoal->fp_id}}">
                </div>
              </div>
              @foreach ($jawab as $dataJawab)
                @if ($dataSoal->fp_id == $dataJawab->ppd_fpd_fp)
                  @if ($dataJawab->fpd_type == 'I')
                    <div class="bold">
                      <span style="font-size: 35px;">{{$dataJawab->pp_fpd_det}}</span>
                    </div>
                  @else
                      <div class="bold">
                       <span style="font-size: 20px;margin-top: 15px;">&nbsp;&nbsp;&nbsp;* {{$dataJawab->pp_fpd_ket}}</span>
                      </div>
                  @endif
                @endif
              @endforeach
            @endforeach

    
    
  </div>
  <script type="text/javascript">
    function prints()
    {
      window.print();
    }

  </script>
</body>
</html>