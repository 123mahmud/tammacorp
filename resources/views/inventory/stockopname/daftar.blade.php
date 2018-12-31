<div id="alert-tab" class="tab-pane fade in active">
    <div class="row">
      <form id="opname">

        <div class="col-md-2 col-sm-12 col-xs-12">
            <label class="tebal">Pemilik Item :</label>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="form-group" align="pull-left">
                <select class="form-control input-sm" id="pemilik" name="o_comp"
                style="width: 100%;" onclick="clearTable()">
                    <option class="form-control" value="" >- Pilih Gudang</option>
                    @foreach ($data as $gudang)
                        <option class="form-control pemilik-gudang" value="{{ $gudang->cg_id }}">
                            - {{ $gudang->cg_cabang }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2 col-sm-12 col-xs-12">
            <label class="tebal">Posisi Item :</label>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="form-group" align="pull-left">
                <select class="form-control input-sm" id="posisi"
                name="o_position" style="width: 100%;" onclick="clearTable()">
                    <option class="form-control" value="">- Pilih Gudang</option>
                    @foreach ($data as $gudang)
                        <option class="form-control pemilik-gudang" value="{{ $gudang->cg_id }}">
                            - {{ $gudang->cg_cabang }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-2 col-sm-12 col-xs-12">
            <label class="tebal">Tanggal Opname :</label>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="form-group" align="pull-left">
                <input type="text" class="form-control input-sm datepicker" name="o_date" value="{{ date('d-m-Y') }}">
            </div>
        </div>

        <div class="col-md-2 col-sm-12 col-xs-12">
            <label class="tebal">Nama Staff :</label>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="form-group" align="pull-left">
              <input type="text" readonly="" class="form-control input-sm" name="" value="{{$staff['nama']}}">
              <input type="hidden" readonly="" class="form-control input-sm" name="o_staff" value="{{$staff['id']}}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-12 tamma-bg"  style="margin-top: 5px;margin-bottom: 5px;
            margin-bottom: 40px; padding-bottom:20px;padding-top:20px;">
              <div class="col-md-4">
                  <label class="control-label tebal" for="">Masukan Kode / Nama</label>
                  <div class="input-group input-group-sm" style="width: 100%;">
                      <input type="text" id="namaitem" name="item" class="form-control">
                      <input type="hidden" id="i_id" name="i_id" class="form-control">
                      <input type="hidden" id="i_code" name="i_code" class="form-control">
                      <input type="hidden" id="i_name" name="i_name" class="form-control">
                      <input type="hidden" id="m_sname" name="m_sname" class="form-control">
                  </div>
              </div>
              <div class="col-md-3">
                  <label class="control-label tebal" name="qty">Qty Real</label>
                  <div class="input-group input-group-sm" style="width: 100%;">
                      <input type="number" id="qtyReal" name="qtyReal" class="form-control">
                  </div>
              </div>
              <div class="col-md-3">
                  <label class="control-label tebal" name="qty">Qty Sistem</label>
                  <div class="input-group input-group-sm" style="width: 100%;">
                      <input type="text" id="s_qtykw" name="s_qtykw" class="form-control" readonly>
                      <input type="hidden" id="s_qty" name="s_qty" class="form-control" readonly>
                  </div>
              </div>
              <div class="col-md-2">
                  <label class="control-label tebal" name="qty">Satuan</label>
                  <div class="input-group input-group-sm" style="width: 100%;">
                      <input type="text" id="satuan" name="satuan" class="form-control" readonly>
                  </div>
              </div>
            </div>
        </div>

      </form>
      <form id="tbOpname">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tabelOpname">
                <thead>
                  <tr>
                      <th>Kode - Nama Item</th>
                      <th>Qty Sistem</th>
                      <th width="5%">Satuan</th>
                      <th>Qty Real</th>
                      <th>Opname</th>
                      <th width="5%">Aksi</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
      </form>

        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top: 20px;margin-bottom: 5px;">
            <button class="btn btn-success kirim-opname" onclick="simpanOpname()"
            style="float: right" type="button">Kirim</button>
        </div>

    </div>
</div>
