<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejarah Unit</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <link rel="stylesheet" href="{{ asset('home.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        
        body {
            min-height: 100vh;
        }
        
        .main-content {
            display: flex;
            min-height: 60vh; /* Set minimum height for content */
            max-height: none; /* Remove max height constraint */
            margin-top: 50px; /* Keep the reduced margin for navbar */
        }
        
        .sidebar {
            width: 250px;
            background-color: #f8f8f8;
            border-right: 1px solid #e0e0e0;
            padding: 0;
            position: sticky;
            top: 50px; /* Further reduced top spacing */
            max-height: calc(100vh - 150px); /* Further reduced to show more footer */
            overflow-y: auto;
        }
        
        .sidebar-item {
            padding: 10px 25px;
            cursor: pointer;
            font-weight: bold;
            color: #333;
            transition: background-color 0.3s;
        }
        
        .sidebar-item:hover {
            background-color: #e8e8e8;
        }
        
        .sidebar-item.active {
            background-color: #ebebeb;
            border-left: 5px solid #176369;
        }
        
        .content {
            flex: 1;
            padding: 10px 30px;
            max-width: calc(100% - 250px);
        }
        
        .main-title {
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 24px;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 5px;
        }
        
        .content-text {
            line-height: 1.4;
            color: #444;
            text-align: justify;
            margin-top: 0;
            max-height: none; /* Remove height constraint */
            overflow-y: visible;
        }
        
        .content-section {
            display: none;
        }
        
        .content-section.active {
            display: block;
        }
        
        p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
@include('Inovasi.sejarah.navbarhilirisasi')

<div class="main-content">
    <div class="sidebar">
        <div class="sidebar-item active" data-section="sejarah">Sejarah</div>
        <div class="sidebar-item" data-section="visi-misi">Visi Misi</div>
        <div class="sidebar-item" data-section="tujuan">Tujuam</div>
        <div class="sidebar-item" data-section="rencana">Rencana Strategis</div>
    </div>
    
    <div class="content">
        <div id="sejarah" class="content-section active">
            <h1 class="main-title">Sejarah</h1>
            <div class="content-text">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Curabitur vestibulum, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl.</p>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Curabitur vestibulum, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl.</p>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Curabitur vestibulum, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl.</p>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Curabitur vestibulum, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl.</p>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Curabitur vestibulum, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl.</p>
            </div>
        </div>
        
        <div id="visi-misi" class="content-section">
            <h1 class="main-title">Visi Misi</h1>
            <div class="content-text">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Curabitur vestibulum, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl.</p>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Curabitur vestibulum, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl.</p>
            </div>
        </div>
        
        
        <div id="tujuan" class="content-section">
            <h1 class="main-title">Tujuan</h1>
            <div class="content-text">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Curabitur vestibulum, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl.</p>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Curabitur vestibulum, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl.</p>
            </div>
        </div>
        
        
        <div id="rencana" class="content-section">
            <h1 class="main-title">Rencana Strategis</h1>
            <div class="content-text">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Curabitur vestibulum, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl.</p>
                
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Nullam auctor, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl. Curabitur vestibulum, nisl eget ultricies tincidunt, nisl nisl aliquam nisl, eget aliquam nisl nisl eget nisl.</p>
            </div>
        </div>
    </div>
</div>

    <script>
        // Navigation functionality
        const sidebarItems = document.querySelectorAll('.sidebar-item');
        const contentSections = document.querySelectorAll('.content-section');
        
        sidebarItems.forEach(item => {
            item.addEventListener('click', () => {
                // Remove active class from all sidebar items
                sidebarItems.forEach(i => i.classList.remove('active'));
                
                // Add active class to clicked item
                item.classList.add('active');
                
                // Hide all content sections
                contentSections.forEach(section => section.classList.remove('active'));
                
                // Show the corresponding content section
                const sectionId = item.getAttribute('data-section');
                document.getElementById(sectionId).classList.add('active');
            });
        });
    </script>
<!-- Adding margin before footer -->
<div style="margin-top: 50px"></div>
@include('Pemeringkatan.sejarah.footerpemeringkatan')
</body>
</html>