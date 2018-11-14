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
          <div class="page-title">Belanja Harian</div>
      </div>

      <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li><i></i>&nbsp;Purchasing&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Belanja Harian</li>
      </ol>

      <div class="clearfix">
      </div>

    </div>

    <div class="page-content fadeInRight">
      <div class="col-lg-12" >
                <div class="col-lg-1" >
                </div>
                <div class="col-lg-2" >
                    <div style="background-color: #777;color: white;" class="alert alert-primary alert-dismissible" title="DP sudah Lunas">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>NOTICE !</strong> <br>
                        <label class="badge badge-pill badge-primary waiting">{{ $waiting }}</label>
                        waiting
                    </div>
                </div>
                <div class="col-lg-2" >
                    <div style="background-color: #ff6a00;color: white;" class="alert alert-primary alert-dismissible" title="DP sudah Lunas">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>NOTICE !</strong> <br>
                        <label class="badge badge-pill badge-primary confirm">{{ $confirm }}</label>
                        Diseujui
                    </div>
                </div>
                <div class="col-lg-2" >
                    <div style="background-color: #5cb85c;color: white;" class="alert alert-primary alert-dismissible" title="DP sudah Lunas">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>NOTICE !</strong> <br>
                        <label class="badge badge-pill badge-primary dapat_edit">{{ $dapat_edit }}</label>
                        dapat_edit
                    </div>
                </div>
                <div class="col-lg-2" >
                    <div style="background-color: #8d10dc;color: white;" class="alert alert-primary alert-dismissible" title="DP sudah Lunas">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>NOTICE !</strong> <br>
                        <label class="badge badge-pill badge-primary received">{{ $received }}</label>
                        received
                    </div>
                </div>
                <div class="col-lg-2" >
                    <div style="background-color: #d9534f;color: white;" class="alert alert-primary alert-dismissible" title="DP sudah Lunas">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>NOTICE !</strong> <br>
                        <label class="badge badge-pill badge-primary revisi">{{ $revisi }}</label>
                        revisi
                    </div>
                </div>
            </div>
      <div id="tab-general">
        <div class="row mbl">
          <div class="col-lg-12">
                    
            <div class="col-md-12">
                <div id="area-chart-spline" style="width: 100%; height: 300px; display: none;">
                </div>
            </div>
      
                    
            <ul id="generalTab" class="nav nav-tabs">
              <li class="active"><a href="#index-tab" data-toggle="tab">Belanja Harian</a></li>
              <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
              <li><a href="#label-badge-tab" data-toggle="tab">3</a></li> -->
            </ul>
            <div id="generalTabContent" class="tab-content responsive">
              <!-- index tab -->
              @include('purchasing.belanjaharian.tab-index')
          
            </div>
          
          </div>
        </div>
      </div>
    </div>

</div>
  <!-- modal-detail -->
  @include('purchasing.belanjaharian.modal-detail')
  <!-- modal-edit -->
  @include('purchasing.belanjaharian.modal-edit')
