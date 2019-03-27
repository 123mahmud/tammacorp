
    <title>Tamma | Food</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" href="{{App\Http\Controllers\SystemController::getProfile()->cp_image}}">
    <link rel="apple-touch-icon" href="{{ asset ('assets/images/icons/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset ('assets/images/icons/favicon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset ('assets/images/icons/favicon-114x114.png') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery-ui-1.10.4.custom.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/font-awesome.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/animate.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/all.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/main.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/style-responsive.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/zabuto_calendar.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/pace.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery.news-ticker.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/bootstrap-datepicker.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/dataTables.bootstrap.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery.dataTables.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/toastr/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/toastr/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/select2/select2-bootstrap.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/timepicker.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/css/ladda-themeless.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset ('assets/styles/awesome-bootstrap-checkbox.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/jquery-confirm/jquery-confirm.css')}}">
<link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">
    <style type="text/css">

        .overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.6);
            z-index: 2000;
        }

        .lds-hourglass {
          display: inline-block;
          position: relative;
          width: 64px;
          height: 64px;
        }
        .lds-hourglass:after {
          content: " ";
          display: block;
          border-radius: 50%;
          background: white;
          width: 0;
          height: 0;
          margin: 6px;
          box-sizing: border-box;
          border: 26px solid #FF8800;
          border-color: #FF8800 transparent #FF8800 transparent;
          animation: lds-hourglass 1.2s infinite;
        }
        @keyframes lds-hourglass {
          0% {
            transform: rotate(0);
            animation-timing-function: cubic-bezier(0.55, 0.055, 0.675, 0.19);
          }
          50% {
            transform: rotate(900deg);
            animation-timing-function: cubic-bezier(0.215, 0.61, 0.355, 1);
          }
          100% {
            transform: rotate(1800deg);
          }
        }

        .center{
            text-align: center
        }
        .right{
            text-align: right;
        }
        .disabled_select{
            pointer-events: none;
            background-color: #eee;
        }
        .tamma-bg-form-top{
            margin-top: -23px;
            padding-top: 23px;
            padding-bottom: 10px;
            border-radius: unset;
        }
        .tamma-bg-form-mid{
            padding-top: 23px;
            padding-bottom: 10px;
            border-radius: unset;
        }
        .select2-container{
            width: 100% !important;
        }

        .centered-text {
            text-align: center;
        }
    </style>
