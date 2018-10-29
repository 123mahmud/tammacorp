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
                  <div class="page-title">Transfer Grosir</div>
              </div>
              <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                  <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                  <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                  <li class="active">Transfer Grosir</li>
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
                      <a href="#data-transfer" data-toggle="tab">Persetujuan Transfer</a>
                    </li>
                    <li>
                      <a href="#nav-stock" data-toggle="tab" onclick="cariTanggalTransfer()">Transfer Ke Retail</a>
                    </li>
                  </ul>
                  <div id="generalTabContent" class="tab-content responsive">
                        <div id="data-transfer" class="tab-pane fade in active"> 

                              <div class="col-md-2 col-sm-3 col-xs-12">
                                <label class="tebal">Tanggal Persetujuan</label>
                              </div>

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <div class="input-daterange input-group">
                                    <input id="tanggal1" class="form-control input-sm datepicker1" name="tanggal" type="text">
                                    <span class="input-group-addon">-</span>
                                    <input id="tanggal2" class="input-sm form-control datepicker2" name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-3 col-xs-12" align="left">
                                <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="cariTanggal()">
                                  <strong>
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                  </strong>
                                </button>
                              </div>
                              <div class="col-md-3 col-sm-3 col-xs-12" style="margin-bottom: 15px;" align="right">

                                    <select name="tampilData" id="tampil_data" class="form-control input-sm" >
                                      <option value="Semua" class="form-control">Tampilkan Data : Semua</option>
                                      <option value="Waiting" class="form-control">Tampilkan Data : Waiting</option>
                                      <option value="Approved" class="form-control">Tampilkan Data : Approved</option>
                                      <option value="Send" class="form-control">Tampilkan Data : Send</option>
                                      <option value="Received" class="form-control">Tampilkan Data : Received</option>
                                    </select>

                              </div>
                            <div class="panel-body">
                              <table class="table tabelan table-bordered no-padding" 
                              id="acceptTransfer">
                                  <thead>
                                    <tr>
                                      <th width="15%">Tanggal</th>
                                      <th width="10%">Kode</th>              
                                      <th width="35%">Catatan</th>
                                    {{--   <th width="10%">Waktu</th> --}}
                                      <th width="10%">Status</th>              
                                      <th width="10%">Aksi</th>
                                    </tr>
                                  </thead>
                                  <tbody>

                                  </tbody>
                              </table>
                            </div>
                        </div>

                        <!-- div note-tab -->
                        <div id="nav-stock" class="tab-pane fade">
                          <div class="row">

                              <div class="col-md-2 col-sm-3 col-xs-12">
                                <label class="tebal">Tanggal Transfer</label>
                              </div>

                              <div class="col-md-4 col-sm-6 col-xs-12">
                                <div class="form-group">
                                  <div class="input-daterange input-group">
                                    <input id="tanggal3" class="form-control input-sm datepicker1" name="tanggal" type="text">
                                    <span class="input-group-addon">-</span>
                                    <input id="tanggal4" class="input-sm form-control datepicker2" name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                                  </div>
                                </div>
                              </div>

                              <div class="col-md-3 col-sm-3 col-xs-12" align="left">
                                <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="cariTanggalTransfer()">
                                  <strong>
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                  </strong>
                                </button>

                              </div>

                            
                              <div class="col-md-3 col-sm-3 col-xs-12" align="right" style="margin-bottom: 15px;">
                                  <button  data-toggle="modal" onclick="noNota()" aria-controls="list" role="tab"  class="btn-primary btn-flat btn-sm"><i class="fa fa-plus" aria-hidden="true"></i> &nbsp; Transfer Item</button>

                                    <div style="margin-bottom: 15px;"></div>

                                  <select name="tampilData" id="tampil_data_Transfer" class="form-control input-sm" >
                                    <option value="Semua" class="form-control">Tampilkan Data : Semua</option>
                                    <option value="Send" class="form-control">Tampilkan Data : Send</option>
                                    <option value="Received" class="form-control">Tampilkan Data : Received</option>
                                  </select>

                                </div>
                            <div class="panel-body">
                              <div class="table-responsive no-padding">       
                                <table class="table tabelan table-bordered no-padding" width="100%" id="transfer_retail">
                                    <thead>
                                      <tr>
                                        <th width="15%">Tanggal</th>
                                        <th width="10%">Kode</th>              
                                        <th width="35%">Catatan</th>
                                    {{--     <th width="7%">Waktu</th> --}}
                                        <th width="10%">Status</th>              
                                        <th width="10%">Aksi</th>
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
                          <!-- End DIv note-tab -->
                   @include('transfer-grosir.modal-transfer')  

                </div>
              @include('transfer-grosir.modal-edit-tf-grosir')  
        <!-- End div generalTab -->
            </div>

          </div>
        </div>

      </div>  
              @include('transfer-grosir.modal-approve')

    </div>
