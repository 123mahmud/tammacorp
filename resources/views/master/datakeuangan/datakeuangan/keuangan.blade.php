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
            <div class="page-title">Master Data Akun Keuangan</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Master Data Akun Keuangan</li>
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
              <li><a href="#general-tab" data-toggle="tab" {{-- onclick="daftarTabelOrder()" --}}>Data Akun Type General</a></li>
              <li class="active"><a href="#alert-tab" data-toggle="tab">Master Data Akun Keuangan</a></li>
              {{-- <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> --}}
            </ul>
            
            <div id="generalTabContent" class="tab-content responsive">

              <div id="general-tab" class="tab-pane fade in">
                <div class="row" style="margin-top:-20px;">
                  <div align="right" class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px;">
                    {{-- <a href="{{ url('master/datakeuangan/tambah_akun') }}">
                      <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                        <i class="fa fa-plus" aria-hidden="true">
                         &nbsp;
                        </i>Tambah Data
                      </button>
                    </a> --}}
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="table-responsive">
                      <table class="table tabelan table-hover table-responsive table-bordered" width="100%" cellspacing="0" id="tbl_General">
                        <thead>
                          <tr>
                            {{-- <th class="sorting_disabled"></th> --}}
                            <th class="wd-15p text-center">Nomor Akun</th>
                            <th class="wd-15p text-center">Nama Akun</th>
                            <th class="wd-15p text-center">Kelompok Akun</th>
                            <th class="wd-15p text-center">Debet/Kredit</th>
                          </tr>
                        </thead>
                       
                        <tbody>

                        </tbody>
          
                      </table> 
                    </div>

                  </div>
                
                </div>
              </div>

              <div id="alert-tab" class="tab-pane fade in active">
                <div class="row" style="margin-top:-20px;">
                  <div align="right" class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px;">
                    <a href="{{ url('master/datakeuangan/tambah_akun') }}">
                      <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                        <i class="fa fa-plus" aria-hidden="true">
                         &nbsp;
                        </i>Tambah Data
                      </button>
                    </a>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="table-responsive">
                      <table class="table tabelan table-hover table-responsive table-bordered" width="100%" cellspacing="0" id="tbl_customer">
                        <thead>
                          <tr>
                            {{-- <th class="sorting_disabled"></th> --}}
                            <th class="wd-15p text-center">Nomor Akun</th>
                            <th class="wd-15p text-center">Nama Akun</th>
                            <th class="wd-15p text-center">Kelompok Akun</th>
                            <th class="wd-15p text-center">Debet/Kredit</th>
                            <th class="wd-15p text-center">Neraca</th>
                            <th class="wd-15p text-center">Laba Rugi</th>
                            <th class="wd-15p text-center">Aksi</th>
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
      
      $('#tbl_customer').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route('datatable_akun', 'list=detail') }}',
            },
             columnDefs: [
                  {"className": "center d_id", "targets": 0},
                  {"className": "center", "targets": "_all"}
                ],
            "columns": [
              { "data": "id_akun" },
              { "data": "nama_akun" },
              { "data": "kelompok_akun" },
              { "data": "posisi_akun" },
              { "data": "group_neraca" },
              { "data": "group_laba_rugi" },
              { "data": "action" },
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

      $('#tbl_General').DataTable({
            processing: true,
            // responsive:true,
            serverSide: true,
            ajax: {
                url:'{{ route('datatable_akun', 'list=general') }}',
            },
             columnDefs: [
                  {"className": "center d_id", "targets": 0},
                  {"className": "center", "targets": "_all"}
                ],
            "columns": [
              { "data": "id_akun" },
              { "data": "nama_akun" },
              { "data": "kelompok_akun" },
              { "data": "posisi_akun" },
              // { "data": "group_neraca" },
              // { "data": "group_laba_rugi" },
              // { "data": "action" },
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

      function hapus(conteks, a) {
        $(conteks).attr('disabled', 'disabled');

        $.ajax({
          type: "post",
          url: '{{ route('hapus_akun') }}',
          data: {id: a, _token: '{{ csrf_token() }}'},
          dataType: 'json',
          success: function(response){

            if(response == "error")
              alert('Data Akun Gagal Dihapus');

            if(response == "sukses"){
              alert('Data Akun Berhasil Dihapus');

              $(conteks).closest('tr').remove();
            }
          },
          error: function (e){
            alert(e)
          }
        })
      }


      function edit(a) {
        var parent = $(a).parents('tr');
        var id = $(parent).find('.d_id').text();
        console.log(id);
        $.ajax({
             type: "get",
             url: '{{ route('edit_akun') }}',
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