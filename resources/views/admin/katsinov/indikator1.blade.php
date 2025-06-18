<div class="container" data-indicator="1">
    <div class="card" data-aos="fade-up">
        <div class="main-title">
            Indikator KATSINOV 1
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
                    <th class="rating-columns">rating</th>
                    <td rowspan="24" class="katsinov-title">KATSINOV 1</td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">1</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Belum dilakukan validasi terhadap komponen individu dari teknologi."><input
                            type="radio" name="indikator1_row1" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 0) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Persiapan pelaksanaan validasi dan uji komponen individu dari teknologi secara terpisah.">
                        <input type="radio" name="indikator1_row1" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 1) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Mulai dilakukan validasi dan uji komponen individu dari teknologi secara terpisah di lingkungan laboratorium.">
                        <input type="radio" name="indikator1_row1" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 2) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Telah selesai dan lolos validasi dan uji komponen individu dari teknologi secara terpisah di lingkungan laboratorium.">
                        <input type="radio" name="indikator1_row1" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 3) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Mulai dilakukan validasi dan uji di lingkungan simulasi."><input
                            type="radio" name="indikator1_row1" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 4) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Telah selesai dan lolos validasi dan uji di lingkungan laboratorium dan simulasi.">
                        <input type="radio" name="indikator1_row1" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 5) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Ide baru yang memberi solusi permasalahan masyarakat.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown1" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[0]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[0]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[0]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[0]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[0]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[0]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">2</td>
                    <td class="aspect-cell">T</td>
                    <td
                        data-description="Belum dilakukan demonstrasi purnarupa (Prototype) a (alpha) pada lingkungan yang relevan.">
                        <input type="radio" name="indikator1_row2" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 0) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Persiapan untuk melaksanakan tahapan pembuatan purnarupa (Prototype) a (alpha).">
                        <input type="radio" name="indikator1_row2" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 1) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan pembuatan purnarupa (Prototype) a (alpha) dan diketahui kondisi lingkungan operasi sesungguhnya.><input type="radio"
                        name="indikator1_row2" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 2)
                        @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Telah diperoleh purnarupa (Prototype) a (alpha), diketahui kondisi lingkungan operasi, serta keberhasilan modeling & simulasi untuk kinerja sistem.">
                        <input type="radio" name="indikator1_row2" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 3) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Telah dilakukan pengujian Prototype) a (alpha) pada kondisi lingkungan operasi sesungguhnya.">
                        <input type="radio" name="indikator1_row2" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 4) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Telah dilakukan pengujian Prototype) a (alpha) dengan diketahui: kondisi lingkungan, kebutuhan investasi, proses fabrikasi, keberhasilan modeling & simulasi, serta hasil uji layak secara teknis (engineering feasibility).">
                        <input type="radio" name="indikator1_row2" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 5) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah dilakukan pengamatan prinsip-prinsip ilmiah dasar dan publikasi
                        ilmiah.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown2" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[1]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[1]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[1]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[1]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[1]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[1]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">3</td>
                    <td class="aspect-cell">T</td>

                    <td data-description="Teknologi belum layak secara teknis."><input type="radio"
                            name="indikator1_row3" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Tahap persiapan pembuatan purnarupa (Prototype) a (alpha) untuk pengujian teknis.">
                        <input type="radio" name="indikator1_row3" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Purnarupa (prototype) a (alpha) diperoleh."><input type="radio"
                            name="indikator1_row3" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Purnarupa (Prototype) a (alpha) telah diperoleh dan pengujian awal dilakukan ">
                        <input type="radio" name="indikator1_row3" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Purnarupa (Prototype) a (alpha) telah diperoleh dan dilakukan iterasi pengujian. @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Teknologi
                        dinyatakan layak secara teknis (engineering feasibility) melalui serangkaian pengujian."><input
                            type="radio" name="indikator1_row3" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>

                    <td class="description-cell">Faktor yang membedakan temuan dengan temuan lain dan unsur kebaruan
                        dari sebuah ide atau gagasan telah diidentifikasi.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown3" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[2]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[2]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[2]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[2]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[2]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[2]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">4</td>
                    <td class="aspect-cell">T</td>
                    <td data-description="Belum dilakukan pendaftaran kekayaan intelektual."><input type="radio"
                            name="indikator1_row4" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahap mempelajari persyaratan pendaftaran kekayaan intelektual."><input
                            type="radio" name="indikator1_row4" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahap mempersiapkan persyaratan pendaftaran kekayaan intelektual."><input
                            type="radio" name="indikator1_row4" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahap melengkapi persyaratan pendaftaran kekayaan intelektual"><input
                            type="radio" name="indikator1_row4" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahap pendaftaran kekayaan intelektual"><input type="radio"
                            name="indikator1_row4" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah terdaftar dan telah menerima bukti pembayaran biaya permohonan."><input
                            type="radio" name="indikator1_row4" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Mengidentifikasi tahapan riset dan targetnya.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown4" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[3]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[3]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[3]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[3]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[3]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[3]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">5</td>
                    <td class="aspect-cell">T</td>
                    <td
                        data-description="Secara teknis belum memberikan solusi terhadap permasalahan yang dihadapi masyarakat.">
                        <input type="radio" name="indikator1_row5" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Tahap identifikasi kebutuhan solusi terhadap permasalahan yang dihadapi masyarakat.">
                        <input type="radio" name="indikator1_row5" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Sistem yang diajukan cukup praktis karena teknologi yang tersedia cukup untuk diaplikasikan.">
                        <input type="radio" name="indikator1_row5" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Hanya syarat 1 dan 2 yang telah terpenuhi."><input type="radio"
                            name="indikator1_row5" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Hanya syarat 1, 2, dan 3 yang telah terpenuhi."><input type="radio"
                            name="indikator1_row5" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Keempat Syarat Kelayakan Teknis telah terpenuhi."><input type="radio"
                            name="indikator1_row5" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Teknologi yang akan dikembangkan telah layak secara ilmiah (scientific
                        feasibility).</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown5" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[4]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[4]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[4]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[4]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[4]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[4]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">6</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Tidak ada identifikasi terhadap pelanggan akhir yang ingin disasar."><input
                            type="radio" name="indikator1_row6" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dimulai proses identifikasi pelanggan akhir."><input type="radio"
                            name="indikator1_row6" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Proses awal identifikasi pelangan akhir telah dilakukan."><input
                            type="radio" name="indikator1_row6" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Proses identifikasi pelanggan akhir telah selesai."><input type="radio"
                            name="indikator1_row6" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Profil pelanggan akhir telah dianalisis."><input type="radio"
                            name="indikator1_row6" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Rincian profil calon pelanggan akhir diuraikan secara lengkap."><input
                            type="radio" name="indikator1_row6" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Inovasi dilakukan berdasarkan permintaan dan/atau kebutuhan pelanggan.
                    </td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown6" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[5]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[5]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[5]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[5]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[5]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[5]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">7</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Tidak memiliki rencana peluncuran produk ke pasar (business plan)."><input
                            type="radio" name="indikator1_row7" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Memiliki ide/gagasan tentang rencana peluncuran produk ke pasar."><input
                            type="radio" name="indikator1_row7" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Garis besar materi rencana strategi peluncuran produk ke pasar telah disusun.">
                        <input type="radio" name="indikator1_row7" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Dokumen strategi peluncuran produk ke pasar sedang disusun."><input
                            type="radio" name="indikator1_row7" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Tahap analisi dan finalisasi penyusunan dokumen strategi peluncuran produk ke pasar.">
                        <input type="radio" name="indikator1_row7" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Dokumen strategi peluncuran produk (business plan) yang lengkap mencakup STP dan 4P telah selesai.">
                        <input type="radio" name="indikator1_row7" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Permintaan dan kebutuhan pelanggan telah diidentifikasi.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown7" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[6]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[6]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[6]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[6]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[6]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[6]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">8</td>
                    <td class="aspect-cell">M</td>
                    <td data-description="Tidak ada informasi terkait modal intelektual."><input type="radio"
                            name="indikator1_row8" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Ada ide/gagagsan untuk menyiapkan modal intelektual."><input type="radio"
                            name="indikator1_row8" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Mulai disiapkan penyusunan rincian modal intelektual."><input
                            type="radio" name="indikator1_row8" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahap finalisasi penyusunan rincian modal intelektual"><input type="radio"
                            name="indikator1_row8" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Rincian modal intelektual telah disiapkan dan diuraikan tidak secara lengkap.">
                        <input type="radio" name="indikator1_row8" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Rincian modal intelektual telah disiapkan dan diuraikan secara lengkap.">
                        <input type="radio" name="indikator1_row8" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah mengidentifikasikan lokasi pasar yang akan dituju.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown8" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[7]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[7]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[7]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[7]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[7]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[7]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">9</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Belum disusun analisis dan rencana bisnis."><input type="radio"
                            name="indikator1_row9" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Persiapan penyusunan rencana bisnis."><input type="radio"
                            name="indikator1_row9" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Mulai penyusunan awal rencana bisnis."><input type="radio"
                            name="indikator1_row9" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahap penyelesaian analisis bisnis."><input type="radio"
                            name="indikator1_row9" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah diselesaikan analisis bisnis, dan tahap penyelesaian rencana bisnis">
                        <input type="radio" name="indikator1_row9" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dikeluarkan analisis dan rencana bisnis."><input type="radio"
                            name="indikator1_row9" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah memiliki strategi inovasi.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown9" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[8]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[8]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[8]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[8]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[8]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[8]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">10</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Tidak memiliki dan melibatkan individu-individu kunci."><input
                            type="radio" name="indikator1_row10" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Memiliki beberapa individu kunci yang memiliki keahlian unik, tetapi tidak dilibatkan secara aktif.">
                        <input type="radio" name="indikator1_row10" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Memiliki beberapa individu kunci dengan keahlian uniknya, tetapi kurang diberikan tanggung jawab pada posisi strategis.">
                        <input type="radio" name="indikator1_row10" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Memiliki beberapa individu kunci dengan keahlian uniknya dan diberikan tanggung jawab pada posisi yang strategis.">
                        <input type="radio" name="indikator1_row10" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Memiliki individu-individu kunci dengan keahlian uniknya yang sulit digantikan (berkaitan dengan jumlah), tetapi belum secara optimal diberikan tanggung jawab pada posisi yang strategis.">
                        <input type="radio" name="indikator1_row10" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Memiliki individu-individu kunci dengani keahlian uniknya yang sulit digantikan (berkaitan dengan jumlah) dan diberikan tanggung jawab pada posisi yang strategis.">
                        <input type="radio" name="indikator1_row10" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Lingkup proyek dan tugas telah diidentifikasi.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown10" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[9]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[9]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[9]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[9]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[9]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[9]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">11</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Belum ada persyaratan proyek dan daftar mitra proyek."><input
                            type="radio" name="indikator1_row11" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Dalam proses identifikasi persyaratan proyek dan daftar mitra proyek."><input type="radio"
                            name="indikator1_row11" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sudah ada persyaratan proyek, tetapi belum ada mitra, atau sebaliknya."><input
                            type="radio" name="indikator1_row11" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sudah ada persyaratan proyek dan daftar mitra proyek, tetapi belum disetujui."><input type="radio"
                            name="indikator1_row11" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sudah ada persyaratan proyek dan daftar mitra proyek, dan dalam proses persetujuan."><input
                            type="radio" name="indikator1_row11" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sudah ada persyaratan proyek dan daftar mitra proyek yang telah disetujui.">
                        <input type="radio" name="indikator1_row11" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Kebutuhan akan sumber daya, dana dan fasilitas penelitian telah
                        dikonfirmasi.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown11" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[10]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[10]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[10]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[10]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[10]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[10]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">12</td>
                    <td class="aspect-cell">O</td>
                    <td data-description="Belum ada tanggung jawab dan persetujuan batas waktu proyek."><input type="radio"
                            name="indikator1_row12" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Dalam proses identifikasi beban dan tanggung jawab dalam pelaksanaan proyek, dan proses penyusunan jadwal."><input type="radio"
                            name="indikator1_row12" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sudah ada tanggungjawab proyek, tetapi belum ada batas waktu proyek, atau sebaliknya."><input
                            type="radio" name="indikator1_row12" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sudah ada tanggung jawab dan persetujuan batas waktu proyek, tetapi belum disetujui."><input type="radio"
                            name="indikator1_row12" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sudah ada penanggungjawab dan batas waktu proyek, dan dalam proses persetujuan."><input
                            type="radio" name="indikator1_row12" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah tersedia penanggungjawab dan batas waktu proyek yang disetujui.
