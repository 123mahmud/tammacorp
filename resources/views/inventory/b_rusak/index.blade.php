@extends('main')
@section('content')
<style type="text/css">
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
      <div class="page-title">Barang Rusak</div>
    </div>
    
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Inventory&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Barang Rusak</li>
    </ol>
    
    <div class="clearfix"></div>
  </div>
  
  <div class="page-content">
    <div id="tab-general">
      <div class="row mbl">
        <div class="col-lg-12">
          <div class="col-md-12">
            <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;"></div>
          </div>

          <ul id="generalTab" class="nav nav-tabs">
            <li class="active"><a href="#index-tab" data-toggle="tab">Barang Rusak</a></li>
            <li><a href="#musnah-tab" data-toggle="tab" onclick="lihatMusnahByTgl()">List Barang Musnah</a></li>
            <li><a href="#ubahjenis-tab" data-toggle="tab" onclick="lihatUbahJenisByTgl()">List Ubah Jenis</a></li>
          </ul>
          
          <div id="generalTabContent" class="tab-content responsive">
            @include('inventory.b_rusak.tab-index')
            @include('inventory.b_rusak.tab-musnah')
            @include('inventory.b_rusak.tab-ubahjenis')
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- modal -->
    <!--modal Barang Rusak-->
    @include('inventory.b_rusak.modal')
    @include('inventory.b_rusak.modal-detail')
    @include('inventory.b_rusak.modal-proses-ubahjenis')
    @include('inventory.b_rusak.modal-opsi')
  <!-- /modal -->
