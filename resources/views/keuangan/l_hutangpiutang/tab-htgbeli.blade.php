<div id="htgbeli-tab" class="tab-pane fade in active">
  <div class="row">
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
    {{--   <div class="panel-body"> --}}
        <!-- Isi Content -->
        <div class="col-md-3 transaksi-wrapper">
        <div class="col-md-12 icon">
          <i class="fa fa-book" style="color: #FF8800;"></i>
        </div>

        <div class="col-md-12 text">
          <a href="#" data-toggle="modal" data-target="#modal_buku_piutang">Lihat Hutang Pembelian</a>
        </div>
      </div>
    {{--   </div> --}}

    {{--   <div class="panel-body"> --}}
      <!-- Isi Content -->
      <div class="col-md-3 transaksi-wrapper">
      <div class="col-md-12 icon">
        <i class="fa fa-book" style="color: #FF8800;"></i>
      </div>

      <div class="col-md-12 text">
        <a href="#" data-toggle="modal" data-target="#modal_buku_besar">Lihat Hutang Penjualan</a>
      </div>
    </div>
  {{--   </div> --}}
  </div>
    </div>
  </div>     
</div><!-- /div alert-tab -->

 <div class="modal fade" id="modal_buku_piutang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document" style="width: 35%;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Setting Buku Besar</h4>
          </div>

          <form id="form-piutang" method="get" action="{{ route('laporan_piutang.index') }}" target="_blank">
          <div class="modal-body">
            <div class="row" style="margin-bottom: 15px;">
              <div class="col-md-3">
                Periode
              </div>

              <div class="col-md-4 durasi_bulan_buku_besar">
                <input type="text" name="periode1" placeholder="periode Mulai" class="form-control datepicker1" id="d1_buku_besar" autocomplete="off" required readonly style="cursor: pointer;">
              </div>

              <div class="col-md-1">
                s/d
              </div>

              <div class="col-md-4 durasi_bulan_buku_besar">
                <input type="text" name="periode2" placeholder="Periode Akhir" class="form-control datepicker2" id="d2_buku_besar" autocomplete="off" required readonly style="cursor: pointer;">
              </div>

            </div>

            <div class="row" style="margin-bottom: 15px;">
              <div class="col-md-3">
                Pilih Supplier
              </div>

              <div class="col-md-9 durasi_bulan_buku_besar">
                <select id="hitPenjualan" class="form-control select-1" name="cus">
                  <option value="all">Semua</option>
                  @foreach ($supplier as $sup)
                    <option value="{{ $sup->s_id }}">{{ $sup->s_company }}</option>
                  @endforeach
                </select>
              </div>

            </div>

          </div>
          
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Proses</button>
          </div>

          </form>
        </div>
      </div>
    </div>