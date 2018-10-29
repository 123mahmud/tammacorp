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
                        <div class="page-title">Transfer Retail</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li><i></i>&nbsp;Penjualan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Transfer Retail</li>
                    </ol>
                    <div class="clearfix"></div>
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
                                <a href="#transfer" data-toggle="tab">List Transfer</a>
                              </li>
                              <li>
                                <a href="#alert-tab" data-toggle="tab" onclick="cariTanggalPenerimaan()">Penerimaan Transfer</a>
                              </li>                            
                            </ul>
                            <div id="generalTabContent" class="tab-content responsive">                                 
                              <div id="transfer" class="tab-pane fade in active">
                                  <div class="col-md-2 col-sm-3 col-xs-12">
                                    <label class="tebal">Tanggal Transfer</label>
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

                                  <div style="margin-bottom: 15px;"></div>

                                  <div class="col-md-3 col-sm-3 col-xs-12" align="right" style="margin-bottom: 15px;">
                                    <button data-toggle="modal" onclick="noNota()" aria-controls="list" role="tab" class="btn-primary btn-flat btn-sm">
                                    <i class="fa fa-plus" aria-hidden="true"></i> 
                                      &nbsp; Request Item
                                    </button>

                                    <div style="margin-bottom: 15px;"></div>

                                    <select name="tampilData" id="tampil_data" class="form-control input-sm" >
                                      <option value="Semua" class="form-control">Tampilkan Data : Semua</option>
                                      <option value="Waiting" class="form-control">Tampilkan Data : Waiting</option>
                                      <option value="Approved" class="form-control">Tampilkan Data : Approved</option>
                                      <option value="Send" class="form-control">Tampilkan Data : Send</option>
                                      <option value="Received" class="form-control">Tampilkan Data : Received</option>
                                    </select>
                                    
                                  </div>

                                <div class="panel-body">
                                  <table class="table tabelan table-bordered no-padding" id="listTransfer" width="100%">
                                      <thead>
                                        <tr>
                                          <th width="15%">Tanggal</th>
                                          <th width="10%">Kode</th>              
                                          <th width="35%">Catatan</th>
                                         {{--  <th width="7%">Waktu</th> --}}
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
                              <div id="alert-tab" class="tab-pane fade">
                                    <div class="col-md-2 col-sm-3 col-xs-12">
                                      <label class="tebal">Tanggal Penerimaan</label>
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
                                      <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="cariTanggalPenerimaan()">
                                        <strong>
                                          <i class="fa fa-search" aria-hidden="true"></i>
                                        </strong>
                                      </button>

                                      
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12" style="margin-bottom: 15px;" align="right">

                                      <select name="tampilData" id="tampil_data_Penerimaan" class="form-control input-sm" >
                                        <option value="Semua" class="form-control">Tampilkan Data : Semua</option>
                                        <option value="Send" class="form-control">Tampilkan Data : Send</option>
                                        <option value="Received" class="form-control">Tampilkan Data : Received</option>
                                      </select>
                                    </div>

                                  <div class="panel-body">
                                    <div class="table-responsive no-padding">       
                                     <table class="table tabelan table-bordered no-padding" id="terimaTransfer" width="100%">
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
                          
                              <!-- End DIv note-tab -->
                          </div>
                     </div>     
          
                    </div>
                  <!-- End div generalTab -->
                  </div>
                </div>
                          <div class="modal fade" id="myReceived" role="dialog">
                            <div class="modal-dialog modal-lg">
                            
                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title">Detail terima</h4>
                                </div>
                              <div class="modal-body">

                                <div id="dataReceived">
                                  
                                </div>
                                  
                              </div>
                              
                            </div>

                          </div>

                          </div>

                  @include('penjualan.POSretail.StokRetail.transfer')
              </div>
                @include('transfer.modal-transfer')    
            </div>  
            @include('transfer.penerimaan.modal-penerimaan') 

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

    $('#tampil_data_Penerimaan').on('change', function() {
      cariTanggalPenerimaan();
    })

    $('#myTransfer').on('shown.bs.modal', function () {
      $('#ri_keterangan').focus()
    }) 

    // $('#myTransferPenerimaan').on('shown.bs.modal', function () {
    //   $('.terima').focus()
    // }) 

  });

  function noNota(){
    $.ajax({
      url         : baseUrl+'/transfer/no-nota',
      type        : 'get',
      timeout     : 10000,
      dataType    :'json',
      success     : function(response){
          $('#myTransfer').modal('show');
          }
      });
    }

    $('#ri_keterangan').keypress(function(e){
      var charCode;
      if ((e.which && e.which == 13)) {
        charCode = e.which;
      }else if (window.event) {
          e = window.event;
          charCode = e.keyCode;
      }
      if ((e.which && e.which == 13)){
        $("input[name='rnamaitem']").focus();
        return false;
      }
    });

    $('#rnamaitem').keypress(function(e){
      var charCode;
      if ((e.which && e.which == 13)) {
        charCode = e.which;
      }else if (window.event) {
          e = window.event;
          charCode = e.keyCode;
      }
      if ((e.which && e.which == 13)){
        return false;
      }
    });

    tableReq = $('#detail-req').DataTable();

      //transfer thoriq
    $("#rnamaitem").autocomplete({
        source: baseUrl+'/penjualan/POSretail/retail/transfer-item',
        minLength: 1,
        select: function(event, ui) {        
          $('#rnamaitem').val(ui.item.label);   
          $('#code').val(ui.item.code);
          $('#rkode').val(ui.item.id);
          $('#rdetailnama').val(ui.item.name);        
          $('#rqty').val(ui.item.qty);
          $("input[name='rqty']").focus();
        }
      });

    $( "#rnamaitem" ).focus(function(){
      var key = 1;
      $("#rnamaitem").autocomplete({
        source: baseUrl+'/penjualan/POSretail/retail/transfer-item',
        minLength: 1,
        select: function(event, ui) {
          $('#rnamaitem').val(ui.item.label);   
          $('#code').val(ui.item.code);
          $('#rkode').val(ui.item.id);
          $('#rdetailnama').val(ui.item.name);        
          $('#rqty').val(ui.item.qty);
          $("input[name='rqty']").focus();
        }
      });
      $("#rnamaitem").val('');
      $("#code" ).val('');
      $('#rkode').val('');
      $("#rqty").val('');
      $("#rdetailnama").val('');
    });

  //enter stock
  $('#rqty').keypress(function(e){
      var charCode;
      if ((e.which && e.which == 13)) {
        charCode = e.which;
      }else if (window.event) {
          e = window.event;
          charCode = e.keyCode;
      }
      if ((e.which && e.which == 13)){
        var isi   = $('#rqty').val();
        var jumlah= $('#rdetailnama').val();
        if(isi == '' || jumlah == ''){
          toastr.warning('Item dan Jumlah tidak boleh kosong');
          return false;
      }
        tambahreq();
        $("#rnamaitem").val('');
        $("#rqty").val('');
        $("input[name='rnamaitem']").focus();
           return false;  
      }
   });

   var rindex=0;
    var rtamp=[];
      function tambahreq() {   
        var kode  =$('#rkode').val();      
        var code  =$('#code').val();      
        var nama  =$('#rdetailnama').val();                                
        var qty   =parseInt($('#rqty').val());        
        var Hapus = '<button type="button" class="btn btn-danger hapus" onclick="rhapus(this)"><i class="fa fa-trash-o"></i></button>';
        var rindex = rtamp.indexOf(kode);

        if ( rindex == -1){     
            tableReq.row.add([
              code,
              nama+'<input type="hidden" name="kode_item[]" class="kode_item kode" value="'+kode+'"><input type="hidden" name="nama_item[]" class="nama_item" value="'+nama+'"> ',
              '<input size="30" style="text-align:right;" type="number"  name="sd_qty[]" class="sd_qty form-control r_qty-'+kode+'" value="'+qty+'"> ',
              
              Hapus
              ]);

            tableReq.draw();
        rindex++;
        // console.log(rtamp);
        rtamp.push(kode);
            }else{
            var qtyLawas= parseInt($(".r_qty-"+kode).val());
            $(".r_qty-"+kode).val(qtyLawas+qty);
            }

          var kode  =$('#rkode').val('');      
          var nama  =$('#rdetailnama').val('');
        }

   function simpanTransfer() {
    $('.simpan-transfer').attr('disabled','disabled'); 
    $.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
    var item = $('#save_request').serialize();
    $.ajax({
      url : baseUrl + "/penjualan/POSretail/retail/simpan-transfer",
      type: 'get',
      data: item,
      dataType:'json',
      success:function(response, nota){
        if(response.status=='sukses'){
          var nota = response.nota;
          iziToast.success({timeout: 5000, 
                          position: "topRight",
                          icon: 'fa fa-chrome', 
                          title: nota, 
                          message: 'Telah terkirim.'});
          $('#myTransfer').modal('hide');
          tableReq.row().clear().draw(false);
          var inputs = document.getElementsByClassName( 'kode' ),
          names  = [].map.call(inputs, function( input ) {
              return input.value;
          });
          rtamp = names;
          $('#save_request')[0].reset();
          listTransfer.ajax.reload();
          $('.simpan-transfer').removeAttr('disabled','disabled');
        }else{  
          iziToast.error({position: "topRight",
                        title: '', 
                        message: 'Mohon melengkapi data.'});                              
          $('.simpan-transfer').removeAttr('disabled','disabled');
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

     function lihatTransfer($id){
            $.ajax({
                    url         : baseUrl+'/transfer/data-transfer/'+$id+'/lihat',
                    type        : 'get',
                    timeout     : 10000,                                        
                    success     : function(response){
                        $('#Edit-data-transfer').html(response);
                        $('#myTransferEdit').modal('show');
                        }
            });
     }

     function lihatRC($id){
            $.ajax({
                    url         : baseUrl+'/transfer/lihat-transfer/'+$id,
                    type        : 'get',
                    timeout     : 10000,                                        
                    success     : function(response){
                        $('#dataReceived').html(response);
                        $('#myReceived').modal('show');
                        }
            });
     }

     function editTransfer($id){
        $.ajax({
                url         : baseUrl+'/transfer/data-transfer/'+$id+'/edit',
                type        : 'get',
                timeout     : 10000,                                        
                success     : function(response){
                    $('#Edit-data-transfer').html(response);
                    $('#myTransferEdit').modal('show');
                    }
        });
     }


     function hapusTransfer($id){
      $('#hapus' + $id).attr('disabled','disabled');
      iziToast.show({
      onClosing: function () {
          $('#hapus' + $id).removeAttr('disabled','disabled');
        },
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
                    url         : baseUrl+'/transfer/data-transfer/hapus/'+$id,
                    type        : 'get',
                    timeout     : 10000,    
                    dataType    :'json',                                   
                    success     : function(response){
                     
                       if(response.status=='sukses'){                        
                          iziToast.success({timeout: 5000, 
                                    position: "topRight",
                                    icon: 'fa fa-chrome', 
                                    title: '', 
                                    message: 'Data telah terhapus.'});
                          listTransfer.ajax.reload();
                          $('#hapus' + $id).removeAttr('disabled','disabled');
                       }else{
                          iziToast.error({position: "topRight",
                                    title: '', 
                                    message: 'Data gagal di hapus.'});
                          $('#hapus' + $id).removeAttr('disabled','disabled');
                       }
                      }
            });
          }
        ],
        [
          '<button>Close</button>',
           function (instance, toast) {
            instance.hide({
              transitionOut: 'fadeOutUp'
            }, toast);
            $('#hapus' + $id).removeAttr('disabled','disabled');
          }
        ]
      ]
    }); 
     }

    function lihatPenerimaan($id){
         $.ajax({
                    url         : baseUrl+'/transfer/lihat-penerimaan/'+$id,
                    type        : 'get',
                    timeout     : 10000,                                        
                    success     : function(response){
                        $('#data-penerimaan-transfer').html(response);
                        $('#myTransferPenerimaan').modal('show');
                        }
                    });
     }

