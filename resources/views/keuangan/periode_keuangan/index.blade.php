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
<div id="vue-element">
<div id="page-wrapper">
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
            <div class="page-title">Bulan Finansial</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><i></i>&nbsp;System&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Bulan Finansial</li>
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
              <li class="active"><a href="#alert-tab" data-toggle="tab">Data Bulan Finansial</a></li>
            </ul>
            
            <div id="generalTabContent" class="tab-content responsive">

              <div id="alert-tab" class="tab-pane fade in active" style="padding: 20px;">
                <div class="row" style="margin-top:-20px;">
                  <div class="col-md-5" style="background: none; padding: 0px 10px 0px 0px;">
                    <form id="data-form">
                      <input type="hidden" value="{{csrf_token()}}" name="_token" readonly>

                      <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg" style="margin-bottom: 15px; padding-top:10px; border-radius: 0px;">

                        <div class="row" style="padding: 0px 10px;">
                          <div class="col-md-12 col-sm-3 col-xs-12 text-center" style="border-bottom: 1px solid #ccc;"> 
                            <label class="tebal">Tambah Data Periode</label>
                          </div>
                        </div>

                        <div class="row" style="margin-top: 15px;">
                          <div class="col-md-5 col-sm-3 col-xs-12"> 
                            <label class="tebal">Bulan Periode</label>
                          </div>
                          <div class="col-md-5 col-sm-8 col-xs-11 mb-3">
                            <datepicker :placeholder="'Plih Bulan Periode'" :name="'bulan_periode'" :id="'bulan_periode'" :disabled="state == 'update'" :required="true" @input="changeDate"></datepicker>
                          </div>

                          <div class="col-md-1" style="background: none; padding: 8px 0px; cursor: pointer;" title="Bersihkan Form"> 
                            <i class="fa fa-times" v-if="state == 'update'" @click="form_reset"></i>
                          </div>
                        </div>

                        <div class="row" style="margin-top: 15px; border-bottom: 1px solid #ccc; padding-bottom: 15px;">
                          <div class="col-md-5 col-sm-3 col-xs-12"> 
                            <label class="tebal">Status Periode</label>
                          </div>
                          <div class="col-md-7 col-sm-8 col-xs-11 mb-3">
                            <select class="form-control" v-model="single_data.status" name="status_periode">
                              <option value="1">Aktif</option>
                              <option value="0">Non Aktif</option>
                            </select>
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

                  <div class="col-md-7" style="background: white; padding: 0px 0px 0px 20">
                    <data-list :data_resource="data_table" :columns="column" :selectable="true" :ajax_on_loading="on_ajax_loading" @selected="getPeriode" :index_column="'pk_id'"></data-list>
                  </div>
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

  <script type="text/x-template" id="datepicker-template">
    <input type="text" :name="name" :placeholder="placeholder" class="form-control" style="width:100%; cursor: pointer;" :id="id" required>
  </script>
  
  <script src="{{ asset("js/vue/vue.js") }}"></script>
  <script src="{{ asset("js/vue/vue-datatable.js") }}"></script>
  <script src="{{ asset("js/datepicker/datepicker.js") }}"></script>
  <script src="{{ asset("js/axios/dist/axios.min.js") }}"></script>
  <script src="{{ asset("js/toast/dist/jquery.toast.min.js") }}"></script>
  <script src="{{ asset("js/validator/bootstrapValidator.min.js") }}"></script>

  <script type="text/javascript">
    
      function register_validator(){
        $('#data-form').bootstrapValidator({
            feedbackIcons : {
              valid : 'glyphicon glyphicon-ok',
              invalid : 'glyphicon glyphicon-remove',
              validating : 'glyphicon glyphicon-refresh'
            },
            fields : {
              bulan_periode : {
                validators : {
                  notEmpty : {
                    message : 'Bulan Tidak Boleh Kosong',
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

      var vm = new Vue({

        el: '#vue-element',
        data: {
          baseUrl: '{{ url('/') }}',
          btn_save_disabled: false,
          state: 'simpan',
          on_ajax_loading: false,

          data_table: [],
          column: [],

          single_data: {
            status: '1',
            bulan: '',
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
          axios.get(this.baseUrl+'/system/periode_keuangan/list-periode')
                .then((response) => {
                  console.log(response.data);

                  this.data_table = response.data;
                  this.column = [
                      {name: 'Periode Keuangan', context: 'pk_periode', width: '15%', childStyle: 'text-align: center', override: function(e){
                        return e.split('-')[1]+' / '+e.split('-')[0];
                      }},
                      {name: 'Status Periode', context: 'pk_status', width: '15%', childStyle: 'text-align: center', override: function(e){
                        return (e == 1) ? 'Aktif' : 'Non Aktif';
                      }},
                  ];

                  // console.log(this.data);
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
                axios.post(this.baseUrl+'/system/periode_keuangan/list-periode/store', 
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

                      // alert(response.data.context);

                      // if(response.data.context.length > 0)
                        this.data_table.unshift(response.data.context);

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

          update: function(){
            alert('update')
          },

          hapus: function(){
            alert('hapus')
          },

          changeDate: function(e){
            this.single_data.tanggal_beli = e;
            $('#data-form').data('bootstrapValidator').resetForm();
          },

          getPeriode: function(e){
            var idx = this.data_table.findIndex(a => a.pk_id === e);
            var data = this.data_table[idx];
            var bulan = data.pk_periode.split('-')[1]+'-'+data.pk_periode.split('-')[0];

            this.single_data.status = data.pk_status;
            this.single_data.bulan = bulan;
            $('#bulan_periode').val(bulan);
            $('#data-form').data('bootstrapValidator').resetForm();
            this.state = 'update';

          },

          form_reset: function(){
            this.state = 'simpan';
            this.single_data.bulan = '';
            this.single_data.status = '1';

            $('#bulan_periode').val('');
            $('#data-form').data('bootstrapValidator').resetForm();
          }
        }

      })
    
  </script>
@endsection