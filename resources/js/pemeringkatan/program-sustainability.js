document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('.info-sidebar a');
            const contentArea = document.querySelector('.info-content');

            const contentData = {
                'tagihan-listrik': {
                    title: 'Tagihan Listrik',
                    content: `
                        <p>Program pengelolaan tagihan listrik di Universitas Negeri Jakarta merupakan bagian integral dari upaya sustainability kampus. Program ini bertujuan untuk mengoptimalkan penggunaan energi listrik dan mengurangi dampak lingkungan.</p>
                        
                        <h3 style="color: #277177; margin: 20px 0 15px 0;">Strategi Penghematan Energi</h3>
                        <ul>
                            <li>Implementasi sistem monitoring konsumsi listrik real-time</li>
                            <li>Penggunaan lampu LED di seluruh area kampus</li>
                            <li>Sistem otomatisasi pencahayaan berbasis sensor</li>
                            <li>Program edukasi hemat energi untuk civitas akademika</li>
                        </ul>

                        <h3 style="color: #277177; margin: 20px 0 15px 0;">Target dan Pencapaian</h3>
                        <p>UNJ menargetkan pengurangan konsumsi listrik sebesar 20% dalam 5 tahun ke depan melalui berbagai inovasi teknologi hijau dan perubahan perilaku penggunaan energi di lingkungan kampus.</p>
                    `
                },
                'bbm': {
                    title: 'BBM (Bahan Bakar Minyak)',
                    content: `
                        <p>Program pengelolaan BBM di UNJ fokus pada pengurangan konsumsi bahan bakar fosil dan transisi menuju energi yang lebih berkelanjutan untuk operasional transportasi dan fasilitas kampus.</p>
                        
                        <h3 style="color: #277177; margin: 20px 0 15px 0;">Inisiatif Penghematan BBM</h3>
                        <ul>
                            <li>Program car-free day setiap hari Jumat</li>
                            <li>Penyediaan shuttle bus kampus dengan jadwal teratur</li>
                            <li>Pengembangan jalur sepeda di area kampus</li>
                            <li>Optimalisasi rute dan jadwal kendaraan operasional</li>
                        </ul>

                        <h3 style="color: #277177; margin: 20px 0 15px 0;">Teknologi Ramah Lingkungan</h3>
                        <p>UNJ sedang mengeksplorasi penggunaan kendaraan listrik untuk operasional kampus dan mendorong civitas akademika untuk menggunakan transportasi berkelanjutan.</p>
                        
                        <p>Program ini juga mencakup edukasi tentang pentingnya mengurangi jejak karbon melalui pilihan transportasi yang lebih ramah lingkungan.</p>
                    `
                },
                'sarpas-ramah-lingkungan': {
                    title: 'Sarana Prasarana Ramah Lingkungan',
                    content: `
                        <p>UNJ berkomitmen mengembangkan sarana dan prasarana yang ramah lingkungan sebagai wujud kepedulian terhadap kelestarian lingkungan dan pembangunan berkelanjutan.</p>
                        
                        <h3 style="color: #277177; margin: 20px 0 15px 0;">Fasilitas Hijau</h3>
                        <ul>
                            <li>Green building dengan sertifikasi ramah lingkungan</li>
                            <li>Sistem pengolahan air limbah terpusat</li>
                            <li>Taman vertikal dan ruang terbuka hijau</li>
                            <li>Sistem pemanenan air hujan (rainwater harvesting)</li>
                            <li>Tempat sampah terpilah dan sistem pengelolaan sampah berkelanjutan</li>
                        </ul>

                        <h3 style="color: #277177; margin: 20px 0 15px 0;">Inovasi Berkelanjutan</h3>
                        

                        <h3 style="color: #277177; margin: 20px 0 15px 0;">Rencana Pengembangan</h3>
                        <p>UNJ terus berkomitmen untuk mengembangkan infrastruktur yang lebih berkelanjutan dengan target menjadi eco-campus pada tahun 2030. Berbagai penelitian dan inovasi terus dilakukan untuk mendukung visi ini.</p>
                    `
                }
            };

            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Remove active class from all links
                    links.forEach(l => l.classList.remove('active'));
                    
                    // Add active class to clicked link
                    this.classList.add('active');
                    
                    // Get target content
                    const targetId = this.getAttribute('href').substring(1);
                    const content = contentData[targetId];
                    
                    if (content) {
                        contentArea.innerHTML = `
                            <h2>${content.title}</h2>
                            ${content.content}
                        `;
                        contentArea.id = targetId;
                    }
                });
            });
        });