tablePenerimaan=$('#detail-terima').DataTable();

    function simpaPenerimaan(){
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       $('.simpanPenerimaan').attr('disabled','disabled');
      $.ajax({
        url         : baseUrl+'/transfer/penerimaan/simpa-penerimaan',
        type        : 'POST',
        timeout     : 10000,  
        data: item+'&'+tablePenerimaan.$('input').serialize(),
        dataType:'json',                                      
        success     : function(response){
          if(response.status=='sukses'){
            iziToast.success({timeout: 5000, 
                        position: "topRight",
                        icon: 'fa fa-chrome', 
                        title: '', 
                        message: 'Data berhasil diterima.'});
              terimaTransfer.ajax.reload();
              $('#myTransferPenerimaan').modal('hide');
          $('.simpanPenerimaan').removeAttr('disabled','disabled');
          }else{
            iziToast.error({position: "topRight",
                        title: '', 
                        message: 'Data gagal diterima.'});
          $('.simpanPenerimaan').removeAttr('disabled','disabled');
          }
        }
    });
   }

  function cariTanggal(){
    $('#listTransfer').dataTable().fnDestroy();
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    var tampil=$('#tampil_data').val();
    listTransfer =  $('#listTransfer').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url : baseUrl + "/transfer/penerimaan/table_transfer/"+tgl1+'/'+tgl2+'/'+tampil,
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

  function cariTanggalPenerimaan(){
    $('#terimaTransfer').dataTable().fnDestroy();
    var tgl3 = $('#tanggal3').val();
    var tgl4 = $('#tanggal4').val();
    var tampil1 = $('#tampil_data_Penerimaan').val();
    terimaTransfer =  $('#terimaTransfer').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url : baseUrl + "/transfer/penerimaan/terima_transfer/"+tgl3+'/'+tgl4+'/'+tampil1,
    },
    columns: [
      {data: 'ti_time', name: 'ti_time', width:'7%'},
      {data: 'ti_code', name: 'ti_code', width:'10%'},
      {data: 'ti_note', name: 'ti_note', width:'43%'},
      // {data: 'ti_time', name: 'ti_time', width:'7%'},
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

       function updateTransfer($id) {
        $('#update').attr('disabled','disabled');
        var item = $('#edit_request :input').serialize();
        var data = tableTf.$('input').serialize();
        $.ajax({
        url : baseUrl + "/penjualan/POSretail/update-transfer-grosir/"+$id,
        type: 'get',
        data: item+'&'+data,
        dataType:'json',
          success:function(response){
            if(response.status=='sukses'){
              iziToast.success({timeout: 5000, 
                        position: "topRight",
                        icon: 'fa fa-chrome', 
                        title: '', 
                        message: 'Berhasil diperbarui.'});               
              $('#myTransferEdit').modal('hide');
              $('#update').removeAttr('disabled','disabled');
            }else{
              iziToast.error({position: "topRight",
                        title: '', 
                        message: 'Data gagal di perbarui.'});
              $('#update').removeAttr('disabled','disabled');
            }   
          }
        })
      }

    </script>
    
@endsection()