@extends('main')
@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Master Data Barang</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Master Data Barang</li>
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
                                <li class="active"><a href="#alert-tab" data-toggle="tab">Master Data Barang</a></li>
                                <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                                <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
                              </ul>
                              <div id="generalTabContent" class="tab-content responsive">

                                <div id="alert-tab" class="tab-pane fade in active">

                                  <div class="row" style="margin-top:-15px;">


                                  <div align="right" class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px;">

                                    <a href="{{ url('master/itemproduksi/tambah_item') }}">
                                    <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                                     <i class="fa fa-plus" aria-hidden="true">
                                         &nbsp;
                                     </i>Tambah Data
                                    </button></a>

                                  </div>

                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                          <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                            <thead>
                                <tr>
                                  <th class="wd-15p" width="5%">Kode Barang</th>
                                  <th class="wd-15p">Nama Barang</th>
                                  <th class="wd-15p">Satuan</th>
                                  <th class="wd-15p">Kelompok Barang</th>
                                  <th class="wd-15p" width="10%">Aksi</th>
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
      </div>
    </div>

@endsection
@section("extra_scripts")
    <script type="text/javascript">
      var extensions = {
           "sFilterInput": "form-control input-sm",
          "sLengthSelect": "form-control input-sm"
      }
      // Used when bJQueryUI is false
      $.extend($.fn.dataTableExt.oStdClasses, extensions);
      // Used when bJQueryUI is true
      $.extend($.fn.dataTableExt.oJUIClasses, extensions);

    var tableItem = $('#data').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url : baseUrl + "/master/tableproduksi/table",
            },
             columnDefs: [
                ],
            "columns": [
            { "data": "i_code" },
            { "data": "i_name" },
            { "data": "m_sname" },
            { "data": "m_gname" },
            { "data": "aksi", className: 'center' },
            ],
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

  function ubahStatus(a){
    $('#status'+a).attr('disabled','disabled');
    $.ajaxSetup({
      headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
      });
    iziToast.show({
        timeout: false,
        color: 'red',
        title: '',
        message: 'Yakin ingin merubah status.',
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
                url : baseUrl + "/master/itemproduksi/ubah_status/"+a,
                type: 'GET',
                data: a,
                success:function(response){
                if (response.status=='sukses') {
                    iziToast.success({timeout: 5000,
                                    position: "topRight",
                                    icon: 'fa fa-chrome',
                                    title: '',
                                    message: 'Status brhasil di ganti.'});
                    tableItem.ajax.reload();
                    $('#status'+a).removeAttr('disabled','disabled');
                  }else{
                    iziToast.error({position: "topRight",
                                  title: '',
                                  message: 'Status gagal di ubah.'});
                    $('#status'+a).removeAttr('disabled','disabled');
                  }
                }

              });
            }
          ],
          [
            '<button>Close</button>',
             function (instance, toast) {
              $('#status'+a).removeAttr('disabled','disabled');
              instance.hide({
                transitionOut: 'fadeOutUp'
              }, toast);
            }
          ]
        ]
      })
    }


         function edit(a) {
          $.ajax({
               type: "get",
               url : baseUrl + '/master/itemproduksi/edit_item/'+a,
               success: function(data){
               },
               complete:function (argument) {
                window.location=(this.url)
               },
               error: function(){

               },
               async: false
             });
        }
      </script>
@endsection()
