@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
      <!--BEGIN TITLE & BREADCRUMB PAGE-->
      <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
          <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
              <div class="page-title">Training Pegawai</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
              <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li><i></i>&nbsp;HRD&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li class="active">Training Pegawai</li>
          </ol>
          <div class="clearfix">
          </div>
      </div>
      <div class="page-content fadeInRight">
          <div id="tab-general">
              <div class="row mbl">
                  <div class="col-lg-12">

                    <div class="col-md-12">
                        <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                        </div>
                    </div>


                    <ul id="generalTab" class="nav nav-tabs">
                      <li class="active"><a href="#alert-tab" data-toggle="tab">Training Pegawai</a></li>
                      <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                      <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                    </ul>
                    <div id="generalTabContent" class="tab-content responsive">

                      <div class="row" align="right">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <a href="{{route('form_training')}}" class="btn btn-box-tool"><i class="fa fa-plus"></i>&nbsp; Tambah Data</a>
                        </div>
                      </div>

                      <div class="col-md-2 col-sm-3 col-xs-12">
                          <label class="tebal">Detail Absensi :</label>
                      </div>
                      <div id="alert-tab" class="tab-pane fade in active">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <div class="input-daterange input-group">
                                    <input id="tanggal1" class="form-control input-sm datepicker1 "
                                           name="tanggal" type="text">
                                    <span class="input-group-addon">-</span>
                                    <input id="tanggal2" class="input-sm form-control datepicker2"
                                           name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 col-xs-12" align="center">
                            <button class="btn btn-primary btn-sm btn-flat autoCari" type="button"
                                    onclick="detTanggal()">
                                <strong>
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </strong>
                            </button>
                            <button class="btn btn-info btn-sm btn-flat refresh-data2" type="button"
                                    onclick="detTanggal()">
                                <strong>
                                    <i class="fa fa-undo" aria-hidden="true"></i>
                                </strong>
                            </button>
                        </div>

                        <div class="col-md-4 col-sm-3 col-xs-12" align="left">
                            <select name="tampilDet" id="tampilDet" onchange="detTanggal()" class="form-control input-sm">
                              @foreach ($devisi as $divisi)
                                <option value="{{$divisi->c_id}}" class="form-control input-sm">{{$divisi->c_divisi}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="panel-body">
                        <div class="table-responsive">
                          <table class="table tabelan table-hover table-bordered" width="100%"
                            cellspacing="0" id="tablePengajuan">
                            <thead>
                                <tr>
                                  <th>Kode</th>
                                  <th>Nama Pegawai</th>
                                  <th>Nama Atasan</th>
                                  <th>Jenis Pelatihan</th>
                                  <th>Status</th>
                                  <th>Aksi</th>
                                </tr>
                              </thead>
                              <tbody>

                              </tbody>

                          </table>
                        </div>

                      </div>
                      <div class="modal fade" id="myModalView" role="dialog">
                          <div class="modal-dialog modal-lg">
                            <form id="myForm">
                              <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header" style="background-color: #e77c38;">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title" style="color: white;">Form Detail Formula</h4>
                                  </div>
                                  <div id="view-formula">

                                  </div>
                                </div>
                              </form>
                            </div>
                        </div>
                      <!-- /div alert-tab -->

                      <!-- div note-tab -->
                      {{-- <div id="note-tab" class="tab-pane fade">
                        <div class="row">
                          <div class="panel-body">
                            <!-- Isi Content -->
                          </div>
                        </div>
                      </div><!--/div note-tab -->

                      <!-- div label-badge-tab -->
                      <div id="label-badge-tab" class="tab-pane fade">
                        <div class="row">
                          <div class="panel-body">
                            <!-- Isi content -->
                          </div>
                        </div>
                      </div><!-- /div label-badge-tab --> --}}

                    </div>

                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>


@endsection
@section("extra_scripts")
    <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function () {
      var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
      }
      // Used when bJQueryUI is false
      $.extend($.fn.dataTableExt.oStdClasses, extensions);
      // Used when bJQueryUI is true
      $.extend($.fn.dataTableExt.oJUIClasses, extensions)

      var date = new Date();
      var newdate = new Date(date);

      newdate.setDate(newdate.getDate() - 3);
      var nd = new Date(newdate);

      $('#tanggal1').datepicker({
          autoclose: true,
          format: "dd-mm-yyyy",
          endDate: 'today'
      }).datepicker("setDate", nd);

      detTanggal();
    });

      function detTanggal(){
        $('#tablePengajuan').dataTable().fnDestroy();
        var tgl1 = $("#tanggal1").val();
        var tgl2 = $("#tanggal2").val();
        var tampil = $("#tampilDet").val();
        $('#tablePengajuan').DataTable({
            "ajax": {
                url: baseUrl + "/hrd/training/tablePengajuan/" + tgl1 + "/" +tgl2+ "/" + tampil,
                type: 'GET'
            },
            "columns": [
              // {"data" : "DT_Row_Index", orderable: false, searchable: false},
              {"data" : 'pp_code', name: 'pp_code', width:"10%"},
              {"data" : 'pegawai', name: 'pegawai', orderable: false, width:"30%"},
              {"data" : 'atasan', name: 'atasan', orderable: false, width:"30%"},
              {"data" : 'pelatihan', name: 'pelatihan', orderable: false, width:"30%"},
              {"data" : 'status', name: 'status', orderable: false, width:"15%"},
              {"data" : 'aksi', name: 'aksi', orderable: false, width:"15%"},
            ],
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
      }

      function openPengajuan(id){
        // baseUrl + ""id ;
        window.location.href= baseUrl + "/hrd/training/acc-pelatihan/" + id;
      }

      function openWaktu(id){
        $.ajax({
          url : baseUrl + "/hrd/training/wakti-pelatihan/",
          type: "get",
          data: {x:id},
          success: function(response){
            $('#view-formula').html(response);
          }
        })
      }

      </script>
@endsection()
