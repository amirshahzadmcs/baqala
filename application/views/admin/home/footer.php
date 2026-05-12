
				</div>
				<!-- container-fluid -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>
                                    document.write(new Date().getFullYear());
                                </script>
                                © Warehouse.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">Crafted with <i class="mdi mdi-heart text-danger"></i> by IXIANA TECH</div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->

        <!-- JAVASCRIPT -->
        <script src="<?php echo base_url('admin_assets/libs/jquery/jquery.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $(document).ajaxStart(function(){
                    $("#wait").css("display", "block");
                });
                $(document).ajaxComplete(function(){
                    $("#wait").css("display", "none");
                });
                $(document).ajaxError(function(){
                    $("#wait").css("display", "none");
                });
            });
            
            function passwordShow() {
				var x = document.getElementById("password");
				if (x.type === "password") {
					x.type = "text";
					$('#password_btn').html('<i class="fas fa-eye-slash"></i>');
				} else {
					x.type = "password";
					$('#password_btn').html('<i class="fa fa-eye"></i>');
				}
			}
			
			document.getElementById('vertical-menu-btn').addEventListener('click', function() {
				document.body.classList.toggle('vertical-collpsed');
				if (document.body.classList.contains('vertical-collpsed')) {
					localStorage.setItem('sidebarState', 'collapsed');
				} else {
					localStorage.setItem('sidebarState', 'expanded');
				}
				// Reload the page to apply the changes
				location.reload();
			});

			window.addEventListener('load', function() {
				const sidebarState = localStorage.getItem('sidebarState');
				if (sidebarState === 'collapsed') {
					document.body.classList.add('vertical-collpsed');
				} else {
					document.body.classList.remove('vertical-collpsed');
				}
			});
        </script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
        <script src="<?php echo base_url('admin_assets/plugins/hijri-date-picker/js/bootstrap-hijri-datetimepicker.min.js');?>"></script>
		<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
		<script type="text/javascript">
			$(function () {
				initHijriPickers();
			});

			function initHijriPickers() {
				$(".hijri-picker").hijriDatePicker({
					hijri: true,
					showSwitcher: false,
					format: 'DD-MM-YYYY',  // very important
					useCurrent: false,
					allowInputToggle: true,
				});
			}
		</script>
        <script src="<?php echo base_url('admin_assets/libs/metismenu/metisMenu.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/simplebar/simplebar.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/node-waves/waves.min.js');?>"></script>
        <!--  select2  -->
        <script src="<?php echo base_url('admin_assets/libs/select2/js/select2.full.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/select2/js/select2.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/spectrum-colorpicker2/spectrum.min.js');?>"></script>
        <!-- Sweet Alerts js -->
        <script src="<?php echo base_url('admin_assets/libs/sweetalert2/sweetalert2.min.js');?>"></script>
        <!-- Required datatable js -->
        <script src="<?php echo base_url('admin_assets/libs/datatables.net/js/jquery.dataTables.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js');?>"></script>
        <!-- Buttons examples -->
        <script src="<?php echo base_url('admin_assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/jszip/jszip.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/pdfmake/build/pdfmake.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/pdfmake/build/vfs_fonts.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/datatables.net-buttons/js/buttons.html5.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/datatables.net-buttons/js/buttons.print.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/datatables.net-buttons/js/buttons.colVis.min.js');?>"></script>
        <!-- Responsive examples -->
        <script src="<?php echo base_url('admin_assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js');?>"></script>
        <!-- twitter-bootstrap-wizard js -->
        <script src="<?php echo base_url('admin_assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/twitter-bootstrap-wizard/prettify.js');?>"></script>
		<!-- Magnific Popup-->
        <script src="<?php echo base_url('admin_assets/libs/magnific-popup/jquery.magnific-popup.min.js');?>"></script>
        <!-- Tour init js-->
        <script src="<?php echo base_url('admin_assets/js/pages/lightbox.init.js');?>"></script>

        <!-- Datatable init js -->
        <script src="<?php echo base_url('admin_assets/js/pages/datatables.init.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/js/pages/form-validation.init.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/parsleyjs/parsley.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js');?>"></script>
        <!-- apexcharts -->
        <script src="<?php echo base_url('admin_assets/libs/apexcharts/apexcharts.min.js');?>"></script>
        <!-- dropzone plugin -->
		<script src="<?php echo base_url('admin_assets/plugins/dropify/dropify.min.js'); ?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/dropzone/min/dropzone.min.js');?>"></script>
        <!-- Plugins js-->
        <script src="<?php echo base_url('admin_assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/js/pages/dashboard.init.js');?>"></script>
        <!--tinymce js-->
        <script src="<?php echo base_url('admin_assets/libs/tinymce/tinymce.min.js');?>"></script>
        <!-- init js -->
        <script src="<?php echo base_url('admin_assets/js/pages/form-editor.init.js');?>"></script>
		<link href="<?php echo base_url('admin_assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js');?>" rel="stylesheet" />
		<script src="<?php echo base_url('admin_assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/js/pages/form-advanced.init.js');?>"></script>
        <!-- Sweet alert init js-->
        <script src="<?php echo base_url('admin_assets/js/pages/sweet-alerts.init.js');?>"></script>
        <!-- init js -->
        <!-- form mask -->
        <script src="<?php echo base_url('admin_assets/libs/inputmask/jquery.inputmask.min.js');?>"></script>
        <!-- form mask init -->
        <script src="<?php echo base_url('admin_assets/js/pages/form-mask.init.js');?>"></script>
		<!-- Table Editable plugin -->
        <script src="<?php echo base_url('admin_assets/libs/table-edits/build/table-edits.min.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/js/pages/table-editable.init.js');?>"></script> 
        <script src="<?php echo base_url('admin_assets/js/pages/ecommerce-add-product.init.js');?>"></script>
		<script src="<?php echo base_url('admin_assets/libs/jquery-knob/jquery.knob.min.js');?>"></script> 
		<script src="<?php echo base_url('admin_assets/js/pages/jquery-knob.init.js');?>"></script>
        <script src="<?php echo base_url('admin_assets/js/app.js');?>"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
		<script src="<?php echo base_url('admin_assets/js/profile-pic-cropper.js'); ?>"></script>

		<script type="text/javascript" src="<?php echo base_url('admin_assets/plugins/easyui/jquery.easyui.min.js')?>"></script>
		<script src="<?php echo base_url('admin_assets/js/assets-management.js'); ?>"></script>
        <script src="<?php echo base_url('admin_assets/js/vehicle_timesheet.js'); ?>"></script>
		
        <script type="text/javascript">
            setTimeout(function() {
                // Closing the alert
                $('.alert-dismissible').alert('close');
            }, 2000);
        </script>
		<!---- Top search bar ---->
		<script>
			$(document).ready(function() {
				// Set data-label attributes
				$('#side-menu a').each(function() {
					var text = $(this).text().trim().toLowerCase();
					$(this).attr('data-label', text);
				});

				function filterSidebarItems() {
					var filter = $('#sidebar-search').val().toLowerCase();

					$('#side-menu li').each(function() {
						var $this = $(this);
						var $anchor = $this.find('a');

						// Ensure anchor exists before accessing attributes
						if ($anchor.length) {
							var itemText = $anchor.attr('data-label') || '';
							var isVisible = itemText.toLowerCase().indexOf(filter) > -1;

							if (isVisible) {
								$this.show();
								// Show parent items if this item is in a sub-menu
								$this.parents('ul.sub-menu').siblings('a').show();
								$this.parents('ul.sub-menu').parent().show(); // Show parent menu item
							} else {
								var hasMatchingDescendant = $this.find('ul.sub-menu li:visible').length > 0;
								if (hasMatchingDescendant) {
									$this.show();
									// Ensure parent items are visible
									$this.parents('ul.sub-menu').siblings('a').show();
									$this.parents('ul.sub-menu').parent().show(); // Show parent menu item
								} else {
									$this.hide();
								}
							}
						} else {
							$this.hide(); // Hide li if no anchor is found
						}
					});

					// Ensure that the direct parent menu items are shown if their children match
					$('#side-menu li').each(function() {
						var $this = $(this);
						if ($this.find('ul.sub-menu li:visible').length > 0) {
							$this.show();
							$this.parents('ul.sub-menu').siblings('a').show(); // Show parent link
							$this.parents('ul.sub-menu').parent().show(); // Show parent menu item
						}
					});
				}

				// Search functionality
				$('#sidebar-search').on('keyup', filterSidebarItems);

				// Close search functionality
				$('.close-search').on('click', function(e) {
					e.preventDefault(); // Prevent default link behavior

					// Clear the search input
					$('#sidebar-search').val('');

					// Show all items
					$('#side-menu li').show();
					$('#side-menu a').show(); // Ensure parent items are visible
				});
			});
			/*---- Top search bar script end ----*/
			// Global function to handle date validation and disabling past or invalid dates
			function initializeDatePickers(startDateSelector, endDateSelector, errorMessageSelector) {
				$(startDateSelector).attr('min', new Date().toISOString().split('T')[0]);
				$(startDateSelector).on('change', function() {
					var startDate = $(this).val();
					$(endDateSelector).attr('min', startDate);
				});

				$(endDateSelector).on('change', function() {
					var startDate = $(startDateSelector).val();
					var endDate = $(this).val();
					var errorMessage = $(errorMessageSelector);

					if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
						errorMessage.text('End date should be greater than or equal to the start date.');
						$(this).val('');
					} else {
						errorMessage.text('');
					}
				});
			}
			
			function formatDateDMY(date) {
				return date.toLocaleDateString('en-GB').replace(/\//g, '-');
			}
			
			function calculateAge(dobInput, ageInput) {
				var dob = new Date($(dobInput).val());
				var today = new Date();
				
				if (dob) {
					var age = today.getFullYear() - dob.getFullYear();
					
					// Adjust age if the birthday hasn't occurred yet this year
					if (today.getMonth() < dob.getMonth() || 
					(today.getMonth() === dob.getMonth() && today.getDate() < dob.getDate())) {
						age--;
					}

					$(ageInput).val(age); // Set the age value
				}
			}
		</script>
		
    </body>
</html>
