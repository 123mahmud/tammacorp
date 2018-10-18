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
      <div class="page-title">Payroll Pegawai Manajemen</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Payroll Pegawai Manajemen</li>
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
              <a href="#index-tab" data-toggle="tab">Payroll Manajemen</a>
            </li>
          </ul>

          <div id="generalTabContent" class="tab-content responsive">
            <!-- /div alert-tab -->
            @include('hrd.payrollman.tab-index')
          </div>

        </div>
      </div>
    </div>
  </div> 
  @include('hrd.payrollman.modal')
  @include('hrd.payrollman.modal-detail')
</div>
@endsection 
@section("extra_scripts")
  <script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
  <script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
  <script type="text/javascript">
    var divisi = "";
    var jabatan = "";
    var pegawai = "";
    var tgl_i1 = "";
    $(document).ready(function () {
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

      $.fn.maskFunc = function(){
        $('.currency').inputmask("currency", {
          radixPoint: ",",
          groupSeparator: ".",
          digits: 2,
          autoGroup: true,
          prefix: '', //Space after $, this will not truncate the first character.
          rightAlign: false,
          oncleared: function () { self.Value(''); }
        });
      }
      $(this).maskFunc();

      var date = new Date();
      var newdate = new Date(date);
      newdate.setDate(newdate.getDate()-30);
      var nd = new Date(newdate);
      
      //datepicker
      $('.datepicker1').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy",
        endDate: 'today'
      }).datepicker("setDate", nd);
      tgl_i1 = $('.datepicker1').val();

      $('.datepicker2').datepicker({
        autoclose: true,
        format:"dd-mm-yyyy"
      }).datepicker("setDate", "0");
      //end datepicker
      
      // fungsi jika modal hidden
      $(".modal").on("hidden.bs.modal", function(){
        //remove append tr
        //$('tr').remove('.tbl_modal_detail_row');
        $('#d_appending div').remove();
        $('tr').remove('.tbl_modal_detail_row');
        //remove class all jquery validation error
        $('.form-group').find('.error').removeClass('error');
        $('.form-group').removeClass('has-valid has-error');
        //reset all input txt field
        $('#form-input-payroll')[0].reset();
        $('#i_tgl1').val(tgl_i1);
        //empty select2 field
        $('#i_divisi').empty();
        $('#i_jabatan').empty();
        $('#i_pegawai').empty();
        $('#btn_proses').attr('disabled', true);
      });

      //select2
      $('.select2').select2({});

      $(".i_divisi").select2({
          placeholder: "Pilih Divisi",
          ajax: {
            url: baseUrl + '/hrd/payrollman/lookup-data-divisi',
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

      $('.i_divisi').change(function() 
      {
        if($(this).val() != ""){
          $('.divDivisi').removeClass('has-error').addClass('has-valid');
          $('.i_jabatan').empty().attr('disabled', false);
          $('.i_pegawai').empty().attr('disabled', false);
        }else{
          $('.divDivisi').addClass('has-error').removeClass('has-valid');
          $('.i_jabatan').empty().attr('disabled', true);
          $('.i_pegawai').empty().attr('disabled', true);
        }
        $('#btn_proses').attr('disabled', true);
        divisi = $(this).val();

        $(".i_jabatan").select2({
          placeholder: "Pilih Jabatan",
          ajax: {
            url: baseUrl + '/hrd/payrollman/lookup-data-jabatan',
            dataType: 'json',
            data: function (params) {
              return {
                  q: $.trim(params.term),
                  divisi : divisi
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
      });

      $('.i_jabatan').change(function() 
      {
        if($(this).val() != ""){
          $('.divPegawai').removeClass('has-error').addClass('has-valid');
          $('.i_pegawai').empty().attr('disabled', false);
        }else{
          $('.divPegawai').addClass('has-error').removeClass('has-valid');
          $('.i_pegawai').empty().attr('disabled', true);
        }
        $('#btn_proses').attr('disabled', true);
        jabatan = $(this).val();

        $(".i_pegawai").select2({
          placeholder: "Pilih Pegawai",
          ajax: {
            url: baseUrl + '/hrd/payrollman/lookup-data-pegawai',
            dataType: 'json',
            data: function (params) {
              return {
                  q: $.trim(params.term),
                  divisi : divisi,
                  jabatan : jabatan
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
      });

      $('.i_pegawai').change(function() 
      {
        if($(this).val() != ""){
          $('#btn_proses').attr('disabled', false);
        }else{
          $('#btn_proses').attr('disabled', true);
        }
      });

      lihatPayrollByTgl();
    });//end jquery
  
    function lihatPayrollByTgl()
    {
      var tgl1 = $('#tgl_index1').val();
      var tgl2 = $('#tgl_index2').val();
      var divisi = $('#head_divisi').val();
      var status = $('#head_status').val();
      $('#tbl-index').dataTable({
        "destroy": true,
        "processing" : true,
        "serverside" : true,
        "ajax" : {
          url: baseUrl + "/hrd/payrollman/get-payroll-man",
          type: 'GET',
          data: {tgl1:tgl1, tgl2:tgl2, divisi:divisi, status:status}
        },
        "columns" : [
          {"data" : "d_pm_code", "width" : "10%"},
          {"data" : "tglBuat", "width" : "10%"},
          {"data" : "d_pm_periode", "width" : "18%"},
          {"data" : "c_nik", "width" : "10%"},
          {"data" : "c_nama", "width" : "17%"},
          {"data" : "totGaji", "width" : "15%"},
          {"data" : "tglCetak", "width" : "10%"},
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

    function setFieldModal()
    {
      pegawai = $('.i_pegawai').val();
      var sDate = $('#i_tgl1').val();
      var lDate = $('#i_tgl2').val();
      $.ajax({
        url : baseUrl + "/hrd/payrollman/set-field-modal",
        type: "GET",
        dataType: "JSON",
        data: {divisi:divisi, pegawai:pegawai, jabatan:jabatan, sDate:sDate, lDate:lDate},
        success: function(response)
        {
          $('#i_gapok').val(response.gapok);
          $('#i_tunjangan').val(response.total_tunjangan);
          $('#i_potongan').val(response.potongan);
          $('#i_totgaji').val(response.total_income);
          var i = randString(5);
          var key = 1;
          var key2 = 1;
          //loop data
          Object.keys(response.list).forEach(function()
          {
            $('#appending-modal').append(
              '<input type="hidden" id="index_tunjangan" name="index_tunjangan[]" class="form-control input-sm" value="'+response.list[key-1]+'">'
              +'<input type="hidden" id="nilai_tunjangan" name="nilai_tunjangan[]" class="form-control input-sm" value="'+response.nilai_tunjangan[key-1]+'">');
            i = randString(5);
            key++;
          });
          Object.keys(response.potonganTxt).forEach(function()
          {
            $('#appending-modal').append(
              '<input type="hidden" id="harian" name="harian[]" class="form-control input-sm" value="'+response.potonganTxt[key2-1].harian+'">'
              +'<input type="hidden" id="harianmakan" name="harianmakan[]" class="form-control input-sm" value="'+response.potonganTxt[key2-1].harianmakan+'">'
              +'<input type="hidden" id="harianmakantrans" name="harianmakantrans[]" class="form-control input-sm" value="'+response.potonganTxt[key2-1].harianmakantrans+'">');
            i = randString(5);
            key2++;
          });
        },
        error: function(){
          iziToast.warning({
            icon: 'fa fa-times',
            message: 'Terjadi Kesalahan!'
          });
        },
        async: false
      });
      $('#btn_simpan').attr('disabled', false);
      $('#btn_proses').attr('disabled', true);
    }

    function submitPayrollMan() 
    {
      iziToast.question({
        close: false,
        overlay: true,
        displayMode: 'once',
        //zindex: 999,
        title: 'Proses Payroll Pegawai',
        message: 'Apakah anda yakin ?',
        position: 'center',
        buttons: [
          ['<button><b>Ya</b></button>', function (instance, toast) {
            var IsValid = $("form[name='formInputPayroll']").valid();
            if(IsValid)
            {
              $('#btn_simpan').text('Saving...');
              $('#btn_simpan').attr('disabled',true);
              $.ajax({
                url : baseUrl + "/hrd/payrollman/simpan-data",
                type: "POST",
                dataType: "JSON",
                data: $('#form-input-payroll').serialize(),
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
                        $('#btn_simpan').text('Confirm'); //change button text
                        $('#btn_simpan').attr('disabled',false); //set button enable
                        $('#modal_tambah_data').modal('hide');
                        $('#tbl-index').DataTable().ajax.reload();
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
                        $('#btn_simpan').text('Update'); //change button text
                        $('#btn_simpan').attr('disabled',false); //set button enable
                        $('#modal_tambah_data').modal('hide');
                        $('#tbl-index').DataTable().ajax.reload();
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
                message: "Mohon Lengkapi data form !",
                onClosing: function(instance, toast, closedBy){
                  $('.divjenis').addClass('has-error');
                  $('.divDivisi').addClass('has-error');
                  $('.divJabatan').addClass('has-error');
                  $('.divPegawai').addClass('has-error');
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

    function detailPman(id) 
    {
      $.ajax({
        url : baseUrl + "/hrd/payrollman/get-detail/"+id,
        type: "GET",
        dataType: "JSON",
        success: function(response)
        {
          var date = response.payroll.d_pm_date;
          if(date != null) { var newKpixDate = date.split("-").reverse().join("-"); }
          
          $('#d_tanggal').text(newKpixDate);
          $('#periode').text(response.payroll.d_pm_periode);
          $('#d_divisi').text(response.payroll.c_divisi);
          $('#d_jabatan').text(response.payroll.c_posisi);
          $('#d_pegawai').text(response.payroll.c_nama);
          
          var i = randString(5);
          var key = 1;
          var key2 = 1;
          var totBobot = 0;
          var totScore = 0;
          //loop data
          Object.keys(response.list_tunjangan).forEach(function()
          {
            $('#d_appending').append(
                '<tr class="tbl_modal_detail_row">'
                  +'<td>'+key+'</td>'
                  +'<td>'+response.list_tunjangan[key-1].tman_nama+'</td>'
                  +'<td>'
                    +'<span style="float:left;">Rp. </span>'
                    +'<span style="float:right;">'
                      +convertDecimalToRupiah(response.list_tunjangan[key-1].d_pmdt_nilai)
                    +'</span>'
                  +'</td>'
                +'</tr>');
            i = randString(5);
            key++;
          });
          $('#d_appending').append(
                '<tr class="tbl_modal_detail_row">'
                  +'<td colspan="2" align="right"><strong>Total Tunjangan</strong></td>'
                  +'<td>'
                    +'<span style="float:left;"><strong>Rp. </strong></span>'
                    +'<span style="float:right;"><strong>'
                      +convertDecimalToRupiah(response.payroll.d_pm_totaltun)
                    +'</strong></span>'
                  +'</td>'
                +'</tr>');
          $('#d_appending').append(
                '<tr class="tbl_modal_detail_row">'
                  +'<td colspan="2" align="right"><strong>Gaji Pokok</strong></td>'
                  +'<td>'
                    +'<span style="float:left;"><strong>Rp. </strong></span>'
                    +'<span style="float:right;"><strong>'
                      +convertDecimalToRupiah(response.list_gaji.d_pmdt_nilai)
                    +'</strong></span>'
                  +'</td>'
                +'</tr>');
          Object.keys(response.list_potongan).forEach(function()
          {
            $('#d_appending').append(
                '<tr class="tbl_modal_detail_row">'
                  +'<td>'+key+'</td>'
                  +'<td>'+response.list_potongan[key2-1].d_pot_keterangan+'</td>'
                  +'<td>'
                    +'<span style="float:left;">Rp. </span>'
                    +'<span style="float:right;">'
                      +convertDecimalToRupiah(response.list_potongan[key2-1].d_pot_value)
                    +'</span>'
                  +'</td>'
                +'</tr>');
            i = randString(5);
            key++;
            key2++;
          });
          $('#d_appending').append(
                '<tr class="tbl_modal_detail_row">'
                  +'<td colspan="2" align="right"><strong>Total Potongan</strong></td>'
                  +'<td>'
                    +'<span style="float:left;"><strong>Rp. </strong></span>'
                    +'<span style="float:right;"><strong>'
                      +convertDecimalToRupiah(response.payroll.d_pm_totalpot)
                    +'</strong></span>'
                  +'</td>'
                +'</tr>');
          $('#d_appending').append(
                '<tr class="tbl_modal_detail_row">'
                  +'<td colspan="2" align="right"><strong>Total Gaji Nett</strong></td>'
                  +'<td>'
                    +'<span style="float:left;"><strong>Rp. </strong></span>'
                    +'<span style="float:right;"><strong>'
                      +convertDecimalToRupiah(response.payroll.d_pm_totalnett)
                    +'</strong></span>'
                  +'</td>'
                +'</tr>');
          $('#btn-modal').html('<a href="'+ baseUrl +'/hrd/payrollman/print-payroll/'+ id +'" target="_blank" class="btn btn-info">'+
            '<i class="fa fa-print"></i> Print'+
            '</a>'+
            '<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>');

          $('#modal_detail_data').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
      });
    }
    
    function hapusPman(id) 
    {
      iziToast.question({
        timeout: 20000,
        close: false,
        overlay: true,
        displayMode: 'once',
        title: 'Hapus Data',
        message: 'Apakah anda yakin ?',
        position: 'center',
        buttons: [
          ['<button><b>Ya</b></button>', function (instance, toast) {
            $.ajax({
              url : baseUrl + "/hrd/payrollman/delete-data",
              type: "POST",
              dataType: "JSON",
              data: {id:id, "_token": "{{ csrf_token() }}"},
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
                      $('#tbl-index').DataTable().ajax.reload();
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
                      $('#tbl-index').DataTable().ajax.reload();
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
      var hasil = rupiah.split('',rupiah.length-1).reverse().join('');
      return hasil+',00';
    }

    function convertIntToRupiah(angka) 
    {
      var rupiah = '';        
      var angkarev = angka.toString().split('').reverse().join('');
      for(var i = 0; i < angkarev.length; i++) 
        if(i%3 == 0) 
          rupiah += angkarev.substr(i,3)+'.';
      var hasil = 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
      return hasil+',00'; 
    }

    function refreshTabelIndex() 
    {
      $('#tbl-index').DataTable().ajax.reload();
    }

    function refreshTabelScore() 
    {
      $('#tbl-score').DataTable().ajax.reload();
    }
    
  </script> 
@endsection()