">
                        <input type="radio" name="indikator1_row12" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Tersedia saluran komunikasi tanpa hambatan.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown12" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[11]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[11]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[11]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[11]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[11]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[11]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-mf">
                    <td class="row-number">13</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Belum diidentifikasi teknologi dan komponen kritikal."><input
                            type="radio" name="indikator1_row13" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Persiapan identifikasi teknologi dan komponen kritikal."><input
                            type="radio" name="indikator1_row13" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Mulai dilakukan identifikasi awal teknologi & komponen kritikal dengan capaian 40%."><input
                            type="radio" name="indikator1_row13" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Identifikasi teknologi dan komponen kritikal dalam penyelesaian dengan capaian 60%."><input
                            type="radio" name="indikator1_row13" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Identifikasi teknologi dan komponen kritikal dalam penyelesaian dengan capaian 80%."><input
                            type="radio" name="indikator1_row13" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah secara komplit (capaian 100%) diidentifikasi teknologi dan komponen kritikal."><input
                            type="radio" name="indikator1_row13" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Konsekuensi hasil temuan telah diidentifikasi melalui dasar manufaktur
                        ekonomis.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown13" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[12]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[12]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[12]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[12]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[12]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[12]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-mf">
                    <td class="row-number">14</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Belum dapat diperlihatkan kesiapan sub system/system dalam suatu lingkungan produksi yang relevan."><input type="radio"
                            name="indikator1_row14" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahap persiapan awal membangun kesiapan sub system/system dalam suatu lingkungan produksi yang relevan"><input type="radio"
                            name="indikator1_row14" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah diperlihatkan kesiapan sub system/system dalam suatu lingkungan produksi yang relevan yang mencakup kesiapan material."><input type="radio"
                            name="indikator1_row14" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah diperlihatkan kesiapan sub system/system dalam suatu lingkungan produksi yang relevan yang mencakup kesiapan material dan perkakas "><input
                            type="radio" name="indikator1_row14" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah diperlihatkan kesiapan sub system/system dalam suatu lingkungan produksi yang relevan yang mencakup kesiapan material, perkakas dan alat uji prototype."><input
                            type="radio" name="indikator1_row14" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah diperlihatkan kesiapan sub system/system dalam suatu lingkungan produksi yang relevan yang mencakup kesiapan material, perkakas, alat uji prototype, dan keahlian personel."><input
                            type="radio" name="indikator1_row14" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Teridentifikasi dalam konsep manufaktur secara teknis dan ekonomis.
                    </td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown14" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[13]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[13]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[13]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[13]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[13]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[13]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-mf">
                    <td class="row-number">15</td>
                    <td class="aspect-cell">Mf</td>
                    <td data-description="Tidak ada bukti bahwa solusi yang ditawarkan kepada pelanggan memunculkan daya tarik yang menguntungkan di pasar."><input type="radio"
                            name="indikator1_row15" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Memiliki keunggulan nilai jual namun belum melakukan survey pasar."><input type="radio"
                            name="indikator1_row15" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Keunggulan nilai jual (value proposition) sedang di uji terap melalui survey pasar."><input type="radio"
                            name="indikator1_row15" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Memiliki keunggulan nilai jual dibanding dengan kompetitor untuk pasar yang terbatas."><input type="radio"
                            name="indikator1_row15" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Keunggulan nilai jual (value proposition) sedang diverifikasi dan divalidasi melalui uji terap untuk pasar yang lebih luas."><input type="radio"
                            name="indikator1_row15" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Memiliki keunggulan dibanding kompetitor dan teruji dalam survey pasar yang lebih luas."><input
                            type="radio" name="indikator1_row15" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Tersedia bukti konsep manufaktur melalui analitik atau eksperimen
                        laboratorium.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown15" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[14]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[14]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[14]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[14]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[14]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[14]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-i">
                    <td class="row-number">16</td>
                    <td class="aspect-cell">I</td>
                    
                    <td data-description="Tidak ada bukti bahwa solusi yang ditawarkan kepada pelanggan memunculkan daya tarik yang menguntungkan di pasar."><input type="radio"
                            name="indikator1_row16" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Ide yang dikembangkan menjadi prototype sesuai dengan kebutuhan pelanggan."><input type="radio"
                            name="indikator1_row16" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Prototype yang dikembangkan memiliki nilai lebih dibanding kompetitor."><input
                            type="radio" name="indikator1_row16" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Prototype yang dikembangkan dilakukan uji pasar"><input
                            type="radio" name="indikator1_row16" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Dilakukan proyeksi keuntungan terhadap prototype yang dikembangkan."><input
                            type="radio" name="indikator1_row16" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Diperoleh proyeksi keuntungan dari prototype yang dikembangkan."><input type="radio"
                            name="indikator1_row16" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    
                    <td class="description-cell">Ide yang dikembangkan memiliki konsep model bisnis.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown16" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[15]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[15]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[15]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[15]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[15]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[15]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-i">
                    <td class="row-number">17</td>
                    <td class="aspect-cell">I</td>

                    <td data-description="Tidak ada bukti dilakukannya: validasi value proposition, channel, segmen pelanggan, model hubungan dengan pelanggan yang ada, dan aliran revenue."><input
                            type="radio" name="indikator1_row17" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah ditetapkan MPV dan segmen pelanggan."><input type="radio"
                            name="indikator1_row17" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah ditetapkan channel dan model hubungan dengan pelanggan yang ada."><input type="radio"
                            name="indikator1_row17" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dihasilkan analisis aliran revenue."><input type="radio"
                            name="indikator1_row17" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan validasi antara MPV, segmen pelanggan, channel, hubungan dengan pelanggan yang ada dan aliran revenue."><input
                            type="radio" name="indikator1_row17" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Bukti-bukti yang ada saling berkaitan dalam menentukan aliran revenue."><input
                            type="radio" name="indikator1_row17" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>

                    <td class="description-cell">Ide yang dikembangkan memiliki hasil analisis pelanggan, pasar, dan
                        pesaing.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown17" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[16]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[16]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[16]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[16]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[16]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[16]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-p">
                    <td class="row-number">18</td>
                    <td class="aspect-cell">I</td>
                    <td data-description="Belum dilakukan penggalian informasi dan seleksi mitra."><input type="radio"
                            name="indikator1_row18" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Dilakukan penggalian informasi mitra."><input type="radio"
                            name="indikator1_row18" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Diperoleh database mitra, dan penyusunan kriteria untuk seleksi mitra."><input
                            type="radio" name="indikator1_row18" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Diperoleh database mitra dan kriteria untuk seleksi mitra."><input
                            type="radio" name="indikator1_row18" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Diperoleh database mitra dan kriteria seleksi mitra, serta mulai dilakukan seleksi mitra.">
                        <input type="radio" name="indikator1_row18" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan penggalian informasi dan seleksi mitra, dan telah diperoleh database mitra, kriteria seleksi mitra dan calon mitra potensial hasil seleksi.">
                        <input type="radio" name="indikator1_row18" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Ide yang dikembangkan telah terbukti memberi solusi bagi pelanggan.
                    </td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown18" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[17]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[17]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[17]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[17]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[17]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[17]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-i">
                    <td class="row-number">19</td>
                    <td class="aspect-cell">P</td>
                    <td data-description="Belum terbangun pola kemitraan yang tepat."><input type="radio"
                            name="indikator1_row19" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Mengkaji konsep pola kemitraan."><input type="radio"
                            name="indikator1_row19" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah diperoleh konsep pola kemitraan yang lebih tepat."><input type="radio"
                            name="indikator1_row19" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Validasi konsep pola kemitraan yang lebih tepat."><input
                            type="radio" name="indikator1_row19" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Upaya pembangunan pola kemitraan berdasar konsep yang disusun."><input
                            type="radio" name="indikator1_row19" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dibangun pola kemitraan yang lebih tepat dalam pengembangan usaha untuk mencapai tujuan bisnis bersama.">
                        <input type="radio" name="indikator1_row19" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah tersusun strategi membangun jaringan kerja dan kemitraan.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown19" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[18]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[18]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[18]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[18]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[18]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[18]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">20</td>
                    <td class="aspect-cell">P</td>
                    <td data-description="Tidak ada kajian risiko teknologi dan tidak menjadi pertimbangan dalam setiap tahap pengembangan teknologi."><input type="radio"
                            name="indikator1_row20" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sedang disusun materi penelitian atau kajian risiko teknologi dalam setiap tahap pengembangan teknologi."><input type="radio"
                            name="indikator1_row20" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Kajian risiko teknologi pada setiap tahap pengembangan teknologi telah selesai (belum menjadi pertimbangan)."><input type="radio"
                            name="indikator1_row20" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Kajian risiko telah menjadi pertimbangan dalam beberapa tahap pengembangan teknologi."><input type="radio"
                            name="indikator1_row20" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Kajian risiko telah menjadi pertimbangan dalam hampir setiap tahap pengembangan teknologi."><input
                            type="radio" name="indikator1_row20" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Kajian risiko telah menjadi pertimbangan dalam setiap tahap pengembangan teknologi."><input
                            type="radio" name="indikator1_row20" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Mitra potensial telah diidentifikasi.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown20" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[19]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[19]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[19]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[19]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[19]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[19]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">21</td>
                    <td class="aspect-cell">R</td>
                    <td data-description="Tidak disusun rencana pengendalian risiko teknologi pada tahap pengembangan teknologi."><input type="radio"
                            name="indikator1_row21" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Memiki ide/gagasan pengendalian risiko teknologi pada tahap pengembangan teknologi."><input type="radio"
                            name="indikator1_row21" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Garis besar materi rencana pengendalian risiko teknologi pada tahap tahap pengembangan teknologi telah disusun."><input type="radio"
                            name="indikator1_row21" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Mulai menyusun rencana pengendalian risiko teknologi pada tahap pengembangan teknologi."><input type="radio"
                            name="indikator1_row21" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahap penyelesaian penyusunan rencana pengendalian risiko teknologi pada tahap pengembangan teknologi."><input
                            type="radio" name="indikator1_row21" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tersusun rencana pengendalian risiko teknologi pada tahap tahap pengembangan teknologi."><input
                            type="radio" name="indikator1_row21" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Kajian risiko teknologi telah menjadi pertimbangan dalam setiap
                        langkah penelitian.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown21" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[20]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[20]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[20]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[20]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[20]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[20]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">22</td>
                    <td class="aspect-cell">R</td>
                    <td data-description="Tidak ada rencana pengendalian risiko. Skor: 0 (0%)"><input type="radio"
                            name="indikator1_row22" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[21]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Identifikasi awal untuk rencana pengendalian. Skor: 1 (20%)"><input
                            type="radio" name="indikator1_row22" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[21]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Draft rencana pengendalian risiko dibuat. Skor: 2 (40%)"><input
                            type="radio" name="indikator1_row22" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[21]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Rencana pengendalian risiko telah disusun. Skor: 3 (60%)"><input
                            type="radio" name="indikator1_row22" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[21]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Rencana pengendalian risiko telah diimplementasikan. Skor: 4 (80%)"><input
                            type="radio" name="indikator1_row22" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[21]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Rencana pengendalian risiko dievaluasi secara berkala. Skor: 5 (100%)"><input
                            type="radio" name="indikator1_row22" class="radio-input" value="5"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[21]->score == 5)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Pada tahap penelitian dilakukan penyusunan rencana pengendalian risiko
                        teknologi.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown22" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[21]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorOne->isNotEmpty() && $indicatorOne[21]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorOne->isNotEmpty() && $indicatorOne[21]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorOne->isNotEmpty() && $indicatorOne[21]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorOne->isNotEmpty() && $indicatorOne[21]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorOne->isNotEmpty() && $indicatorOne[21]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="total-row">
                    <td colspan="2">Total Skor</td>
                    <td colspan="6" class="total-value">{{ $indicatorOne->sum('score') / 2 }} </td>
                    <td colspan="1" style="text-align: left; padding-left: 10px;">
                        <a href="{{ route('admin.katsinov.lampiran.index', ['katsinov_id' => $katsinov['id'] ?? null]) }}"
                            class="btn btn-sm" style="background-color: #277177; border-color: #277177; color: white;"
                            target="_blank">
                            <i class='bx bx-paperclip'></i> Lampiran
                        </a>
                    </td>
                </tr>
                <tr class="total-row">
                    <td colspan="2">Persentase</td>
                    <td colspan="6" class="total-value">
                        ({{ number_format(($indicatorOne->sum('score') / (22 * 5)) * 100, 2) }}%)</td>
                    <td colspan="1" class="status-cell">
                        {{ ($indicatorOne->sum('score') / (22 * 5)) * 100 >= 80 ? 'TERPENUHI' : 'TIDAK TERPENUHI' }}
                    </td>
                </tr>
            </table>
            <div class="katsinov-legend">
                Skala: 0=tidak terpenuhi; 1=20%; 2=40%; 3=60%; 4=80%; 5=100% atau terpenuhi
            </div>
            <div class="notes-section">
                <div class="notes-header">Catatan</div>
                <textarea name="notes[1]" placeholder="Tambahkan catatan untuk Indikator 1 di sini..."
                    class="notes-textarea form-control">{{ $notes[1] ?? '' }}</textarea>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('indikator.js') }}"></script>

```
