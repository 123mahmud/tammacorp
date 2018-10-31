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
        <div class="page-title">Penerimaan Barang Supplier</div>
    </div>

    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Inventory&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Penerimaan Barang Supplier</li>
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
            <li class="active"><a href="#index-tab" data-toggle="tab">Daftar Penerimaan</a></li>
            <li><a href="#wait-tab" data-toggle="tab" onclick="listWaitingByTgl()">Daftar Tunggu</a></li>
            <li><a href="#finish-tab" data-toggle="tab" onclick="listReceivedByTgl()">Daftar Hasil Penerimaan</a></li>
          </ul>

          <div id="generalTabContent" class="tab-content responsive">
            
            @include('inventory.p_suplier.tab-index')
            @include('inventory.p_suplier.tab-wait')
            @include('inventory.p_suplier.tab-finish')          

          </div>
        </div>
      </div>
    </div>
  </div>
  <!--END TITLE & BREADCRUMB PAGE-->
  <!-- modal -->
    <!--modal Tambah Terima-->
    @include('inventory.p_suplier.modal')
    @include('inventory.p_suplier.modal-detail')
    @include('inventory.p_suplier.modal-detail-peritem')
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

    $('.datepicker3').datepicker({
      format:"dd-mm-yyyy",
      autoclose: true
    });

    //select2
    $( "#head_nota_purchase" ).select2({
      placeholder: "Pilih Nota Pembelian...",
      ajax: {
        url: baseUrl + '/inventory/p_suplier/lookup-data-pembelian',
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

    //event onchange select option
    $('#head_nota_purchase').change(function() 
    {
      $('#appending div').remove();
      $('#btn_simpan').attr('disabled', false);
      //remove existing appending row
      $('tr').remove('.tbl_form_row');
      var idPo = $('#head_nota_purchase').val();
      $.ajax({
        url : baseUrl + "/inventory/p_suplier/get-data-form/"+idPo,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          var totalPembelianGross = data.data_header[0].d_pcs_total_gross;
          var totalPembelianNett = data.data_header[0].d_pcs_total_net;
          var totalDisc = parseInt(data.data_header[0].d_pcs_disc_value) + parseInt(data.data_header[0].d_pcs_discount);
          var taxPercent = data.data_header[0].d_pcs_tax_percent;
          if(data.data_header[0].d_pcs_method != "CASH")
          {
            var date = data.data_header[0].d_pcs_duedate;
            var newDueDate = date.split("-").reverse().join("-");
          }
          //console.log(totalDisc);
          $('#head_nota_txt').val($('#head_nota_purchase').text());
          $('#head_supplier').val(data.data_header[0].s_company);
          $('#head_supplier_id').val(data.data_header[0].s_id);
          $('#head_total_gross').val(convertDecimalToRupiah(totalPembelianGross));
          $('#head_total_disc').val(convertDecimalToRupiah(totalDisc));
          $('#head_total_tax').val(taxPercent+' %');
          $('#head_total_nett').val(convertDecimalToRupiah(totalPembelianNett));
          $('#head_total_terima').val(convertDecimalToRupiah(totalPembelianNett));
          $('#head_method').val(data.data_header[0].d_pcs_method);
          if (data.data_header[0].d_pcs_method == "DEPOSIT") 
          {
            $('#appending div').remove();
            $('#appending').append('<div class="form-group">'
                                      +'<input type="hidden" id="apd_tgl" name="apdTgl" class="form-control datepicker3 input-sm" readonly value="'+newDueDate+'">'
                                    +'</div>');
          }
          else if (data.data_header[0].d_pcs_method == "CREDIT")
          {
            $('#appending div').remove();
            $('#appending').append('<div class="form-group">'
                                      +'<input type="hidden" id="apd_tgl" name="apdTgl" class="form-control datepicker3 input-sm" readonly value="'+newDueDate+'">'
                                    +'</div>');
          }

          //persentase diskon berdasarkan total harga bruto
          var percentDiscTotalGross = parseFloat(totalDisc*100/totalPembelianGross);
          var key = 1;
          i = randString(5);
          //loop data
          Object.keys(data.data_isi).forEach(function(){
            var hargaTotalItemGross = data.data_isi[key-1].d_pcsdt_total;
            var qtyCost = data.data_isi[key-1].d_pcsdt_qtyconfirm;
            var qtyTerima = data.data_qty[key-1];
            //harga total per item setelah kena diskon & pajak
            var hargaTotalItemNet = Math.round(parseFloat(hargaTotalItemGross - (hargaTotalItemGross * percentDiscTotalGross/100) + ((hargaTotalItemGross - (hargaTotalItemGross * percentDiscTotalGross/100)) * taxPercent/100)).toFixed(2));
            console.log(hargaTotalItemNet);
            var hargaSatuanItemNet = hargaTotalItemNet/qtyCost;
            var hargaTotalPerRow = hargaSatuanItemNet * qtyTerima;
            //console.log(hargaSatuanItemNet);
            $('#tabel-modal-terima').append('<tr class="tbl_form_row" id="row'+i+'">'
                            +'<td style="text-align:center">'+key+'</td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].i_code+' | '+data.data_isi[key-1].i_name+'" name="fieldNamaItem[]" class="form-control input-sm" readonly/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].i_id+'" name="fieldItemId[]" class="form-control input-sm"/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].d_pcsdt_id+'" name="fieldIdPurchaseDet[]" class="form-control input-sm"/></td>'
                            +'<td><input type="text" value="'+qtyCost+'" name="fieldQty[]" class="form-control numberinput input-sm field_qty" readonly/></td>'
                            +'<td><input type="text" value="'+qtyTerima+'" name="fieldQtyterima[]" class="form-control numberinput input-sm field_qty_terima" id="'+i+'"/>'
                            +'<input type="hidden" value="'+qtyTerima+'" name="fieldQtyterimaHidden[]" class="form-control numberinput input-sm" id="qtymskhidden_'+i+'"/></td>'
                            +'<td><input type="text" value="'+data.data_isi[key-1].m_sname+'" name="fieldSatuanTxt[]" class="form-control input-sm" readonly/>'
                            +'<input type="hidden" value="'+data.data_isi[key-1].m_sid+'" name="fieldSatuanId[]" class="form-control input-sm" readonly/>'
                            +'<input type="hidden" value="'+convertDecimalToRupiah(hargaSatuanItemNet)+'" name="fieldHarga[]" id="cost_'+i+'" class="form-control input-sm field_harga numberinput" readonly/>'
                            +'<input type="hidden" value="'+hargaSatuanItemNet+'" name="fieldHargaRaw[]" id="costRaw_'+i+'" class="form-control input-sm field_harga_raw numberinput" readonly/>'
                            +'<input type="hidden" value="'+convertDecimalToRupiah(hargaTotalPerRow)+'" name="fieldHargaTotal[]" class="form-control input-sm hargaTotalItem" id="total_'+i+'" readonly/>'
                            +'<input type="hidden" value="'+hargaTotalPerRow+'" name="fieldHargaTotalRaw[]" id="totalRaw_'+i+'" class="form-control input-sm field_hargatotal_raw numberinput" readonly/></td>'
                            +'<td><input type="text" value="'+data.data_stok[key-1].qtyStok+' '+data.data_satuan[key-1]+'" name="fieldStokTxt[]" class="form-control input-sm" readonly/>'
                            +'<input type="hidden" value="'+data.data_stok[key-1].qtyStok+'" name="fieldStokVal[]" class="form-control input-sm" readonly/></td>'
                            +'<td><button name="remove" id="'+i+'" class="btn btn-danger btn_remove btn-sm">X</button></td>'
                            +'</tr>');
            i = randString(5);
            key++;
          });
          totalNilaiPenerimaan();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
      });
    });

    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

    //remove row in modal form
    $(document).on('click', '.btn_remove', function(){
      var button_id = $(this).attr('id');
      $('#row'+button_id+'').remove();
      totalNilaiPenerimaan();
    });

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      $('#btn_simpan').attr('disabled', true);
      //remove append tr
      $('tr').remove('.tbl_form_row');
      $('tr').remove('.tbl_modal_detail_row');
      $('tr').remove('.tbl_modal_detailmsk_row');
      //reset all input txt field
      $('#form-terima-beli')[0].reset();
      //empty select2 field
      $('#head_nota_purchase').empty();
      //remove appending div
      $('#appending div').remove();
      //set datepicker to today 
      $('.datepicker2').datepicker('setDate', 'today');
      //remove class all jquery validation error
      $('.form-group').find('.error').removeClass('error');
      $('.form-group').removeClass('has-valid has-error');
    });

    //event focus on input qty
    $(document).on('focus', '.field_qty_terima',  function(e){
        var qty = $(this).val();
        $(this).val(qty);
        $('#btn_simpan').attr('disabled', true);
    });

    $(document).on('blur', '.field_qty_terima',  function(e){
      var getid = $(this).attr("id");
      var qtyReturn = $(this).val();
      var cost = $('#costRaw_'+getid+'').val();
      var hasilTotal = parseInt(qtyReturn * cost);
      var hasilTotalRaw = parseFloat(qtyReturn * cost).toFixed(2);
      var totalCost = $('#total_'+getid+'').val(convertDecimalToRupiah(hasilTotal));
      var totalCostRaw = $('#totalRaw_'+getid+'').val(hasilTotalRaw);
      // $(this).val(potonganRp);
      totalNilaiPenerimaan();
      $('#btn_simpan').attr('disabled', false);
    });

    $(document).on('keyup', '.field_qty_terima', function(e) {
      var val = parseInt($(this).val());
      var getid = $(this).attr("id");
      var qtyRemain = $('#qtymskhidden_'+getid+'').val();
      console.log(getid);
      if (val > qtyRemain || $(this).val() == "" || val == 0) {
        $(this).val(qtyRemain);
      }
    });

    //validasi
    $("#form-terima-beli").validate({
      rules:{
        headTglTerima: "required",
        headNotaPurchase: "required",
      },
      errorPlacement: function() {
          return false;
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    $('#head_nota_purchase').change(function(event) {
      if($(this).val() != ""){
        $('#divSelectNota').removeClass('has-error').addClass('has-valid');
      }else{
        $('#divSelectNota').addClass('has-error').removeClass('has-valid');
      }
    });

    //load fungsi
    lihatPenerimaanByTanggal();

  //end jquery
  });

  function lihatPenerimaanByTanggal()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#tbl-daftar').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/inventory/p_suplier/get-penerimaan-by-tgl/"+tgl1+"/"+tgl2,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "tglBuat", "width" : "10%"},
        {"data" : "d_tb_code", "width" : "10%"},
        {"data" : "m_name", "width" : "10%"},
        {"data" : "s_company", "width" : "20%"},
        {"data" : "d_pcs_code", "width" : "10%"},
        {"data" : "d_pcs_date_created", "width" : "10%"},
        {"data" : "action", orderable: false, searchable: false, "width" : "10%"}
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

  function totalNilaiPenerimaan()
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
    $('#head_total_terima').val(total);
  }

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

  function detailPenerimaan(id) 
  {
    $.ajax({
      url : baseUrl + "/inventory/p_suplier/get-detail-penerimaan/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var date = data.header[0].d_pcs_duedate;
        if(date != null) { var newDueDate = date.split("-").reverse().join("-"); }
        
        //ambil data ke json->modal
        $('#lblNotaPembelian').text(data.header[0].d_pcs_code);
        $('#lblNotaPenerimaan').text(data.header[0].d_tb_code);
        $('#lblTglPenerimaan').text(data.header2.tanggalTerima);
        $('#lblStaff').text(data.header[0].m_name);
        $('#lblSupplier').text(data.header[0].s_company);

        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-detail').append('<tr class="tbl_modal_detail_row">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_code+' '+data.data_isi[key-1].i_name+'</td>'
                          +'<td class="text-center">'+separatorRibuan(data.data_isi[key-1].d_pcsdt_qtyconfirm)+'</td>'
                          +'<td class="text-center">'+separatorRibuan(data.data_isi[key-1].d_tbdt_qty)+'</td>'
                          +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                          // +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_tbdt_price)+'</td>'
                          // +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_tbdt_pricetotal)+'</td>'
                          +'<td class="text-right">'+separatorRibuan(data.data_stok[key-1].qtyStok)+' '+data.data_satuan[key-1]+'</td>'
                          +'</tr>');
          key++;
        });
        $('#apdsfs').html('<a href="'+ baseUrl +'/inventory/p_suplier/print/'+ id +'" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i>&nbsp;Print</a>'+
        '<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
        $('#modal_detail').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function detailListReceived(id) 
  {
    $.ajax({
      url : baseUrl + "/inventory/p_suplier/get-penerimaan-peritem/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var key = 1;
        var dateCreated = data.header[0].d_pcs_date_created;
        var newDateCreated = dateCreated.split("-").reverse().join("-");
        //ambil data ke json->modal
        $('#lblHeadItem').text('( '+data.isi[0].i_code+' '+data.isi[0].i_name+' )');
        $('#lblHeadPo').text(data.header[0].d_pcs_code);
        $('#lblHeadQty').text(data.header[0].d_pcsdt_qty);
        $('#lblHeadTglPo').text(data.header[0].d_pcs_date_created);
        $('#lblHeadSup').text(data.header[0].s_company);
        //loop data
        Object.keys(data.isi).forEach(function(){
          $('#tabel-detail-peritem').append('<tr class="tbl_modal_detailmsk_row">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.isi[key-1].i_code+' '+data.isi[key-1].i_name+'</td>'
                          +'<td>'+data.isi[key-1].m_sname+'</td>'
                          +'<td>'+data.isi[key-1].d_tbdt_qty+'</td>'
                          +'<td>'+data.isi[key-1].d_tb_code+'</td>'
                          +'<td>'+data.tanggalTerima[key-1]+'</td>'
                          +'</tr>');
          key++;
        });
        $('#modal_detail_peritem').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function submitTerima() {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Terima data pembelian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          var IsValid = $("form[name='formTerimaBeli']").valid();
          if(IsValid)
          {
            var countRow = $('#div_item tr').length;
            if(countRow > 0)
            {
              $('#divSelectNota').removeClass('has-error');
              $('#btn_simpan').text('Updating...');
              $('#btn_simpan').attr('disabled',true);
              $.ajax({
                url : baseUrl + "/inventory/p_suplier/simpan-penerimaan",
                type: "POST",
                dataType: "JSON",
                data: $('#form-terima-beli').serialize(),
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
                        $('#modal_terima_beli').modal('hide');
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
                        $('#modal_terima_beli').modal('hide');
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

  function deletePenerimaan(id) {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Hapus data penerimaan',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url : baseUrl + "/inventory/p_suplier/delete-data-penerimaan",
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

  function listWaitingByTgl()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#tbl-waiting').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/inventory/p_suplier/get-list-waiting-bytgl/"+tgl1+"/"+tgl2,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "d_pcs_code", "width" : "10%"},
        {"data" : "s_company", "width" : "15%"},
        {"data" : "i_name", "width" : "15%"},
        {"data" : "m_sname", "width" : "5%"},
        {"data" : "d_pcsdt_qtyconfirm", "width" : "5%"},
        {"data" : "qty_remain", "width" : "5%"},
        {"data" : "tglBuat", "width" : "10%"},
        {"data" : "status", "width" : "5%"},
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

  function listReceivedByTgl()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#tbl-received').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/inventory/p_suplier/get-list-received-bytgl/"+tgl1+"/"+tgl2,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "d_pcs_code", "width" : "10%"},
        {"data" : "s_company", "width" : "15%"},
        {"data" : "i_name", "width" : "15%"},
        {"data" : "m_sname", "width" : "5%"},
        {"data" : "d_pcsdt_qtyconfirm", "width" : "5%"},
        {"data" : "qty_received", "width" : "5%"},
        {"data" : "tglBuat", "width" : "10%"},
        {"data" : "status", "width" : "5%"},
        {"data" : "action", "width" : "5%"},
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

  function refreshTabelIndex()
  {
    $('#tbl-daftar').DataTable().ajax.reload(); 
  }

  function refreshTabelWaiting() 
  {
    $('#tbl-waiting').DataTable().ajax.reload();
  }

</script>
@endsection()