
    <script src="{{ asset ('assets/script/jquery-2.2.4.min.js') }}"></script>
    <script src="{{ asset ('assets/js/date-uk.js') }}"></script>
    <script src="{{ asset ('assets/js/js_ssb.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery-migrate-1.2.1.min.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery-ui.js') }}"></script>
    <script src="{{ asset ('assets/script/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset ('assets/script/bootstrap.min.js') }}"></script>
    <script src="{{ asset ('assets/script/bootstrap-hover-dropdown.js') }}"></script>
    <script src="{{ asset ('assets/script/respond.min.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.cookie.js') }}"></script>
  {{--   <script src="{{ asset ('assets/script/icheck.min.js') }}"></script> --}}
    <script src="{{ asset ('assets/script/custom.min.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.news-ticker.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.menu.js') }}"></script>
    <script src="{{ asset ('assets/script/pace.min.js') }}"></script>
    <script src="{{ asset ('assets/script/holder.js') }}"></script>
    <script src="{{ asset ('assets/script/responsive-tabs.js') }}"></script>
    <script src="{{ asset ('assets/script/zabuto_calendar.min.js') }}"></script>
    <script src="{{ asset ('assets/script/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset ('assets/script/jquery.dataTables.js') }}"></script>
    <script src="{{ asset ('assets/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset ('assets/select2/select2.min.js') }}"></script>
    <!--LOADING SCRIPTS FOR CHAfRTS-->
    <script src="{{ asset ('assets/script/highcharts.js') }}"></script>
    <script src="{{ asset ('assets/script/data.js') }}"></script>
    <script src="{{ asset ('assets/script/drilldown.js') }}"></script>
    <script src="{{ asset ('assets/script/exporting.js') }}"></script>
    <script src="{{ asset ('assets/script/highcharts-more.js') }}"></script>
    <script src="{{ asset ('assets/script/charts-highchart-pie.js') }}"></script>
    <script src="{{ asset ('assets/script/charts-highchart-more.js') }}"></script>
    <script src="{{ asset ('assets/script/chartjs/Chart.bundle.js') }}"></script>
    <script src="{{ asset ('assets/script/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset ('assets/script/chartjs/Chart.js') }}"></script>
    <script src="{{ asset ('assets/script/chartjs/Chart.min.js') }}"></script>
    <!--CORE JAVASCRIPT-->
    <script src="{{ asset ('assets/script/main.js') }}"></script>
    <!-- End core -->
    <script src="{{ asset ('assets/script/timepicker.min.js') }}"></script>
    <script src="{{asset('assets/script/jquery.maskMoney.js')}}"></script>
    <script src="{{asset('assets/script/accounting.min.js')}}"></script>
    <script src="{{ asset('js/iziToast.min.js') }}"></script>
    <script src="{{asset('js/jquery-validation.min.js')}}"></script>
    <script src="{{asset('assets/jquery-confirm/jquery-confirm.js')}}"></script>
    <script src="{{ asset('assets/inputmask/inputmask.jquery.js') }}"></script>
    <script type="text/javascript">
        var baseUrl = '{{url('/')}}';

        toastr.options = {
          "closeButton": true,
          "debug": false,
          "newestOnTop": false,
          "progressBar": true,
          "positionClass": "toast-top-right",
          "preventDuplicates": false,
          "onclick": null,
          "showDuration": "300",
          "hideDuration": "1000",
          "timeOut": "5000",
          "extendedTimeOut": "1000",
          "showEasing": "swing",
          "hideEasing": "linear",
          "showMethod": "fadeIn",
          "hideMethod": "fadeOut"
        };

        // var readonly = $('.readonly').attr('readonly','true')
        var readonly = $('.readonly').css('pointer','none')

    </script>
    <script>
         $(document).ready(function() {

           var datepicker_today = $('.datepicker_today').datepicker({
              format:"dd-mm-yyyy",
              autoclose:true
            }).datepicker("setDate", "0");

           var datepicker_strip = $('.datepicker_strip').datepicker({
              format:"dd-mm-yyyy",
              autoclose:true
            });

           $('.input-daterange').datepicker({
            format:"dd-mm-yyyy"
           });

            var extensions = {
                 "sFilterInput": "form-control input-sm",
                "sLengthSelect": "form-control input-sm"
            }
            // Used when bJQueryUI is false
            $.extend($.fn.dataTableExt.oStdClasses, extensions);
            // Used when bJQueryUI is true
            $.extend($.fn.dataTableExt.oJUIClasses, extensions);

            
            $('.data-table').dataTable({
                  "responsive":true,

                  "pageLength": 10,
                "lengthMenu": [[10, 20, 50, - 1], [10, 20, 50, "All"]],
                "language": {
                    "searchPlaceholder": "Cari Data",
                    "emptyTable": "Tidak ada data",
                    "sInfo": "Menampilkan _START_ - _END_ Dari _TOTAL_ Data",
                    "sSearch": '<i class="fa fa-search"></i>',
                    "sLengthMenu": "Menampilkan &nbsp; _MENU_ &nbsp; Data",
                    "infoEmpty": "",
                    "paginate": {
                            "previous": "Sebelumnya",
                            "next": "Selanjutnya",
                         }
                  }

                });

            // add manually inputmask to each .currency
            $('.currency-x').inputmask("currency", {
              radixPoint: ".",
              groupSeparator: ".",
              digits: 0,
              autoGroup: true,
              prefix: '', //Space after $, this will not truncate the first character.
              rightAlign: false,
              autoUnmask: true,
              // unmaskAsNumber: true,
            });
            });
    </script>
    <script type="text/javascript">
          // Filter Search Menu Submenu Sidebar
      function myFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("filterInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("side-menu");
        li = ul.getElementsByTagName("li");
        button = document.getElementById('btn-reset');
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";

            }
        }
        

        if (input.value != 0 ) {
          button.classList.remove('hidden');
        } else {
          button.classList.add('hidden');
        }
        
    }
      function btnReset() {
        input = document.getElementById("filterInput");
        input.value=null;
        input.focus();
      }
    </script>

    {{-- kotak2 an dashboard || index || home --}}
    <script type="text/javascript">
    //BEGIN COUNTER FOR SUMMARY BOX
    function counterNum(obj, start, end, step, duration) {
        $(obj).html(start);
        setInterval(function(){
            var val = Number($(obj).html());
            if (val < end) {
                $(obj).html(val+step);
            } else {
                clearInterval();
            }
        },duration);
    }
    //END COUNTER FOR SUMMARY BOX
    </script>

    {{-- Logout Question --}}
    <script type="text/javascript">
      $('.log-out-m8').click(function(e){
        e.preventDefault();
        
        iziToast.question({
            timeout: 20000,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            icon: 'fa fa-sign-out',
            zindex: 999,
            title: 'Log Out ?' ,
            message: 'Apakah anda yakin?',
            position: 'center',
            buttons: [
                ['<button><b>Ya</b></button>', function (instance, toast) {
         
                    window.location.href = $('.log-out-m8').attr('href');
         
                }, true],
                ['<button>Tidak</button>', function (instance, toast) {
         
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
         
                }],
            ],
            onClosing: function(instance, toast, closedBy){
                console.info('Closing | closedBy: ' + closedBy);
            },
            onClosed: function(instance, toast, closedBy){
                console.info('Closed | closedBy: ' + closedBy);
            }
        });
      });
    </script>