<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Calon Adjunct Professor</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <script src="{{ asset('home.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('mobile.css') }}">
    <script src="{{ asset('mobile.js') }}"></script>
    <style>
        /* Scoped styles with unique prefix "adjunct-" */
        .adjunct-container {
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 50px;
            padding: 30px;
        }
        
        .adjunct-heading {
            color: #277177;
            margin-bottom: 30px;
            text-align: center;
            font-size: 28px;
        }
        
        .adjunct-cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        
        .adjunct-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .adjunct-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }
        
        .adjunct-card-header {
            background-color: #277177;
            color: white !important; /* Force color */
            padding: 15px 20px;
            position: relative;
        }
        
        .adjunct-card-fakultas {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 5px;
            color: white !important; /* Force color */
        }
        
        .adjunct-card-name {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
            color: white !important; /* Force color */
        }
        
        .adjunct-card-body {
            padding: 20px;
        }
        
        .adjunct-card-item {
            margin-bottom: 15px;
        }
        
        .adjunct-card-label {
            font-size: 12px;
            color: #666 !important; /* Force color */
            display: block;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .adjunct-card-value {
            font-size: 15px;
            color: #333 !important; /* Force color */
        }
        
        .adjunct-card-country {
            display: flex;
            align-items: center;
        }
        
        @media (max-width: 768px) {
            .adjunct-container {
                padding: 15px;
            }
            
            .adjunct-heading {
                font-size: 24px;
                margin-bottom: 20px;
            }
            
            .adjunct-cards-container {
                grid-template-columns: 1fr;
            }
        }
        .back-button-container {
        padding: 1rem;
        margin: 1rem 0;
    }
    
    .back-button {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        background-color: #186862; /* Match the teal color from the site */
        color: white;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .back-button:hover {
        background-color: #0D9488; /* Lighter teal on hover */
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .back-button i {
        margin-right: 0.5rem;
    }
    .back-button-container.floating {
    position: fixed;
    top: 85px; /* Adjust based on navbar height */
    left: 20px;
    z-index: 100;
    padding: 0;
    margin: 0;
    margin-top : 60px;
}
    
    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .back-button-container {
            padding: 0.75rem;
            margin: 0.75rem 0;
        }
        
        .back-button {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }
    }
    </style>
</head>
@include('layout.navbar')
<body>
<div class="back-button-container floating">
    <a href="{{ route('home') }}" class="back-button">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali</span>
    </a>
</div>
    <div class="adjunct-container">
        <h1 class="adjunct-heading">Daftar Calon Adjunct Professor</h1>
        <div class="adjunct-cards-container">
            
            <!-- Card 1 -->
            <div class="adjunct-card">
                <div class="adjunct-card-header">
                    <div class="adjunct-card-fakultas">Fakultas Teknik (FT)</div>
                    <div class="adjunct-card-name">Prof. Ir, Dr Sitti Asmah Binti Hassan</div>
                </div>
                <div class="adjunct-card-body">
                    <div class="adjunct-card-item">
                        <span class="adjunct-card-label">Bidang Keahlian</span>
                        <span class="adjunct-card-value">Transportation & Traffic Engineering</span>
                    </div>
                    <div class="adjunct-card-item">
                        <span class="adjunct-card-label">Kewarganegaraan</span>
                        <span class="adjunct-card-value adjunct-card-country">Malaysia</span>
                    </div>
                    <div class="adjunct-card-item">
                        <span class="adjunct-card-label">Instansi Asal</span>
                        <span class="adjunct-card-value">School of Civil Engineering Universiti Teknologi Malaysia</span>
                    </div>
                </div>
            </div>
            
            <!-- Card 2 -->
            <div class="adjunct-card">
                <div class="adjunct-card-header">
                    <div class="adjunct-card-fakultas">Fakultas Matematika dan Ilmu Pengetahuan Alam (FMIPA)</div>
                    <div class="adjunct-card-name">Prof Dr Jungshan Chang</div>
                </div>
                <div class="adjunct-card-body">
                    <div class="adjunct-card-item">
                        <span class="adjunct-card-label">Bidang Keahlian</span>
                        <span class="adjunct-card-value">Biomedis</span>
                    </div>
                    <div class="adjunct-card-item">
                        <span class="adjunct-card-label">Kewarganegaraan</span>
                        <span class="adjunct-card-value adjunct-card-country">Taiwan</span>
                    </div>
                    <div class="adjunct-card-item">
                        <span class="adjunct-card-label">Instansi Asal</span>
                        <span class="adjunct-card-value">Taipei Medical University</span>
                    </div>
                </div>
            </div>
            
            <!-- Card 3 -->
            <div class="adjunct-card">
                <div class="adjunct-card-header">
                    <div class="adjunct-card-fakultas">Fakultas Matematika dan Ilmu Pengetahuan Alam (FMIPA)</div>
                    <div class="adjunct-card-name">Assoc. Prof Dr Muhammad Irfan Ashraf</div>
                </div>
                <div class="adjunct-card-body">
                    <div class="adjunct-card-item">
                        <span class="adjunct-card-label">Bidang Keahlian</span>
                        <span class="adjunct-card-value">Biotechnology</span>
                    </div>
                    <div class="adjunct-card-item">
                        <span class="adjunct-card-label">Kewarganegaraan</span>
                        <span class="adjunct-card-value adjunct-card-country">Pakistan</span>
                    </div>
                    <div class="adjunct-card-item">
                        <span class="adjunct-card-label">Instansi Asal</span>
                        <span class="adjunct-card-value">Sarghoda University</span>
                    </div>
                </div>
            </div>
            
            <!-- Card 4 -->
            <div class="adjunct-card">
                <div class="adjunct-card-header">
                    <div class="adjunct-card-fakultas">Fakultas Psikologi (FPsi)</div>
                    <div class="adjunct-card-name">Prof. Madya dr. Nor ba`yah binti Abdul Kadir</div>
                </div>
                <div class="adjunct-card-body">
                    <div class="adjunct-card-item">
                        <span class="adjunct-card-label">Bidang Keahlian</span>
                        <span class="adjunct-card-value">Health Psychology</span>
                    </div>
                    <div class="adjunct-card-item">
                        <span class="adjunct-card-label">Kewarganegaraan</span>
                        <span class="adjunct-card-value adjunct-card-country">Malaysia</span>
                    </div>
                    <div class="adjunct-card-item">
                        <span class="adjunct-card-label">Instansi Asal</span>
                        <span class="adjunct-card-value">Pusat Kajian Psikologi & Kesejahteraan Manusia Universitas Kebangsaan Malaysia</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
@include('layout.footer')
</html>