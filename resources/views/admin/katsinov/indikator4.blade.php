
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
                    <td><input type="radio" name="indikator4_row1" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[0]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row1" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[0]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row1" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[0]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row1" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[0]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row1" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[0]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row1" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[0]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row2" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[1]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row2" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[1]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row2" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[1]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row2" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[1]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row2" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[1]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row2" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[1]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row3" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[2]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row3" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[2]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row3" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[2]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row3" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[2]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row3" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[2]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row3" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[2]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row4" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[3]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row4" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[3]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row4" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[3]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row4" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[3]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row4" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[3]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row4" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[3]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row5" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[4]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row5" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[4]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row5" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[4]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row5" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[4]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row5" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[4]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row5" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[4]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row6" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[5]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row6" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[5]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row6" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[5]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row6" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[5]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row6" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[5]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row6" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[5]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row7" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[6]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row7" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[6]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row7" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[6]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row7" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[6]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row7" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[6]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row7" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[6]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row8" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[7]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row8" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[7]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row8" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[7]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row8" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[7]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row8" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[7]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row8" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[7]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row9" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[8]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row9" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[8]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row9" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[8]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row9" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[8]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row9" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[8]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row9" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[8]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row10" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[9]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row10" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[9]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row10" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[9]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row10" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[9]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row10" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[9]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row10" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[9]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row11" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[10]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row11" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[10]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row11" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[10]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row11" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[10]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row11" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[10]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row11" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[10]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row12" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[11]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row12" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[11]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row12" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[11]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row12" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[11]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row12" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[11]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row12" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[11]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row13" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[12]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row13" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[12]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row13" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[12]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row13" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[12]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row13" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[12]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row13" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[12]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row14" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[13]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row14" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[13]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row14" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[13]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row14" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[13]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row14" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[13]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row14" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[13]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row15" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[14]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row15" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[14]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row15" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[14]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row15" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[14]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row15" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[14]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row15" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[14]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row16" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[15]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row16" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[15]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row16" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[15]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row16" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[15]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row16" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[15]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row16" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[15]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row17" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[16]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row17" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[16]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row17" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[16]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row17" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[16]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row17" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[16]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row17" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[16]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row18" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[17]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row18" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[17]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row18" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[17]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row18" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[17]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row18" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[17]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row18" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[17]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row19" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[18]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row19" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[18]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row19" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[18]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row19" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[18]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row19" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[18]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row19" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[18]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row20" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[19]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row20" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[19]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row20" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[19]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row20" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[19]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row20" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[19]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row20" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[19]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row21" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[20]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row21" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[20]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row21" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[20]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row21" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[20]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row21" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[20]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row21" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[20]->score == 5)></td>
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
                    <td><input type="radio" name="indikator4_row22" class="radio-input" value="0" @checked($indicatorFour->isNotEmpty() && $indicatorFour[21]->score == 0)></td>
                    <td><input type="radio" name="indikator4_row22" class="radio-input" value="1" @checked($indicatorFour->isNotEmpty() && $indicatorFour[21]->score == 1)></td>
                    <td><input type="radio" name="indikator4_row22" class="radio-input" value="2" @checked($indicatorFour->isNotEmpty() && $indicatorFour[21]->score == 2)></td>
                    <td><input type="radio" name="indikator4_row22" class="radio-input" value="3" @checked($indicatorFour->isNotEmpty() && $indicatorFour[21]->score == 3)></td>
                    <td><input type="radio" name="indikator4_row22" class="radio-input" value="4" @checked($indicatorFour->isNotEmpty() && $indicatorFour[21]->score == 4)></td>
                    <td><input type="radio" name="indikator4_row22" class="radio-input" value="5" @checked($indicatorFour->isNotEmpty() && $indicatorFour[21]->score == 5)></td>
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
                    <td colspan="6" class="total-value">0</td>
                    <td colspan="1"></td>
                </tr>
                <tr class="total-row">
                    <td colspan="2">Persentase</td>
                    <td colspan="6" class="total-value">0.00%</td>
                    <td colspan="1" class="status-cell">TIDAK TERPENUHI</td>
                </tr>
            </table>
            {{-- <div class="notes-section">
                <div class="notes-header">Catatan</div>
                <textarea 
                    placeholder="Tambahkan catatan di sini..." 
                    class="notes-textarea">
                </textarea>
            </div> --}}
            <div class="katsinov-legend">
                Skala: 0=tidak terpenuhi; 1=20%; 2=40%; 3=60%; 4=80%; 5=100% atau terpenuhi
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('indikator.js') }}"></script>