@endsection
@section("extra_scripts")
    <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
    <script src="{{ asset ('assets/script/bootstrap-datepicker.js') }}"></script>

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
    var date = new Date();
    var newdateIndex = new Date(date);
    var newdate = new Date(date);

    newdateIndex.setDate(newdate.getDate()-30);
    newdate.setDate(newdate.getDate()-3);

    var ndi = new Date(newdateIndex);
    var nd = new Date(newdate);

    $('.datepicker').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
    }).datepicker("setDate", ndi);

    $('.datepicker1').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
    }).datepicker("setDate", nd);

    $('.datepicker2').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
    });

    cariTanggal();
    $('#tampil_data').on('change', function() {
      cariTanggal();
    })

    $('#tampil_data_Transfer').on('change', function() {
      cariTanggalTransfer();
    })

    $('#myTransferToRetail').on('shown.bs.modal', function () {
      $('#tf_note').focus()
    }) 

  });

    function edit($id){
            $.ajax({
                    url         : baseUrl+'/penjualan/POSgrosir/approve-transfer/'+$id+'/edit',
                    type        : 'get',
                    timeout     : 10000,                                        
                    success     : function(response){
                        $('#data-transfer-appr').html(response);
                         $('#myTransfer').modal('show');
                        }
            });
    }


     function hapus($id){
            $.ajax({
                    url         : baseUrl+'/penjualan/POSgrosir/approve-transfer/'+$id+'/hapus',
                    type        : 'get',
                    timeout     : 10000,                                        
                    success     : function(response){
                        $('#data-transfer').html(response);
                        }
            });
     }


  function simpanApprove(){
    $('.simpanApprove').attr('disabled','disabled'); 
    $no_transfer = $('input[name="ri_nomor"]').val();
    $.ajax({
        url         : baseUrl+'/penjualan/POSgrosir/approve-transfer/simpan-approve',
        type        : 'get',
        timeout     : 10000,  
        data: item+'&'+tableReq.$('input').serialize(),
        dataType:'json',                                      
        success     : function(response){
          if(response.status=='sukses'){
            iziToast.success({timeout: 5000, 
                    position: "topRight",
                    icon: 'fa fa-chrome', 
                    title: '',
                    message: 'Data tersimpan.'});
            transfer.ajax.reload();
            window.open(baseUrl+'/inventory/POSgrosir/print_setuju/'+$no_transfer);
            $('#myTransfer').modal('hide');
          $('.simpanApprove').removeAttr('disabled','disabled');
          }else{
            iziToast.error({position: "topRight",
                    title: '', 
                    message: 'Data gagal tersimpan.'});
          $('.simpanApprove').removeAttr('disabled','disabled');
          }
        }
    });
  }

 function noNota(){
         $.ajax({
                    url         : baseUrl+'/transfer/no-nota',
                    type        : 'get',
                    timeout     : 10000,
                    dataType    :'json',
                    success     : function(response){
                        $('#no-nota').val(response);
                        $('#myTransferToRetail').modal('show');
                        }
                    });
    }

 tableReq=$('#transfer-detail').DataTable();

      //transfer thoriq
  $( "#stf_namaitem" ).focus(function(){
      var key = 1;
    $("#stf_namaitem").autocomplete({
        source: baseUrl+'/penjualan/transfer/grosir/transfer-item',
        minLength: 1,
        select: function(event, ui) {        
          $('#stf_namaitem').val(ui.item.label);        
          $('#stf_kode').val(ui.item.id);
          $('#stf_detailnama').val(ui.item.name);        
          $('#sstf_qty').val(ui.item.qty);
          $('#stf_stok').val(ui.item.qty);
          $('#stf_code').val(ui.item.code);
          $("input[name='stf_qty']").focus();
        }
    });
      $("#stf_namaitem").val('');
      $("#stf_kode" ).val('');
      $('#stf_detailnama').val('');
      $("#stf_qty").val('');
      $("#sstf_qty").val('');
      $("#stf_stok").val('');
      $("#stf_code").val('');
  });

    $('#tf_note').keypress(function(e){
      var charCode;
      if ((e.which && e.which == 13)) {
        charCode = e.which;
      }else if (window.event) {
          e = window.event;
          charCode = e.keyCode;
      }
      if ((e.which && e.which == 13)){
        $("input[name='stf_namaitem']").focus();
        return false;
      }
    });

  $('#stf_qty').keypress(function(e){      
      var qtyStok   =parseInt($('#sstf_qty').val()); 
      var qtySend   =parseInt($('#stf_qty').val()); 
      var charCode;
      if ((e.which && e.which == 13)) {
        charCode = e.which;
      }else if (window.event) {
          e = window.event;
          charCode = e.keyCode;
      }
      if ((e.which && e.which == 13)){
        var isi   = $('#stf_qty').val();
        var nama= $('#stf_detailnama').val();
        if(nama == '' || isi == ''|| isi == '0'){
          toastr.warning('Item dan Jumlah tidak boleh kosong');
          return false;
        }
        else if(qtyStok-qtySend<0){
          toastr.warning('Stok Tidak Mencukupi');
          return false;
        }
        tambahTf();
        $("#stf_namaitem").val('');
        $("#stf_qty").val('');
        $("#sstf_qty").val('');
        $("input[name='stf_namaitem']").focus();
           return false;  
      }
   });

   var rindex=0;
    var rtamp=[];
      function tambahTf() {   
        var kode  = $('#stf_kode').val(); 
        var code  = $('#stf_code').val();     
        var nama  = $('#stf_detailnama').val();                                
        var qty   = parseInt($('#stf_qty').val());        
        var Hapus = '<button type="button" class="btn btn-danger hapus" onclick="rhapus(this)"><i class="fa fa-trash-o"></i></button>';
        var rindex = rtamp.indexOf(kode);

        if ( rindex == -1){     
            tableReq.row.add([
              code,
              nama+'<input type="hidden" name="kode_item[]" class="kode_item kode" value="'+kode+'">',
              '<input size="30" style="text-align:right;" type="text"  name="sd_qty[]" class="sd_qty form-control tf_qty-'+kode+'" value="'+qty+'"> ',
              
              Hapus
              ]);

            tableReq.draw();
        rindex++;

        rtamp.push(kode);
            }else{
            var qtyLawas = parseInt($(".tf_qty-"+kode).val());
            var c = $(".tf_qty-"+kode).val(qtyLawas + qty);

            }

          var kode  =$('#stf_kode').val('');      
          var nama  =$('#stf_detailnama').val('');
        }

  function simpanTransfer() {
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $('.simpan').attr('disabled','disabled');
    var item = $('#master_transfer :input').serialize();
    var data = tableReq.$('input').serialize();
    $.ajax({
    url : baseUrl + "/penjualan/transfer/grosir/simpan-transfer-grosir",
    type: 'POST',
    data: item+'&'+data,
    dataType:'json',
    success:function(response, nota){     
      if(response.status=='sukses'){
        var nota = response.nota;
        $('#myTransferToRetail').modal('hide');
        transfer_retail.ajax.reload();
        iziToast.success({timeout: 5000, 
                          position: "topRight",
                          icon: 'fa fa-chrome', 
                          title: nota, 
                          message: 'Telah terkirim.'});
        $('#master_transfer')[0].reset();
        tableReq.row().clear().draw(false);
        var inputs = document.getElementsByClassName( 'kode' ),
        names  = [].map.call(inputs, function( input ) {
            return input.value;
        });
        rtamp = names;
        window.open(baseUrl+'/inventory/POSgrosir/print_setuju/'+ nota);
        $('.simpan').removeAttr('disabled','disabled');           
      }else{
        iziToast.error({position: "topRight",
                        title: '', 
                        message: 'Mohon melengkapi data.'});  
        $('.simpan').removeAttr('disabled','disabled');
      } 
    }
    })
  }

      function updateTransfer($id) {
        $no_transfer2 = $('input[name="ri_nomor"]').val();
        var item = $('#edit_request :input').serialize();
        var data = tableTf.$('input').serialize();
        $.ajax({
          url : baseUrl + "/penjualan/POSgrosir/update-transfer-grosir/"+$id,
          type: 'get',
          data: item+'&'+data,
          dataType:'json',
            success:function(response){
              if(response.status=='sukses'){
              iziToast.success({timeout: 5000, 
                          position: "topRight",
                          icon: 'fa fa-chrome', 
                          title: '', 
                          message: 'Berhasil di update.'});
              $('#EditTransfer').modal('hide');
              window.open(baseUrl+'/inventory/POSgrosir/print_setuju/'+$no_transfer2);               
            }    
          }
        })
      }

  function rhapus(a){
    var par = a.parentNode.parentNode;
    tableReq.row(par).remove().draw(false);

  var inputs = document.getElementsByClassName( 'kode' ),
      names  = [].map.call(inputs, function( input ) {
          return input.value;
      });
      rtamp = names;

     }


      function editTransferGrosir($id){
            $.ajax({
                    url         : baseUrl+'/penjualan/POSgrosir/edit-transfer-grosir/'+$id+'/edit',
                    type        : 'get',
                    timeout     : 10000,                                        
                    success     : function(response){
                        $('#edit-data-transfer').html(response);
                         $('#EditTransfer').modal('show');
                        }
            });
     }


     function hapusTransferGrosir($id){
            $.ajax({
                    url         : baseUrl+'/penjualan/POSgrosir/hapus-transfer-grosir/hapus/'+$id,
                    type        : 'get',
                    timeout     : 10000,    
                    dataType    :'json',
                    success     : function(response){
                          if(response.status=='sukses'){
                                      alert('Berhasil Di Hapus');                                        
                                      tfToRetail();
                          }    
                    }
                        
            });
     }

  function cariTanggal(){
    $('#acceptTransfer').dataTable().fnDestroy();
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    var tampil=$('#tampil_data').val();
    transfer = $('#acceptTransfer').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url : baseUrl + "/transfer/grosir/table_transfer/"+tgl1+'/'+tgl2+'/'+tampil,
    },
    columns: [
      {data: 'ti_time', name: 'ti_time'},
      {data: 'ti_code', name: 'ti_code'},
      {data: 'ti_note', name: 'ti_note'},
      // {data: 'ti_time', name: 'ti_time'},
      {data: 'status', name: 'status'},
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
  }

  function cariTanggalTransfer(){
    $('#transfer_retail').dataTable().fnDestroy();
    var tgl3 = $('#tanggal3').val();
    var tgl4 = $('#tanggal4').val();
    var tampil1 = $('#tampil_data_Transfer').val();
    transfer_retail = $('#transfer_retail').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url : baseUrl + "/transfer/grosir/transfer_retail/"+tgl3+'/'+tgl4+'/'+tampil1,
    },
    columns: [
      {data: 'ti_time', name: 'ti_time', width:'15%'},
      {data: 'ti_code', name: 'ti_code', width:'10%'},
      {data: 'ti_note', name: 'ti_note', width:'35%'},
      // {data: 'ti_time', name: 'ti_time', width:'10%'},
      {data: 'status', name: 'status', width:'10%'},
      {data: 'action', name: 'action', width:'10%', orderable: false, searchable: false},
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
  }

    </script>
    
@endsection()