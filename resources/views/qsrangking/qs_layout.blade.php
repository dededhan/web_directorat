<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Str::ucfirst($category)  }} form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #176369;
            --primary-light: #207378;
            --primary-dark: #0e4548;
        }
        
        body {
            background: #e6f0f1;
            padding: 2rem;
        }
        
        .form-container {
            max-width: 100%;
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(23, 99, 105, 0.1);
        }
        
        h2 {
            color: var(--primary-color);
            margin-bottom: 2rem;
            font-weight: 600;
        }
        
        .form-section {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #dde5e6;
        }
        
        .form-group {
            flex: 1;
            min-width: 200px;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--primary-color);
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #a3c7c9;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(23, 99, 105, 0.2);
            outline: none;
        }
        
        .radio-group {
            display: flex;
            gap: 1rem;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-submit {
            background: var(--primary-color);
            color: white;
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        
        .btn-submit:hover {
            background: var(--primary-light);
        }
        .section-title {
            width: 100%;
            color: var(--primary-color);
            font-size: 1.25rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary-color);
        }
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .form-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
<body>
    <div class="form-container">
        <h2>{{ Str::ucfirst($category) }} Respondent Form</h2>
        @yield('form')
    </div>

</body>