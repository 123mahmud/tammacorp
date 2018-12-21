@extends('main')
@section('content')
<style type="text/css">
  td.details-control {
    background: url({{ asset('assets/images/details_open.png') }}) no-repeat center center;
    cursor: pointer;
}
 .sorting_disabled {

}
tr.details td.details-control {
     background: url({{ asset('assets/images/details_close.png')}}) no-repeat center center;
}

/*tr.details td.details-control {
    background: url({{ asset('assets/images/details_close.png')}}) no-repeat center center;
}*/
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Group Harga Khusus</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Group Harga Khusus</li>
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
              <li class="active"><a href="#alert-tab" data-toggle="tab">Group Harga Khusus</a></li>
              <li><a href="#note-tab" data-toggle="tab" onclick="masterGroup()">Master Group</a></li>
              {{-- <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> --}}
            </ul>

            <div id="generalTabContent" class="tab-content responsive">
              <div id="alert-tab" class="tab-pane fade in active">
                <div class="row" style="margin-top:-20px;">
                  <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="col-md-2 col-sm-4 col-xs-12">
                      <label class="tebal">Pilih Group :</label>
                    </div>

                    <div class="col-md-3 col-sm-8 col-xs-12">
                      <div class="form-group">
                        <select class="form-control input-sm select2" id="idGroup" onchange="pilihGroup()" >
                          @foreach ($group as $grup)
                            <option value="{{ $grup->pg_id }}">{{ $grup->pg_name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="col-md-12 tamma-bg"  style="margin-top: 5px;margin-bottom: 5px;
                      margin-bottom: 40px; padding-bottom:20px;padding-top:20px;">
                        <div class="col-md-9">
                            <label class="control-label tebal" for="">Masukan Kode / Nama</label>
                            <div class="input-group input-group-sm" style="width: 100%;">
                                <input type="text" id="namaitem" name="item" class="form-control">
                                <input type="hidden" id="i_id" name="i_id" class="form-control">
                                <input type="hidden" id="i_code" name="i_code" class="form-control">
                                <input type="hidden" id="i_name" name="i_name" class="form-control">
                                <input type="hidden" id="m_sname" name="m_sname" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label tebal" name="qty">Qty Real</label>
                            <div class="input-group input-group-sm" style="width: 100%;">
                                <input type="number" id="qtyReal" name="qtyReal" class="form-control">
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="panel-body">
                    <div class="table-responsive">
                      <table class="table tabelan table-hover table-responsive table-bordered" width="100%" cellspacing="0" id="tbl_groupitem">
                        <thead>
                          <tr>
                            {{-- <th class="sorting_disabled"></th> --}}
                            <th class="wd-15p">Kode - Nama Item</th>
                            <th class="wd-15p">Harga</th>
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
              <div id="note-tab" class="tab-pane fade">
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
                                    <table class="table tabelan table-bordered table-hover dt-responsive" id="tb_group"
                                           style="width: 100%;">
                                        <thead>
                                          <th>No</th>
                                          <th>Nama Group</th>
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

      $('.select2').select2();
      pilihGroup();

      function pilihGroup(){
        var x = document.getElementById("idGroup").value;
        $('#tbl_groupitem').dataTable().fnDestroy();
        $('#tbl_groupitem').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url: baseUrl + '/master/grouphargakhusus/tablegroup/'+x,
            },
            "columns": [
            { "data": "i_name", width: '60%' },
            { "data": "ip_price", width: '30%' },
            { "data": "action", width: '10%' },
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
      }

      function masterGroup(){
        $('#tb_group').dataTable().fnDestroy();
        $('#tb_group').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url: baseUrl + '/master/grouphargakhusus/mastergroup/',
            },
            "columns": [
            {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
            { "data": "pg_name", width: '85%' },
            { "data": "action", width: '10%' },
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
      }

      function hapus(a) {
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
                var parent = $(a).parents('tr');
                var id = $(parent).find('.d_id').text();
                console.log(id);
                $.ajax({
                     type: "get",
                     url: '{{ route('hapus_cust') }}',
                     data: {id},
                     success: function(response){
                          if (response.status=='sukses') {
                            toastr.info('Data berhasil di hapus.');
                            tbl_customer.ajax.reload();
                          }else{
                            toastr.error('Data gagal di simpan.');
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


       function edit(a) {
        var parent = $(a).parents('tr');
        var id = $(parent).find('.d_id').text();
        console.log(id);
        $.ajax({
             type: "get",
             url: '{{ route('edit_cust') }}',
             data: {id},
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
@endsection