</div>
<!--END PAGE WRAPPER-->
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

    //select2
    $( "#head_gudang" ).select2({
      placeholder: "Pilih Gudang...",
      ajax: {
        url: baseUrl + '/inventory/b_rusak/lookup-data-gudang',
        dataType: 'json',
        data: function (params) {
          return {
              q: $.trim(params.term)
          };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
      },
    });

    $( "#head_gudang_jenis" ).select2({
      placeholder: "Pilih Gudang...",
      ajax: {
        url: baseUrl + '/inventory/b_rusak/lookup-data-gudang',
        dataType: 'json',
        data: function (params) {
          return {
              q: $.trim(params.term)
          };
        },
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
      },
    });

    $('#head_gudang').change(function(event) {
      clearInput();
      $('#ip_barang').focus();
    });

    $('#head_gudang_jenis').change(function(event) {
      clearInput2();
      $('#ip_barang_jenis').focus();
    });

    //autocomplete w/parameters
    $( "#ip_barang" ).focus(function() {
      var key = 1;
      $('#btn_simpan').attr('disabled', true);
      $("#ip_barang").autocomplete({
        source: function(request, response) {
          $.ajax({
            url: baseUrl + "/inventory/b_rusak/autocomplete-barang",
            dataType: "JSON",
            data: {
              term : request.term,
              id_gudang : $('#head_gudang').val()
            },
            success: function(data) {
              response(data);
            }
          });
        },
        select: function(event, ui) {
          $('#ip_item').val(ui.item.id);
          $('#ip_barang').val(ui.item.label);
          $('#ip_scomp').val(ui.item.s_comp);
          $('#ip_spos').val(ui.item.s_pos);
          $('#ip_qtyStok').val(ui.item.stok+' '+ui.item.satTxt[0]);
          Object.keys(ui.item.sat).forEach(function(){
            $('#ip_sat').append($('<option>', { 
              value: ui.item.sat[key-1],
              text : ui.item.satTxt[key-1]
            }));
            key++;
          });
          $("input[name='ipQtyReq']").focus();
        },
        minLength: 1,
        delay: 300
      });
      clearInput();
    });

    $( "#ip_barang_jenis" ).focus(function() {
      var key = 1;
      $('#btn_submit_jenis').attr('disabled', true);
      $("#ip_barang_jenis").autocomplete({
        source: function(request, response) {
          $.ajax({
            url: baseUrl + "/inventory/b_rusak/autocomplete-barang",
            dataType: "JSON",
            data: {
              term : request.term,
              id_gudang : $('#head_gudang_jenis').val()
            },
            success: function(data) {
              response(data);
            }
          });
        },
        select: function(event, ui) {
          $('#ip_item_jenis').val(ui.item.id);
          $('#ip_barang_jenis').val(ui.item.label);
          $('#ip_scomp_jenis').val(ui.item.s_comp);
          $('#ip_spos_jenis').val(ui.item.s_pos);
          $('#ip_qtyStok_jenis').val(ui.item.stok+' '+ui.item.satTxt[0]);
          Object.keys(ui.item.sat).forEach(function(){
            $('#ip_sat_jenis').append($('<option>', { 
              value: ui.item.sat[key-1],
              text : ui.item.satTxt[key-1]
            }));
            key++;
          });
          $("input[name='ipQtyReqJenis']").focus();
        },
        minLength: 1,
        delay: 300
      });
      clearInput2();
    });

    $('#ip_barang').blur(function(event) {
      $('#btn_simpan').attr('disabled', false);
    });

    $('#ip_barang_jenis').blur(function(event) {
      $('#btn_submit_jenis').attr('disabled', false);
    });

    $(document).on('click', '.btn_remove', function(){
      nomor--;
      var button_id = $(this).attr('id');
      $('#row'+button_id+'').remove();
    });

    //validasi
    $("#form-barang-rusak").validate({
      rules:{
        headGudang: "required",
        headTglPakai: "required",
        headPemberi: "required"
      },
      errorPlacement: function() {
          return false;
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    $("#form-proses-ubahjenis").validate({
      rules:{
        headGudangJenis: "required",
        headTglUjenis: "required"
      },
      errorPlacement: function() {
          return false;
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      //remove append tr
      $('tr').remove('.tbl_form_row');
      $('tr').remove('.tbl_modal_detail_row');
      $('tr').remove('.tbl_modal_edit_row');
      $('tr').remove('.tbl_modal_edit_row');
      // $('#appending-form div').remove();
      //reset all input txt field
      $('#form-barang-rusak')[0].reset();
      $('#form_opsi_rusak')[0].reset();
      $('#form-proses-ubahjenis')[0].reset();
      //empty select2 field
      $('#head_gudang').empty();
      $('#head_gudang_jenis').empty();
      //set datepicker to today 
      $('.datepicker2').datepicker('setDate', 'today');
      //remove class all jquery validation error
      $('.form-group').find('.error').removeClass('error');
      $('.form-group').removeClass('has-valid has-error');
    });

    $("#modal_opsi").on("hidden.bs.modal", function(){
      location.reload(); 
    });

    $('#head_gudang').change(function(event) {
      if($(this).val() != ""){
        $('#divSelectNota').removeClass('has-error').addClass('has-valid');
      }else{
        $('#divSelectNota').addClass('has-error').removeClass('has-valid');
      }
    });

    $('#head_gudang_jenis').change(function(event) {
      if($(this).val() != ""){
        $('#divSelectNotaJenis').removeClass('has-error').addClass('has-valid');
      }else{
        $('#divSelectNotaJenis').addClass('has-error').removeClass('has-valid');
      }
    });

    //load fungsi
    lihatBrgRusakByTanggal();

  });//end jquery

  var nomor = 1;
  function addItemRow() 
  {
    var i = randString(5);
    var ambilSatuanId = $("#ip_sat option:selected").val();
    var ambilSatuanTxt = $("#ip_sat option:selected").text();
    $('#ip_sat').empty();
    var ambilIdBarang = $('#ip_item').val();
    var ambilBarang = $('#ip_barang').val();
    var scomp = $('#ip_scomp').val();
    var spos = $('#ip_spos').val();
    var ambilQty = $('#ip_qtyreq').val();
    var ambilStok = $('#ip_qtyStok').val();
    var ambilKet = $('#ip_keterangan').val();
    if (ambilIdBarang == "" || ambilBarang == "" || ambilQty == "" || ambilSatuanId == "" || scomp == "" || spos == "") 
    {
      iziToast.warning({
        position: 'center',
        title: 'Pemberitahuan',
        message: "Terdapat kolom yang kosong, dimohon cek lagi !"
      });
      clearInput();
      $('#ip_barang').focus();

    } 
    else
    {
      $('#div_item').append(
        '<tr class="tbl_form_row" id="row'+i+'">'
          +'<td style="text-align:center">'+nomor+'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpBarang[]" value="'+ambilBarang+'" id="field_ip_barang" class="form-control" required readonly>'
            +'<input type="hidden" name="fieldIpItem[]" value="'+ambilIdBarang+'" id="field_ip_item" class="form-control">'
            +'<input type="hidden" name="fieldIpSpos[]" value="'+spos+'" id="field_ip_spos" class="form-control">'
            +'<input type="hidden" name="fieldIpScomp[]" value="'+scomp+'" id="field_ip_scomp" class="form-control">'
          +'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpQty[]" value="'+ambilQty+'" id="field_ip_qty" class="form-control" required readonly>'
          +'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpSatTxt[]" value="'+ambilSatuanTxt+'" id="field_ip_sat_txt" class="form-control" required readonly>'
            +'<input type="hidden" name="fieldIpSatId[]" value="'+ambilSatuanId+'" id="field_ip_sat_id" class="form-control" required readonly>'
          +'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpStok[]" value="'+ambilStok+'" id="field_ip_stok" class="form-control" required readonly>'
          +'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpKet[]" value="'+ambilKet+'" id="field_ip_ket" class="form-control" readonly>'
          +'</td>'
          +'<td>'
            +'<button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button>'
          +'</td>'
        +'</tr>');
      i = randString(5);
      nomor++;
      //kosongkan field setelah append row
      clearInput();
      // totalPembelian();
    }
  }

  function addItemRow2() 
  {
    var i = randString(5);
    var ambilSatuanId = $("#ip_sat_jenis option:selected").val();
    var ambilSatuanTxt = $("#ip_sat_jenis option:selected").text();
    $('#ip_sat_jenis').empty();
    var ambilIdBarang = $('#ip_item_jenis').val();
    var ambilBarang = $('#ip_barang_jenis').val();
    var scomp = $('#ip_scomp_jenis').val();
    var spos = $('#ip_spos_jenis').val();
    var ambilQty = $('#ip_qtyreq_jenis').val();
    var ambilStok = $('#ip_qtyStok_jenis').val();
    var ambilKet = $('#ip_keterangan_jenis').val();
    if (ambilIdBarang == "" || ambilBarang == "" || ambilQty == "" || ambilSatuanId == "" || scomp == "" || spos == "") 
    {
      iziToast.warning({
        position: 'center',
        title: 'Pemberitahuan',
        message: "Terdapat kolom yang kosong, dimohon cek lagi !"
      });
      clearInput2();
      $('#ip_barang_jenis').focus();
    } 
    else
    {
      $('#div_item_jenis').append(
        '<tr class="tbl_form_row" id="row'+i+'">'
          +'<td style="text-align:center">'+nomor+'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpBarang[]" value="'+ambilBarang+'" id="field_ip_barang" class="form-control" required readonly>'
            +'<input type="hidden" name="fieldIpItem[]" value="'+ambilIdBarang+'" id="field_ip_item" class="form-control">'
            +'<input type="hidden" name="fieldIpSpos[]" value="'+spos+'" id="field_ip_spos" class="form-control">'
            +'<input type="hidden" name="fieldIpScomp[]" value="'+scomp+'" id="field_ip_scomp" class="form-control">'
          +'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpQty[]" value="'+ambilQty+'" id="field_ip_qty" class="form-control" required readonly>'
          +'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpSatTxt[]" value="'+ambilSatuanTxt+'" id="field_ip_sat_txt" class="form-control" required readonly>'
            +'<input type="hidden" name="fieldIpSatId[]" value="'+ambilSatuanId+'" id="field_ip_sat_id" class="form-control" required readonly>'
          +'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpStok[]" value="'+ambilStok+'" id="field_ip_stok" class="form-control" required readonly>'
          +'</td>'
          +'<td>'
            +'<input type="text" name="fieldIpKet[]" value="'+ambilKet+'" id="field_ip_ket" class="form-control" readonly>'
          +'</td>'
          +'<td>'
            +'<button name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button>'
          +'</td>'
        +'</tr>');
      i = randString(5);
      nomor++;
      //kosongkan field setelah append row
      clearInput2();
      // totalPembelian();
    }
  }

  function submitPakai() {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Simpan Data Barang Rusak',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          var IsValid = $("form[name='formBarangRusak']").valid();
          if(IsValid)
          {
            var countRow = $('#div_item tr').length;
            if(countRow > 0)
            {
              $('#divSelectNota').removeClass('has-error');
              $('#btn_simpan').text('Saving...');
              $('#btn_simpan').attr('disabled',true);
              $.ajax({
                url : baseUrl + "/inventory/b_rusak/simpan-data-rusak",
                type: "POST",
                dataType: "JSON",
                data: $('#form-barang-rusak').serialize(),
                success: function(response)
                {
                  if(response.status == "sukses")
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.success({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.pesan,
                      onClosing: function(instance, toast, closedBy){
                        $('#btn_simpan').text('Submit'); //change button text
                        $('#btn_simpan').attr('disabled',false); //set button enable
                        $('#modal_barang_rusak').modal('hide');
                        $('#tbl-daftar').DataTable().ajax.reload();
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
                        $('#btn_simpan').text('Submit'); //change button text
                        $('#btn_simpan').attr('disabled',false); //set button enable
                        $('#modal_barang_rusak').modal('hide');
                        $('#tbl-daftar').DataTable().ajax.reload();
                      }
                    }); 
                  }
                },
                error: function(){
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.warning({
                    icon: 'fa fa-times',
                    message: 'Terjadi Kesalahan!'
                  });
                },
                async: false
              }); 
            }
            else
            {
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              iziToast.warning({
                position: 'center',
                message: "Mohon maaf, form pada tabel dilarang kosong !"
              });
            }//end check table form
          }
          else
          {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            iziToast.warning({
              position: 'center',
              message: "Mohon Lengkapi data form !",
              onClosing: function(instance, toast, closedBy){
                $('#divSelectNota').addClass('has-error');
              }
            });
          } //end check valid
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function lihatBrgRusakByTanggal()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#tbl-daftar').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/inventory/b_rusak/get-brg-rusak-by-tgl/"+tgl1+"/"+tgl2,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "tglBuat", "width" : "15%"},
        {"data" : "d_br_code", "width" : "15%"},
        {"data" : "m_name", "width" : "15%"},
        {"data" : "cg_cabang", "width" : "15%"},
        {"data" : "action", orderable: false, searchable: false, "width" : "15%"}
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

  function lihatMusnahByTgl()
  {
    var tgl1 = $('#tanggal3').val();
    var tgl2 = $('#tanggal4').val();
    $('#tbl-musnah').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/inventory/b_rusak/get-brg-musnah-by-tgl/"+tgl1+"/"+tgl2,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "tglBuat", "width" : "10%"},
        {"data" : "d_br_pemberi", "width" : "15%"},
        {"data" : "d_br_code", "width" : "10%"},
        {"data" : "namaItem", "width" : "25%"},
        {"data" : "d_brdt_qty", "width" : "5%"},
        {"data" : "m_sname", "width" : "5%"},
        {"data" : "d_brdt_keterangan", "width" : "25%"}
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

  function lihatUbahJenisByTgl()
  {
    var tgl1 = $('#tanggal5').val();
    var tgl2 = $('#tanggal6').val();
    $('#tbl-ubahjenis').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/inventory/b_rusak/get-brg-ubahjenis-by-tgl/"+tgl1+"/"+tgl2,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "tglBuat", "width" : "10%"},
        {"data" : "d_br_pemberi", "width" : "10%"},
        {"data" : "d_br_code", "width" : "10%"},
        {"data" : "namaItem", "width" : "20%"},
        {"data" : "d_brdt_qty", "width" : "10%"},
        {"data" : "m_sname", "width" : "8%"},
        {"data" : "d_brdt_keterangan", "width" : "15%"},
        {"data" : "action", orderable: false, searchable: false, "width" : "12%"}
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

  function detailBrgRusak(id) 
  {
    $.ajax({
      url : baseUrl + "/inventory/b_rusak/get-detail/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        $('#lblGudang').text(data.header[0].cg_cabang);
        $('#lblKode').text(data.header[0].d_br_code);
        $('#lblTgl').text(data.header2.tgl_pakai);
        $('#lblStaff').text(data.header[0].m_name);
        $('#lblPemberi').text(data.header[0].d_br_pemberi);
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-detail').append('<tr class="tbl_modal_detail_row">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                          +'<td>'+data.data_isi[key-1].qty_pakai+'</td>'
                          +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                          +'<td>'+data.stok[key-1]+' '+data.txtSat1[key-1].m_sname+'</td>'
                          +'<td>'+data.data_isi[key-1].d_brdt_keterangan+'</td>'
                          +'</tr>');
          key++;
        });
        $('#apdsfs').html('<a href="'+ baseUrl +'/inventory/b_rusak/print/'+ id +'" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i>&nbsp;Print</a>'+
        '<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
        $('#modal_detail').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function opsiBrgRusak(id) 
  {
    //autofill
    $('#pilihan_opsi').change(function()
    {
      $('#appending-form div').remove();
      var pilihan = $(this).val();
      if (pilihan == "") 
      {
        $('#appending-form div').remove();
      }
      else if(pilihan == "musnah")
      {   
        $('#appending-form div').remove();
        musnah(id);
      }
      else if(pilihan == "kembali")
      { 
        $('#appending-form div').remove();
        kembaliKeGudang(id);
      }
      else if(pilihan == "ubah_jenis")
      { 
        $('#appending-form div').remove();
        ubahJenis(id);
      }
      /*else if(pilihan == "jual")
      { 
        $('#appending-form div').remove();
        ubahJenis(id);
      }*/
    });

    $('#modal_opsi').modal('show');
  }

  function musnah(id) 
  {
    $('#appending-form').append(
        '<div class="col-md-2 col-sm-12 col-xs-12">'
          +'<label class="tebal">Gudang Asal</label>'
        +'</div>'
        +'<div class="col-md-4 col-sm-12 col-xs-12">'
          +'<div class="form-group">'
            +'<label id="lblOpsiGudang"></label>'
          +'</div>'  
        +'</div>'

        +'<div class="col-md-2 col-sm-12 col-xs-12">'
          +'<label class="tebal">Kode</label>'
        +'</div>'
        +'<div class="col-md-4 col-sm-12 col-xs-12">'
          +'<div class="form-group">'
            +'<label id="lblOpsiKode"></label>'
          +'</div>'  
        +'</div>'

        +'<div class="col-md-2 col-sm-12 col-xs-12">'
          +'<label class="tebal">Tanggal</label>'
        +'</div>'
        +'<div class="col-md-4 col-sm-12 col-xs-12">'
          +'<div class="form-group">'
            +'<label id="lblOpsiTgl"></label>'
          +'</div>'  
        +'</div>'

        +'<div class="col-md-2 col-sm-12 col-xs-12">'
          +'<label class="tebal">Staff</label>'
        +'</div>'
        +'<div class="col-md-4 col-sm-12 col-xs-12">'
          +'<div class="form-group">'
            +'<label id="lblOpsiStaff"></label>'
          +'</div>'
        +'</div>'

        +'<div class="col-md-2 col-sm-12 col-xs-12">'
          +'<label class="tebal">Diterima Dari</label>'
        +'</div>'
        +'<div class="col-md-4 col-sm-12 col-xs-12">'
          +'<div class="form-group">'
            +'<label id="lblOpsiPemberi"></label>'
          +'</div>'
        +'</div>'
        
        +'<div class="table-responsive">'
          +'<table class="table tabelan table-bordered" id="tabel-form-opsi">'
            +'<thead>'
              +'<tr>'
                +'<th width="5%">No</th>'
                +'<th width="20%">Kode | Barang</th>'
                +'<th width="10%">Qty</th>'
                +'<th width="10%">Satuan</th>'
                +'<th width="10%">Stok</th>'
                +'<th width="20%">Keterangan</th>'
                +'<th width="5%">Aksi</th>'
              +'</tr>'
            +'</thead>'
            +'<tbody id="div_item_opsi">'
            +'</tbody>'
          +'</table>'
        +'</div>'
        
        +'<div id="grup-tombol" class="modal-footer" style="border-top: none;">'
        +'</div>');
    $.ajax({
      url : baseUrl + "/inventory/b_rusak/get-detail/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        $('#lblOpsiGudang').text(data.header[0].cg_cabang);
        $('#lblOpsiKode').text(data.header[0].d_br_code);
        $('#lblOpsiTgl').text(data.header2.tgl_pakai);
        $('#lblOpsiStaff').text(data.header[0].m_name);
        $('#lblOpsiPemberi').text(data.header[0].d_br_pemberi);
        $("input[name='idTabelHeader']").val(data.header[0].d_br_id);
        //loop data
        i = randString(5);
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-form-opsi').append('<tr class="tbl_modal_edit_row" id="row'+i+'">'
                          +'<td>'+key+'</td>'
                          +'<td>'
                            +data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name
                            +'<input type="hidden" name="fieldOpsiIdDet[]" class="form-control input-sm" value="'+data.data_isi[key-1].d_brdt_id+'"/>'
                          +'</td>'
                          +'<td>'+data.data_isi[key-1].qty_pakai+'</td>'
                          +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                          +'<td>'+data.stok[key-1]+' '+data.txtSat1[key-1].m_sname+'</td>'
                          +'<td>'+data.data_isi[key-1].d_brdt_keterangan+'</td>'
                          +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove btn-sm">X</button></td>'
                          +'</tr>');
          i = randString(5);
          key++;
        });
        $('#grup-tombol').html('<button type="button" id="button_save" class="btn btn-primary" onclick="musnahkanBarang()">Submit Data</button>'+
        '<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function kembaliKeGudang(id) 
  {
    $('#appending-form').append(
      '<div class="col-md-2 col-sm-12 col-xs-12">'
        +'<label class="tebal">Gudang Asal</label>'
      +'</div>'
      +'<div class="col-md-4 col-sm-12 col-xs-12">'
        +'<div class="form-group">'
          +'<label id="lblOpsiGudang"></label>'
        +'</div>'  
      +'</div>'

      +'<div class="col-md-2 col-sm-12 col-xs-12">'
        +'<label class="tebal">Kode</label>'
      +'</div>'
      +'<div class="col-md-4 col-sm-12 col-xs-12">'
        +'<div class="form-group">'
          +'<label id="lblOpsiKode"></label>'
        +'</div>'  
      +'</div>'

      +'<div class="col-md-2 col-sm-12 col-xs-12">'
        +'<label class="tebal">Tanggal</label>'
      +'</div>'
      +'<div class="col-md-4 col-sm-12 col-xs-12">'
        +'<div class="form-group">'
          +'<label id="lblOpsiTgl"></label>'
        +'</div>'  
      +'</div>'

      +'<div class="col-md-2 col-sm-12 col-xs-12">'
        +'<label class="tebal">Staff</label>'
      +'</div>'
      +'<div class="col-md-4 col-sm-12 col-xs-12">'
        +'<div class="form-group">'
          +'<label id="lblOpsiStaff"></label>'
        +'</div>'
      +'</div>'

      +'<div class="col-md-2 col-sm-12 col-xs-12">'
        +'<label class="tebal">Diterima Dari</label>'
      +'</div>'
      +'<div class="col-md-4 col-sm-12 col-xs-12">'
        +'<div class="form-group">'
          +'<label id="lblOpsiPemberi"></label>'
        +'</div>'
      +'</div>'
      
      +'<div class="table-responsive">'
        +'<table class="table tabelan table-bordered" id="tabel-form-opsi">'
          +'<thead>'
            +'<tr>'
              +'<th width="5%">No</th>'
              +'<th width="20%">Kode | Barang</th>'
              +'<th width="10%">Qty</th>'
              +'<th width="10%">Satuan</th>'
              +'<th width="10%">Stok</th>'
              +'<th width="20%">Keterangan</th>'
              +'<th width="5%">Aksi</th>'
            +'</tr>'
          +'</thead>'
          +'<tbody id="div_item_opsi">'
          +'</tbody>'
        +'</table>'
      +'</div>'
      
      +'<div id="grup-tombol" class="modal-footer" style="border-top: none;">'
      +'</div>'
    );

    $.ajax({
      url : baseUrl + "/inventory/b_rusak/get-detail/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        $('#lblOpsiGudang').text(data.header[0].cg_cabang);
        $('#lblOpsiKode').text(data.header[0].d_br_code);
        $('#lblOpsiTgl').text(data.header2.tgl_pakai);
        $('#lblOpsiStaff').text(data.header[0].m_name);
        $('#lblOpsiPemberi').text(data.header[0].d_br_pemberi);
        $("input[name='idTabelHeader']").val(data.header[0].d_br_id);
        $("input[name='idGudangHeader']").val(data.header[0].d_br_gdg);
        //loop data
        i = randString(5);
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-form-opsi').append('<tr class="tbl_modal_edit_row" id="row'+i+'">'
                          +'<td>'+key+'</td>'
                          +'<td>'
                            +data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name
                            +'<input type="hidden" name="fieldOpsiIdDet[]" class="form-control input-sm" value="'+data.data_isi[key-1].d_brdt_id+'"/>'
                          +'</td>'
                          +'<td>'+data.data_isi[key-1].qty_pakai+'</td>'
                          +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                          +'<td>'+data.stok[key-1]+' '+data.txtSat1[key-1].m_sname+'</td>'
                          +'<td>'+data.data_isi[key-1].d_brdt_keterangan+'</td>'
                          +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove btn-sm">X</button></td>'
                          +'</tr>');
          i = randString(5);
          key++;
        });
        $('#grup-tombol').html('<button type="button" id="button_save" class="btn btn-primary" onclick="kembalikanBarang()">Submit Data</button>'+
        '<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function ubahJenis(id) 
  {
    $('#appending-form').append(
      '<div class="col-md-2 col-sm-12 col-xs-12">'
        +'<label class="tebal">Gudang Asal</label>'
      +'</div>'
      +'<div class="col-md-4 col-sm-12 col-xs-12">'
        +'<div class="form-group">'
          +'<label id="lblOpsiGudang"></label>'
        +'</div>'  
      +'</div>'

      +'<div class="col-md-2 col-sm-12 col-xs-12">'
        +'<label class="tebal">Kode</label>'
      +'</div>'
      +'<div class="col-md-4 col-sm-12 col-xs-12">'
        +'<div class="form-group">'
          +'<label id="lblOpsiKode"></label>'
        +'</div>'  
      +'</div>'

      +'<div class="col-md-2 col-sm-12 col-xs-12">'
        +'<label class="tebal">Tanggal</label>'
      +'</div>'
      +'<div class="col-md-4 col-sm-12 col-xs-12">'
        +'<div class="form-group">'
          +'<label id="lblOpsiTgl"></label>'
        +'</div>'  
      +'</div>'

      +'<div class="col-md-2 col-sm-12 col-xs-12">'
        +'<label class="tebal">Staff</label>'
      +'</div>'
      +'<div class="col-md-4 col-sm-12 col-xs-12">'
        +'<div class="form-group">'
          +'<label id="lblOpsiStaff"></label>'
        +'</div>'
      +'</div>'

      +'<div class="col-md-2 col-sm-12 col-xs-12">'
        +'<label class="tebal">Diterima Dari</label>'
      +'</div>'
      +'<div class="col-md-4 col-sm-12 col-xs-12">'
        +'<div class="form-group">'
          +'<label id="lblOpsiPemberi"></label>'
        +'</div>'
      +'</div>'
      
      +'<div class="table-responsive">'
        +'<table class="table tabelan table-bordered" id="tabel-form-opsi">'
          +'<thead>'
            +'<tr>'
              +'<th width="5%">No</th>'
              +'<th width="20%">Kode | Barang</th>'
              +'<th width="10%">Qty</th>'
              +'<th width="10%">Satuan</th>'
              +'<th width="10%">Stok</th>'
              +'<th width="20%">Keterangan</th>'
              +'<th width="5%">Aksi</th>'
            +'</tr>'
          +'</thead>'
          +'<tbody id="div_item_opsi">'
          +'</tbody>'
        +'</table>'
      +'</div>'
      
      +'<div id="grup-tombol" class="modal-footer" style="border-top: none;">'
      +'</div>'
    );

    $.ajax({
      url : baseUrl + "/inventory/b_rusak/get-detail/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        $('#lblOpsiGudang').text(data.header[0].cg_cabang);
        $('#lblOpsiKode').text(data.header[0].d_br_code);
        $('#lblOpsiTgl').text(data.header2.tgl_pakai);
        $('#lblOpsiStaff').text(data.header[0].m_name);
        $('#lblOpsiPemberi').text(data.header[0].d_br_pemberi);
        $("input[name='idTabelHeader']").val(data.header[0].d_br_id);
        $("input[name='idGudangHeader']").val(data.header[0].d_br_gdg);
        //loop data
        i = randString(5);
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-form-opsi').append('<tr class="tbl_opsi_row" id="row'+i+'">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                          +'<td>'+data.data_isi[key-1].qty_pakai+'</td>'
                          +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                          +'<td>'+data.stok[key-1]+' '+data.txtSat1[key-1].m_sname+'</td>'
                          +'<td>'+data.data_isi[key-1].d_brdt_keterangan+'</td>'
                          +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove btn-sm">X</button></td>'
                          +'</tr>'
                          +'<tr class="tbl_opsi_row" id="row'+i+'">');
          i = randString(5);
          key++;
        });
        $('#grup-tombol').html('<button type="button" id="button_save" class="btn btn-primary" onclick="simpanUbahJenis()">Simpan Data</button>'
        +'<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function hapusUbahJenis(id)
  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Hapus Data Ubah Jenis',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url : baseUrl + "/inventory/b_rusak/hapus-data-ubahjenis",
            type: "POST",
            dataType: "JSON",
            data: {idDetail:id, "_token": "{{ csrf_token() }}"},
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#tbl-ubahjenis').DataTable().ajax.reload();
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
                    $('#tbl-ubahjenis').DataTable().ajax.reload();
                  }
                }); 
              }
            },
            error: function(){
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
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

  function musnahkanBarang() 
  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Musnahkan Barang',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#button_save').text('Updating...'); //change button text
          $('#button_save').attr('disabled',true); //set button disable 
          $.ajax({
            url : baseUrl + "/inventory/b_rusak/musnahkan-barang-rusak",
            type: "POST",
            dataType: "JSON",
            data: $('#form_opsi_rusak').serialize(),
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#button_save').text('Update'); //change button text
                    $('#button_save').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    location.reload();
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
                    $('#button_save').text('Update'); //change button text
                    $('#button_save').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    location.reload();
                  }
                }); 
              }
            },
            error: function(){
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
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

  function kembalikanBarang() 
  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Kembalikan Barang Rusak',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#button_save').text('Updating...'); //change button text
          $('#button_save').attr('disabled',true); //set button disable 
          $.ajax({
            url : baseUrl + "/inventory/b_rusak/kembalikan-barang-rusak",
            type: "POST",
            dataType: "JSON",
            data: $('#form_opsi_rusak').serialize(),
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#button_save').text('Update'); //change button text
                    $('#button_save').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    location.reload();
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
                    $('#button_save').text('Update'); //change button text
                    $('#button_save').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    location.reload();
                  }
                }); 
              }
            },
            error: function(){
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
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

  function simpanUbahJenis() 
  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Pindahkan Barang ke TAB UBAH JENIS',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#button_save').text('Updating...'); //change button text
          $('#button_save').attr('disabled',true); //set button disable 
          $.ajax({
            url : baseUrl + "/inventory/b_rusak/simpan-ubah-jenis",
            type: "POST",
            dataType: "JSON",
            data: $('#form_opsi_rusak').serialize(),
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#button_save').text('Update'); //change button text
                    $('#button_save').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    location.reload();
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
                    $('#button_save').text('Update'); //change button text
                    $('#button_save').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    location.reload();
                  }
                }); 
              }
            },
            error: function(){
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
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

  function submitUbahJenis() 
  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Simpan Ubah Jenis Barang Rusak',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          var IsValid = $("form[name='formProsesUbahJenis']").valid();
          if(IsValid)
          {
            var countRow = $('#div_item_jenis tr').length;
            if(countRow > 1)
            {
              $('#divSelectNotaJenis').removeClass('has-error');
              $('#btn_submit_jenis').text('Processing...'); //change button text
              $('#btn_submit_jenis').attr('disabled',true); //set button disable 
              $.ajax({
                url : baseUrl + "/inventory/b_rusak/proses-ubah-jenis",
                type: "POST",
                dataType: "JSON",
                data: $('#form-proses-ubahjenis').serialize(),
                success: function(response)
                {
                  if(response.status == "sukses")
                  {
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    iziToast.success({
                      position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                      title: 'Pemberitahuan',
                      message: response.pesan,
                      onClosing: function(instance, toast, closedBy){
                        $('#btn_submit_jenis').text('Update'); //change button text
                        $('#btn_submit_jenis').attr('disabled',false); //set button enable
                        $('#modal-proses-ubahjenis').modal('hide');
                        location.reload();
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
                        $('#btn_submit_jenis').text('Update'); //change button text
                        $('#btn_submit_jenis').attr('disabled',false); //set button enable
                        $('#modal-proses-ubahjenis').modal('hide');
                        location.reload();
                      }
                    }); 
                  }
                },
                error: function(){
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.warning({
                    icon: 'fa fa-times',
                    message: 'Terjadi Kesalahan!'
                  });
                },
                async: false
              });
            }
            else
            {
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
              iziToast.warning({
                position: 'center',
                message: "Mohon maaf, form pada tabel dilarang kosong !"
              });
            }//end check table form
          }
          else
          {
            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            iziToast.warning({
              position: 'center',
              message: "Mohon Lengkapi data form !",
              onClosing: function(instance, toast, closedBy){
                $('#divSelectNotaJenis').addClass('has-error');
              }
            });
          } 
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function deleteBrgRusak(id)
  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Hapus Data Barang Rusak',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url : baseUrl + "/inventory/b_rusak/kembalikan-barang-rusak",
            type: "POST",
            dataType: "JSON",
            data: {idTabelHeader:id, "_token": "{{ csrf_token() }}"},
            success: function(response)
            {
              if(response.status == "sukses")
              {
                instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                iziToast.success({
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
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
                  position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                  title: 'Pemberitahuan',
                  message: response.pesan,
                  onClosing: function(instance, toast, closedBy){
                    $('#tbl-daftar').DataTable().ajax.reload();
                  }
                }); 
              }
            },
            error: function(){
              instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
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

  function prosesUbahJenis(id) 
  {
    $('#div_item_jenis div').remove();
    $.ajax({
      url : baseUrl + "/inventory/b_rusak/get-detail-ubahjenis/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        $('#lblKodeRusakJenis').text(data.data_isi[0].d_br_code);
        $('#lblNamaBarangJenis').text(data.data_isi[0].i_code+' '+data.data_isi[0].i_name);
        $('#lblQtyJenis').text(data.data_isi[0].qty_pakai+' '+data.data_isi[0].m_sname);
        $('#lblPemberiJenis').text(data.data_isi[0].d_br_pemberi);
        $('#lblKeteranganEdit').text(data.data_isi[0].d_brdt_keterangan);
        $("input[name='idHeaderJenis']").val(data.data_isi[0].d_brdt_brid);
        $("input[name='idBrgRusak']").val(data.data_isi[0].i_id);
        $("input[name='qtyBrgRusak']").val(data.data_isi[0].qty_pakai);
        $("input[name='codeBrgRusak']").val(data.data_isi[0].d_br_code);
        $("input[name='satBrgRusak']").val(data.data_isi[0].d_brdt_sat);
       
        $('#grup-tombol').html('<button type="button" id="button_save" class="btn btn-primary" onclick="submitUbahJenis()">Simpan Data</button>'
        +'<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
    $('#modal-proses-ubahjenis').modal('show');
  }

  function clearInput() 
  {
    $('#ip_sat').empty();
    $('#ip_item').val("");
    $('#ip_barang').val("");
    $('#ip_scomp').val("");
    $('#ip_spos').val("");
    $('#ip_qtyreq').val("");
    $('#ip_qtyStok').val("");
    $('#ip_keterangan').val("");
  }

  function clearInput2() 
  {
    $('#ip_sat_jenis').empty();
    $('#ip_item_jenis').val("");
    $('#ip_barang_jenis').val("");
    $('#ip_scomp_jenis').val("");
    $('#ip_spos_jenis').val("");
    $('#ip_qtyreq_jenis').val("");
    $('#ip_qtyStok_jenis').val("");
    $('#ip_keterangan_jenis').val("");
  }

  function convertToAngka(rupiah)
  {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
  }

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

  function refreshTabelIndex()
  {
    $('#tbl-daftar').DataTable().ajax.reload(); 
  }

  function refreshTabelMusnah()
  {
    $('#tbl-musnah').DataTable().ajax.reload(); 
  }

  function refreshTabelUbahJenis()
  {
    $('#tbl-ubahjenis').DataTable().ajax.reload(); 
  }
  
</script>
@endsection