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
                        <div class="page-title">Form Input Data Transaksi Memorial</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li> &nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Input Transaksi Memorial</li>
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
                                     <h4>Transaksi Memorial</h4>
                                   </div>
                                   <div class="col-md-7 col-sm-6 col-xs-4" align="right" style="margin-top:5px;margin-right: -25px;">
                                     <a href="{{ url('/keuangan/p_inputtransaksi/index') }}" class="btn"><i class="fa fa-arrow-left"></i></a>
                                   </div>
                                </div>

                                <hr>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <form id="data-form">
                                      <input type="hidden" value="{{csrf_token()}}" name="_token" readonly>
                                      <input type="hidden" name="id_transaksi" readonly v-model="single_data.id_transaksi">
                                      <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 20px; padding-bottom:5px;padding-top:20px; ">

                                        <div class="col-md-6" style="padding: 0px;">
                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Jenis Transaksi</label>
                                            </div>
                                            <div class="col-md-5 col-sm-8 col-xs-11 mb-3">
                                              <select class="form-control" name="jenis_transaksi" id="jenis_transaksi" name="jenis_transaksi" v-model="single_data.jenis_transaksi" :disabled="state == 'update'">
                                                <option value="MD">Memorial Debet</option>
                                                <option value="MK">Memorial Kredit</option>
                                              </select>
                                            </div>

                                            <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: pointer;" title="Lakukan Pencarian Berdasarkan Jenis dan Bulan (dari tanggal yang dipilih)"> 
                                              <i class="fa fa-search" @click="open_list"></i>
                                            </div>

                                            <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: pointer;" title="Bersihkan Form"> 
                                              <i class="fa fa-times" v-if="state == 'update'" @click="form_reset"></i>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Tanggal Transaksi</label>
                                            </div>
                                            <div class="col-md-5 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <datepicker :placeholder="'Plih Tanggal Transaksi'" :name="'tanggal_transaksi'" :id="'tanggal_transaksi'" :disabled="state == 'update'"></datepicker>
                                            </div>

                                            <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: help;" title="Bulan Yang Dipilih Untuk Tanggal Ini Juga Digunakan Sebagai Parameter Pencarian"> 
                                              <i class="fa fa-exclamation-circle"></i>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Nama Transaksi</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3">
                                                <input type="text" name="nama_transaksi" class="form-control" placeholder="Nama Transaksi" v-model="single_data.nama_transaksi" required>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Keterangan</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3">
                                                <input type="text" name="keterangan" class="form-control" placeholder="Masukkan Keterangan Transaksi" v-model="single_data.keterangan" required>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Pilih Akun Memorial</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3">
                                                <chosen :name="'perkiraan'" :option="akun_perkiraan" :id="'akun_perkiraan'"></chosen>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Nominal Transaksi</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3">
                                                <inputmask :name="'nominal'" :id="'nominal'"></inputmask>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="col-md-5 col-md-offset-1" style="background: white; padding: 10px;">
                                          <div class="row">
                                            <div class="col-md-4 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Akun Lawan</label>
                                            </div>
                                            <div class="col-md-8 col-sm-9 col-xs-12 mb-3">
                                                <chosen :name="'akun_lawan'" :option="akun_lawan" :id="'akun_lawan'"></chosen>
                                            </div>
                                          </div>
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
                      <b>List Data Transaksi</b>
                    </div>

                    <div class="col-md-3 text-right" style="background: white; color: #ff4444; padding: 15px 20px; border-bottom: 1px solid #aaa; font-size: 12pt;">
                      <i class="fa fa-times" style="cursor: pointer;" @click="close_list" title="Tutup Jendela"></i>
                    </div>

                    <div class="col-md-12" style="background: white; color: #3e3e3e; padding-top: 10px;">
                      <data-list :data_resource="list_transaksi" :columns="data_table_columns" :selectable="true" :ajax_on_loading="on_ajax_loading" @selected="get_data" :index_column="'id_transaksi'"></data-list>
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
    <input type="text" :name="name" class="form-control text-right" :id="id" required>
  </script>

  <script type="text/x-template" id="choosen-template">
    <select class="form-control" :name="name" :id="id">
      <option value="cek" v-for="(n, idx) in option" :value="n.id_akun">@{{ n.id_akun+' - '+n.nama_akun }}</option>
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
            nama_transaksi : {
              validators : {
                notEmpty : {
                  message : 'Nama Transaksi Tidak Boleh Kosong',
                }
              }
            },

            tanggal_transaksi : {
              validators : {
                notEmpty : {
                  message : 'Tanggal Transaksi Tidak Boleh Kosong',
                }
              }
            },

            keterangan : {
              validators : {
                notEmpty : {
                  message : 'Keterangan Transaksi Tidak Boleh Kosong',
                }
              }
            },

            nominal : {
              validators : {
                notEmpty : {
                  message : 'Nominal Harus Lebih Besar Dari 0',
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
      props: ['placeholder', 'name', 'id'],
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

    Vue.component('chosen', {
      props: ['option', 'name', 'id'],
      template: '#choosen-template',
      mounted: function(){
        var vm = this;
        $(this.$el).select2();
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

        akun_perkiraan: [],
        akun_lawan: [],
        list_transaksi: [],
        data_table_columns: [],

        single_data: {

          id_transaksi      : '',
          jenis_transaksi   : 'MD',
          tanggal_transaksi : '',
          nama_transaksi    : '',
          keterangan        : '',
          akun_perkiraan    : '',
          nominal           : '',
          akun_lawan        : '',

        },
      },

      mounted: function(){
        register_validator();
        $('.overlay.main').fadeIn(200);
        $('#load-status-text').text('Harap Tunggu. Sedang Menyiapkan Form');  
      },

      created: function(){
        axios.get(this.baseUrl+'/keuangan/p_inputtransaksi/transaksi_memorial/form-resource')
              .then((response) => {
                console.log(response.data);
                this.akun_perkiraan = response.data.akun_perkiraan;
                this.akun_lawan = response.data.akun_lawan;

                $('#tanggal_transaksi').val('{{ date('d-m-Y') }}');
                $('.overlay.main').fadeOut(200);

              }).catch(err => {
                 $('#load-status-text').text('Sistem Bermasalah. Cobalah Memuat Ulang Halaman');
              }).then(() => {
                $('#overlay-transaksi').fadeIn(200);
              })
      },

      methods: {
        simpan_data: function(evt){
          evt.preventDefault();
          this.btn_save_disabled = true;

          if($('#data-form').data('bootstrapValidator').validate().isValid()){
            axios.post(this.baseUrl+'/keuangan/p_inputtransaksi/transaksi_memorial/save', 
              $('#data-form').serialize()
            ).then((response) => {
              console.log(response.data);
              if(response.data.status == 'berhasil'){
                $.toast({
                    text: 'Data Transaksi Kas Anda Berhasil Disimpan.',
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
          evt.preventDefault();
          this.btn_save_disabled = true;

          if($('#data-form').data('bootstrapValidator').validate().isValid()){
            axios.post(this.baseUrl+'/keuangan/p_inputtransaksi/transaksi_memorial/update', 
              $('#data-form').serialize()
            ).then((response) => {
              console.log(response.data);
              if(response.data.status == 'berhasil'){
                $.toast({
                    text: 'Data Transaksi Kas Anda Berhasil Diupdate.',
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

        hapus: function(){
          let confirmed = confirm('Apakah Anda Yakin .. ?');

          if(confirmed){
            this.btn_save_disabled = true;

            axios.post(this.baseUrl+'/keuangan/p_inputtransaksi/transaksi_memorial/delete', 
              {id: this.single_data.id_transaksi}
            ).then((response) => {
              console.log(response.data);
              if(response.data.status == 'berhasil'){
                $.toast({
                    text: 'Data Transaksi Kas Anda Berhasil Dihapus.',
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
          }
        },

        get_data: function(val){
          let idx = this.list_transaksi.findIndex(e => e.id_transaksi === val);
          this.single_data.id_transaksi      = this.list_transaksi[idx].id_transaksi;
          this.single_data.jenis_transaksi   = this.list_transaksi[idx].no_bukti.substring(1,3);
          this.single_data.nama_transaksi    = this.list_transaksi[idx].nama_transaksi;
          this.single_data.keterangan        = this.list_transaksi[idx].keterangan;
          this.single_data.nominal           = this.list_transaksi[idx].nominal;

          // alert(this.list_transaksi[idx].jurnal.detail[0].jrdt_acc);

          $('#nominal').val(this.list_transaksi[idx].nominal);
          $('#akun_perkiraan').val(this.list_transaksi[idx].jurnal.detail[0].jrdt_acc);
          $('#akun_lawan').val(this.list_transaksi[idx].jurnal.detail[1].jrdt_acc);


          this.state = "update";
          $(".overlay.transaksi_list").fadeOut(200);
        },

        close_list: function(){
          $(".overlay.transaksi_list").fadeOut(200);
        },

        open_list: function(){
          this.data_table_columns = [
            {name: 'No Bukti', context: 'no_bukti', width: '20%', childStyle: 'text-align: center'},
            {name: 'Tgl. Transaksi', context: 'tanggal_transaksi', width: '15%', childStyle: 'text-align: center'},
            {name: 'Nama Transaksi', context: 'nama_transaksi', width: '40%', childStyle: 'text-align: center'},
            {name: 'Nominal', context: 'nominal', width: '35%', childStyle: 'text-align: right', override: function(el){
                var bilangan = el.toString();
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
            }},
          ];
          
          $('.overlay.transaksi_list').fadeIn(200);
          this.list_transaksi = [];
          this.on_ajax_loading = true;

          axios.get(this.baseUrl+'/keuangan/p_inputtransaksi/transaksi_memorial/list_transaksi?tgl='+$('#tanggal_transaksi').val()+'&idx='+this.single_data.jenis_transaksi)
                  .then((response) => {
                    // console.log(response.data);
                    this.list_transaksi = response.data;
                    this.on_ajax_loading = false;
                  }).catch((err) => {
                    alert(err);
                  })
        },

        form_reset: function(){
            this.single_data.id_transaksi = '';
            this.single_data.jenis_transaksi   = 'MD';
            this.single_data.nama_transaksi    = '';
            this.single_data.keterangan        = '';
            this.single_data.nominal           = '';
            this.state = 'simpan';

            $('#tanggal_transaksi').val('{{ date('d-m-Y') }}');
            $('#nominal').val('');
            $('#akun_lawan').val(this.akun_lawan[0].id_akun);
            $('#akun_perkiraan').val(this.akun_perkiraan[0].id_akun);
        }
      }

    })

  </script>
@endsection                            
