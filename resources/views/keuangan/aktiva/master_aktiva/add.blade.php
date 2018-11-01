@extends('main')

@section('extra_styles')
    <link type="text/css" rel="stylesheet" href="{{ asset('js/chosen/chosen.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('js/datepicker/datepicker.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('js/toast/dist/jquery.toast.min.css') }}">

    <style>
      .mb-3{
        margin-bottom: 15px;
      }
    </style>
@endsection

@section('content')
            <!--BEGIN PAGE WRAPPER-->
            <div id="vue-element">
              <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
                        <div class="page-title">Form Input Aktiva</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li> &nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Input Aktiva</li>
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
                            {{-- <li class="active"><a href="#alert-tab" data-toggle="tab">Form Master Data Akun Keuangan</a></li> --}}
                            <!-- <li><a href="#note-tab" data-toggle="tab">2</a></li>
                            <li><a href="#label-badge-tab-tab" data-toggle="tab">3</a></li> -->
                          </ul>

                          <div id="generalTabContent" class="tab-content responsive">
                            <div id="alert-tab" class="tab-pane fade in active">
                              <div class="row">
                                <div class="col-md-12" style="margin-top: -10px;margin-bottom: 20px;">
                                   <div class="col-md-5 col-sm-6 col-xs-8">
                                     <h4>Data Aktiva</h4>
                                   </div>
                                   <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                                     <a href="{{ url('master/aktiva/aset') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                                   </div>
                                </div>

                                <hr>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <form id="data-form">
                                      <input type="hidden" value="{{csrf_token()}}" name="_token" readonly>
                                      <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 10px; padding-bottom:5px;padding-top:20px;background: ">

                                        <div class="col-md-6" style="padding: 0px;">
                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Nomor Aset</label>
                                            </div>
                                            <div class="col-md-5 col-sm-8 col-xs-11 mb-3">
                                              <input type="text" name="nomor_aset" class="form-control" readonly style="cursor: pointer;" placeholder="Di Isi Oleh Sistem" v-model="single_data.nomor_aset">
                                            </div>

                                            <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: pointer;" title="Lakukan Pencarian Data Aset"> 
                                              <i class="fa fa-search" @click="open_list"></i>
                                            </div>

                                            <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: pointer;" title="Bersihkan Form"> 
                                              <i class="fa fa-times" v-if="state == 'update'" @click="form_reset"></i>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Nama Aset</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <input type="text" name="nama_aset" id="nama_aset" class="form-control" placeholder="Masukkan Nama Kelompok Aset" id="nama_aset" v-model="single_data.nama_aset" required>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Bulan Beli Aset</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <datepicker :placeholder="'Plih Bulan Beli'" :name="'tanggal_beli'" :id="'tanggal_beli'" :disabled="state == 'update'" :required="true" @input="dateChange"></datepicker>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Harga Beli Aset</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <inputmask :name="'harga_beli'" :id="'harga_beli'" :required="true" :readonly="false" @input="priceChange"></inputmask>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Kelompok Aset</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <select2 :option="kelompok_aktiva" :name="'kelompok_aktiva'" :id="'kelompok_aktiva'" @input="golonganChange"></select2>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Pilih Metode Penyusutan</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <select2 :option="metode_penyusutan" :name="'metode_penyusutan'" :id="'metode_penyusutan'" @input="metodeChange"></select2>
                                            </div>
                                          </div>                                                                                    
                                        </div>

                                        <div class="col-md-5 col-md-offset-1" style="background: none; padding: 0px;">
                                          <div class="row" style="background: none; padding-right: 20px;">
                                            <table class="table table-bordered" style="margin-bottom: 0px; background: white;">
                                              <thead>
                                                <tr>
                                                  <td class="text-center" width="30%" style="background: #0099CC; color: white;">Metode</td>
                                                  <td class="text-center" width="35%" style="background: #0099CC; color: white;">Masa Manfaat</td>
                                                  <td class="text-center" width="35%" style="background: #0099CC; color: white;">% Penyusutan</td>
                                                </tr>
                                              </thead>

                                              <tbody>
                                                <tr>
                                                  <td class="text-center">
                                                    <i>@{{ single_data.metode_penyusutan }}</i>
                                                  </td>

                                                  <td class="text-center">
                                                    <input type="hidden" readonly name="masa_manfaat" v-model='single_data.masa_manfaat'>
                                                    <b v-html="single_data.masa_manfaat"></b> Tahun
                                                  </td>
                                                  <td class="text-center">
                                                    <input type="hidden" readonly name="persentase_gl" v-model='single_data.persentase'>
                                                    <b v-html="single_data.persentase"></b> %
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>

                                          <div class="row" style="margin-top: 35px;">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3" style="padding: 0px 5px;"> 
                                              <label class="tebal">Akun Harta</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:; padding-right: 25px;">
                                                <input type="text" name="akun_harta" class="form-control" readonly style="cursor: pointer;" placeholder="Sesuai Kelompok Aset" v-model="single_data.akun_harta">
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3" style="padding: 0px 5px;"> 
                                              <label class="tebal">Akun Akm. Penyusutan</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:; padding-right: 25px;">
                                                 <input type="text" name="akun_akumulasi" class="form-control" readonly style="cursor: pointer;" placeholder="Sesuai Kelompok Aset" v-model="single_data.akun_akumulasi">
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3" style="padding: 0px 5px;"> 
                                              <label class="tebal">Akun Beban</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:; padding-right: 25px;">
                                                 <input type="text" name="akun_penyusutan" class="form-control" readonly style="cursor: pointer;" placeholder="Sesuai Kelompok Aset" v-model="single_data.akun_penyusutan">
                                            </div>
                                          </div>

                                        </div>
                                      </div>

                                      <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:10px;">

                                        <div v-if="simulasi_view == 'standby'" class="col-md-12 text-muted" style="text-align: center; margin: 0 auto;">
                                          Simulasi Penyusutan Akan Menampilkan Perkiraan Penyusutan Sesuai Dengan Data Yang Anda Masukkan. Perhitungan Tidak Akan Disimpan Sampai Anda Menekan Tombol Simpan.
                                        </div>

                                        <div v-if="simulasi_view == 'calculating'" class="col-md-12 text-muted" style="text-align: center; margin: 0 auto;">
                                          Sedang Melakukan Simulasi Penyusutan... Harap Tunggu!
                                        </div>

                                        <table class="table table-bordered" style="background: white; margin-bottom: 5px;" v-show="simulasi_view == 'complete'">
                                          <thead>
                                            <tr>
                                              <td width="10%" class="text-center" style="background: #0099CC; color: white;">Tahun</td>
                                              <td width="15%" class="text-center" style="background: #0099CC; color: white;">Jumlah Bulan</td>
                                              <td width="15%" class="text-center" style="background: #0099CC; color: white;">Harga Perolehan</td>
                                              <td width="20%" class="text-center" style="background: #0099CC; color: white;">Biaya Penyusutan</td>
                                              <td width="22%" class="text-center" style="background: #0099CC; color: white;">Akumulasi Penyusutan</td>
                                              <td width="18%" class="text-center" style="background: #0099CC; color: white;">Nilai Sisa Buku (Residu)</td>
                                            </tr>
                                          </thead>

                                          <tbody>
                                            <tr v-for="data in simulasi_hitung" :style="(data.year_now) ? 'background: #eee;' : ''">
                                              <td class="text-center">
                                                <input type="hidden" name="tahun[]" :value="data.tahun" readonly>
                                                @{{ data.tahun }}
                                              </td>
                                              <td class="text-center">
                                                <input type="hidden" name="jml_bulan[]" :value="data.jumlah_bulan" readonly>
                                                @{{ data.jumlah_bulan }}
                                              </td>
                                              <td class="text-center">
                                                @{{ data.harga_perolehan }}
                                              </td>
                                              <td class="text-center">
                                                <input type="hidden" name="penyusutan[]" :value="data.nilai_penyusutan" readonly>
                                                @{{ data.nilai_penyusutan }}
                                              </td>
                                              <td class="text-center">@{{ data.nilai_akumulasi }}</td>
                                              <td class="text-center">@{{ data.nilai_sisa }}</td>
                                            </tr>
                                          </tbody>

                                          <tfoot v-if="state == 'update'">
                                            <tr>
                                              <td colspan="6" class="text-center">
                                                <small style="padding-left: 10px;">
                                                  Perubahan Pada Aktiva Yang Sudah Dilakukan Penyusutan Hanya Akan Mempengaruhi Nama Aktiva.
                                                </small>
                                              </td>
                                            </tr>
                                          </tfoot>
                                        </table>

                                      </div>

                                      <div align="right">
                                        <div class="form-group">
                                          <button type="button" name="hitung" class="btn btn-success" id="hitung" @click="hitung" :disabled='btn_save_disabled'>Hitung Simulasi Penyusutan</button>

                                          <button type="button" name="tambah_data" class="btn btn-primary" id="simpan" @click="simpan_data" :disabled="btn_save_disabled || simulasi_view != 'complete'" v-if="state == 'simpan'">Simpan Data</button>

                                          <button type="button" name="tambah_data" class="btn btn-primary" id="update" @click="update" :disabled='btn_save_disabled' v-if="state == 'update'">Update</button>

                                          <button type="button" name="tambah_data" class="btn btn-dafault" id="hapus" @click="hapus" :disabled='btn_save_disabled' v-if="state == 'update'">Hapus</button>
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

                <div class="overlay transaksi_list">
                  <div class="content-loader" style="background: none; width:60%; margin: 3em auto; color: #eee;">
                    <div class="col-md-9" style="background: white; color: rgba(0,0,0,0.5); padding: 15px 20px; border-bottom: 1px solid #aaa; font-size: 12pt;">
                      <b>List Data Kelompok Aktiva </b>
                    </div>

                    <div class="col-md-3 text-right" style="background: white; color: #ff4444; padding: 15px 20px; border-bottom: 1px solid #aaa; font-size: 12pt;">
                      <i class="fa fa-times" style="cursor: pointer;" @click="close_list" title="Tutup Jendela"></i>
                    </div>

                    <div class="col-md-12" style="background: white; color: #3e3e3e; padding-top: 10px;">
                      <data-list :data_resource="data_table_resource" :columns="data_table_columns" :selectable="true" :ajax_on_loading="on_ajax_loading" @selected="get_kelompok" :index_column="'a_nomor'"></data-list>
                    </div>
                  </div>
                </div>

              </div>
                            
