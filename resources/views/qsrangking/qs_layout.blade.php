<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <title>{{ Str::ucfirst($category ?? 'Survey') }} Form</title>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tailwind CDN with Preflight disabled to avoid resets/collisions -->
    <script>
        window.tailwind = {
            config: {
                theme: {
                    extend: {
                        colors: {
                            unj: {
                                primary: '#176369',
                                primaryDark: '#0f4a4f',
                                accent: '#22c55e'
                            }
                        }
                    }
                },
                corePlugins: {
                    preflight: false
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary-color: #176369;
            --secondary-color: #f0f7f8;
            --font-color: #333;
            --border-color: #dde5e6;
            --shadow-color: rgba(23, 99, 105, 0.1);
        }
        
        body {
            background: radial-gradient(1200px 800px at 10% -10%, rgba(23, 99, 105, 0.08), transparent),
                        radial-gradient(1000px 600px at 100% 0%, rgba(34, 197, 94, 0.06), transparent),
                        var(--secondary-color);
            padding: 2rem;
            font-family: 'Inter', sans-serif;
        }
        
        .form-container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 2.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 30px var(--shadow-color);
            border: 1px solid rgba(23, 99, 105, 0.08);
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
            padding-top: .5rem;
        }
        
        .section-title {
            width: 100%;
            color: var(--primary-color);
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: .5rem;
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
            background-color: #ffffff;
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
            letter-spacing: .2px;
            box-shadow: 0 6px 14px rgba(23, 99, 105, 0.25);
        }
        
        .btn-submit:hover {
            background-color: #207378;
            transform: translateY(-1px);
            box-shadow: 0 10px 18px rgba(23, 99, 105, 0.28);
        }

        .success-message {
            text-align: center;
            padding: 1rem;
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            border-radius: .375rem;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
        }

        /* Category chip */
        .chip {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .35rem .7rem;
            font-size: .8rem;
            line-height: 1rem;
            border-radius: 9999px;
            background: rgba(23, 99, 105, .08);
            color: var(--primary-color);
            border: 1px solid rgba(23, 99, 105, 0.15);
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <div class="mb-6">
            <div class="flex items-center justify-center gap-3 mb-3">
                <span class="chip">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                    </svg>
                    {{ Str::ucfirst($category ?? 'Survey') }}
                </span>
            </div>
            <h2 class="text-2xl md:text-3xl !mb-2">{{ Str::ucfirst($category ?? 'Survey') }} Respondent Form</h2>
            <p class="text-center text-slate-600 text-sm">
                Please complete the form below. Fields marked with an asterisk (*) are required.
            </p>
        </div>

        @if(session('success'))
            <div class="success-message">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-7.5 9.5a.75.75 0 01-1.127.06l-4.5-4.5a.75.75 0 011.06-1.06l3.872 3.872 6.986-8.85a.75.75 0 011.066-.074z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        
        @yield('form')
    </div>
</body>
</html>
