<!DOCTYPE html>
<html>
<head>
  <title>Penggajian Pegawai Produksi</title>
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
              Laporan : Penggajian Pegawai Produksi <br>
              Periode : {{date('d M Y', strtotime($tgl1))}} s/d {{date('d M Y', strtotime($tgl2))}}
            </div>
            <div class="bold" style="margin-top: 15px;">
              Nama    : {{ $garapan[0]->c_nama }} <br>
              Jabatan : {{ $garapan[0]->c_jabatan_pro }}
            </div>  
            <div class="bold" style="margin-top: 15px;">
            </div>    

    <table width="100%" cellpadding="2px" class="tabel" border="1px" style="margin-bottom: 10px;">
      <thead>
        <tr>
          <th width="40%">Nama Item</th>
          <th width="10%">Regular</th>
          <th width="25%">Harga</th>
          <th width="25%">Total</th>
        </tr>
      </thead>
      <tbody>

        @foreach ($garapan as $data)
          <tr>
            <td>{{ $data->nm_gaji }}</td>
            <td class="text-right">{{ number_format( $data->dataGaji + $data->dataLembur,0,'.',',') }}</td>
            <td class="text-right">{{ number_format( $data->c_gaji,0,'.',',') }}</td>
            <td class="text-right">{{ number_format(( $data->dataGaji+ $data->dataLembur) * $data->c_gaji,0,'.',',') }}</td>
          </tr>
        @endforeach

      </tbody>

    </table>

    <table width="100%" cellpadding="2px" class="tabel" border="1px" style="margin-bottom: 10px;">
      <thead>
        <tr>
          <th width="40%">Nama Item</th>
          <th width="10%">Lembur</th>
          <th width="25%">Harga</th>
          <th width="25%">Total</th>
        </tr>
      </thead>
      <tbody>

        @foreach ($garapan as $data)
          <tr>
            <td>{{ $data->nm_gaji }}</td>
            <td class="text-right">{{ number_format($data->dataLembur,0,'.',',') }}</td>
            <td class="text-right">{{ number_format($data->c_lembur,0,'.',',') }}</td>
            <td class="text-right">{{ number_format($data->dataLembur * $data->c_lembur,0,'.',',') }}</td>
          </tr>
        @endforeach

        <tr>
          <td colspan="3" style="text-align:left;font-weight: bold;">Pendapatan Total</td>
          <td  class="text-right" style="font-weight: bold;">{{ number_format($total,0,'.',',') }}</td>
        </tr>

      </tbody>

    </table>
    
    
  </div>
  <script type="text/javascript">
    function prints()
    {
      window.print();
    }

  </script>
</body>
</html>