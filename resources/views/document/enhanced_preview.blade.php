<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $document->judul_dokumen }} - Preview</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4a6cf7;
            --primary-dark: #3a5bd9;
            --primary-light: #eaefff;
            --secondary: #6c757d;
            --secondary-light: #e9ecef;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
            --white: #ffffff;
            --shadow: 0 2px 10px rgba(0,0,0,0.05);
            --shadow-lg: 0 5px 15px rgba(0,0,0,0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', Arial, sans-serif;
            color: #333;
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .preview-header {
            background-color: var(--white);
            padding: 15px 20px;
            box-shadow: var(--shadow);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .document-info {
            flex: 1;
        }
        
        .document-title {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }
        
        .document-meta {
            margin-top: 5px;
            font-size: 13px;
            color: var(--secondary);
        }
        
        .header-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            white-space: nowrap;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
        }
        
        .btn-secondary {
            background-color: var(--secondary);
            color: var(--white);
        }
        
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        
        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background-color: var(--primary-light);
        }
        
        .main-content {
            flex: 1;
            display: flex;
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }
        
        .document-preview {
            flex: 1;
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 70vh;
        }
        
        .preview-content {
            padding: 40px 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
        }
        
        .document-icon {
            font-size: 80px;
            margin-bottom: 20px;
            color: #2b579a; /* Microsoft Word blue */
            width: 120px;
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f5ff;
            border-radius: 20px;
        }
        
        .document-icon.pdf-icon {
            color: #e2574c; /* PDF red */
            background-color: #fff5f5;
        }
        
        .preview-actions {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
            max-width: 300px;
        }
        
        .document-details {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--secondary-light);
            width: 100%;
            max-width: 500px;
        }
        
        .details-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: left;
        }
        
        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid var(--secondary-light);
            font-size: 14px;
        }
        
        .detail-label {
            color: var(--secondary);
        }
        
        .detail-value {
            font-weight: 500;
        }
        
        .preview-footer {
            padding: 15px 0;
            text-align: center;
            font-size: 13px;
            color: var(--secondary);
            background-color: var(--light);
            border-top: 1px solid #eee;
        }
        
        @media (max-width: 768px) {
            .preview-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .header-actions {
                margin-top: 15px;
                width: 100%;
            }
            
            .btn {
                flex: 1;
            }
            
            .main-content {
                padding: 15px;
            }
            
            .preview-content {
                padding: 30px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="preview-header">
        <div class="document-info">
            <h1 class="document-title">{{ $document->judul_dokumen }}</h1>
            <div class="document-meta">
                <span><i class="fas fa-calendar-alt"></i> {{ $uploadDate }}</span>
                &middot;
                <span><i class="fas fa-file-{{ $document->kategori === 'pdf' ? 'pdf' : 'word' }}"></i> 
                    {{ $extension }} Document
                </span>
                &middot;
                <span><i class="fas fa-weight-hanging"></i> {{ $fileSize }}</span>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('document.document') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href="{{ route('documents.download', $document->id) }}" class="btn btn-primary">
                <i class="fas fa-download"></i> Download
            </a>
        </div>
    </div>
    
    <div class="main-content">
        <div class="document-preview">
            <div class="preview-content">
                <div class="document-icon {{ $document->kategori === 'pdf' ? 'pdf-icon' : 'word-icon' }}">
                    <i class="fas fa-file-{{ $document->kategori === 'pdf' ? 'pdf' : 'word' }}"></i>
                </div>
                
                <h2>{{ $extension }} Document</h2>
                <p style="max-width: 500px; margin: 15px 0 25px;">
                    This document needs to be downloaded to view its contents. 
                    You can open it with Microsoft Word or any compatible word processor.
                </p>
                
                <div class="preview-actions">
                    <a href="{{ route('documents.download', $document->id) }}" class="btn btn-primary" style="justify-content: center">
                        <i class="fas fa-download"></i> Download Document
                    </a>
                </div>
                
                <div class="document-details">
                    <h3 class="details-title">Document Details</h3>
                    
                    <div class="detail-item">
                        <span class="detail-label">File Name</span>
                        <span class="detail-value">{{ $document->nama_file }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">File Type</span>
                        <span class="detail-value">{{ $extension }} Document</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">File Size</span>
                        <span class="detail-value">{{ $fileSize }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Upload Date</span>
                        <span class="detail-value">{{ $uploadDate }}</span>
                    </div>
                    
                    @if($document->deskripsi)
                    <div class="detail-item">
                        <span class="detail-label">Description</span>
                        <span class="detail-value">{{ $document->deskripsi }}</span>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="preview-footer">
                Document provided by Universitas Negeri Jakarta Document Repository
            </div>
        </div>
    </div>
</body>
</html>