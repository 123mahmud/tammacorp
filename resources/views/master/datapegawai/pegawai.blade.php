@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">pegawai</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;Master&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">pegawai</li>
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
            <li class="active">
              <a href="#transfer" data-toggle="tab">Manajemen</a>
            </li>
            <li>
              <a href="#alert-tab" onclick="tabelProduksi()" data-toggle="tab">Produksi</a>
            </li>
            <li>
              <a href="#alert-tab-rumah" onclick="tabelRumah()" data-toggle="tab">Rumah Produksi</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="transfer" class="tab-pane fade in active">
              <div class="row" style="margin-top:-20px;">
                <div class="panel-body">
                  <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 10px;">
                    <div class="col-md-4 col-sm-12 col-xs-12">
                    </div>
                    <div class="col-md-8 col-sm-12 col-xs-12">
                      <a href="{{ url('master/datapegawai/tambah-pegawai') }}">
                        <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                          <i class="fa fa-plus" aria-hidden="true">
                            &nbsp;
                          </i>Tambah Data
                        </button>
                      </a>
                    </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                      <table id="tbl_pegawai" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                        <thead>
                          <tr>
                            <th class="wd-15p">ID</th>
                            <th class="wd-15p">NIK</th>
                            <th class="wd-15p">Nama Pegawai</th>
                            <th class="wd-15p">Tahun Masuk</th>
                            <th class="wd-15p">Jabatan</th>
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
            </div>
            <!-- div note-tab -->
            <div id="alert-tab" class="tab-pane fade">
              <div class="row">
                <div class="panel-body">
                  <div class="row" style="margin-top:-20px;">
                     <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-2 col-sm-2 col-xs-2">
                           <label class="tebal">Rumah Produksi:</label>
                        </div>

                         <div class="col-md-4 col-sm-4 col-xs-4">
                           <select name="tampilData" id="tampil_data" class="form-control input-sm" onchange="tabelProduksi()">
                              @foreach ($rumah as $produksi)
                                 <option value="{{ $produksi->mp_id }}" class="form-control">{{ $produksi->mp_name }}</option>
                              @endforeach
                          </select>
                         </div>

                         <div class="col-md-6 col-sm-6 col-xs-6" align="right" style="padding-bottom: 30px;">
                           <a href="{{ url('master/datapegawai/tambah-pegawai-pro') }}">
                             <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                               <i class="fa fa-plus" aria-hidden="true">
                                 &nbsp;
                               </i>Tambah Data
                             </button>
                           </a>
                         </div>

                       <div class="col-md-12 col-sm-12 col-xs-12">
                         <div class="table-responsive">
                           <table id="tbl_pegawai_pro" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0">
                             <thead>
                               <tr>
                                 <th class="wd-15p">ID</th>
                                 <th class="wd-15p">NIK</th>
                                 <th class="wd-15p">Nama Pegawai</th>
                                 <th class="wd-15p">Tahun Masuk</th>
                                 <th class="wd-15p">Tugas</th>
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
                </div>
              </div>
            </div>
              <!-- End DIv note-tab -->
              <!-- div note-tab rumah -->
            <div id="alert-tab-rumah" class="tab-pane fade">
              <div class="row">
                <div class="panel-body">
                  <div class="row" style="margin-top:-20px;">
                     <div class="col-md-12 col-sm-12 col-xs-12">
                         <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="padding-bottom: 30px;">
                           <a href="{{ url('master/datapegawai/tambah-rumah-pro') }}">
                             <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                               <i class="fa fa-plus" aria-hidden="true">
                                 &nbsp;
                               </i>Tambah Data
                             </button>
                           </a>
                         </div>

                       <div class="col-md-12 col-sm-12 col-xs-12">
                         <div class="table-responsive">
                           <table id="tbl_rumah_pro" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data-rumah">
                             <thead>
                               <tr>
                                 <th class="wd-15p">Rumah Produksi</th>
                                 <th class="wd-15p">Alamat</th>
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
                </div>
              </div>
              <!-- End DIv note-tab -->
            </div>
            </div>
          <!-- End div generalTab -->

        </div>
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

    var tablePeg = $('#tbl_pegawai').DataTable({
      processing: true,
      // responsive:true,
      serverSide: true,
      ajax: {
        url: '{{ url("master/datapegawai/datatable-pegawai") }}',
      },
      columnDefs: [
        {
          targets: 0,
          className: 'center d_id'
        },
      ],
      "columns": [
        { "data": "c_code" },
        { "data": "c_nik" },
        { "data": "c_nama" },
        { "data": "c_tahun_masuk" },
        { "data": "c_posisi" },
        { "data": "action" },
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

    function ubahStatusMan(id)
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
                url: baseUrl +'/master/datapegawai/ubahstatus',
                type: "get",
                dataType: "JSON",
                data: {id:id},
                success: function(response)
                {
                  if(response.status == "sukses")
                  {
                    $('#tbl_pegawai').DataTable().ajax.reload();
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
                    $('#tbl_pegawai').DataTable().ajax.reload();
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

    function ubahStatusPro(id)
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
                url: baseUrl +'/master/datapegawai/ubahstatuspro',
                type: "get",
                dataType: "JSON",
                data: {id:id},
                success: function(response)
                {
                  if(response.status == "sukses")
                  {
                    $('#tbl_pegawai_pro').DataTable().ajax.reload();
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
                    $('#tbl_pegawai_pro').DataTable().ajax.reload();
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

    function edit(a) {
      var parent = $(a).parents('tr');
      var id = $(parent).find('.d_id').text();
      console.log(id);
      $.ajax({
        type: "PUT",
        url: '{{ url("master/datapegawai/edit-pegawai") }}' + '/' + a,
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
    function hapusPro(id) {
      iziToast.question({
        timeout: 20000,
        close: false,
        overlay: true,
        toastOnce: true,
        id: 'question',
        zindex: 999,
        title: 'Hey',
        message: 'Apakah anda yakin?',
        position: 'center',
        buttons: [
          ['<button><b>YA</b></button>', function (instance, toast) {
            $.ajax({
              url: '{{ url("master/datapegawai/delete-pegawai-pro") }}' + '/' + id,
              async: false,
              type: "DELETE",
              data: {
                "id": id,
                "_method": 'DELETE',
                "_token": '{{ csrf_token() }}',
              },
              dataType: "json",
              success: function (data) { }
            });
            tablePro.ajax.reload();
            instance.hide({
                  transitionOut: 'fadeOutUp'
              }, toast);

          }, true],
          ['<button>TIDAK</button>', function (instance, toast) {

            instance.hide({
                  transitionOut: 'fadeOutUp'
              }, toast);

          }]
        ],
        onClosing: function (instance, toast, closedBy) {
          console.info('Closing | closedBy: ' + closedBy);
        },
        onClosed: function (instance, toast, closedBy) {
          console.info('Closed | closedBy: ' + closedBy);
        }
      });
    }
    function editPro(a) {
      var parent = $(a).parents('tr');
      var id = $(parent).find('.d_id').text();
      console.log(id);
      $.ajax({
        type: "PUT",
        url: '{{ url("master/datapegawai/edit-pegawai-pro") }}' + '/' + a,
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

   function tabelProduksi()
   {
      $('#tbl_pegawai_pro').dataTable().fnDestroy();
      var id = $('#tampil_data').val();
      var tablePro = $('#tbl_pegawai_pro').DataTable({
      processing: true,
      // responsive:true,
      serverSide: true,
      ajax: {
         url: baseUrl + '/master/datapegawai/datatable-pegawaipro/' + id,
      },
      columnDefs: [
        {
          targets: 0,
          className: 'center d_id'
        },
      ],
      "columns": [
        { "data": "c_code" },
        { "data": "c_nik" },
        { "data": "c_nama" },
        { "data": "c_tahun_masuk" },
        { "data": "c_jabatan_pro" },
        { "data": "action" },
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

   function tabelRumah()
   {
      $('#tbl_rumah_pro').dataTable().fnDestroy();
      var tablePro = $('#tbl_rumah_pro').DataTable({
      processing: true,
      // responsive:true,
      serverSide: true,
      ajax: {
         url: baseUrl + '/master/datapegawai/datatable-rumahpro',
      },
      columnDefs: [
        {
          targets: 0,
          className: 'center d_id'
        },
      ],
      "columns": [
        { "data": "mp_name", "width" : "30%" },
        { "data": "mp_alamat", "width" : "55%" },
        { "data": "action", "width" : "15%" },
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

   function ubahStatusRumah(id)
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
                url: baseUrl +'/master/datapegawai/ubahstatusrumah',
                type: "get",
                dataType: "JSON",
                data: {id:id},
                success: function(response)
                {
                  if(response.status == "sukses")
                  {
                    $('#tbl_rumah_pro').DataTable().ajax.reload();
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
                    $('#tbl_rumah_pro').DataTable().ajax.reload();
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

      function editRumahPro(a) {
         var parent = $(a).parents('tr');
         var id = $(parent).find('.d_id').text();
         console.log(id);
         $.ajax({
           type: "PUT",
           url: '{{ url("master/datapegawai/edit-rumah-pro") }}' + '/' + a,
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
   

  </script>
  <style>
    .upload-btn-wrapper {
      position: relative;
      overflow: hidden;
      display: inline-block;
    }
  </style>
  @endsection