<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('bower_components/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- Raphael (لـ Morris.js) -->
<script src="{{ asset('bower_components/raphael/raphael.min.js') }}"></script>

<!-- Morris.js -->
<script src="{{ asset('bower_components/morris.js/morris.min.js') }}"></script>

<!-- jQuery Sparkline -->
<script src="{{ asset('bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>

<!-- jvectormap -->
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

<!-- jQuery Knob -->
<script src="{{ asset('bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>

<!-- Moment -->
<script src="{{ asset('bower_components/moment/min/moment.min.js') }}"></script>

<!-- Daterangepicker -->
<script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<!-- Datepicker -->
<script src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>

<!-- Slimscroll -->
<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- FastClick -->
<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

<!-- AdminLTE dashboard demo (اختياري) -->
<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>

<!-- AdminLTE demo -->
<script src="{{ asset('dist/js/demo.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('bower_components/select2/dist/js/select2.full.min.js') }}"></script>

<!-- InputMask -->
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>

<!-- bootstrap color picker -->
<script src="{{ asset('bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>

<!-- bootstrap time picker -->
<script src="{{ asset('plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>

<!-- iCheck 1.0.1 -->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>

<!-- babakhani datepicker -->
<script src="{{ asset('dist/js/persian-date-0.1.8.min.js') }}"></script>
<script src="{{ asset('dist/js/persian-datepicker-0.4.5.min.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#tarikh').persianDatepicker({
            altField: '#tarikhAlt',
            altFormat: 'X',
            format: 'D MMMM YYYY HH:mm a',
            observer: true,
            timePicker: { enabled: true },
        });
    });

    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2();

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' });
        $('[data-mask]').inputmask();

        //Date range picker
        $('#reservation').daterangepicker();
        $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' });

        $('#daterange-btn').daterangepicker({
            ranges: {
                'Today'       : [moment(), moment()],
                'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate  : moment()
        }, function (start, end) {
            $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        });

        //Date picker
        $('#datepicker').datepicker({ autoclose: true });

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        });
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass   : 'iradio_minimal-red'
        });
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        });

        //Colorpicker
        $('.my-colorpicker1').colorpicker();
        $('.my-colorpicker2').colorpicker();

        //Timepicker
        $('.timepicker').timepicker({ showInputs: false });
    });

    // Global Numeral Conversion
    function toWesternNums(str) {
        // Includes both Arabic (U+0660-U+0669) and Farsi/Persian (U+06F0-U+06F9) numerals
        const arabicNumerals = [
            /٠|۰/g, /١|۱/g, /٢|۲/g, /٣|۳/g, /٤|۴/g, /٥|۵/g, /٦|۶/g, /٧|۷/g, /٨|۸/g, /٩|۹/g
        ];
        const westernNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        if (typeof str === 'string') {
            for (let i = 0; i < 10; i++) {
                str = str.replace(arabicNumerals[i], westernNumerals[i]);
            }
        }
        return str;
    }

    function purgeArabicNumerals(node) {
        if (!node) return;
        if (node.nodeName === 'SCRIPT' || node.nodeName === 'STYLE') return;

        if (node.nodeType === 3) {
            const originalValue = node.nodeValue;
            const convertedValue = toWesternNums(originalValue);
            if (originalValue !== convertedValue) {
                node.nodeValue = convertedValue;
            }
        } else if (node.nodeType === 1) {
            // Convert attributes that might contain numbers
            ['placeholder', 'value', 'title', 'data-content', 'alt'].forEach(function(attr) {
                if (node.hasAttribute(attr)) {
                    var oldVal = node.getAttribute(attr);
                    var newVal = toWesternNums(oldVal);
                    if (oldVal !== newVal) node.setAttribute(attr, newVal);
                }
            });

            // Special handling for Select2 and other dropdowns if they exist
            if (node.tagName === 'OPTION') {
                node.text = toWesternNums(node.text);
            }
            for (var i = 0; i < node.childNodes.length; i++) {
                purgeArabicNumerals(node.childNodes[i]);
            }
        }
    }

    $(document).ready(function() {
        purgeArabicNumerals(document.body);
        
        var numObserver = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                mutation.addedNodes.forEach(function(node) {
                    purgeArabicNumerals(node);
                });
            });
        });
        numObserver.observe(document.body, { childList: true, subtree: true });

        $(document).on('input', 'input, textarea', function() {
            var start = this.selectionStart, end = this.selectionEnd;
            var newVal = toWesternNums(this.value);
            if (this.value !== newVal) {
                this.value = newVal;
                if (start !== null) this.setSelectionRange(start, end);
            }
        });
    });
</script>



