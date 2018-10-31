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
        <div class="page-title">Return Pembelian</div>
    </div>

    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Return Pembelian</li>
    </ol>

    <div class="clearfix">
    </div>
  </div>

  <div class="page-content fadeInRight">
    <div id="tab-general">
      <div class="row mbl">
        <div class="col-lg-12">
                    
          <div class="col-md-12">
              <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;"></div>
          </div>
                    
          <ul id="generalTab" class="nav nav-tabs">
            <li class="active"><a href="#index-tab" data-toggle="tab">Return Pembelian</a></li>
            <li><a href="#revisi-tab" data-toggle="tab" onclick="lihatRevisiByTgl()">Revisi PO</a></li>
          </ul>

          <div id="generalTabContent" class="tab-content responsive" >
            <!-- div index-tab -->  
            @include('purchasing.returnpembelian.tab-index')
            <!-- div revisi-tab -->
            @include('purchasing.returnpembelian.tab-revisi')
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- modal -->
  <!--modal detail-rev-->
  @include('purchasing.returnpembelian.modal-detail-rev')
  <!--modal detail-->
  @include('purchasing.returnpembelian.modal-detail')
  <!--modal edit-->
  @include('purchasing.returnpembelian.modal-edit')
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

    $(document).on('click', '.btn_remove', function(){
      var button_id = $(this).attr('id');
      $('#row'+button_id+'').remove();
      totalNilaiReturn();
      totalNilaiReturnRaw();
    });

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      $('tr').remove('.tbl_modal_detail_row');
      $('tr').remove('.tbl_modal_edit_row');
      $('tr').remove('.tbl_modal_row');
      //remove span class in modal detail
      $("#txt_span_status_detail_rev").removeClass();
      $('#txt_span_status_detail').removeClass();
      $('#txt_span_status_edit').removeClass();
    });

    //event focus on input qty
    $(document).on('focus', '.field_qty',  function(e){
        var qty = $(this).val();
        $(this).val(qty);
        $('#button_save').attr('disabled', true);
    });

    //event onblur input qty
    $(document).on('blur', '.field_qty',  function(e){
      var getid = $(this).attr("id");
      var qtyReturn = $(this).val();
      //alert(qtyReturn);
      var cost = $('#costRaw_'+getid+'').val();
      var hasilTotalRaw = parseFloat(qtyReturn * cost).toFixed(2);
      var hasilTotal = parseInt(qtyReturn * cost);
      var totalCost = $('#total_'+getid+'').val(convertDecimalToRupiah(hasilTotal));
      var totalCostRaw = $('#totalRaw_'+getid+'').val(hasilTotalRaw);
      // $(this).val(potonganRp);
      totalNilaiReturn();
      totalNilaiReturnRaw();
      $('#button_save').attr('disabled', false);
    });

    //load fungsi
    lihatReturnByTanggal();
  //end jquery
  });

  function lihatReturnByTanggal()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#tabel-return').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/purchasing/returnpembelian/get-return-by-tgl/"+tgl1+"/"+tgl2,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "tglBuat", "width" : "10%"},
        {"data" : "d_pcsr_code", "width" : "10%"},
        {"data" : "m_name", "width" : "7%"},
        {"data" : "metode", "width" : "10%"},
        {"data" : "s_company", "width" : "15%"},
        {"data" : "hargaTotal", "width" : "15%"},
        {"data" : "status", "width" : "7%"},
        {"data" : "action", orderable: false, searchable: false}
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

  function lihatRevisiByTgl()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#tbl-history').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/purchasing/returnpembelian/get-list-revisi-bytgl/"+tgl1+"/"+tgl2,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "tglBuat", "width" : "10%"},
        {"data" : "d_pcs_code", "width" : "10%"},
        {"data" : "m_name", "width" : "10%"},
        {"data" : "s_company", "width" : "15%"},
        {"data" : "d_pcs_method", "width" : "10%"},
        {"data" : "hargaTotalNet", "width" : "15%"},
        {"data" : "tglTerima", "width" : "10%"},
        {"data" : "status", "width" : "5%"},
        {"data" : "action", "width" : "5%"}
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

  function detailReturPembelian(id) 
  {
    $.ajax({
      url : baseUrl + "/purchasing/returnpembelian/get-data-detail/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var i = randString(5);
        var key = 1;
        $('#txt_span_status_detail').text(data.spanTxt);
        $("#txt_span_status_detail").addClass('label'+' '+data.spanClass);
        $('#lblNotaPembelian').text(data.header[0].d_pcs_code);
        $('#lblCodeReturn').text(data.header[0].d_pcsr_code);
        $('#lblTglReturn').text(data.header2.tanggalReturn);
        $('#lblStaff').text(data.header[0].m_name);
        $('#lblSupplier').text(data.header[0].s_company);
        $('#lblMetode').text(data.lblMethod);
        $('#lblTotalReturn').text(data.header2.hargaTotalReturn);
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-detail').append('<tr class="tbl_modal_detail_row" id="row'+i+'">'
                          +'<td class="center">'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'</td>'
                          +'<td class="right">'+formatAngka(data.data_isi[key-1].d_pcsrdt_qty)+'</td>'
                          +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                          +'<td class="right">'+separatorRibuanRp(data.data_isi[key-1].d_pcsrdt_price)+'</td>'
                          +'<td class="right">'+separatorRibuanRp(data.data_isi[key-1].d_pcsrdt_pricetotal)+'</td>'
                          +'<td class="right">'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                          +'</tr>');
          key++;  
          i = randString(5);
        });
        $('#divBtnModalDetail').html(
          '<a href="'+ baseUrl +'/purchasing/returnpembelian/print-sj-retur/'+ id +'" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i>&nbsp;Print</a>'+
          '<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
        $('#modal-detail').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function editReturPembelian(id) 
  {
    $.ajax({
      url : baseUrl + "/purchasing/returnpembelian/get-data-detail/"+id+"/all",
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var i = randString(5);
        var key = 1;
        $('#txt_span_status_edit').text(data.spanTxt);
        $("#txt_span_status_edit").addClass('label'+' '+data.spanClass);
        $('#lblCodeReturnEdit').text(data.header[0].d_pcsr_code);
        $('#lblNotaPembelianEdit').text(data.header[0].d_pcs_code);
        $('#lblTglReturnEdit').text(data.header2.tanggalReturn);
        $('#lblStaffEdit').text(data.staff['nama']);
        $('#id_staff_edit').val(data.staff['id']);
        $('#lblSupplierEdit').text(data.header[0].s_company);
        $('#lblMetodeEdit').text(data.lblMethod);
        $('#lblTotalReturnEdit').text(data.header2.hargaTotalReturn);
        $('#id_return').val(data.header[0].d_pcsr_id);
        $('#id_sup').val(data.header[0].d_pcsr_supid);
        $('#code_return').val(data.header[0].d_pcsr_code);
        $('#method_return').val(data.header[0].d_pcsr_method);
        $('#price_total').val(data.header[0].d_pcsr_pricetotal);
        $('#price_total_nett').val(data.header[0].d_pcs_total_net);
        $('#price_result').val(data.header[0].d_pcsr_priceresult);
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          var qtyCost = data.data_isi[key-1].d_pcsrdt_qty;
          var hargaSatuanItemNet = data.data_isi[key-1].d_pcsrdt_price
          var hargaTotalItemNet = Math.round(parseFloat(qtyCost * hargaSatuanItemNet).toFixed(2));
          var hargaTotalPerRow = hargaSatuanItemNet * qtyCost;
          //console.log(hargaSatuanItemNet);
          $('#tabel-edit').append('<tr class="tbl_modal_edit_row" id="row'+i+'">'
                          +'<td style="text-align:center">'+key+'</td>'
                          +'<td><input type="text" value="'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'" name="fieldNamaItem[]" class="form-control" readonly/>'
                          +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_item+'" name="fieldIdItem[]" class="form-control" readonly/>'
                          +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_id+'" name="fieldIdDt[]" class="form-control"/>'
                          +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_smdetail+'" name="fieldSmidDetail[]" class="form-control"/>'
                          +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsrdt_qty+'" name="fieldQtyLalu[]" class="form-control right"/></td>'
                          +'<td><input type="text" value="'+qtyCost+'" name="fieldQty[]" class="form-control field_qty numberinput input-sm right" id="'+i+'"/></td>'
                          +'<td><input type="text" value="'+data.data_isi[key-1].m_sname+'" name="fieldSatuanTxt[]" class="form-control input-sm" readonly/>'
                          +'<input type="hidden" value="'+data.data_isi[key-1].m_sid+'" name="fieldSatuanId[]" class="form-control input-sm" readonly/></td>'
                          +'<td><input type="text" value="'+convertDecimalToRupiah(hargaSatuanItemNet)+'" name="fieldHarga[]" class="form-control input-sm right" id="cost_'+i+'" readonly/>'
                          +'<input type="hidden" value="'+hargaSatuanItemNet+'" name="fieldHargaRaw[]" id="costRaw_'+i+'" class="form-control input-sm field_harga_raw numberinput" readonly/></td>'
                          +'<td><input type="text" value="'+convertDecimalToRupiah(hargaTotalPerRow)+'" name="fieldHargaTotal[]" class="form-control input-sm hargaTotalItem right" id="total_'+i+'" readonly/>'
                          +'<input type="hidden" value="'+hargaTotalPerRow+'" name="fieldHargaTotalRaw[]" id="totalRaw_'+i+'" class="form-control input-sm hargaTotalItemRaw numberinput" readonly/></td>'
                          +'<td><input type="text" value="'+formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'" name="fieldStokTxt[]" class="form-control input-sm right" readonly/>'
                          +'<input type="hidden" value="'+data.data_stok[key-1].qtyStok+'" name="fieldStokVal[]" class="form-control input-sm" readonly/></td>'
                          +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove btn-sm" disabled>X</button></td>'
                          +'</tr>');
          i = randString(5);
          key++;
        });
        totalNilaiReturn();
        totalNilaiReturnRaw();
        //force integer input in textfield
        $('input.numberinput').bind('keypress', function (e) {
            return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
        });
        $('#modal-edit').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function submitEdit()
  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Update data Return',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $('#btn_update').text('Updating...'); //change button text
          $('#btn_update').attr('disabled',true); //set button disable 
          $.ajax({
            url : baseUrl + "/purchasing/returnpembelian/update-data-return",
            type: "POST",
            dataType: "JSON",
            data: $('#form-edit-return').serialize(),
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
                    $('#btn_update').text('Update'); //change button text
                    $('#btn_update').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    $('#tabel-return').DataTable().ajax.reload();
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
                    $('#btn_update').text('Update'); //change button text
                    $('#btn_update').attr('disabled',false); //set button enable
                    $('#modal-edit').modal('hide');
                    $('#tabel-return').DataTable().ajax.reload();
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

  function deleteReturPembelian(id)
  {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Hapus Data Retur',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url : baseUrl + "/purchasing/returnpembelian/delete-data-return",
            type: "POST",
            dataType: "JSON",
            data: {id:id, "_token": "{{ csrf_token() }}"},
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
                    $('#tabel-return').DataTable().ajax.reload();
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
                    $('#tabel-return').DataTable().ajax.reload();
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

  function detailPoRev(id) 
  {
    $.ajax({
      url : baseUrl + "/purchasing/returnpembelian/get-detail-revisi/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var i = randString(5);
        var key = 1;
        $('#txt_span_status_detail_rev').text(data.spanTxt);
        $("#txt_span_status_detail_rev").addClass('label'+' '+data.spanClass);
        $('#lblNoOrder').text(data.header[0].d_pcs_code);
        $('#lblCaraBayar').text(data.header[0].d_pcs_method);
        $('#lblTglOrder').text(formatTanggal(data.header[0].d_pcs_date_created));
        $('#lblTglKirim').text(formatTanggal(data.header[0].d_pcs_date_received));
        $('#lblStaffRev').text(data.header[0].m_name);
        $('#lblSupplierRev').text(data.header[0].s_company);
        $('[name="totalHarga"]').val(data.header2.hargaBruto);
        $('[name="diskonHarga"]').val(data.header2.nilaiDiskon);
        $('[name="ppnHarga"]').val(data.header2.nilaiPajak);
        $('[name="totalHargaFinal"]').val(data.header2.hargaNet);
        if (data.header[0].d_pcs_method != "CASH") 
        {
          $('#append-modal-detail div').remove();
          var metode = data.header[0].d_pcs_method;
          if (metode == "DEPOSIT") 
          {
            $('#append-modal-detail div').remove();
            $('#append-modal-detail').append('<div class="col-md-3 col-sm-12 col-xs-12">'
                                      +'<label class="tebal">Batas Terakhir Pengiriman</label>'
                                  +'</div>'
                                  +'<div class="col-md-9 col-sm-12 col-xs-12">'
                                    +'<div class="form-group">'
                                      +'<label id="dueDate">'+formatTanggal(data.header[0].d_pcs_duedate)+'</label>'
                                    +'</div>'
                                  +'</div>');
          }
          else if(metode == "CREDIT")
          {
            $('#append-modal-detail div').remove();
            $('#append-modal-detail').append('<div class="col-md-3 col-sm-12 col-xs-12">'
                                      +'<label class="tebal">TOP (Termin Of Payment)</label>'
                                  +'</div>'
                                  +'<div class="col-md-9 col-sm-12 col-xs-12">'
                                    +'<div class="form-group">'
                                      +'<label id="dueDate">'+data.header[0].d_pcs_duedate+'</label>'
                                    +'</div>'
                                  +'</div>');
          }
        }
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-order').append('<tr class="tbl_modal_row" id="row'+i+'">'
                          +'<td>'+key+'</td>'
                          +'<td>'
                            +data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name
                            +'<input type="hidden" class="input-sm form-control" name="ip_item[]" value="'+data.data_isi[key-1].i_id+'">'
                          +'</td>'
                          +'<td>'
                            +data.data_isi[key-1].m_sname
                            +'<input type="hidden" class="input-sm form-control" name="ip_sid[]" value="'+data.data_isi[key-1].m_sid+'">'
                          +'</td>'
                          +'<td align="right">'
                            +formatAngka(data.data_isi[key-1].d_pcsdt_qty)
                            +'<input type="hidden" class="input-sm form-control" name="ip_qty[]" value="'+data.data_isi[key-1].d_pcsdt_qty+'">'
                          +'</td>'
                          +'<td align="right">'
                            +formatAngka(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]
                          +'</td>'
                          +'<td align="right">'
                            +formatAngka(data.data_isi[key-1].d_pcsdt_prevcost)
                            +'<input type="hidden" class="input-sm form-control" name="ip_prevcost[]" value="'+data.data_isi[key-1].d_pcsdt_prevcost+'">'
                          +'</td>'
                          +'<td align="right">'
                            +formatAngka(data.data_isi[key-1].d_pcsdt_price)
                            +'<input type="hidden" class="input-sm form-control" name="ip_price[]" value="'+data.data_isi[key-1].d_pcsdt_price+'">'
                          +'</td>'
                          +'<td align="right">'
                            +formatAngka(data.data_isi[key-1].d_pcsdt_price * data.data_isi[key-1].d_pcsdt_qty)
                            +'<input type="hidden" class="input-sm form-control" name="ip_total[]" value="'+data.data_isi[key-1].d_pcsdt_price * data.data_isi[key-1].d_pcsdt_qty+'">'
                          +'</td>'
                        +'</tr>');
          key++;  
          i = randString(5);
        });
        $('#divBtnModal').html(
          '<button type="button" class="btn btn-success" onclick="ubahStatusToReceived('+data.header[0].d_pcs_id+')">Ubah Status</button>'+
          '<a href="'+ baseUrl +'/purchasing/returnpembelian/print-revisi-po/'+ id +'" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i>&nbsp;Print</a>'+
          '<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
        $('#modal-detail-rev').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function ubahStatusToReceived(id) {
    iziToast.question({
      timeout: 20000,
      close: false,
      overlay: true,
      displayMode: 'once',
      // id: 'question',
      // zindex: 999,
      title: 'Peringatan!!',
      message: 'Anda akan merivisi PO lama sesuai dengan data tertampil',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
            var dataform = $('#form-revisi-po').serialize();
            $.ajax({
              type: "POST",
              url : baseUrl + "/purchasing/returnpembelian/ubah-status-po/" + id,
              data: dataform,
              success: function(response){
                if(response.status == "sukses")
                {
                  instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                  iziToast.success({
                    position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                    title: 'Pemberitahuan',
                    message: response.pesan,
                    onClosing: function(instance, toast, closedBy){
                      $('#modal-detail-rev').modal('hide');
                      refreshTabelRevisi();
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
                      $('#modal-detail-rev').modal('hide');
                      refreshTabelRevisi();
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

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
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

  function separatorRibuan(num)
  {
    var num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return num_parts.join(".");
  }

  function separatorRibuanRp(num)
  {
    var num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return 'Rp. '+num_parts.join(",");
  }

  function formatAngka(decimal) 
  {
    var angka = parseInt(decimal);
    var fAngka = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++){
      if(i%3 == 0) fAngka += angkarev.substr(i,3)+'.';
    } 
    var hasil = fAngka.split('',fAngka.length-1).reverse().join('');
    return hasil;
  }

  function convertToAngka(rupiah)
  {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
  }

  function convertToRupiah(angka) 
  {
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00'; 
  }

  function totalNilaiReturn()
  {
    var inputs = document.getElementsByClassName( 'hargaTotalItem' ),
    hasil  = [].map.call(inputs, function( input ) 
    {
      if(input.value == '') input.value = 0;
      return input.value;
    });
    console.log(hasil);
    var total = 0;
    for (var i = hasil.length - 1; i >= 0; i--){

      hasil[i] = convertToAngka(hasil[i]);
      hasil[i] = parseInt(hasil[i]);
      total = total + hasil[i];
    }
      if (isNaN(total)) {
          total=0;
        }
    total = convertToRupiah(total);
    // console.log(total);
    $('#lblTotalReturnEdit').text(total);
    $('#price_total').val(total);
  }

  function totalNilaiReturnRaw()
  {
    var inputs = document.getElementsByClassName( 'hargaTotalItemRaw' ),
    hasil  = [].map.call(inputs, function( input ) 
    {
      if(input.value == '') input.value = 0;
      return input.value;
    });
    //console.log(hasil);
    var total = 0;
    for (var i = 0; i < hasil.length; i++){
      total = (parseFloat(total) + parseFloat(hasil[i])).toFixed(2);
      // console.log(total);
    }
      if (isNaN(total)) {
        total = parseFloat(0).toFixed(2);
      }
    $('[name="priceTotalRaw"]').val(total);
  }

  function refreshTabelIndex() 
  {
    $('#tabel-return').DataTable().ajax.reload();
  }

  function refreshTabelRevisi() 
  {
    $('#tbl-history').DataTable().ajax.reload();
  }

  function formatTanggal(dateString)
  {
    var p = dateString.split(/\D/g)
    return [p[2],p[1],p[0] ].join("-")
  }
</script>
@endsection