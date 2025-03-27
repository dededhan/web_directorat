<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document->judul_dokumen }} - Preview Error</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', Arial, sans-serif;
            color: #333;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        .header {
            background-color: #fff;
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            flex: 1;
        }
        
        .error-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
            text-align: center;
            margin-top: 40px;
        }
        
        .error-icon {
            font-size: 64px;
            color: #dc3545;
            margin-bottom: 20px;
        }
        
        .error-title {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }
        
        .error-message {
            color: #6c757d;
            margin-bottom: 25px;
        }
        
        .error-details {
            background-color: #f8f9fa;
            border-radius: 4px;
            padding: 15px;
            text-align: left;
            font-family: monospace;
            margin-bottom: 25px;
            word-wrap: break-word;
            max-height: 150px;
            overflow-y: auto;
        }
        
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background-color: #4a6cf7;
            color: #fff;
        }
        
        .btn-primary:hover {
            background-color: #3a5bd9;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            color: #fff;
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        
        .footer {
            padding: 15px 0;
            text-align: center;
            font-size: 13px;
            color: #6c757d;
            background-color: #f8f9fa;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <a href="{{ route('document.document') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Documents
            </a>
        </div>
    </div>
    
    <div class="container">
        <div class="error-card">
            <div class="error-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <h1 class="error-title">Document Preview Unavailable</h1>
            <p class="error-message">
                We couldn't preview the document "{{ $document->judul_dokumen }}". 
                The document might be too complex or in a format that can't be properly converted.
            </p>
            
            @if(app()->environment('local') || app()->environment('development'))
            <div class="error-details">
                {{ $error }}
            </div>
            @endif
            
            <div class="action-buttons">
                <a href="{{ route('documents.download', $document->id) }}" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download Document
                </a>
                <a href="{{ route('document.document') }}" class="btn btn-secondary">
                    <i class="fas fa-th-large"></i> Browse Other Documents
                </a>
            </div>
        </div>
    </div>
    
    <div class="footer">
        Universitas Negeri Jakarta Document Repository
    </div>
</body>
</html>