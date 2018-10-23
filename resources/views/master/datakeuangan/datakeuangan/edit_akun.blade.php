@extends('main')

@section('extra_styles')
    <link type="text/css" rel="stylesheet" href="{{ asset('js/chosen/chosen.css') }}">

    <style>
      .mb-3{
        margin-bottom: 15px;
      }
    </style>
@endsection

@section('content')
            <!--BEGIN PAGE WRAPPER-->
              <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Form Master Data Akun Keuangan</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li> &nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Master Data Akun Keuangan</li>
                        <li><i class="fa fa-angle-right"></i>&nbsp;Form Master Data Akun Keuangan&nbsp;&nbsp;&nbsp;&nbsp;</li>
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
                            <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Data Akun Keuangan</a></li>
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                          </ul>

                          <div id="generalTabContent" class="tab-content responsive">
                            <div id="alert-tab" class="tab-pane fade in active">
                              <div class="row">
                                <div class="col-md-12" style="margin-top: -10px;margin-bottom: 20px;">
                                   <div class="col-md-5 col-sm-6 col-xs-8">
                                     <h4>Form Master Data Akun Keuangan</h4>
                                   </div>
                                   <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                                     <a href="{{ url('master/datakeuangan/keuangan') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                                   </div>
                                </div>

                                <hr>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <form id="form_cust">
                                      <input type="hidden" value="{{csrf_token()}}" name="_token" readonly>
                                      <input type="hidden" value="{{$akun->id_akun}}" name="id_akun" readonly>
                                      <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">
                                        
                                        <div class="col-md-2 col-sm-3 col-xs-12 mb-3"> 
                                          <label class="tebal type_akun">Type Akun</label>
                                        </div>
                                        <div class="col-md-10 col-sm-9 col-xs-12 mb-3">
                                          <input type="text" class="form-control form_validate" placeholder="Inputkan Nomor Akun" aria-describedby="basic-addon1" name="type_akun" disabled value="{{ $akun->type_akun }}">
                                        </div>

                                        <div class="col-md-2 col-sm-3 col-xs-12 mb-3"> 
                                          <label class="tebal">Kelompok Akun</label>
                                        </div>
                                        <div class="col-md-4 col-sm-9 col-xs-12 mb-3">
                                          <input type="text" class="form-control form_validate" placeholder="Inputkan Nomor Akun" aria-describedby="basic-addon1" name="Kelompok_akun" disabled value="{{ $akun->kelompok_akun }}">
                                        </div>

                                        <div class="col-md-2 col-sm-3 col-xs-12 mb-3"> 
                                          <label class="tebal">Nomor Akun</label>
                                        </div>
                                        <div class="col-md-4 col-sm-9 col-xs-12 mb-3">
                                            <input type="text" class="form-control form_validate" placeholder="Inputkan Nomor Akun" aria-describedby="basic-addon1" name="nomor_akun" disabled value="{{ $akun->id_akun }}">
                                        </div>

                                        <div class="col-md-2 col-sm-3 col-xs-12 mb-3"> 
                                          <label class="tebal">Nama Akun</label>
                                        </div>
                                        <div class="col-md-4 col-sm-9 col-xs-12 mb-3">
                                          <input type="text" class="form-control form_validate" placeholder="Inputkan Nama Akun" aria-describedby="basic-addon1" name="nama_akun" value="{{ $akun->nama_akun }}">
                                        </div>

                                        <div class="col-md-2 col-sm-3 col-xs-12 mb-3"> 
                                          <label class="tebal">Posisi Debet/Kredit</label>
                                        </div>
                                        <div class="col-md-4 col-sm-9 col-xs-12 mb-3">
                                          <select class="form-control" name="posisi_akun" id="posisi_akun">
                                            <option value="D">DEBET</option>
                                            <option value="K">KREDIT</option>
                                          </select>
                                        </div>

                                        <div id="add_detail">
                                          <div class="col-md-2 col-sm-3 col-xs-12 mb-3"> 
                                            <label class="tebal">Group Neraca</label>
                                          </div>
                                          <div class="col-md-4 col-sm-9 col-xs-12 mb-3">
                                           <select name="group_neraca_detail" id="group_neraca_detail" class="form-control select-2"></select>
                                          </div>

                                          <div class="col-md-2 col-sm-3 col-xs-12 mb-3"> 
                                            <label class="tebal">Group Laba Rugi</label>
                                          </div>
                                          <div class="col-md-4 col-sm-9 col-xs-12 mb-3">
                                            <select name="group_laba_rugi_detail" id="group_laba_rugi_detail" class="form-control select-2"></select>
                                          </div>

                                          {{-- <div class="col-md-2 col-sm-3 col-xs-12 mb-3"> 
                                            <label class="tebal">Saldo Bulan Ini</label>
                                          </div>
                                          <div class="col-md-4 col-sm-9 col-xs-12 mb-3">
                                            <input type="text" class="form-control currency text-right" name="saldo_bulan_ini" id="saldo_bulan_ini" placeholder="Masukkan Saldo Bulan Ini" value="{{ $akun->saldo }}">
                                          </div> --}}
                                        </div>

                                      </div>

                                      <div align="right">
                                        <div class="form-group">
                                          <button type="button" name="tambah_data" class="btn btn-primary" id="simpan">Simpan Data</button>
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

