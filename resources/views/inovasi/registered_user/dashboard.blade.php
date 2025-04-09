@extends('Inovasi.registered_user.index')

@section('contentregistered_user')
    <div class="head-title">
        <div class="left">
            <h1>Payment Confirmation</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Payment</a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Alert Messages -->
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class='bx bx-info-circle me-2'></i>
        Please upload your payment receipt to confirm your registration.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Upload Payment Receipt</h3>
            </div> 

            <form id="payment-form" method="POST" action="#" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="payment-info-box">
                            <h4><i class='bx bx-credit-card'></i> Payment Information</h4>
                            <ul>
                                <li>Bank Transfer: <strong>Bank Mandiri</strong></li>
                                <li>Account Number: <strong>1234-5678-9012-3456</strong></li>
                                <li>Account Name: <strong>Pusat Inovasi dan Teknologi</strong></li>
                                <li>Amount: <strong>Rp 500.000</strong></li>
                            </ul>
                            <div class="alert alert-warning">
                                <i class='bx bx-error me-2'></i>
                                Please make sure your payment includes your <strong>full name</strong> and <strong>registration number</strong> in the transaction description.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="upload-container">
                            <label for="payment_receipt" class="form-label">Payment Receipt</label>
                            <div class="upload-area" id="uploadArea">
                                <div class="upload-icon-container">
                                    <i class='bx bx-upload upload-icon'></i>
                                </div>
                                <div class="upload-text">
                                    <p>Drag and drop your payment receipt here</p>
                                    <p class="or-text">OR</p>
                                    <button type="button" class="browse-btn" id="browseBtn">Browse Files</button>
                                </div>
                                <input type="file" name="payment_receipt" id="payment_receipt" class="file-input" accept="image/*" hidden>
                            </div>
                            <div class="form-text text-muted">
                                <ul class="file-requirements">
                                    <li>Upload a clear image of your payment receipt/screenshot</li>
                                    <li>Acceptable formats: JPG, PNG, or PDF</li>
                                    <li>Make sure all payment details are clearly visible</li>
                                    <li>Maximum file size: 5MB</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="payment_confirm" name="payment_confirm" required>
                            <label class="form-check-label" for="payment_confirm">
                                I confirm that I have completed the payment and the uploaded receipt is valid.
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mb-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-check-circle me-1'></i> Submit Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-data mt-4">
        <div class="order">
            <div class="head">
                <h3>Payment Status</h3>
            </div>
            
            <div class="status-container">
                <div class="status-item">
                    <div class="status-icon pending">
                        <i class='bx bx-time'></i>
                    </div>
                    <div class="status-details">
                        <h4>Payment Pending</h4>
                        <p>Your payment is awaiting verification by our admin team.</p>
                        <p class="status-date">Submitted: 28 March 2025</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-data {
            margin-top: 24px;
        }

        .order {
            background: #fff;
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .payment-info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .payment-info-box h4 {
            color: #2c3e50;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .payment-info-box h4 i {
            margin-right: 10px;
            color: #3498db;
        }

        .payment-info-box ul {
            padding-left: 15px;
            margin-bottom: 15px;
        }

        .payment-info-box li {
            margin-bottom: 8px;
        }

        .upload-container {
            margin-bottom: 20px;
        }

        .upload-area {
            border: 2px dashed #3498db;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #f8f9fe;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 200px;
        }

        .upload-area:hover {
            background-color: #ecf0f1;
        }

        .upload-icon-container {
            margin-bottom: 15px;
        }

        .upload-icon {
            font-size: 60px;
            color: #3498db;
        }

        .upload-text {
            color: #7f8c8d;
        }

        .upload-text p {
            margin-bottom: 10px;
        }

        .or-text {
            font-weight: bold;
            margin: 10px 0;
        }

        .browse-btn {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .browse-btn:hover {
            background-color: #2980b9;
        }

        .file-requirements {
            padding-left: 20px;
            margin-top: 10px;
        }

        .file-requirements li {
            font-size: 13px;
            margin-bottom: 5px;
            color: #7f8c8d;
        }

        .form-check {
            margin-top: 15px;
        }

        .status-container {
            margin-top: 15px;
        }

        .status-item {
            display: flex;
            align-items: flex-start;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .status-icon {
            margin-right: 15px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .status-icon.pending {
            background-color: #f39c12;
            color: white;
        }

        .status-icon.approved {
            background-color: #27ae60;
            color: white;
        }

        .status-icon.rejected {
            background-color: #e74c3c;
            color: white;
        }

        .status-icon i {
            font-size: 20px;
        }

        .status-details h4 {
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .status-details p {
            color: #7f8c8d;
            margin-bottom: 5px;
        }

        .status-date {
            font-size: 12px;
            color: #95a5a6;
        }

        /* Responsive fixes */
        @media (max-width: 768px) {
            .upload-area {
                padding: 20px;
            }
            
            .upload-icon {
                font-size: 40px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadArea = document.getElementById('uploadArea');
            const fileInput = document.getElementById('payment_receipt');
            const browseBtn = document.getElementById('browseBtn');
            
            // Browse button click handler
            browseBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                fileInput.click();
            });
            
            // Upload area click handler
            uploadArea.addEventListener('click', function() {
                fileInput.click();
            });
            
            // File selected handler
            fileInput.addEventListener('change', function() {
                if (fileInput.files.length > 0) {
                    const fileName = fileInput.files[0].name;
                    
                    // Show file name in upload area
                    const uploadText = document.querySelector('.upload-text p:first-child');
                    uploadText.textContent = `Selected file: ${fileName}`;
                    
                    // Change upload area style
                    uploadArea.style.borderColor = '#27ae60';
                    
                    // Change icon
                    const uploadIcon = document.querySelector('.upload-icon');
                    uploadIcon.classList.remove('bx-upload');
                    uploadIcon.classList.add('bx-check-circle');
                    uploadIcon.style.color = '#27ae60';
                }
            });
            
            // Drag and drop functionality
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            // Highlight drop area when dragging over it
            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                uploadArea.style.backgroundColor = '#eaf2f8';
                uploadArea.style.borderColor = '#3498db';
            }
            
            function unhighlight() {
                uploadArea.style.backgroundColor = '#f8f9fe';
                uploadArea.style.borderColor = '#3498db';
            }
            
            // Handle dropped files
            uploadArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                fileInput.files = files;
                
                if (files.length > 0) {
                    const fileName = files[0].name;
                    
                    // Show file name in upload area
                    const uploadText = document.querySelector('.upload-text p:first-child');
                    uploadText.textContent = `Selected file: ${fileName}`;
                    
                    // Change upload area style
                    uploadArea.style.borderColor = '#27ae60';
                    
                    // Change icon
                    const uploadIcon = document.querySelector('.upload-icon');
                    uploadIcon.classList.remove('bx-upload');
                    uploadIcon.classList.add('bx-check-circle');
                    uploadIcon.style.color = '#27ae60';
                }
            }
            
            // Form submission
            const paymentForm = document.getElementById('payment-form');
            paymentForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Here you would normally process the form submission
                // For now, just show a success message
                alert('Payment receipt submitted successfully. Our team will verify your payment shortly.');
            });
        });
    </script>
@endsection