@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Master Data Pegawai</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;Master&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Master Divisi</li>
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
            <li class="active"><a href="#alert-tab" data-toggle="tab">Master Divisi</a></li>
            <li><a href="#posisi-tab" data-toggle="tab" onclick="tbPosisi()">Master Posisi</a></li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row" style="margin-top:-20px;">
                <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top:15px;">
                  
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 10px;">
                  <a href="{{ url('master/divisi/pos/tambahdivisi') }}">
                    <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                      <i class="fa fa-plus" aria-hidden="true"> &nbsp;
                      </i>Tambah Data</button>
                  </a>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="table-responsive">
                    <table id="tbl_divisi" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th class="wd-15p">No</th>
                          <th class="wd-15p">Nama Divisi</th>
                          <th class="wd-15p">Divisi Akronim</th>
                          <th class="wd-15p">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- div note-tab -->
            <div id="posisi-tab" class="tab-pane fade">
                <div class="row">
                  <div class="panel-body">
                      <div id="note-show">
                          <div class="table-responsive" align="right" style="padding-top: 15px;">
                            <a href="{{ url('master/divisi/pos/tambahposisi/index') }}">
                              <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                                <i class="fa fa-plus" aria-hidden="true"> &nbsp;
                                </i>Tambah Data</button>
                            </a>
                              <div id="dt_nota_jual">
                                  <table class="table tabelan table-bordered table-hover dt-responsive" id="tb_posisi"
                                         style="width: 100%;">
                                      <thead>
                                      <th>No</th>
                                      <th>Posisi</th>
                                      <th>Aksi</th>
                                      </thead>
                                      <tbody>
                                      </tbody>
                                  </table>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>
            </div>
            <!-- End DIv note-tab -->
          </div>
        </div>
      </div>
      @endsection @section("extra_scripts")
      <script type="text/javascript">
        var extensions = {
          "sFilterInput": "form-control input-sm",
          "sLengthSelect": "form-control input-sm"
        }
        // Used when bJQueryUI is false
        $.extend($.fn.dataTableExt.oStdClasses, extensions);
        // Used when bJQueryUI is true
        $.extend($.fn.dataTableExt.oJUIClasses, extensions);
        var tblDivisi = $('#tbl_divisi').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
            url : baseUrl + "/master/divisi/pos/table",
          },
          "columns": [
            {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"},
            { "data": "c_divisi" },
            { "data": "c_divisi_akronim" },
            { "data": "action", "width" : "15%"},
          ],
          "responsive": true,

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

        function tbPosisi(){
        $('#tb_posisi').dataTable().fnDestroy();
        var tbPosisi = $('#tb_posisi').DataTable({
          processing: true,
          serverSide: true,
          ajax: {
            url : baseUrl + "/master/divisi/posisi/table",
          },
          "columns": [
            {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"},
            { "data": "c_subdivisi" },
            { "data": "action", "width" : "15%"},
          ],
          "responsive": true,

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
        }

      function ubahStatusPos(id)
      {
        iziToast.question({
          close: false,
          overlay: true,
          displayMode: 'once',
          //zindex: 999,
          title: 'Ubah Status',
          message: 'Apakah anda yakin ?',
          position: 'center',
          buttons: [
            ['<button><b>Ya</b></button>', function (instance, toast) {
              $.ajax({
                url: baseUrl +'/master/divisi/posisi/ubahstatus',
                type: "get",
                dataType: "JSON",
                data: {id:id},
                success: function(response)
                {
                  if(response.status == "sukses")
                  {
                    $('#tb_posisi').DataTable().ajax.reload();
                    iziToast.success({timeout: 5000,
                                        position: "topRight",
                                        icon: 'fa fa-chrome',
                                        title: '',
                                        message: 'Status brhasil di ganti.'});
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  }
                  else
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    $('#tb_posisi').DataTable().ajax.reload();
                    iziToast.error({position: "topRight",
                                      title: '',
                                      message: 'Status gagal di ubah.'});
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  }
                },
                error: function(){
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.warning({
                    icon: 'fa fa-times',
                    message: 'Terjadi Kesalahan!'
                  });
                },
                async: false
              }); 
            }, true],
            ['<button>Tidak</button>', function (instance, toast) {
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            }],
          ]
        });
      }

      function ubahStatusDiv(id)
      {
        iziToast.question({
          close: false,
          overlay: true,
          displayMode: 'once',
          //zindex: 999,
          title: 'Ubah Status',
          message: 'Apakah anda yakin ?',
          position: 'center',
          buttons: [
            ['<button><b>Ya</b></button>', function (instance, toast) {
              $.ajax({
                url: baseUrl +'/master/divisi/pos/ubahstatus',
                type: "get",
                dataType: "JSON",
                data: {id:id},
                success: function(response)
                {
                  if(response.status == "sukses")
                  {
                    $('#tbl_divisi').DataTable().ajax.reload();
                    iziToast.success({timeout: 5000,
                                        position: "topRight",
                                        icon: 'fa fa-chrome',
                                        title: '',
                                        message: 'Status brhasil di ganti.'});
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  }
                  else
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    $('#tbl_divisi').DataTable().ajax.reload();
                    iziToast.error({position: "topRight",
                                      title: '',
                                      message: 'Status gagal di ubah.'});
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  }
                },
                error: function(){
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.warning({
                    icon: 'fa fa-times',
                    message: 'Terjadi Kesalahan!'
                  });
                },
                async: false
              }); 
            }, true],
            ['<button>Tidak</button>', function (instance, toast) {
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            }],
          ]
        });
      }


        function editDivisi(a) {
          var parent = $(a).parents('tr');
          var id = $(parent).find('.d_id').text();
          console.log(id);
          $.ajax({
            type: "PUT",
            url: '{{ url("master/divisi/pos/edit") }}' + '/' + a,
            data: { id },
            success: function (data) {
            },
            complete: function (argument) {
              window.location = (this.url)
            },
            error: function () {

            },
            async: false
          });
        }

        function editPosisi(a) {
          var parent = $(a).parents('tr');
          var id = $(parent).find('.d_id').text();
          console.log(id);
          $.ajax({
            type: "PUT",
            url: '{{ url("master/divisi/posisi/edit") }}' + '/' + a,
            data: { id },
            success: function (data) {
            },
            complete: function (argument) {
              window.location = (this.url)
            },
            error: function () {

            },
            async: false
          });
        }

      </script> @endsection