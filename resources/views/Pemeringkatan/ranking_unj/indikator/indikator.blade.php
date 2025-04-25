<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indikator Pemeringkatan</title>
    
    <!-- External CSS Libraries -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('home.css') }}">
</head>
<body>
    <!-- Navigation -->
    @include('layout.navbar_pemeringkatan')

    <!-- Banner -->
    <div class="indikator-banner">
        <h2>Indikator Pemeringkatan</h2>
    </div>

    <!-- Main Content -->
    <div class="info-section">
        <!-- Sidebar Navigation -->
        <div class="info-sidebar">
            <ul>
                <li><a href="#sejarah" class="active">Sejarah</a></li>
                <li><a href="#visi-misi">Visi Misi</a></li>
                <li><a href="#tujuan">Tujuan</a></li>
                <li><a href="#rencana-strategis">Rencana Strategis</a></li>
                <li><a href="#struktur-organisasi">Struktur Organisasi</a></li>
                <li><a href="#prestasi">Prestasi</a></li>
                <li><a href="#penelitian">Penelitian</a></li>
                <li><a href="#kerjasama">Kerjasama</a></li>
                <li><a href="#publikasi">Publikasi</a></li>
                <li><a href="#pengabdian">Pengabdian</a></li>
                <li><a href="#fasilitas">Fasilitas</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>
        </div>

        <!-- Content Area -->
        <div class="info-content" id="sejarah">
            <h2>Sejarah</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sed sapien quam. Sed dapibus est id enim facilisis, at posuere turpis adipiscing. Quisque sit amet dui dui. Duis rhoncus velit nec est condimentum feugiat. Donec aliquam augue nec gravida lobortis. Nunc arcu mi, pretium quis dolor id, iaculis euismod libero. Pellentesque ultricies ante eu velit vulputate, nec mattis justo suscipit.</p>
            <p>Curabitur mollis metus in nunc malesuada, vel placerat tellus vestibulum. Maecenas dignissim egestas lacus, ac elementum metus ultrices ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nullam quis sapien a nulla venenatis ullamcorper. Suspendisse euismod, mauris non gravida placerat, ipsum velit sollicitudin ipsum.</p>
        </div>
    </div>

    <!-- Spacer before footer -->
    <div class="footer-spacer"></div>

    <!-- External JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

    <!-- Smooth Scrolling Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('a[href*="#"]');
            
            for (const link of links) {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    
                    // Only prevent default for in-page links
                    if (href.startsWith('#')) {
                        e.preventDefault();
                        
                        const targetId = this.getAttribute('href').substring(1);
                        const targetElement = document.getElementById(targetId);
                        
                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth'
                            });
                        }
                        
                        // For sidebar navigation - toggle active class
                        if (this.closest('.info-sidebar')) {
                            const sidebarLinks = document.querySelectorAll('.info-sidebar a');
                            sidebarLinks.forEach(link => link.classList.remove('active'));
                            this.classList.add('active');
                            
                            // Update content based on clicked link
                            const contentArea = document.querySelector('.info-content');
                            contentArea.id = targetId;
                            
                            // Content sections
                            const sections = {
                                'sejarah': '<h2>Sejarah</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sed sapien quam. Sed dapibus est id enim facilisis, at posuere turpis adipiscing. Quisque sit amet dui dui. Duis rhoncus velit nec est condimentum feugiat. Donec aliquam augue nec gravida lobortis. Nunc arcu mi, pretium quis dolor id, iaculis euismod libero. Pellentesque ultricies ante eu velit vulputate, nec mattis justo suscipit.</p><p>Curabitur mollis metus in nunc malesuada, vel placerat tellus vestibulum. Maecenas dignissim egestas lacus, ac elementum metus ultrices ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nullam quis sapien a nulla venenatis ullamcorper. Suspendisse euismod, mauris non gravida placerat, ipsum velit sollicitudin ipsum.</p>',
                                'visi-misi': '<h2>Visi Misi</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas aliquam, tortor posuere malesuada feugiat, nulla nisi congue ante, vitae commodo dolor lorem nec tellus. Praesent tincidunt, ex ut efficitur scelerisque, nibh sem condimentum nulla, ut rutrum nisi dui eget risus. Praesent venenatis, eros sed laoreet dictum, lectus neque lobortis mi, at vehicula lacus sapien vel nisi.</p><p>Morbi pharetra diam sit amet felis facilisis interdum. Etiam at ipsum risus. Phasellus sagittis quam vel feugiat hendrerit. Integer ut tempor felis, ac gravida arcu. Phasellus dictum ex quis neque efficitur, quis varius est facilisis. Maecenas semper vulputate felis, id congue dui cursus ut.</p>',
                                'tujuan': '<h2>Tujuan</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin molestie eros quis diam pulvinar, non ultrices elit imperdiet. Cras sed mauris eget elit consequat ultrices. Praesent vel facilisis ante. Nullam hendrerit maximus elit vel varius. Vivamus sed turpis sed turpis molestie rutrum. Phasellus rutrum ipsum in scelerisque pulvinar.</p><p>Nullam nec elementum leo. In facilisis vestibulum nulla, vitae faucibus dui tempor at. Sed eget pretium urna. Sed in velit eget orci pharetra lobortis. Sed cursus, odio in faucibus convallis, neque massa ornare diam, et consectetur purus nisl vel nulla. Aenean at tellus dui.</p>',
                                'rencana-strategis': '<h2>Rencana Strategis</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sed tempus nulla. Donec faucibus augue eu bibendum sodales. Donec nulla magna, tincidunt eu sapien nec, lacinia fermentum libero. Donec quis bibendum ligula. In non risus nec nisl consectetur aliquet. Nulla massa diam, condimentum vitae mi ut, ultrices tempus augue.</p><p>Suspendisse non metus sit amet dolor venenatis scelerisque. Proin ultricies egestas enim, vitae tempor massa feugiat nec. Aliquam vel mattis dui. Suspendisse potenti. Integer fermentum nisl sit amet eros elementum blandit. Pellentesque viverra consequat nisi nec scelerisque.</p>',
                                'struktur-organisasi': '<h2>Struktur Organisasi</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce vehicula, lorem id pharetra finibus, dui dui pulvinar enim, ut luctus mi ex vel nibh. Vivamus ultrices magna vitae justo interdum, eget lacinia dui gravida. Praesent sed lacus odio. Proin sodales orci in sem consequat, quis finibus leo pellentesque.</p><p>Phasellus tincidunt aliquet finibus. Aenean vitae sollicitudin nisi. Phasellus vel metus vitae nisl hendrerit scelerisque. Suspendisse vel pretium nulla. Etiam lacinia enim in metus porta, a scelerisque ligula fringilla. Duis nec magna nec ipsum molestie tempus. Integer consectetur eu risus nec feugiat.</p>',
                                'prestasi': '<h2>Prestasi</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ullamcorper justo sit amet nulla interdum, at euismod arcu facilisis. Pellentesque quis est in nibh ullamcorper venenatis. Quisque faucibus nisi sit amet tempus convallis. Suspendisse facilisis fringilla arcu, non lobortis diam convallis vel.</p><p>Sed suscipit consequat pellentesque. Curabitur non velit eget urna viverra porttitor. Integer vel bibendum dolor. Ut eget fringilla urna. Vestibulum blandit nisl vitae sem rutrum, vitae dictum orci vehicula. Vivamus porttitor ullamcorper lectus, ac laoreet diam pellentesque ac.</p>',
                                'penelitian': '<h2>Penelitian</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla elementum orci sem, at tempus ante cursus vitae. Aliquam volutpat nisl quis lacus dictum, sit amet bibendum arcu cursus. Morbi ac elementum lorem. Nulla facilisi. Aenean placerat sem vel dolor mattis, in luctus sem tempus.</p><p>Sed id odio pellentesque, vehicula augue aliquet, faucibus quam. Proin iaculis accumsan metus, id ultrices dolor lacinia eu. Vivamus accumsan, augue eget rhoncus tempus, nunc libero ullamcorper odio, ac faucibus justo dolor ac orci. Nulla arcu sapien, sodales nec hendrerit vitae, tempor eu lectus.</p>',
                                'kerjasama': '<h2>Kerjasama</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin lobortis feugiat ex vel eleifend. Phasellus quis quam quam. Nullam mattis diam sed felis dictum, a congue mauris fringilla. Proin quis orci sollicitudin, lobortis libero id, eleifend purus. Donec pellentesque laoreet est eget tempus.</p><p>Phasellus et tincidunt odio. Vivamus hendrerit tortor eget metus malesuada, sed ultrices justo ultrices. Sed et urna sit amet quam interdum maximus quis vel arcu. Ut fermentum lectus ac tellus vestibulum molestie. In dignissim et ligula in placerat. Donec imperdiet arcu quis odio congue, vitae pharetra sapien lobortis.</p>',
                                'publikasi': '<h2>Publikasi</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt risus ac ex consequat, at sollicitudin quam sollicitudin. Cras rhoncus ex nec molestie pretium. Nulla laoreet velit vel felis ultrices rhoncus. Integer luctus vulputate tellus sit amet interdum.</p><p>Praesent sed nulla molestie, lacinia sem et, bibendum justo. Nullam faucibus sapien ut libero maximus, a molestie dui fermentum. Morbi maximus pellentesque augue, et lobortis diam aliquam a. Etiam non ultrices purus. Proin non nibh eros. Nam pretium purus sit amet nisi faucibus consectetur.</p>',
                                'pengabdian': '<h2>Pengabdian</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non nulla vestibulum, blandit nisi quis, egestas quam. Phasellus a ipsum nec lectus efficitur pharetra. Suspendisse vel risus egestas, egestas urna eu, vulputate risus. Suspendisse velit massa, bibendum at placerat vitae, fermentum in mauris.</p><p>Quisque ultricies orci sed rutrum luctus. Etiam id fermentum est. Aliquam dignissim finibus dui. Nullam scelerisque dolor in nulla pellentesque interdum. Nulla egestas rutrum nulla, id posuere risus porta sit amet. In ac dictum sapien, at efficitur sapien.</p>',
                                'fasilitas': '<h2>Fasilitas</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec non quam id erat ultricies faucibus. Duis ultricies, ante sed auctor eleifend, urna lacus pharetra justo, et bibendum velit lectus eu eros. Fusce efficitur vel velit id fringilla. Vivamus convallis egestas hendrerit.</p><p>Fusce vitae dignissim nisl. Integer faucibus posuere ex, eget faucibus mi posuere a. Ut id magna eu ipsum suscipit vehicula et at tortor. Pellentesque tincidunt egestas tellus, et pretium est. Phasellus sollicitudin dui risus, eu fringilla arcu pellentesque at.</p>',
                                'kontak': '<h2>Kontak</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque congue diam id enim facilisis, quis feugiat dolor dignissim. Vestibulum faucibus faucibus dui, id luctus elit vehicula sed. Phasellus sit amet convallis risus. Mauris porttitor neque sit amet orci luctus ultricies.</p><p>Aenean sed pharetra nisi. Ut eget lobortis ligula. Suspendisse porttitor dapibus aliquet. Praesent vel tempus justo. Donec volutpat ut libero in tempus. Vivamus vel neque convallis, volutpat lacus molestie, facilisis nulla. Donec auctor ullamcorper turpis, at tincidunt orci.</p>'
                            };
                            
                            // Update content if the section exists
                            if (sections[targetId]) {
                                contentArea.innerHTML = sections[targetId];
                            }
                        }
                    }
                });
            }
        });
    </script>

    <!-- Footer -->
    @include('layout.footer')
</body>
</html>