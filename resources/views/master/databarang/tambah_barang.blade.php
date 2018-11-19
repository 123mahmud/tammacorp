@extends('main')
@section('content')
<!-- style for jquery validation error -->
<style>
  .error {
    border: 1px solid #f00;
  }

  .valid {
      border: 1px solid #8080ff;
  }
</style>
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Form Master Data Barang</div>
    </div>

    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Master Data Barang</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Master Data Barang&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
            <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Data Barang</a></li>
          </ul>

          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px;margin-bottom: 15px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Form Master Data Barang</h4>
                  </div>
                  <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('master/databarang/barang') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                  </div>
                </div>
            
                <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top:15px;">
                  <form method="POST" id="form-save" name="formTambahBarang">
                    {{ csrf_field() }}
                    <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:15px;padding-left:-10px;padding-right: -10px; ">
                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Nama <span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="nama" name="nama" class="form-control input-sm">
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-12 col-xs-12">
                        <label class="tebal">Type Barang <span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-9 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <select class="form-control" name="type" id="type">
                             <option selected value="">- Pilih Dahulu -</option>
                             <option value="BB">BAHAN BAKU</option>
                             <option value="BJ">BARANG JUAL</option>
                           </select>                               
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Kelompok <span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select class="input-sm form-control" name="code_group" id="code_group"> 
                            <option selected value="">- Pilih -</option>
                              @foreach ($group as $g)
                                <option value="{{ $g->m_gcode }}" data-val="{{ $g->m_gname }}" >{{ $g->m_gcode }} - {{ $g->m_gname }}</option>
                              @endforeach
                            </select>
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Kode Barang <span style="color: red">*</span></label>
                      </div>
                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="kode_barang" name="kode_barang" placeholder="PILIH GROUP DAHULU" readonly="" class="form-control input-sm">                                  
                        </div>
                      </div>

                      <input type="hidden" name="group" id="group">                              
                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Min Stock</label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="min_stock" name="min_stock" class="form-control input-sm">
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Satuan Utama <span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select class="input-sm form-control" name="satuan1">
                            <option value="">- Pilih -</option>
                            @foreach ($satuan as $element)
                            <option value="{{ $element->m_sid }}">{{ $element->m_scode }} - {{ $element->m_sname }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                  
                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Isi Sat Utama <span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="isi_sat1" name="isi_sat1" class="form-control input-sm" readonly value="1">                               
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Satuan Alternatif 1 <span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select class="input-sm form-control" name="satuan2">
                            <option value="">- Pilih -</option>
                            @foreach ($satuan as $element)
                              <option value="{{ $element->m_sid }}">{{ $element->m_scode }} - {{ $element->m_sname }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                  
                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Isi Sat Alternatif 1 <span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="isi_sat2" name="isi_sat2" class="form-control input-sm" placeholder="Qty terhadap satuan utama">
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Satuan Alternatif 2 <span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select class="input-sm form-control" name="satuan3">
                            <option value="">- Pilih -</option>
                            @foreach ($satuan as $element)
                              <option value="{{ $element->m_sid }}">{{ $element->m_scode }} - {{ $element->m_sname }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                  
                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Isi Sat Alternatif 2 <span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="isi_sat3" name="isi_sat3" class="form-control input-sm" placeholder="Qty terhadap satuan utama">                               
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Harga Per Satuan <span style="color: red">*</span></label>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <label class="tebal">Harga Satuan Utama</label>
                          <input type="text" id="harga_beli1" name="hargaBeli1" class="form-control input-sm currency" readonly>
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <label class="tebal">Harga Satuan Alternatif 1</label>
                          <input type="text" id="harga_beli2" name="hargaBeli2" class="form-control input-sm currency" readonly>
                        </div>
                      </div>

                      <div class="col-md-3 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <label class="tebal">Harga Satuan Alternatif 2</label>
                          <input type="text" id="harga_beli3" name="hargaBeli3" class="form-control input-sm currency" readonly>
                        </div>
                      </div>

                      <div class="col-xs-12">
                        <label class="tebal"></label>
                      </div>
                  
                      <div class="col-md-3 col-sm-4 col-xs-12">
                        <label class="tebal">Detail</label>
                      </div>

                      <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <textarea class="form-control input-sm" name="detail"></textarea>                               
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12 col-sm-4 col-xs-12">
                      <label class="tebal" style="color: red">Keterangan : * Wajib diisi.</label>
                    </div>
          
                    <div align="right" id="change_function">
                      <input type="button" name="tambah_data" value="Simpan Data" id="save_data" class="btn btn-primary">
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
<!--END PAGE WRAPPER-->
</div>                         
@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
<script type="text/javascript">     

  $( document ).ready(function() {
    //mask money
    $.fn.maskFunc = function(){
      $('.currency').inputmask("currency", {
        radixPoint: ".",
        groupSeparator: ".",
        digits: 2,
        autoGroup: true,
        prefix: '', //Space after $, this will not truncate the first character.
        rightAlign: false,
        oncleared: function () { self.Value(''); }
      });
    }

    $(this).maskFunc();

    $('#code_group').change(function(){
      var id = $(this).val();
      var bid = $('#code_group').find(':selected').data('val');
      console.log(id);
      $.ajax({
         type: "get",
         url: '{{ route('kode_barang') }}',
         data: {id},
         success: function(data){
          $('#kode_barang').val(data);
         
         },
         error: function(){
        
         },
         async: false
      });
    });

    //event focus on isi_sat2
    $(document).on('focus', '#isi_sat2',  function(e){
      $('#harga_beli1').val('');
      $('#harga_beli2').val('');
      $('#harga_beli3').val('');
    });

    //event focus on isi_sat3
    $(document).on('focus', '#isi_sat3',  function(e){
      $('#harga_beli1').val('');
      $('#harga_beli2').val('');
      $('#harga_beli3').val('');
    });

    //event focus on harga_beli1
    $(document).on('focus', '#harga_beli1',  function(e){
      $(this).attr('readonly', false).val(0);
      $('#harga_beli2').attr('readonly', true).val(0);
      $('#harga_beli3').attr('readonly', true).val(0);
    });

    //event focus on harga_beli2
    $(document).on('focus', '#harga_beli2',  function(e){
      $(this).attr('readonly', false).val(0);
      $('#harga_beli1').attr('readonly', true).val(0);
      $('#harga_beli3').attr('readonly', true).val(0);
    });

    //event focus on harga_beli3
    $(document).on('focus', '#harga_beli3',  function(e){
      $(this).attr('readonly', false).val(0);
      $('#harga_beli1').attr('readonly', true).val(0);
      $('#harga_beli2').attr('readonly', true).val(0);
    });

    //event onblur harga beli1
    $(document).on('blur', '#harga_beli1',  function(e){
      var harga1 = $(this).val();
      harga1 = harga1.replace(/,/g, "");
      //console.log(parseFloat(harga1));
      var isi2 = $('#isi_sat2').val();
      var isi3 = $('#isi_sat3').val();
      var harga2 = parseFloat(harga1 * isi2);
      var harga3 = parseFloat(harga1 * isi3);
      $('#harga_beli2').val(harga2);
      $('#harga_beli3').val(harga3);
    });

    //event onblur harga beli2
    $(document).on('blur', '#harga_beli2',  function(e){
      //cari harga sat 1
      var harga2 = $(this).val();
      harga2 = harga2.replace(/,/g, "");
      var isi2 = $('#isi_sat2').val();
      var isi3 = $('#isi_sat3').val();
      var harga1 = parseFloat(harga2 / isi2);
      //cari harga sat 3
      var harga3 = parseFloat(harga1 * isi3);
      $('#harga_beli1').val(harga1);
      $('#harga_beli3').val(harga3);
    });

    //event onblur harga beli3
    $(document).on('blur', '#harga_beli3',  function(e){
      //cari harga sat 1
      var harga3 = $(this).val();
      harga3 = harga3.replace(/,/g, "");
      var isi2 = $('#isi_sat2').val();
      var isi3 = $('#isi_sat3').val();
      var harga1 = parseFloat(harga3 / isi3);
      //cari harga sat 2
      var harga2 = parseFloat(harga1 * isi2);
      $('#harga_beli1').val(harga1);
      $('#harga_beli2').val(harga2);
    });

    $("#nama").load("/master/databarang/tambah_barang", function(){
        $("#nama").focus();
    });


    $('#change_function').on("click", "#save_data",function(){
      var IsValid = $("form[name='formTambahBarang']").valid();
      alert(IsValid);
      if(IsValid){
        $.ajax({
          type: "POST",
          url: '{{ route('simpan_barang') }}',
          data: $('#form-save').serialize(),
          success: function(response)
          {
            if(response.status == "sukses")
            {
              iziToast.success({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: response.pesan,
                onClosing: function(instance, toast, closedBy){
                   window.location=('{{ route('barang') }}');
                }
              });
            }
            else
            {
              iziToast.error({
                position: 'center', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                title: 'Pemberitahuan',
                message: "Data Gagal disimpan !",
                onClosing: function(instance, toast, closedBy){
                   // window.location=('{{ route('barang') }}');
                }
              });
            }              
          },
          error: function()
          {
            iziToast.error({
              position: 'topRight', //center, bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
              title: 'Pemberitahuan',
              message: "Data gagal disimpan !"
            });
          },
          async: false
        });
      }
      else //else validation
      {
        iziToast.warning({
          //icon: 'fa fa-microphone',
          position: 'center',
          message: "Mohon Lengkapi data form !"
        });
      }
    });

    $('#type').change(function(){
      var id = $(this).val();
      $.ajax({
        type: "get",
        url: '{{ route('cari_group_barang') }}',
        data: {id},
        success: function(data){
          console.log(data);
          var array_change = '<option selected >- Pilih -</option>';
          $.each(data, function(i, item) {
            array_change += '<option value="'+data[i].m_gcode+'" data-val="'+data[i].m_gname+'" >'+data[i].m_gcode+' - '+data[i].m_gname+'</option>';
          });
          $('#code_group').html(array_change);
        },
        error: function(){
        },
       async: false
      });
    });

    //validasi
    $("#form-save").validate({
      // Specify validation rules
      rules:{
          nama: "required",
          type: "required",
          code_group: "required",
          min_stock: "required",
          satuan1: "required",
          isi_sat1: "required",
          satuan2: "required",
          isi_sat2: "required",
          satuan3: "required",
          isi_sat3: "required",
          hargaBeli1: "required",
          hargaBeli2: "required",
          hargaBeli3: "required"
      },
      errorPlacement: function() {
          return false;
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

  }); //end jquery

  function convertToAngka(rupiah)
  {
    return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
  }

</script>
@endsection