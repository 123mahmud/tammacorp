@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
        <div class="page-title">Form Master Data Suplier</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Master Data Suplier</li><li><i class="fa fa-angle-right"></i>&nbsp;Form Master Data Suplier&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
            <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Data Suplier</a></li>
            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
          </ul>
          
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">  
                  <div class="col-md-5 col-sm-6 col-xs-8" >
                    <h4>Form Master Data Suplier</h4>
                  </div>
                  
                  <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('master/datasuplier/suplier') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                  </div>
                </div>
                   
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <form id="form_suplier" method="POST">
                    {{ csrf_field() }}
                    <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-top:30px;padding-bottom:20px;">
                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <label class="tebal">Nama Supplier</label>
                      </div>

                      <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <div class="input-icon right">
                            <i class="fa fa-building"></i>
                            <input type="text" id="nama_sup" name="namaSup" class="form-control input-sm" >
                          </div>
                        </div>
                      </div>

                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <label class="tebal">Nama Pemilik</label>
                      </div>

                      <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <div class="input-icon right">
                            <i class="fa fa-user"></i>
                            <input type="text" id="owner" name="owner" class="form-control input-sm">
                          </div>
                        </div>
                      </div>
                             
                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <label class="tebal">No. Telp 1</label>
                      </div>

                      <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <div class="input-icon right">
                            <i class="glyphicon glyphicon-earphone"></i>
                            <input type="text" id="no_telp1" name="noTelp1" class="form-control input-sm">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <label class="tebal">No. Telp 2</label>
                      </div>

                      <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <div class="input-icon right">
                            <i class="glyphicon glyphicon-earphone"></i>
                            <input type="text" id="no_telp2" name="noTelp2" class="form-control input-sm">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <label class="tebal">NPWP</label>
                      </div>

                      <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <div class="input-icon right">
                            <div class="input-icon right">
                              <i class="fa fa-university"></i>
                              <input type="text" id="npwp_sup" name="npwpSup" class="form-control input-sm">
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-2 col-sm-3 col-xs-12"> 
                        <label class="tebal">Fax</label>
                      </div>

                      <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <div class="input-icon right">
                            <i class="fa fa-fax"></i>
                            <input type="text" id="fax" name="fax" class="form-control input-sm">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-2 col-sm-3 col-xs-12"> 
                        <label class="tebal">Bank</label>
                      </div>

                      <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <select class="form-control input-sm" name="methodBayar" id="method_bayar">
                              <option value="">Pilih Bank</option>
                              <option value="BCA">BCA</option>
                              <option value="MANDIRI">MANDIRI</option>
                              <option value="BNI">BNI</option>
                              <option value="BRI">BRI</option>
                              <option value="BUKOPIN">BUKOPIN</option>
                              <option value="DANAMON">DANAMON</option>
                              <option value="MEGA">MEGA</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-2 col-sm-3 col-xs-12"> 
                        <label class="tebal">Rekening</label>
                      </div>

                      <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="rekening" name="rekening" class="form-control input-sm" readonly>
                        </div>
                      </div>

                      <div class="col-md-2 col-sm-3 col-xs-12"> 
                        <label class="tebal">Batas TOP</label>
                      </div>

                      <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <div class="input-icon right">
                            <input type="number" id="tgl_top" name="tglTop" class="form-control input-sm">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-2 col-sm-3 col-xs-12"> 
                        <label class="tebal">Limit Hutang</label>
                      </div>

                      <div class="col-md-4 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <div class="input-icon right">
                            <i class="fa fa-usd"></i>
                            <input type="text" id="limit" name="limit" class="form-control input-sm currency text-right">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <label class="tebal">Alamat</label>
                      </div>

                      <div class="col-md-10 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <div class="input-icon right">
                            <i class="fa fa-home"></i>
                            <textarea id="alamat" name="alamat" class="form-control input-sm"></textarea>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-2 col-sm-3 col-xs-12">
                        <label class="tebal">Keterangan</label>
                      </div>

                      <div class="col-md-10 col-sm-9 col-xs-12">
                        <div class="form-group">
                          <div class="input-icon right">
                            <i class="fa fa-list"></i>
                            <textarea id="keterangan" name="keterangan" class="form-control input-sm" ></textarea>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div align="right">
                      <div class="form-group" align="right">
                        <button type="button" onclick="simpan()" class="btn btn-primary">Simpan Data</button>
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
  <!--END TITLE & BREADCRUMB PAGE-->
</div>
                            
@endsection
@section("extra_scripts")
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
<script type="text/javascript">     

  $(document).ready(function(){
    var extensions = {
        "sFilterInput": "form-control input-sm",
        "sLengthSelect": "form-control input-sm"
    }
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

    newdate.setDate(newdate.getDate()+7);
    var nd = new Date(newdate);

    $('.datepicker1').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy",
    }).datepicker("setDate", nd);

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

    $("#perusahaan").load("/master/datasuplier/tambah_suplier", function(){
      $("#perusahaan").focus();
    });

    $('#method_bayar').change(function(event) {
      if ($(this).val() != "") {
        $('#rekening').attr('readonly', false);
      }else{
        $('#rekening').attr('readonly', true);
      }
    });

  });// end jquery

  function simpan()
  {
    var namaSup  = $('input[name="namaSup"]');
    var owner = $('input[name="owner"]');
    var telp1 = $('input[name="noTelp1"]');
    var fax = $('input[name="fax"]');
    var keterangan = $('input[name="keterangan"]');
    var alamat = $('input[name="alamat"]');
    var bank = $('input[name="methodBayar"]');
    var rekening = $('input[name="rekening"]');
    
    if(namaSup.val()=='' || telp1.val()=='' || alamat.val()=='')
    {
      if(namaSup.val()==''){
        toastr["error"]("Supplier tidak boleh kosong", "Error");
        namaSup.addClass('state-error');
      } else {
        namaSup.removeClass('state-error');
      }

      if(telp1.val()==''){
        toastr["error"]("Nomor Telp ke-1 tidak boleh kosong", "Error");
        telp1.addClass('state-error');
      } else {
        telp1.removeClass('state-error');
      }

      return false;
    }

    if(bank.val() != '' && rekening.val() == '')
    {
      toastr["error"]("Rekening tidak boleh kosong", "Error");
      rekening.addClass('state-error');
      return false;
    }else {
      rekening.removeClass('state-error');
    }

    $.ajax({
       type: "POST",
       url: baseUrl + '/master/datasuplier/suplier_proses',
       data: $('#form_suplier').serialize(),
       success: function(response){
        if(response.status=='sukses')
        {
          toastr["success"]("Suplier Berhasil ditambahkan", "Sukses");
          window.location = ('{{route("suplier")}}');
        }
       },
       error: function(){
        toastr["error"]("Terjadi Kesalahan", "Error");
       },
       // async: false
     });
  }

</script>
@endsection                            
