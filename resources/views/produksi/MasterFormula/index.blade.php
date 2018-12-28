@extends('main') 
@section('content')
  <!--BEGIN PAGE WRAPPER-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<style type="text/css">
  .ui-autocomplete { z-index:2147483647; }
</style>
  <div id="page-wrapper">
      <!--BEGIN TITLE & BREADCRUMB PAGE-->
      <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
          <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
              <div class="page-title">Master Formula</div>
          </div>
          <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
              <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li><i></i>&nbsp;Produksi&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
              <li class="active">Master Formula</li>
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
                      <li class="active"><a href="#alert-tab" data-toggle="tab">Master Formula</a></li>
                    </ul>
                    <div id="generalTabContent" class="tab-content responsive">
                          
                      <div id="alert-tab" class="tab-pane fade in active">
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-xs-12">   

                              <div align="right">
                                <a data-toggle="modal" data-target="#myModal" class="btn btn-box-tool" id="btn-tambah"><i class="fa fa-plus"></i>&nbsp; Tambah Data</a>
                              </div>

                            <div class="table-responsive">
                              <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="TableFormula">
                                <thead>
                                  <tr>
                                    <th width="5%">No</th>
                                    <th>Kode Item</th>
                                    <th>Nama Item</th>
                                    <th>Hasil</th>
                                    <th>Satuan</th>
                                    <th width="15%">Aksi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                              </table> 
                            </div>  
                          </div>
                        </div>
                      </div>
                      
                      <!--Modal tambah rencana-->
                        
                      @include('produksi.MasterFormula.modal')
                       <!--End Modal-->
                       <!--Modal view detail formula-->
                       <div class="modal fade" id="myModalView" role="dialog">
                        <div class="modal-dialog modal-lg">
                          <form id="myForm">
                            <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header" style="background-color: #e77c38;">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title" style="color: white;">Form Detail Formula</h4>
                                </div>
                                <div id="view-formula">

                                </div>
                                <div class="modal-footer" style="border-top: none;">
                                  <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </form>   
                          </div>
                      </div>
                      <!--End Modal-->
                      <!--Modal view Edit formula-->
                      <div class="modal fade" id="myModalEdit" role="dialog">
                        <div class="modal-dialog modal-lg">
                          
                            <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header" style="background-color: #e77c38;">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title" style="color: white;">Form Detail Formula</h4>
                                </div>
                                <div id="edit-formula">

                                </div>
                                <div class="modal-footer" style="border-top: none;">
                                  <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                                  <button type="button" class="btn btn-primary" id="btn-simpan-edit" onclick="simpanResepUpdate()">Simpan Data</button>
                                </div>
                              </div>
                               
                          </div>
                      </div>
                      <!--End Modal-->
                    </div>

                  </div>
              </div>
          </div>
      </div>
  </div>

