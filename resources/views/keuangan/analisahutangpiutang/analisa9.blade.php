@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Analisa Hutang Piutang</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Analisa Hutang Piutang</li>
    </ol>
    <div class="clearfix">
    </div>
  </div>
  <div class="page-content fadeInRight">
    <div id="tab-general">
      <div class="row mbl">
        <div class="col-lg-12">

          <div class="col-md-12" style="margin-bottom: 50px;">
            <div style="padding:10px;">
              <label>Filter By Periode</label>
              <select id="periodeFilter">
                <option value="1">Periode 1</option>
                <option value="2">Periode 2</option>
              </select>
              
              <!-- <button>Pilih</button> -->
            </div>
            <div id="area-chart-spline">
              <div style="overflow-x:auto;">
                <canvas id="analisaocfChart" width="600" height="280" ></canvas>
              </div>
            </div>
          </div>


          <ul id="generalTab" class="nav nav-tabs">
            <li class="active"><a href="#hutang-tab" data-toggle="tab">Analisa Hutang</a></li>
            <li class=""><a href="#piutang-tab" data-toggle="tab">Analisa Piutang</a></li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">

            <div id="hutang-tab" class="tab-pane fade in active">

              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="col-md-8 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                    <div style="margin-left:-30px;">
                      <div class="col-md-2 col-sm-2 col-xs-12">
                        <label style="padding-top: 7px; font-size: 15px; margin-right:100px;">Periode</label>
                      </div>
                      <div class="col-md-6 col-sm-7 col-xs-12">
                        <div class="form-group" style="display: ">
                          <div class="input-daterange input-group">
                            <input id="tanggal" data-provide="datepicker" class="form-control input-sm" name="tanggal" type="text">
                            <!-- <input name="startDate" id="startDate" class="date-picker" /> -->
                            <span class="input-group-addon">-</span>
                            <input id="tanggal" data-provide="datepicker" class="input-sm form-control" name="tanggal" type="text">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                      <button class="btn btn-warning btn-sm btn-flat" type="button">
                        <strong>
                          <i class="fa fa-search" aria-hidden="true"></i>
                        </strong>
                      </button>
                      <button class="btn btn-danger btn-sm btn-flat" type="button">
                        <strong>
                          <i class="fa fa-undo" aria-hidden="true"></i>
                        </strong>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="table-responsive">
                    <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                      <thead>
                        <tr>
                          <th colspan="3" align="center">Analisa Hutang Periode Agustus 2018 - Januari 2019</th>
                          <!-- <th class="wd-15p">Nama Supplier</th>
                          <th class="wd-20p">Data Baku</th>
                          <th class="wd-15p">Total Harga</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td >Saldo Awal Hutang</td>
                        <td >:</td>
                        <td align="right">300,000,000</td>
                      </tr>
                      <tr >
                        <td colspan="3"></td>
                      </tr>
                      <tr>
                        <td>Hutang Baru Periode Ini</td>
                        <td>:</td>
                        <td align="right">120,000,000</td>
                      </tr>
                      <tr>
                        <td>Hutang yang Sudah Dibayar</td>
                        <td>:</td>
                        <td align="right">32,000,000</td>
                      </tr>
                      <tr>
                        <td>Sisa Hutang yang Belum Dibayar</td>
                        <td>:</td>
                        <td align="right">88,000,000</td>
                      </tr>
                    </tbody>

                  </table> 
                </div>                                       
              </div>
            </div>

          </div><!-- /div alert-tab -->

          <!-- div piutang-tab -->
          <div id="piutang-tab" class="tab-pane fade">

              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="col-md-8 col-sm-12 col-xs-12" style="padding-bottom: 10px;">
                    <div style="margin-left:-30px;">
                      <div class="col-md-2 col-sm-2 col-xs-12">
                        <label style="padding-top: 7px; font-size: 15px; margin-right:100px;">Periode</label>
                      </div>
                      <div class="col-md-6 col-sm-7 col-xs-12">
                        <div class="form-group" style="display: ">
                          <div class="input-daterange input-group">
                            <input id="tanggal" data-provide="datepicker" class="form-control input-sm" name="tanggal" type="text">
                            <!-- <input name="startDate" id="startDate" class="date-picker" /> -->
                            <span class="input-group-addon">-</span>
                            <input id="tanggal" data-provide="datepicker" class="input-sm form-control" name="tanggal" type="text">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                      <button class="btn btn-warning btn-sm btn-flat" type="button">
                        <strong>
                          <i class="fa fa-search" aria-hidden="true"></i>
                        </strong>
                      </button>
                      <button class="btn btn-danger btn-sm btn-flat" type="button">
                        <strong>
                          <i class="fa fa-undo" aria-hidden="true"></i>
                        </strong>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="table-responsive">
                    <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                      <thead>
                        <tr>
                          <th colspan="3" align="center">Analisa Piutang Periode Agustus 2018 - Januari 2019</th>
                          <!-- <th class="wd-15p">Nama Supplier</th>
                          <th class="wd-20p">Data Baku</th>
                          <th class="wd-15p">Total Harga</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td >Saldo Awal Piutang</td>
                        <td >:</td>
                        <td align="right">300,000,000</td>
                      </tr>
                      <tr >
                        <td colspan="3"></td>
                      </tr>
                      <tr>
                        <td>Piutang Baru Periode Ini</td>
                        <td>:</td>
                        <td align="right">120,000,000</td>
                      </tr>
                      <tr>
                        <td>Piutang yang Sudah Dibayar</td>
                        <td>:</td>
                        <td align="right">32,000,000</td>
                      </tr>
                      <tr>
                        <td>Sisa Piutang yang Belum Dibayar</td>
                        <td>:</td>
                        <td align="right">88,000,000</td>
                      </tr>
                    </tbody>

                  </table> 
                </div>                                       
              </div>
            </div>

          </div><!--/div piutang-tab -->

          <!-- div label-badge-tab -->
          <div id="label-badge-tab" class="tab-pane fade">
            <div class="row">
              <div class="panel-body">
                <!-- Isi content -->we
              </div>
            </div>
          </div><!-- /div label-badge-tab -->

        </div>

      </div>
    </div>
  </div>
