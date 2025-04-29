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
                    <td><input type="radio" name="indikator5_row1" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[0]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row1" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[0]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row1" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[0]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row1" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[0]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row1" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[0]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row1" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[0]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row2" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[1]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row2" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[1]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row2" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[1]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row2" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[1]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row2" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[1]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row2" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[1]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row3" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[2]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row3" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[2]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row3" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[2]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row3" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[2]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row3" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[2]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row3" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[2]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row4" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[3]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row4" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[3]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row4" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[3]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row4" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[3]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row4" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[3]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row4" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[3]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row5" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[4]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row5" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[4]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row5" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[4]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row5" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[4]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row5" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[4]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row5" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[4]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row6" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[5]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row6" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[5]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row6" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[5]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row6" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[5]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row6" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[5]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row6" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[5]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row7" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[6]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row7" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[6]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row7" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[6]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row7" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[6]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row7" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[6]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row7" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[6]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row8" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[7]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row8" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[7]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row8" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[7]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row8" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[7]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row8" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[7]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row8" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[7]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row9" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[8]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row9" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[8]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row9" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[8]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row9" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[8]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row9" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[8]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row9" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[8]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row10" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[9]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row10" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[9]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row10" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[9]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row10" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[9]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row10" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[9]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row10" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[9]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row11" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[10]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row11" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[10]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row11" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[10]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row11" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[10]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row11" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[10]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row11" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[10]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row12" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[11]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row12" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[11]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row12" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[11]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row12" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[11]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row12" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[11]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row12" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[11]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row13" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[12]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row13" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[12]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row13" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[12]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row13" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[12]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row13" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[12]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row13" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[12]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row14" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[13]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row14" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[13]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row14" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[13]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row14" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[13]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row14" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[13]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row14" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[13]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row15" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[14]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row15" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[14]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row15" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[14]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row15" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[14]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row15" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[14]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row15" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[14]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row16" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[15]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row16" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[15]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row16" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[15]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row16" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[15]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row16" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[15]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row16" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[15]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row17" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[16]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row17" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[16]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row17" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[16]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row17" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[16]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row17" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[16]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row17" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[16]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row18" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[17]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row18" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[17]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row18" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[17]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row18" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[17]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row18" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[17]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row18" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[17]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row19" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[18]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row19" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[18]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row19" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[18]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row19" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[18]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row19" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[18]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row19" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[18]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row20" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[19]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row20" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[19]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row20" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[19]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row20" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[19]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row20" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[19]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row20" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[19]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row21" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[20]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row21" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[20]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row21" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[20]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row21" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[20]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row21" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[20]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row21" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[20]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row22" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[21]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row22" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[21]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row22" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[21]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row22" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[21]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row22" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[21]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row22" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[21]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row23" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[22]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row23" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[22]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row23" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[22]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row23" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[22]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row23" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[22]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row23" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[22]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator5_row24" class="radio-input" value="0" @checked($indicatorFive->isNotEmpty() && $indicatorFive[23]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row24" class="radio-input" value="1" @checked($indicatorFive->isNotEmpty() && $indicatorFive[23]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row24" class="radio-input" value="2" @checked($indicatorFive->isNotEmpty() && $indicatorFive[23]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row24" class="radio-input" value="3" @checked($indicatorFive->isNotEmpty() && $indicatorFive[23]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row24" class="radio-input" value="4" @checked($indicatorFive->isNotEmpty() && $indicatorFive[23]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator5_row24" class="radio-input" value="5" @checked($indicatorFive->isNotEmpty() && $indicatorFive[23]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    placeholder="Tambahkan catatan di sini..." 
                    class="notes-textarea">
                </textarea>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('indikator.js') }}"></script>

