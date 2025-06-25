<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Str::ucfirst($category ?? 'Survey') }} Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #176369;
            --secondary-color: #f0f7f8;
            --font-color: #333;
            --border-color: #dde5e6;
            --shadow-color: rgba(23, 99, 105, 0.1);
        }
        
        body {
            background-color: var(--secondary-color);
            padding: 2rem;
            font-family: 'Inter', sans-serif;
        }
        
        .form-container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 2.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 8px 15px var(--shadow-color);
        }
        
        h2 {
            color: var(--primary-color);
            margin-bottom: 2.5rem;
            font-weight: 700;
            text-align: center;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem 2rem;
        }

        @media (min-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr 1fr; /* Two columns on larger screens */
            }
        }
        
        .form-section {
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
            grid-column: 1 / -1; /* Make sections span all columns */
        }
        
        .section-title {
            width: 100%;
            color: var(--primary-color);
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }

        .full-width {
            grid-column: 1 / -1; /* Make element span all columns */
        }
        
        .form-label {
            font-weight: 500;
            color: var(--font-color);
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            width: 100%;
            padding: 0.6rem;
            border: 1px solid #a3c7c9;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(23, 99, 105, 0.2);
            outline: none;
        }
        
        .radio-group {
            display: flex;
            gap: 1.5rem;
            align-items: center;
            height: 100%;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-submit {
            background: var(--primary-color);
            color: white;
            padding: 0.8rem 2.5rem;
            border: none;
            border-radius: 0.375rem;
            font-weight: 600;
            transition: background-color 0.2s;
            width: 100%;
            margin-top: 1rem;
        }
        
        .btn-submit:hover {
            background-color: #207378;
        }

        .success-message {
            text-align: center;
            padding: 1rem;
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
            border-radius: .375rem;
            margin-bottom: 2rem;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <h2>{{ Str::ucfirst($category ?? 'Survey') }} Respondent Form</h2>

        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        
        @yield('form')
    </div>
</body>
</html>
