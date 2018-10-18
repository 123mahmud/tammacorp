<div class="modal fade" id="create" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #e77c38;">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h4 class="modal-title" style="color: white;">Tambah Hasil
                    Produksi</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table tabelan table-hover ">
                        <tbody>
                        <tr>
                            <td>
                                Tanggal SPK<font color="red">*</font>
                            </td>
                            <td>
                                <input type="text"
                                       class="form-control datepicker2"
                                       id="TanggalProduksi"
                                       onchange="SetTanggalProduksi()"
                                       name="Tanggal_Produksi">
                            </td>
                        </tr>
                        <tr>
                            <td>Nomor SPK<font color="red">*</font></td>
                            <td id="ubahselect">
                                <select class="form-control input-sm"
                                        id="cari_spk" name="cariSpk"
                                        style="width: 100%;">
                                    <option>- Pilih Nomor SPK</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Nama Item</td>
                            <td>
                                <input type="text" name="" type="text"
                                       class="form-control" id="NamaItem"
                                       value="" readonly>
                                <input type="hidden" name=""
                                       class="form-control" id="id_item"
                                       value="" readonly>
                                <input type="hidden" name=""
                                       class="form-control" id="spk_id"
                                       value="" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah SPK</td>
                            <td>
                                <input type="text" name="" type="text"
                                       class="form-control"
                                       id="JumlahItemSpk" value="" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Jml Hasil Produksi</td>
                            <td>
                                <input type="text" name="" type="text"
                                       class="form-control"
                                       id="JumlahItemHasilSpk" value=""
                                       readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Produksi</td>
                            <td>
                                <input type="text" class="form-control"
                                       id="TanggalHasilProduksi" name=""
                                       value="{{ date('d-m-Y') }}" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td>Dari Produksi<font color="red">*</font></td>
                            <td>
                                <select class="form-control input-sm"
                                        id="prdt_produksi"
                                        name="prdt_produksi"
                                        style="width: 100%;">
                                    @foreach ($data as $produksi)
                                        <option value="{{ $produksi->mp_id }}">{{ $produksi->mp_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Jam Produksi<font color="red">*</font></td>
                            <td>
                                <input type="text"
                                       class="form-control timepicker"
                                       id="time" name="">
                            </td>
                        </tr>
                        <tr>
                            <td>Jumlah Item<font color="red">*</font></td>
                            <td>
                                <input type="number" class="form-control"
                                       id="JumlahItem" name=""
                                       style="text-align: right;"
                                       onkeyup="maxQty()">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning"
                        data-dismiss="modal">Close
                </button>
                <button class="btn btn-primary PostingHasil" type="submit"
                        onclick="simpanHasilProduct()">Posting
                </button>
            </div>
        </div>
    </div>
</div>