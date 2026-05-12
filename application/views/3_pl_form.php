<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <base href="<?php echo base_url(); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Own-Fleet Profile</title>
    <link rel="shortcut icon" type="admin_assets/images/favicon.ico" href="favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Sweet Alert-->
	<link href="<?php echo base_url('admin_assets/libs/sweetalert2/sweetalert2.min.css'); ?>" rel="stylesheet" type="text/css" />
    <style>
        body {
            background: #f8f9fa;
            font-family: "Inter", sans-serif;

        }

        .card-custom {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 1px 4px 0 rgba(41, 43, 47, .16);
            overflow: hidden;
            width: 800px;
            margin: 0 auto;
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #b0e3b0;
            font-weight: 600;
            font-size: 18px;
        }

        .form-section {
            background: #f4f7f4;
            padding: 45px;
            border-radius: 6px;
        }

        .form-control,
        .form-select {
            border-radius: 6px;
            border: 1px solid #cfdbe6;
            font-size: 13px;
            padding: 8px 10px;
        }

        .btn-toggle {
            border-radius: 25px;
            padding: 4px 20px;
            font-weight: 500;
            font-size: 14px;
        }

        .btn-toggle.active {
            background: #0d6efd;
            color: #fff;
        }

        .upload-box {
            border: 2px dashed #9ac6f3;
            background: #eaf6ff;
            border-radius: 6px;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #555;
        }

        .upload-box a {
            display: block;
            font-weight: 600;
            color: #0d6efd;
            margin-bottom: 5px;
            text-decoration: none;
        }

        .btn-submit {
            background: #005500;
            border: none;
            padding: 8px 30px;
            font-size: 13px;
            border-radius: 6px;
            color: #fff !important;
        }

        .btn-submit:hover {
            background-color: #057205;
        }

        .referralTop p {
            color: #71828c;
            font-size: 13px;
        }

        .form-check-input {
            display: none;
        }

        /* Custom styles for the labels to act as buttons */
        .form-check-label {
            display: inline-block;
            padding: 6px 13px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            color: #000;
            background-color: #c8e7c8;
            transition: background-color 0.3s, color 0.3s;
            font-size: 13px;
        }

        /* Hover effect */
        .form-check-label:hover {
            background-color: #b5dab5;
        }

        /* Checked state styling */
        .form-check-input:checked+.form-check-label {
            background-color: #005500;
            color: white !important;
            border-color: #005500;
        }

        /* Focus state when the radio button is selected */
        .form-check-input:focus+.form-check-label {
            box-shadow: 0 0 0 0.25rem rgba(38, 143, 255, 0.5);
        }

        .form-card h6 {
            color: #151617;
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
            font-size: 12px;
            color: #3e4448;
            margin-bottom: 4px;
        }

        .form-control {
            background-color: transparent;
            border-color: #b7dfb7;
            padding: 6px 8px;
            color: #000;
        }

        .form-control:focus {
            box-shadow: none;
            background-color: transparent;
            border-color: #6baf6b
        }

        .cursor-pointer {
            cursor: pointer;
        }

        input.date-placholder {
            color: #6baf6b;
        }

        .select2-container .select2-selection--single {
            height: 35px;
            border-radius: 6px;
            border-color: #b7dfb7;
            background: transparent;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 34px;
            font-size: 13px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 35px;
        }

        .select2-results__option[aria-selected] {
            font-size: 12px;
        }

        .select2-dropdown {
            background-color: #f4f7f4;
        }

        input[readonly] {
            background-color: #d9edd9;
        }

        .upload-area span {
            font-size: 13px;
        }

        .upload-area svg path {
            fill: #6baf6b;
        }

        .upload-area {
            border: 1px dashed #a3d7a3;
            background-color: #e2ebe2;
            color: #6baf6b;
            border-radius: 6px;
            padding: 16px 9px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .upload-area:hover {
            border-color: #5ea35e;
        }

        .upload-area .icon {
            font-size: 1.5rem;
            display: block;
            margin-bottom: 5px;
        }

        .upload-area .title {
            font-weight: 500;
        }

        .upload-area .subtitle {
            font-size: 0.60rem;
            color: #6c757d;
        }

        input[type="file"] {
            display: none;
        }

        #preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 15px;
        }

        .preview-image {
            position: relative;
            display: inline-block;
            margin-top: 17px;
        }

        .preview-image img {
            max-width: 43px;
            max-height: 43px;
            border-radius: 4px;
        }

        .remove-btn {
            position: absolute;
            top: -8px;
            right: -6px;
            background: #71828c;
            color: white;
            border-radius: 50%;
            height: 15px;
            width: 15px;
            font-size: 12px;
            cursor: pointer;
            z-index: 10;
            line-height: 1;
            display: none;
        }

        .preview-image:hover .remove-btn {
            display: flex;
            align-items: center;
            justify-content: center
        }

        .file-name {
            display: inline-block;
            max-width: 5ch;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 12px;
        }

        .preview-image {
            border: 1px solid #a3d7a3;
            padding: 3px 4px;
            border-radius: 6px;
        }

        input.error, select.error, textarea.error {
            border-color: red !important;
        }

        .invalid-feedback{
            position: absolute;
            bottom: -19px;
            font-size: 11px;
        }

        .upload-area.is-invalid {
            border-color: #dc3545 !important;
        }

        .select2-container.is-invalid .select2-selection {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220,53,69,.25);
            border-radius: 0.375rem; /* match bootstrap input radius */
        }

        @media (max-width: 800px) {
            .card-custom {
                width: 100%;
            }

            .form-section {
                padding: 25px;
            }
        }

        @media (max-width:768px) {
            .card-header {
                font-size: 15px;
            }

            .form-section {
                padding: 15px;
            }

            .form-card h6 {
                font-size: 14px;
            }
        }

        @media (max-width:576.99px) {
            .form-control {
                padding: 10px 8px;
            }

            .form-label {
                font-size: 13px;
            }

            .card-header {
                position: fixed;
                top: 0;
                width: 100%;
                background: #fff;
                z-index: 1;
            }

            .card-custom form {
                margin: 56px 0 75px;
            }

            .text-end {
                position: fixed;
                bottom: 0;
                width: 100%;
                background: #fff;
                z-index: 1;
            }

            .btn-submit {
                width: 100%;
                padding: 11px 30px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <div class="my-md-4">
        <div class="card-custom">
            <div class="p-3 p-md-4 card-header">
                Create Your Own-Fleet Profile
            </div>
            <form id="riderApplicationForm" enctype="multipart/form-data" novalidate>
                <div class="form-section">
                    <!-- Referral -->
                    <div class="referralTop">
                        <p class="w-full mb-2">Referral?</p>
                        <div class="gap-2 d-flex">
                            <div class="p-0 m-0 form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="options" id="yesOption" value="yes">
                                <label class="form-check-label" for="yesOption">Yes</label>
                            </div>
                            <div class="p-0 m-0 form-check form-check-inline">
                                <input checked class="form-check-input" type="radio" name="options" id="noOption" value="no">
                                <label class="form-check-label" for="noOption">No</label>
                            </div>
                        </div>
                    </div>

                    <!-- Referrer Info -->
                    <div class="mt-3 mt-md-5 form-card" id="referrerSection">
                        <h6 class="mb-2 mb-md-3">Referrer Info</h6>
                        <div class="row g-md-4 g-2">
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between">
                                    <label class="form-label">Full Name / اسم المتقدم الكامل</label>
                                    <input type="text" class="form-control" name="referrer_full_name">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between">
                                    <label class="form-label">Referrer Mobile / رقم جوال الوسيط</label>
                                    <input type="text" class="form-control" name="referrer_mobile" maxlength="10">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between">
                                    <label class="form-label">Referrer Iqama/ID / رقم هوية الوسيط</label>
                                    <input type="text" class="form-control" name="referrer_iqama_id" maxlength="10">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between">
                                    <label class="form-label">Referrer HungerStation ID / رقم معرف هنقرستيشن</label>
                                    <input type="text" class="form-control" name="referrer_hungerstation_id" maxlength="7">
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-8">
                                <div class="d-flex flex-column h-100 justify-content-between">
                                    <label class="form-label">Referrer IBAN / ايبان الوسيط</label>
                                    <input type="text" class="form-control" name="referrer_iban" maxlength="24">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rider Information & Documents -->
                    <div class="mt-3 mt-md-5 form-card">
                        <h6 class="mb-2 mb-md-3">Rider Information & Documents</h6>
                        <div class="row g-4">
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                                    <label class="form-label">Full Name / اسم المتقدم الكامل <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="rider_full_name" required>
                                    <div class="invalid-feedback">
                                        This field is required.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                                    <label class="form-label">Mobile Number / رقم الجوال <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="rider_mobile" minlength="10" maxlength="10" required>
                                    <div class="invalid-feedback">Enter a valid mobile number.</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                                    <label class="form-label">Iqama Or ID / رقم الاقامة او الهوية <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="rider_iqama_id" minlength="10" maxlength="10" required>
                                    <div class="invalid-feedback">Enter a valid Iqama/ID number.</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                                    <label class="form-label">Iqama/ID Expiry Date / تاريخ انتهاء الهوية <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="rider_iqama_expiry" required>
                                    <div class="invalid-feedback">Enter a valid Iqama/ID expiry date.</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                                    <label class="form-label">Nationality / الجنسية <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="nationality" required>
                                        <option value="">-- Select Country --</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="India">India</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="Sudan">Sudan</option>
                                    </select>
                                    <div class="invalid-feedback">This field is required.</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                                    <label class="form-label">Email / البريد الإلكتروني <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" required>
                                    <div class="invalid-feedback">Enter a valid email address.</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                                    <label class="form-label">Date Of Birth / تاريخ الميلاد <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="dob" required>
                                    <div class="invalid-feedback">Enter a valid date of birth.</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                                    <label class="form-label">Age / العمر</label>
                                    <input readonly type="text" class="form-control" name="age">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                                    <label class="form-label">Rider City / المدينة <span class="text-danger">*</span></label>
                                    <select class="form-select select2" name="rider_city" required>
                                        <option value="">Please Select</option>
                                        <option value="Riyadh">Riyadh</option>
                                        <option value="Jeddah">Jeddah</option>
                                    </select>
                                    <div class="invalid-feedback">This field is required.</div>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                                    <label class="form-label">IBAN Number / رقم الايبان <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="rider_iban" maxlength="24" required>
                                    <div class="invalid-feedback">Enter a valid IBAN number.</div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="d-flex flex-column h-100 justify-content-between position-relative">
                                    <label class="form-label">Saudi / Non-Saudi</label>
                                    <input readonly type="text" class="form-control" name="saudi_status" value="Non-Saudi">
                                </div>
                            </div>
                            <div class="row row g-4">
                                <!-- File Input 1 -->
                                <div class="col-md-4 col-sm-12">
                                    <div class="d-flex flex-column justify-content-center position-relative">
                                        <label class="form-label">Iqama or ID Photocopy / صورة الهوية أو الإقامة</label>
                                        <div class="mt-0 position-relative">
                                            <label for="fileInput1">
                                                <div class="upload-area">
                                                    <div class="gap-1 mb-1 d-flex justify-content-center align-items-center title">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 12 12"><path fill="var(--kf-color-gray-700,#545C6B)" fill-rule="evenodd" d="M7.753 2.36a1.975 1.975 0 0 0-2.793 0L2.585 4.735a3.212 3.212 0 1 0 4.543 4.543l3.375-3.375a.5.5 0 1 1 .707.707L7.835 9.985a4.212 4.212 0 1 1-5.957-5.957l2.375-2.375A2.975 2.975 0 0 1 8.46 5.86L6.085 8.235a1.737 1.737 0 0 1-2.457-2.457l2.375-2.375a.5.5 0 0 1 .707.707L4.335 6.485a.737.737 0 1 0 1.043 1.043l2.375-2.375a1.975 1.975 0 0 0 0-2.793Z" clip-rule="evenodd"></path></svg>
                                                        <span>Upload files</span>
                                                    </div>
                                                    <div class="subtitle">Drag and drop files or paste from clipboard</div>
                                                </div>
                                            </label>
                                            <input type="file" id="fileInput1" accept="image/*" multiple required>
                                            <div class="invalid-feedback">This field is required.</div>
                                            <div id="preview1"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- File Input 2 -->
                                <div class="col-md-4 col-sm-12">
                                    <div class="d-flex flex-column justify-content-center">
                                        <label class="form-label">Driver's License Photocopy / صورة الرخصة</label>
                                        <div class="mt-0 position-relative">
                                            <label for="fileInput2">
                                                <div class="upload-area">
                                                    <div class="gap-1 mb-1 d-flex justify-content-center align-items-center title">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 12 12"><path fill="var(--kf-color-gray-700,#545C6B)" fill-rule="evenodd" d="M7.753 2.36a1.975 1.975 0 0 0-2.793 0L2.585 4.735a3.212 3.212 0 1 0 4.543 4.543l3.375-3.375a.5.5 0 1 1 .707.707L7.835 9.985a4.212 4.212 0 1 1-5.957-5.957l2.375-2.375A2.975 2.975 0 0 1 8.46 5.86L6.085 8.235a1.737 1.737 0 0 1-2.457-2.457l2.375-2.375a.5.5 0 0 1 .707.707L4.335 6.485a.737.737 0 1 0 1.043 1.043l2.375-2.375a1.975 1.975 0 0 0 0-2.793Z" clip-rule="evenodd"></path></svg>
                                                        <span>Upload files</span>
                                                    </div>
                                                    <div class="subtitle">Drag and drop files or paste from clipboard</div>
                                                </div>
                                            </label>
                                            <input type="file" id="fileInput2" accept="image/*" multiple required>
                                            <div class="invalid-feedback">This field is required.</div>
                                            <div id="preview2"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- File Input 3 -->
                                <div class="col-md-4 col-sm-12">
                                    <div class="d-flex flex-column justify-content-center">
                                        <label class="form-label">IBAN Certificate Photocopy / صورة ايبان</label>
                                        <div class="mt-0 position-relative">
                                            <label for="fileInput3">
                                                <div class="upload-area">
                                                    <div class="gap-1 mb-1 d-flex justify-content-center align-items-center title">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 12 12"><path fill="var(--kf-color-gray-700,#545C6B)" fill-rule="evenodd" d="M7.753 2.36a1.975 1.975 0 0 0-2.793 0L2.585 4.735a3.212 3.212 0 1 0 4.543 4.543l3.375-3.375a.5.5 0 1 1 .707.707L7.835 9.985a4.212 4.212 0 1 1-5.957-5.957l2.375-2.375A2.975 2.975 0 0 1 8.46 5.86L6.085 8.235a1.737 1.737 0 0 1-2.457-2.457l2.375-2.375a.5.5 0 0 1 .707.707L4.335 6.485a.737.737 0 1 0 1.043 1.043l2.375-2.375a1.975 1.975 0 0 0 0-2.793Z" clip-rule="evenodd"></path></svg>
                                                        <span>Upload files</span>
                                                    </div>
                                                    <div class="subtitle">Drag and drop files or paste from clipboard</div>
                                                </div>
                                            </label>
                                            <input type="file" id="fileInput3" accept="image/*" multiple required>
                                            <div class="invalid-feedback">This field is required.</div>
                                            <div id="preview3"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- File Input 4 -->
                                <div class="col-md-4 col-sm-12">
                                    <div class="d-flex flex-column justify-content-center">
                                        <label class="form-label">Personal Photograph / صورة شخصية</label>
                                        <div class="mt-0 position-relative">
                                            <label for="fileInput4">
                                                <div class="upload-area">
                                                    <div class="gap-1 mb-1 d-flex justify-content-center align-items-center title">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 12 12"><path fill="var(--kf-color-gray-700,#545C6B)" fill-rule="evenodd" d="M7.753 2.36a1.975 1.975 0 0 0-2.793 0L2.585 4.735a3.212 3.212 0 1 0 4.543 4.543l3.375-3.375a.5.5 0 1 1 .707.707L7.835 9.985a4.212 4.212 0 1 1-5.957-5.957l2.375-2.375A2.975 2.975 0 0 1 8.46 5.86L6.085 8.235a1.737 1.737 0 0 1-2.457-2.457l2.375-2.375a.5.5 0 0 1 .707.707L4.335 6.485a.737.737 0 1 0 1.043 1.043l2.375-2.375a1.975 1.975 0 0 0 0-2.793Z" clip-rule="evenodd"></path></svg>
                                                        <span>Upload files</span>
                                                    </div>
                                                    <div class="subtitle">Drag and drop files or paste from clipboard</div>
                                                </div>
                                            </label>
                                            <input type="file" id="fileInput4" accept="image/*" multiple required>
                                            <div class="invalid-feedback">This field is required.</div>
                                            <div id="preview4"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="px-3 py-3 text-end form-footer">
                    <button type="submit" class="btn btn-submit">Submit</button>
                </div>
            </form>

        </div>
    </div>

    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <!-- Sweet Alerts js -->
    <script src="<?php echo base_url('admin_assets/libs/sweetalert2/sweetalert2.min.js');?>"></script>

    <!-- Scripts -->
    <script>
        $(document).ready(function() {
            // Toggle Referrer Section
            function toggleReferrerSection() {
                if ($("#yesOption").is(":checked")) $("#referrerSection").show();
                else $("#referrerSection").hide();
            }
            $("input[name='options']").on("change", toggleReferrerSection);
            toggleReferrerSection();

            // Initialize Select2
            $('.select2').select2();

            // File Upload to Temp
            function setupTempUpload(fileInputId, previewId) {
                const input = document.getElementById(fileInputId);
                input.addEventListener('change', function() {
                    const preview = document.getElementById(previewId);
                    const files = Array.from(this.files);

                    files.forEach(file => {
                        if (!file.type.startsWith('image/')) return;

                        const formData = new FormData();
                        formData.append('file', file);

                        // --- Create loader UI ---
                        const loaderWrapper = document.createElement('div');
                        loaderWrapper.classList.add('upload-loader');
                        loaderWrapper.innerHTML = `
                            <div class="gap-2 d-flex align-items-center mt-2">
                                <div class="spinner-border text-primary" role="status" style="width:25px;height:25px;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span class="text-muted">Uploading ${file.name}...</span>
                            </div>
                        `;
                        preview.appendChild(loaderWrapper);

                        $.ajax({
                            url: "<?php echo base_url('welcome/upload_temp'); ?>",
                            type: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType: "json",
                            success: function(res){
                                loaderWrapper.remove(); // remove loader after upload
                                if(res.status === 'success'){
                                    // Hidden input
                                    const hiddenInput = document.createElement('input');
                                    hiddenInput.type = 'hidden';
                                    hiddenInput.name = 'uploaded_files[]';
                                    hiddenInput.value = res.temp_file;
                                    preview.appendChild(hiddenInput);

                                    // Preview
                                    const wrapper = document.createElement('div');
                                    wrapper.classList.add('preview-image');
                                    wrapper.innerHTML = `
                                        <div class="gap-2 d-flex align-items-center mt-2">
                                            <img src="${res.file_url}" style="width:43px;height:43px;object-fit:cover;border:1px solid #ccc;border-radius:4px;" />
                                            <div class="d-flex flex-column">
                                                <span class="file-name">${file.name}</span>
                                                <span class="remove-btn" style="cursor:pointer;color:red;font-weight:bold;">&times;</span>
                                            </div>
                                        </div>
                                    `;
                                    wrapper.querySelector('.remove-btn').addEventListener('click', ()=>{
                                        $.post("<?php echo base_url('welcome/delete_temp'); ?>", {file: res.temp_file});
                                        wrapper.remove();
                                        hiddenInput.remove();
                                        Swal.fire({
                                            icon: 'info',
                                            title: 'Removed!',
                                            text: 'File removed successfully.',
                                            timer: 1500,
                                            showConfirmButton: false
                                        });
                                    });
                                    preview.appendChild(wrapper);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Upload Failed',
                                        text: res.message || 'Something went wrong!'
                                    });
                                }
                            },
                            error: function(){
                                loaderWrapper.remove(); // remove loader on error
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: '❌ Error uploading file.'
                                });
                            }
                        });
                    });
                    this.value = '';
                });
            }

            setupTempUpload('fileInput1','preview1');
            setupTempUpload('fileInput2','preview2');
            setupTempUpload('fileInput3','preview3');
            setupTempUpload('fileInput4','preview4');

            // File input change handler to remove required/red border dynamically
            $(document).ready(function() {
                $("input[type='file']").on("change", function() {
                    const $el = $(this);
                    const uploadArea = $el.closest(".position-relative").find(".upload-area");

                    if ($el[0].files.length > 0) {
                        // Remove red border from the input itself or the container
                        $el.removeClass("is-invalid");
                        $(uploadArea).removeClass("is-invalid");

                        // Hide the error message
                        // This will check for both .invalid-feedback as sibling or inside container
                        const feedback = $el.siblings(".invalid-feedback, .error-message").first();
                        feedback.removeClass("d-block").hide();
                    }
                });
            });

            // Form Submit
            $("#riderApplicationForm").on("submit", function(e) {
                e.preventDefault();
                let form = this;

                // Clear previous errors
                $(".error-text, .invalid-feedback").remove();
                $(".is-invalid").removeClass("is-invalid");

                let isValid = true;

                // Validate all required fields
                $(form).find("[required]").each(function() {
                    const $el = $(this);

                    // Select2 fields
                    if ($el.is('select')) {
                        if (!$el.val()) {
                            isValid = false;
                            $el.next('.select2-container').addClass('is-invalid');
                            if($el.siblings('.invalid-feedback').length === 0){
                                $el.after('<div class="invalid-feedback">This field is required.</div>');
                            } else {
                                $el.siblings('.invalid-feedback').show();
                            }
                        } else {
                            $el.next('.select2-container').removeClass('is-invalid');
                            $el.siblings('.invalid-feedback').hide();
                        }

                    // File inputs
                    } else if ($el.attr('type') === 'file') {
                        const previewId = $el.attr('id').replace('fileInput', 'preview');
                        const preview = $("#" + previewId);
                        const $uploadArea = $el.closest('div').find('.upload-area');

                        // Check if any file uploaded (hidden input)
                        const hasUploaded = preview.find('input[type="hidden"]').length > 0;

                        if ($el[0].files.length === 0 && !hasUploaded) {
                            isValid = false;

                            // Add red border
                            $uploadArea.addClass('is-invalid');

                            // Show invalid feedback
                            if($el.siblings('.invalid-feedback').length === 0){
                                $el.after('<div class="invalid-feedback d-block">This field is required.</div>');
                            } else {
                                $el.siblings('.invalid-feedback').addClass('d-block').show();
                            }
                        } else {
                            // Remove red border
                            $uploadArea.removeClass('is-invalid');
                            $el.siblings('.invalid-feedback').removeClass('d-block').hide();
                        }

                    // Normal inputs
                    } else {
                        if (!$el.val()) {
                            isValid = false;
                            $el.addClass('is-invalid');
                            if($el.siblings('.invalid-feedback').length === 0){
                                $el.after('<div class="invalid-feedback">This field is required.</div>');
                            } else {
                                $el.siblings('.invalid-feedback').show();
                            }
                        } else {
                            $el.removeClass('is-invalid');
                            $el.siblings('.invalid-feedback').hide();
                        }
                    }
                });

                if (!isValid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Please fill all required fields.'
                    });
                    return false;
                }

                // Proceed with AJAX submit
                let formData = new FormData(form);
                $.ajax({
                    url: "<?php echo base_url('welcome/save_application'); ?>",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    beforeSend: function() {
                        $(".btn-submit").prop("disabled", true).text("Saving...");
                    },
                    success: function(res) {
                        $(".btn-submit").prop("disabled", false).text("Submit");
                        if (res.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Uploaded!',
                                text: res.message || "Application submitted successfully!",
                                timer: 1500,
                                showConfirmButton: false
                            });
                            form.reset();
                            $(".select2").val(null).trigger("change");
                            $(".preview-image").remove();
                        } else if (res.status === 'error' && res.errors) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Server validation errors, check fields!'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.message || "Something went wrong!"
                            });
                        }
                    },
                    error: function() {
                        $(".btn-submit").prop("disabled", false).text("Submit");
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Server error, please try again.'
                        });
                    }
                });
            });

            
            // Auto-calculate Age when DOB is entered/changed
            $(document).on("change keyup", "input[name='dob']", function () {
                const dob = new Date(this.value);
                if (!isNaN(dob)) {
                    const today = new Date();

                    let years = today.getFullYear() - dob.getFullYear();
                    let months = today.getMonth() - dob.getMonth();
                    let days = today.getDate() - dob.getDate();

                    // Adjust months and years if birthday hasn't happened yet this year/month
                    if (days < 0) months--;
                    if (months < 0) {
                        years--;
                        months += 12;
                    }

                    let ageText = "";
                    if (years > 0) ageText += years + " year" + (years > 1 ? "s " : " ");
                    if (months > 0) ageText += months + " month" + (months > 1 ? "s" : "");
                    if (!ageText) ageText = "0 month"; // less than 1 month old

                    $("input[name='age']").val(ageText.trim());
                } else {
                    $("input[name='age']").val('');
                }
            });

        });
    </script>
</body>

</html>