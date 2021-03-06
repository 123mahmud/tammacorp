<div class="modal fade" id="prosesProgresUpdate" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="background-color: #e77c38;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color: white;">Form Pembayaran DP Grosir</h4>
            </div>

            <div class="modal-body">

                <div class="col-md-12 col-sm-12 col-xs-12 tamma-bg"
                     style="margin-bottom: 20px; padding-bottom:15px;padding-top:15px; ">

                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Total Belanja</td>
                            <td>
                                <input type="text" name="" readonly="true" id="totalPaymentDp"
                                       class="form-control total" style="text-align: right;" value="0">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table" id="tablePayment">
                        <tbody class="mc">
                        <tr>
                            <td>
                                <select name="sp_methodDP" class="form-control">
                                        @foreach ($dataPayment as $data)
                                            @if ($edit[0]->sp_method == $data->pm_id)
                                                <option value="{{ $data->pm_id }}" selected>{{ $data->pm_name }}</option>
                                            @else
                                                <option value="{{ $data->pm_id }}">{{ $data->pm_name }}</option>
                                            @endif
                                        @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="sp_nominal[]" id="bayarDP" readonly 
                                    value="{{ substr($edit[0]->sp_nominal,0,-3)}}"
                                    class="i_price-DP form-control totPaymentDP" autocomplete="off"
                                    onkeyup="updateKembalianDP()" style="text-align: right;"
                                    onkeyup="rege(event,'i_price-DP');" onblur="setRupiah(event,'i_price-DP')"
                                    onclick="setAwal('event','i_price-DP')">
                            </td>

                        </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Total Pembayaran</td>
                            <td>
                                <input type="text" readonly="true" class="form-control" name="totPembayaranDP"
                                id="totPembayaranDP" style="text-align: right;" value="0">
                            </td>
                        </tr>
                        <tr>
                            <td>Kembalian</td>
                            <td>
                                <input type="text" name="s_kembalianP" value="0" id="kembalianDP" readonly="true"
                                       class="form-control kemblaian" style="text-align: right;">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                <button class="btn btn-primary simpanProgres" type="button" onclick="sal_save_onProgresUpdate()">
                  Proses</button>
            </div>
        </div>
    </div>
</div>

<script>

</script>
