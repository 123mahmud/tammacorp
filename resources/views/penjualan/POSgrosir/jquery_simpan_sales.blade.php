<script type="text/javascript">

    function simpan() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.simpanCus').attr('disabled', 'disabled');
        var a = $('#save_customer').serialize();
        $.ajax({
            url: baseUrl + "/penjualan/POSretail/retail/store",
            type: 'POST',
            data: a,
            success: function (response, customer) {
                if (response.status == 'sukses') {
                    $('#myModal').modal('hide');
                    $('#save_customer')[0].reset();
                    iziToast.success({
                        timeout: 5000,
                        position: "topRight",
                        icon: 'fa fa-chrome',
                        title: '',
                        message: 'Data customer tersimpan.'
                    });
                    $('.simpanCus').removeAttr('disabled', 'disabled');
                    $("input[name='s_member']").val(response.customer.c_name);
                    $("input[name='id_cus']").val(response.customer.c_id);
                    $("input[name='sm_alamat']").val(response.customer.c_address + ', '
                      + response.customer.c_hp1 + ', ' + response.customer.c_hp2);
                    $("input[name='c-class']").val(response.customer.c_class);
                    $("#nama-customer").attr("disabled", 'true');
                    $("input[name='item']").focus();
                } else {
                    iziToast.error({
                        position: "topRight",
                        title: '',
                        message: 'Mohon melengkapi data.'
                    });
                    $('.simpanCus').removeAttr('disabled', 'disabled');
                }
            }
        })
    }

    $("input[name='s_member']").focus();

    function sal_save_final() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.simpanFinal').attr('disabled', 'disabled');
        var bb = $('#save_sform :input').serialize();
        var cc = $('#save_item :input').serialize();
        var data = tableDetail.$('input').serialize();
        $.ajax({
            url: baseUrl + "/penjualan/POSgrosir/grosir/sal_save_final",
            type: 'POST',
            data: bb + '&' + cc + '&' + data,

            success: function (response) {
                if (response.status == 'sukses') {
                    $('#proses').modal('hide');
                    $("input[name='s_gross']").val('');
                    $("input[name='s_net']").val('');
                    $("input[name='totalDiscount[]']").val('');
                    $("#nama-customer").val('');
                    $("#alamat2").val('');
                    $('#c-class').val('');
                    tableDetail.row().clear().draw(false);
                    var inputs = document.getElementById('kode'),
                        names = [].map.call(inputs, function (input) {
                            return input.value;
                        });
                    tamp = names;
                    $('#save_item')[0].reset();
                    $("#nama-customer").prop("disabled", false);
                    $("input[name='s_member']").focus();
                    $('.simpanFinal').removeAttr('disabled', 'disabled');
                    var nota = response.nota.s_note;
                    var id = response.nota.s_id;
                    iziToast.show({
                        timeout: false,
                        color: 'red',
                        title: nota,
                        message: 'Cetak sekarang!',
                        position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                        progressBarColor: 'rgb(0, 255, 184)',
                        buttons: [
                            [
                                '<button>Ok</button>',
                                function (instance, toast) {
                                    instance.hide({
                                        transitionOut: 'fadeOutUp'
                                    }, toast);
                                    window.open(baseUrl + "/penjualan/POSgrosir/print/" + id, "_blank");
                                    window.open(baseUrl + "/penjualan/POSgrosir/print_surat_jalan/" + id, "_blank");
                                    window.location.href = baseUrl + "/penjualan/POSgrosir/index";

                                }
                            ],
                            [
                                '<button>Close</button>',
                                function (instance, toast) {
                                    instance.hide({
                                        transitionOut: 'fadeOutUp'
                                    }, toast);
                                }
                            ]
                        ]
                    });
                } else {
                    iziToast.error({
                        position: "topRight",
                        title: '',
                        message: 'Mohon melengkapi data.'
                    });
                    $('.simpanFinal').removeAttr('disabled', 'disabled');
                }
            }
        })
    }

    function sal_save_onProgres() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.simpanProgres').attr('disabled', 'disabled');
        var bb = $('#save_sform :input').serialize();
        var cc = $('#save_item :input').serialize();
        var data = tableDetail.$('input').serialize();
        $.ajax({
            url: baseUrl + "/penjualan/POSgrosir/grosir/sal_save_onprogres",
            type: 'POST',
            data: bb + '&' + cc + '&' + data,
            success: function (response, nota) {
                if (response.status == 'sukses') {
                    $("input[name='s_gross']").val('');
                    $("input[name='s_net']").val('');
                    $("input[name='totalDiscount[]']").val('');
                    $("#nama-customer").val('');
                    $("#alamat2").val('');
                    $('#c-class').val('');
                    tableDetail.row().clear().draw(false);
                    var inputs = document.getElementById('kode'),
                        names = [].map.call(inputs, function (input) {
                            return input.value;
                        });
                    tamp = names;
                    $('#save_item')[0].reset();
                    $("#nama-customer").prop("disabled", false);
                    $("input[name='s_member']").focus();
                    $('.simpanProgres').removeAttr('disabled', 'disabled');
                    var nota = response.nota.s_note;
                    var id = response.nota.s_id;
                    iziToast.show({
                        timeout: false,
                        color: 'red',
                        title: nota,
                        message: 'Cetak sekarang!',
                        position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                        progressBarColor: 'rgb(0, 255, 184)',
                        buttons: [
                            [
                                '<button>Ok</button>',
                                function (instance, toast) {
                                    instance.hide({
                                        transitionOut: 'fadeOutUp'
                                    }, toast);
                                    window.open(baseUrl + "/penjualan/POSgrosir/dp/" + id, "_blank");
                                    window.location.href = baseUrl + "/penjualan/POSgrosir/index";

                                }
                            ],
                            [
                                '<button>Close</button>',
                                function (instance, toast) {
                                    instance.hide({
                                        transitionOut: 'fadeOutUp'
                                    }, toast);
                                }
                            ]
                        ]
                    });
                } else {
                    iziToast.error({
                        position: "topRight",
                        title: '',
                        message: 'Mohon melengkapi data.'
                    });
                    $('.simpanProgres').removeAttr('disabled', 'disabled');
                }
            }
        })
    }

    function sal_save_draft() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.simpanDraft').attr('disabled', 'disabled');
        var bb = $('#save_sform :input').serialize();
        var cc = $('#save_item :input').serialize();
        var data = tableDetail.$('input').serialize();
        $.ajax({
            url: baseUrl + "/penjualan/POSgrosir/grosir/sal_save_draft",
            type: 'POST',
            data: bb + '&' + cc + '&' + data,
            success: function (response, nota) {
                if (response.status == 'sukses') {
                    $("input[name='s_gross']").val('');
                    $("input[name='s_net']").val('');
                    $("input[name='totalDiscount[]']").val('');
                    $("#nama-customer").val('');
                    $("#alamat2").val('');
                    $('#c-class').val('');
                    tableDetail.row().clear().draw(false);
                    var inputs = document.getElementById('kode'),
                        names = [].map.call(inputs, function (input) {
                            return input.value;
                        });
                    tamp = names;
                    $('#save_item')[0].reset();
                    $("#nama-customer").prop("disabled", false);
                    $("input[name='s_member']").focus();
                    $('.simpanDraft').removeAttr('disabled', 'disabled');
                    var nota = response.nota.s_note;
                    iziToast.success({
                        timeout: 5000,
                        position: "topRight",
                        icon: 'fa fa-chrome',
                        title: nota,
                        message: 'Nota tersimpan sebagai draft.'
                    });
                } else {
                    iziToast.error({
                        position: "topRight",
                        title: '',
                        message: 'Mohon melengkapi data.'
                    });
                    $('.simpanDraft').removeAttr('disabled', 'disabled');
                    ;
                }
            }
        })
    }

    function sal_save_finalUpdate() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.simpanFinal').attr('disabled', 'disabled');
        var bb = $('#save_sform :input').serialize();
        var cc = $('#save_item :input').serialize();
        var data = tableDetail.$('input').serialize();
        $.ajax({
            url: baseUrl + "/penjualan/POSgrosir/grosir/sal_save_finalupdate",
            type: 'POST',
            data: bb + '&' + cc + '&' + data,

            success: function (response, nota) {
                if (response.status == 'sukses') {
                    $('#proses').modal('hide');
                    $('#proses').modal('hide');
                    $("input[name='s_gross']").val('');
                    $("input[name='s_net']").val('');
                    $("input[name='totalDiscount[]']").val('');
                    $("#nama-customer").val('');
                    $("#alamat2").val('');
                    $('#c-class').val('');
                    $('.simpanFinal').removeAttr('disabled', 'disabled');
                    tableDetail.row().clear().draw(false);
                    var inputs = document.getElementById('kode'),
                        names = [].map.call(inputs, function (input) {
                            return input.value;
                        });
                    tamp = names;
                    $('#save_item')[0].reset();
                    $("#nama-customer").prop("disabled", false);
                    $("input[name='s_member']").focus();
                    var id = $('#id_faktur').val();
                    var nota = response.nota.s_note;
                    iziToast.show({
                        timeout: false,
                        onClosing: function () {
                            window.location.href = baseUrl + "/penjualan/POSgrosir/index";
                        },
                        color: 'red',
                        title: nota,
                        message: 'Cetak sekarang!',
                        position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                        progressBarColor: 'rgb(0, 255, 184)',
                        buttons: [
                            [
                                '<button>Ok</button>',
                                function (instance, toast) {
                                    instance.hide({
                                        transitionOut: 'fadeOutUp'
                                    }, toast);
                                    window.open(baseUrl + "/penjualan/POSgrosir/print/" + id, "_blank");
                                    window.open(baseUrl + "/penjualan/POSgrosir/print_surat_jalan/" + id, "_blank");
                                    window.location.href = baseUrl + "/penjualan/POSgrosir/index";
                                }
                            ],
                            [
                                '<button>Close</button>',
                                function (instance, toast) {
                                    instance.hide({
                                        transitionOut: 'fadeOutUp'
                                    }, toast);
                                    window.location.href = baseUrl + "/penjualan/POSgrosir/index";
                                }
                            ]
                        ]
                    });
                } else {
                    iziToast.error({
                        position: "topRight",
                        title: '',
                        message: 'Mohon melengkapi data.'
                    });
                    $('.simpanFinal').removeAttr('disabled', 'disabled');
                }
            }
        });
    }

    function sal_save_onProgresUpdate() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.simpanProgres').attr('disabled', 'disabled');
        var bb = $('#save_sform :input').serialize();
        var cc = $('#save_item :input').serialize();
        var data = tableDetail.$('input').serialize();
        $.ajax({
            url: baseUrl + "/penjualan/POSgrosir/grosir/sal_save_onProgresUpdate",
            type: 'POST',
            data: bb + '&' + cc + '&' + data,

            success: function (response, nota) {
                if (response.status == 'sukses') {
                    $('#proses').modal('hide');
                    $("input[name='s_gross']").val('');
                    $("input[name='s_net']").val('');
                    $("input[name='totalDiscount[]']").val('');
                    $("#nama-customer").val('');
                    $("#alamat2").val('');
                    $('#c-class').val('');
                    tableDetail.row().clear().draw(false);
                    var inputs = document.getElementById('kode'),
                        names = [].map.call(inputs, function (input) {
                            return input.value;
                        });
                    tamp = names;
                    $('#save_item')[0].reset();
                    $("#nama-customer").prop("disabled", false);
                    $("input[name='s_member']").focus();
                    $('.simpanProgres').removeAttr('disabled', 'disabled');
                    var nota = response.nota.s_note;
                    var id = response.nota.s_id;
                    iziToast.show({
                        timeout: false,
                        color: 'red',
                        title: nota,
                        message: 'Cetak sekarang!',
                        position: 'center', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                        progressBarColor: 'rgb(0, 255, 184)',
                        buttons: [
                            [
                                '<button>Ok</button>',
                                function (instance, toast) {
                                    instance.hide({
                                        transitionOut: 'fadeOutUp'
                                    }, toast);
                                    window.open(baseUrl + "/penjualan/POSgrosir/dp/" + id, "_blank");
                                    window.location.href = baseUrl + "/penjualan/POSgrosir/index";

                                }
                            ],
                            [
                                '<button>Close</button>',
                                function (instance, toast) {
                                    instance.hide({
                                        transitionOut: 'fadeOutUp'
                                    }, toast);
                                }
                            ]
                        ]
                    });
                } else {
                    iziToast.error({
                        position: "topRight",
                        title: '',
                        message: 'Mohon melengkapi data.'
                    });
                    $('.simpanProgres').removeAttr('disabled', 'disabled');
                }

            }
        });
    }
</script>
