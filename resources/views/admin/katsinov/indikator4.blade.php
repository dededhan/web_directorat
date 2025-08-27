
<div class="container" data-indicator="4">
    <div class="card" data-aos="fade-up">
        <div class="main-title">
            Indikator KATSINOV 4
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
                    <td rowspan="24" class="katsinov-title">KATSINOV 4</td>
                </tr>
                <!-- T rows -->
                <!-- T rows -->
                <tr class="row-t">
                    <td class="row-number">1</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 1, Nilai 0: Belum ada buku manual."><input type="radio" name="indikator4_row1" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[0]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 1, Nilai 1: Tersedia spesifikasi teknis saja."><input type="radio" name="indikator4_row1" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[0]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 1, Nilai 2: Tersedia spesifikasi teknis dan cara penggunaan."><input type="radio" name="indikator4_row1" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[0]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 1, Nilai 3: Tersedia spesifikasi teknis, cara penggunaan dan cara perawatan."><input type="radio" name="indikator4_row1" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[0]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 1, Nilai 4: Tersedia spesifikasi teknis, cara penggunaan, cara perawatan dan petunjuk teknis bila terjadi masalah."><input type="radio" name="indikator4_row1" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[0]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 1, Nilai 5: Tersedia spesifikasi teknis, cara penggunaan, cara perawatan, petunjuk teknis bila terjadi masalah dan dilengkapi alamat costomer service."><input type="radio" name="indikator4_row1" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[0]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah terbentuk keahlian terkait pengoperasian dan pemeliharaan produk teknologi.</td>
                    <td>
                        <select name="indikator4_dropdown1" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[0]->dropdown_value === 'A')> 0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[0]->dropdown_value === 'B')> 1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[0]->dropdown_value === 'C')> 2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[0]->dropdown_value === 'D')> 3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[0]->dropdown_value === 'E')> 4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[0]->dropdown_value === 'F')> 5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">2</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 2, Nilai 0: Belum diidentifikasi penggunaan umumnya."><input type="radio" name="indikator4_row2" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[1]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 2, Nilai 1: Pada tahap uji dan validasi di lingkungan laboratorium."><input type="radio" name="indikator4_row2" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[1]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 2, Nilai 2: Pada tahap uji dan validasi di kondisi yang hampir menyerupai lingkungannya."><input type="radio" name="indikator4_row2" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[1]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 2, Nilai 3: Pada tahap uji dan validasi di kondisi yang lingkungan sebenarnya."><input type="radio" name="indikator4_row2" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[1]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 2, Nilai 4: Telah diperoleh sistem teknologi yang stabil."><input type="radio" name="indikator4_row2" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[1]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 2, Nilai 5: Telah ditetapkan penggunaan umum produk teknologi oleh pasar luas."><input type="radio" name="indikator4_row2" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[1]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Penggunaan umum produk teknologi oleh cakupan pasar yang luas telah diidentifikasi.</td>
                 <td>
                        <select name="indikator4_dropdown2" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[1]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[1]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[1]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[1]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[1]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[1]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">3</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 3, Nilai 0: Belum dilakukan pengujian untuk identifikasi keuntungan teknologi."><input type="radio" name="indikator4_row3" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[2]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 3, Nilai 1: Tahap persiapan pengujian untuk identifikasi keuntungan teknologi."><input type="radio" name="indikator4_row3" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[2]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 3, Nilai 2: Mulai dilakukan pengujian untuk identifikasi keuntungan teknologi."><input type="radio" name="indikator4_row3" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[2]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 3, Nilai 3: Telah dilakukan pengujian intensif, tetapi belum dapat diidentifikasi keuntungan teknologinya."><input type="radio" name="indikator4_row3" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[2]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 3, Nilai 4: Telah dilakukan pengujian intensif, mulai teridentifikasi keuntungan teknologinya."><input type="radio" name="indikator4_row3" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[2]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 3, Nilai 5: Telah dilakukan pengujian intensif, mulai teridentifikasi keuntungan teknologinya."><input type="radio" name="indikator4_row3" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[2]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Keuntungan teknologi melalui hasil pengujian telah diidentifikasi.</td>
                 <td>
                        <select name="indikator4_dropdown3" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[2]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[2]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[2]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[2]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[2]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[2]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">4</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 4, Nilai 0: Belum ada dukungan terhadap adopsi produk teknologi oleh pasar."><input type="radio" name="indikator4_row4" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[3]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 4, Nilai 1: Tahap awal: Proses memberikan edukasi kepada pasar."><input type="radio" name="indikator4_row4" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[3]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 4, Nilai 2: Telah terbangun kesadaran pasar terhadap produk teknologi."><input type="radio" name="indikator4_row4" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[3]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 4, Nilai 3: Telah terbangun kesadaran dan minat pasar terhadap produk teknologi."><input type="radio" name="indikator4_row4" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[3]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 4, Nilai 4: Telah terbangun kesadaran, minat, dan mencoba produk teknologi."><input type="radio" name="indikator4_row4" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[3]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 4, Nilai 5: Telah terjadi adopsi produk teknologi oleh pasar."><input type="radio" name="indikator4_row4" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[3]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Adanya dukungan terhadap adopsi produk teknologi oleh pasar.</td>
                 <td>
                        <select name="indikator4_dropdown4" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[3]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[3]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[3]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[3]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[3]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[3]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">5</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 5, Nilai 0: Belum membangun citra produk teknologi kepada pasar."><input type="radio" name="indikator4_row5" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[4]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 5, Nilai 1: Persiapan untuk membangun citra produk teknologi kepada pasar."><input type="radio" name="indikator4_row5" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[4]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 5, Nilai 2: Menyusun garis besar strategi dan analisis isi untuk membangun citra produk teknologi kepada pasar"><input type="radio" name="indikator4_row5" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[4]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 5, Nilai 3: Tahap penyelesaian strategi dan analisis isi untuk membangun citra produk teknologi kepada pasar."><input type="radio" name="indikator4_row5" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[4]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 5, Nilai 4: Strategi dan analisis isi untuk membangun citra produk teknologi kepada pasar telah tersusun."><input type="radio" name="indikator4_row5" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[4]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 5, Nilai 5: Hasil analisis isi dan strategi untuk membangun citra produk teknologi kepada pasar telah diimplementasikan secara faktual."><input type="radio" name="indikator4_row5" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[4]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah membangun citra produk teknologi kepada pasar.</td>
                 <td>
                        <select name="indikator4_dropdown5" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[4]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[4]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[4]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[4]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[4]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[4]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">6</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 6, Nilai 0: Model bisnis belum ditetapkan."><input type="radio" name="indikator4_row6" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[5]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 6, Nilai 1: Persiapan perancangan model bisnis."><input type="radio" name="indikator4_row6" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[5]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 6, Nilai 2: Garis besar konsep dan materi model bisnis telah disusun."><input type="radio" name="indikator4_row6" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[5]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 6, Nilai 3: Perancangan dan penyelesaian model bisnis."><input type="radio" name="indikator4_row6" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[5]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 6, Nilai 4: Hasil rancang model bisnis telah dianalisis."><input type="radio" name="indikator4_row6" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[5]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 6, Nilai 5: Model bisnis telah ditetapkan."><input type="radio" name="indikator4_row6" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[5]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Model bisnis ditetapkan.</td>
                 <td>
                        <select name="indikator4_dropdown6" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[5]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[5]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[5]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[5]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[5]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[5]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">7</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 7, Nilai 0: Pesaing belum teridentifikasi."><input type="radio" name="indikator4_row7" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[6]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 7, Nilai 1: Persiapan kajian identifikasi pesaing."><input type="radio" name="indikator4_row7" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[6]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 7, Nilai 2: Garis besar konsep identifikasi pesaing telah disusu"><input type="radio" name="indikator4_row7" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[6]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 7, Nilai 3: Kajian identifikasi pesaing telah dirancang dan diselesaikan."><input type="radio" name="indikator4_row7" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[6]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 7, Nilai 4: Hasil kajian identifikasi pesaing telah dianalisis."><input type="radio" name="indikator4_row7" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[6]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 7, Nilai 5: Pesaing telah teridentifikasi dan ditetapkan."><input type="radio" name="indikator4_row7" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[6]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Pesaing diidentifikasi dengan baik.</td>
                 <td>
                        <select name="indikator4_dropdown7" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[6]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[6]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[6]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[6]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[6]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[6]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">8</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 8, Nilai 0: Belum dilakukan tahap perkenalan produk kepada pelanggannya di pasar"><input type="radio" name="indikator4_row8" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[7]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 8, Nilai 1: Persiapan strategi pengenalan (promosi) produk kepada pelanggannya di pasar."><input type="radio" name="indikator4_row8" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[7]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 8, Nilai 2: Mulai menyusun garis besar strategi dan materi pengenalan (promosi) produk kepada pelanggannya di pasar."><input type="radio" name="indikator4_row8" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[7]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 8, Nilai 3: Strategi dan materi pengenalan (promosi) telah di analisis."><input type="radio" name="indikator4_row8" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[7]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 8, Nilai 4: Strategi dan materi pengenalan (promosi) mulai dijalankan"><input type="radio" name="indikator4_row8" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[7]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 8, Nilai 5: Promosi dan pemasaran berjalan dengan efektif sehingga perusahaan memperoleh nilai tambah."><input type="radio" name="indikator4_row8" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[7]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Pemasaran ditekankan pada pengenalan secara spesifik produk teknologi kepada para pelanggannya.</td>
                 <td>
                        <select name="indikator4_dropdown8" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[7]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[7]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[7]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[7]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[7]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[7]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">9</td>
                    <td class="aspect-cell">O</td>
                    <td  data-description="Deskripsi untuk Indikator 4, Baris 9, Nilai 0: Belum ada organisasi."><input type="radio" name="indikator4_row9" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[8]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td  data-description="Deskripsi untuk Indikator 4, Baris 9, Nilai 1: Telah ada organisasi R&D (Research & Development)."><input type="radio" name="indikator4_row9" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[8]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td  data-description="Deskripsi untuk Indikator 4, Baris 9, Nilai 2: Proses pengubahan organisasi R&D menjadi organisasi bisnis, walaupun belum ditetapkan bentuk organisasinya."><input type="radio" name="indikator4_row9" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[8]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td  data-description="Deskripsi untuk Indikator 4, Baris 9, Nilai 3: Organisasi R&D telah menjadi organisasi bisnis, walaupun belum ditetapkan bentuk organisasinya."><input type="radio" name="indikator4_row9" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[8]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td  data-description="Deskripsi untuk Indikator 4, Baris 9, Nilai 4: Organisasi R&D telah menjadi organisasi bisnis dan sudah ditetapkan bentuk organisasinya. Tapi belum berbadan hukum."><input type="radio" name="indikator4_row9" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[8]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td  data-description="Deskripsi untuk Indikator 4, Baris 9, Nilai 5: Telah ada bentuk organisasi bisnis dan berbadan hukum."><input type="radio" name="indikator4_row9" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[8]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah menetapkan bentuk organisasi.</td>
                 <td>
                        <select name="indikator4_dropdown9" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[8]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[8]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[8]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[8]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[8]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[8]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">10</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 10, Nilai 0: Belum dilakukan pengembangan kemitraan dengan organisasi independen."><input type="radio" name="indikator4_row10" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[9]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 10, Nilai 1: Tahap persiapan pengembangan kemitraan dengan organisasi independen."><input type="radio" name="indikator4_row10" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[9]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 10, Nilai 2: Mulai dikembangkan kemitraan dengan organisasi independen"><input type="radio" name="indikator4_row10" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[9]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 10, Nilai 3: Telah berkembang kemitraan dengan organisasi independen, tetapi belum bersifat formal dan mengikat."><input type="radio" name="indikator4_row10" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[9]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 10, Nilai 4: Mulai dibangun kemitraan dengan organisasi independen yang bersifat formal dan mengikat."><input type="radio" name="indikator4_row10" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[9]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 10, Nilai 5: Telah terbangun kemitraan dengan organisasi independen yang bersifat formal dan mengikat."><input type="radio" name="indikator4_row10" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[9]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah mengembangkan kemitraan dengan organisasi independen.</td>
                 <td>
                        <select name="indikator4_dropdown10" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[9]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[9]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[9]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[9]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[9]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[9]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">11</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 11, Nilai 0: Belum ada produk baru yang diperkenalkan kepada mitra dan pasar baru."><input type="radio" name="indikator4_row11" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[10]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 11, Nilai 1: Tahap pengembangan produk baru."><input type="radio" name="indikator4_row11" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[10]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 11, Nilai 2: Tahap penyelesaian pengembangan produk baru."><input type="radio" name="indikator4_row11" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[10]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 11, Nilai 3: Telah diperoleh produk baru yang siap diperkenalkan ke pasar"><input type="radio" name="indikator4_row11" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[10]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 11, Nilai 4: Proses identifikasi peluang untuk memperkenalkan produk kepada mitra dan pasar baru."><input type="radio" name="indikator4_row11" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[10]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 11, Nilai 5: Telah diidentifikasi peluang untuk memperkenalkan produk dan mulai dilakukan pengenalan."><input type="radio" name="indikator4_row11" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[10]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Identifikasi peluang untuk memperkenalkan produk kepada mitra dan pasar baru.</td>
                 <td>
                        <select name="indikator4_dropdown11" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[10]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[10]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[10]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[10]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[10]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[10]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-mf">
                    <td class="row-number">12</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 12, Nilai 0: Telah diperoleh perancangan dan sistem metode produksi rinci, namun belum menunjukkan produksi yang menguntungkan secara finansial."><input type="radio" name="indikator4_row12" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[11]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 12, Nilai 1: Sedang dilakukan tahap uji terhadap hasil perancangan sistem atau metode produksi rinci yang menguntungkan secara finansial."><input type="radio" name="indikator4_row12" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[11]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 12, Nilai 2: Tahap uji yang berulang-ulang terhadap hasil perancangan sistem atau metode produksi rinci, dan telah menunjukkan kestabilan"><input type="radio" name="indikator4_row12" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[11]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 12, Nilai 3: Sudah dilakukan produksi namun keuntungan finansial masih rendah."><input type="radio" name="indikator4_row12" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[11]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 12, Nilai 4: Persiapan produksi yang menguntungkan secara finansial dalam tahap uji dan evaluasi."><input type="radio" name="indikator4_row12" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[11]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 12, Nilai 5: Telah dilakukan produksi yang menguntungkan secara finansial."><input type="radio" name="indikator4_row12" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[11]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah diperlihatkan produksi yang menguntungkan secara finansial.</td>
                 <td>
                        <select name="indikator4_dropdown12" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[11]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[11]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[11]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[11]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[11]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[11]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-mf">
                    <td class="row-number">13</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 13, Nilai 0: Produksi belum memenuhi ketentuan keamanan, kualitas, dan persyaratan hukum yang diberlakukan secara nasional maupun internasional."><input type="radio" name="indikator4_row13" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[12]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 13, Nilai 1: Tahap persiapan pengurusan ketentuan keamanan, kualitas, dan persyaratan hukum yang diberlakukan secara nasional maupun internasional"><input type="radio" name="indikator4_row13" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[12]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 13, Nilai 2: Mulai dilakukan pengurusan secara administratif ketentuan keamanan, kualitas, dan persyaratan hukum yang diberlakukan secara nasional maupun internasional."><input type="radio" name="indikator4_row13" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[12]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 13, Nilai 3: Tahap verifikasi dan/atau appraisal oleh institusi berwenang dalam rangka memperoleh ketentuan keamanan, kualitas, dan persyaratan hukum yang diberlakukan secara nasional maupun internasional."><input type="radio" name="indikator4_row13" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[12]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 13, Nilai 4: Telah dinyatakan memenuhi ketentuan keamanan, kualitas, dan persyaratan hukum yang diberlakukan secara nasional maupun internasional."><input type="radio" name="indikator4_row13" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[12]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 13, Nilai 5: Produksi sudah melaksanakan dan memenuhi ketentuan keamanan, kualitas, dan persyaratan hukum yang diberlakukan secara nasional maupun internasional"><input type="radio" name="indikator4_row13" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[12]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Mulai menerapkan GMP (Good Manufacturing Practice) atau Lean Manufacturing.</td>
                 <td>
                        <select name="indikator4_dropdown13" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[12]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[12]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[12]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[12]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[12]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[12]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-mf">
                    <td class="row-number">14</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 14, Nilai 0: Belum menerapkan jaminan mutu."><input type="radio" name="indikator4_row14" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[13]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 14, Nilai 1: Tahap persiapan menerapkan jaminan mutu."><input type="radio" name="indikator4_row14" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[13]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 14, Nilai 2: Mulai menerapkan jaminan mutu."><input type="radio" name="indikator4_row14" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[13]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 14, Nilai 3: Tahap pengurusan mendapatkan akreditasi jaminan mutu."><input type="radio" name="indikator4_row14" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[13]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 14, Nilai 4: Tahap verifikasi dan/atau appraisal oleh institusi berwenang dalam rangka memperoleh akreditasi jaminan mutu sesuai standar tertentu."><input type="radio" name="indikator4_row14" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[13]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 14, Nilai 5: Telah mendapatkan sertifikat dan melaksanakan jaminan mutu sesuai standar tertentu yang dipersyaratkan."><input type="radio" name="indikator4_row14" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[13]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Mulai menerapkan jaminan mutu sesuai standar (SNI).</td>
                 <td>
                        <select name="indikator4_dropdown14" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[13]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[13]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[13]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[13]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[13]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[13]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-mf">
                    <td class="row-number">15</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 15, Nilai 0: Belum ada kesadaran memperhatikan tuntutan masyarakat terhadap mutu, keamanan dan keselamatan produk yang dimanfaatkan."><input type="radio" name="indikator4_row15" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[14]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 15, Nilai 1: Tahap munculnya kesadaran awal untuk menerima dan memenuhi tuntutan masyarakat terhadap mutu, keamanan dan keselamatan produk yang dimanfaatkan."><input type="radio" name="indikator4_row15" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[14]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 15, Nilai 2: Tahap melakukan upaya memperoleh tanggapan atau feedback dari masyarakat atau pelanggannya terhadap mutu, keamanan dan keselamatan produk yang dimanfaatkan."><input type="radio" name="indikator4_row15" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[14]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 15, Nilai 3: Telah menerima tanggapan atau feedback dari masyarakat atau pelanggannya terhadap mutu, keamanan dan keselamatan produk,, tetapi belum melakukan upaya untuk memenuhi tuntutan tersebut."><input type="radio" name="indikator4_row15" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[14]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 15, Nilai 4: Telah menerima dan memenuhi tuntutan dari terhadap mutu, keamanan dan keselamatan produk."><input type="radio" name="indikator4_row15" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[14]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 15, Nilai 5: Telah menerima dan memenuhi tuntutan secara optimal dari masyarakat atau pelanggannya terhadap mutu, keamanan dan keselamatan produk yang dimanfaatkan."><input type="radio" name="indikator4_row15" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[14]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Adanya tuntutan masyarakat terhadap mutu, keamanan dan keselamatan produk yang dimanfaatkan.</td>
                 <td>
                        <select name="indikator4_dropdown15" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[14]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[14]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[14]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[14]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[14]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[14]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-i">
                    <td class="row-number">16</td>
                    <td class="aspect-cell">I</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 16, Nilai 0: Belum dilakukan identifikasi potensi pasar"><input type="radio" name="indikator4_row16" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[15]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 16, Nilai 1: Mulai dilakukan identifikasi potensi pasar."><input type="radio" name="indikator4_row16" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[15]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 16, Nilai 2: Potensi pasar telah teridentifikasi."><input type="radio" name="indikator4_row16" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[15]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 16, Nilai 3: Hasil teridentifikasi potensi pasar mulai dianalisis."><input type="radio" name="indikator4_row16" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[15]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 16, Nilai 4: Hasil identifikasi potensi pasar telah selesai dianalisis."><input type="radio" name="indikator4_row16" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[15]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 16, Nilai 5: Telah diperkirakan daya serap konsumen terhadap produk/jasa yang ditawarkan melalui identifikasi dan analisis potensi pasar."><input type="radio" name="indikator4_row16" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[15]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Potensi pasar teridentifikasi.</td>
                 <td>
                        <select name="indikator4_dropdown16" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[15]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[15]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[15]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[15]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[15]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[15]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-i">
                    <td class="row-number">17</td>
                    <td class="aspect-cell">I</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 17, Nilai 0: Belum dilakukan identifikasi keberterimaan produk/jasa di pasar."><input type="radio" name="indikator4_row17" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[16]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 17, Nilai 1: Persiapan pelaksanaan identifikasi keberterimaan produk/jasa di pasar."><input type="radio" name="indikator4_row17" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[16]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 17, Nilai 2: Telah dilakukan identifikasi keberterimaan produk/jasa di pasar."><input type="radio" name="indikator4_row17" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[16]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 17, Nilai 3: Hasil identifikasi keberterimaan produk/jasa di pasar telah dianalisis."><input type="radio" name="indikator4_row17" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[16]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 17, Nilai 4: Hasil identifikasi keberterimaan produk/jasa di pasar telah dianalisis"><input type="radio" name="indikator4_row17" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[16]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 17, Nilai 5: Hasil analisi identifikasi keberterimaan produk/jasa di pasar, telah menjadi pertimbangan dalam penyusunan strategi pemasaran"><input type="radio" name="indikator4_row17" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[16]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Daya terima pasar terhadap produk telah teridentifikasi.</td>
                 <td>
                        <select name="indikator4_dropdown17" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[16]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[16]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[16]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[16]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[16]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[16]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-p">
                    <td class="row-number">18</td>
                    <td class="aspect-cell">P</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 18, Nilai 0: Tidak melihat jaringan mitra sebagai hal yang strategis untuk keberhasilan bisnisnya."><input type="radio" name="indikator4_row18" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[17]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 18, Nilai 1: Mulai muncul kesadaran bahwa membangun kerjasama didalam jejaring secara dinamis adalah hal yang strategis untuk keberhasilan bisnisnya."><input type="radio" name="indikator4_row18" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[17]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 18, Nilai 2: Mulai melakukan pencarian jejaring yang dapat mendukung bisnisnya."><input type="radio" name="indikator4_row18" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[17]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 18, Nilai 3: Telah ditemukan dan mulai membangun kerjasama didalam jejaring yang dapat mendukung bisnisnya."><input type="radio" name="indikator4_row18" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[17]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 18, Nilai 4: Telah melakukan dan memanfaatkan kerjasama didalam jejaring namun belum dinamis"><input type="radio" name="indikator4_row18" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[17]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 18, Nilai 5: Telah melakukan dan memanfaatkan kerjasama didalam jejaring secara dinamis"><input type="radio" name="indikator4_row18" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[17]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Melakukan kerja sama di dalam jejaring usaha secara dinamis.</td>
                 <td>
                        <select name="indikator4_dropdown18" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[17]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[17]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[17]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[17]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[17]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[17]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-p">
                    <td class="row-number">19</td>
                    <td class="aspect-cell">P</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 19, Nilai 0: Kerjasama yang telah dibangun, tetapi tidak ada tindak lanjutnya."><input type="radio" name="indikator4_row19" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[18]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 19, Nilai 1: Masih tahap perencanaan implementasi kerjasama."><input type="radio" name="indikator4_row19" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[18]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 19, Nilai 2: Telah ada rencana implementasi kerjasama yang disepakati, tetapi implementasinya masih nol."><input type="radio" name="indikator4_row19" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[18]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 19, Nilai 3: Telah diimplementasikan sebagian rencana kerjasama yang disepakati"><input type="radio" name="indikator4_row19" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[18]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 19, Nilai 4: Telah mengimplementasikan seluruh rencana kerjasama yang disepakati."><input type="radio" name="indikator4_row19" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[18]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 19, Nilai 5: Telah mengimplementasikan seluruh rencana kerjasama yang disepakati, dan melakukan pengelolaan kerjasama yang sudah berjalan."><input type="radio" name="indikator4_row19" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[18]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Terus melakukan pengelolaan terhadap kerjasama yang sudah berjalan.</td>
                 <td>
                        <select name="indikator4_dropdown19" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[18]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[18]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[18]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[18]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[18]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[18]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">20</td>
                    <td class="aspect-cell">R</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 20, Nilai 0: Belum ada rencana pengendalian risiko non teknologi pada tahap introduksi produk ke pasar."><input type="radio" name="indikator4_row20" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[19]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 20, Nilai 1: Memiliki rencana dan persiapan pengendalian risiko non teknologi pada tahap introduksi produk ke pasar."><input type="radio" name="indikator4_row20" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[19]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 20, Nilai 2: Mulai menyusun rencana pengendalian risiko non teknologi pada tahap introduksi produk ke pasar."><input type="radio" name="indikator4_row20" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[19]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 20, Nilai 3: Tahap penyelesaian penyusunan rencana pengendalian risiko non teknologi pada tahap introduksi produk ke pasar."><input type="radio" name="indikator4_row20" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[19]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 20, Nilai 4: Tersusun rencana pengendalian risiko non teknologi pada tahap introduksi produk ke pasar."><input type="radio" name="indikator4_row20" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[19]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 20, Nilai 5: Rencana pengendalian risiko non teknologi pada tahap introduksi produk ke pasar telah divalidasi."><input type="radio" name="indikator4_row20" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[19]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Penyusunan rencana pengendalian risiko non teknologi (organisasi dan sosial) pada tahap pengenalan produk ke pasar.</td>
                 <td>
                        <select name="indikator4_dropdown20" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[19]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[19]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[19]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[19]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[19]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[19]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">21</td>
                    <td class="aspect-cell">R</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 21, Nilai 0: Belum dilakukan kajian risiko organisasi (khususnya indikator keuangan) pada tahap introduksi produk ke pasar."><input type="radio" name="indikator4_row21" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[20]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 21, Nilai 1: Persiapan pelaksanaan kajian risiko organisasi (khususnya indikator keuangan) pada tahap introduksi produk ke pasar."><input type="radio" name="indikator4_row21" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[20]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 21, Nilai 2: Konsep dan outline pelaksanaan kajian risiko organisasi (khususnya indikator keuangan) pada tahap introduksi produk ke pasar telah disusun."><input type="radio" name="indikator4_row21" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[20]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 21, Nilai 3: Mulai dilakukan kajian risiko organisasi (khususnya indikator keuangan) pada tahap introduksi produk ke pasar."><input type="radio" name="indikator4_row21" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[20]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 21, Nilai 4: Hasil kajian risiko organisasi (khususnya indikator keuangan) pada tahap introduksi produk ke pasar selesai disusun."><input type="radio" name="indikator4_row21" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[20]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 21, Nilai 5: Telah diperoleh hasil kajian risiko organisasi (khususnya indikator keuangan) pada tahap introduksi produk ke pasar yang tervalidasi."><input type="radio" name="indikator4_row21" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[20]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Kajian risiko organisasi (khususnya indikator keuangan) dilakukan pada tahap pengenalan produk ke pasar.</td>
                 <td>
                        <select name="indikator4_dropdown21" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[20]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[20]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[20]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[20]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[20]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[20]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">22</td>
                    <td class="aspect-cell">R</td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 22, Nilai 0: Belum dilakukan kajian risiko dampak sosial pada tahap pengenalan produk ke pasa."><input type="radio" name="indikator4_row22" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[21]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 22, Nilai 1: Persiapan pelaksanaan kajian risiko dampak sosial pada tahap introduksi produk ke pasar."><input type="radio" name="indikator4_row22" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[21]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 22, Nilai 2: Konsep dan outline kajian risiko dampak sosial tahap introduksi produk ke pasar telah disusun."><input type="radio" name="indikator4_row22" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[21]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 22, Nilai 3: Mulai dilakukan kajian risiko dampak sosial pada tahap introduksi produk ke pasar."><input type="radio" name="indikator4_row22" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[21]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 22, Nilai 4: Kajian risiko dampak sosial pada tahap introduksi produk ke pasar selesai disusun."><input type="radio" name="indikator4_row22" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[21]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 4, Baris 22, Nilai 5: Hasil kajian risiko dampak sosial pada tahap introduksi produk ke pasar telah divalidasi."><input type="radio" name="indikator4_row22" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[21]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Kajian risiko dampak sosial pada tahap pengenalan produk ke pasar.</td>
                 <td>
                        <select name="indikator4_dropdown22" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorFour->isNotEmpty() && $indicatorFour[21]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorFour->isNotEmpty() && $indicatorFour[21]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorFour->isNotEmpty() && $indicatorFour[21]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorFour->isNotEmpty() && $indicatorFour[21]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorFour->isNotEmpty() && $indicatorFour[21]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorFour->isNotEmpty() && $indicatorFour[21]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                
                <tr class="total-row">
                    <td colspan="2">Total Skor</td>
                    <td colspan="6" class="total-value">{{ $indicatorFour->sum('score')/ 2 }} </td>
                    <td colspan="1" style="text-align: left; padding-left: 10px;">
                        <a href="{{ route('admin.katsinov.lampiran.index', ['katsinov_id' => $katsinov['id'] ?? null]) }}" class="btn btn-sm" style="background-color: #277177; border-color: #277177; color: white;" target="_blank">
                            <i class='bx bx-paperclip'></i> Lampiran
                        </a>
                    </td>
                </tr>
            <tr class="total-row">
                <td colspan="2">Persentase</td>
                <td colspan="6" class="total-value">({{ number_format(($indicatorFour->sum('score') / (22 * 10)) * 100, 2) }}%)</td>
                <td colspan="1" class="status-cell">
                    {{ ($indicatorFour->sum('score') / (21 * 5)) * 100 >= 80 ? 'TERPENUHI' : 'TIDAK TERPENUHI' }}
                </td>
            </tr>
            </table>
            <div class="katsinov-legend">
                Skala: 0=tidak terpenuhi; 1=20%; 2=40%; 3=60%; 4=80%; 5=100% atau terpenuhi
            </div>
            <div class="notes-section">
                <div class="notes-header">Catatan</div>
                <textarea 
                name="notes[4]"
                placeholder="Tambahkan catatan untuk Indikator 4 di sini..." 
                class="notes-textarea form-control">{{ $notes[4] ?? '' }}</textarea>
            </div>
        </div>
    </div>
</div>