@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
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

  tableResep = $('#resep-detail').DataTable();

  $('#myModal').on('shown.bs.modal', function () {
    $('#namaitem').focus()
  }) 

  $('#hasil_item').keypress(function(e){
    var charCode;
    if ((e.which && e.which == 13)) {
      charCode = e.which;
    }else if (window.event) {
        e = window.event;
        charCode = e.keyCode;
    }
    if ((e.which && e.which == 13)){
      $("input[name='bahan_baku']").focus();
      return false;
    }
  });

  $(".modal").on("hidden.bs.modal", function(){
    $('#i_id').val('');
    $('#i_name').val('');
    $("#namaitem" ).val('');
    $("#satuan-item").empty();
    $("#satuan").empty();
    $("#bahan_baku" ).val('');
    $("#hasil_item" ).val('');
    //remove span class in modal detail
    tableResep.row().clear().draw(false);
    var inputs = document.getElementsByClassName( 'i_id' ),
    names  = [].map.call(inputs, function( input ) {
        return input.value;
    });
    tamp = names;
  });

  $( "#bahan_baku" ).focus(function(){
    var key = 1;
    $( "#bahan_baku" ).autocomplete({
      source: baseUrl+'/produksi/masterformula/autocomplete',
      minLength: 1,
      select: function(event, ui) {
        $('#i_id').val(ui.item.id);
        $('#i_name').val(ui.item.name);
        Object.keys(ui.item.satuan).forEach(function(){
          $('#satuan').append($('<option>', { 
            value: ui.item.id_satuan[key-1],
            text : ui.item.satuan[key-1]
            }));
          key++;
        });
        $('#i_code').val(ui.item.i_code);
        $("input[name='qty']").focus();
        }
    });
    $("#satuan").empty();
    $("#bahan_baku" ).val('');
    $("input[name='qty']").val('');
  });

  $( "#namaitem" ).focus(function(){
    var key = 1;
    $( "#namaitem" ).autocomplete({
      source: baseUrl+'/produksi/namaitem/autocomplete',
      minLength: 1,
      select: function(event, ui) {
        $('#id_item').val(ui.item.id);
        $("input[name='hasil_item']").focus();
        Object.keys(ui.item.satuan).forEach(function(){
            $('#satuan-item').append($('<option>', { 
              value: ui.item.id_satuan[key-1],
              text : ui.item.satuan[key-1]
              }));
            key++;
          });
        }
    });
    $("#satuan-item").empty();
    $("#namaitem" ).val('');
  });

});

  var tableFormula = $('#TableFormula').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url : baseUrl + "/produksi/masterformula/table",
    },
    columns: [
    {data: 'DT_Row_Index', name: 'DT_Row_Index'},
    {data: 'i_code', name: 'i_code'},
    {data: 'i_name', name: 'i_name'},
    {data: 'fr_result', name: 'fr_result'},
    {data: 'm_sname', name: 'm_sname'},
    {data: 'action', name: 'action', orderable: false, searchable: false},
    ],
  });

    var index=0;
    var tamp=[];
  function tambahResep(){
    var i_id = $('#i_id').val();
    var i_code = $('#i_code').val();
    var i_name = $('#i_name').val();
    var qty = $('#qty').val();
    var idSatuan = $('#satuan option:selected').val();
    var satuan = $('#satuan option:selected').text();
    var hapus = '<div class="text-center"><button type="button" class="btn btn-danger hapus" onclick="hapus(this)"><i class="fa fa-trash-o"></i></button><div>'
    var index = tamp.indexOf(i_id);

    if ( index == -1){ 
      tableResep.row.add([
        i_code+'<input type="hidden" name="i_id[]" id="" class="i_id" value="'+i_id+'">',
        i_name+'',
        '<input type="number" name="qty[]" id="" class="form-control text-right" value="'+qty+'">',
        satuan+'<input type="hidden" name="satuan[]" id="" class="" value="'+idSatuan+'">',
        hapus
        ]);
      tableResep.draw();
      index++;
      tamp.push(i_id);

    }else{
      toastr.warning('item sudah ada');
        $('#bahan_baku').val('');
        $('#satuan').val('');
        $('#qty').val('');
        $("input[name='bahan_baku']").focus();
      }
  }

    $('#qty').keypress(function(e){
        var charCode;
        if ((e.which && e.which == 13)) {
          charCode = e.which;
        }else if (window.event) {
            e = window.event;
            charCode = e.keyCode;
        }
        if ((e.which && e.which == 13)){
          var bahan_baku  = $('#bahan_baku').val();
          var qty         = $('#qty').val();
          var satuan      = $('#satuan').val();
          if(bahan_baku == '' || qty == ''){
            toastr.warning('Item dan Jumlah tidak boleh kosong!!');
            return false;
        }else{
          tambahResep();
            $('#bahan_baku').val('');
            $('#satuan').val('');
            $('#qty').val('');
            $("input[name='bahan_baku']").focus(); 
             return false;
        }

        }
     });

  function hapus(a){
    var par = a.parentNode.parentNode;
      tableResep.row(par).remove().draw(false);

        var inputs = document.getElementsByClassName( 'i_id' ),
    names  = [].map.call(inputs, function( input ) {
        return input.value;
    });
    tamp = names;
  }

  function simpanResep(){
    $('#btn-simpan').attr('disabled','disabled');
    var a = $('#myForm').serialize();
    var data = tableResep.$('input').serialize();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
      url : baseUrl + "/produksi/namaitem/save/formula",
      type: 'POST',
      data: a + '&' + data,
      success:function(response){
        if (response.status=='sukses') {
          $('#i_id').val('');
          $('#i_name').val('');
          $("#namaitem" ).val('');
          $("#satuan-item").empty();
          $("#satuan").empty();
          $("#bahan_baku" ).val('');
          $("#hasil_item" ).val('');
          tableResep.row().clear().draw(false);
          var inputs = document.getElementsByClassName( 'i_id' ),
          names  = [].map.call(inputs, function( input ) {
              return input.value;
          });
          tamp = names;
          tableFormula.ajax.reload();
          $('#myModal').modal('hide');
          iziToast.success({timeout: 5000, 
                          position: "topRight",
                          icon: 'fa fa-chrome', 
                          title: '', 
                          message: 'Data resep tersimpan.'});
          $('#btn-simpan').removeAttr('disabled','disabled');
        }else{
          iziToast.error({position: "topRight",
                        title: '', 
                        message: 'Mohon mengecek kelengkapan resep.'});
          $('#btn-simpan').removeAttr('disabled','disabled');
        }
      }
    }); 
  }

  function distroyFormula(id){
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
      url : baseUrl + "/produksi/namaitem/distroy/formula/"+id,
      type: 'GET',
      success : function(response){
        if (response.status=='sukses') {
          iziToast.success({timeout: 5000, 
                          position: "topRight",
                          icon: 'fa fa-chrome', 
                          title: '', 
                          message: 'Formula berhasil dihapus.'});
          tableFormula.ajax.reload();
        }else{
          iziToast.error({position: "topRight",
                        title: '', 
                        message: 'Formula gagal dihapus.'});
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
          }
        ]
      ]
    }); 
  }

  function lihatDetail(id){
    $.ajax({
      url : baseUrl + "/produksi/namaitem/view/formula",
      type: 'GET',
      data: {x:id},
      success : function(response){
        $('#view-formula').html(response);
      }
    });
  }

  function editFormula(id){
    $.ajax({
      url : baseUrl + "/produksi/namaitem/edit/formula",
      type: 'GET',
      data: {x:id},
      success : function(response){
        $('#edit-formula').html(response);
      }
    });
  }

  function simpanResepUpdate(){
    $('#btn-simpan-edit').attr('disabled','disabled');
    var b = $('#myFormUpdate').serialize();
    var data = tableResepEdit.$('input').serialize();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
      url : baseUrl + "/produksi/namaitem/update/formula",
      type: 'POST',
      data: b + '&' + data,
      success:function(response){
        if (response.status=='sukses') {
          $('#myModalEdit').modal('hide');
          iziToast.success({timeout: 5000, 
                          position: "topRight",
                          icon: 'fa fa-chrome', 
                          title: '', 
                          message: 'Data resep terupdate.'});
          tableFormula.ajax.reload();
          $('#btn-simpan-edit').removeAttr('disabled','disabled');
        }else{
          alert('Data Formula gagal di update!');
          $('#btn-simpan-edit').removeAttr('disabled','disabled');
        }
      }
    });
  }

</script>
@endsection()
