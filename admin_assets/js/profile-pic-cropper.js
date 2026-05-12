var baseUrl = $('.baseUrl').val();
let cropper;

// When user selects an image
$("#employee_pic").on("change", function (event) {
	let files = event.target.files;

	let done = function (url) {
		$("#cropImage").attr("src", url);
		$("#imagePreview").show();
		$("#cropControls").show();

		// Destroy old cropper if exists
		if (cropper) cropper.destroy();

		// Create new cropper
		cropper = new Cropper(document.getElementById("cropImage"), {
			aspectRatio: 1,
			viewMode: 1,
			background: false,
			autoCropArea: 1,
			zoomable: true,
			rotatable: true
		});
	};

	if (files && files.length > 0) {
		let reader = new FileReader();
		reader.onload = function (e) {
			done(e.target.result);
		};
		reader.readAsDataURL(files[0]);
	}
});

// Zoom
$("#zoomIn").click(() => cropper.zoom(0.1));
$("#zoomOut").click(() => cropper.zoom(-0.1));

// Rotate
$("#rotateLeft").click(() => cropper.rotate(-45));
$("#rotateRight").click(() => cropper.rotate(45));

// Upload button action
$('#uploadButton').click(function () {

	if (!cropper) {
		$('#uploadStatus').html('<div class="alert alert-danger">Please select an image first.</div>');
		return;
	}

	cropper.getCroppedCanvas({
		width: 200,
		height: 200
	}).toBlob(function (blob) {

		let formData = new FormData();

		// Employee ID
		formData.append("emp_id", $("input[name=emp_id]").val());

		// Important: send PNG always (matches model)
		formData.append("employee_pic", blob, "profile.png");

		$.ajax({
			url: baseUrl + 'admin/hr/employees/update-profile-pic',
			type: "POST",
			data: formData,
			contentType: false,
			processData: false,
			success: function (response) {
				let data = JSON.parse(response);

				if (data.type === 'success') {

					$('#uploadStatus').html('<div class="alert alert-success">' + data.message + '</div>');

					// Update profile image immediately
					if (data.profile_picture_url) {
						$('#profilePicture').attr('src', data.profile_picture_url + '?v=' + Date.now());
					}

					// Close modal
					setTimeout(() => {
						window.location.reload();
					}, 700);

				} else {
					$('#uploadStatus').html('<div class="alert alert-danger">' + data.message + '</div>');
				}
			},
			error: function () {
				$('#uploadStatus').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
			}
		});

	}, "image/png"); // Force PNG format
});

function removeProfilePicture() {

    Swal.fire({
        title: "Are you sure?",
        text: "This will remove the employee's profile picture.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, remove it",
        cancelButtonText: "No, cancel"
    }).then((result) => {

        if (result.isConfirmed) {

            let emp_id = $("input[name=emp_id]").val();

            $.ajax({
                url: baseUrl + 'admin/hr/employees/remove-profile-pic',
                type: "POST",
                data: { emp_id: emp_id },
                success: function (response) {

                    let data = JSON.parse(response);

                    if (data.type === "success") {

                        Swal.fire({
                            title: "Removed!",
                            text: data.message,
                            icon: "success",
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Update image to default
                        $('#profilePicture').attr('src', baseUrl + 'images/user-img.png?v=' + Date.now());

                        // Close modal smoothly
                        setTimeout(() => {
                            window.location.reload();
                        }, 800);

                    } else {
                        Swal.fire("Error", data.message, "error");
                    }
                },
                error: function () {
                    Swal.fire("Error", "Unable to remove picture.", "error");
                }
            });
        }
    });
}