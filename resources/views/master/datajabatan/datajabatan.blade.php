@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Data Jabatan</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Data Jabatan</li>
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
              <a href="#alert-tab" data-toggle="tab">Data Jabatan</a>
            </li>
            <li><a href="#note-tab" data-toggle="tab" onclick="lihatJabPro()">Jabatan Produksi</a></li>
            {{-- <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> --}}
          </ul>
          <div id="generalTabContent" class="tab-content responsive">

            <div id="alert-tab" class="tab-pane fade in active">

              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="col-md-12 col-sm-12 col-xs-12" align="right" style="margin-bottom: 10px;">

                    <a href="{{ url('master/datajabatan/tambah-jabatan') }}">
                      <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                        <i class="fa fa-plus" aria-hidden="true"> &nbsp;
                        </i>Tambah Data</button>
                    </a>

                    <div class="table-responsive">
                      <table id= "tbl_jabatan" class="table tabelan table-hover table-bordered"  width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Divisi</th>
                            <th>Action</th>
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
            <!-- /div alert-tab -->

              <!-- div note-tab -->
              <div id="note-tab" class="tab-pane fade">
                <div class="row">
                  <div class="panel-body">
                    @include('master.datajabatan.jabatan-produksi')
                  </div>
                </div>
              </div>
              <!--/div note-tab -->

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  @endsection @section("extra_scripts")

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
      $.extend($.fn.dataTableExt.oJUIClasses, extensions);

      $('#tbl_jabatan').DataTable({
      processing: true,
      // responsive:true,
      serverSide: true,
      ajax: {
        url: '{{ url("master/datajabatan/data-jabatan") }}',
      },
      columnDefs: [
        {
          targets: 0,
          className: 'center d_id'
        },
      ],
      "columns": [
        { "data": "kode" },
        { "data": "c_posisi" },
        { "data": "c_divisi" },
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


    });

    
    function edit(a) {
      var parent = $(a).parents('tr');
      var id = $(parent).find('.d_id').text();
      console.log(id);
      $.ajax({
        type: "PUT",
        url: '{{ url("master/datajabatan/edit-jabatan") }}' + '/' + a,
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


    function hapus(id){
      iziToast.show({
      color: 'red',
      title: 'Peringatan',
      message: 'Apakah anda yakin!',
      position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
      progressBarColor: 'rgb(0, 255, 184)',
      buttons: [
        [
          '<button>Ok</button>',
          function (instance, toast) {
            instance.hide({
              transitionOut: 'fadeOutUp'
            }, toast); 
      $.ajax({
            url: baseUrl + "/master/datajabatan/delete-jabatan/"+ id,
            type: 'GET',
            success: function (response, customer) {
                if (response.status == 'sukses') {
                    window.location.reload();
                    iziToast.success({
                        timeout: 5000,
                        position: "topRight",
                        icon: 'fa fa-chrome',
                        title: '',
                        message: 'Berhasil Menghapus.'
                    });
                } else {
                    iziToast.error({
                        position: "topRight",
                        title: '',
                        message: 'Hapus Gagal (Data Adalah Parent)'
                    });
                }
            }
        })
      }
        ],
        [
          '<button>Close</button>',
           function (instance, toast) {
            instance.hide({
              transitionOut: 'fadeOutUp'
            }, toast);
          }
        ]
      ]
    }); 

         
      }

      function lihatJabPro(){
          $('#tbl_jabatanpro').dataTable().fnDestroy();
          $('#tbl_jabatanpro').DataTable({
              processing: true,
              serverSide: true,
              ajax: {
                  url: baseUrl + "/master/datajabatan/tableproduksi",
              },
              columns: [
                  {data : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"},
                  {data: 'c_jabatan_pro', name: 'c_jabatan_pro', "width" : "85%"},
                  {data: 'action', name: 'action', "width" : "10%"},
              ],
              "responsive": true,

              "pageLength": 10,
              "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "All"]],
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

    function editJPro(id){
        $.ajax({
          type: "GET",
          url: '{{ url("master/datajabatan/pro/edit") }}' + '/' + id,
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

    function hapusJPro(id){
      iziToast.show({
      color: 'red',
      title: 'Peringatan',
      message: 'Apakah anda yakin!',
      position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
      progressBarColor: 'rgb(0, 255, 184)',
      buttons: [
        [
          '<button>Ok</button>',
          function (instance, toast) {
            instance.hide({
              transitionOut: 'fadeOutUp'
            }, toast); 
      $.ajax({
            url: baseUrl + "/datajabatan/hapus-jabatanpro/"+ id,
            type: 'GET',
            success: function (response, customer) {
                if (response.status == 'sukses') {
                    lihatJabPro()
                    iziToast.success({
                        timeout: 5000,
                        position: "topRight",
                        icon: 'fa fa-chrome',
                        title: '',
                        message: 'Berhasil Menghapus.'
                    });
                } else {
                    iziToast.error({
                        position: "topRight",
                        title: '',
                        message: 'Gagal Menghapus.'
                    });
                }
            }
        })
      }
        ],
        [
          '<button>Close</button>',
           function (instance, toast) {
            instance.hide({
              transitionOut: 'fadeOutUp'
            }, toast);
          }
        ]
      ]
    }); 
    }

  </script> @endsection
