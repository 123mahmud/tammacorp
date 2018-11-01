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
                        <div class="page-title">Form Input Kelompok Aktiva</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li> &nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Input Kelompok Aktiva</li>
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
                                     <h4>Data Kelompok Aktiva</h4>
                                   </div>
                                   <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                                     <a href="{{ url('/keuangan/p_inputtransaksi/index') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                                   </div>
                                </div>

                                <hr>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <form id="data-form">
                                      <input type="hidden" value="{{csrf_token()}}" name="_token" readonly>
                                      <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">

                                        <div class="col-md-6" style="padding: 0px;">
                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Nomor kelompok Aktiva</label>
                                            </div>
                                            <div class="col-md-5 col-sm-8 col-xs-11 mb-3">
                                              <input type="text" name="nomor_kelompok" class="form-control" readonly style="cursor: pointer;" placeholder="Di Isi Oleh Sistem" v-model="single_data.nomor_kelompok">
                                            </div>

                                            <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: pointer;" title="Lakukan Pencarian Data Kelompok Aktiva"> 
                                              <i class="fa fa-search" @click="open_list"></i>
                                            </div>

                                            <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: pointer;" title="Bersihkan Form"> 
                                              <i class="fa fa-times" v-if="state == 'update'" @click="form_reset"></i>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Nama Kelompok Aktiva</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <input type="text" name="nama_kelompok" class="form-control" placeholder="Masukkan Nama Kelompok AKtiva" id="nama_kelompok" v-model="single_data.nama_kelompok" required>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Keterangan Kelompok Aktiva</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <input type="text" name="keterangan_kelompok" class="form-control" placeholder="Masukkan Keterangan" id="keterangan_kelompok" v-model="single_data.keterangan_kelompok">
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Golongan Aset</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <select2 :option="golongan_aset" :name="'golongan_kelompok'" :id="'golongan_kelompok'" @input="golonganChange"></select2>
                                            </div>
                                          </div>

                                          <div class="row" style="border-top: 3px solid white; padding-top: 20px;">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Pilih Akun Harta</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <select2 :option="akun_harta" :name="'akun_harta'" :id="'akun_harta'"></select2>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Pilih Akun Akm. Penyusutan</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                 <select2 :option="akun_akumulasi" :name="'akun_akumulasi'" :id="'akun_akumulasi'"></select2>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Pilih Akun Beban Penyusutan</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                 <select2 :option="akun_penyusutan" :name="'akun_penyusutan'" :id="'akun_penyusutan'"></select2>
                                            </div>
                                          </div>
                                          
                                        </div>

                                        <div class="col-md-5 col-md-offset-1" style="background: white; padding: 0px;">
                                          <table class="table table-bordered" style="margin-bottom: 0px;">
                                            <thead>
                                              <tr>
                                                <td class="text-center" width="30%" style="background: #0099CC; color: white;">Metode</td>
                                                <td class="text-center" width="35%" style="background: #0099CC; color: white;">Masa Manfaat</td>
                                                <td class="text-center" width="35%" style="background: #0099CC; color: white;">% Penyusutan</td>
                                              </tr>
                                            </thead>

                                            <tbody>
                                              <tr>
                                                <td class="text-center"><i>Garis Lurus</i></td>
                                                <td class="text-center">
                                                  <input type="hidden" readonly name="masa_manfaat" v-model='single_data.masa_manfaat'>
                                                  <b v-html="single_data.masa_manfaat"></b> Tahun
                                                </td>
                                                <td class="text-center">
                                                  <input type="hidden" readonly name="persentase_sm" v-model='single_data.persentase_sm'>
                                                  <b v-html="single_data.persentase_sm"></b> %
                                                </td>
                                              </tr>

                                              <tr>
                                                <td class="text-center"><i>Saldo Menurun</i></td>
                                                <td class="text-center">
                                                  <input type="hidden" readonly name="masa_manfaat" v-model='single_data.masa_manfaat'>
                                                  <b v-html="single_data.masa_manfaat"></b> Tahun
                                                </td>
                                                <td class="text-center">
                                                  <input type="hidden" readonly name="persentase_gl" v-model='single_data.persentase_gl'>
                                                  <b v-html="single_data.persentase_gl"></b> %
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                      </div>

                                      <div align="right">
                                        <div class="form-group">
                                          <button type="button" name="tambah_data" class="btn btn-primary" id="simpan" @click="simpan_data" :disabled='btn_save_disabled' v-if="state == 'simpan'">Simpan Data</button>

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
                      <data-list :data_resource="data_table_resource" :columns="data_table_columns" :selectable="true" :ajax_on_loading="on_ajax_loading" @selected="get_kelompok" :index_column="'ga_id'"></data-list>
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
            nama_kelompok : {
              validators : {
                notEmpty : {
                  message : 'Nama Kelompok Tidak Boleh Kosong',
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
          format: 'dd-mm-yyyy'
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
            radixPoint: ",",
            groupSeparator: ".",
            digits: 2,
            allowMinus: false,
            autoGroup: true,
            prefix: '', //Space after $, this will not truncate the first character.
            rightAlign: false,
            oncleared: function () {  }
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

        data_table_resource: [],
        data_table_columns: [],

        golongan_aset : [
          {
            nama            : "Non Bangunan - Kelompok 1",
            masa_manfaat    : 4,
            garis_lurus     : 25,
            saldo_menurun   : 50,
            value           : '1'
          },
          {
            nama            : "Non Bangunan - Kelompok 2",
            masa_manfaat    : 8,
            garis_lurus     : 12.50,
            saldo_menurun   : 25,
            value           : '2'
          },
          {
            nama            : "Non Bangunan - Kelompok 3",
            masa_manfaat    : 16,
            garis_lurus     : 6.25,
            saldo_menurun   : 12.5,
            value           : '3'
          },
          {
            nama            : "Non Bangunan - Kelompok 4",
            masa_manfaat    : 20,
            garis_lurus     : 5,
            saldo_menurun   : 10,
            value           : '4'
          },
          {
            nama            : "Bangunan - Permanen",
            masa_manfaat    : 20,
            garis_lurus     : 5,
            saldo_menurun   : 0,
            value           : '5'
          },
          {
            nama            : "Bangunan - Non Permanen",
            masa_manfaat    : 10,
            garis_lurus     : 10,
            saldo_menurun   : 0,
            value           : '6'
          }
        ],

        akun_harta: [],
        akun_penyusutan: [],
        akun_akumulasi: [],
        golongan_kelompok: '4',

        single_data: {
            nomor_kelompok: '',
            nama_kelompok: '',
            keterangan_kelompok: '',
            masa_manfaat : '4',
            persentase_gl : '25',
            persentase_sm : '50',
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
        // this.golonganChange(1);
        axios.get(this.baseUrl+'/aktiva/kelompok_aktiva/form-resource')
              .then((response) => {
                console.log(response.data);

                if(response.data.akun_harta.length > 0){
                  this.akun_harta = response.data.akun_harta;
                  // this.single_data.akun_harta = response.data.akun_harta[0].id_akun;
                }

                if(response.data.akun_beban.length > 0){
                  this.akun_penyusutan = response.data.akun_beban;
                  // this.single_data.akun_penyusutan = response.data.akun_beban[0].id_akun;
                }

                if(response.data.akun_penyusutan.length > 0){
                  this.akun_akumulasi = response.data.akun_penyusutan;
                  // this.single_data.akun_akumulasi = response.data.akun_penyusutan[0].id_akun;
                }

                // console.log(this.single_data.akun_kas);
                // $('#supplier').select2();
                $('.overlay.main').fadeOut(200);
              }).catch(err => {
                 $('#load-status-text').text('Sistem Bermasalah. Cobalah Memuat Ulang Halaman');
              }).then(() => {
                $('#overlay-transaksi').fadeIn(200);
              })
      },

      watch: {
        
      },

      methods: {
        simpan_data: function(evt){
          evt.preventDefault();
          this.btn_save_disabled = true;

          // console.log($('#data-form').serialize());

          if($('#data-form').data('bootstrapValidator').validate().isValid()){
            axios.post(this.baseUrl+'/aktiva/kelompok_aktiva/store', 
              $('#data-form').serialize()
            ).then((response) => {
              console.log(response.data);
              if(response.data.status == 'berhasil'){
                $.toast({
                    text: 'Data Kelompok Aktiva Baru Berhasil Disimpan.',
                    showHideTransition: 'slide',
                    position: 'top-right',
                    icon: 'success'
                })

                this.form_reset();
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
          
        },

        hapus: function(){
          
        },

        close_list: function(){
          $(".overlay").fadeOut(200);
        },

        open_list: function(){

          this.data_table_columns = [
            {name: 'No.Kelompok', context: 'ga_nomor', width: '15%', childStyle: 'text-align: center'},
            {name: 'Nama Kelompok', context: 'ga_nama', width: '15%', childStyle: 'text-align: center'},
            {name: 'Golongan Aset', context: 'ga_golongan', width: '20%', childStyle: 'text-align: center', override: function(e){
              switch(e){
                case 1 :
                  return 'Non Bangunan - Kelompok 1';
                  break;
                case 2 :
                  return 'Non Bangunan - Kelompok 2';
                  break;
                case 3 :
                  return 'Non Bangunan - Kelompok 3';
                  break;
                case 4 :
                  return 'Non Bangunan - Kelompok 4';
                  break;
                case 5 :
                  return 'Bangunan - Permanen';
                  break;
                case 6 :
                  return 'Bangunan - Non Permanen';
                  break;
              }
            }},
            {name: 'Akun Harta', context: 'ga_akun_harta', width: '15%', childStyle: 'text-align: center'},
            {name: 'Akun Akumulasi', context: 'ga_akun_akumulasi', width: '15%', childStyle: 'text-align: center'},
            {name: 'Akun Penyusutan', context: 'ga_akun_penyusutan', width: '15%', childStyle: 'text-align: center'},
          ];

          $('.overlay.transaksi_list').fadeIn(200);
          this.on_ajax_loading = true;
          this.data_table_resource = [];

          axios.get(this.baseUrl+'/aktiva/kelompok_aktiva/list-kelompok')
                  .then((response) => {
                    console.log(response.data);
                    this.data_table_resource = response.data;
                    this.on_ajax_loading = false;
                  }).catch((err) => {
                    alert(err);
                  })
        },

        get_kelompok: function(e){
          alert(e);
        },

        golonganChange: function(e){
          var idx = this.golongan_aset.findIndex(a => a.value === e);
          // alert(idx);
          this.single_data.masa_manfaat = this.golongan_aset[idx].masa_manfaat;
          this.single_data.persentase_gl = this.golongan_aset[idx].garis_lurus;
          this.single_data.persentase_sm = this.golongan_aset[idx].saldo_menurun;
        },

        humanizePrice: function(alpha){
          var bilangan = alpha;
  
          var number_string = bilangan.toString(),
            sisa  = number_string.length % 3,
            rupiah  = number_string.substr(0, sisa),
            ribuan  = number_string.substr(sisa).match(/\d{3}/g);
              
          if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
          }

          // Cetak hasil
          return rupiah; // Hasil: 23.456.789
        },

        form_reset: function(){
           // alert($('#akun_harta').val());
           $('#golongan_kelompok').val(this.golongan_aset[0].value).trigger('change.select2');
           $('#akun_harta').val(this.akun_harta[0].value).trigger('change.select2');
           $('#akun_penyusutan').val(this.akun_penyusutan[0].value).trigger('change.select2').trigger('change.select2');
           $('#akun_akumulasi').val(this.akun_akumulasi[0].value).trigger('change.select2');

          this.single_data.nama_kelompok = '';
          this.single_data.keterangan_kelompok = '';
          this.single_data.masa_manfaat  = '4';
          this.single_data.persentase_gl  = '25';
          this.single_data.persentase_sm  = '50';
        }
      }

    })

  </script>
@endsection                            
