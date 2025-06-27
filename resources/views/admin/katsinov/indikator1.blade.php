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
                    <td data-description="Tidak ditemui ide baru yang memberi solusi."><input
                            type="radio" name="indikator1_row1" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 0) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Ide baru bersifat Inkremental, belum menawarkan solusi.">
                        <input type="radio" name="indikator1_row1" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 1) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Ide bersifat Inkremental dan menawarkan solusi.">
                        <input type="radio" name="indikator1_row1" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 2) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Ide bersifat Distinctive dan belum menawarkan solusi.">
                        <input type="radio" name="indikator1_row1" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 3) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Ide bersifat Distinctive dan sudah menawarkan solusi yang tepat."><input
                            type="radio" name="indikator1_row1" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 4) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Ide bersifat terobosan dan mengubah, serta memberikan solusi yang tepat.">
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
                        data-description="Belum dilakukan pengamatan prinsip-prinsip ilmiah dasar dan publikasi ilmiah.">
                        <input type="radio" name="indikator1_row2" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 0) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Telah dilakukan pengamatan tetapi belum memiliki dukungan ilmiah yang kuat.">
                        <input type="radio" name="indikator1_row2" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 1) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan pengamatan yang memberikan dukungan ilmiah namun lemah bagi keberhasilan mewujudkan ide."><input type="radio"
                        name="indikator1_row2" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 2)
                        @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Telah dilakukan pengamatan yang memberikan dukungan ilmiah dan cukup kuat bagi keberhasilan mewujudkan ide.">
                        <input type="radio" name="indikator1_row2" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 3) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Telah dilakukan pengamatan sehingga memberikan dukungan ilmiah yang kuat bagi keberhasilan mewujudkan ide.">
                        <input type="radio" name="indikator1_row2" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 4) @if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Telah dilakukan pengamatan sehingga memberikan dukungan ilmiah yang sangat kuat bagi keberhasilan mewujudkan ide.">
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

                    <td data-description="Tidak memiliki unsur kebaruan dan daya beda dengan temuan lainnya."><input type="radio"
                            name="indikator1_row3" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Memiliki daya beda dengan temuan lain tetapi tidak memiliki unsur kebaruan.">
                        <input type="radio" name="indikator1_row3" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Memiliki kebaruan tetapi daya beda dengan temuan lain lemah."><input type="radio"
                            name="indikator1_row3" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Kebaruan bersifat inkremental (berkembang sedikit demi sedikit secara teratur) dan daya beda yang kuat.">
                        <input type="radio" name="indikator1_row3" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Kebaruan bersifat khas, dan daya beda yang kuat.">
                        <input type="radio" name="indikator1_row3" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Kebaruan bersifat lompatan dan daya beda yang kuat."><input
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
                    <td data-description="Belum dapat diidentifikasi tahapan riset dan targetnya."><input type="radio"
                            name="indikator1_row4" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahapan riset dan targetnya sudah mencapai tahap Perencanaan."><input
                            type="radio" name="indikator1_row4" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahapan riset dan targetnya sudah mencapai tahap Perencanaan dan Pelaksanaan."><input
                            type="radio" name="indikator1_row4" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahapan riset dan targetnya sudah mencapai tahap Perencanaan, Pelaksanaan dan Pelaporan Penelitian."><input
                            type="radio" name="indikator1_row4" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahapan riset dan targetnya: Sudah Memiliki Purnarupa (Prototype)."><input type="radio"
                            name="indikator1_row4" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Purnarupa (protype) sudah terbukti kebenaran dan keamanannya."><input
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
                        data-description="Belum dilakukan Pengujian.">
                        <input type="radio" name="indikator1_row5" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Dalam persiapan Pengujian.">
                        <input type="radio" name="indikator1_row5" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Telah dilakukan Pengujian Awal Teori.">
                        <input type="radio" name="indikator1_row5" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan Pengujian Awal Teori, secara Intensif, namun belum dapat disimpulkan."><input type="radio"
                            name="indikator1_row5" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan Pengujian Awal Teori, secara Intensif, hampir diperoleh kesimpulan."><input type="radio"
                            name="indikator1_row5" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan Pengujian Awal Teori, secara Intensif, sudah diperoleh kesimpulan."><input type="radio"
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
                    <td data-description="Produk Inovasi belum memperhatikan kebutuhan pasar."><input
                            type="radio" name="indikator1_row6" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Produk Inovasi sedikit memperhatikan kebutuhan pasar."><input type="radio"
                            name="indikator1_row6" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Produk Inovasi sudah berorientasi kebutuhan pasar."><input
                            type="radio" name="indikator1_row6" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Produk Inovasi sudah berorientasi kebutuhan pasar, namun belum ada riset pada pasar."><input type="radio"
                            name="indikator1_row6" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Produk Inovasi sudah berorientasi kebutuhan pasar, ada riset pasar, belum terjadi feedback dari pelanggan."><input type="radio"
                            name="indikator1_row6" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Produk Inovasi sudah berorientasi kebutuhan pasar, ada riset pasar, belum terjadi feedback dari pelanggan."><input
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
                    <td data-description="Tidak dilakukan riset pasar."><input
                            type="radio" name="indikator1_row7" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan riset pasar, tetapi belum teridentifikasi: keinginan, kebutuhan, permintaan pelanggan."><input
                            type="radio" name="indikator1_row7" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Telah dilakukan riset pasar, dan teridentifikasi: kebutuhan pelanggan.">
                        <input type="radio" name="indikator1_row7" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan riset pasar, dan teridentifikasi: keinginan pelanggan."><input
                            type="radio" name="indikator1_row7" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Telah dilakukan riset pasar, dan teridentifikasi: permintaan pelanggan.">
                        <input type="radio" name="indikator1_row7" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Telah dilakukan riset pasar, sudah teridentifikasi: keinginan, kebutuhan dan permintaan pelanggan.">
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
                    <td data-description="Belum dilakukan riset pasar."><input type="radio"
                            name="indikator1_row8" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Persiapan dan mulai dilakukan riset pasar."><input type="radio"
                            name="indikator1_row8" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan riset pasar dan teridentifikasi: Variabel Geografis."><input
                            type="radio" name="indikator1_row8" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan riset pasar dan teridentifikasi: Opsi lokasi pasar yang akan dituju."><input type="radio"
                            name="indikator1_row8" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Sedang dilakukan pengujian riset pasar pada opsi pasar yang dituju.">
                        <input type="radio" name="indikator1_row8" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sudah dilakukan riset pasar dan memilih lokasi pasar yang akan dituju.">
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
                    <td data-description="Belum memiliki strategi inovasi."><input type="radio"
                            name="indikator1_row9" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahap persiapan penyusunan strategi inovasi."><input type="radio"
                            name="indikator1_row9" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Dalam penyusunan strategi inovasi."><input type="radio"
                            name="indikator1_row9" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah menyusun strategi, namun belum diterapkan."><input type="radio"
                            name="indikator1_row9" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah menyusun strategi, dan telah menetapkan strategi inovasi.">
                        <input type="radio" name="indikator1_row9" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah menyusun strategi, dan telah menetapkan dan menjalankan strategi inovasi."><input type="radio"
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
                    <td data-description="Belum didefiniskan lingkup proyek dan tugas tim."><input
                            type="radio" name="indikator1_row10" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Tahap persiapan penyusunan lingkup proyek dan tugas tim.">
                        <input type="radio" name="indikator1_row10" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Tahap penyusunan lingkup proyek dan tugas tim.">
                        <input type="radio" name="indikator1_row10" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Penyusunan lingkup proyek dan tugas tim sudah selesai.">
                        <input type="radio" name="indikator1_row10" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Penyusunan lingkup proyek dan tugas tim sudah selesai dan masih dalam proses penetapan.">
                        <input type="radio" name="indikator1_row10" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td
                        data-description="Penyusunan lingkup proyek dan tugas tim sudah selesai dan sudah ditetapkan.">
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
                    <td data-description="Belum ada kepastian sumber daya (SDM & SDA) dan dana serta fasilitas penelitian yang dibutuhkan."><input
                            type="radio" name="indikator1_row11" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Hanya memiliki salah satu kepastian diantara: SDM, Laboratorium, Sumber Dana."><input type="radio"
                            name="indikator1_row11" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sudah memiliki dua kepastian diantara: SDM, Laboratorium, Sumber Dana."><input
                            type="radio" name="indikator1_row11" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sudah memiliki kepastian SDM, Laboratorium, Sumber Dana."><input type="radio"
                            name="indikator1_row11" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sudah memiliki kepastian SDM, Laboratorium, Sumber Dana, tetapi masih membutuhkan dukungan layanan lainnya."><input
                            type="radio" name="indikator1_row11" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sudah memiliki kepastian SDM, Laboratorium, Sumber Dana dan dukungan layanan lainnya.">
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
                    <td data-description="Tidak ada akses komunikasi Digital."><input type="radio"
                            name="indikator1_row12" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Hanya ada saluran Telepon."><input type="radio"
                            name="indikator1_row12" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Hanya ada saluran telepon dan perpustakaan."><input
                            type="radio" name="indikator1_row12" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Ada saluran Telepon dan salah satu diantara: Jaringan Internet atau Perpustakaan."><input type="radio"
                            name="indikator1_row12" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Ada saluran Telepon dan Perpustakaan serta jaringan internet."><input
                            type="radio" name="indikator1_row12" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Ada saluran Telepon, Jaringan Internet, Perpustakaan dan E-Library.">
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
                    <td data-description="Belum teridentifikasi implikasi dasar manufaktur."><input
                            type="radio" name="indikator1_row13" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Persiapan pelaksanaan identifikasi awal implikasi dasar manufaktur."><input
                            type="radio" name="indikator1_row13" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan identifikasi awal implikasi dasar manufaktur."><input
                            type="radio" name="indikator1_row13" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah teridentifikasi implikasi dasar manufaktur secara teknis."><input
                            type="radio" name="indikator1_row13" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah teridentifikasi implikasi dasar manufaktur secara teknis dan dalam proses identifikasi dasar manufaktur secara ekonomis."><input
                            type="radio" name="indikator1_row13" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Teridentifikasi implikasi (konsekuensi atau akibat langsung dari hasil penemuan suatu penelitian ilmiah) dasar manufaktur."><input
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
                    <td data-description="Belum teridentifikasi konsep manufaktur."><input type="radio"
                            name="indikator1_row14" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Persiapan pelaksanaan identifikasi konsep manufaktur."><input type="radio"
                            name="indikator1_row14" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan identifikasi awal konsep manufaktur."><input type="radio"
                            name="indikator1_row14" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah teridentifikasi konsep manufaktur dalam pengertian proses manufaktur secara teknis."><input
                            type="radio" name="indikator1_row14" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Proses penyelesaian konsep manufaktur dalam pengertian proses manufaktur secara ekonomis."><input
                            type="radio" name="indikator1_row14" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah teridentifikasi konsep manufaktur: Proses manufaktur secara teknis dan ekonomis."><input
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
                    <td data-description="Belum dilakukan validasi konsep manufaktur melalui analitik atau eksperimen laboratorium."><input type="radio"
                            name="indikator1_row15" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahap persiapan validasi konsep manufaktur melalui analitik atau eksperimen laboratorium."><input type="radio"
                            name="indikator1_row15" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan validasi awal konsep manufaktur melalui analitik atau eksperimen laboratorium, dengan capaian 40%."><input type="radio"
                            name="indikator1_row15" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan validasi konsep manufaktur melalui analitik atau eksperimen laboratorium dengan capaian 60%."><input type="radio"
                            name="indikator1_row15" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah dilakukan validasi konsep manufaktur melalui analitik atau eksperimen laboratorium dengan capaian 80%."><input type="radio"
                            name="indikator1_row15" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah diselesaikan validasi konsep manufaktur melalui analitik atau eksperimen laboratorium, dan telah diperoleh bukti konsep manufaktur."><input
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
                    
                    <td data-description="Tidak punya konsep model bisnis untuk ide yang dikembangkan."><input type="radio"
                            name="indikator1_row16" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Persiapan dan mulai menyusun konsep model bisnis berdasarkan ide yang dikembangkan."><input type="radio"
                            name="indikator1_row16" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sedang menyusun konsep model bisnis untuk ide yang dikembangkan."><input
                            type="radio" name="indikator1_row16" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Konsep model bisnis untuk ide yang dikembangkan belum lengkap dan jelas."><input
                            type="radio" name="indikator1_row16" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Konsep model bisnis untuk ide yang dikembangkan cukup lengkap dan jelas."><input
                            type="radio" name="indikator1_row16" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Konsep model bisnis untuk ide yang dikembangkan lengkap dan jelas."><input type="radio"
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

                    <td data-description="Tidak ada analisis pelanggan, pasar dan pesaing dari ide yang dikembangkan."><input
                            type="radio" name="indikator1_row17" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sedang mulai menyusun analisis pelanggan, pasar dan pesaing terhadap ide yang dikembangkan."><input type="radio"
                            name="indikator1_row17" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Hanya ada hasil analisis pesaing dari ide yang dikembangkan."><input type="radio"
                            name="indikator1_row17" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Hanya Ada hasil analisis pelanggan dari ide yang dikembangkan."><input type="radio"
                            name="indikator1_row17" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Hanya Ada hasil analisis pelanggan dan pesaing dari ide yang dikembangkan."><input
                            type="radio" name="indikator1_row17" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Ada hasil analisis pelanggan, pasar dan pesaing dari ide yang dikembangkan."><input
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
                    <td data-description="Tidak ada bukti bahwa ide yang dikembangkan telah memberikan solusi bagi pelanggan."><input type="radio"
                            name="indikator1_row18" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Mulai dilakukan percobaan dan percontohan terhadap ide yang dikembangkan dapat memberi solusi bagi pelanggan."><input type="radio"
                            name="indikator1_row18" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Percobaan dan percontohan telah selesai (belum dianalisis berdasarkan kekuatan, kelemahan, peluang dan tantangan- SWOT analysis)."><input
                            type="radio" name="indikator1_row18" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Ada bukti yang Lemah bahwa ide yang dikembangkan telah memberikan solusi bagi pelanggan."><input
                            type="radio" name="indikator1_row18" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Ada bukti yang cukup kuat bahwa ide yang dikembangkan telah memberikan solusi bagi pelanggan.">
                        <input type="radio" name="indikator1_row18" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Ada bukti yang sangat kuat bahwa ide yang dikembangkan telah memberikan solusi bagi pelanggan.">
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
                    <td data-description="Belum ada strategi membangun jejaring kerja dan kemitraan."><input type="radio"
                            name="indikator1_row19" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahap persiapan penyusunan strategi membangun jejaring kerja dan kemitraan."><input type="radio"
                            name="indikator1_row19" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Identifikasi kekuatan, kelemahan, peluang dan ancaman dalam membangun jejaring kerja dan kemitraan."><input type="radio"
                            name="indikator1_row19" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Analisis SWOT."><input
                            type="radio" name="indikator1_row19" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Analisis faktor internal dan eksternal untuk menurunkan strategi."><input
                            type="radio" name="indikator1_row19" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah diperoleh strategi membangun jejaring kerja dan kemitraan.">
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
                    <td data-description="Belum diidentifikasi mitra potensial."><input type="radio"
                            name="indikator1_row20" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="SeTahap persiapan identifikasi mitra potensial."><input type="radio"
                            name="indikator1_row20" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Identifikasi awal terkait relevansi mitra dengan program pengembangan yang dilakukan."><input type="radio"
                            name="indikator1_row20" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Identifikasi lanjutan, mencakup: relevansi mitra dengan program pengembangan yang dilakukan, serta peta peran dan kontribusi mitra."><input type="radio"
                            name="indikator1_row20" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahap penyelesaian identifikasi, mencakup: relevansi mitra dengan program pengembangan yang dilakukan, peta peran dan kontribusi mitra, serta upaya memaksimalkan peran dan kontribusi mitra."><input
                            type="radio" name="indikator1_row20" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Telah tersedia hasil identifikasi mitra potensial, mencakup: relevansi mitra dengan program pengembangan yang dilakukan, peta peran dan kontribusi mitra, serta upaya memaksimalkan peran dan kontribusi mitra."><input
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
                    <td data-description="Tidak ada kajian risiko teknologi dan tidak menjadi pertimbangan dalam setiap langkah penelitian."><input type="radio"
                            name="indikator1_row21" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Sedang disusun materi penelitian atau kajian risiko teknologi."><input type="radio"
                            name="indikator1_row21" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Kajian risiko teknologi telah selesai (belum menjadi pertimbangan)."><input type="radio"
                            name="indikator1_row21" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Kajian risiko telah menjadi pertimbangan dalam beberapa langkah penelitian."><input type="radio"
                            name="indikator1_row21" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Kajian risiko telah menjadi pertimbangan dalam hampir setiap langkah penelitian."><input
                            type="radio" name="indikator1_row21" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Kajian risiko telah menjadi pertimbangan dalam setiap langkah penelitian."><input
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
                    <td data-description="Tidak disusun rencana pengendalian risiko teknologi pada tahap penelitian."><input type="radio"
                            name="indikator1_row22" class="radio-input" value="0"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[21]->score == 0)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Memiki ide/gagasan pengendalian risiko teknologi pada tahap penelitian."><input
                            type="radio" name="indikator1_row22" class="radio-input" value="1"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[21]->score == 1)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Garis besar materi rencana pengendalian risiko teknologi pada tahap penelitian telah disusun."><input
                            type="radio" name="indikator1_row22" class="radio-input" value="2"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[21]->score == 2)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Mulai menyusun rencana pengendalian risiko teknologi pada tahap penelitian."><input
                            type="radio" name="indikator1_row22" class="radio-input" value="3"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[21]->score == 3)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tahap penyelesaian penyusunan rencana pengendalian risiko teknologi pada tahap penelitian."><input
                            type="radio" name="indikator1_row22" class="radio-input" value="4"
                            @checked($indicatorOne->isNotEmpty() && $indicatorOne[21]->score == 4)@if (request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td data-description="Tersusun rencana pengendalian risiko teknologi pada tahap penelitian."><input
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
<script src="{{ asset('resources/movejs/indikator.js') }}"></script>

```
