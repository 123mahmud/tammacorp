@extends('main') 
@section('content')
<style>
  .ui-autocomplete { z-index:2147483647; }
  .error { border: 1px solid #f00; }
  .valid { border: 1px solid #8080ff; }
  .has-error .select2-selection {
    border: 1px solid #f00 !important;
  }
  .has-valid .select2-selection {
    border: 1px solid #8080ff !important;
  }
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Edit Relasi Supplier ke Barang</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;Master&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Edit Relasi Supplier ke Barang</li>
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
              <a href="#alert-tab" data-toggle="tab">Edit Relasi Supplier ke Barang</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px;margin-bottom: 15px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Setting Relasi Supplier ke Barang</h4>
                  </div>
                  <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('master/databrgsup/index') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                  </div>
                </div>
                <div class="col-md-12">
                  <form method="POST" action="{{ url('master/databrgsup/update-relasi-supplier') }}/{{$data[0]->d_sb_supid}}" id="form_relasi_supplier">
                    {{ csrf_field() }}
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px; padding-bottom:5px;padding-top:10px;padding-left:-10px;padding-right: -10px; ">
                      
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <label class="tebal">Nama Supplier</label>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <input type="text" name="namasup" id="namasup" class="form-control input-sm" value="{{$data[0]->s_company}}" readonly>
                            <input type="hidden" name="idsup" id="idsup" readonly="" class="form-control input-sm" value="{{$data[0]->d_sb_supid}}">
                          </div>
                        </div>
                      </div>
                      
                      <div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 20px;"> 
                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <label class="tebal">Daftar Barang (Input nama barang terkait)</label>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <div class="form-group">
                            <input type="text" name="formbrg" id="formbrg" class="form-control input-sm ui-autocomplete-input" placeholder="Masukkan nama barang" autocomplete="off">
                            <input type="hidden" name="idbrg" id="idbrg" readonly="" class="form-control input-sm">
                            <input type="hidden" name="kdbrg" id="kdbrg" readonly="" class="form-control input-sm">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 20px;"> 
                        <div class="table-responsive">
                          <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tbl-form-sup">
                            <thead>
                              <tr>
                                <th class="wd-15p" width="90%">Nama Barang</th>
                                <th class="wd-15p" width="10%">Aksi</th>
                              </tr>
                            </thead>
                            <tbody id="tbl-body-form"></tbody>
                          </table> 
                        </div>
                      </div>
                      
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <a href="{{ url('master/databrgsup/index') }}" class="btn btn-danger btn-block"> Kembali </a>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <input type="submit" class="btn btn-primary btn-block" value="Simpan">
                      </div>
                    </div>
                  </form>
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
@section('extra_scripts')
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
  var tabelForm;
  $(document).ready(function() { 

    tabelForm = $('#tbl-form-sup').DataTable({
      'retrieve': true,
      'paging': false,
      "responsive": true,
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
  
    //autocomplete
    $( "#formbrg" ).focus(function() {
       var key = 1;
       $( "#formbrg" ).autocomplete({
          source: baseUrl+'/purchasing/rencanapembelian/autocomplete-barang',
          minLength: 1,
          select: function(event, ui) {
            $('#idbrg').val(ui.item.id);
            $('#formbrg').val(ui.item.label);
          }
       });
       $('#idbrg').val("");
       $('#formbrg').val("");
    });

    $( "#formbrg" ).focus(function() {
       var key = 1;
       $( "#formbrg" ).autocomplete({
          source: baseUrl+'/master/databrgsup/autocomplete-barang',
          minLength: 1,
          select: function(event, ui) {
            $('#idbrg').val(ui.item.id);
            $('#formbrg').val(ui.item.label);
            $('#kdbrg').val(ui.item.kode);
          }
       });
       $('#idbrg').val("");
       $('#kdbrg').val("");
       $('#formbrg').val("");
    });

    //prevent enter on submit form
    $(document).on("keypress", ":input:not(submit)", function(event) {
        return event.keyCode != 13;
    });
    
    $('#formbrg').keypress(function (e) {
      if ((e.which && e.which == 13)) 
      {
        var i = randString(5);
        var ambilBarang = $('input[name="formbrg"]').val();
        var ambilIdBarang = $('input[name="idbrg"]').val();
        var ambilKdBarang = $('input[name="kdbrg"]').val();
        var hapus = '<button type="button" class="btn btn-danger hapus" onclick="hapusRow(this)"><i class="fa fa-trash-o"></i></button>';
        //tambah();
        tabelForm.row.add([
                '<input type="text" name="ipbarang[]" value="'+ambilBarang+'" id="field_ip_barang" class="form-control" required readonly>'+
                '<input type="hidden" name="ipid[]" value="'+ambilIdBarang+'" id="field_ip_id" class="form-control">',
                hapus
            ]);
        tabelForm.draw();
        i = randString(5);
        $('input[name="formbrg"]').val("").focus();
        $('input[name="idbrg"]').val("");
        return false;  
      }
    });

    var idSup = $('#idsup').val();
    $.ajax({
      url : baseUrl + "/master/databrgsup/get-form-editsup",
      type: "GET",
      dataType: "JSON",
      data : {id:idSup},
      success: function(data)
      {
        var hapus = '<button type="button" class="btn btn-danger hapus" onclick="hapusRow(this)"><i class="fa fa-trash-o"></i></button>';
        var key = 1;
        Object.keys(data.data).forEach(function(){
          tabelForm.row.add([
                '<input type="text" name="ipbarang[]" value="'+data.data[key-1].i_code+' '+data.data[key-1].i_name+'" id="field_ip_barang" class="form-control" required readonly>'+
                '<input type="hidden" name="ipid[]" value="'+data.data[key-1].d_sb_itemid+'" id="field_ip_id" class="form-control">',
                hapus
            ]);
          tabelForm.draw();
          key++;
        });
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });

  });//end jquery

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

  function hapusRow(a) {
    var par = a.parentNode.parentNode;
    tabelForm.row(par).remove().draw(false);
  }
</script> 
@endsection