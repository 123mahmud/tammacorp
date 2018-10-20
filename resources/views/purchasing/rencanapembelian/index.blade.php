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
        <div class="page-title">Rencana Pembelian</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Rencana Pembelian</li>
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
            <li class="active"><a href="#alert-tab" data-toggle="tab">Daftar Rencana Pembelian</a></li>
            <li><a href="#note-tab" data-toggle="tab" onclick="lihatHistorybyTgl()">History Rencana Pembelian</a></li>
          </ul>

          <div id="generalTabContent" class="tab-content responsive">
            
            @include('purchasing.rencanapembelian.tab-daftar')
            
            @include('purchasing.rencanapembelian.tab-history')          

          </div>
        </div>
      </div>
    </div>
  </div>
  <!--END TITLE & BREADCRUMB PAGE-->
  <!-- modal -->
    <!--modal detail-->
    @include('purchasing.rencanapembelian.modal-detail')
    <!--modal edit-->
    @include('purchasing.rencanapembelian.modal-edit')
  <!-- /modal -->
</div>
@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    //fix to issue select2 on modal when opening in firefox
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);

    var date = new Date();
    var newdate = new Date(date);

    newdate.setDate(newdate.getDate()-30);
    var nd = new Date(newdate);

    $('.datepicker1').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
    }).datepicker("setDate", nd);

    $('.datepicker2').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
      endDate: 'today'
    });//datepicker("setDate", "0");

    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      $('tr').remove('.tbl_modal_detail_row');
      $('tr').remove('.tbl_modal_edit_row');
      //remove span class in modal detail
      $("#txt_span_status").removeClass();
      $('#txt_span_status_edit').removeClass();
    });

    $('#tampil_data').on('change', function() {
      lihatHistorybyTgl();
    })

    $('.refresh-data-history').click(function(event) {
      $('#tbl-history').DataTable().ajax.reload();
    });

    //load fungsi
    lihatRencanaByTanggal();
  //end jquery
  });

  function refreshTabelDaftar() {
    $('#tbl-daftar').DataTable().ajax.reload();
  }

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

  function detailPlan(id) 
  {
    $.ajax({
      url : baseUrl + "/purchasing/rencanapembelian/get-detail-plan/"+id+"/confirmed",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        //ambil data ke json->modal
        $('#txt_span_status').text(data.spanTxt);
        $("#txt_span_status").addClass('label'+' '+data.spanClass);
        $('#lblCodePlan').text(data.header[0].d_pcsp_code);
        $('#lblTglPlan').text(data.header[0].d_pcsp_datecreated);
        $('#lblStaff').text(data.header[0].m_name);
        $('#lblSupplier').text(data.header[0].s_company);
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-detail').append('<tr class="tbl_modal_detail_row">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                          +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                          +'<td>'+data.data_isi[key-1].d_pcspdt_qty+'</td>'
                          +'<td>'+data.data_isi[key-1].d_pcspdt_qtyconfirm+'</td>'
                          +'<td>'+data.data_stok[key-1].qtyStok+' '+data.data_satuan[key-1]+'</td>'
                          +'</tr>');
          key++;
        });
        $('#modal-detail').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function detailPlanAll(id) 
  {
    $.ajax({
      url : baseUrl + "/purchasing/rencanapembelian/get-detail-plan/"+id+"/all",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        //ambil data ke json->modal
        $('#txt_span_status').text(data.spanTxt);
        $("#txt_span_status").addClass('label'+' '+data.spanClass);
        $('#lblCodePlan').text(data.header[0].d_pcsp_code);
        $('#lblTglPlan').text(data.header[0].d_pcsp_datecreated);
        $('#lblStaff').text(data.header[0].m_name);
        $('#lblSupplier').text(data.header[0].s_company);
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-detail').append('<tr class="tbl_modal_detail_row">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                          +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                          +'<td>'+data.data_isi[key-1].d_pcspdt_qty+'</td>'
                          +'<td>'+data.data_isi[key-1].d_pcspdt_qtyconfirm+'</td>'
                          +'<td>'+data.data_stok[key-1].qtyStok+' '+data.data_satuan[key-1]+'</td>'
                          +'</tr>');
          key++;
        });
        $('#modal-detail').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function editPlanAll(id) 
  {
    $.ajax({
      url : baseUrl + "/purchasing/rencanapembelian/get-edit-plan/"+id+"/all",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        //ambil data ke json->modal
        $('#txt_span_status_edit').text(data.spanTxt);
        $("#txt_span_status_edit").addClass('label'+' '+data.spanClass);
        $('#lblCodeEdit').text(data.header[0].d_pcsp_code);
        $('#lblTglEdit').text(data.header[0].d_pcsp_datecreated);
        $('#lblStaffEdit').text(data.header[0].m_name);
        $('#lblSupplierEdit').text(data.header[0].s_company);
        $('#id_plan').val(data.header[0].d_pcsp_id);
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-edit').append('<tr class="tbl_modal_edit_row">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                          +'<td>'+data.data_isi[key-1].m_sname
                          +'<input type="hidden" value="'+data.data_isi[key-1].m_sid+'" name="fieldIdSat[]" class="form-control"/></td>'
                          +'<td><input type="text" value="'+data.data_isi[key-1].d_pcspdt_qty+'" name="fieldQty[]" class="form-control numberinput input-sm"/>'
                          +'<input type="hidden" value="'+data.data_isi[key-1].d_pcspdt_id+'" name="fieldIdDt[]" class="form-control"/></td>'
                          +'<td>'+data.data_isi[key-1].d_pcspdt_qtyconfirm+'</td>'
                          +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_pcspdt_prevcost)+'</td>'
                          +'<td>'+data.data_stok[key-1].qtyStok+' '+data.data_satuan[key-1]+'</td>'
                          +'</tr>');
          key++;
        });
        $('#modal-edit').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function editPlan(id) 
  {
    $.ajax({
      url : baseUrl + "/purchasing/rencanapembelian/get-edit-plan/"+id+"/confirmed",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        //ambil data ke json->modal
        $('#txt_span_status_edit').text(data.spanTxt);
        $("#txt_span_status_edit").addClass('label'+' '+data.spanClass);
        $('#lblCodeEdit').text(data.header[0].d_pcsp_code);
        $('#lblTglEdit').text(data.header[0].d_pcsp_datecreated);
        $('#lblStaffEdit').text(data.header[0].m_name);
        $('#lblSupplierEdit').text(data.header[0].s_company);
        $('#id_plan').val(data.header[0].d_pcsp_id);
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-edit').append('<tr class="tbl_modal_edit_row">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                          +'<td>'+data.data_isi[key-1].m_sname
                          +'<input type="hidden" value="'+data.data_isi[key-1].m_sid+'" name="fieldIdSat[]" class="form-control"/></td>'
                          +'<td><input type="text" value="'+data.data_isi[key-1].d_pcspdt_qty+'" name="fieldQty[]" class="form-control numberinput input-sm"/>'
                          +'<input type="hidden" value="'+data.data_isi[key-1].d_pcspdt_id+'" name="fieldIdDt[]" class="form-control"/></td>'
                          +'<td>'+data.data_isi[key-1].d_pcspdt_qtyconfirm+'</td>'
                          +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_pcspdt_prevcost)+'</td>'
                          +'<td>'+data.data_stok[key-1].qtyStok+' '+data.data_satuan[key-1]+'</td>'
                          +'</tr>');
          key++;
        });
        $('#modal-edit').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function submitEdit() {
    iziToast.question({
      timeout: 20000,
      close: false,
      overlay: true,
      displayMode: 'once',
      // id: 'question',
      //zindex: 999,
      title: 'Update data',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#btn_update').text('Updating...'); //change button text
          $('#btn_update').attr('disabled',true); //set button disable 
          $.ajax({
            url : baseUrl + "/purchasing/rencanapembelian/update-data-plan",
            type: "POST",
            dataType: "JSON",
            data: $('#form-edit-plan').serialize(),
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'topRight',
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#btn_update').text('Update'); //change button text
                    $('#btn_update').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    $('#tbl-daftar').DataTable().ajax.reload();
                  }
                });
              }
              else
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.error({
                  position: 'topRight',
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#btn_update').text('Update'); //change button text
                    $('#btn_update').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    $('#tbl-daftar').DataTable().ajax.reload();
                  }
                });
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              iziToast.error({
                icon: 'fa fa-times',
                message: 'Terjadi Kesalahan!'
              });
            }
          });
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function deletePlan(idPlan) 
  {
    iziToast.question({
      timeout: 20000,
      close: false,
      overlay: true,
      displayMode: 'once',
      title: 'Hapus data',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url : baseUrl + "/purchasing/rencanapembelian/delete-data-plan",
            type: "POST",
            dataType: "JSON",
            data: {idPlan:idPlan, "_token": "{{ csrf_token() }}"},
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'topRight',
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#tbl-daftar').DataTable().ajax.reload();
                  }
                });
              }
              else
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.error({
                  position: 'topRight',
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#tbl-daftar').DataTable().ajax.reload();
                  }
                });
              }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              iziToast.error({
                icon: 'fa fa-times',
                message: 'Terjadi Kesalahan!'
              });
            }
          });
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function lihatRencanaByTanggal()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#tbl-daftar').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/purchasing/rencanapembelian/get-rencana-by-tgl/"+tgl1+"/"+tgl2,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "tglBuat", "width" : "10%"},
        {"data" : "d_pcsp_code", "width" : "10%"},
        {"data" : "m_name", "width" : "10%"},
        {"data" : "s_company", "width" : "15%"},
        {"data" : "tglConfirm", "width" : "10%"},
        {"data" : "status", "width" : "10%"},
        {"data" : "action", orderable: false, searchable: false, "width" : "13%"}
      ],
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

  function lihatHistorybyTgl(){
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    var tampil = $('#tampil_data').val();
    $('#tbl-history').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/purchasing/rencanapembelian/get-data-tabel-history/"+tgl1+"/"+tgl2+"/"+tampil,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "d_pcsp_code", "width" : "10%"},
        {"data" : "i_name", "width" : "15%"},
        {"data" : "m_sname", "width" : "10%"},
        {"data" : "s_company", "width" : "15%"},
        {"data" : "tglBuat", "width" : "10%"},
        {"data" : "d_pcspdt_qty", "width" : "5%"},
        {"data" : "tglConfirm", "width" : "10%"},
        {"data" : "d_pcspdt_qtyconfirm", "width" : "5%"},
        {"data" : "status", "width" : "10%"}
      ],
      /*"rowsGroup": [
        'first:name'
      ],*/
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

  function convertDecimalToRupiah(decimal) 
  {
    var angka = parseInt(decimal);
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00';
  }

</script>
@endsection()