@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script type="text/javascript">
  totalPembelian();
  $(document).ready(function() {
    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions);
    
    //force integer input in textfield
    $('input.numberinput').bind('keypress', function (e) {
        return (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && e.which != 46) ? false : true;
    });

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

    //event focus on input harga
    $(document).on('focus', '.field_harga',  function(e){
        var harga = convertToAngka($(this).val());
        $(this).val(harga);
    });

    $(document).on('focus', '#total_bayar_edit',  function(e){
        var bayar = convertToAngka($(this).val());
        $(this).val(bayar);
    });

    //event onblur input harga
    $(document).on('blur', '.field_harga',  function(e){
      var getid = $(this).attr("data-price");
      var harga = $(this).val();
      var qty = $('#qty_'+getid+'').val();
      //hitung nilai harga total
      var valueHargaTotal = convertToRupiah(qty * harga);
      $('#total_'+getid+'').val(valueHargaTotal);
      //ubah format ke rupiah
      var hargaRp = convertToRupiah($(this).val());
      $(this).val(hargaRp);
      totalPembelian();
    });

    $(document).on('blur', '.field_qty',  function(e){
      var getid = $(this).attr("data-qty");
      var qty = $(this).val();
      var harga = convertToAngka($('#price_'+getid+'').val());
      //hitung nilai harga total
      var valueHargaTotal = convertToRupiah(qty * harga);
      $('#total_'+getid+'').val(valueHargaTotal);
      totalPembelian();
    });

    $(document).on('blur', '#total_bayar_edit',  function(e){
      var valueHargaByr = convertToRupiah($(this).val());
      $(this).val(valueHargaByr);
    });

    // fungsi jika modal hidden
    $(".modal").on("hidden.bs.modal", function(){
      $('tr').remove('.tbl_modal_row');
      $('tr').remove('.tbl_modal_edit_row');
      //remove span class in modal detail
      $("#txt_span_status_detail").removeClass();
      $('#txt_span_status_edit').removeClass();
      //remove class all jquery validation error
      $('.form-group').find('.error').removeClass('error');
    });

    $("#form-belanja-edit").validate({
      rules:{
        tanggalBeliEdit: "required",
        noReffEdit: "required"
      },
      errorPlacement: function() {
          return false;
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    //load fungsi
    lihatBelanjaByTanggal();
  //end jquery
  });

  function detailBeliHarian(id) 
  {
    $.ajax({
      url : baseUrl + "/purchasing/belanjaharian/get-detail-belanja/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var i = randString(5);
        var key = 1;
        $('#txt_span_status_detail').text(data.spanTxt);
        $("#txt_span_status_detail").addClass('label'+' '+data.spanClass);
        $('#lblTglBeli').text(data.header2.tanggalBeli);
        $('#lblNoNota').text(data.header[0].d_pcsh_code);
        $('#lblTotalBiaya').text(data.header2.hargaTotalBeli);
        $('#lblStaff').text(data.header[0].m_name);
        $('#lblPeminta').text(data.header[0].d_pcsh_peminta);
        $('#lblKeperluan').text(data.header[0].d_pcsh_keperluan);
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          $('#tabel-detail-beli').append('<tr class="tbl_modal_row" id="row'+i+'">'
                          +'<td>'+key+'</td>'
                          +'<td>'+data.data_isi[key-1].i_name+'</td>'
                          +'<td>'+data.data_isi[key-1].d_pcshdt_qty+'</td>'
                          +'<td>'+data.data_isi[key-1].m_sname+'</td>'
                          +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_pcshdt_price)+'</td>'
                          +'<td>'+convertDecimalToRupiah(data.data_isi[key-1].d_pcshdt_pricetotal)+'</td>'
                          +'</tr>');
          key++;  
          i = randString(5);
        });
        $('#m1a2-abrams').html('<a href="'+ baseUrl +'/purchasing/belanjaharian/print/'+id+'" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i>&nbsp;Print</a>'+
          '<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');
        $('#modal-detail').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          alert('Error get data from ajax');
      }
    });
  }

  function editBeliHarian(id) 
  {
    $.ajax({
      url : baseUrl + "/purchasing/belanjaharian/get-edit-belanja/"+id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        var totalHarga = 0;
        var key = 1;
        i = randString(5);
        $('#txt_span_status_edit').text(data.spanTxt);
        $("#txt_span_status_edit").addClass('label'+' '+data.spanClass);
        $('#tanggal_beli_edit').val(data.tanggal);
        $('#no_nota_edit').val(data.header[0].d_pcsh_code);
        $('#id_belanja_edit').val(data.header[0].d_pcsh_id);
        $('#total_biaya_edit').val(convertDecimalToRupiah(data.header[0].d_pcsh_totalprice));
        $('#peminta_edit').val(data.header[0].d_pcsh_peminta);
        $('#keperluan_edit').val(data.header[0].d_pcsh_keperluan);
        $('#id_supplier_edit').val(data.header[0].s_id);
        //loop data
        Object.keys(data.data_isi).forEach(function(){
          var qtyCost = data.data_isi[key-1].d_pcshdt_qty;
          $('#tabel-edit-beli').append('<tr class="tbl_modal_edit_row">'
                            +'<td style="text-align:center">'+key+'</td>'
                            +'<td><input type="text" name="fieldIpBarangEdit[]" value="'+data.data_isi[key-1].i_name+'" id="field_ip_barang_edit" class="form-control input-sm" required readonly>'
                            +'<input type="hidden" name="fieldIpIdDetailEdit[]" value="'+data.data_isi[key-1].d_pcshdt_id+'" id="field_ip_detail_edit" class="form-control">'
                            +'<input type="hidden" name="fieldIpItemEdit[]" value="'+data.data_isi[key-1].d_pcshdt_item+'" id="field_ip_item_edit" class="form-control"></td>'
                            +'<td><input type="text" name="fieldIpQtyEdit[]" value="'+data.data_isi[key-1].d_pcshdt_qty+'" id="qty_'+i+'" data-qty="'+i+'" class="form-control field_qty input-sm" required></td>'
                            +'<td><input type="text" name="fieldIpSatTxtEdit[]" value="'+data.data_isi[key-1].m_sname+'" id="field_ip_sat_txt_edit" class="form-control input-sm" required readonly>'
                            +'<input type="hidden" name="fieldIpSatIdEdit[]" value="'+data.data_isi[key-1].m_sid+'" id="field_ip_sat_id_edit" class="form-control input-sm" required readonly></td>'
                            +'<td><input type="text" value="'+convertDecimalToRupiah(data.data_isi[key-1].d_pcshdt_price)+'" name="fieldIpHargaEdit[]" id="price_'+i+'" data-price="'+i+'" class="form-control input-sm field_harga numberinput"/></td>'
                            +'<td><input type="text" value="'+convertDecimalToRupiah(data.data_isi[key-1].d_pcshdt_pricetotal)+'" name="fieldIpHargaTotalEdit[]" class="form-control input-sm hargaTotalItem" id="total_'+i+'" readonly/></td>'
                            +'</tr>');
          i = randString(5);
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
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999, //jika form pd modal, jgn digunakan
      title: 'Update Belanja Harian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          var IsValid = $("form[name='formBelanjaEdit']").valid();
          if(IsValid)
          {
            $('#btn_update').text('Updating...');
            $('#btn_update').attr('disabled',true); 
            $.ajax({
              url : baseUrl + "/purchasing/belanjaharian/update-data-belanja",
              type: "post",
              dataType: "JSON",
              data: $('#form-belanja-edit').serialize(),
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
                      $('#data').DataTable().ajax.reload();
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
                      $('#data').DataTable().ajax.reload();
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
              message: "Mohon Lengkapi data form !"
            });
          } //end check valid
        }, true],
        ['<button>Tidak</button>', function (instance, toast) {
          instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        }],
      ]
    });
  }

  function deleteBeliHarian(idBeli) {
    iziToast.question({
      close: false,
      overlay: true,
      displayMode: 'once',
      //zindex: 999,
      title: 'Hapus data belanja harian',
      message: 'Apakah anda yakin ?',
      position: 'center',
      buttons: [
        ['<button><b>Ya</b></button>', function (instance, toast) {
          $.ajax({
            url : baseUrl + "/purchasing/belanjaharian/delete-data-belanja",
            type: "POST",
            dataType: "JSON",
            data: {idBeli:idBeli, "_token": "{{ csrf_token() }}"},
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
                    $('#data').DataTable().ajax.reload();
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
                    $('#data').DataTable().ajax.reload();
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

  function convertDecimalToRupiah(decimal) 
  {
    var angka = parseInt(decimal);
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00';
  }

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }

  function convertToRupiah(angka) 
  {
    var rupiah = '';        
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    return hasil+',00'; 
  }

  function convertToAngka(rupiah)
  {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
  }

  function convertDiscToAngka(disc) {
    return parseInt(disc.replace('%', ''), 10);
  }

  function totalPembelian(){
    var inputs = document.getElementsByClassName( 'hargaTotalItem' ),
    hasil  = [].map.call(inputs, function( input ) {
        if(input.value == '') input.value = 0;
        return input.value;
    });
    console.log(hasil);
    var total = 0;
    for (var i = hasil.length - 1; i >= 0; i--)
    {
      hasil[i] = convertToAngka(hasil[i]);
      hasil[i] = parseInt(hasil[i]);
      total = total + hasil[i];
    }
    if (isNaN(total)) 
    {
      total=0;
    }

    total = convertToRupiah(total);
    $('#total_biaya_edit').val(total);
  }

  function lihatBelanjaByTanggal()
  {
    var tgl1 = $('#tanggal1').val();
    var tgl2 = $('#tanggal2').val();
    $('#data').dataTable({
      "destroy": true,
      "processing" : true,
      "serverside" : true,
      "ajax" : {
        url: baseUrl + "/purchasing/belanjaharian/get-belanja-by-tgl/"+tgl1+"/"+tgl2,
        type: 'GET'
      },
      "columns" : [
        {"data" : "DT_Row_Index", orderable: true, searchable: false, "width" : "5%"}, //memanggil column row
        {"data" : "tglBeli", "width" : "10%"},
        {"data" : "m_name", "width" : "10%"},
        {"data" : "d_pcsh_code", "width" : "10%"},
        {"data" : "d_pcsh_peminta", "width" : "8%"},
        {"data" : "d_pcsh_keperluan", "width" : "10%"},
        {"data" : "hargaTotal", "width" : "10%"},
        {"data" : "status", "width" : "7%"},
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


    $.ajax({
        url: baseUrl + "/purchasing/belanjaharian/get-belanja-by-tgl-span/" + tgl1 + '/' + tgl2,
        type: 'get',
        success: function (response) {
            $('.waiting').html(response.waiting);
            $('.confirm').html(response.confirm);
            $('.dapat_edit').html(response.dapat_edit);
            $('.received').html(response.received);
            $('.revisi').html(response.revisi);
        }
    });


  }

  function refreshTabelBelanja() 
  {
    $('#data').DataTable().ajax.reload();
  }
</script>
@endsection()