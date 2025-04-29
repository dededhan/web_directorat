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
                    <td><input type="radio" name="indikator6_row1" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[0]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row1" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[0]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row1" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[0]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row1" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[0]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row1" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[0]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row1" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[0]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator6_row2" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[1]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row2" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[1]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row2" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[1]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row2" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[1]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row2" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[1]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row2" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[1]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator6_row3" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[2]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row3" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[2]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row3" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[2]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row3" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[2]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row3" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[2]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row3" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[2]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator6_row4" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[3]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row4" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[3]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row4" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[3]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row4" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[3]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row4" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[3]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row4" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[3]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator6_row5" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[4]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row5" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[4]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row5" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[4]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row5" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[4]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row5" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[4]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row5" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[4]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator6_row6" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[5]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row6" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[5]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row6" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[5]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row6" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[5]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row6" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[5]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row6" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[5]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator6_row7" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[6]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row7" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[6]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row7" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[6]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row7" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[6]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row7" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[6]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row7" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[6]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator6_row8" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[7]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row8" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[7]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row8" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[7]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row8" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[7]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row8" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[7]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row8" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[7]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator6_row9" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[8]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row9" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[8]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row9" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[8]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row9" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[8]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row9" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[8]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row9" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[8]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator6_row10" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[9]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row10" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[9]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row10" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[9]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row10" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[9]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row10" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[9]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row10" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[9]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator6_row11" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[10]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row11" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[10]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row11" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[10]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row11" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[10]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row11" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[10]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row11" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[10]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator6_row12" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[11]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row12" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[11]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row12" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[11]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row12" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[11]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row12" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[11]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row12" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[11]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator6_row13" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[12]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row13" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[12]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row13" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[12]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row13" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[12]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row13" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[12]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row13" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[12]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator6_row14" class="radio-input" value="0" @checked($indicatorSix->isNotEmpty() && $indicatorSix[13]->score == 0)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row14" class="radio-input" value="1" @checked($indicatorSix->isNotEmpty() && $indicatorSix[13]->score == 1)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row14" class="radio-input" value="2" @checked($indicatorSix->isNotEmpty() && $indicatorSix[13]->score == 2)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row14" class="radio-input" value="3" @checked($indicatorSix->isNotEmpty() && $indicatorSix[13]->score == 3)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row14" class="radio-input" value="4" @checked($indicatorSix->isNotEmpty() && $indicatorSix[13]->score == 4)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator6_row14" class="radio-input" value="5" @checked($indicatorSix->isNotEmpty() && $indicatorSix[13]->score == 5)@if(request()->routeIs('admin.katsinov.show')) disabled @endif></td>
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
                    placeholder="Tambahkan catatan di sini..." 
                    class="notes-textarea">
                </textarea>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('indikator.js') }}"></script>

