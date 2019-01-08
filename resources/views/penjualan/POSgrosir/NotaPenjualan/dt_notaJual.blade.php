<div class="row">
    <div class="panel-body">
        <div id="note-show">

            <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="tebal">Tanggal Belanja</label>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="form-group">
                    <div class="input-daterange input-group">
                        <input id="tanggal1" class="form-control input-sm datepicker1 " name="tanggal"
                               type="text"{{--  value="{{ date('d-m-Y') }}" --}}>
                        <span class="input-group-addon">-</span>
                        <input id="tanggal2" class="input-sm form-control datepicker2" name="tanggal" type="text"
                               value="{{ date('d-m-Y') }}">
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" align="center">
                <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="cariTanggal()">
                    <strong>
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </strong>
                </button>
                <button class="btn btn-info btn-sm btn-flat" type="button" onclick="cariTanggal()">
                    <strong>
                        <i class="fa fa-undo" aria-hidden="true"></i>
                    </strong>
                </button>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" align="right">
                <select name="tampilData" id="tampil_data" onchange="tampilDataGrosir(this);"
                        class="form-control input-sm">
                    <option value="semua" class="form-control">Tampilkan Data : Semua</option>
                    <option value="draft" class="form-control">Tampilkan Data : Draft</option>
                    <option value="progress" class="form-control">Tampilkan Data : Progress</option>
                    <option value="final" class="form-control">Tampilkan Data : Final</option>
                    <option value="packing" class="form-control">Tampilkan Data : Packing</option>
                    <option value="sending" class="form-control">Tampilkan Data : Sending</option>
                    <option value="received" class="form-control">Tampilkan Data : Received</option>
                    <option value="FPN" class="form-control">Tampilkan Data : Final Pending</option>
                    <option value="PPN" class="form-control">Tampilkan Data : Progress Pending</option>
                </select>
            </div>

            <div class="table-responsive" style="padding-top: 15px;">
                <div id="dt_nota_jual">
                    <table class="table tabelan table-bordered table-hover dt-responsive" id="data2"
                           style="width: 100%;">
                        <thead>
                        {{--    <th width="2%">No</th> --}}
                        <th>Tanggal Nota</th>
                        <th>No Nota</th>
                        <th>Customer</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Resi</th>
                        <th>Ubah Status</th>
                        <th>Aksi</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


