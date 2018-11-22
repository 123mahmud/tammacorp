@extends('main') @section('content')

<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Form Edit Data Pegawai</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;Edit&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Edit Data Pegawai</li>
      <li>
        <i class="fa fa-angle-right"></i>&nbsp;Form Edit Data Pegawai&nbsp;&nbsp;</i>&nbsp;&nbsp;</li>
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
              <a href="#alert-tab" data-toggle="tab">Form Edit Data Pegawai</a>
            </li>
            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:-10px;margin-bottom: 15px;">
                  <div class="col-md-5 col-sm-6 col-xs-8">
                    <h4>Form Edit Data Pegawai</h4>
                  </div>
                  <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                    <a href="{{ url('master/datapegawai/pegawai') }}" class="btn">
                      <i class="fa fa-arrow-left"></i>
                    </a>
                  </div>
                </div>


                <div class="col-md-12 col-sm-12 col-xs-12 " style="margin-top:15px;">
                  <form method="POST" id="updatePeg">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:15px;padding-left:-10px;padding-right: -10px; ">
                    <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">ID Pegawai<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input disabled="" type="text" name="" value="{{$data->c_code}}" class="form-control input-sm">
                          <input type="hidden" name="c_code" value="{{$data->c_code}}" class="form-control input-sm">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Tanggal Masuk</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="tgl_masuk" name="c_tahun_masuk" data-date-format="dd-mm-yyyy" class="datepicker form-control input-sm"
                            placeholder="dd-mm-yyyy" value="{{$data->c_tahun_masuk}}">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Divisi<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select id="divisi" name="c_divisi_id" class="form-control input-sm">
                            <option>--pilih divisi--</option>
                            <?php foreach($divisi as $div){ ?>
                              <?php if($div->c_id == $data->c_divisi_id){ ?>
                              <option value="{{ $div->c_id }}" selected="">{{ $div->c_divisi }}</option>
                              <?php }else{ ?>
                              <option value="{{ $div->c_id }}">{{ $div->c_divisi }}</option>
                            <?php }} ?>
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
                              <option value="Senin" <?php if($data->c_hari_awal == "Senin"){ echo "selected"; }?>>Senin</option>
                              <option value="Selasa" <?php if($data->c_hari_awal == "Selasa"){ echo "selected"; }?>>Selasa</option>
                              <option value="Rabu" <?php if($data->c_hari_awal == "Rabu"){ echo "selected"; }?>>Rabu</option>
                              <option value="Kamis" <?php if($data->c_hari_awal == "Kamis"){ echo "selected"; }?>>Kamis</option>
                              <option value="Jumat" <?php if($data->c_hari_awal == "Jumat"){ echo "selected"; }?>>Jumat</option>
                              <option value="Sabtu" <?php if($data->c_hari_awal == "Sabtu"){ echo "selected"; }?>>Sabtu</option>
                              <option value="Minggu" <?php if($data->c_hari_awal == "Minggu"){ echo "selected"; }?>>Minggu</option>
                            </select>
                        </div>
                      </div>
                       <div class="col-md-2 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select id="" name="c_hari_akhir" class="form-control input-sm">
                              <option value="Senin" <?php if($data->c_hari_akhir == "Senin"){ echo "selected"; }?>>Senin</option>
                              <option value="Selasa" <?php if($data->c_hari_akhir == "Selasa"){ echo "selected"; }?>>Selasa</option>
                              <option value="Rabu" <?php if($data->c_hari_akhir == "Rabu"){ echo "selected"; }?>>Rabu</option>
                              <option value="Kamis" <?php if($data->c_hari_akhir == "Kamis"){ echo "selected"; }?>>Kamis</option>
                              <option value="Jumat" <?php if($data->c_hari_akhir == "Jumat"){ echo "selected"; }?>>Jumat</option>
                              <option value="Sabtu" <?php if($data->c_hari_akhir == "Sabtu"){ echo "selected"; }?>>Sabtu</option>
                              <option value="Minggu" <?php if($data->c_hari_akhir == "Minggu"){ echo "selected"; }?>>Minggu</option>
                            </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Shift<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select id="" name="c_shift_id" class="form-control input-sm">
                            <?php foreach($shift as $s){ ?>
                            <?php if($s->c_id == $data->c_shift_id){ ?>
                            <option value="{{ $s->c_id }}" selected="">{{ $s->c_name}}</option>
                            <?php }else{ ?>
                            <option value="{{ $s->c_id }}">{{ $s->c_name}}</option>
                            <?php }} ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Nama Pegawai<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_nama" id="c_nama" class="form-control input-sm" value="{{ $data->c_nama }}">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">KTP<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_ktp" id="c_ktp" class="form-control input-sm" value="{{ $data->c_ktp }}" >
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Alamat KTP<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_ktp_alamat" id="c_ktp_alamat" class="form-control input-sm" value="{{ $data->c_ktp_alamat }}">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">domisili sekarang<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_alamat" id="c_alamat" class="form-control input-sm" value="{{ $data->c_alamat }}">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Tempat, tanggal lahir</label>
                      </div>
                      <div class="col-md-2 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_tempat" class="form-control input-sm" value="{{ $data->c_tempat }}">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" id="tgl_lahir" name="c_tanggal" data-date-format="dd-mm-yyyy" class="datepicker form-control input-sm"
                            placeholder="dd-mm-yyyy" value="{{ $data->tgl_lahir }}">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">pendidikan<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select id="" name="c_pendidikan" class="form-control input-sm">
                            <option>--pilih pendidikan--</option>
                            <option value="S2" <?php if($data->c_pendidikan == "S2"){ echo "selected"; }?>>S2</option>
                            <option value="S1" <?php if($data->c_pendidikan == "S1"){ echo "selected"; }?>>S1</option>
                            <option value="D3" <?php if($data->c_pendidikan == "D3"){ echo "selected"; }?>>D3</option>
                            <option value="D2" <?php if($data->c_pendidikan == "D2"){ echo "selected"; }?>>D2</option>
                            <option value="D1" <?php if($data->c_pendidikan == "D1"){ echo "selected"; }?>>S1</option>
                            <option value="SMA" <?php if($data->c_pendidikan == "SMA"){ echo "selected"; }?>>SMA</option>
                            <option value="SMP" <?php if($data->c_pendidikan == "SMP"){ echo "selected"; }?>>SMP</option>
                            <option value="SD" <?php if($data->c_pendidikan == "SD"){ echo "selected"; }?>>SD</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">email<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_email" id="c_name" class="form-control input-sm" value="{{ $data->c_email }}">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">no. handphone<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_hp" id="c_name" class="form-control input-sm" value="{{ $data->c_hp }}">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Agama<font color="red">*</font></label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <select id="" name="c_agama" class="form-control input-sm">
                            <option>--pilih agama--</option>
                            <option <?php if($data->c_agama == "islam"){ echo "selected"; }?> value="islam">Islam</option>
                            <option <?php if($data->c_agama == "kristen"){ echo "selected"; }?> value="kristen">Kristen</option>
                            <option <?php if($data->c_agama == "katolik"){ echo "selected"; }?> value="katolik">Katolik</option>
                            <option <?php if($data->c_agama == "hindu"){ echo "selected"; }?> value="hindu">Hindu</option>
                            <option <?php if($data->c_agama == "budha"){ echo "selected"; }?> value="budha">Budha</option>
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
                            <option <?php if($data->c_nikah == "menikah"){ echo "selected"; }?> value="menikah">Menikah</option>
                            <option <?php if($data->c_nikah == "belum menikah"){ echo "selected"; }?> value="belum menikah">Belum menikah</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">nama suami/istri</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_pasangan" id="c_name" class="form-control input-sm" value="{{ $data->c_pasangan }}">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">anak</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="number" name="c_anak" id="c_name" class="form-control input-sm" value="{{ $data->c_anak }}">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">bank</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_bank" id="c_name" class="form-control input-sm" value="{{ $data->c_bank }}">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">no. rekening</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_rekening" id="c_name" class="form-control input-sm" value="{{ $data->c_rekening }}">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">Sertifikasi keahlian</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_sertification" id="c_name" class="form-control input-sm" value="{{ $data->c_sertification }}">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">tahun</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_sertif_tahun" id="c_name" class="form-control input-sm" value="{{ $data->c_sertif_tahun }}">
                        </div>
                      </div>
                      <div class="col-md-2 col-sm-4 col-xs-12">
                        <label class="tebal">tempat</label>
                      </div>
                      <div class="col-md-4 col-sm-8 col-xs-12">
                        <div class="form-group">
                          <input type="text" name="c_sertif_tempat" id="c_name" class="form-control input-sm" value="{{ $data->c_sertif_tempat }}">
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
            $(document).ready(function(){
              $.ajax({
                url: '{{ url('/master/datapegawai/data-jabatan') }}/{{ $data->c_divisi_id }}',
                type: "GET",
                dataType: "json",
                  success:function(data) {                    
                    $('select[name="c_jabatan_id"]').empty();
                    $.each(data, function(key, value) {
                      // console.log(value.c_id)
                      $('select[name="c_jabatan_id"]').append('<option value="'+ value.c_id +'">'+ value.c_posisi +'</option>');
                      $('select[name="c_jabatan_id"]').val({{ $data->c_jabatan_id }});
                    });
                  }
                });
                if({{$data->c_divisi_id}} == 4){
                   $('#produksi').removeAttr('hidden');
                }
            });
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
                      $('select[name="c_jabatan_id"]').append('<option value="'+ value.c_id +'">'+ value.c_posisi +'</option>');
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
        var a = $('#updatePeg').serialize();
        $.ajax({
            url: baseUrl + "/master/datapegawai/update-pegawai/{{$data->c_id}}",
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