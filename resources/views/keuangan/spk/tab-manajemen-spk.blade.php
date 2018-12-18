      <div id="manajemen-spk-tab" class="tab-pane fade ">
        <div class="row" style="margin-top: -5px;">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-2 col-sm-3 col-xs-12">
              <label class="tebal">Tanggal SPK</label>
            </div>

            <div class="col-md-4 col-sm-6 col-xs-12">
              <div class="form-group">
                <div class="input-daterange input-group">
                  <input id="tanggal1" class="form-control input-sm datepicker1" name="tanggal" type="text">
                  <span class="input-group-addon">-</span>
                  <input id="tanggal2" class="input-sm form-control datepicker2" name="tanggal" type="text" value="{{ date('d-m-Y') }}">
                </div>
              </div>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" align="center">
              <button class="btn btn-primary btn-sm btn-flat autoCari" type="button" onclick="cariTanggalSpk()">
                <strong>
                  <i class="fa fa-search" aria-hidden="true"></i>
                </strong>
              </button>
              <button class="btn btn-info btn-sm btn-flat" type="button" onclick="refreshTabelSpk()">
                <strong>
                  <i class="fa fa-undo" aria-hidden="true"></i>
                </strong>
              </button>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12" align="right" style="padding-bottom: 50px;">
              <select name="tampilData" id="tampil_data" class="form-control input-sm">
                <option value="semua" class="form-control">Tampilkan : Semua</option>
                <option value="draft" class="form-control">Tampilkan : Draft</option>
                <option value="setuju" class="form-control">Tampilkan : Di Setujui</option>
                <option value="progress" class="form-control">Tampilkan : On Progress</option>
                <option value="finish" class="form-control">Tampilkan : Selesai</option>
              </select>
            </div>
            
            <div class="table-responsive">
              <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="table-spk">
                <thead>
                  <tr>
                    <th>No</th>
                    <th width="10%">Tanggal</th>
                    <th width="30%">No Spk</th>
                    <th>Item</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th style="text-align: center;">Aksi</th>
                  </tr>
                </thead>
                <tbody>                                                
                </tbody>
              </table> 
            </div>                                       
          </div>
        </div>
      </div>