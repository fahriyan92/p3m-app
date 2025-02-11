<!-- InputMask -->
<!-- Sparkline -->
<!-- JQVMap -->
<!-- jQuery Knob Chart -->
<!-- daterangepicker -->
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets'); ?>/dist/js/adminlte.js"></script>
<!-- adminlte dashboard demo (this is only for demo purposes) -->
<!-- AdminLTE for demo purposes -->
<!-- DataTables -->

<!-- Select2 -->


<!-- date-range-picker -->
<script src="<?php echo base_url('assets'); ?>/plugins/daterangepicker/daterangepicker.js"></script>

<script>
    $('#reservationtime').daterangepicker({
        timePicker: true,
        timePickerIncrement: 30,
        format: 'MM/DD/YYYY h:mm A'
    });


    $('.input-group.date').datepicker({
        format: "dd.mm.yyyy"
    });
</script>