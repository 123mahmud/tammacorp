@extends('main') @section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Form Master Data Pegawai</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;Master&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Master Data Pegawai</li>
      <li>
        <i class="fa fa-angle-right"></i>&nbsp;Form Master Data Pegawai&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
              <a href="#alert-tab" data-toggle="tab">Form Master Data Pegawai</a>
            </li>
            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px;margin-bottom: 15px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Form Master Data Pegawai</h4>
                  </div>
                  <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('master/datapegawai/pegawai') }}" class="btn">
                      <i class="fa fa-arrow-left"></i>
                    </a>
                  </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top:15px;">
                  <form method="POST" id="simpanPegawai">
                    <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:15px;padding-left:-10px;padding-right: -10px; ">
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">ID Pegawai<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input disabled="" type="text" name="" value="{{$id_pegawai}}" class="form-control input-sm">
                          <input type="hidden" name="c_code" value="{{$id_pegawai}}" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Tanggal Masuk</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="tgl_masuk" name="c_tahun_masuk" data-date-format="dd-mm-yyyy" class="datepicker form-control input-sm"
                            placeholder="dd-mm-yyyy">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Divisi<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select id="divisi" name="c_divisi_id" class="form-control input-sm">
                            <option>--pilih jabatan--</option>
                            <?php foreach($divisi as $div){ ?>
                              <option value="{{ $div->c_id }}">{{ $div->c_divisi }}</option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Jabatan<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select id="jabatan" name="c_jabatan_id" class="form-control input-sm">
                            <option>--pilih jabatan--</option>
                            <option value=""></option>
                          </select>
                        </div>
                      </div>
                     <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Hari Kerja</label>
                      </div>
                      <div class="col-md-2 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select id="" name="c_hari_awal" class="form-control input-sm">
                              <option value="Senin">Senin</option>
                              <option value="Selasa">Selasa</option>
                              <option value="Rabu">Rabu</option>
                              <option value="Kamis">Kamis</option>
                              <option value="Jumat">Jumat</option>
                              <option value="Sabtu">Sabtu</option>
                              <option value="Minggu">Minggu</option>
                            </select>
                        </div>
                      </div>
                       <div class="col-md-2 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select id="" name="c_hari_akhir" class="form-control input-sm">
                              <option value="Senin">Senin</option>
                              <option value="Selasa">Selasa</option>
                              <option value="Rabu">Rabu</option>
                              <option value="Kamis">Kamis</option>
                              <option value="Jumat">Jumat</option>
                              <option value="Sabtu">Sabtu</option>
                              <option value="Minggu">Minggu</option>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Shift<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select id="" name="c_shift_id" class="form-control input-sm">
                            <option>--pilih shift--</option>
                            <?php foreach($shift as $s){ ?>
                            <option value="{{ $s->c_id }}">{{ $s->c_name}}</option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Nama Pegawai<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_nama" id="c_nama" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">KTP<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_ktp" id="c_ktp" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Alamat KTP<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_ktp_alamat" id="c_ktp_alamat" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">domisili sekarang<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_alamat" id="c_alamat" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Tempat, tanggal lahir</label>
                      </div>
                      <div class="col-md-2 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_tempat" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="tgl_lahir" name="c_tanggal" data-date-format="dd-mm-yyyy" class="datepicker form-control input-sm"
                            placeholder="dd-mm-yyyy">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">pendidikan<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select id="" name="c_pendidikan" class="form-control input-sm">
                            <option>--pilih pendidikan--</option>
                            <option value="S2">S2</option>
                            <option value="S1">S1</option>
                            <option value="D3">D3</option>
                            <option value="D2">D2</option>
                            <option value="D1">D1</option>
                            <option value="SMA">SMA</option>
                            <option value="SMP">SMP</option>
                            <option value="SD">SD</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">email<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_email" id="c_name" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">no. handphone<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_hp" id="c_name" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Agama<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select id="" name="c_agama" class="form-control input-sm">
                            <option>--pilih agama--</option>
                            <option value="islam">Islam</option>
                            <option value="kristen">Kristen</option>
                            <option value="katolik">Katolik</option>
                            <option value="hindu">Hindu</option>
                            <option value="budha">Budha</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Status pernikahan</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select id="" name="c_nikah" class="form-control input-sm">
                            <option>--pilih status pernikahan--</option>
                            <option value="menikah">Menikah</option>
                            <option value="belum menikah">Belum menikah</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">nama suami/istri</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_pasangan" id="c_name" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">anak</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="number" name="c_anak" id="c_name" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">bank</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_bank" id="c_name" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">no. rekening</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_rekening" id="c_name" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Sertifikasi keahlian</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_sertification" id="c_name" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">tahun</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_sertif_tahun" id="c_name" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">tempat</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_sertif_tempat" id="c_name" class="form-control input-sm">
                        </div>
                      </div>
                    </div>
                    <div align="right">
                      <input type="submit" value="Simpan Data" class="btn btn-primary simpanPeg" onclick="simpanPegawai()">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          @endsection @section("extra_scripts")
          <script type="text/javascript">
            $("#nik").load("/master/datapegawai/tambah_pegawai", function () {
              $("#nik").focus();
            });
            $('#tgl_masuk').datepicker({
              autoclose: true,
              format: 'yyyy-mm-dd'
            });
            $('#tgl_lahir').datepicker({
              autoclose: true,
              format: 'yyyy-mm-dd'
            });
        $('select[name="c_divisi_id"]').on('change', function() {
            var stateID = $(this).val();
            if(stateID) {
              $.ajax({
                url: '{{ url('/master/datapegawai/data-jabatan') }}/'+stateID,
                type: "GET",
                dataType: "json",
                  success:function(data) {                    
                    $('select[name="c_jabatan_id"]').empty();
                    $.each(data, function(key, value) {
                      // console.log(value.c_id)
                      $('select[name="c_jabatan_id"]').append('<option value="'+ value.c_id + "-" + value.c_sub_divisi_id +'">'+ value.c_posisi +'</option>');
                    });
                  }
                });
              if(stateID == 4){
                 $('#produksi').removeAttr('hidden');
              }else{
                $('#produksi').attr('hidden','true');
              }
            }else{
              $('select[name="c_jabatan_id"]').empty();
            }
        });

        function simpanPegawai(){
          $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.simpanPeg').attr('disabled', 'disabled');
        var a = $('#simpanPegawai').serialize();
        $.ajax({
            url: baseUrl + "/master/datapegawai/simpan-pegawai",
            type: 'POST',
            data: a,
            success: function (response,) {
                if (response.status == 'sukses') {
                    iziToast.success({
                        timeout: 5000,
                        position: "topRight",
                        icon: 'fa fa-chrome',
                        title: '',
                        message: 'Data pegawai tersimpan.'
                    });
                    window.location.href = baseUrl + "/master/datapegawai/pegawai";
                } else {
                    iziToast.error({
                        position: "topRight",
                        title: '',
                        message: 'Mohon melengkapi data.'
                    });
                    $('.simpanPeg').removeAttr('disabled', 'disabled');
                }
            }
        })
        }

          </script> @endsection        
