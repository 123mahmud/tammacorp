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
                        <div class="page-title">Form Input Data Pembuayaran Hutang Supplier</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li> &nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Input Pembuayaran Hutang Supplier</li>
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
                                     <h4>Transaksi Pembayaran Hutang Supplier</h4>
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
                                              <label class="tebal">Nomor Nota Pembayaran</label>
                                            </div>
                                            <div class="col-md-5 col-sm-8 col-xs-11 mb-3">
                                              <input type="text" name="nomor_nota" class="form-control" readonly style="cursor: pointer;" placeholder="Di Isi Oleh Sistem" v-model="single_data.nomor_nota">
                                            </div>

                                            <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: pointer;"> 
                                              <i class="fa fa-search" @click="open_list"></i>
                                            </div>

                                            <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: pointer;"> 
                                              <i class="fa fa-times" v-if="state == 'update'" @click="form_reset"></i>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Pilih Supplier</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <select class="form-control" name="supplier" v-model="single_data.supplier" id="supplier" :disabled="state == 'update'">
                                                  <option :value="supplier.s_id" v-for="supplier in suppliers" v-html="supplier.s_company"></option>
                                                </select>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Tanggal Pembayaran</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <datepicker :placeholder="'Plih Tanggal Pembayaran'" :name="'tanggal_pembayaran'" :id="'tanggal_pembayaran'" :disabled="state == 'update'"></datepicker>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Nomor P.O</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <input type="text" name="nomor_po" class="form-control" placeholder="Pilih Nomor P.O" readonly style="cursor: pointer;" @click="get_po" id="nomor_po" v-model="single_data.nomor_po" required>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Keterangan</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <input type="text" name="keterangan_pembayaran" id="keterangan_pembayaran" placeholder="Tulis Keterangan" class="form-control" v-model="single_data.keterangan" required>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Jenis Pembayaran</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <select class="form-control" name="jenis_pembayaran" id="jenis_pembayaran" v-model="single_data.jenis">
                                                  <option value="C">Tunai</option>
                                                  <option value="T">Transfer</option>
                                                </select>
                                            </div>
                                          </div>

                                          <div class="row" v-if="single_data.jenis == 'C'">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Pilih Akun Kas</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <select class="form-control" name="akun_kas" id="akun_kas" v-model="single_data.akun_kas">
                                                  <option :value="kas.id_akun" v-for="kas in akun_kas">@{{ kas.nama_akun }}</option>
                                                </select>
                                            </div>
                                          </div>

                                          <div class="row" v-if="single_data.jenis == 'T'">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Pilih Akun Bank</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <select class="form-control" name="akun_bank" id="akun_bank" v-model="single_data.akun_bank">
                                                  <option :value="kas.id_akun" v-for="kas in akun_bank">@{{ kas.nama_akun }}</option>
                                                </select>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Nominal Pembayaran</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <inputmask :name="'nominal_pembayaran'" :id="'nominal_pembayaran'" :required="true" :readonly="false"></inputmask>
                                            </div>
                                          </div>
                                        </div>

                                        <div class="col-md-5 col-md-offset-1" style="background: white; padding: 10px;">
                                          <div class="row">
                                            <div class="col-md-4 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Total Tagihan</label>
                                            </div>
                                            <div class="col-md-8 col-sm-9 col-xs-12 mb-3">
                                                <inputmask :name="'total_tagihan'" :id="'total_tagihan'" :required="false" :readonly="true"></inputmask>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-4 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Sudah Dibayar</label>
                                            </div>
                                            <div class="col-md-8 col-sm-9 col-xs-12 mb-3">
                                                <inputmask :name="'sudah_dibayar'" :id="'sudah_dibayar'" :required="false" :readonly="true"></inputmask>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-4 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Sisa Tagihan</label>
                                            </div>
                                            <div class="col-md-8 col-sm-9 col-xs-12 mb-3">
                                                <inputmask :name="'sisa_tagihan'" :id="'sisa_tagihan'" :required="false" :readonly="true"></inputmask>
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
                    <div class="col-md-9" style="background: white; color: #3e3e3e; padding: 10px; border-bottom: 1px solid #ccc;">
                      <h5>List Data Pembayaran</h5>
                    </div>

                    <div class="col-md-3 text-right" style="background: white; color: #3e3e3e; padding: 10px; border-bottom: 1px solid #ccc;">
                      <h5><i class="fa fa-times" style="cursor: pointer;" @click="close_list"></i></h5>
                    </div>

                    <div class="col-md-12" style="background: white; color: #3e3e3e; padding-top: 10px;">
                      <xyz :data="list_transaksi" @get_data="get_data_pembayaran" :ajax_loading="on_ajax_loading" :sts_null="'Tidak Ada Transaksi Pembayaran Pada Supplier Yang Dipilih..'"></xyz>
                    </div>
                  </div>
                </div>

                <div class="overlay data_po">
                  <div class="content-loader" style="background: none; width:60%; margin: 3em auto; color: #eee;">
                    <div class="col-md-9" style="background: white; color: #3e3e3e; padding: 10px; border-bottom: 1px solid #ccc;">
                      <h5>List Data Purchase Order (P.O)</h5>
                    </div>

                    <div class="col-md-3 text-right" style="background: white; color: #3e3e3e; padding: 10px; border-bottom: 1px solid #ccc;">
                      <h5><i class="fa fa-times" style="cursor: pointer;" @click="close_list"></i></h5>
                    </div>

                    <div class="col-md-12" style="background: white; color: #3e3e3e; padding-top: 10px;">
                      <table-po :data="list_purchase" @get_data="get_data_po" :ajax_loading="on_ajax_loading" :sts_null="'Tidak Ada P.O Yang Belum Lunas Untuk Supplier Yang Dipilih..'"></table-po>
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
  <script src="{{ asset("js/axios/dist/axios.min.js") }}"></script>
  <script src="{{ asset("js/validator/bootstrapValidator.min.js") }}"></script>
  <script src="{{ asset("js/toast/dist/jquery.toast.min.js") }}"></script>

  <script type="text/x-template" id="datepicker-template">
    <input type="text" :name="name" :placeholder="placeholder" class="form-control" style="width:100%; cursor: pointer;" :id="id" required>
  </script>

  <script type="text/x-template" id="inputmask-template">
    <input type="text" :name="name" class="form-control text-right" :id="id" :required="required" :readonly="readonly">
  </script>

  <script type="text/x-template" id="choosen-template">
    <select class="form-control" :name="name" :id="id">
      <option value="cek" v-for="(n, idx) in option" :value="n.id_akun">@{{ n.id_akun+' - '+n.nama_akun }}</option>
    </select>
  </script>

  <script type="text/x-template" id="table-template">
      <table class="table table-striped table-bordered" style="font-size: 0.85em;">
        <thead>
          <tr>
            <th width="25%" class="text-center">No.Pembayaran</th>
            <th width="15%" class="text-center">Nomor P.O</th>
            <th class="text-center">Tanggal Pembayaran</th>
            <th class="text-center">keterangan</th>
            <th width="25%" class="text-center">Nominal</th>
          </tr>
        </thead>

        <tbody>

            <tr v-if="ajax_loading">
              <td colspan="5" class="text-center">
                <i class="fa fa-clock-o fa-3x fa-fw"></i> &nbsp; Sedang Mencari Transaksi. Harap Tunggu..
                <span class="sr-only">Loading...</span>
              </td>
            </tr>

            <tr v-if="data.length == 0 && !ajax_loading">
              <td colspan="5" class="text-center">
                <i class="fa fa-frown-o fa-3x fa-fw"></i> &nbsp; @{{ sts_null }}
                <span class="sr-only">Loading...</span>
              </td>
            </tr>

            <tr v-for="transaksi in data">
              <td class="text-center" style="cursor:pointer" @click="get_data(transaksi.payment_id)">@{{ transaksi.payment_code }}</td>
              <td class="text-center">@{{ transaksi.payment_po }}</td>
              <td class="text-center">@{{ transaksi.payment_date }}</td>
              <td class="text-center">@{{ transaksi.payment_keterangan }}</td>
              <td class="text-center" v-html="humanizePrice(transaksi.payment_value)"></td>
            </tr>
        </tbody>
      </table>
  </script>

  <script type="text/x-template" id="table-po">
      <table class="table table-striped table-bordered" style="font-size: 0.85em;">
        <thead>
          <tr>
            <th width="25%" class="text-center">No.Purchase</th>
            <th width="15%" class="text-center">Tanggal Transaksi</th>
            <th width="15%" class="text-center">Jenis Tagihan</th>
            <th class="text-center">Total Tagihan</th>
          </tr>
        </thead>

        <tbody>

            <tr v-if="ajax_loading">
              <td colspan="4" class="text-center">
                <i class="fa fa-clock-o fa-3x fa-fw"></i> &nbsp; Sedang Mencari Transaksi. Harap Tunggu..
                <span class="sr-only">Loading...</span>
              </td>
            </tr>

            <tr v-if="data.length == 0 && !ajax_loading">
              <td colspan="4" class="text-center">
                <i class="fa fa-frown-o fa-3x fa-fw"></i> &nbsp; @{{ sts_null }}
                <span class="sr-only">Loading...</span>
              </td>
            </tr>

            <tr v-for="transaksi in data">
              <td class="text-center" style="cursor:pointer" @click="get_data(transaksi.d_pcs_id)">@{{ transaksi.d_pcs_code }}</td>
              <td class="text-center">@{{ transaksi.d_pcs_date_created }}</td>
              <td class="text-center">@{{ transaksi.d_pcs_method }}</td>
              <td class="text-center" v-html="humanizePrice(transaksi.d_pcs_total_net)"></td>
            </tr>
        </tbody>
      </table>
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
            supplier : {
              validators : {
                notEmpty : {
                  message : 'Pilih Supplier Terlebih Dahulu',
                }
              }
            },

            nomor_po : {
              validators : {
                notEmpty : {
                  message : 'Pilih Nomor P.O Terlebih Dahulu',
                }
              }
            },

            tanggal_pembayaran : {
              validators : {
                notEmpty : {
                  message : 'Tanggal Tidak Boleh kosong',
                }
              }
            },

            keterangan_pembayaran : {
              validators : {
                notEmpty : {
                  message : 'keterangan Tidak Boleh Kosong',
                }
              }
            },

            nominal_pembayaran : {
              validators : {
                notEmpty : {
                  message : 'Nominal Pembayaran Tidak Boleh Kosong',
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

    Vue.component('chosen', {
      props: ['option', 'name', 'id'],
      template: '#choosen-template',
      mounted: function(){
        var vm = this;
      },
      watch: {
        model: function(){
          // $(this.$el).val(this.model);
        }
      },
      destroyed: function () {
          
        }
    })

    Vue.component('xyz', {
      props: ['data', 'context', 'ajax_loading', 'sts_null'],
      template: '#table-template',
      mounted: function(){
        // console.log(this.data)
        // alert(this.ajax_loading);
      },

      watch: {
        data: function(){
          console.log(this.data);
        }
      },

      methods: {
        get_data: function(val){
          this.$emit('get_data', val);
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
      }
    })

    Vue.component('table-po', {
      props: ['data', 'context', 'ajax_loading', 'sts_null'],
      template: '#table-po',
      mounted: function(){
        // console.log(this.data)
        // alert(this.ajax_loading);
      },

      watch: {
        data: function(){
          console.log(this.data);
        }
      },

      methods: {
        get_data: function(val){
          this.$emit('get_data', val);
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
      }
    })
    
    var vm = new Vue({

      el: '#vue-element',
      data: {
        baseUrl: '{{ url('/') }}',
        btn_save_disabled: false,
        state: 'simpan',
        on_ajax_loading: false,

        list_purchase: [],
        list_transaksi: [],
        suppliers: [],
        akun_kas: [],
        akun_bank: [],

        single_data: {
            nomor_nota: '',
            supplier: '',
            nomor_po: '',
            keterangan: '',
            akun_kas: '',
            akun_bank: '',
            jenis: 'C',
        },
      },

      mounted: function(){
        register_validator();
        $('.overlay.main').fadeIn(200);
        $('#load-status-text').text('Harap Tunggu. Sedang Menyiapkan Form');  
      },

      created: function(){
        axios.get(this.baseUrl+'/purchasing/pembayaran_hutang/form-resource')
              .then((response) => {
                console.log(response.data);

                if(response.data.supplier.length > 0){
                  this.suppliers = response.data.supplier;
                  this.single_data.supplier = response.data.supplier[0].s_id;
                }

                if(response.data.akun_kas.length > 0){
                  this.akun_kas = response.data.akun_kas;
                  this.single_data.akun_kas = response.data.akun_kas[0].id_akun;
                }

                if(response.data.akun_bank.length > 0){
                  this.akun_bank = response.data.akun_bank;
                  this.single_data.akun_bank = response.data.akun_bank[0].id_akun;
                }

                // console.log(this.single_data.akun_kas);

                $('.overlay.main').fadeOut(200);
                $('#tanggal_pembayaran').val('{{ date('d-m-Y') }}')
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
          // this.form_reset();

          let nominal      = $('#nominal_pembayaran').val().split(',')[0].replace(/\./g, '');
          let sisa_tagihan = $('#sisa_tagihan').val().split(',')[0].replace(/\./g, '');

          // alert(parseInt(nominal) > parseInt(sisa_tagihan));

          if($('#data-form').data('bootstrapValidator').validate().isValid()){
            if(parseInt(nominal) > parseInt(sisa_tagihan)){
              alert('Jumlah Yang Anda Bayarkan Lebih Banyak Dari Sisa Tagihan Yang Ada.');
              this.btn_save_disabled = false;
              return false;
            }

            axios.post(this.baseUrl+'/purchasing/pembayaran_hutang/save', 
              $('#data-form').serialize()
            ).then((response) => {
              console.log(response.data);
              if(response.data.status == 'berhasil'){
                $.toast({
                    text: 'Data Pembayaran Hutang Berhasil Anda Berhasil Disimpan.',
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

          let nominal      = $('#nominal_pembayaran').val().split(',')[0].replace(/\./g, '');
          let sisa_tagihan = $('#total_tagihan').val().split(',')[0].replace(/\./g, '');

          if($('#data-form').data('bootstrapValidator').validate().isValid()){

            if(parseInt(nominal) > parseInt(sisa_tagihan)){
              alert('Jumlah Yang Anda Bayarkan Lebih Banyak Dari Total Tagihan Yang Ada.');
              this.btn_save_disabled = false;
              return false;
            }

            axios.post(this.baseUrl+'/purchasing/pembayaran_hutang/update', 
              $('#data-form').serialize()
            ).then((response) => {
              console.log(response.data);
              if(response.data.status == 'berhasil'){
                $.toast({
                    text: 'Data Pembayaran Hutang Anda Berhasil Diupdate.',
                    showHideTransition: 'slide',
                    position: 'top-right',
                    icon: 'success'
                })

                this.form_reset();
              }else if(response.data.status == 'not_exist'){
                $.toast({
                    text: 'Nomor Nota Tidak Bisa Ditemukan. :(',
                    showHideTransition: 'slide',
                    position: 'top-right',
                    hideAfter: false,
                    icon: 'error'
                })
              }else if(response.data.status == 'po_not_exist'){
                $.toast({
                    text: 'Nomor PO Tidak Bisa Ditemukan . Semua Nota Dengan Nomor P.O Tersebut Akan Dihapus. :(',
                    showHideTransition: 'slide',
                    position: 'top-right',
                    hideAfter: false,
                    icon: 'error'
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
          let confirmed = confirm('Apakah Anda Yakin .. ?');

          if(confirmed){
            this.btn_save_disabled = true;

            axios.post(this.baseUrl+'/purchasing/pembayaran_hutang/delete', 
              {id: this.single_data.nomor_nota}
            ).then((response) => {
              console.log(response.data);
              if(response.data.status == 'berhasil'){
                $.toast({
                    text: 'Data Pembayaran Hutang Anda Berhasil Dihapus.',
                    showHideTransition: 'slide',
                    position: 'top-right',
                    icon: 'success'
                })

                this.form_reset();
              }else if(response.data.status == 'not_exist'){
                $.toast({
                    text: 'Nomor Nota Tidak Bisa Ditemukan. :(',
                    showHideTransition: 'slide',
                    position: 'top-right',
                    hideAfter: false,
                    icon: 'error'
                })
              }
            }).catch((err) => {
              alert(err);
              this.btn_save_disabled = false;
            }).then(() => {
              this.btn_save_disabled = false;
            })
          }
        },

        close_list: function(){
          $(".overlay").fadeOut(200);
        },

        open_list: function(){
          $('.overlay.transaksi_list').fadeIn(200);
          this.list_transaksi = [];
          this.on_ajax_loading = true;

          axios.get(this.baseUrl+'/purchasing/pembayaran_hutang/get-transaksi?sp='+this.single_data.supplier+'&tgl='+$('#tanggal_pembayaran').val())
                  .then((response) => {
                    console.log(response.data);
                    this.list_transaksi = response.data;
                    this.on_ajax_loading = false;
                  }).catch((err) => {
                    alert(err);
                  })
        },

        get_po: function(){

          if(this.state == 'update'){
            return false;
          }

          $('.overlay.data_po').fadeIn(200);

          this.list_purchase = [];
          this.on_ajax_loading = true;

          axios.get(this.baseUrl+'/purchasing/pembayaran_hutang/get-po?supplier='+this.single_data.supplier)
                  .then((response) => {
                    console.log(response.data);
                    this.list_purchase = response.data;
                    this.on_ajax_loading = false;
                  }).catch((err) => {
                    alert(err);
                  })
        },

        get_data_po: function(alpha){
          let idx = this.list_purchase.findIndex(e => e.d_pcs_id == alpha);

          this.single_data.nomor_po = this.list_purchase[idx].d_pcs_code;
          $('#total_tagihan').val(this.list_purchase[idx].d_pcs_total_net);
          $('#sudah_dibayar').val(this.list_purchase[idx].d_pcs_payment);
          $('#sisa_tagihan').val(this.list_purchase[idx].d_pcs_total_net - this.list_purchase[idx].d_pcs_payment); 
          $('#data-form').data('bootstrapValidator').resetForm();

          $('.overlay.data_po').fadeOut(200);
        },

        get_data_pembayaran: function(alpha){
          let idx = this.list_transaksi.findIndex(e => e.payment_id == alpha);

          this.single_data.nomor_nota = this.list_transaksi[idx].payment_code;
          this.single_data.supplier = this.list_transaksi[idx].s_id;
          this.single_data.nomor_po = this.list_transaksi[idx].payment_po;
          this.single_data.keterangan = this.list_transaksi[idx].payment_keterangan;
          this.single_data.jenis = (this.list_transaksi[idx].payment_type  == "CASH") ? 'C' : 'T';

          $('#tanggal_pembayaran').val(this.list_transaksi[idx].payment_date.split('-')[2]+'-'+this.list_transaksi[idx].payment_date.split('-')[1]+'-'+this.list_transaksi[idx].payment_date.split('-')[0])

          $('#nominal_pembayaran').val(this.list_transaksi[idx].payment_value);
          $('#total_tagihan').val(this.list_transaksi[idx].d_pcs_total_net);
          $('#sudah_dibayar').val(this.list_transaksi[idx].d_pcs_payment);
          $('#sisa_tagihan').val(this.list_transaksi[idx].d_pcs_total_net - this.list_transaksi[idx].d_pcs_payment); 
          $('#data-form').data('bootstrapValidator').resetForm();

          this.state = 'update';

          $('.overlay.transaksi_list').fadeOut(200);
        },

        form_reset: function(){
            this.state = 'simpan';
            this.single_data.nomor_nota = '';
            this.single_data.supplier = this.suppliers[0].s_id;
            this.single_data.nomor_po = '';
            this.single_data.keterangan = '';
            this.single_data.jenis = 'C';

            $('#tanggal_pembayaran').val('{{ date('d-m-Y') }}');
            $('#nominal_pembayaran').val('');
            $('#total_tagihan').val('');
            $('#sudah_dibayar').val('');
            $('#sisa_tagihan').val('');
        }
      }

    })

  </script>
@endsection                            
