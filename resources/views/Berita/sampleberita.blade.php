
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/4/46/Lambang_baru_UNJ.png" type="image/png">
    <title>{{ $berita->judul }}UNJ News Portal</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <link rel="stylesheet" href="{{ asset('berita.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FONT AWESOME - SINGLE VERSION -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            line-height: 1.6;
            color: #333;
            font-size: 14px;
        }
        
        .content-container {
            display: flex;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .featured-image-container {
            width: 100%;
            position: relative;
            margin-bottom: 20px;
        }
        
        .featured-image {
            width: 100%;
            height: auto;
            display: block;
            max-height: 400px;
            object-fit: cover;
        }
        
        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 15px 30px;
            text-align: center;
            max-width: 500px;
        }
        
        .image-overlay h1 {
            font-size: 1.2rem;
            margin: 5px 0;
            color: white;
            line-height: 1.4;
        }
        
        .date-badge {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            color: white;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .main-content {
            flex: 1;
            min-width: 0;
            padding: 0 20px 20px 20px;
            max-width: 70%;
        }
        
        .sidebar {
            width: 30%;
            padding: 0 20px 20px 0;
        }
        
        .article-meta {
            margin-bottom: 15px;
            line-height: 1.6;
        }
        
        .article-content p {
            margin-bottom: 15px;
            text-align: justify;
            line-height: 1.6;
        }
        
        .article-content p:first-of-type::first-letter {
            font-size: 2.5em;
            font-weight: bold;
            float: left;
            line-height: 1;
            margin-right: 6px;
            color: rgba(23, 99, 105, 1);
        }
        
        .article-share {
            display: flex;
            align-items: center;
            margin: 20px 0;
            padding: 10px 0;
            border-top: 1px solid #eee;
            border-bottom: 1px solid #eee;
        }
        
        .article-share span {
            margin-right: 15px;
            font-weight: bold;
        }
        
        .article-share a {
            margin-right: 10px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #f0f0f0;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }
        
        .article-share a:hover {
            background-color: rgba(23, 99, 105, 0.9);
            color: white;
            text-decoration: none;
        }
        
        .article-tags {
            margin: 20px 0;
        }
        
        .article-tags span {
            display: inline-block;
            background-color: #f0f0f0;
            color: #333;
            padding: 3px 10px;
            margin-right: 5px;
            border-radius: 3px;
            font-size: 12px;
        }
        
        sup {
            vertical-align: super;
            font-size: smaller;
        }
        
        .section-header {
            background-color: rgba(23, 99, 105, 0.9);
            color: white;
            display: inline-block;
            padding: 5px 15px;
            font-size: 0.9rem;
            font-weight: bold;
            margin-bottom: 15px;
        }
        
        .news-item {
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }
        
        .news-item:hover {
            background-color: #f9f9f9;
            padding-left: 5px;
        }
        
        .news-item h3 {
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 5px;
        }
        
        .news-item h3 a {
            color: #333;
            text-decoration: none;
        }
        
        .news-item h3 a:hover {
            color: rgba(23, 99, 105,.9);
            text-decoration: none;
        }
        
        .news-item .date {
            font-size: 12px;
            color: #888;
        }
        
        .popular-item {
            margin-bottom: 10px;
            padding: 5px 0;
            transition: all 0.3s ease;
        }
        
        .popular-item:hover {
            background-color: #f9f9f9;
            padding-left: 5px;
        }
        
        .post-date {
            color: #888;
            font-size: 12px;
            display: block;
            margin-bottom: 3px;
        }
        
        .post-title {
            font-size: 14px;
            color: #333;
            text-decoration: none;
            display: block;
        }
        
        .post-title:hover {
            color: rgba(23, 99, 105, .9);
            text-decoration: none;
        }
        
        .related-posts {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #eee;
        }
        
        .related-post-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 15px;
        }
        
        .related-post-item {
            border: 1px solid #eee;
            border-radius: 4px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .related-post-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .related-post-image {
            width: 100%;
            height: 120px;
            object-fit: cover;
            background-color: #f0f0f0;
        }
        
        .related-post-content {
            padding: 10px;
        }
        
        .related-post-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .related-post-date {
            font-size: 12px;
            color: #888;
        }
        
        strong, b {
            font-weight: bold;
        }
        
        a {
            color: #333;
            text-decoration: none;
        }
        
        a:hover {
            color: rgba(23, 99, 105, .9);
        }
        
        .section-title-wrapper {
            margin-bottom: 10px;
        }
        
        .section-content {
            margin-bottom: 30px;
        }
        
        .newsletter {
            background-color: #f9f9f9;
            padding: 20px;
            margin-top: 20px;
            border-radius: 4px;
        }
        
        .newsletter h4 {
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .newsletter p {
            margin-bottom: 15px;
            font-size: 13px;
        }
        
        .newsletter-form {
            display: flex;
        }
        
        .newsletter-form input {
            flex: 1;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
            outline: none;
        }
        
        .newsletter-form button {
            background-color: rgba(23, 99, 105, 0.9);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        
        .newsletter-form button:hover {
            background-color: rgba(23, 99, 105, 1);
        }
        
        /* Mobile-specific styles */
        @media (max-width: 768px) {
            .main-content, .sidebar {
                width: 100%;
                max-width: 100%;
                padding: 0 15px;
            }
            
            .content-container {
                flex-direction: column;
            }
            
            .image-overlay {
                max-width: 90%;
            }
            
            .related-post-grid {
                grid-template-columns: 1fr;
            }
            
            .article-content p:first-of-type::first-letter {
                font-size: 2em;
            }
        }
    </style>
</head>
@include('layout.navbar_sticky')
<body>
    <!-- Main Content -->
    <div class="content-container">
        <div class="featured-image-container">
            <img class="featured-image" src="{{ asset('storage/'.$berita->gambar) }}" alt="{{ $berita->judul }}" onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg width=\'680\' height=\'400\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'100%25\' height=\'100%25\' fill=\'%23f0f0f0\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' font-size=\'18\' text-anchor=\'middle\' alignment-baseline=\'middle\' font-family=\'Arial, sans-serif\' fill=\'%23888888\'%3EUniversitas Indonesia%3C/text%3E%3C/svg%3E'">
            <div class="image-overlay">
                <div class="date-badge">
                    <span>📅 {{ date('F d, Y', strtotime($berita->tanggal)) }}</span>
                    <span>⌚ {{ date('g:i a', strtotime($berita->tanggal)) }}</span>
                </div>
                <h1>{{ $berita->judul }}</h1>
            </div>
        </div>
        
        <div class="main-content">
            <div class="article-meta">
                <strong>{{ $berita->kategori == 'inovasi' ? 'Inovasi' : 'Pemeringkatan' }}, {{ date('d F Y', strtotime($berita->tanggal)) }}</strong> - 
                {{ Str::limit(strip_tags($berita->isi), 200) }}
            </div>
            
            <div class="article-content">
                {!! $berita->isi !!}
                
                <div class="article-share">
                    <span>Bagikan:</span>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                    <a href="#"><i class="far fa-envelope"></i></a>
                </div>
                
                <div class="article-tags">
                    <span>{{ $berita->kategori }}</span>
                    <span>Universitas</span>
                    <span>UNJ</span>
                </div>
                
                <div class="related-posts">
                    <h3>Berita Terkait</h3>
                    <div class="related-post-grid">
                        @forelse($relatedNews as $related)
                        <div class="related-post-item">
                            <img src="{{ asset('storage/'.$related->gambar) }}" alt="{{ $related->judul }}" class="related-post-image" onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg width=\'300\' height=\'150\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Crect width=\'100%25\' height=\'100%25\' fill=\'%23f0f0f0\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' font-size=\'14\' text-anchor=\'middle\' alignment-baseline=\'middle\' font-family=\'Arial, sans-serif\' fill=\'%23888888\'%3EBerita Terkait%3C/text%3E%3C/svg%3E'">
                            <div class="related-post-content">
                                <div class="related-post-title">
                                    <a href="{{ route('Berita.show', ['slug' => $related->slug]) }}">{{ $related->judul }}</a>
                                </div>
                                <div class="related-post-date">{{ date('F d, Y', strtotime($related->tanggal)) }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="related-post-item">
                            <div class="related-post-content">
                                <div class="related-post-title">
                                    Tidak ada berita terkait
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <div class="sidebar">
            <div class="section-title-wrapper">
                <div class="section-header">Latest News</div>
            </div>
            <div class="section-content">
                @foreach($latestNews as $latest)
                <div class="news-item">
                    <h3><a href="{{ route('Berita.show', ['slug' => Str::slug($latest->judul)]) }}">{{ $latest->judul }}</a></h3>
                    <div class="date">{{ date('F d, Y', strtotime($latest->tanggal)) }} • {{ ucfirst($latest->kategori) }}</div>
                </div>
                @endforeach
            </div>
            
            <div class="section-title-wrapper">
                <div class="section-header">Popular Post</div>
            </div>
            <div class="section-content">
                @foreach($popularNews as $popular)
                <div class="popular-item">
                    <span class="post-date">🗓 {{ date('M d, Y', strtotime($popular->tanggal)) }}</span>
                    <a href="{{ route('Berita.show', ['slug' => Str::slug($popular->judul)]) }}" class="post-title">{{ $popular->judul }}</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
@include('layout.footer')

</html>