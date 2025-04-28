
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
                    <th class="rating-columns">Rating</th>
                    <td rowspan="24" class="katsinov-title">KATSINOV 3</td>
                </tr>
                <!-- T rows -->
                <tr class="row-r">
                    <td class="row-number">1</td>
                    <td class="aspect-cell">T</td>
                    <td><input type="radio" name="indikator3_row22" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[0]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row22" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[0]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row22" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[0]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row22" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[0]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row22" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[0]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row22" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[0]->score == 5)></td>
                    <td class="description-cell">Sistem aktual teknologi telah didemonstrasikan dalam lingkungan yang sebenarnya.</td>
                    <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row23" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[1]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row23" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[1]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row23" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[1]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row23" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[1]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row23" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[1]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row23" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[1]->score == 5)></td>
                    <td class="description-cell">Uji eksternal dari teknologi yang dikembangkan telah dilakukan secara lengkap, dalam rangka memenuhi persyaratan teknis dan kesesuaian regulasi.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row24" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[2]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row24" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[2]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row24" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[2]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row24" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[2]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row24" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[2]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row24" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[2]->score == 5)></td>
                    <td class="description-cell">Telah mendokumentasikan teknologi yang dikembangkan.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row25" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[3]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row25" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[3]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row25" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[3]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row25" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[3]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row25" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[3]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row25" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[3]->score == 5)></td>
                    <td class="description-cell">Hasil Inovasi telah diperkenalkan.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row26" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[4]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row26" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[4]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row26" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[4]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row26" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[4]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row26" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[4]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row26" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[4]->score == 5)></td>
                    <td class="description-cell">Telah memperoleh Kekayaan intelektual (misal: paten, desain industri, hak cipta, merek, dll).</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row27" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[5]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row27" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[5]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row27" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[5]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row27" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[5]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row27" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[5]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row27" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[5]->score == 5)></td>
                    <td class="description-cell">Kebutuhan khusus dan keperluan pelanggan telah diketahui.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row28" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[6]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row28" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[6]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row28" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[6]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row28" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[6]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row28" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[6]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row28" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[6]->score == 5)></td>
                    <td class="description-cell">Segmen, ukuran dan pangsa pasar telah diprediksi.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row29" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[7]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row29" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[7]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row29" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[7]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row29" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[7]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row29" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[7]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row29" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[7]->score == 5)></td>
                    <td class="description-cell">Produk telah diperkenalkan, dan harganya telah ditetapkan.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row30" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[8]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row30" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[8]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row30" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[8]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row30" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[8]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row30" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[8]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row30" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[8]->score == 5)></td>
                    <td class="description-cell">Penetapan organisasi (struktur bisnis dengan staff dan kolaborator).</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row31" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[9]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row31" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[9]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row31" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[9]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row31" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[9]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row31" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[9]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row31" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[9]->score == 5)></td>
                    <td class="description-cell">Identifikasi beberapa tambahan staff yang dibutuhkan.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row32" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[10]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row32" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[10]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row32" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[10]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row32" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[10]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row32" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[10]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row32" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[10]->score == 5)></td>
                    <td class="description-cell">Telah merincikan pembagian tanggung jawab dan beban kerja.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row33" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[11]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row33" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[11]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row33" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[11]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row33" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[11]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row33" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[11]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row33" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[11]->score == 5)></td>
                    <td class="description-cell">Desain sistem sebagian besar stabil dan terbukti dalam uji dan evaluasi.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row34" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[12]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row34" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[12]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row34" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[12]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row34" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[12]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row34" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[12]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row34" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[12]->score == 5)></td>
                    <td class="description-cell">Proses dan prosedur manufaktur terbukti dalam skala pilot.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row35" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row35" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row35" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row35" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row35" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row35" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 5)></td>
                    <td class="description-cell">Produksi pada laju rendah telah dilaksanakan.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row36" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row36" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row36" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row36" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row36" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row36" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[13]->score == 5)></td>
                    <td class="description-cell">Telah mendefinisikan kondisi akhir dari produk teknologi dengan mempertimbangkan target person, pasar vertikal, serta geografik.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row37" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[14]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row37" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[14]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row37" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[14]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row37" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[14]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row37" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[14]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row37" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[14]->score == 5)></td>
                    <td class="description-cell">Validasi terhadap bisnis yang dilakukan sudah diterapkan.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row38" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[15]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row38" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[15]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row38" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[15]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row38" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[15]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row38" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[15]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row38" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[15]->score == 5)></td>
                    <td class="description-cell">Identifikasi dan validasi terhadap indikator kinerja utama yang mengindikasikan keberhasilan bisnis.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row39" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[16]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row39" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[16]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row39" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[16]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row39" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[16]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row39" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[16]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row39" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[16]->score == 5)></td>
                    <td class="description-cell">Telah terjalin kemitraan secara formal.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row40" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[17]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row40" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[17]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row40" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[17]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row40" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[17]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row40" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[17]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row40" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[17]->score == 5)></td>
                    <td class="description-cell">Telah menyusun dan telah menerapkan rencana kerja sama.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row41" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[18]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row41" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[18]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row41" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[18]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row41" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[18]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row41" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[18]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row41" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[18]->score == 5)></td>
                    <td class="description-cell">Kajian risiko teknologi menjadi dasar pengambilan keputusan teknis dalam tahap engineering & Operation.</td>
                  <td class="rating-columns">
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
                    <td><input type="radio" name="indikator3_row42" class="radio-input" value="0" @checked($indicatorThree->isNotEmpty() && $indicatorThree[19]->score == 0)></td>
                    <td><input type="radio" name="indikator3_row42" class="radio-input" value="1" @checked($indicatorThree->isNotEmpty() && $indicatorThree[19]->score == 1)></td>
                    <td><input type="radio" name="indikator3_row42" class="radio-input" value="2" @checked($indicatorThree->isNotEmpty() && $indicatorThree[19]->score == 2)></td>
                    <td><input type="radio" name="indikator3_row42" class="radio-input" value="3" @checked($indicatorThree->isNotEmpty() && $indicatorThree[19]->score == 3)></td>
                    <td><input type="radio" name="indikator3_row42" class="radio-input" value="4" @checked($indicatorThree->isNotEmpty() && $indicatorThree[19]->score == 4)></td>
                    <td><input type="radio" name="indikator3_row42" class="radio-input" value="5" @checked($indicatorThree->isNotEmpty() && $indicatorThree[19]->score == 5)></td>
                    <td class="description-cell">Pada tahap penerapan teknologi dilakukan penyusunan rencana pengendalian risiko teknologi.</td>
                  <td class="rating-columns">
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
                        <td colspan="6" class="total-value">0</td>
                        <td colspan="1" style="text-align: left; padding-left: 10px;">
                        </td>
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

