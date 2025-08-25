<!-- KATSINOV Assessment Section -->

<div class="container" data-indicator="5">
    <div class="card" data-aos="fade-up">
        <div class="main-title">
            Indikator KATSINOV 5
        </div>
        <div class="content position-relative">
            <table class="katsinov-table">
                <tr>
                    <th>No</th>
                    <th>Aspek</th>
                    <th class="score-columns">0</th>
                    <th class="score-columns">1</th>
                    <th class="score-columns">2</th>
                    <th class="score-columns">3</th>
                    <th class="score-columns">4</th>
                    <th class="score-columns">5</th>
                    <th>Deskripsi</th>
                    <th>Rating</th>
                    <td rowspan="26" class="katsinov-title">KATSINOV 5</td>
                </tr>
                <!-- T rows -->
                <!-- T rows -->
                <tr class="row-t">
                    <td class="row-number">1</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 1, Nilai 0: Belum menganggap garansi sebagai upaya perlindungan konsumen dan alat promosi yang efektif."><input type="radio" name="indikator5_row1" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[0]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 1, Nilai 1: Mulai muncul kesadaran kolektif dari produsen untuk memberikan garansi kepada konsumen. "><input type="radio" name="indikator5_row1" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[0]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 1, Nilai 2: Tahap pengkajian pemberian garansi kepada konsumen. "><input type="radio" name="indikator5_row1" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[0]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 1, Nilai 3: Telah memberikan garansi resmi berupa garansi service gratis."><input type="radio" name="indikator5_row1" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[0]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 1, Nilai 4: Telah memberikan garansi resmi berupa garansi service gratis dan penggantian spare part. "><input type="radio" name="indikator5_row1" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[0]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 1, Nilai 5: Telah menyediakan garansi resmi secara penuh (garansi service gratis, penggantian spare part, penggantian unit baru) sebagai upaya perlindungan konsumen dan alat promosi yang efektif."><input type="radio" name="indikator5_row1" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[0]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Adanya garansi terhadap produk teknologi yang dipasarkan.</td>
                    <td>
                        <select name="indikator5_dropdown1" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[0]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[0]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[0]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[0]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[0]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[0]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">2</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 2, Nilai 0: HP Tidak tersedia pusat pelayanan purna jual, baik selama garansi maupun pasca garansi."><input type="radio" name="indikator5_row2" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[1]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 2, Nilai 1: Persiapan penyediaan pusat pelayanan purna jual, baik selama garansi maupun pasca garansi."><input type="radio" name="indikator5_row2" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[1]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 2, Nilai 2: Mulai tersedia secara sentralistik (di kantor induk produsen) pusat pelayanan purna jual, baik selama garansi maupun pasca garansi."><input type="radio" name="indikator5_row2" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[1]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 2, Nilai 3: Tersedia pusat pelayanan purna jual, baik selama garansi maupun pasca garansi, di kota dimana produsen berada."><input type="radio" name="indikator5_row2" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[1]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 2, Nilai 4: Tersedia pusat pelayanan purna jual, baik selama garansi maupun pasca garansi, di beberapa kota besar."><input type="radio" name="indikator5_row2" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[1]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 2, Nilai 5: Tersedia pusat pelayanan purna jual, baik selama garansi maupun pasca garansi, di seluruh kota besar."><input type="radio" name="indikator5_row2" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[1]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Layanan pemeliharaan produk telah disediakan.</td>
                    <td>
                        <select name="indikator5_dropdown2" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[1]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[1]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[1]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[1]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[1]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[1]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">3</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 3, Nilai 0: Tidak tersedia pasokan suku cadang untuk produk teknologi."><input type="radio" name="indikator5_row3" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[2]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 3, Nilai 1: Persiapan penyediaan pasokan suku cadang untuk produk teknologi."><input type="radio" name="indikator5_row3" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[2]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 3, Nilai 2: Mulai tersedia secara sentralistik (di kantor induk produsen) pasokan suku cadang untuk produk teknologi."><input type="radio" name="indikator5_row3" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[2]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 3, Nilai 3: Tersedia pasokan suku cadang untuk produk teknologi, melalui pusat pelayanan purna jual dan distributor di kota dimana produsen berada."><input type="radio" name="indikator5_row3" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[2]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 3, Nilai 4: Tersedia pasokan suku cadang untuk produk teknologi, melalui pusat pelayanan purna jual dan distributor di beberapa kota besar."><input type="radio" name="indikator5_row3" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[2]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 3, Nilai 5: Tersedia pasokan suku cadang untuk produk teknologi, melalui pusat pelayanan purna jual dan distributor di seluruh kota besar."><input type="radio" name="indikator5_row3" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[2]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Pasokan suku cadang untuk produk teknologi telah disediakan.</td>
                <td>
                        <select name="indikator5_dropdown3" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[2]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[2]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[2]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[2]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[2]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[2]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">4</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 4, Nilai 0: Tidak lagi melakukan pengembangan."><input type="radio" name="indikator5_row4" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[3]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 4, Nilai 1: Belum ada pengembangan yang berarti, hanya perbaikan mutu melalui mekanisme Jaminan Mutu selama produksi."><input type="radio" name="indikator5_row4" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[3]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 4, Nilai 2: Aktivitas tidak hanya perbaikan mutu melalui mekanisme Jaminan Mutu selama produksi."><input type="radio" name="indikator5_row4" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[3]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 4, Nilai 3: Telah dilakukan aktivitas pengembangan berkelanjutan dalam rangka upaya menjawab keluhan pelanggan melalui perbaikan mutu produk sesuai permintaan pelanggan."><input type="radio" name="indikator5_row4" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[3]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 4, Nilai 4: Telah dilakukan aktivitas pengembangan berkelanjutan dalam upaya menjawab keluhan pelanggan melalui perbaikan mutu dan fungsi produk."><input type="radio" name="indikator5_row4" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[3]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 4, Nilai 5: Telah dilakukan aktivitas pengembangan berkelanjutan dalam upaya menjawab keluhan pelanggan melalui perbaikan mutu, fungsi, dan unjuk kerja produk."><input type="radio" name="indikator5_row4" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[3]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Adanya aktivitas pengembangan dengan intensitas lebih rendah, untuk peningkatan kerja produk teknologi sesuai permintaan pelanggan.</td>
                <td>
                        <select name="indikator5_dropdown4" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[3]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[3]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[3]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[3]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[3]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[3]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <!-- M rows -->
                <tr class="row-m">
                    <td class="row-number">5</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 5, Nilai 0: Surat garansi produk/teknologi yang dipasarkan."><input type="radio" name="indikator5_row5" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[4]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 5, Nilai 1: Daftar komponen produk/teknologi yang mudah aus atau rusak."><input type="radio" name="indikator5_row5" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[4]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 5, Nilai 2: Daftar suku cadang yang harus disediakan untuk mendukung layanan purna jual."><input type="radio" name="indikator5_row5" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[4]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 5, Nilai 3: Daftar layanan teknis yang harus disediakan untuk mendukung layanan purna jual."><input type="radio" name="indikator5_row5" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[4]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 5, Nilai 4: Daftar lokasi layanan purna jual."><input type="radio" name="indikator5_row5" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[4]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 5, Nilai 5: Informasi lokasi layanan purna jual, akses layanan, fasilitas layanan, akuntablitas jasa layanan, ketersediaan produk dan kompetensi sumberdaya manusia berbasis kebutuhan produk."><input type="radio" name="indikator5_row5" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[4]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah menyediakan pelayanan dan solusi yang lengkap.</td>
                <td>
                        <select name="indikator5_dropdown5" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[4]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[4]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[4]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[4]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[4]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[4]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">6</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 6, Nilai 0: Tidak dilakukan diferensiasi produk."><input type="radio" name="indikator5_row6" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[5]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 6, Nilai 1: Ada rencana srataegi diferensiasi produk."><input type="radio" name="indikator5_row6" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[5]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 6, Nilai 2: Rencana strategi diferensiasi produk telah disusun."><input type="radio" name="indikator5_row6" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[5]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 6, Nilai 3: Strategi diferensiasi produk mulai diterapkan."><input type="radio" name="indikator5_row6" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[5]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 6, Nilai 4: Perusahaan belum optimal menerapkan strategi diferensiasi produk."><input type="radio" name="indikator5_row6" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[5]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 6, Nilai 5: Perusahaan melaksanakan strategi diferensiasi produk secara optimal."><input type="radio" name="indikator5_row6" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[5]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah melakukan diferensiasi produk.</td>
                <td>
                        <select name="indikator5_dropdown6" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[5]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[5]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[5]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[5]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[5]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[5]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">7</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 7, Nilai 0: Tidak dilakukan evaluasi dan penyempurnaan model bisnis."><input type="radio" name="indikator5_row7" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[6]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 7, Nilai 1: Tahap perencanaan evaluasi dan penyempurnaan model bisnis."><input type="radio" name="indikator5_row7" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[6]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 7, Nilai 2: Mulai dilakukan evaluasi dan penyempurnaan model bisnis model bisnis."><input type="radio" name="indikator5_row7" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[6]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 7, Nilai 3: Diperoleh hasil evaluasi dan tahap penyempurnaan model bisnis."><input type="radio" name="indikator5_row7" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[6]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 7, Nilai 4: Telah dilakukan penyempurnaan model bisnis berdasar hasil evaluasi."><input type="radio" name="indikator5_row7" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[6]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 7, Nilai 5: Penyempurnaan model bisnis telah diverifikasi dan divalidasi."><input type="radio" name="indikator5_row7" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[6]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah melakukan penyempurnaan model bisnis.</td>
                <td>
                        <select name="indikator5_dropdown7" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[6]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[6]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[6]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[6]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[6]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[6]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">8</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 8, Nilai 0: Kemitraan belum dipertimbangkan sebagai faktor yang mempengaruhi daya saing."><input type="radio" name="indikator5_row8" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[7]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 8, Nilai 1: Telah memiliki rencana strategis kemitraan usaha"><input type="radio" name="indikator5_row8" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[7]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 8, Nilai 2: Rencana strategi kemitraan telah diimplementasikan tetapi belum optimal"><input type="radio" name="indikator5_row8" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[7]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 8, Nilai 3: Kemitraan telah dioptimalkan untuk aspek teknis (pengembangan produk, perbaikan proses produksi, perbaikan kualitas, dan akses teknologi)."><input type="radio" name="indikator5_row8" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[7]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 8, Nilai 4: Kemitraan dioptimalkan untuk aspek ekspansi pasar, distribusi, pemasok bahan baku, peningkatan profit dan akuisisi pelanggan baru."><input type="radio" name="indikator5_row8" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[7]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 8, Nilai 5: Kemitraan telah terjalin di berbagai aspek dari hulu ke hilir dengan saling menguntungkan."><input type="radio" name="indikator5_row8" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[7]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah menggunakan kemitraan untuk berkompetisi di pasar.</td>
                <td>
                        <select name="indikator5_dropdown8" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[7]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[7]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[7]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[7]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[7]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[7]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <!-- O rows -->
                <tr class="row-o">
                    <td class="row-number">9</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 9, Nilai 0: Belum ada upaya meningkatkan efektivitas dan kerjasama organisasi."><input type="radio" name="indikator5_row9" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[8]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 9, Nilai 1: Mulai muncul kesadaran upaya peningkatan efektivitas dan kerjasama organisasi."><input type="radio" name="indikator5_row9" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[8]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 9, Nilai 2: Secara sadar melakukan upaya peningkatan efektivitas & kerjasama organisasi."><input type="radio" name="indikator5_row9" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[8]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 9, Nilai 3: Telah dilakukan peningkatan efektivitas & kerjasama organisasi sehingga terpenuhi pencapaian visi organisasi, pengembangan sumber daya manusia organisasi, dan pemenuhan aspirasi."><input type="radio" name="indikator5_row9" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[8]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 9, Nilai 4: Telah dilakukan peningkatan efektivitas dan kerjasama organisasi sehingga terpenuhi pencapaian visi organisasi, pengembangan SDM organisasi, pemenuhan aspirasi & menghasilkan keuntungan bagi organisasi."><input type="radio" name="indikator5_row9" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[8]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 9, Nilai 5: Terpenuhi pencapaian visi organisasi, pengembangan SDM organisasi, pemenuhan aspirasi, menghasilkan keuntungan bagi organisasi, kepuasan pelanggan & memberikan dampak positif bagi masyarakat di luar organisasi."><input type="radio" name="indikator5_row9" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[8]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah meningkatkan efektivitas dan kerjasama.</td>
                <td>
                        <select name="indikator5_dropdown9" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[8]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[8]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[8]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[8]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[8]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[8]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">10</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 10, Nilai 0: Tidak ada upaya melakukan restrukturisasi yang dibutuhkan."><input type="radio" name="indikator5_row10" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[9]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 10, Nilai 1: Mulai ada kesadaran dibutuhkan restrukturisasi di perusahaan."><input type="radio" name="indikator5_row10" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[9]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 10, Nilai 2: Perusahaan mempersiapkan restrukturisasi yang dibutuhkan."><input type="radio" name="indikator5_row10" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[9]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 10, Nilai 3: Perusahaan mulai menjalankan restrukturisasi yang dibutuhkan, dimulai dengan evaluasi kinerja."><input type="radio" name="indikator5_row10" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[9]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 10, Nilai 4: Perusahaan telah melakukan evaluasi kinerja dan melakukan beberapa perbaikan dalam pelaksanaan restrukturisasi yang dibutuhkan."><input type="radio" name="indikator5_row10" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[9]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 10, Nilai 5: Melakukan restrukturisasi yang dibutuhkan, melalui evaluasi kinerjanya serta melakukan serangkaian perbaikan berkelanjutan agar tetap tumbuh dan dapat bersaing."><input type="radio" name="indikator5_row10" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[9]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah melakukan penataan kembali struktur perusahaan sesuai kebutuhan.</td>
                <td>
                        <select name="indikator5_dropdown10" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[9]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[9]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[9]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[9]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[9]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[9]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">11</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 11, Nilai 0: Belum diidentifikasi peningkatan peluang mempertemukan produk teknologi dengan kebutuhan pasar."><input type="radio" name="indikator5_row11" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[10]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 11, Nilai 1: Telah dipersiapkan pelaksanaan identifikasi peningkatan peluang mempertemukan produk teknologi dengan kebutuhan pasar."><input type="radio" name="indikator5_row11" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[10]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 11, Nilai 2: Mulai dilakukan identifikasi peningkatan peluang mempertemukan produk teknologi dengan kebutuhan pasar"><input type="radio" name="indikator5_row11" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[10]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 11, Nilai 3: Telah dapat diidentifikasi peningkatan peluang pasar baru yang dapat dimasuki."><input type="radio" name="indikator5_row11" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[10]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 11, Nilai 4: Telah dapat diidentifikasi peningkatan peluang pasar baru yang dapat dimasuki dan pelanggan baru dalam pasar yang ada sekarang."><input type="radio" name="indikator5_row11" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[10]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 11, Nilai 5: Telah dapat diidentifikasi peningkatan peluang mempertemukan produk teknologi dengan kebutuhan pasar, yaitu berupa pasar baru yang dapat dimasuki, pelanggan baru dalam pasar yang ada sekarang, dan produk-produk baru yang mempunyai potensi."><input type="radio" name="indikator5_row11" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[10]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Identifikasi peningkatan peluang pertemuan produk teknologi dengan kebutuhan pasar.</td>
                <td>
                        <select name="indikator5_dropdown11" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[10]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[10]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[10]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[10]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[10]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[10]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">12</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 12, Nilai 0: Belum dilakukan review proses teknis dan komersial."><input type="radio" name="indikator5_row12" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[11]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 12, Nilai 1: Persiapan dilakukan review proses teknis dan komersial."><input type="radio" name="indikator5_row12" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[11]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 12, Nilai 2: Telah dilakukan review proses teknis dan komersial untuk meningkatkan efektivitas."><input type="radio" name="indikator5_row12" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[11]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 12, Nilai 3: Telah dilakukan review proses teknis dan komersial untuk meningkatkan efektivitas dan efisiensi."><input type="radio" name="indikator5_row12" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[11]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 12, Nilai 4: Telah dilakukan review proses teknis dan komersial untuk meningkatkan efektivitas, efisiensi, dan produktivitas."><input type="radio" name="indikator5_row12" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[11]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 12, Nilai 5: Telah diperoleh dan digunakan hasil review proses teknis dan komersial untuk meningkatkan efektivitas, efisiensi, produktivitas, dan profit."><input type="radio" name="indikator5_row12" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[11]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah melakukan peninjauan proses teknis dan komersial untuk meningkatkan harga dan keuntungan.</td>
                <td>
                        <select name="indikator5_dropdown12" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[11]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[11]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[11]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[11]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[11]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[11]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <!-- Mf rows -->
                <tr class="row-mf">
                    <td class="row-number">13</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 13, Nilai 0: Belum menerapkan Lean Manufacturing secara total."><input type="radio" name="indikator5_row13" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[12]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 13, Nilai 1: Persiapan di tingkat top management untuk menerapkan Lean Manufacturing secara total."><input type="radio" name="indikator5_row13" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[12]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 13, Nilai 2: Tahap awal penerapan Lean Manufacturing secara total."><input type="radio" name="indikator5_row13" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[12]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 13, Nilai 3: Tahap awal penerapan Lean Manufacturing secara total."><input type="radio" name="indikator5_row13" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[12]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 13, Nilai 4: Proses iterasi penerapan Lean Manufacturing secara total."><input type="radio" name="indikator5_row13" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[12]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 13, Nilai 5: Telah diterapkan Lean Manufacturing secara total, dan telah diperoleh manfaat bagi perusahaan dan konsumen."><input type="radio" name="indikator5_row13" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[12]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Menerapkan GMP (Good Manufacturing Practice) atau Lean Manufacturing secara intensif.</td>
                <td>
                        <select name="indikator5_dropdown13" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[12]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[12]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[12]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[12]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[12]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[12]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-mf">
                    <td class="row-number">14</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 14, Nilai 0: Dalam perbaikan kinerja belum dibutuhkan masukan (internal/eksternal) kepada manajemen."><input type="radio" name="indikator5_row14" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[13]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 14, Nilai 1: Mulai ada kebutuhan masukan (internal maupun eksternal) kepada manajemen untuk perbaikan kinerja."><input type="radio" name="indikator5_row14" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[13]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 14, Nilai 2: Telah dilakukan masukan internal secara terbatas kepada manajemen untuk perbaikan kinerja."><input type="radio" name="indikator5_row14" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[13]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 14, Nilai 3: Telah dilakukan masukan internal 360 derajat kepada manajemen untuk perbaikan kinerja."><input type="radio" name="indikator5_row14" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[13]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 14, Nilai 4: Telah dilakukan masukan internal 360 derajat dan eksternal (mikro) kepada manajemen untuk perbaikan kinerja."><input type="radio" name="indikator5_row14" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[13]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 14, Nilai 5: Telah dilakukan masukan internal 360 derajat dan eksternal (mikro dan makro) kepada manajemen untuk perbaikan kinerja."><input type="radio" name="indikator5_row14" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[13]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Adanya kebutuhan saran (baik internal maupun eksternal) kepada manajemen untuk perbaikan kinerja.</td>
                <td>
                        <select name="indikator5_dropdown14" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[13]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[13]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[13]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[13]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[13]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[13]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-mf">
                    <td class="row-number">15</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 15, Nilai 0: Belum menerapkan penjaminan mutu sesuai standar (SNI) secara intensif."><input type="radio" name="indikator5_row15" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[14]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 15, Nilai 1: Telah muncul kesadaran menerapkan penjaminan mutu sesuai standar (SNI)."><input type="radio" name="indikator5_row15" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[14]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 15, Nilai 2: Upaya sosialisasi penerapan penjaminan mutu sesuai standar (SNI)."><input type="radio" name="indikator5_row15" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[14]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 15, Nilai 3: Mulai mempersiapkan penerapan penjaminan mutu sesuai standar (SNI)."><input type="radio" name="indikator5_row15" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[14]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 15, Nilai 4: Telah menerapkan penjaminan mutu sesuai standar (SNI), namun belum intensif."><input type="radio" name="indikator5_row15" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[14]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 15, Nilai 5: Telah menerapkan penjaminan mutu sesuai standar (SNI) secara intensif, dan telah digunakan sebagai alat bagi manajemen."><input type="radio" name="indikator5_row15" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[14]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah menerapkan jaminan mutu sesuai standar</td>
                    <td>
                        <select name="indikator5_dropdown15" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[14]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[14]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[14]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[14]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[14]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[14]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                 
                    <tr class="row-mf">
                    <td class="row-number">16</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 16, Nilai 0: Belum ada jaminan terhadap mutu, keamanan dan keselamatan produk yang dimanfaatkan oleh masyarakat."><input type="radio" name="indikator5_row16" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[15]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 16, Nilai 1: Membangun kesadaran dan komitmen."><input type="radio" name="indikator5_row16" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[15]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 16, Nilai 2: Sosialisasi rencana pelaksanaan sertifikasi produk dan akreditasi lembaga."><input type="radio" name="indikator5_row16" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[15]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 16, Nilai 3: Persiapan administrasi dan teknis pelaksanaan sertifikasi produk dan akreditasi lembaga."><input type="radio" name="indikator5_row16" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[15]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 16, Nilai 4: Proses sertifikasi produk dan akreditasi lembaga."><input type="radio" name="indikator5_row16" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[15]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 16, Nilai 5: Telah mendapat sertifikat produk dan akreditasi lembaga sebagai bentuk jaminan terhadap mutu, keamanan dan keselamatan produk di masyarakat."><input type="radio" name="indikator5_row16" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[15]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Adanya jaminan terhadap mutu, keamanan dan keselamatan produk yang dimanfaatkan oleh masyarakat.</td>
                <td>
                        <select name="indikator5_dropdown16" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[15]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[15]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[15]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[15]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[15]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[15]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <!-- I rows -->
                <tr class="row-i">
                    <td class="row-number">17</td>
                    <td class="aspect-cell">I</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 17, Nilai 0: Tidak dilakukan identifikasi kebutuhan memperluas pasar."><input type="radio" name="indikator5_row17" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[16]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 17, Nilai 1: Persiapan untuk melakukan identifikasi kebutuhan memperluas pasar."><input type="radio" name="indikator5_row17" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[16]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 17, Nilai 2: Dalam proses penyelesaian identifikasi kebutuhan memperluas pasar."><input type="radio" name="indikator5_row17" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[16]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 17, Nilai 3: Dalam proses penyelesaian identifikasi kebutuhan ekspansi pasar."><input type="radio" name="indikator5_row17" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[16]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 17, Nilai 4: Identifikasi kebutuhan ekspansi pasar telah selesai."><input type="radio" name="indikator5_row17" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[16]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 17, Nilai 5: Hasil identifikasi kebutuhan ekspansi pasar telah divalidasi."><input type="radio" name="indikator5_row17" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[16]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Kebutuhan perluasan pasar telah diidentifikasi.</td>
                <td>
                        <select name="indikator5_dropdown17" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[16]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[16]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[16]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[16]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[16]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[16]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-i">
                    <td class="row-number">18</td>
                    <td class="aspect-cell">I</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 18, Nilai 0: Belum ada peningkatan kapasitas produksi."><input type="radio" name="indikator5_row18" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[17]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 18, Nilai 1: Terdapat kecenderungan meningkatnya permintaan pasar."><input type="radio" name="indikator5_row18" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[17]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 18, Nilai 2: Ada peningkatan kapasitas produksi namun belum tercapai kapasitas produksi optimumnya."><input type="radio" name="indikator5_row18" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[17]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 18, Nilai 3: Ada peningkatan kapasitas produksi, dan telah tercapai kapasitas produksi optimumnya."><input type="radio" name="indikator5_row18" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[17]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 18, Nilai 4: Ada keharuskan penambahan kapasitas produksi."><input type="radio" name="indikator5_row18" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[17]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 18, Nilai 5: Telah dilakukan penambahan kapasitas produksi atas permintaan pasar."><input type="radio" name="indikator5_row18" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[17]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Adanya peningkatan kapasitas produksi.</td>
                <td>
                        <select name="indikator5_dropdown18" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[17]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[17]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[17]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[17]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[17]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[17]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <!-- P rows -->
                <tr class="row-p">
                    <td class="row-number">19</td>
                    <td class="aspect-cell">P</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 19, Nilai 0: Belum dilakukan peningkatan kerjasama didalam jejaring secara dinamis."><input type="radio" name="indikator5_row19" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[18]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 19, Nilai 0: Upaya evaluasi terhadap kerjasama didalam jejaring yang telah berjalan."><input type="radio" name="indikator5_row19" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[18]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 19, Nilai 0: Telah ditetapkan ada kebutuhan peningkatan kerjasama didalam jejaring yang telah berjalan."><input type="radio" name="indikator5_row19" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[18]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 19, Nilai 0: Telah dilakukan upaya peningkatan kerjasama didalam jaringan produksi."><input type="radio" name="indikator5_row19" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[18]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 19, Nilai 0: Telah dilakukan upaya peningkatan kerjasama didalam jaringan produksi dan pemasaran."><input type="radio" name="indikator5_row19" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[18]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 19, Nilai 0: Telah di upayakan peningkatan kerjasama dalam jejaring secara dinamis, meliputi: jaringan produksi, jaringan pemasaran, maupun jaringan pelayanan."><input type="radio" name="indikator5_row19" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[18]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Peningkatan kerjasama di dalam jejaring secara dinamis.</td>
                <td>
                        <select name="indikator5_dropdown19" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[18]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[18]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[18]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[18]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[18]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[18]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-p">
                    <td class="row-number">20</td>
                    <td class="aspect-cell">P</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 20, Nilai 0: Belum dilakukan peningkatan mutu pengelolaan kerjasama yang sudah berjalan."><input type="radio" name="indikator5_row20" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[19]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 20, Nilai 1: Evaluasi terhadap pengelolaan kerjasama yang telah berjalan."><input type="radio" name="indikator5_row20" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[19]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 20, Nilai 2: Telah teridentifikasi beberapa kelemahan pengelolaan kerjasama yang telah berjalan."><input type="radio" name="indikator5_row20" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[19]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 20, Nilai 3: Perencanaan upaya peningkatan mutu pengelolaan kerjasama yang sudah berjalan."><input type="radio" name="indikator5_row20" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[19]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 20, Nilai 4: Dilakukan eksekusi upaya peningkatan mutu pengelolaan kerjasama yang sudah berjalan."><input type="radio" name="indikator5_row20" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[19]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 20, Nilai 5: Telah dilakukan peningkatan mutu pengelolaan kerjasama yang sudah berjalan meliputi prinsip: persamaan, keterbukaan dan saling menguntungkan."><input type="radio" name="indikator5_row20" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[19]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah melakukan peningkatan mutu pengelolaan pada produk yang sudah berjalan.</td>
                <td>
                        <select name="indikator5_dropdown20" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[19]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[19]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[19]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[19]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[19]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[19]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-p">
                    <td class="row-number">21</td>
                    <td class="aspect-cell">P</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 21, Nilai 0: Belum dilakukan kerjasama distribusi dan pemasaran produk dengan pihak lain."><input type="radio" name="indikator5_row21" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[20]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 21, Nilai 1: Identifikasi mitra potensi untuk kerjasama distribusi dan pemasaran produk."><input type="radio" name="indikator5_row21" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[20]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 21, Nilai 2: Telah tetapkan mitra untuk kerjasama distribusi dan pemasaran produk."><input type="radio" name="indikator5_row21" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[20]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 21, Nilai 3: Perjanjian kesepakatan kerjasama distribusi dan pemasaran produk."><input type="radio" name="indikator5_row21" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[20]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 21, Nilai 4: Eksekusi kerjasama distribusi dan pemasaran produk."><input type="radio" name="indikator5_row21" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[20]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 21, Nilai 5: Telah berjalan kerjasama distribusi dan pemasaran produk dengan mitra, sehingga jangkauan pasarnya menjadi lebih luas."><input type="radio" name="indikator5_row21" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[20]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Kerja sama dalam distribusi dan pemasaran produk.</td>
                <td>
                        <select name="indikator5_dropdown21" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[20]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[20]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[20]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[20]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[20]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[20]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <!-- R rows -->
                <tr class="row-r">
                    <td class="row-number">22</td>
                    <td class="aspect-cell">R</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 22, Nilai 0: Belum disusun rencana pengendalian risiko non teknologi pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row22" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[21]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 22, Nilai 0: Garis besar rencana penyusunan risiko non-teknologi telah selesai pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row22" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[21]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 22, Nilai 0: Persiapan penyusunan rencana pengendalian risiko non teknologi pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row22" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[21]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 22, Nilai 0: Sedang disusun rencana pengendalian risiko non teknologi pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row22" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[21]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 22, Nilai 0: Penyelesaian penyusunan rencana pengendalian risiko non teknologi pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row22" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[21]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 22, Nilai 0: Tersusun rencana pengendalian risiko non teknologi pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row22" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[21]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Penyusunan rencana pengendalian risiko non teknologi (organisasi dan sosial) pada tahap kematangan pasar tercapai.</td>
                <td>
                        <select name="indikator5_dropdown22" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[21]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[21]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[21]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[21]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[21]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[21]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">23</td>
                    <td class="aspect-cell">R</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 23, Nilai 0: Belum dilakukan kajian risiko organisasi (khususnya indikator keuangan) pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row23" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[22]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 23, Nilai 1: Outline penyusunan kajian risiko organisasi (khususnya indikator keuangan) telah disusun pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row23" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[22]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 23, Nilai 2: Persiapan dilakukan kajian risiko organisasi (khususnya indikator keuangan) pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row23" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[22]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 23, Nilai 3: Tahap penyelesaian kajian risiko organisasi (khususnya indikator keuangan) pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row23" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[22]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 23, Nilai 4: Diperoleh hasil kajian risiko organisasi (khususnya indikator keuangan) pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row23" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[22]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 23, Nilai 5: Tersusun kajian risiko organisasi (khususnya indikator keuangan) pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row23" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[22]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Kajian risiko organisasi (khususnya indikator keuangan) pada tahap kematangan pasar tercapai.</td>
                <td>
                        <select name="indikator5_dropdown23" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[22]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[22]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[22]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[22]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[22]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[22]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">24</td>
                    <td class="aspect-cell">R</td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 23, Nilai 0: Belum dilakukan kajian risiko dampak sosial."><input type="radio" name="indikator5_row24" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[23]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 23, Nilai 1: Garis besar penyusunan kajian risiko dampak sosial telah selesai."><input type="radio" name="indikator5_row24" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[23]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 23, Nilai 2: Persiapan dilakukan kajian risiko dampak sosial pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row24" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[23]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 23, Nilai 3: Tahap penyelesaian kajian risiko dampak sosial pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row24" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[23]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 23, Nilai 4: Diperoleh hasil kajian risiko dampak sosial pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row24" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[23]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 5, Baris 23, Nilai 5: Tersusun kajian risiko dampak sosial pada tahap kematangan pasar tercapai."><input type="radio" name="indikator5_row24" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[23]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Kajian risiko dampak sosial pada tahap kematangan pasar tercapai.</td>
                <td>
                        <select name="indikator5_dropdown24" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFive->isNotEmpty() && $indicatorFive[23]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFive->isNotEmpty() && $indicatorFive[23]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFive->isNotEmpty() && $indicatorFive[23]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFive->isNotEmpty() && $indicatorFive[23]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFive->isNotEmpty() && $indicatorFive[23]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFive->isNotEmpty() && $indicatorFive[23]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                
                <tr class="total-row">
                    <td colspan="2">Total Skor</td>
                    <td colspan="6" class="total-value">{{ $indicatorFive->sum('score')/ 2 }} </td>
                    <td colspan="1" style="text-align: left; padding-left: 10px;">
                        <a href="{{ route('admin.katsinov.lampiran.index', ['katsinov_id' => $katsinov['id'] ?? null]) }}" class="btn btn-sm" style="background-color: #277177; border-color: #277177; color: white;" target="_blank">
                            <i class='bx bx-paperclip'></i> Lampiran
                        </a>
                    </td>
                </tr>
            <tr class="total-row">
                <td colspan="2">Persentase</td>
                <td colspan="6" class="total-value">({{ number_format(($indicatorFive->sum('score') / (24 * 10)) * 100, 2) }}%)</td>
                <td colspan="1" class="status-cell">
                    {{ ($indicatorFive->sum('score') / (21 * 5)) * 100 >= 80 ? 'TERPENUHI' : 'TIDAK TERPENUHI' }}
                </td>
            </tr>
            </table>
            <div class="katsinov-legend">
                Skala: 0=tidak terpenuhi; 1=20%; 2=40%; 3=60%; 4=80%; 5=100% atau terpenuhi
            </div>
            <div class="notes-section">
                <div class="notes-header">Catatan</div>
                <textarea 
                    name="notes[5]"
                    placeholder="Tambahkan catatan untuk Indikator 5 di sini..." 
                    class="notes-textarea form-control">{{ $notes[5] ?? '' }}</textarea>
            </div>
        </div>
    </div>
</div>


