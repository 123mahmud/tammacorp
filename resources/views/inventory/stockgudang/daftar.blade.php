<div id="alert-tab" class="tab-pane fade in active">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px;margin-top: -20px;">

        </div>
{{--         <div class="col-md-2 col-sm-12 col-xs-12">
            <label class="tebal">Pemilik Item :</label>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="form-group" align="pull-left">
                <select class="form-control input-sm" id="pemilik" name="prdt_produksi"
                style="width: 100%;">
                    <option class="form-control" value="">- Pilih Gudang</option>
                    @foreach ($data as $gudang)
                        <option class="form-control pemilik-gudang" value="{{ $gudang->cg_id }}">
                            - {{ $gudang->cg_cabang }}</option>
                    @endforeach
                </select>
            </div>
        </div> --}}
        <div class="col-md-2 col-sm-12 col-xs-12">
            <label class="tebal">Pemilik Item :</label>
        </div>
        <div class="col-md-10 col-sm-12 col-xs-12">
            <div class="form-group" align="pull-left">
                <select class="form-control input-sm" id="posisi" onchange="pilihGudang()"
                name="prdt_produksi" style="width: 100%;">
                    <option class="form-control" value="">- Pilih Gudang</option>
                    @foreach ($data as $gudang)
                        <option class="form-control pemilik-gudang" value="{{ $gudang->cg_id }}">
                            {{ $gudang->cg_cabang }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <table class="table tabelan table-hover table-bordered" width="100%" cellspacing="0" id="tabelGudang">
                <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Kode - Nama Item</th>
                    <th>Type Item</th>
                    <th>Qty Sistem</th>
                    <th>Satuan</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>
</div>
