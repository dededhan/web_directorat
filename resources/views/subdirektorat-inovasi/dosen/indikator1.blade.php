          
<!-- KATSINOV Assessment Section -->

<div class="container" data-indicator="1">
    <div class="card" data-aos="fade-up">
        <div class="main-title">
            Indikator KATSINOV 1
        </div>
        <div class="content position-relative">
            <table class="katsinov-table 
            ">
            
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
                <!-- T rows -->
                <tr class="row-t">
                    <td class="row-number">1</td>
                    <td class="aspect-cell">T</td>
                    {{-- NUMERIC INDEX SUPERIORITY RAAAHHH!!!! --}}
                    <td><input type="radio" name="indikator1_row1" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 0)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row1" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 1)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row1" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 2)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row1" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 3)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row1" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 4)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row1" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[0]->score == 5)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Ide baru yang memberi solusi permasalahan masyarakat.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown1" class="form-select" >
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
                    <td><input type="radio" name="indikator1_row2" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 0)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row2" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 1)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row2" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 2)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row2" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 3)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row2" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 4)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row2" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[1]->score == 5)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Telah dilakukan pengamatan prinsip-prinsip ilmiah dasar dan publikasi ilmiah.</td>
                    <td class="rating-columns">
                        <select name="indikator1_dropdown2" class="form-select">
                            <option value="">Pilih</option>
                            <option value="A" @selected($indicatorOne->isNotEmpty() && $indicatorOne[1]->dropdown_value === 'A')>1</option>
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
                    <td><input type="radio" name="indikator1_row3" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 0)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row3" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 1)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row3" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 2)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row3" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 3)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row3" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 4)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row3" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[2]->score == 5)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Faktor yang membedakan temuan dengan temuan lain dan unsur kebaruan dari sebuah ide atau gagasan telah diidentifikasi.</td>
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
                    <td><input type="radio" name="indikator1_row4" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 0)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row4" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 1)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row4" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 2)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row4" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 3)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row4" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 4)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row4" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[3]->score == 5)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator1_row5" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 0)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row5" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 1)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row5" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 2)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row5" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 3)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row5" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 4)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row5" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[4]->score == 5)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Teknologi yang akan dikembangkan telah layak secara ilmiah (scientific feasibility).</td>
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
                <!-- M rows -->
                <tr class="row-m">
                    <td class="row-number">6</td>
                    <td class="aspect-cell">M</td>
                    <td><input type="radio" name="indikator1_row6" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 0)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row6" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 1)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row6" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 2)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row6" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 3)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row6" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 4)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row6" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[5]->score == 5)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Inovasi dilakukan berdasarkan permintaan dan/atau kebutuhan pelanggan.</td>
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
                    <td><input type="radio" name="indikator1_row7" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 0)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row7" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 1)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row7" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 2)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row7" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 3)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row7" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 4)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row7" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[6]->score == 5)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator1_row8" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 0)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row8" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 1)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row8" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 2)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row8" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 3)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row8" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 4)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row8" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[7]->score == 5)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
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
                <!-- O rows -->
                <tr class="row-o">
                    <td class="row-number">9</td>
                    <td class="aspect-cell">O</td>
                    <td><input type="radio" name="indikator1_row9" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 0)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row9" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 1)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row9" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 2)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row9" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 3)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row9" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 4)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row9" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[8]->score == 5)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator1_row10" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 0)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row10" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 1)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row10" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 2)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row10" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 3)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row10" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 4)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row10" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[9]->score == 5)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
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
                    <td><input type="radio" name="indikator1_row11" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 0)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row11" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 1)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row11" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 2)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row11" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 3)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row11" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 4)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row11" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[10]->score == 5)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Kebutuhan akan sumber daya, dana dan fasilitas penelitian telah dikonfirmasi.</td>
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
                    <td><input type="radio" name="indikator1_row12" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 0)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row12" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 1)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row12" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 2)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row12" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 3)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row12" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 4)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row12" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[11]->score == 5)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
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
                <!-- Mf rows -->
                <tr class="row-mf">
                    <td class="row-number">13</td>
                    <td class="aspect-cell">Mf</td>
                    <td><input type="radio" name="indikator1_row13" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 0)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row13" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 1)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row13" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 2)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row13" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 3)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row13" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 4)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td><input type="radio" name="indikator1_row13" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[12]->score == 5)@if(request()->routeIs('admin.Katsinov.show')) disabled @endif></td>
                    <td class="description-cell">Konsekuensi hasil temuan telah diidentifikasi melalui dasar manufaktur ekonomis.</td><td class="rating-columns">
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
                    <td><input type="radio" name="indikator1_row14" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 0)></td>
                    <td><input type="radio" name="indikator1_row14" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 1)></td>
                    <td><input type="radio" name="indikator1_row14" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 2)></td>
                    <td><input type="radio" name="indikator1_row14" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 3)></td>
                    <td><input type="radio" name="indikator1_row14" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 4)></td>
                    <td><input type="radio" name="indikator1_row14" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[13]->score == 5)></td>
                    <td class="description-cell">Tersedia bukti konsep manufaktur melalui analitik atau eksperimen laboratorium.</td><td class="rating-columns">
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
                    <td><input type="radio" name="indikator1_row15" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 0)></td>
                    <td><input type="radio" name="indikator1_row15" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 1)></td>
                    <td><input type="radio" name="indikator1_row15" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 2)></td>
                    <td><input type="radio" name="indikator1_row15" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 3)></td>
                    <td><input type="radio" name="indikator1_row15" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 4)></td>
                    <td><input type="radio" name="indikator1_row15" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[14]->score == 5)></td>
                    <td class="description-cell">Ide yang dikembangkan memiliki konsep model bisnis.</td>
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
                <!-- I rows -->
                <tr class="row-i">
                    <td class="row-number">16</td>
                    <td class="aspect-cell">I</td>
                    <td><input type="radio" name="row
                    <!-- Lanjutan I rows -->
                   <td><input type="radio" name="indikator1_row16" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 0)></td>
                   <td><input type="radio" name="indikator1_row16" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 1)></td>
                   <td><input type="radio" name="indikator1_row16" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 2)></td>
                   <td><input type="radio" name="indikator1_row16" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 3)></td>
                   <td><input type="radio" name="indikator1_row16" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 4)></td>
                   <td><input type="radio" name="indikator1_row16" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[15]->score == 5)></td>
                   <td class="description-cell">Ide yang dikembangkan memiliki hasil analisis pelanggan, pasar, dan pesaing.</td>
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
                   <td><input type="radio" name="indikator1_row17" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 0)></td>
                   <td><input type="radio" name="indikator1_row17" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 1)></td>
                   <td><input type="radio" name="indikator1_row17" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 2)></td>
                   <td><input type="radio" name="indikator1_row17" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 3)></td>
                   <td><input type="radio" name="indikator1_row17" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 4)></td>
                   <td><input type="radio" name="indikator1_row17" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[16]->score == 5)></td>
                   <td class="description-cell">Ide yang dikembangkan telah terbukti memberi solusi bagi pelanggan.</td>
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
               <tr class="row-i">
                   <td class="row-number">18</td>
                   <td class="aspect-cell">I</td>
                   <td><input type="radio" name="indikator1_row18" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 0)></td>
                   <td><input type="radio" name="indikator1_row18" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 1)></td>
                   <td><input type="radio" name="indikator1_row18" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 2)></td>
                   <td><input type="radio" name="indikator1_row18" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 3)></td>
                   <td><input type="radio" name="indikator1_row18" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 4)></td>
                   <td><input type="radio" name="indikator1_row18" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[17]->score == 5)></td>
                   <td class="description-cell">Telah tersusun strategi membangun jaringan kerja dan kemitraan.</td>
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
               <!-- P rows -->
               <tr class="row-p">
                   <td class="row-number">19</td>
                   <td class="aspect-cell">P</td>
                   <td><input type="radio" name="indikator1_row19" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 0)></td>
                   <td><input type="radio" name="indikator1_row19" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 1)></td>
                   <td><input type="radio" name="indikator1_row19" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 2)></td>
                   <td><input type="radio" name="indikator1_row19" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 3)></td>
                   <td><input type="radio" name="indikator1_row19" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 4)></td>
                   <td><input type="radio" name="indikator1_row19" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[18]->score == 5)></td>
                   <td class="description-cell">Mitra potensial telah diidentifikasi.</td>
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
               <tr class="row-p">
                   <td class="row-number">20</td>
                   <td class="aspect-cell">P</td>
                   <td><input type="radio" name="indikator1_row20" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 0)></td>
                   <td><input type="radio" name="indikator1_row20" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 1)></td>
                   <td><input type="radio" name="indikator1_row20" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 2)></td>
                   <td><input type="radio" name="indikator1_row20" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 3)></td>
                   <td><input type="radio" name="indikator1_row20" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 4)></td>
                   <td><input type="radio" name="indikator1_row20" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[19]->score == 5)></td>
                   <td class="description-cell">Kajian risiko teknologi telah menjadi pertimbangan dalam setiap langkah penelitian.</td>
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
               <!-- R row -->
               <tr class="row-r">
                   <td class="row-number">21</td>
                   <td class="aspect-cell">R</td>
                   <td><input type="radio" name="indikator1_row21" class="radio-input" value="0" @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 0)></td>
                   <td><input type="radio" name="indikator1_row21" class="radio-input" value="1" @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 1)></td>
                   <td><input type="radio" name="indikator1_row21" class="radio-input" value="2" @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 2)></td>
                   <td><input type="radio" name="indikator1_row21" class="radio-input" value="3" @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 3)></td>
                   <td><input type="radio" name="indikator1_row21" class="radio-input" value="4" @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 4)></td>
                   <td><input type="radio" name="indikator1_row21" class="radio-input" value="5" @checked($indicatorOne->isNotEmpty() && $indicatorOne[20]->score == 5)></td>
                   <td class="description-cell">Pada tahap penelitian dilakukan penyusunan rencana pengendalian risiko teknologi.</td>
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
           <!-- Move notes section outside of the table -->
        <div class="notes-section">
            <div class="notes-header">Catatan</div>
            <textarea 
                name="catatan"
                placeholder="Tambahkan catatan di sini..." 
                class="notes-textarea form-control">{{ $catatan ?? '' }}</textarea>
        </div>
        </div>
    </div>
</div>
<script src="{{ asset('indikator.js') }}"></script>
