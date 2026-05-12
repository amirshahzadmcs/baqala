<div class="menubar-area style-7 footer-fixed rounded-0">
    <div class="toolbar-inner menubar-nav">
        <a href="javascript:void(0)" data-bs-target="#vehicleModal" data-bs-toggle="modal" class="nav-link">
            <i class="">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M23.75 16.25V20.25C23.75 23.0784 23.75 24.4926 22.8713 25.3713C21.9926 26.25 20.5784 26.25 17.75 26.25H12.25C9.42157 26.25 8.00736 26.25 7.12868 25.3713C6.25 24.4926 6.25 23.0784 6.25 20.25V9.75C6.25 6.92157 6.25 5.50736 7.12868 4.62868C8.00736 3.75 9.42157 3.75 12.25 3.75H15" stroke="#222222" stroke-linecap="round" />
                    <path d="M22.5 3.75L22.5 11.25" stroke="#222222" stroke-linecap="round" />
                    <path d="M26.25 7.5L18.75 7.5" stroke="#222222" stroke-linecap="round" />
                    <path d="M11.25 16.25L18.75 16.25" stroke="#222222" stroke-linecap="round" />
                    <path d="M11.25 11.25L16.25 11.25" stroke="#222222" stroke-linecap="round" />
                    <path d="M11.25 21.25L16.25 21.25" stroke="#222222" stroke-linecap="round" />
                </svg>
            </i>
            <span>Timesheet Create</span>
        </a>
        <a href="<?php echo base_url('gate-keeper'); ?>" class="nav-link <?php echo uri_string() == 'gate-keeper' ? 'active' : ''; ?>">
            <i class="">
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="5" y="5" width="7.5" height="7.5" rx="1" stroke="#35B366" stroke-linejoin="round" />
                    <rect x="5" y="17.5" width="7.5" height="7.5" rx="1" stroke="#35B366" stroke-linejoin="round" />
                    <rect x="17.5" y="17.5" width="7.5" height="7.5" rx="1" stroke="#35B366" stroke-linejoin="round" />
                    <rect x="17.5" y="5" width="7.5" height="7.5" rx="1" stroke="#35B366" stroke-linejoin="round" />
                </svg>
            </i>
            <span>Dashboard</span>
        </a>
        <a href="<?php echo base_url('gate-keeper/vehicle/get-timesheet') ?>" class="nav-link <?php echo uri_string() == 'gate-keeper/vehicle/get-timesheet' ? 'active' : ''; ?>">
            <i>
                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.25 8.75L16.25 8.75" stroke="#222222" stroke-linecap="round" />
                    <path d="M11.25 18.75L15 18.75" stroke="#222222" stroke-linecap="round" />
                    <path d="M11.25 13.75L18.75 13.75" stroke="#222222" stroke-linecap="round" />
                    <path d="M23.75 13.75V9.75C23.75 6.92157 23.75 5.50736 22.8713 4.62868C21.9926 3.75 20.5784 3.75 17.75 3.75H12.25C9.42157 3.75 8.00736 3.75 7.12868 4.62868C6.25 5.50736 6.25 6.92157 6.25 9.75V20.25C6.25 23.0784 6.25 24.4926 7.12868 25.3713C8.00736 26.25 9.42157 26.25 12.25 26.25H15" stroke="#222222" stroke-linecap="round" />
                    <circle cx="21.875" cy="21.875" r="3.125" stroke="#222222" stroke-linecap="round" />
                    <path d="M26.25 26.25L24.375 24.375" stroke="#222222" stroke-linecap="round" />
                </svg>
            </i>

            <span>Timesheet List</span>
        </a>
    </div>
</div>
</div>


<!-- JAVASCRIPT -->
<script type="text/javascript">
    var base_url = '<?= base_url(); ?>';
</script>
<script src="<?php echo base_url('store_assets/libs/jquery/jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/metismenu/metisMenu.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/simplebar/simplebar.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/node-waves/waves.min.js'); ?>"></script>
<!--  select2  -->
<script src="<?php echo base_url('store_assets/libs/select2/js/select2.full.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/select2/js/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/spectrum-colorpicker2/spectrum.min.js'); ?>"></script>
<!-- Sweet Alerts js -->
<script src="<?php echo base_url('store_assets/libs/sweetalert2/sweetalert2.min.js'); ?>"></script>
<!-- Required datatable js -->
<script src="<?php echo base_url('store_assets/libs/datatables.net/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
<!-- Buttons examples -->
<script src="<?php echo base_url('store_assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/jszip/jszip.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/pdfmake/build/pdfmake.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/pdfmake/build/vfs_fonts.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/datatables.net-buttons/js/buttons.html5.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/datatables.net-buttons/js/buttons.print.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/datatables.net-buttons/js/buttons.colVis.min.js'); ?>"></script>
<!-- Responsive examples -->
<script src="<?php echo base_url('store_assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js'); ?>"></script>
<!-- twitter-bootstrap-wizard js -->
<script src="<?php echo base_url('store_assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/twitter-bootstrap-wizard/prettify.js'); ?>"></script>

<!-- Datatable init js -->
<script src="<?php echo base_url('store_assets/js/pages/datatables.init.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/js/pages/form-validation.init.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/parsleyjs/parsley.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js'); ?>"></script>
<!-- apexcharts -->
<script src="<?php echo base_url('store_assets/libs/apexcharts/apexcharts.min.js'); ?>"></script>
<!-- dropzone plugin -->
<script src="<?php echo base_url('store_assets/libs/dropzone/min/dropzone.min.js'); ?>"></script>
<!-- Plugins js-->
<script src="<?php echo base_url('store_assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/js/pages/dashboard.init.js'); ?>"></script>
<!--tinymce js-->
<script src="<?php echo base_url('store_assets/libs/tinymce/tinymce.min.js'); ?>"></script>
<!-- init js -->
<script src="<?php echo base_url('store_assets/js/pages/form-editor.init.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/js/pages/form-advanced.init.js'); ?>"></script>
<!-- Sweet alert init js-->
<script src="<?php echo base_url('store_assets/js/pages/sweet-alerts.init.js'); ?>"></script>
<!-- init js -->
<script src="<?php echo base_url('store_assets/js/pages/ecommerce-add-product.init.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/js/app.js'); ?>"></script>
<script src="<?php echo base_url('store_assets/js/vehicle_timesheet.js'); ?>"></script>
<script type="text/javascript">
    setTimeout(function() {
        // Closing the alert
        $('.alert-dismissible').alert('close');
    }, 2000);
</script>
</body>

</html>