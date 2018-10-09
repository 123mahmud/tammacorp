@extends('main') 
@section('content')
<!--BEGIN PAGE WRAPPER-->
<div id="page-wrapper">
  <!--BEGIN TITLE & BREADCRUMB PAGE-->
  <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left" style="font-family: 'Raleway', sans-serif;">
      <div class="page-title">Setting Tunjangan Pegawai Manajemen</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right" style="font-family: 'Raleway', sans-serif;">
      <li>
        <i class="fa fa-home"></i>&nbsp;
        <a href="{{ url('/home') }}">Home</a>&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li>
        <i></i>&nbsp;HRD&nbsp;&nbsp;
        <i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
      <li class="active">Setting Tunjangan Pegawai Manajemen</li>
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
              <a href="#alert-tab" data-toggle="tab">Setting Tunjangan Pegawai Manajemen</a>
            </li>
          </ul>
          <div id="generalTabContent" class="tab-content responsive">
            <div id="alert-tab" class="tab-pane fade in active">
              <div class="row">
                <div class="col-md-12">
                  <div class="row">
                    <div class="panel-body">
                      <div class="row" style="margin-top:-20px;">
                        <div class="col-lg-12">
                          <div class="pull-right" style="margin-bottom: 10px;">
                            <a href="{{ url('hrd/payroll/setting-gaji') }}" class="btn btn-box-tool"><i class="fa fa-arrow-left"></i>
                            Kembali</a>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="table-responsive">
                              <table id="tbl_tunjangan_pegman" class="table tabelan table-hover table-bordered" width="100%" cellspacing="0">
                                <thead>
                                  <tr>
                                    <th class="wd-15p">id</th>
                                    <th class="wd-15p">Nama</th>
                                    <th class="wd-15p">NIP</th>
                                    <th class="wd-15p">Divisi</th>
                                    <th class="wd-15p">Jabatan</th>
                                    <th class="wd-15p">Tunjangan</th>
                                    <th class="wd-15p">Aksi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- End DIv note-tab -->
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
@section('extra_scripts')
<script src="{{ asset ('assets/script/icheck.min.js') }}"></script>
<script src="{{ asset("js/inputmask/inputmask.jquery.js") }}"></script>
<script type="text/javascript">
  $(document).ready(function() { 
    var extensions = {
      "sFilterInput": "form-control input-sm",
      "sLengthSelect": "form-control input-sm"
    }
    // Used when bJQueryUI is false
    $.extend($.fn.dataTableExt.oStdClasses, extensions);
    // Used when bJQueryUI is true
    $.extend($.fn.dataTableExt.oJUIClasses, extensions)
    //mask money
    $.fn.maskFunc = function(){
      $('.currency').inputmask("currency", {
        radixPoint: ",",
        groupSeparator: ".",
        digits: 2,
        autoGroup: true,
        prefix: '', //Space after $, this will not truncate the first character.
        rightAlign: false,
        oncleared: function () { self.Value(''); }
      });
    }

    $(this).maskFunc();

    $('#tbl_tunjangan_pegman').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: '{{ url("hrd/payroll/datatable-tunjangan-pegman") }}',
      },
      columnDefs: [
        {
          targets: 0,
          className: 'center d_id'
        },
        {
          targets: 6,
          className: 'center'
        },
      ],
      "columns": [
        { "data": "c_id", "width" : "5%" },
        { "data": "c_nama", "width" : "15%" },
        { "data": "c_nik", "width" : "10%" },
        { "data": "c_divisi", "width" : "15%" },
        { "data": "c_posisi", "width" : "20%" },
        { "data": "tunjangan", "width" : "20%" },
        { "data": "action", orderable: false, searchable: false, "width" : "5%" },
      ],
      "responsive": true,

      "pageLength": 10,
      "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
      "language": {
        "searchPlaceholder": "Cari Data",
        "emptyTable": "Tidak ada data",
        "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
        "sSearch": '<i class="fa fa-search"></i>',
        "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
        "infoEmpty": "",
        "paginate": {
          "previous": "Sebelumnya",
          "next": "Selanjutnya",
        }
      }
    });

  }); 

  function batal() {
    $('#form_tunjangan')[0].reset();
  }

  // function edit_t_pegman(id) 
  // {
  //   $.ajax({
  //     url : baseUrl + "/hrd/payroll/edit-tunjangan-pegman/"+id,
  //     type: "PUT",
  //     dataType: "JSON",
  //     success: function(response)
  //     {
  //     },
  //     complete: function (argument) {
  //       window.location = (this.url)
  //     },
  //     error: function (jqXHR, textStatus, errorThrown)
  //     {
  //         alert('Terjadi Kesalahan');
  //     }
  //   });
  // }

  function edit_t_pegman(a) {
    var parent = $(a).parents('tr');
    var id = $(parent).find('.d_id').text();
    $.ajax({
      type: "PUT",
      url : baseUrl + "/hrd/payroll/edit-tunjangan-pegman/"+a,
      data: { id },
      success: function (data) {
      },
      complete: function (argument) {
        window.location = (this.url)
      },
      error: function () {

      },
      async: false
    });
  }

  function randString(angka) 
  {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for (var i = 0; i < angka; i++)
      text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
  }
</script> 
@endsection