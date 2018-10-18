<!DOCTYPE html>
<html>
<head>
    <title>Print Jangan Banting</title>
</head>
<style type="text/css">

    .div-width {
        width: 90vw;
        margin: auto;
    }

    .red {
        color: red;
    }

    .bold {
        font-weight: bold;
    }

    p {
        font-size: 14px;
    }

    .underline {
        text-decoration: underline;
    }

    @media print {
        .buttonPrint {
            display: none;
        }
    }
</style>
<body>
<div class="buttonPrint">
    <button onclick="prints()">Print</button>
</div>
<div class="div-width" align="center">
    <h1 class="red underline">JANGAN DI BANTING</h1>
    <h3>TAMMA FOOD INDONESIA</h3>
    <p class="bold">
        Jl. Raya Randu Sidotopo Wetan Surabaya.<br>
        Telp. 031-51165528, Hp: 081234561066, 081907654321
    </p>
    <p class="bold">
        Kepada : {{$sales->c_name}} <br>
        {{$sales->c_address}}<br>
        HP {{$sales->c_hp1}} , {{$sales->c_hp2}}
    </p>
    <h1 class="red underline">MAKANAN BEKU</h1>
</div>
</body>
<script type="text/javascript">
    function prints() {
        window.print();
    }
</script>
</html>