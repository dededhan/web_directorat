
<div class="container" data-indicator="2">
    <div class="card" data-aos="fade-up">
        <div class="main-title">
            Indikator KATSINOV 2
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
                    <td rowspan="24" class="katsinov-title">KATSINOV 2</td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">1</td>
                    <td class="aspect-cell">T</td>
                    <td><input type="radio" name="indikator2_row1" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[0]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row1" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[0]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row1" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[0]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row1" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[0]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row1" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[0]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row1" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[0]->score == 5)></td>
                    <td class="description-cell">Telah melakukan validasi terhadap komponen individu dari teknologi.</td>
                    <td>
                        <select name="indikator2_dropdown1" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[0]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[0]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[0]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[0]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[0]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[0]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">2</td>
                    <td class="aspect-cell">T</td>
                    <td><input type="radio" name="indikator2_row2" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[1]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row2" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[1]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row2" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[1]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row2" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[1]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row2" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[1]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row2" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[1]->score == 5)></td>
                    <td class="description-cell">Prototipe telah didemonstrasikan dalam lingkungan yang relevan.</td>
                    <td>
                        <select name="indikator2_dropdown2" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[1]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[1]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[1]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[1]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[1]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[1]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">3</td>
                    <td class="aspect-cell">T</td>
                    <td><input type="radio" name="indikator2_row3" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[2]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row3" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[2]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row3" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[2]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row3" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[2]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row3" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[2]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row3" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[2]->score == 5)></td>
                    <td class="description-cell">Teknologi dinyatakan layak secara teknis.</td>
                    <td>
                        <select name="indikator2_dropdown3" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[2]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[2]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[2]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[2]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[2]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[2]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">4</td>
                    <td class="aspect-cell">T</td>
                    <td><input type="radio" name="indikator2_row4" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[3]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row4" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[3]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row4" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[3]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row4" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[3]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row4" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[3]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row4" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[3]->score == 5)></td>
                    <td class="description-cell">Telah melakukan pendaftaran kekayaan intelektual (misal: paten, desain industri, hak cipta, merek, dll).</td>
                <td>
                        <select name="indikator2_dropdown4" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[3]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[3]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[3]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[3]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[3]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[3]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-t">
                    <td class="row-number">5</td>
                    <td class="aspect-cell">T</td>
                    <td><input type="radio" name="indikator2_row5" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[4]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row5" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[4]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row5" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[4]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row5" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[4]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row5" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[4]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row5" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[4]->score == 5)></td>
                    <td class="description-cell">Secara teknis mampu memberikan solusi terhadap permasalahan yang dihadapi masyarakat.</td>
                <td>
                        <select name="indikator2_dropdown5" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[4]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[4]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[4]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[4]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[4]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[4]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                
                <!-- Market Aspect Rows -->
                <tr class="row-m">
                    <td class="row-number">6</td>
                    <td class="aspect-cell">M</td>
                    <td><input type="radio" name="indikator2_row6" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[5]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row6" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[5]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row6" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[5]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row6" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[5]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row6" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[5]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row6" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[5]->score == 5)></td>
                    <td class="description-cell">Pelanggan akhir teridentifikasi.</td>
                <td>
                        <select name="indikator2_dropdown6" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[5]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[5]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[5]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[5]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[5]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[5]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">7</td>
                    <td class="aspect-cell">M</td>
                    <td><input type="radio" name="indikator2_row7" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[6]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row7" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[6]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row7" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[6]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row7" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[6]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row7" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[6]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row7" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[6]->score == 5)></td>
                    <td class="description-cell">Telah mengeluarkan rencana peluncuran produk baru ke pasar secara rinci.</td>
                <td>
                        <select name="indikator2_dropdown7" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[6]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[6]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[6]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[6]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[6]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[6]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-m">
                    <td class="row-number">8</td>
                    <td class="aspect-cell">M</td>
                    <td><input type="radio" name="indikator2_row8" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[7]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row8" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[7]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row8" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[7]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row8" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[7]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row8" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[7]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row8" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[7]->score == 5)></td>
                    <td class="description-cell">Telah memulai kesiapan modal intelektual (intellectual capital).</td>
                <td>
                        <select name="indikator2_dropdown8" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[7]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[7]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[7]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[7]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[7]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[7]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                
                <!-- Organization Aspect Rows -->
                <tr class="row-o">
                    <td class="row-number">9</td>
                    <td class="aspect-cell">O</td>
                    <td><input type="radio" name="indikator2_row9" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[8]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row9" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[8]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row9" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[8]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row9" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[8]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row9" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[8]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row9" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[8]->score == 5)></td>
                    <td class="description-cell">Analisis dan rencana bisnis telah dikeluarkan.</td>
                <td>
                        <select name="indikator2_dropdown9" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[8]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[8]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[8]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[8]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[8]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[8]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">10</td>
                    <td class="aspect-cell">O</td>
                    <td><input type="radio" name="indikator2_row10" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[9]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row10" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[9]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row10" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[9]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row10" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[9]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row10" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[9]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row10" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[9]->score == 5)></td>
                    <td class="description-cell">Telah memiliki keterlibatan dengan individu kunci.</td>
                <td>
                        <select name="indikator2_dropdown10" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[9]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[9]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[9]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[9]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[9]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[9]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">11</td>
                    <td class="aspect-cell">O</td>
                    <td><input type="radio" name="indikator2_row11" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[10]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row11" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[10]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row11" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[10]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row11" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[10]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row11" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[10]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row11" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[10]->score == 5)></td>
                    <td class="description-cell">Telah melakukan persetujuan persyaratan proyek dan daftar mitra proyek.</td>
                <td>
                        <select name="indikator2_dropdown11" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[10]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[10]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[10]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[10]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[10]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[10]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-o">
                    <td class="row-number">12</td>
                    <td class="aspect-cell">O</td>
                    <td><input type="radio" name="indikator2_row12" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[11]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row12" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[11]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row12" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[11]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row12" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[11]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row12" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[11]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row12" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[11]->score == 5)></td>
                    <td class="description-cell">Telah melakukan persetujuan tanggung jawab dan persetujuan batas waktu dalam pengelolaan suatu proyek.</td>
                <td>
                        <select name="indikator2_dropdown12" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[11]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[11]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[11]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[11]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[11]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[11]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                
                <!-- Manufacturing Aspect Rows -->
                <tr class="row-mf">
                    <td class="row-number">13</td>
                    <td class="aspect-cell">Mf</td>
                    <td><input type="radio" name="indikator2_row13" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[12]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row13" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[12]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row13" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[12]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row13" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[12]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row13" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[12]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row13" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[12]->score == 5)></td>
                    <td class="description-cell">Identifikasi teknologi dan komponen kritikal telah komplit.</td>
                <td>
                        <select name="indikator2_dropdown13" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[12]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[12]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[12]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[12]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[12]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[12]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-mf">
                    <td class="row-number">14</td>
                    <td class="aspect-cell">Mf</td>
                    <td><input type="radio" name="indikator2_row14" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[13]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row14" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[13]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row14" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[13]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row14" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[13]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row14" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[13]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row14" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[13]->score == 5)></td>
                    <td class="description-cell">Material, perkakas dan alat uji prototipe, maupun keahlian personel telah diperlihatkan oleh sub system/system dalam suatu lingkungan produksi yang relevan.</td>
                <td>
                        <select name="indikator2_dropdown14" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[13]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[13]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[13]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[13]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[13]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[13]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                
                <tr class="row-i">
                <td class="row-number">15</td>
                <td class="aspect-cell">I</td>
                <td><input type="radio" name="indikator2_row15" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[14]->score == 0)></td>
                <td><input type="radio" name="indikator2_row15" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[14]->score == 1)></td>
                <td><input type="radio" name="indikator2_row15" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[14]->score == 2)></td>
                <td><input type="radio" name="indikator2_row15" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[14]->score == 3)></td>
                <td><input type="radio" name="indikator2_row15" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[14]->score == 4)></td>
                <td><input type="radio" name="indikator2_row15" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[14]->score == 5)></td>
                <td class="description-cell">Keunggulan jual yang dimiliki telah teruji kepada pelanggan.</td>
            <td>
                        <select name="indikator2_dropdown15" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[14]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[14]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[14]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[14]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[14]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[14]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
            </tr>

                <tr class="row-i">
                    <td class="row-number">16</td>
                    <td class="aspect-cell">I</td>
                    <td><input type="radio" name="indikator2_row16" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[15]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row16" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[15]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row16" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[15]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row16" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[15]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row16" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[15]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row16" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[15]->score == 5)></td>
                    <td class="description-cell">Keunggulan jual yang dimiliki telah teruji kepada pelanggan.</td>
                <td>
                        <select name="indikator2_dropdown16" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[15]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[15]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[15]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[15]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[15]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[15]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-i">
                    <td class="row-number">17</td>
                    <td class="aspect-cell">I</td>
                    <td><input type="radio" name="indikator2_row17" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[16]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row17" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[16]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row17" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[16]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row17" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[16]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row17" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[16]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row17" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[16]->score == 5)></td>
                    <td class="description-cell">Solusi yang ditawarkan kepada pelanggan memunculkan daya tarik yang menguntungkan di pasar.</td>
                <td>
                        <select name="indikator2_dropdown17" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[16]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[16]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[16]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[16]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[16]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[16]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-i">
                    <td class="row-number">18</td>
                    <td class="aspect-cell">I</td>
                    <td><input type="radio" name="indikator2_row18" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[17]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row18" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[17]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row18" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[17]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row18" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[17]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row18" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[17]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row18" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[17]->score == 5)></td>
                    <td class="description-cell">Validasi value proposition, channel, segmen pelanggan, model hubungan dengan pelanggan yang ada, dan aliran revenue terbukti telah dilakukan.</td>
                <td>
                        <select name="indikator2_dropdown18" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[17]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[17]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[17]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[17]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[17]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[17]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                
                <!-- Partnership Aspect Rows -->
                <tr class="row-p">
                    <td class="row-number">19</td>
                    <td class="aspect-cell">P</td>
                    <td><input type="radio" name="indikator2_row19" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[18]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row19" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[18]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row19" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[18]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row19" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[18]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row19" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[18]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row19" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[18]->score == 5)></td>
                    <td class="description-cell">Telah melakukan penggalian informasi dan seleksi mitra.</td>
                <td>
                        <select name="indikator2_dropdown19" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[18]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[18]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[18]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[18]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[18]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[18]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-p">
                    <td class="row-number">20</td>
                    <td class="aspect-cell">P</td>
                    <td><input type="radio" name="indikator2_row20" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[19]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row20" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[19]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row20" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[19]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row20" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[19]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row20" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[19]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row20" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[19]->score == 5)></td>
                    <td class="description-cell">Pola kemitraan dibangun dengan tepat.</td>
                <td>
                        <select name="indikator2_dropdown20" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[19]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[19]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[19]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[19]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[19]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[19]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                
                <!-- Risk Aspect Rows -->
                <tr class="row-r">
                    <td class="row-number">21</td>
                    <td class="aspect-cell">R</td>
                    <td><input type="radio" name="indikator2_row21" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[20]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row21" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[20]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row21" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[20]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row21" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[20]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row21" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[20]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row21" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[20]->score == 5)></td>
                    <td class="description-cell">Kajian risiko teknologi telah dilakukan dalam setiap langkah pengembangan teknologi.</td>
                <td>
                        <select name="indikator2_dropdown21" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[20]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[20]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[20]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[20]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[20]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[20]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="row-r">
                    <td class="row-number">22</td>
                    <td class="aspect-cell">R</td>
                    <td><input type="radio" name="indikator2_row22" class="radio-input" value="0" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[21]->score == 0)></td>
                    <td><input type="radio" name="indikator2_row22" class="radio-input" value="1" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[21]->score == 1)></td>
                    <td><input type="radio" name="indikator2_row22" class="radio-input" value="2" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[21]->score == 2)></td>
                    <td><input type="radio" name="indikator2_row22" class="radio-input" value="3" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[21]->score == 3)></td>
                    <td><input type="radio" name="indikator2_row22" class="radio-input" value="4" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[21]->score == 4)></td>
                    <td><input type="radio" name="indikator2_row22" class="radio-input" value="5" @checked($indicatorTwo->isNotEmpty() && $indicatorTwo[21]->score == 5)></td>
                    <td class="description-cell">Pada tahap pengembangan teknologi dilakukan penyusunan rencana pengendalian risiko teknologi.</td>
                <td>
                        <select name="indikator2_dropdown22" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[21]->dropdown_value === 'A')>0</option>
                            <option value="B" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[21]->dropdown_value === 'B')>1</option>
                            <option value="C" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[21]->dropdown_value === 'C')>2</option>
                            <option value="D" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[21]->dropdown_value === 'D')>3</option>
                            <option value="E" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[21]->dropdown_value === 'E')>4</option>
                            <option value="F" @selected($indicatorTwo->isNotEmpty() && $indicatorTwo[21]->dropdown_value === 'F')>5</option>
                        </select>
                    </td>
                </tr>
                <tr class="total-row">
                    <td colspan="2">Total Skor</td>
                    <td colspan="6" class="total-value">0</td>
                    <td colspan="1"></td>
                </tr>
                <tr class="total-row">
                    <td colspan="2">Persentase</td>
                    <td colspan="6" class="total-value">0.00%</td>
                    <td colspan="1" class="status-cell">TIDAK TERPENUHI</td>
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