</div>

          @endsection
          @section("extra_scripts")
          <script type="text/javascript">
           $(document).ready(function() {
            var extensions = {
             "sFilterInput": "form-control input-sm",
             "sLengthSelect": "form-control input-sm"
           }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);
    $('#data').dataTable({
      "responsive":true,

      "pageLength": 10,
      "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
      "language": {
        "searchPlaceholder": "Cari Data",
        "emptyTable": "Tidak ada data",
        "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
        "sSearch": '<i class="fa fa-search"></i>',
        "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
        "infoEmpty": "",
        "paginate": {
          "previous": "Sebelumnya",
          "next": "Selanjutnya",
        }
      }

    });
    $('#data2').dataTable({
      "responsive":true,

      "pageLength": 10,
      "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
      "language": {
        "searchPlaceholder": "Cari Data",
        "emptyTable": "Tidak ada data",
        "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
        "sSearch": '<i class="fa fa-search"></i>',
        "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
        "infoEmpty": "",
        "paginate": {
          "previous": "Sebelumnya",
          "next": "Selanjutnya",
        }
      }

    });
    $('#data3').dataTable({
      "responsive":true,

      "pageLength": 10,
      "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
      "language": {
        "searchPlaceholder": "Cari Data",
        "emptyTable": "Tidak ada data",
        "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
        "sSearch": '<i class="fa fa-search"></i>',
        "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
        "infoEmpty": "",
        "paginate": {
          "previous": "Sebelumnya",
          "next": "Selanjutnya",
        }
      }

    });

    // $('.datepicker').datepicker({
    //   format: "mm",
    //   viewMode: "months",
    //   minViewMode: "months"
    // });
    // $('.datepicker2').datepicker({
    //   format:"dd/mm/yyyy"
    // }); 
    
    $('.date-picker').datepicker( {
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true,
      dateFormat: 'MM yy',
      onClose: function(dateText, inst) { 
        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
      }
    });
  });

</script>

<script type="text/javascript">

 new Chart(document.getElementById("analisaocfChart"), {

  // Jenis Chart
  type: 'line',

  // Set Data Chart
  data: {
    labels: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
    datasets: [{ 
        data: [300000000,300000000,300000000,180000000,180000000,180000000,120000000,120000000,120000000,80000000,80000000,50000000],
        label: "Hutang",
        borderColor: "#3e95cd",
        fill: false
      }, { 
        data: [100000000,120000000,120000000,120000000,120000000,120000000,120000000,120000000,180000000,180000000,250000000,300000000],
        label: "Piutang",
        borderColor: "#8e5ea2",
        fill: false
      }
    ]
  },

  // Konfigurasi
  options: {
    title: {
      display: true,
      text: 'Analisa Hutang Piutang'
    }
    // responsive: true;
  }
});
</script>
@endsection()