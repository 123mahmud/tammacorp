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
                        <div class="page-title">Form Input Data Penerimaan Piutang Customer</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li> &nbsp;Keuangan&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
                        <li class="active">Input Penerimaan Piutang Customer</li>
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
                                     <h4>Transaksi Penerimaan Piutang Customer</h4>
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
                                              <label class="tebal">Nomor Nota Pelunasan</label>
                                            </div>
                                            <div class="col-md-5 col-sm-8 col-xs-11 mb-3">
                                              <input type="text" name="nomor_nota" class="form-control" readonly style="cursor: pointer;" placeholder="Di Isi Oleh Sistem" v-model="single_data.nomor_nota">
                                            </div>

                                            <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: pointer;" title="Lakukan Pencarian Berdasarkan Supplier dan Bulan (dari tanggal yang dipilih)"> 
                                              <i class="fa fa-search" @click="open_list"></i>
                                            </div>

                                            <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: pointer;" title="Bersihkan Form"> 
                                              <i class="fa fa-times" v-if="state == 'update'" @click="form_reset"></i>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Pilih Customer</label>
                                            </div>
                                            <div class="col-md-6 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <select class="form-control" name="supplier" v-model="single_data.supplier" id="supplier" :disabled="state == 'update'">
                                                  <option :value="supplier.c_id" v-for="supplier in suppliers" v-html="supplier.c_name"></option>
                                                </select>
                                            </div>

                                            <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: help;" title="Customer Yang Dipilih Juga Digunakan Sebagai Parameter Pencarian"> 
                                              <i class="fa fa-exclamation-circle"></i>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Tanggal Pembayaran</label>
                                            </div>
                                            <div class="col-md-6 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <datepicker :placeholder="'Plih Tanggal Pembayaran'" :name="'tanggal_pembayaran'" :id="'tanggal_pembayaran'" :disabled="state == 'update'"></datepicker>
                                            </div>

                                            <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: help;" title="Bulan Yang Dipilih Untuk Tanggal Ini Juga Digunakan Sebagai Parameter Pencarian"> 
                                              <i class="fa fa-exclamation-circle"></i>
                                            </div>
                                          </div>

                                          <div class="row">
                                            <div class="col-md-5 col-sm-3 col-xs-12 mb-3"> 
                                              <label class="tebal">Nota Transaksi</label>
                                            </div>
                                            <div class="col-md-7 col-sm-9 col-xs-12 mb-3" style="background:;">
                                                <input type="text" name="nomor_po" class="form-control" placeholder="Pilih Nota Transaksi" readonly style="cursor: pointer;" @click="get_po" id="nomor_po" v-model="single_data.nomor_po" required>
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
                                              <label class="tebal">Jenis Penerimaan</label>
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
                                              <label class="tebal">Nominal Penerimaan</label>
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
                    <div class="col-md-9" style="background: white; color: rgba(0,0,0,0.5); padding: 15px 20px; border-bottom: 1px solid #aaa; font-size: 12pt;">
                      <b>List Data Pelunasan Piutang Dari @{{ nama_supplier }}</b>
                    </div>

                    <div class="col-md-3 text-right" style="background: white; color: #ff4444; padding: 15px 20px; border-bottom: 1px solid #aaa; font-size: 12pt;">
                      <i class="fa fa-times" style="cursor: pointer;" @click="close_list" title="Tutup Jendela"></i>
                    </div>

                    <div class="col-md-12" style="background: white; color: #3e3e3e; padding-top: 10px;">
                      <data-list :data_resource="data_table_resource" :columns="data_table_columns" :selectable="true" :ajax_on_loading="on_ajax_loading" @selected="get_data_pembayaran" :index_column="'payment_id'"></data-list>
                    </div>
                  </div>
                </div>

                <div class="overlay data_po">
                  <div class="content-loader" style="background: none; width:60%; margin: 3em auto; color: #eee;">
                    <div class="col-md-9" style="background: white; color: rgba(0,0,0,0.5); padding: 15px 20px; border-bottom: 1px solid #aaa; font-size: 12pt;">
                      <b>List Data Transaksi Hutang @{{ nama_supplier }}</b>
                    </div>

                    <div class="col-md-3 text-right" style="background: white; color: #ff4444; padding: 15px 20px; border-bottom: 1px solid #aaa; font-size: 12pt;">
                      <i class="fa fa-times" style="cursor: pointer;" @click="close_list" title="Tutup Jendela"></i>
                    </div>

                    <div class="col-md-12" style="background: white; color: #3e3e3e; padding-top: 10px;">
                      <data-list :data_resource="data_table_resource" :columns="data_table_columns" :selectable="true" :ajax_on_loading="on_ajax_loading" @selected="get_data_po" :index_column="'d_pcs_id'"></data-list>
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
    
    var vm = new Vue({

      el: '#vue-element',
      data: {
        baseUrl: '{{ url('/') }}',
        btn_save_disabled: false,
        state: 'simpan',
        on_ajax_loading: false,

        data_table_resource: [],
        data_table_columns: [],

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
        // $('.overlay.transaksi_list').fadeIn(200);
        $('#load-status-text').text('Harap Tunggu. Sedang Menyiapkan Form');  
      },

      created: function(){
        axios.get(this.baseUrl+'/penjualan/penerimaan_piutang/form-resource')
              .then((response) => {
                console.log(response.data);

                if(response.data.supplier.length > 0){
                  this.suppliers = response.data.supplier;
                  this.single_data.supplier = response.data.supplier[0].c_id;
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
                // $('#supplier').select2();
                $('.overlay.main').fadeOut(200);
                $('#tanggal_pembayaran').val('{{ date('d-m-Y') }}')
              }).catch(err => {
                 $('#load-status-text').text('Sistem Bermasalah. Cobalah Memuat Ulang Halaman');
              }).then(() => {
                $('#overlay-transaksi').fadeIn(200);
              })
      },

      computed: {
        nama_supplier: function(){
          var idx = this.suppliers.findIndex(x => x.c_id === this.single_data.supplier);
          return (idx >= 0) ? this.suppliers[idx].c_name : '';
        },
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

          this.data_table_columns = [
            {name: 'No.Transaksi', context: 'payment_code', width: '20%', childStyle: 'text-align: center'},
            {name: 'No.Purchase', context: 'd_pcs_code', width: '20%', childStyle: 'text-align: center'},
            {name: 'Tgl. Dibayarkan', context: 'd_pcs_date_created', width: '15%', childStyle: 'text-align: center'},
            {name: 'Jenis', context: 'd_pcs_method', width: '15%', childStyle: 'text-align: center'},
            {name: 'Total Pembayaran', context: 'payment_value', width: '30%', childStyle: 'text-align: right', override: function(el){
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
          this.on_ajax_loading = true;
          this.data_table_resource = [];

          axios.get(this.baseUrl+'/purchasing/pembayaran_hutang/get-transaksi?sp='+this.single_data.supplier+'&tgl='+$('#tanggal_pembayaran').val())
                  .then((response) => {
                    // console.log(response.data);
                    this.data_table_resource = response.data;
                    this.on_ajax_loading = false;
                  }).catch((err) => {
                    alert(err);
                  })
        },

        get_po: function(){

          if(this.state == 'update'){
            return false;
          }

          this.data_table_columns = [
            {name: 'No.Purchase', context: 'd_pcs_code', width: '15%', childStyle: 'text-align: center'},
            {name: 'Tgl. Transaksi', context: 'd_pcs_date_created', width: '15%', childStyle: 'text-align: center'},
            {name: 'Jenis', context: 'd_pcs_method', width: '10%', childStyle: 'text-align: center'},
            {name: 'Total Tagihan', context: 'd_pcs_total_net', width: '20%', childStyle: 'text-align: right', override: function(el){
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
            {name: 'Sudah Dibayar', context: 'd_pcs_payment', width: '20%', childStyle: 'text-align: right', override: function(el){
                var bilangan = el;
                var commas = bilangan.split('.')[1];var bilangan = el.toString();
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
            {name: 'Sisa Pelunasan', context: 'd_pcs_sisapayment', width: '20%', childStyle: 'text-align: right', override: function(el){
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

          $('.overlay.data_po').fadeIn(200);
          this.on_ajax_loading = true;
          this.data_table_resource = [];

          axios.get(this.baseUrl+'/purchasing/pembayaran_hutang/get-po?supplier='+this.single_data.supplier)
                  .then((response) => {
                    console.log(response.data);
                    this.data_table_resource = response.data;
                    this.on_ajax_loading = false;
                  }).catch((err) => {
                    alert(err);
                  })
        },

        get_data_po: function(alpha){
          let idx = this.data_table_resource.findIndex(e => e.d_pcs_id == alpha);

          this.single_data.nomor_po = this.data_table_resource[idx].d_pcs_code;
          $('#total_tagihan').val(this.data_table_resource[idx].d_pcs_total_net);
          $('#sudah_dibayar').val(this.data_table_resource[idx].d_pcs_payment);
          $('#sisa_tagihan').val(this.data_table_resource[idx].d_pcs_total_net - this.data_table_resource[idx].d_pcs_payment); 
          $('#data-form').data('bootstrapValidator').resetForm();

          $('.overlay.data_po').fadeOut(200);
        },

        get_data_pembayaran: function(alpha){
          let idx = this.data_table_resource.findIndex(e => e.payment_id == alpha);

          this.single_data.nomor_nota = this.data_table_resource[idx].payment_code;
          this.single_data.supplier = this.data_table_resource[idx].s_id;
          this.single_data.nomor_po = this.data_table_resource[idx].payment_po;
          this.single_data.keterangan = this.data_table_resource[idx].payment_keterangan;
          this.single_data.jenis = (this.data_table_resource[idx].payment_type  == "CASH") ? 'C' : 'T';

          $('#tanggal_pembayaran').val(this.data_table_resource[idx].payment_date.split('-')[2]+'-'+this.data_table_resource[idx].payment_date.split('-')[1]+'-'+this.data_table_resource[idx].payment_date.split('-')[0])

          $('#nominal_pembayaran').val(this.data_table_resource[idx].payment_value);
          $('#total_tagihan').val(this.data_table_resource[idx].d_pcs_total_net);
          $('#sudah_dibayar').val(this.data_table_resource[idx].d_pcs_payment);
          $('#sisa_tagihan').val(this.data_table_resource[idx].d_pcs_total_net - this.data_table_resource[idx].d_pcs_payment); 
          $('#data-form').data('bootstrapValidator').resetForm();

          this.state = 'update';

          $('.overlay.transaksi_list').fadeOut(200);
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