@endsection

@section("extra_scripts")
  <script src="{{ asset("js/chosen/chosen.jquery.js") }}"></script>
  <script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
  <script src="{{ asset("js/datepicker/datepicker.js") }}"></script>
  <script src="{{ asset("js/vue/vue.js") }}"></script>
  <script src="{{ asset("js/vue/vue-datatable.js") }}"></script>
  <script src="{{ asset("js/axios/dist/axios.min.js") }}"></script>
  <script src="{{ asset("js/validator/bootstrapValidator.min.js") }}"></script>
  <script src="{{ asset("js/toast/dist/jquery.toast.min.js") }}"></script>

  <script type="text/x-template" id="datepicker-template">
    <input type="text" :name="name" :placeholder="placeholder" class="form-control" style="width:100%; cursor: pointer;" :id="id" required>
  </script>

  <script type="text/x-template" id="inputmask-template">
    <input type="text" :name="name" class="form-control text-right" :id="id" :required="required" :readonly="readonly">
  </script>

  <script type="text/x-template" id="select2">
    <select class="form-control" :name="name" :id="id">
      <option v-for="(n, idx) in option" :value="n.value">@{{ n.value+' - '+n.nama }}</option>
    </select>
  </script>
  
  <script type="text/javascript">  

    function register_validator(){
      $('#data-form').bootstrapValidator({
          feedbackIcons : {
            valid : 'glyphicon glyphicon-ok',
            invalid : 'glyphicon glyphicon-remove',
            validating : 'glyphicon glyphicon-refresh'
          },
          fields : {
            nama_aset : {
              validators : {
                notEmpty : {
                  message : 'Nama Aset Tidak Boleh Kosong',
                }
              }
            },

            tanggal_beli : {
              validators : {
                notEmpty : {
                  message : 'Tanggal Beli Aset Tidak Boleh Kosong',
                }
              }
            },

            harga_beli : {
              validators : {
                notEmpty : {
                  message : 'Harga Beli Aset Tidak Boleh Kosong',
                }
              }
            },
          }
        });
    }

    Vue.component('datepicker', {
      props: ['placeholder', 'name', 'id'],
      template: '#datepicker-template',
      mounted: function () {
        var vm = this
        $(this.$el).datepicker({
          format: "mm-yyyy",
          viewMode: "months", 
          minViewMode: "months"
        }).on('changeDate', function(){
          vm.$emit('input', $(this).val());
        });
      },
      watch: {
        model: function(){
          // $(this.$el).val(this.model);
        }
      },
      destroyed: function () {

      }
    });

    Vue.component('inputmask', {
      props: ['placeholder', 'name', 'id', 'required', 'readonly'],
      template: '#inputmask-template',
      mounted: function () {
        var vm = this
        $(this.$el).inputmask("currency", {
            radixPoint: ".",
            groupSeparator: ",",
            digits: 2,
            allowMinus: false,
            autoGroup: true,
            prefix: '', //Space after $, this will not truncate the first character.
            rightAlign: false,
            oncleared: function () {  }
        }).on('change', function(){
          vm.$emit('input', $(this).val());
        });
      },
      watch: {
        model: function(){
          // $(this.$el).val(this.model);
        }
      },
      destroyed: function () {

      }
    });

    Vue.component('select2', {
      props: ['option', 'name', 'id'],
      template: '#select2',
      mounted: function(){
        // console.log(this.option);
        var vm = this;
        $(this.$el).select2().on('select2:select', function (e) {
          vm.$emit('input', e.params.data.id);
        });
      },
      watch: {
        model: function(){
          // $(this.$el).val(this.model);
        }
      },
      destroyed: function () {
          
        }
    })

    
    var vm = new Vue({

      el: '#vue-element',
      data: {
        baseUrl: '{{ url('/') }}',
        btn_save_disabled: false,
        state: 'simpan',
        on_ajax_loading: false,

        edit : '{{ (isset($_GET['edit'])) ? $_GET['edit'] : 'null' }}',
        data_table_resource: [],
        data_table_columns: [],
        simulasi_view : 'standby',

        metode_penyusutan: [
          {
              value   : 'GL',
              nama    : 'Metode Garis Lurus'
          },

          {
              value   : 'SM',
              nama    : "Metode Saldo Menurun"
          },
        ],

        kelompok_aktiva : [],

        simulasi_hitung: [],

        single_data: {
            nomor_aset: '',
            nama_aset: '',
            masa_manfaat : '',
            persentase : '',
            tanggal_beli : '',
            harga_beli : '',
            kelompok_aktiva : '',
            metode_penyusutan : 'Garis Lurus',
            akun_harta: '',
            akun_penyusutan: '',
            akun_akumulasi: '',
        },
      },

      mounted: function(){
        register_validator();
        // $('.select2').select2();
        $('.overlay.main').fadeIn(200);
        // $('.overlay.transaksi_list').fadeIn(200);
        $('#load-status-text').text('Harap Tunggu. Sedang Menyiapkan Form');  
      },

      created: function(){
        if(this.edit != 'null'){
          axios.get(this.baseUrl+'/master/aktiva/aset/list')
                    .then((response) => {
                      // console.log(response.data);
                      this.data_table_resource = response.data;
                      this.get_kelompok(this.edit);
                    }).then((a) => {
                      // alert(this.edit);
                    }).catch((err) => {
                      alert(err);
                    });
        }

        axios.get(this.baseUrl+'/master/aktiva/aset/form-resource')
              .then((response) => {
                console.log(response.data);

                if(response.data.kelompok_aktiva.length > 0){
                  this.kelompok_aktiva = response.data.kelompok_aktiva;
                }

                $('.overlay.main').fadeOut(200);
              }).catch(err => {
                 $('#load-status-text').text('Sistem Bermasalah. Cobalah Memuat Ulang Halaman');
              }).then(() => {
                if(this.kelompok_aktiva.length > 0 && this.edit == 'null')
                  this.golonganChange(this.kelompok_aktiva[0].value);
                $('#overlay-transaksi').fadeIn(200);
              })
      },

      watch: {
        
      },

      methods: {

        simpan_data: function(evt){
          evt.preventDefault();
          evt.stopImmediatePropagation();
          this.btn_save_disabled = true;

          // console.log($('#data-form').serialize());

          if($('#data-form').data('bootstrapValidator').validate().isValid()){
            axios.post(this.baseUrl+'/master/aktiva/aset/store', 
              $('#data-form').serialize()
            ).then((response) => {
              console.log(response.data);
              if(response.data.status == 'berhasil'){
                  $.toast({
                      text: response.data.content,
                      showHideTransition: 'slide',
                      position: 'top-right',
                      icon: response.data.flag
                  })

                  this.form_reset();
                }else if(response.data.status == 'gagal'){
                  $.toast({
                      text: response.data.content,
                      showHideTransition: 'slide',
                      position: 'top-right',
                      icon: response.data.flag,
                      hideAfter: false
                  })
                }
            }).catch((err) => {
              alert(err);
              this.btn_save_disabled = false;
            }).then(() => {
              this.btn_save_disabled = false;
            })
          }else{
            this.btn_save_disabled = false;
          }
        },

        update: function(evt){
            evt.preventDefault();
            this.btn_save_disabled = true;

            // console.log($('#data-form').serialize());

            if($('#data-form').data('bootstrapValidator').validate().isValid()){
              axios.post(this.baseUrl+'/master/aktiva/aset/update', 
                $('#data-form').serialize()
              ).then((response) => {
                console.log(response.data);
                if(response.data.status == 'berhasil'){
                  $.toast({
                      text: response.data.content,
                      showHideTransition: 'slide',
                      position: 'top-right',
                      icon: response.data.flag
                  })

                  this.form_reset();
                }else if(response.data.status == 'gagal'){
                  $.toast({
                      text: response.data.content,
                      showHideTransition: 'slide',
                      position: 'top-right',
                      icon: response.data.flag,
                      hideAfter: false
                  })
                }
              }).catch((err) => {
                alert(err);
                this.btn_save_disabled = false;
              }).then(() => {
                this.btn_save_disabled = false;
              })
            }else{
              this.btn_save_disabled = false;
            }
        },

        hapus: function(){
          var cfrm = confirm('Apakah Anda Yakin, Semua Jurnal Yang Terkait Dengan Aktiva Ini Juga Akan Dihapus ? ');

          if(cfrm){
            if(this.single_data.nomor_aset != ''){
              this.btn_save_disabled = true;

              axios.post(this.baseUrl+'/master/aktiva/aset/delete', 
                {id: this.single_data.nomor_aset}
              ).then((response) => {
                console.log(response.data);
                if(response.data.status == 'berhasil'){
                  $.toast({
                      text: response.data.content,
                      showHideTransition: 'slide',
                      position: 'top-right',
                      icon: response.data.flag
                  })

                  this.form_reset();
                }else if(response.data.status == 'gagal'){
                  $.toast({
                      text: response.data.content,
                      showHideTransition: 'slide',
                      position: 'top-right',
                      icon: response.data.flag,
                      hideAfter: false
                  })
                }
              }).catch((err) => {
                alert(err);
                this.btn_save_disabled = false;
              }).then(() => {
                this.btn_save_disabled = false;
              })
            }else{
              alert('Tidak Ada Nomor Kelompok Terdeteksi..');
              this.btn_save_disabled = false;
            }
          }
        },

        close_list: function(){
          $(".overlay").fadeOut(200);
        },

        open_list: function(){

          var that = this;

          this.data_table_columns = [
            {name: 'No.Aktiva', context: 'a_nomor', width: '15%', childStyle: 'text-align: center'},
            {name: 'Nama Aktiva', context: 'a_name', width: '15%', childStyle: 'text-align: center'},
            {name: 'Kelompok Aset', context: 'ga_nama', width: '15%', childStyle: 'text-align: center'},
            {name: 'Masa Manfaat', context: 'ga_masa_manfaat', width: '15%', childStyle: 'text-align: center', override: function(a){
              return a+' Tahun';
            }},
            {name: 'Tanggal Beli', context: 'a_tanggal_beli', width: '15%', childStyle: 'text-align: center'},
            {name: 'Harga', context: 'a_harga_beli', width: '15%', childStyle: 'text-align: right', override: function(a){
              return that.humanizePrice(a);
            }},
          ];

          $('.overlay.transaksi_list').fadeIn(200);
          this.on_ajax_loading = true;
          this.data_table_resource = [];

          axios.get(this.baseUrl+'/master/aktiva/aset/list')
                  .then((response) => {
                    console.log(response.data);
                    this.data_table_resource = response.data;
                    this.on_ajax_loading = false;
                  }).catch((err) => {
                    alert(err);
                  })
        },

        get_kelompok: function(e){
          console.log(this.data_table_resource);
          var idx = this.data_table_resource.findIndex(a => a.a_nomor === e);

          // alert('plok');

          console.log(this.data_table_resource[idx]);

          if(idx >= 0){
              var data = this.data_table_resource[idx];

              // alert(data.ga_garis_lurus);

              $('#harga_beli').val(data.a_harga_beli);
              $('#kelompok_aktiva').val(data.a_kelompok).trigger('change.select2');
              $('#metode_penyusutan').val(data.a_metode_penyusutan).trigger('change.select2');
              $('#tanggal_beli').val(data.a_tanggal_beli.split('-')[1]+'-'+data.a_tanggal_beli.split('-')[0]);
              $('#nama_aset').val(data.a_name);

              this.single_data.nomor_aset = data.a_nomor;
              this.single_data.nama_aset = data.a_name;
              this.single_data.masa_manfaat  = data.ga_masa_manfaat;
              this.single_data.persentase  = (data.a_metode_penyusutan == 'SM') ? data.ga_saldo_menurun : data.ga_garis_lurus;
              this.single_data.tanggal_beli  = data.a_tanggal_beli.split('-')[1]+'-'+data.a_tanggal_beli.split('-')[0];
              this.single_data.harga_beli  = this.humanizePrice(data.a_harga_beli);
              this.single_data.kelompok_aktiva  = data.a_kelompok;
              this.single_data.metode_penyusutan  = (data.a_metode_penyusutan == 'SM') ? 'Saldo Menurun' : 'Garis Lurus';

              this.state = 'update';
              $('#data-form').data('bootstrapValidator').resetForm();

              this.metodeChange(data.a_metode_penyusutan);
              this.hitung();

              $('.overlay.transaksi_list').fadeOut(200);

          }else{
            alert('Data Yang Dipilih Tidak Bisa Ditemukan');
          }
        },

        golonganChange: function(e){

          var idx = this.kelompok_aktiva.findIndex(a => a.value === e);
          
          if(idx >= 0){
            this.single_data.kelompok_aktiva = e;
            this.single_data.akun_harta = this.kelompok_aktiva[idx].ga_akun_harta+' - '+this.kelompok_aktiva[idx].akun_harta;
            this.single_data.akun_penyusutan = this.kelompok_aktiva[idx].ga_akun_penyusutan+' - '+this.kelompok_aktiva[idx].akun_penyusutan;
            this.single_data.akun_akumulasi = this.kelompok_aktiva[idx].ga_akun_akumulasi+' - '+this.kelompok_aktiva[idx].akun_akumulasi;
            this .single_data.masa_manfaat = this.kelompok_aktiva[idx].ga_masa_manfaat;

            this.generateInfo();
          }else{
            alert('Kelompok Aktiva Tidak Diketahui');
          }
        },

        metodeChange: function(e){
          if(e == 'SM')
            this.single_data.metode_penyusutan = 'Saldo Menurun';
          else
            this.single_data.metode_penyusutan = 'Garis Lurus';

          this.generateInfo();
        },

        dateChange: function(e){
          this.single_data.tanggal_beli = e;
          $('#data-form').data('bootstrapValidator').resetForm();
          this.calculated();
        },

        priceChange: function(e){
          this.single_data.harga_beli = e;
          this.calculated();
        },

        generateInfo: function(){
          // alert(this.single_data.metode_penyusutan);
          var idx = this.kelompok_aktiva.findIndex(a => a.value === this.single_data.kelompok_aktiva);
          console.log(idx);

          if(this.single_data.metode_penyusutan == "Garis Lurus")
              this.single_data.persentase = this.kelompok_aktiva[idx].ga_garis_lurus;
          else
            this.single_data.persentase = this.kelompok_aktiva[idx].ga_saldo_menurun;
          
          this.calculated();
        },

        hitung: function(){

          if($('#data-form').data('bootstrapValidator').validate().isValid()){
              var that = this;
              this.simulasi_view = 'calculating';
              this.calculated();
              setTimeout(function(){
                that.simulasi_view = 'complete';
              }, ((that.single_data.masa_manfaat * 1000) / 4));
          }else{
            alert('Harap Lengkapi Data Form Terlebih Dahulu');
          }

          // console.log(this.simulasi_hitung);
        },

        calculated: function(){
          var np = parseFloat(this.single_data.harga_beli.replace(/\,/g, ''));
          var tahun = parseInt(this.single_data.tanggal_beli.split('-')[1]);
          var bulan = parseInt(this.single_data.tanggal_beli.split('-')[0]);
          var loop = (bulan > 1) ? this.single_data.masa_manfaat + 1 : this.single_data.masa_manfaat;
          var nilai_penyusutan = nilai_akumulasi = 0 ;
          var nilai_sisa = np;
          var data = []; 
          var persentase = this.single_data.persentase/100;

          for(var i = 0; i < loop; i++){
            
            var bulan_jalan = 12;
            var year_now = ((tahun + i) == '{{ date('Y') }}');

            if((tahun+i) == tahun){
              bulan_jalan = 12 - (bulan-1);
            }else if((tahun+i) == (tahun+this.single_data.masa_manfaat)){
              bulan_jalan = (bulan - 1);
            }

              if(this.single_data.metode_penyusutan == "Garis Lurus"){
                nilai_penyusutan = ((np * persentase) / 12) * bulan_jalan;
              }else{
                if(i != (loop-1))
                  nilai_penyusutan = (((np - nilai_akumulasi) * persentase) / 12) * bulan_jalan;
                else
                  nilai_penyusutan = nilai_sisa;
              }

              nilai_akumulasi += nilai_penyusutan;
              nilai_sisa -= nilai_penyusutan;

              data[i] = {
                'tahun' : (tahun+i),
                'jumlah_bulan' : bulan_jalan,
                'harga_perolehan' : this.humanizePrice(np),
                'nilai_penyusutan' : this.humanizePrice(Number(nilai_penyusutan.toFixed(2))),
                'nilai_akumulasi' : this.humanizePrice(Number(nilai_akumulasi.toFixed(2))), 
                'nilai_sisa' : this.humanizePrice(Number(nilai_sisa.toFixed(2))),
                'year_now'   : year_now,
              }            
          }

          this.simulasi_hitung = data;
        },

        humanizePrice: function(alpha){
          var bilangan = alpha.toString();
          var commas = (bilangan.split('.').length == 1) ? '00' : bilangan.split('.')[1];
  
          var number_string = bilangan.toString(),
            sisa  = number_string.length % 3,
            rupiah  = number_string.substr(0, sisa),
            ribuan  = number_string.substr(sisa).match(/\d{3}/g);
              
          if (ribuan) {
            separator = sisa ? ',' : '';
            rupiah += separator + ribuan.join(',');
          }

          // Cetak hasil
          return rupiah+'.'+commas; // Hasil: 23.456.789
        },

        form_reset: function(){

            this.simulasi_hitung = [];
            this.simulasi_view = 'standby;'
            this.state = 'simpan';
            this.single_data.nomor_aset = '';
            this.single_data.nama_aset = '';
            this.single_data.masa_manfaat  = '';
            this.single_data.persentase  = '';
            this.single_data.tanggal_beli  = '';
            this.single_data.harga_beli  = '';
            this.single_data.kelompok_aktiva  = '';
            this.single_data.metode_penyusutan  = 'Garis Lurus',
            this.single_data.akun_harta = '';
            this.single_data.akun_penyusutan = '';
            this.single_data.akun_akumulasi = '';

            $('#kelompok_aktiva').val(this.kelompok_aktiva[0].value).trigger('change.select2');
            $('#metode_penyusutan').val('GL').trigger('change.select2');
            $('#harga_beli').val(0);
            $('#tanggal_beli').val('');
            this.golonganChange(this.kelompok_aktiva[0].value);
            $('#data-form').data('bootstrapValidator').resetForm();
        }
      }

    })

  </script>
@endsection                            
