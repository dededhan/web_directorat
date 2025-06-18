<div class="container" data-indicator="6">
    <div class="card" data-aos="fade-up">
        <div class="main-title">
            Indikator KATSINOV 6
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
                    <td rowspan="16" class="katsinov-title">KATSINOV 6</td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">1</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 1, Nilai 0: Belum dilakukan review terhadap produk teknologi milik kompetitor."><input type="radio" name="indikator6_row1" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[0]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 1, Nilai 1: Pembahasan urgensi review terhadap produk milik kompetitor di level top management."><input type="radio" name="indikator6_row1" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[0]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 1, Nilai 2: Persiapan pelaksanaan review terhadap produk milik kompetitor di level top management."><input type="radio" name="indikator6_row1" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[0]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 1, Nilai 3: Mulai dilakukan review terhadap produk milik kompetitor di level top management."><input type="radio" name="indikator6_row1" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[0]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 1, Nilai 4: Review terhadap produk milik kompetitor dalam penyelesaian."><input type="radio" name="indikator6_row1" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[0]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 1, Nilai 5: Telah diperoleh hasil review terhadap produk teknologi milik kompetitor."><input type="radio" name="indikator6_row1" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[0]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Produk teknologi milik kompetitor telah ditinjau.</td>
                    <td>
                        <select name="indikator6_dropdown1" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorSix->isNotEmpty() && $indicatorSix[0]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorSix->isNotEmpty() && $indicatorSix[0]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorSix->isNotEmpty() && $indicatorSix[0]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorSix->isNotEmpty() && $indicatorSix[0]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorSix->isNotEmpty() && $indicatorSix[0]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorSix->isNotEmpty() && $indicatorSix[0]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">2</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 2, Nilai 0: Belum dilakukan review terhadap kemampuan teknologi yang dimiliki."><input type="radio" name="indikator6_row2" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[1]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 2, Nilai 1: Pembahasan ditingkat top management terkait urgensi review."><input type="radio" name="indikator6_row2" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[1]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 2, Nilai 2: Persiapan pelaksanaan review terhadap kemampuan teknologi yang dimiliki."><input type="radio" name="indikator6_row2" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[1]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 2, Nilai 3: Mulai dilakukan review terhadap kemampuan teknologi."><input type="radio" name="indikator6_row2" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[1]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 2, Nilai 4: Review terhadap kemampuan teknologi dalam penyelesaian."><input type="radio" name="indikator6_row2" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[1]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 2, Nilai 5: Telah diperoleh review kemampuan teknologi."><input type="radio" name="indikator6_row2" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[1]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah meninjau kemampuan teknologi yang dimiliki untuk mendukung inovasi ulang atau pengembangan teknologi baru.</td>
                    <td>
                        <select name="indikator6_dropdown2" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorSix->isNotEmpty() && $indicatorSix[1]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorSix->isNotEmpty() && $indicatorSix[1]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorSix->isNotEmpty() && $indicatorSix[1]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorSix->isNotEmpty() && $indicatorSix[1]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorSix->isNotEmpty() && $indicatorSix[1]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorSix->isNotEmpty() && $indicatorSix[1]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">3</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 3, Nilai 0: Belum diputuskan apakah melakukan inovasi ulang, atau pengembangan produk baru."><input type="radio" name="indikator6_row3" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[2]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 3, Nilai 1: Keputusan melakukan kajian untuk menentukan pilihan: inovasi ulang atau pengembangan produk baru."><input type="radio" name="indikator6_row3" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[2]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 3, Nilai 2: Persiapan pelaksanaan kajian untuk menentukan pilihan: inovasi ulang atau pengembangan produk baru."><input type="radio" name="indikator6_row3" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[2]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 3, Nilai 3: Mulai dilaksanaan kajian untuk menentukan pilihan: inovasi ulang atau pengembangan produk baru."><input type="radio" name="indikator6_row3" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[2]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 3, Nilai 4: Kajian untuk menentukan pilihan: inovasi ulang atau pengembangan produk baru dalam penyelesaian."><input type="radio" name="indikator6_row3" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[2]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 3, Nilai 5: Telah ada keputusan dari menejemen terkait pilihan atas inovasi ulang atau pengembangan baru."><input type="radio" name="indikator6_row3" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[2]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah memilih antara melakukan inovasi ulang produk teknologi yang ada, atau mengembangkan produk teknologi baru.</td>
                 <td>
                        <select name="indikator6_dropdown3" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorSix->isNotEmpty() && $indicatorSix[2]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorSix->isNotEmpty() && $indicatorSix[2]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorSix->isNotEmpty() && $indicatorSix[2]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorSix->isNotEmpty() && $indicatorSix[2]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorSix->isNotEmpty() && $indicatorSix[2]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorSix->isNotEmpty() && $indicatorSix[2]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">4</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 4, Nilai 0: Penurunan pasar belum dikonfirmasi."><input type="radio" name="indikator6_row4" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[3]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 4, Nilai 1: Terdapat gejala kecenderungan (trend) penurunan pasar."><input type="radio" name="indikator6_row4" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[3]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 4, Nilai 2: Gejala kecenderungan (trend) penurunan pasar sedang dianalisis."><input type="radio" name="indikator6_row4" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[3]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 4, Nilai 3: Penurunan pasar mulai terkonfirmasi berdasarkan hasil analisis."><input type="radio" name="indikator6_row4" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[3]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 4, Nilai 4: Penurunan pasar terkonfirmasi berdasarkan hasil analisis."><input type="radio" name="indikator6_row4" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[3]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 4, Nilai 5: Penurunan pasar telah dikonfirmasi secara faktual."><input type="radio" name="indikator6_row4" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[3]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Penurunan pasar telah dikonfirmasi.</td>
                 <td>
                        <select name="indikator6_dropdown4" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorSix->isNotEmpty() && $indicatorSix[3]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorSix->isNotEmpty() && $indicatorSix[3]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorSix->isNotEmpty() && $indicatorSix[3]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorSix->isNotEmpty() && $indicatorSix[3]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorSix->isNotEmpty() && $indicatorSix[3]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorSix->isNotEmpty() && $indicatorSix[3]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">5</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 5, Nilai 0: Belum ada riset pasar untuk persetujuan inovasi ulang atau pengembangan teknologi yang lebih maju."><input type="radio" name="indikator6_row5" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[4]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 5, Nilai 1: Persiapan pelaksanaan riset pasar untuk persetujuan inovasi ulang atau pengembangan teknologi yang lebih maju."><input type="radio" name="indikator6_row5" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[4]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 5, Nilai 2: Mulai dilaksanakan riset pasar untuk persetujuan inovasi ulang atau pengembangan teknologi yang lebih maju."><input type="radio" name="indikator6_row5" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[4]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 5, Nilai 3: Sedang dilaksanakan riset pasar untuk persetujuan inovasi ulang atau pengembangan teknologi yang lebih maju."><input type="radio" name="indikator6_row5" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[4]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 5, Nilai 4: Riset pasar untuk persetujuan inovasi ulang atau pengembangan teknologi yang lebih maju selesai dilaksanakan."><input type="radio" name="indikator6_row5" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[4]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 5, Nilai 5: Hasil riset pasar menjadi pertimbangan bagi Top Management."><input type="radio" name="indikator6_row5" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[4]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Riset pasar untuk persetujuan inovasi ulang atau pengembangan teknologi yang lebih maju.</td>
                 <td>
                        <select name="indikator6_dropdown5" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorSix->isNotEmpty() && $indicatorSix[4]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorSix->isNotEmpty() && $indicatorSix[4]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorSix->isNotEmpty() && $indicatorSix[4]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorSix->isNotEmpty() && $indicatorSix[4]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorSix->isNotEmpty() && $indicatorSix[4]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorSix->isNotEmpty() && $indicatorSix[4]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">6</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 6, Nilai 0: Belum meninjau permintaan pasar."><input type="radio" name="indikator6_row6" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[5]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 6, Nilai 1: Telah menyusun konsep review permintaan pasar."><input type="radio" name="indikator6_row6" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[5]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 6, Nilai 2: Persiapan review permintaan pasar."><input type="radio" name="indikator6_row6" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[5]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 6, Nilai 3: Mulai pelaksanaan review permintaan pasar."><input type="radio" name="indikator6_row6" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[5]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 6, Nilai 4: Telah diperoleh hasil review permintaan pasar."><input type="radio" name="indikator6_row6" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[5]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 6, Nilai 5: Hasil review permintaan pasar menjadi pertimbangan top manajemen mengambil keputusan untuk reinovasi."><input type="radio" name="indikator6_row6" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[5]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Permintaan pasar telah ditinjau.</td>
                 <td>
                        <select name="indikator6_dropdown6" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorSix->isNotEmpty() && $indicatorSix[5]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorSix->isNotEmpty() && $indicatorSix[5]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorSix->isNotEmpty() && $indicatorSix[5]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorSix->isNotEmpty() && $indicatorSix[5]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorSix->isNotEmpty() && $indicatorSix[5]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorSix->isNotEmpty() && $indicatorSix[5]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">7</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 7, Nilai 0: Belum diidentifikasi peluang tumbuhnya pasar atau ekspansi pasar baru."><input type="radio" name="indikator6_row7" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[6]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 7, Nilai 1: Persiapan identifikasi peluang tumbuhnya pasar atau ekspansi pasar baru."><input type="radio" name="indikator6_row7" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[6]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 7, Nilai 2: Mulai dilakukan identifikasi peluang tumbuhnya pasar atau ekspansi pasar baru."><input type="radio" name="indikator6_row7" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[6]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 7, Nilai 3: Tahap penyelesaian identifikasi peluang tumbuhnya pasar atau ekspansi pasar baru."><input type="radio" name="indikator6_row7" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[6]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 7, Nilai 4: Telah diperoleh hasil identifikasi peluang tumbuhnya pasar atau ekspansi pasar baru."><input type="radio" name="indikator6_row7" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[6]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 7, Nilai 5: Hasil identifikasi peluang tumbuhnya pasar atau ekspansi pasar baru menjadi pertimbangan top manajemen mengambil keputusan untuk reinovasi."><input type="radio" name="indikator6_row7" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[6]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Identifikasi peluang tumbuhnya pasar atau ekspansi pasar baru.</td>
                 <td>
                        <select name="indikator6_dropdown7" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorSix->isNotEmpty() && $indicatorSix[6]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorSix->isNotEmpty() && $indicatorSix[6]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorSix->isNotEmpty() && $indicatorSix[6]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorSix->isNotEmpty() && $indicatorSix[6]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorSix->isNotEmpty() && $indicatorSix[6]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorSix->isNotEmpty() && $indicatorSix[6]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">8</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 8, Nilai 0: Tidak ada dukungan komitmen manajemen dan dukungan sumber daya di lingkungan perusahaan."><input type="radio" name="indikator6_row8" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[7]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 8, Nilai 1: Organisasi belum mempunyai arah dan aksi nyata dalam mendukung Inovasi Ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row8" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[7]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 8, Nilai 2: Organisasi telah memberikan arah, tetapi perannya belum nyata dalam mendukung Inovasi Ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row8" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[7]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 8, Nilai 3: Ada peran organisasi dalam bentuk dukungan sumber daya di lingkungan perusahaan."><input type="radio" name="indikator6_row8" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[7]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 8, Nilai 4: Ada peran organisasi dalam bentuk dukungan nyata berupa komitmen manajemen di lingkungan perusahaan."><input type="radio" name="indikator6_row8" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[7]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 8, Nilai 5: Ada peran organisasi dalam bentuk dukungan nyata berupa komitmen manajemen dan dukungan sumber daya di lingkungan perusahaan."><input type="radio" name="indikator6_row8" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[7]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Adanya peran jaringan kemitraan dalam mendukung inovasi ulang atau pengembangan teknologi baru.</td>
                 <td>
                        <select name="indikator6_dropdown8" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorSix->isNotEmpty() && $indicatorSix[7]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorSix->isNotEmpty() && $indicatorSix[7]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorSix->isNotEmpty() && $indicatorSix[7]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorSix->isNotEmpty() && $indicatorSix[7]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorSix->isNotEmpty() && $indicatorSix[7]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorSix->isNotEmpty() && $indicatorSix[7]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">9</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 9, Nilai 0: Tidak memiliki jejaring untuk mendukung Inovasi Ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row9" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[8]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 9, Nilai 1: Memiliki jejaring, tetapi belum ada peran dalam mendukung Inovasi Ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row9" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[8]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 9, Nilai 2: Memiliki jejaring dan perannya kurang dalam mendukung Inovasi Ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row9" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[8]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 9, Nilai 3: Memiliki jejaring dan ada peran yang cukup besar dalam mendukung Inovasi Ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row9" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[8]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 9, Nilai 4: Memiliki jejaring dan ada peran yang besar dalam mendukung Inovasi Ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row9" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[8]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 9, Nilai 5: Memiliki jejaring dan ada peran yang sangat besar dalam mendukung Inovasi Ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row9" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[8]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Ada peran jejaring dalam mendukung Inovasi Ulang atau Pengembangan Teknologi Baru.</td>
                 <td>
                        <select name="indikator6_dropdown9" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorSix->isNotEmpty() && $indicatorSix[8]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorSix->isNotEmpty() && $indicatorSix[8]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorSix->isNotEmpty() && $indicatorSix[8]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorSix->isNotEmpty() && $indicatorSix[8]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorSix->isNotEmpty() && $indicatorSix[8]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorSix->isNotEmpty() && $indicatorSix[8]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-MF">
                    <td class="row-number">10</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 10, Nilai 0: Inovasi produksi atau pengembangan teknologi produksi baru belum menjadi kebutuhan bagi perusahaan."><input type="radio" name="indikator6_row10" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[9]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 10, Nilai 1: Mulai muncul tekanan dari pesaing di pasar yang ditunjukkan oleh penurunan penjualan."><input type="radio" name="indikator6_row10" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[9]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 10, Nilai 2: Perusahaan mulai melakukan upaya mencari berbagai alternatif untuk bertahan."><input type="radio" name="indikator6_row10" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[9]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 10, Nilai 3: Alternatif inovasi produksi atau pengembangan teknologi produksi baru belum menjadi prioritas."><input type="radio" name="indikator6_row10" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[9]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 10, Nilai 4: Alternatif inovasi produksi atau pengembangan teknologi produksi baru dipertimbangkan sebagai prioritas."><input type="radio" name="indikator6_row10" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[9]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 10, Nilai 5: Inovasi produksi atau pengembangan teknologi produksi baru telah diputuskan menjadi kebutuhan mendesak bagi perusahaan."><input type="radio" name="indikator6_row10" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[9]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Ada kebutuhan dilakukannya inovasi produksi atau pengembangan teknologi produksi baru.</td>
                 <td>
                        <select name="indikator6_dropdown10" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorSix->isNotEmpty() && $indicatorSix[9]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorSix->isNotEmpty() && $indicatorSix[9]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorSix->isNotEmpty() && $indicatorSix[9]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorSix->isNotEmpty() && $indicatorSix[9]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorSix->isNotEmpty() && $indicatorSix[9]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorSix->isNotEmpty() && $indicatorSix[9]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-i">
                    <td class="row-number">11</td>
                    <td class="aspect-cell">I</td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 11, Nilai 0: Belum diidentifikasi inovasi lanjutan terkait skema investasi tambahan."><input type="radio" name="indikator6_row11" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[10]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 11, Nilai 1: Persiapan identifikasi inovasi lanjutan terkait skema investasi tambahan."><input type="radio" name="indikator6_row11" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[10]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 11, Nilai 2: Mulai dilakukan identifikasi inovasi lanjutan terkait skema investasi tambahan."><input type="radio" name="indikator6_row11" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[10]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 11, Nilai 3: Tahap penyelesaian identifikasi inovasi lanjutan terkait skema investasi tambahan."><input type="radio" name="indikator6_row11" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[10]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 11, Nilai 4: Telah diperoleh hasil identifikasi inovasi lanjutan terkait skema investasi tambahan."><input type="radio" name="indikator6_row11" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[10]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 11, Nilai 5: Hasil identifikasi inovasi lanjutan menjadi pertimbangan top manajemen mengambil keputusan untuk reinvestasi."><input type="radio" name="indikator6_row11" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[10]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah mengidentifikasi inovasi lanjutan dari produk, berdasarkan kebutuhan dan permintaan pasar saat ini dan beberapa tahun ke depan.</td>
                 <td>
                        <select name="indikator6_dropdown11" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorSix->isNotEmpty() && $indicatorSix[10]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorSix->isNotEmpty() && $indicatorSix[10]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorSix->isNotEmpty() && $indicatorSix[10]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorSix->isNotEmpty() && $indicatorSix[10]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorSix->isNotEmpty() && $indicatorSix[10]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorSix->isNotEmpty() && $indicatorSix[10]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-p">
                    <td class="row-number">12</td>
                    <td class="aspect-cell">P</td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 12, Nilai 0: Belum dilakukan review terhadap kemitraan yang sudah berjalan."><input type="radio" name="indikator6_row12" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[11]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 12, Nilai 1: Pada tahap persiapan pelaksanaan review terhadap kemitraan yang sudah berjalan."><input type="radio" name="indikator6_row12" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[11]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 12, Nilai 2: Mulai dilakukan review terhadap kemitraan yang sudah berjalan."><input type="radio" name="indikator6_row12" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[11]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 12, Nilai 3: Dalam proses penyelesaian review terkait dengan mutu mitra dan kemitraan yang sudah berjalan."><input type="radio" name="indikator6_row12" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[11]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 12, Nilai 4: Telah diperoleh hasil review terkait dengan mutu mitra dan kemitraan yang sudah berjalan."><input type="radio" name="indikator6_row12" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[11]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 12, Nilai 5: Telah diketahui kualitas, kelebihan serta kekurangan dari kemitraan yang sudah berjalan."><input type="radio" name="indikator6_row12" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[11]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah melakukan tinjauan terhadap kemitraan yang sudah berjalan.</td>
                 <td>
                        <select name="indikator6_dropdown12" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorSix->isNotEmpty() && $indicatorSix[11]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorSix->isNotEmpty() && $indicatorSix[11]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorSix->isNotEmpty() && $indicatorSix[11]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorSix->isNotEmpty() && $indicatorSix[11]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorSix->isNotEmpty() && $indicatorSix[11]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorSix->isNotEmpty() && $indicatorSix[11]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-p">
                    <td class="row-number">13</td>
                    <td class="aspect-cell">P</td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 13, Nilai 0: Belum melakukan pencarian mitra potensial untuk mendukung Inovasi ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row13" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[12]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 13, Nilai 1: Identifikasi kebutuhan Inovasi ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row13" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[12]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 13, Nilai 2: Evaluasi kemampuan internal dalam pelaksanaan Inovasi ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row13" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[12]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 13, Nilai 3: Identifikasi mitra potensial untuk mendukung Inovasi ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row13" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[12]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 13, Nilai 4: Telah ditetapkan kebutuhan dan peran mitra potensial untuk mendukung Inovasi ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row13" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[12]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 13, Nilai 5: Telah diperoleh mitra potensial untuk mendukung Inovasi ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row13" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[12]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah melakukan pencarian mitra potensial untuk mendukung Inovasi ulang atau Pengembangan Teknologi Baru.</td>
                 <td>
                        <select name="indikator6_dropdown13" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorSix->isNotEmpty() && $indicatorSix[12]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorSix->isNotEmpty() && $indicatorSix[12]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorSix->isNotEmpty() && $indicatorSix[12]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorSix->isNotEmpty() && $indicatorSix[12]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorSix->isNotEmpty() && $indicatorSix[12]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorSix->isNotEmpty() && $indicatorSix[12]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">14</td>
                    <td class="aspect-cell">R</td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 14, Nilai 0: Belum dilakukan kajian risiko untuk mendukung keputusan Inovasi Ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row14" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[13]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 14, Nilai 1: Persiapan pelaksanaan kajian risiko untuk mendukung keputusan Inovasi Ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row14" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[13]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 14, Nilai 2: Mulai dilaksanakan kajian risiko untuk mendukung keputusan Inovasi Ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row14" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[13]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 14, Nilai 3: Sedang dilaksanakan kajian risiko untuk mendukung keputusan Inovasi Ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row14" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[13]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 14, Nilai 4: Selesai dilaksanakan kajian risiko untuk mendukung keputusan Inovasi Ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row14" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[13]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 6, Baris 14, Nilai 5: Hasil analisis kajian risiko menjadi pertimbangan bagi top manajemen untuk mengambil keputusan melakukan Inovasi Ulang atau Pengembangan Teknologi Baru."><input type="radio" name="indikator6_row14" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[13]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah melakukan kajian risiko untuk mendukung keputusan Inovasi Ulang atau Pengembangan Teknologi Baru.</td>
                 <td>
                        <select name="indikator6_dropdown14" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorSix->isNotEmpty() && $indicatorSix[13]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorSix->isNotEmpty() && $indicatorSix[13]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorSix->isNotEmpty() && $indicatorSix[13]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorSix->isNotEmpty() && $indicatorSix[13]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorSix->isNotEmpty() && $indicatorSix[13]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorSix->isNotEmpty() && $indicatorSix[13]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="total-row">
                    <td colspan="2">Total Skor</td>
                    <td colspan="6" class="total-value">{{ $indicatorSix->sum('score')/ 2 }} </td>
                    <td colspan="1" style="text-align: left; padding-left: 10px;">
                        <a href="{{ route('admin.katsinov.lampiran.index', ['katsinov_id' => $katsinov['id'] ?? null]) }}" class="btn btn-sm" style="background-color: #277177; border-color: #277177; color: white;" target="_blank">
                            <i class='bx bx-paperclip'></i> Lampiran
                        </a>
                    </td>
                </tr>
            <tr class="total-row">
                <td colspan="2">Persentase</td>
                <td colspan="6" class="total-value">({{ number_format(($indicatorSix->sum('score') / (14 * 10)) * 100, 2) }}%)</td>
                <td colspan="1" class="status-cell">
                    {{ ($indicatorSix->sum('score') / (21 * 5)) * 100 >= 80 ? 'TERPENUHI' : 'TIDAK TERPENUHI' }}
                </td>
            </tr>
            </table>
           
            <div class="katsinov-legend">
                Skala: 0=tidak terpenuhi; 1=20%; 2=40%; 3=60%; 4=80%; 5=100% atau terpenuhi
            </div>
            <div class="notes-section">
                <div class="notes-header">Catatan</div>
                <textarea 
                name="notes[6]"
                placeholder="Tambahkan catatan untuk Indikator 6 di sini..." 
                class="notes-textarea form-control">{{ $notes[6] ?? '' }}</textarea>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('indikator.js') }}"></script>