@section("extra_scripts")

  <script src="{{ asset("js/chosen/chosen.jquery.js") }}"></script>
  <script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>

  <script type="text/javascript">     
    
    $(document).ready(function(){

      dataGroupNeraca = {!! $datagroupneraca !!}; dataGroupLabaRugi = {!! $datagrouplabarugi !!};

      generate_neraca_akun();
      generate_laba_rugi_akun();
      $('.select-2').select2();
      $('#posisi_akun').val('{{$akun->posisi_akun}}');

      $('.currency').inputmask("currency", {
          radixPoint: ",",
          groupSeparator: ".",
          digits: 2,
          autoGroup: true,
          prefix: '', //Space after $, this will not truncate the first character.
          rightAlign: false,
          oncleared: function () { self.Value(''); }
      });

      $('#simpan').click(function(event){
        event.preventDefault();

          btn = $(this);
          btn.attr("disabled", "disabled");
          btn.text("Menyimpan...");

          if(validate_form()){
            $.ajax(baseUrl+"/master/datakeuangan/update",{
              type: "post",
              timeout: 15000,
              data: $("#form_cust").serialize(),
              dataType: 'json',
              success: function(response){
                console.log(response);

                btn.removeAttr("disabled");
                btn.text("Simpan");

                if(response.status == "sukses"){
                  toastr.success('Data Master Akun Berhasil Diperbarui');
                  btn.removeAttr("disabled");
                  btn.text("Simpan");

                  // form_reset();
                }else if(response.status == "exist_id"){
                  toastr.error('Kode Akun Sudah Ada Dengan Nama '+response.content+'. Silahkan Membuat Kode Akun Lagi.');
                  btn.removeAttr("disabled");
                  btn.text("Simpan");
                }else if(response.status == "exist_group_neraca"){
                  toastr.error('Kode Group Neraca Akun Sudah Ada Dengan Nama '+response.content+'. Silahkan Membuat Kode Group Neraca Akun Lagi.');
                  btn.removeAttr("disabled");
                  btn.text("Simpan");
                }else if(response.status == "exist_group_laba_rugi"){
                  toastr.error('Kode Group Neraca Akun Sudah Ada Dengan Nama '+response.content+'. Silahkan Membuat Kode Group Neraca Akun Lagi.');
                  btn.removeAttr("disabled");
                  btn.text("Simpan");
                }
              },
              error: function(request, status, err) {
                if (status == "timeout") {
                  toastr.error('Request Timeout. Data Gagal Disimpan');
                  btn.removeAttr("disabled");
                  btn.text("Simpan");
                } else {
                  toastr.error('Internal Server Error. Data Gagal Disimpan');
                  btn.removeAttr("disabled");
                  btn.text("Simpan");
                }
                btn.removeAttr("disabled");
              }
            })
          }else{
            btn.removeAttr("disabled");
            btn.text("Simpan");
          }

          return false;
      })

      function generate_neraca_akun(identity){
        html = '<option value="-">Tidak Memiliki Grup Neraca</option>';

        $.each(dataGroupNeraca, function(i, n){
            selected = (n.value == '{{$akun->group_neraca}}') ? 'selected' : '';
            html = html +'<option value="'+n.value+'" '+selected+'>'+n.value+' / '+n.text+'</option>';
          })

        $("#group_neraca_detail").html(html);
        
      }

      function generate_laba_rugi_akun(identity){
        html = '<option value="-">Tidak Memiliki Grup Laba Rugi</option>';

        $.each(dataGroupLabaRugi, function(i, n){
            selected = (n.value == '{{$akun->group_laba_rugi}}') ? 'selected' : '';
            html = html +'<option value="'+n.value+'" '+selected+'>'+n.value+' / '+n.text+'</option>';
          })

        $("#group_laba_rugi_detail").html(html);
        
      }

      function validate_form(){
        a = true;

        $(".form_validate").each(function(i, e){
          if($(this).val() == "" && $(this).is(':visible')){
            a = false;
            $(this).focus();
            toastr.warning('Tidak Boleh Ada Data Yang Kosong');
            return false;
          }
        })

        // $(".select_validate").each(function(i, e){
        //   if($(this).val() == "---"){
        //     a = false;
        //     $(this).focus();
        //     toastr.warning('Harap Lengkapi Data Diatas');
        //     return false;
        //   }
        // })

        // if($("#saldo").is(":checked") && $("#DEBET").val() == '0,00' && $("#KREDIT").val() == '0,00'){
        //   a = false;
        //   $("#saldo_debet").focus()
        //   toastr.warning('Jika Akun Ini Memiliki Saldo Maka Saldo Tidak Boleh 0.');
        // }

        // if($("#saldo").is(":checked")){
        //   alert($("#DEBET").val());
        // }

        return a;
      }
    })

  </script>
@endsection                            
