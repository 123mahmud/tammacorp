@extends('main')
@section('content')
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
</style>
    <!--BEGIN PAGE WRAPPER-->
  <div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
      <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
          <div class="page-title">Manajemen Harga</div>
      </div>
      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
          <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
          <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
          <li class="active">Manajemen Harga</li>
      </ol>
      <div class="clearfix"></div>
    </div>
    <div class="page-content fadeInRight">
      <div id="tab-general">
          <div class="row mbl">
              <div class="col-lg-12">
                <div class="col-md-12">
                  <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;"></div>
                </div>
                <ul id="generalTab" class="nav nav-tabs">
                  <li class="active"><a href="#alert-tab" data-toggle="tab">Manajemen Harga</a></li>
                </ul>
                <div id="generalTabContent" class="tab-content responsive">
                  <div id="alert-tab" class="tab-pane fade in active">
                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                          <table class="table tabelan table-bordered table-hover" id="data-harga" width="100%">
                            <thead>
                              <tr>
                                <th>No</th>
                                <th>Kode - Nama Item</th>
                                <th>Item Type</th>
                                <th>Item Group</th>
                                <th>Harga A</th>
                                <th>Harga B</th>
                                <th>Harga C</th>
                                <th>HPP</th>
                                <th>Barang Rusak</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            <tbody>

                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>             
                  </div>
                  <!-- /div alert-tab -->
                      <!--Modal view Edit formula-->
                      <div class="modal fade" id="myModalEdit" role="dialog">
                        <div class="modal-dialog modal-lg">
                          <form id="myFormUpdate">
                            <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header" style="background-color: #e77c38;">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title" style="color: white;">Form Edit Harga</h4>
                                </div>
                                <div id="edit-mpsell">

                                </div>
                                <div class="modal-footer" style="border-top: none;">
                                  <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary" id="btn-simpan-edit" onclick="updatePrice()">Update Data</button>
                                </div>
                              </div>
                            </form>   
                          </div>
                      </div>
                      <!--End Modal-->
                  <!-- div note-tab -->
                  <div id="note-tab" class="tab-pane fade">
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
                  </div><!-- /div label-badge-tab -->
                </div>
      
            </div>
          </div>

        </div>
      </div>
  </div>


@endsection
@section("extra_scripts")
{{-- <script src="{{ asset ('assets/script/icheck.min.js') }}"></script> --}}
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

    $('.datepicker').datepicker({
      format: "mm",
      viewMode: "months",
      minViewMode: "months"
    });

    $('.datepicker2').datepicker({
      format:"dd-mm-yyyy"
    });  

  });

  var dataHarga =  $('#data-harga').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url : baseUrl + "/penjualan/manajemenharga/tabelharga",
    },
    columns: [
      {data: 'DT_Row_Index', name: 'DT_Row_Index'},
      {data: 'i_name', name: 'i_name'},
      {data: 'i_type', name: 'i_type'},
      {data: 'm_gname', name: 'm_gname'},
      {data: 'm_psell1', name: 'm_psell1'},
      {data: 'm_psell2', name: 'm_psell2'},
      {data: 'm_psell3', name: 'm_psell3'},
      {data: 'm_hpp', name: 'm_hpp'},
      {data: 'm_barang_rusak', name: 'm_barang_rusak'},
      {data: 'action', name: 'action', orderable: false, searchable: false},
    ],
    language: {
      searchPlaceholder: "Cari Data",
      emptyTable: "Tidak ada data",
      sInfo: "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
      sSearch: '<i class="fa fa-search"></i>',
      sLengthMenu: "Menampilkan &nbsp; _MENU_ &nbsp; Data",
      infoEmpty: "",
      paginate: {
            previous: "Sebelumnya",
            next: "Selanjutnya",
         }
    }
  });

  function editmpsell(id){
    $.ajax({
      url : baseUrl + "/penjualan/manajemenharga/edit/mpsell/"+id,
      type: 'GET',
      success : function(response){
        $('#edit-mpsell').html(response);
      }
    });
  } 

  function updatePrice(){
    var data = $('#myFormUpdate').serialize();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
      url : baseUrl + "/penjualan/manajemenharga/update/mpsell",
      type: 'POST',
      data: data,
      success : function(response){
        if (response.status=='sukses'){
          dataHarga.ajax.reload();
          iziToast.success({timeout: 5000, 
                          position: "topRight",
                          icon: 'fa fa-chrome', 
                          title: '', 
                          message: 'Berhasil update harga.'});
          $('#myModalEdit').modal('hide');
        }else{
          iziToast.error({position: "topRight",
                        title: '', 
                        message: 'Gagal update harga.'}); 
        }
      }
    });
  }
</script>
@endsection()