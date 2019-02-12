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
    <div class="clearfix"></div>
  </div>
  <!--BEGIN PAGE CONTENT PAGE-->
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
                <div align="left" class="col-md-6 col-sm-6 col-xs-6" style="margin-bottom:10px;">
                  <button class="btn btn-box-tool btn-sm btn-flat" type="button" id="btn_refresh_index" onclick="refresh()">
                    <i class="fa fa-undo" aria-hidden="true">&nbsp;</i> Refresh
                  </button>
                </div>

                <div align="right" class="col-md-6 col-sm-6 col-xs-6" style="margin-bottom:10px;">
                  <a href="{{ url('master/databarang/tambah_barang') }}">
                    <button type="button" class="btn btn-box-tool" title="Tambahkan Data Item">
                      <i class="fa fa-plus" aria-hidden="true">
                      &nbsp;
                      </i>Tambah Data
                    </button>
                  </a>
                </div>
               
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="table-responsive">
                    <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="data">
                      <thead>
                        <tr>
                          <th class="wd-15p" width="5%">Kode</th>
                          <th class="wd-15p">Nama Barang</th>
                          <th class="wd-15p">Type</th>
                          <th class="wd-15p">Satuan</th>
                          <th class="wd-15p">Kelompok Barang</th>
                          <th class="wd-15p">Harga Beli</th>
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
<!--END PAGE WRAPPER-->
</div>

@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    //fix to issue select2 on modal when opening in firefox
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    //add bootstrap class to datatable
    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);
      
    $('#data').DataTable({
      processing: true,
      // responsive:true,
      serverSide: true,
      ajax: {
        url:'{{ route('datatable_barang') }}',
      },
      columnDefs: [
         
      ],
        "columns": [
          { "data": "i_code" },
          { "data": "i_name" },
          { "data": "i_type" },
          { "data": "m_sname" },
          { "data": "m_gname" },
          { "data": "m_pbuy1" ,render: $.fn.dataTable.render.number( '.', '.', 2, '' )},
          { "data": "aksi" },
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
  }); //end jquery

  function gantiStatus(id, statusBrg) {
    iziToast.question({
      timeout: 20000,
      close: false,
      overlay: true,
      displayMode: 'once',
      // id: 'question',
      zindex: 999,
      title: 'Ubah Status',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
            $.ajax({
              type: "POST",
              url: '{{ route('ubah_status') }}',
              data: {id:id, statusBrg:statusBrg, "_token": "{{ csrf_token() }}"},
              success: function(response){
                if(response.status == "sukses")
                {
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.success({
                    position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                    title: 'Pemberitahuan',
                    message: response.pesan,
                    onClosing: function(instance, toast, closedBy){
                      refresh();
                    }
                  });
                }
                else
                {
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.error({
                    position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                    title: 'Pemberitahuan',
                    message: response.pesan,
                    onClosing: function(instance, toast, closedBy){
                      refresh();
                    }
                  }); 
                }
              },
              error: function(){
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
    
  function edit(id) {
    $.ajax({
      type: "GET",
      url: '{{ route('edit_barang') }}',
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

  function refresh() {
    $('#data').DataTable().ajax.reload();
  }
</script>
@endsection()