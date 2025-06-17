
<div class="container" data-indicator="3">
    <div class="card" data-aos="fade-up">
        <div class="main-title">
            Indikator KATSINOV 3
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
                    <td rowspan="24" class="katsinov-title">KATSINOV 3</td>
                </tr>
                <!-- T rows -->
                <tr class="row-r">
                    <td class="row-number">1</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 1, Nilai 0: Belum diperoleh prototype"><input type="radio" name="indikator3_row22" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[0]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 1, Nilai 1: Prototype dalam proses penyelesaian. "><input type="radio" name="indikator3_row22" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[0]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 1, Nilai 2: Prototype sudah selesai. "><input type="radio" name="indikator3_row22" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[0]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 1, Nilai 3: Prototype sedang dalam tahap pengujian dilingkungan sebenarnya. "><input type="radio" name="indikator3_row22" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[0]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 1, Nilai 4: Prototype sudah selesai dalam pengujian dilingkungan sebenarnya. "><input type="radio" name="indikator3_row22" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[0]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 1, Nilai 5: Telah berhasil dalam tahap pengujian prototype. "><input type="radio" name="indikator3_row22" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[0]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Sistem aktual teknologi telah didemonstrasikan dalam lingkungan yang sebenarnya.</td>
                    <td>
                        <select name="indikator3_dropdown1" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[0]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[0]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[0]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[0]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[0]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[0]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">2</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 2, Nilai 0: Belum dilakukan uji eksternal "><input type="radio" name="indikator3_row23" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[1]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 2, Nilai 1: Mempersiapkan uji eksternal "><input type="radio" name="indikator3_row23" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[1]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 2, Nilai 2: Mulai dilakukan uji eksternal "><input type="radio" name="indikator3_row23" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[1]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 2, Nilai 3: Uji eksternal berjalan 60% "><input type="radio" name="indikator3_row23" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[1]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 2, Nilai 4: Uji eksternal berjalan 80% "><input type="radio" name="indikator3_row23" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[1]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 2, Nilai 5: Telah diperoleh sertifikat hasil pengujian eksternal "><input type="radio" name="indikator3_row23" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[1]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Uji eksternal dari teknologi yang dikembangkan telah dilakukan secara lengkap, dalam rangka memenuhi persyaratan teknis dan kesesuaian regulasi.</td>
                  <td>
                        <select name="indikator3_dropdown2" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[1]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[1]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[1]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[1]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[1]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[1]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">3</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 3, Nilai 0: Tidak dilakukan dokumentasi"><input type="radio" name="indikator3_row24" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[2]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 3, Nilai 1: Tahap : pencatatan kegiatan, dokumentasi petunjuk kerja, dan laporan teknis berkala "><input type="radio" name="indikator3_row24" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[2]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 3, Nilai 2: Dalam proses menuju pengelolaan pencatatan kegiatan, dokumentasi petunjuk kerja, dan laporan teknis secara sistematis."><input type="radio" name="indikator3_row24" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[2]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 3, Nilai 3: Dalam pengelolaan pencatatan kegiatan, dokumentasi petunjuk kerja, dan laporan teknis secara sistematis. Tapi belum di dokumentasi. "><input type="radio" name="indikator3_row24" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[2]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 3, Nilai 4: Dalam pengelolaan pencatatan kegiatan, dokumentasi petunjuk kerja, dan laporan teknis secara sistematis. Terdokumentasi namun belum teratur & terstruktur. "><input type="radio" name="indikator3_row24" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[2]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 3, Nilai 5: Dokumentasi sudah teratur dan berstruktur. "><input type="radio" name="indikator3_row24" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[2]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah mendokumentasikan teknologi yang dikembangkan.</td>
                  <td>
                        <select name="indikator3_dropdown3" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[2]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[2]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[2]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[2]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[2]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[2]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">4</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 4, Nilai 0: Belum memperkenalkan hasil inovasi. "><input type="radio" name="indikator3_row25" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[3]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 4, Nilai 1: Perencanaan memperkenalkan hasil inovasi. Tetapi belum diputuskan: kapan, dimana, siapa, dan bagaimana."><input type="radio" name="indikator3_row25" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[3]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 4, Nilai 2: Perencanaan memperkenalkan hasil inovasi. Sudah diputuskan: kapan, dimana, siapa, dan bagaimana."><input type="radio" name="indikator3_row25" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[3]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 4, Nilai 3: Dalam persiapan memperkenalkan hasil inovasi."><input type="radio" name="indikator3_row25" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[3]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 4, Nilai 4: Telah dilakukan perkenalan hasil inovasi."><input type="radio" name="indikator3_row25" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[3]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 4, Nilai 5: Telah dilakukan perkenalan hasil inovasi, dan dapat diterima oleh pasar."><input type="radio" name="indikator3_row25" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[3]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Hasil Inovasi telah diperkenalkan.</td>
                  <td>
                        <select name="indikator3_dropdown4" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[3]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[3]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[3]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[3]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[3]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[3]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">5</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 5, Nilai 0:  Belum diperoleh kekayaan intelektual."><input type="radio" name="indikator3_row26" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[4]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 5, Nilai 1:  Mempelajari persyaratan dalam memperoleh kekayaan intelektual."><input type="radio" name="indikator3_row26" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[4]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 5, Nilai 2:  Persiapan persyaratan dalam memperoleh kekayaan intelektual."><input type="radio" name="indikator3_row26" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[4]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 5, Nilai 3:  Telah mendapatkan surat submit dari Dirjen HKI."><input type="radio" name="indikator3_row26" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[4]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 5, Nilai 4:  Menunggu keluarnya sertifikat kekayaan intelektual."><input type="radio" name="indikator3_row26" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[4]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 5, Nilai 5:  Telah diperoleh sertifikat kekayaan intelektual."><input type="radio" name="indikator3_row26" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[4]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah memperoleh Kekayaan intelektual (misal: paten, desain industri, hak cipta, merek, dll).</td>
                  <td>
                        <select name="indikator3_dropdown5" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[4]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[4]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[4]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[4]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[4]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[4]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">6</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 6, Nilai 0:  Belum dilakukan identifikasi dan analisis kebutuhan dan harapan pelanggan."><input type="radio" name="indikator3_row27" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[5]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 6, Nilai 1:  Mengawali identifikasi: analisis kebutuhan dan harapan pelanggan."><input type="radio" name="indikator3_row27" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[5]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 6, Nilai 2:  Penuangan hasil ide analisis kebutuhan dan harapan pelanggan kedalam tulisan."><input type="radio" name="indikator3_row27" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[5]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 6, Nilai 3:  Sedang dilakukan identifikasi dan analisis kebutuhan dan harapan pelanggan."><input type="radio" name="indikator3_row27" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[5]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 6, Nilai 4:  Identifikasi dan analisis kebutuhan dan harapan pelanggan telah selesai."><input type="radio" name="indikator3_row27" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[5]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 6, Nilai 5:  Identifikasi dan analisis kebutuhan dan harapan pelanggan telah selesai dan tervalidasi."><input type="radio" name="indikator3_row27" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[5]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Kebutuhan khusus dan keperluan pelanggan telah diketahui.</td>
                  <td>
                        <select name="indikator3_dropdown6" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[5]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[5]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[5]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[5]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[5]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[5]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">7</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 7, Nilai 0:  Belum diprediksi segmen."><input type="radio" name="indikator3_row28" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[6]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 7, Nilai 1:  Persiapan survei dan kajian untuk prediksi segmen, ukuran serta pangsa pasar."><input type="radio" name="indikator3_row28" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[6]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 7, Nilai 2:  Garis dasar serta garis besar materi riset data telah disusun."><input type="radio" name="indikator3_row28" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[6]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 7, Nilai 3:  Garis dasar serta garis besar materi riset data dalam tahap pelaksanaan."><input type="radio" name="indikator3_row28" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[6]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 7, Nilai 4:  Garis dasar serta garis besar materi riset data telah selesai dilaksanakan."><input type="radio" name="indikator3_row28" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[6]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 7, Nilai 5:  Garis dasar serta garis besar materi riset data telah selesai dilaksanakan dan tervalidasi."><input type="radio" name="indikator3_row28" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[6]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Segmen, ukuran dan pangsa pasar telah diprediksi.</td>
                  <td>
                        <select name="indikator3_dropdown7" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[6]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[6]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[6]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[6]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[6]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[6]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">8</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 8, Nilai 0:  Belum ada perkiraan harga."><input type="radio" name="indikator3_row29" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[7]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 8, Nilai 1:  Sudah ada perkiraan harga, namun belum ada rencana perkenalan produk."><input type="radio" name="indikator3_row29" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[7]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 8, Nilai 2:  Sudah ada perkiraan harga, sudah ada rencana perkenalan produk."><input type="radio" name="indikator3_row29" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[7]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 8, Nilai 3:  Harga sudah diperkirakan, sudah ada rencana pengenalan, namun jenis produk belum rinci."><input type="radio" name="indikator3_row29" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[7]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 8, Nilai 4:  Harga sudah diperkirakan menurut jenis produk, namun tidak lengkap."><input type="radio" name="indikator3_row29" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[7]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 8, Nilai 5:  Harga sudah diperkirakan menurut jenis produk secara lengkap."><input type="radio" name="indikator3_row29" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[7]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Produk telah diperkenalkan, dan harganya telah ditetapkan.</td>
                  <td>
                        <select name="indikator3_dropdown8" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[7]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[7]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[7]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[7]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[7]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[7]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">9</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 9, Nilai 0:  Belum ada tuntutan penetapan organisasi."><input type="radio" name="indikator3_row30" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[8]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 9, Nilai 1:  Sudah ada tuntutan bisnis namun belum diupayakan penetapan organisasi."><input type="radio" name="indikator3_row30" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[8]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 9, Nilai 2:  Karena ada tuntutan bisnis maka mulai diupayakan penetapan organisasi."><input type="radio" name="indikator3_row30" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[8]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 9, Nilai 3:  Upaya formalitas organisasi telah dilakukan, walaupun masih belum secara de jure dan de facto."><input type="radio" name="indikator3_row30" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[8]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 9, Nilai 4:  Upaya formalitas organisasi telah dilakukan namun baru dilakukan salah satu cara diantara de facto atau de jure."><input type="radio" name="indikator3_row30" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[8]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 9, Nilai 5:  Telah dilakukan formalitas organisasi secara de jure dan de facto untuk memenuhi tuntutan bisnis."><input type="radio" name="indikator3_row30" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[8]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Penetapan organisasi (struktur bisnis dengan staff dan kolaborator).</td>
                  <td>
                        <select name="indikator3_dropdown9" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[8]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[8]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[8]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[8]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[8]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[8]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">10</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 10, Nilai 0:  Belum ada ide terkait dengan: identifikasi, evaluasi dan perencanaan SDM untuk menentukan kebutuhan tambahan staff."><input type="radio" name="indikator3_row31" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[9]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 10, Nilai 1:  Kebutuhan tambahan staff dilakukan tanpa dilakukan identifikasi, evaluasi dan perencanaan SDM."><input type="radio" name="indikator3_row31" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[9]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 10, Nilai 2:  Dalam menentukan kebutuhan tambahan staff mulai mempertimbangkan identifikasi, evaluasi dan perencanaan SDM."><input type="radio" name="indikator3_row31" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[9]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 10, Nilai 3:  Kebutuhan tambahan staff telah dilakukan berdasar hasil identifikasi, evaluasi dan perencanaan SDM, walaupun belum terstruktur dan sistematis."><input type="radio" name="indikator3_row31" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[9]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 10, Nilai 4:  Kebutuhan tambahan staff telah secara terstruktur dilakukan berdasar hasil identifikasi, evaluasi dan perencanaan SDM."><input type="radio" name="indikator3_row31" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[9]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 10, Nilai 5:  Kebutuhan tambahan staff telah secara terstruktur dan sistematis melalui proses identifikasi, evaluasi dan perencanaan SDM."><input type="radio" name="indikator3_row31" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[9]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Identifikasi beberapa tambahan staff yang dibutuhkan.</td>
                  <td>
                        <select name="indikator3_dropdown10" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[9]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[9]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[9]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[9]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[9]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[9]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">11</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 11, Nilai 0:  Tidak ada pembagian tanggung jawab dan beban kerja."><input type="radio" name="indikator3_row32" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[10]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 11, Nilai 1:  Tahap identifikasi pembagian tanggung jawab dan beban kerja."><input type="radio" name="indikator3_row32" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[10]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 11, Nilai 2:  Pembagian tanggung jawab dan beban kerja telah teridentifikasi."><input type="radio" name="indikator3_row32" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[10]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 11, Nilai 3:  Mulai menerapkan pembagian tanggung jawab dan beban kerja."><input type="radio" name="indikator3_row32" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[10]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 11, Nilai 4:  Telah dilaksanakan pembagian tanggung jawab dan beban kerja, walaupun belum secara terstruktur dan sistematis."><input type="radio" name="indikator3_row32" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[10]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 11, Nilai 5:  Telah dilaksanakan pembagian tanggung jawab dan beban kerja secara terstruktur dan sistematis dengan menyesuaikan tuntutan bisnis."><input type="radio" name="indikator3_row32" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[10]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah merincikan pembagian tanggung jawab dan beban kerja.</td>
                  <td>
                        <select name="indikator3_dropdown11" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[10]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[10]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[10]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[10]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[10]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[10]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">12</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 12, Nilai 0:  Desain sistem belum diperoleh."><input type="radio" name="indikator3_row33" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[11]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 12, Nilai 1:  Proses pembentukan desain sistem."><input type="radio" name="indikator3_row33" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[11]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 12, Nilai 2:  Telah diperoleh desain sistem."><input type="radio" name="indikator3_row33" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[11]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 12, Nilai 3:  Desain sistem mulai dilakukan uji dan evaluasi."><input type="radio" name="indikator3_row33" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[11]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 12, Nilai 4:  Pengulangan uji dan evaluasi desain sistem untuk memperoleh stabilitas desain sistem."><input type="radio" name="indikator3_row33" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[11]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 12, Nilai 5:  Telah diperoleh desain sistem yang sebagian besar stabil melalui uji dan evaluasi."><input type="radio" name="indikator3_row33" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[11]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Desain sistem sebagian besar stabil dan terbukti dalam uji dan evaluasi.</td>
                  <td>
                        <select name="indikator3_dropdown12" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[11]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[11]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[11]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[11]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[11]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[11]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">13</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 13, Nilai 0:  Masih pada tahap pengembangan proses dan prosedur manufaktur dalam skala laboratorium."><input type="radio" name="indikator3_row34" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[12]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 13, Nilai 1:  Dalam proses uji dan validasi proses dan prosedur manufaktur dalam skala laboratorium."><input type="radio" name="indikator3_row34" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[12]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 13, Nilai 2:  Tahap aktivitas pengembangan proses dan prosedur manufaktur dalam skala pilot."><input type="radio" name="indikator3_row34" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[12]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 13, Nilai 3:  Telah diperoleh proses dan prosedur manufaktur dalam skala pilot, dan mulai dilakukan uji dan validasi proses dan prosedur manufaktur dalam skala pilot."><input type="radio" name="indikator3_row34" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[12]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 13, Nilai 4:  Dalam proses pengulangan uji dan validasi proses dan prosedur manufaktur dalam skala pilot."><input type="radio" name="indikator3_row34" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[12]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 13, Nilai 5:  Proses dan prosedur manufaktur telah terbukti dalam uji dan validasi skala pilot."><input type="radio" name="indikator3_row34" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[12]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Proses dan prosedur manufaktur terbukti dalam skala pilot.</td>
                  <td>
                        <select name="indikator3_dropdown13" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[12]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[12]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[12]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[12]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[12]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[12]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">14</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 14, Nilai 0:  Belum dibuat perancangan sistem atau metode produksi rinci."><input type="radio" name="indikator3_row35" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 14, Nilai 1:  sedang dilakukan perancangan sistem atau metode produksi rinci melalui kegiatan pengembangan kerekayasaan dan manufaktur."><input type="radio" name="indikator3_row35" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 14, Nilai 2:  Telah diperoleh perancangan sistem atau metode produksi rinci."><input type="radio" name="indikator3_row35" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 14, Nilai 3:  Sedang dilakukan tahap uji terhadap hasil perancangan sistem atau metode produksi rinci."><input type="radio" name="indikator3_row35" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 14, Nilai 4:  Tahap iterasi uji terhadap hasil perancangan sistem atau metode produksi rinci, dan telah menunjukkan stabil."><input type="radio" name="indikator3_row35" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 14, Nilai 5:  Telah dilaksanakan Produksi awal laju rendah."><input type="radio" name="indikator3_row35" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Produksi pada laju rendah telah dilaksanakan.</td>
                  <td>
                        <select name="indikator3_dropdown14" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[13]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[13]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[13]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[13]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[13]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[13]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">15</td>
                    <td class="aspect-cell">I</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 15, Nilai 0:  Belum mendefinisikan kondisi akhir dari produk teknologi dengan mempertimbangkan target person, pasar vertikal, serta geografik"><input type="radio" name="indikator3_row36" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 15, Nilai 0:  Telah dilakukan analisis rantai bisnis."><input type="radio" name="indikator3_row36" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 15, Nilai 0:  Telah diidentifikasi target person, pasar vertikal dan preferensi atau trend di wilayah geografik."><input type="radio" name="indikator3_row36" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 15, Nilai 0:  telah dilakukan analisis pasar terhadap 2 dari 3 kategori pelanggan."><input type="radio" name="indikator3_row36" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 15, Nilai 0:  Telah dilakukan analisis pasar terhadap semua kategori pelanggan."><input type="radio" name="indikator3_row36" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 15, Nilai 0:  Produk yang dikembangkan sesuai dengan preferensi semua kategori pelanggan."><input type="radio" name="indikator3_row36" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah mendefinisikan kondisi akhir dari produk teknologi dengan mempertimbangkan target person, pasar vertikal, serta geografik.</td>
                  <td>
                        <select name="indikator3_dropdown15" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[14]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[14]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[14]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[14]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[14]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[14]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">16</td>
                    <td class="aspect-cell">I</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 16, Nilai 0:  Belum memvalidasi terhadap bisnis yang dilakukan."><input type="radio" name="indikator3_row37" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[14]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 16, Nilai 1:  Telah ada konsep bisnis kanvas."><input type="radio" name="indikator3_row37" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[14]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 16, Nilai 2:  Konsep model bisnis kanvas telah komprehensif."><input type="radio" name="indikator3_row37" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[14]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 16, Nilai 3:  Telah diidentifikasi aspek aspek analisis kelayakan finansial."><input type="radio" name="indikator3_row37" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[14]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 16, Nilai 4:  Telah dilakukan analisis kelayakan finansia"><input type="radio" name="indikator3_row37" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[14]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 16, Nilai 5:  Bisnis yang dikembangkan telah memenuhi analisis kelayakan finansial."><input type="radio" name="indikator3_row37" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[14]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Validasi terhadap bisnis yang dilakukan sudah diterapkan.</td>
                  <td>
                        <select name="indikator3_dropdown16" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[15]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[15]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[15]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[15]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[15]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[15]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">17</td>
                    <td class="aspect-cell">I</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 17, Nilai 0:  Tidak ada bukti studi kelayakan penetapan Indikator kinerja utama terhadap kelayakan dan keberhasilan bisnis."><input type="radio" name="indikator3_row38" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[15]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 17, Nilai 1:  Ada bukti yang lemah terhadap indikator kinerja utama dalam indikasi keberhasilan bisnis."><input type="radio" name="indikator3_row38" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[15]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 17, Nilai 2:  Kelemahan bukti sedang disempurnakan."><input type="radio" name="indikator3_row38" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[15]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 17, Nilai 3:  Penyempurnaan bukti telah selesai."><input type="radio" name="indikator3_row38" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[15]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 17, Nilai 4:  Bukti penetapan IKU terhadap kelayakan dan keberhasilan bisnis telah dianalisis."><input type="radio" name="indikator3_row38" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[15]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 17, Nilai 5:  Penetapan IKU terhadap kelayakan dan keberhasilan bisnis telah divalidasi ."><input type="radio" name="indikator3_row38" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[15]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Identifikasi dan validasi terhadap indikator kinerja utama yang mengindikasikan keberhasilan bisnis.</td>
                  <td>
                        <select name="indikator3_dropdown17" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[16]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[16]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[16]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[16]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[16]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[16]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">18</td>
                    <td class="aspect-cell">P</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 18, Nilai 0:  Dalam penjajakan menjalin kemitraan."><input type="radio" name="indikator3_row39" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[16]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 18, Nilai 1:  Mulai terjalin kemitraan yang sifatnya belum formal dan mengikat."><input type="radio" name="indikator3_row39" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[16]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 18, Nilai 2:  Tahap mencari pola kemitraan yang sifatnya formal dan mengikat."><input type="radio" name="indikator3_row39" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[16]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 18, Nilai 3:  Disepakati untuk melakukan perjanjian yang sifatnya mengikat kedua pihak yang bermitra."><input type="radio" name="indikator3_row39" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[16]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 18, Nilai 4:  Persiapan dokumen perjanjian yang sifatnya mengikat kedua pihak yang bermitra."><input type="radio" name="indikator3_row39" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[16]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 18, Nilai 5:  Pola kemitraan telah disepakati dalam bentuk perjanjian, secara legal formal kemitraan tersebut telah memberikan ikatan bagi kedua pihak yang bermitra."><input type="radio" name="indikator3_row39" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[16]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah terjalin kemitraan secara formal.</td>
                  <td>
                        <select name="indikator3_dropdown18" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[17]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[17]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[17]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[17]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[17]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[17]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">19</td>
                    <td class="aspect-cell">P</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 19, Nilai 0:  Belum dibuat rencana kerjasama kemitraan."><input type="radio" name="indikator3_row40" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[17]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 19, Nilai 1:  Tahap eksplorasi rencana kerjasama yang akan disusun."><input type="radio" name="indikator3_row40" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[17]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 19, Nilai 2:  Mulai dilakukan penyusunan bersama rencana kerjasama."><input type="radio" name="indikator3_row40" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[17]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 19, Nilai 3:  Penyelesaian dokumen rencana kerjasama."><input type="radio" name="indikator3_row40" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[17]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 19, Nilai 4:  Telah diperoleh dokumen rencana kerjasama."><input type="radio" name="indikator3_row40" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[17]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 19, Nilai 5:  Telah ada dokumen dan penerapan rencana kerjasama."><input type="radio" name="indikator3_row40" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[17]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah menyusun dan telah menerapkan rencana kerja sama.</td>
                  <td>
                        <select name="indikator3_dropdown19" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[18]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[18]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[18]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[18]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[18]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[18]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">20</td>
                    <td class="aspect-cell">R</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 20, Nilai 0:  Tidak disusun rencana pengendalian risiko pada tahap engineering dan operation."><input type="radio" name="indikator3_row41" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[18]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 20, Nilai 1:  Mulai diinisiasi dan disiapkan rencana pengendalian risiko pada tahap engineering dan operation"><input type="radio" name="indikator3_row41" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[18]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 20, Nilai 2:  Telah disusun garis besar rencana pengendalian risiko pada tahap engineering dan operation."><input type="radio" name="indikator3_row41" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[18]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 20, Nilai 3:  Sedang disusun rencana pengendalian risiko teknologi pada tahap engineering dan operation."><input type="radio" name="indikator3_row41" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[18]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 20, Nilai 4:  Selesai disusun rencana pengendalian risiko teknologi pada tahap engineering dan operation."><input type="radio" name="indikator3_row41" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[18]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 20, Nilai 5:  Rencana pengendalian risiko teknologi pada tahap engineering dan operation telah divalidasi."><input type="radio" name="indikator3_row41" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[18]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Kajian risiko teknologi menjadi dasar pengambilan keputusan teknis dalam tahap engineering & Operation.</td>
                  <td>
                        <select name="indikator3_dropdown20" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[19]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[19]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[19]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[19]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[19]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[19]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">21</td>
                    <td class="aspect-cell">R</td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 21, Nilai 0:  Tidak disusun rencana pengendalian risiko pada tahap penerapan teknologi."><input type="radio" name="indikator3_row42" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[19]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 21, Nilai 1:  Mulai diinisiasi dan disiapkan rencana pengendalian risiko pada tahap penerapan teknologi."><input type="radio" name="indikator3_row42" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[19]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 21, Nilai 2:  Telah disusun garis besar rencana pengendalian risiko pada tahap penerapan teknologi."><input type="radio" name="indikator3_row42" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[19]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 21, Nilai 3:  Sedang disusun rencana pengendalian risiko teknologi pada tahap penerapan teknologi."><input type="radio" name="indikator3_row42" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[19]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 21, Nilai 4:  Selesai disusun rencana pengendalian risiko teknologi pada tahap penerapan teknologi."><input type="radio" name="indikator3_row42" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[19]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Deskripsi untuk Indikator 3, Baris 21, Nilai 5:  Rencana pengendalian risiko teknologi pada tahap penerapan teknologi telah tervalidasi."><input type="radio" name="indikator3_row42" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[19]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Pada tahap penerapan teknologi dilakukan penyusunan rencana pengendalian risiko teknologi.</td>
                  <td>
                        <select name="indikator3_dropdown21" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorThree->isNotEmpty() && $indicatorThree[20]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorThree->isNotEmpty() && $indicatorThree[20]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorThree->isNotEmpty() && $indicatorThree[20]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorThree->isNotEmpty() && $indicatorThree[20]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorThree->isNotEmpty() && $indicatorThree[20]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorThree->isNotEmpty() && $indicatorThree[20]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="total-row">
                        <td colspan="2">Total Skor</td>
                        <td colspan="6" class="total-value">{{ $indicatorThree->sum('score')/ 2 }} </td>
                        <td colspan="1" style="text-align: left; padding-left: 10px;">
                            <a href="{{ route('admin.katsinov.lampiran.index', ['katsinov_id' => $katsinov['id'] ?? null]) }}" class="btn btn-sm" style="background-color: #277177; border-color: #277177; color: white;" target="_blank">
                                <i class='bx bx-paperclip'></i> Lampiran
                            </a>
                        </td>
                    </tr>
                <tr class="total-row">
                    <td colspan="2">Persentase</td>
                    <td colspan="6" class="total-value">({{ number_format(($indicatorThree->sum('score') / (21 * 10)) * 100, 2) }}%)</td>
                    <td colspan="1" class="status-cell">
                        {{ ($indicatorThree->sum('score') / (21 * 5)) * 100 >= 80 ? 'TERPENUHI' : 'TIDAK TERPENUHI' }}
                    </td>
                </tr>
            </table>
            <div class="katsinov-legend">
                Skala: 0=tidak terpenuhi; 1=20%; 2=40%; 3=60%; 4=80%; 5=100% atau terpenuhi
            </div>
            <div class="notes-section">
                <div class="notes-header">Catatan</div>
                <textarea 
                    name="notes[3]"
                    placeholder="Tambahkan catatan untuk Indikator 3 di sini..." 
                    class="notes-textarea form-control">{{ $notes[3] ?? '' }}</textarea>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('indikator.js') }}"></script>

