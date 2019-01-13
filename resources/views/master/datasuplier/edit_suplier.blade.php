@extends('main')
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Edit Master Data Suplier</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;Master&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Master Data Suplier</li><li><i class="fa fa-angle-right"></i>&nbsp;Edit Master Data Suplier&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
                <li class="active"><a href="#alert-tab" data-toggle="tab">Edit Master Data Suplier</a></li>
                <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
              </ul>
              <div id="generalTabContent" class="tab-content responsive">
                <div id="alert-tab" class="tab-pane fade in active">
                  <div class="row">
                
                    <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: -10px;margin-bottom: 15px;">  
                       <div class="col-md-5 col-sm-6 col-xs-8" >
                         <h4>Edit Master Data Suplier</h4>
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
                                <input type="text" id="perusahaan" name="perusahaan" class="form-control input-sm" value="{{$edit_suplier->s_company}}">
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
                                <input type="text" id="nama" name="nama" class="form-control input-sm" value="{{$edit_suplier->s_name}}">        
                              </div>
                            </div>
                          </div>
                         
                          <div class="col-md-2 col-sm-3 col-xs-12">
                            
                                <label class="tebal">no. Telp 1</label>
                            
                          </div>

                          <div class="col-md-4 col-sm-9 col-xs-12">
                            <div class="form-group">
                              <div class="input-icon right">
                                  <i class="glyphicon glyphicon-earphone"></i>
                                  <input type="text" id="no_hp1" name="noHp1" class="form-control input-sm" value="{{$edit_suplier->s_phone1}}">
                              </div>
                            </div>
                          </div>

                           <div class="col-md-2 col-sm-3 col-xs-12">
                            
                                <label class="tebal">no. Telp 2</label>
                            
                          </div>

                          <div class="col-md-4 col-sm-9 col-xs-12">
                            <div class="form-group">
                              <div class="input-icon right">
                                  <i class="glyphicon glyphicon-earphone"></i>
                                  <input type="text" id="no_hp2" name="noHp2" class="form-control input-sm" value="{{$edit_suplier->s_phone2}}">
                              </div>
                            </div>
                          </div>

                          <div class="col-md-2 col-sm-3 col-xs-12">
                            <label class="tebal">NPWP</label>
                          </div>

                          <div class="col-md-4 col-sm-9 col-xs-12">
                            <div class="form-group">
                              <div class="input-icon right">
                                <i class="fa fa-university"></i>
                                <input type="text" id="npwp_sup" name="npwpSup" class="form-control input-sm" value="{{$edit_suplier->s_npwp}}">
                              </div>
                            </div>
                          </div>

                          <div class="col-md-2 col-sm-3 col-xs-12">
                                <label class="tebal">Fax</label>
                          </div>

                          <div class="col-md-4 col-sm-9 col-xs-12">
                            <div class="form-group">
                              <div class="input-icon right">
                                <i class="glyphicon glyphicon-envelope"></i>
                                <input type="text" id="email" name="email" class="form-control input-sm" value="{{$edit_suplier->s_fax}}">                
                              </div>
                            </div>
                          </div>

                        <div class="col-md-2 col-sm-3 col-xs-12"> 
                          <label class="tebal">Bank</label>
                        </div>

                        <div class="col-md-4 col-sm-9 col-xs-12">
                          <div class="form-group">
                            <select class="form-control input-sm" name="methodBayar" id="method_bayar">
                              <option @if ($edit_suplier->s_bank == '') selected="" @endif value="">Pilih Bank</option>
                              <option @if ($edit_suplier->s_bank == 'BCA') selected="" @endif value="BCA">BCA</option>
                              <option @if ($edit_suplier->s_bank == 'MANDIRI') selected="" @endif value="MANDIRI">MANDIRI</option>
                              <option @if ($edit_suplier->s_bank == 'BNI') selected="" @endif value="BNI">BNI</option>
                              <option @if ($edit_suplier->s_bank == 'BRI') selected="" @endif value="BRI">BRI</option>
                              <option @if ($edit_suplier->s_bank == 'BUKOPIN') selected="" @endif value="BUKOPIN">BUKOPIN</option>
                              <option @if ($edit_suplier->s_bank == 'DANAMON') selected="" @endif value="DANAMON">DANAMON</option>
                              <option @if ($edit_suplier->s_bank == 'MEGA') selected="" @endif value="MEGA">MEGA</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-2 col-sm-3 col-xs-12"> 
                          <label class="tebal">Rekening</label>
                        </div>

                        <div class="col-md-4 col-sm-9 col-xs-12">
                          <div class="form-group">
                            <input type="text" id="rekening" name="rekening" class="form-control input-sm" readonly value="{{$edit_suplier->s_rekening}}">
                          </div>
                        </div>

                          <div class="col-md-2 col-sm-3 col-xs-12">
                            <label class="tebal">Alamat</label>
                          </div>

                          <div class="col-md-10 col-sm-9 col-xs-12">
                            <div class="form-group">
                              <div class="input-icon right">
                                <i class="fa fa-home"></i>
                                <textarea id="alamat" name="alamat" class="form-control input-sm">{{$edit_suplier->s_address}}</textarea>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-2 col-sm-3 col-xs-12"> 
                            <label class="tebal">Tanggal TOP</label>
                          </div>

                          <div class="col-md-4 col-sm-9 col-xs-12">
                            <div class="form-group">
                              <div class="input-icon right">
                                <i class="fa fa-calendar"></i>
                                <input type="number" id="tgl_top" name="tglTop" class="form-control input-sm " value="{{$edit_suplier->s_top}}">
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
                                <input type="text" id="limit" name="limit" class="form-control input-sm currency" value="{{$edit_suplier->s_limit}}">
                              </div>
                            </div>
                          </div>

                          <div class="col-md-2 col-sm-3 col-xs-12">
                            
                                <label class="tebal">Keterangan</label>
                            
                          </div>

                          <div class="col-md-10 col-sm-9 col-xs-12">
                            <div class="form-group">
                              <div class="input-icon right">
                                <i class="fa fa-home"></i>
                                <textarea id="keterangan" name="keterangan" class="form-control input-sm" >{{$edit_suplier->s_note}}</textarea>
                              </div>
                            </div>
                          </div>

                          
                          <input type="hidden" value="{{$edit_suplier->s_id}}" name="s_idx">
                        </div>

                        <div align="right">
                          <div class="form-group" align="right">
                            <button type="button" onclick="edit()" class="btn btn-primary">Update Data</button>
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
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
<script>
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

    newdate.setDate(newdate.getDate()-30);
    var nd = new Date(newdate);

    $('.datepicker1').datepicker({
      autoclose: true,
      format:"dd-mm-yyyy"
    });

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

    $('#method_bayar').change(function(event) {
      if ($(this).val() != "") {
        $('#rekening').attr('readonly', false).val("");
      }else{
        $('#rekening').attr('readonly', true).val("");
      }
    });
  });
  
  function edit()
  {
    var perusahaan  = $('input[name="perusahaan"]');
    var no_hp1 = $('input[name="no_hp1"]');
    var alamat = $('input[name="alamat"]');
    var bank = $('input[name="methodBayar"]');
    var rekening = $('input[name="rekening"]');

    if(perusahaan.val()=='' || no_hp1.val()=='' || alamat.val()=='')
    {
      if(perusahaan.val()=='') {
        toastr["error"]("Perusahan tidak boleh kosong", "Error");
        perusahaan.addClass('state-error');
      } else {
        perusahaan.removeClass('state-error');
      }

      if(no_hp1.val()==''){
        toastr["error"]("Nomor HP tidak boleh kosong", "Error");
        no_hp1.addClass('state-error');
      } else {
        no_hp1.removeClass('state-error');
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

    var form = $('#form_suplier').serialize();
    $.ajax({
           type: "POST",
           url: baseUrl + '/master/datasuplier/suplier_edit_proses/{{$edit_suplier->s_id}}',
           data: form,
          success: function(a){
          if(a.status=="sukses")
          {
            toastr["success"]("Suplier Berhasil diupdate", "Sukses");
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