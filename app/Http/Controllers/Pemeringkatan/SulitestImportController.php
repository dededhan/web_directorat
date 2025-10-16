<?php

namespace App\Http\Controllers\Pemeringkatan;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\QuestionBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SulitestImportController extends Controller
{

    public function importQuestions(Request $request, QuestionBank $questionBank)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:docx',
        ]);

        try {
            $file = $request->file('import_file');
            $phpWord = IOFactory::load($file->getPathname());

            $fullText = '';
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $fullText .= $element->getText() . "\n";
                    } else if (method_exists($element, 'getElements')) {
                        foreach ($element->getElements() as $nestedElement) {
                            if (method_exists($nestedElement, 'getText')) {
                                $fullText .= $nestedElement->getText();
                            }
                        }
                        $fullText .= "\n";
                    }
                }
            }

            $fullText = preg_replace('/\r\n/', "\n", $fullText);
            $fullText = preg_replace('/[\x00-\x1F\x7F]/u', '', $fullText);
            $fullText = preg_replace('/\n\s*(\((?:Skor|Bobot)\s*:?\s*\d+\))/', ' $1', $fullText);

            $questionBlocks = preg_split('/(?=\d+\.\s)/', $fullText, -1, PREG_SPLIT_NO_EMPTY);

            $importedCount = 0;
            $errors = [];

            DB::transaction(function () use ($questionBlocks, $questionBank, &$importedCount, &$errors) {
                foreach ($questionBlocks as $index => $block) {
                    $block = trim($block);
                    if (empty($block)) continue;

                    if (!preg_match('/^(\d+)\.\s*/', $block, $numberMatch)) {
                        $errors[] = "Soal #" . ($index + 1) . ": Format nomor soal tidak valid.";
                        continue;
                    }

                    $questionNumber = $numberMatch[1];

                    preg_match_all(
                        '/([A-E])\.\s*(.*?)\s*\((?:Skor|Bobot)\s*:?\s*(\d+)\)/is',
                        $block,
                        $optionMatches,
                        PREG_SET_ORDER
                    );

                    if (count($optionMatches) !== 5) {
                        $errors[] = "Soal #$questionNumber: Ditemukan " . count($optionMatches) . " opsi, seharusnya 5. Periksa format (Skor X).";
                        continue;
                    }

                    $foundOptions = array_column($optionMatches, 1);
                    $expectedOptions = ['A', 'B', 'C', 'D', 'E'];
                    $missingOptions = array_diff($expectedOptions, $foundOptions);
                    
                    if (!empty($missingOptions)) {
                        $errors[] = "Soal #$questionNumber: Opsi tidak lengkap. Hilang: " . implode(', ', $missingOptions);
                        continue;
                    }
                    $firstOptionPos = strpos($block, $optionMatches[0][0]);
                    if ($firstOptionPos === false) {
                        $errors[] = "Soal #$questionNumber: Tidak dapat menemukan teks pertanyaan.";
                        continue;
                    }

                    $questionText = substr($block, strlen($numberMatch[0]), $firstOptionPos - strlen($numberMatch[0]));
                    $questionText = trim($questionText);
                    $questionText = preg_replace('/\s+/', ' ', $questionText);

                    if (empty($questionText)) {
                        $errors[] = "Soal #$questionNumber: Teks pertanyaan kosong.";
                        continue;
                    }

                    $question = $questionBank->questions()->create(['question_text' => $questionText]);

                    $optionsData = [];
                    foreach ($optionMatches as $match) {
                        $optionsData[] = [
                            'text' => trim($match[2]),
                            'points' => (int) $match[3],
                        ];
                    }
                    $question->options()->createMany($optionsData);
                    $importedCount++;
                }
            });

            if ($importedCount > 0) {
                return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $questionBank->id)
                    ->with('success', "$importedCount soal berhasil diimpor!" . (count($errors) > 0 ? " (dengan " . count($errors) . " error)" : ""))
                    ->with('import_errors', $errors);
            } else {
                return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $questionBank->id)
                    ->with('error', 'Gagal mengimpor soal. Pastikan format file DOCX sudah sesuai template.')
                    ->with('import_errors', $errors);
            }
        } catch (\Exception $e) {
            Log::error('Import failed: ' . $e->getMessage(), [
                'bank_id' => $questionBank->id,
                'line' => $e->getLine()
            ]);
            
            return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $questionBank->id)
                ->with('error', 'Terjadi kesalahan sistem saat memproses file. Silakan cek format file atau hubungi administrator.');
        }
    }


    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Soal');

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];

        $headers = ['Nomor', 'Pertanyaan', 'Opsi A', 'Skor A', 'Opsi B', 'Skor B', 'Opsi C', 'Skor C', 'Opsi D', 'Skor D', 'Opsi E', 'Skor E'];
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $sheet->getStyle($column . '1')->applyFromArray($headerStyle);
            $column++;
        }

        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(50);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(8);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(8);
        $sheet->getColumnDimension('G')->setWidth(40);
        $sheet->getColumnDimension('H')->setWidth(8);
        $sheet->getColumnDimension('I')->setWidth(40);
        $sheet->getColumnDimension('J')->setWidth(8);
        $sheet->getColumnDimension('K')->setWidth(40);
        $sheet->getColumnDimension('L')->setWidth(8);

        $sampleData = [
            [1, 'Apa yang dimaksud dengan pembangunan berkelanjutan?', 'Pembangunan yang hanya fokus pada ekonomi', 1, 'Pembangunan yang memenuhi kebutuhan saat ini tanpa mengorbankan generasi mendatang', 5, 'Pembangunan dengan teknologi modern', 2, 'Pembangunan di negara maju', 1, 'Pembangunan tanpa memperhatikan lingkungan', 1],
            [2, 'Contoh pertanyaan kedua di sini', 'Opsi A untuk soal 2', 2, 'Opsi B untuk soal 2', 3, 'Opsi C untuk soal 2', 1, 'Opsi D untuk soal 2', 5, 'Opsi E untuk soal 2', 4],
        ];

        $row = 2;
        foreach ($sampleData as $data) {
            $column = 'A';
            foreach ($data as $value) {
                $sheet->setCellValue($column . $row, $value);
                $column++;
            }
            $row++;
        }

        $sheet->getStyle('A1:L' . ($row - 1))->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ]);

        $writer = new Xlsx($spreadsheet);
        $filename = 'Template_Import_Soal_SULITEST.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $filename);
        $writer->save($temp_file);

        return response()->download($temp_file, $filename)->deleteFileAfterSend(true);
    }

    public function importFromExcel(Request $request, QuestionBank $questionBank)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls',
        ]);

        try {
            $file = $request->file('import_file');
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            array_shift($rows);

            $importedCount = 0;
            $errors = [];

            DB::transaction(function () use ($rows, $questionBank, &$importedCount, &$errors) {
                foreach ($rows as $index => $row) {
                    $rowNumber = $index + 2;

                    if (empty(array_filter($row))) continue;

                    if (count($row) < 12) {
                        $errors[] = "Baris #$rowNumber: Data tidak lengkap (harus ada 12 kolom).";
                        continue;
                    }

                    $questionNumber = $row[0];
                    $questionText = trim($row[1]);
                    
                    if (empty($questionText)) {
                        $errors[] = "Baris #$rowNumber: Teks pertanyaan kosong.";
                        continue;
                    }

                    $options = [
                        ['text' => trim($row[2]), 'points' => (int)$row[3]],
                        ['text' => trim($row[4]), 'points' => (int)$row[5]],
                        ['text' => trim($row[6]), 'points' => (int)$row[7]],
                        ['text' => trim($row[8]), 'points' => (int)$row[9]],
                        ['text' => trim($row[10]), 'points' => (int)$row[11]],
                    ];

                    foreach ($options as $i => $option) {
                        $optionLetter = chr(65 + $i);
                        if (empty($option['text'])) {
                            $errors[] = "Baris #$rowNumber: Teks opsi $optionLetter kosong.";
                            continue 2;
                        }
                        if ($option['points'] < 1 || $option['points'] > 5) {
                            $errors[] = "Baris #$rowNumber: Skor opsi $optionLetter harus antara 1-5.";
                            continue 2;
                        }
                    }

                    $question = $questionBank->questions()->create(['question_text' => $questionText]);
                    $question->options()->createMany($options);
                    $importedCount++;
                }
            });

            if ($importedCount > 0) {
                return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $questionBank->id)
                    ->with('success', "$importedCount soal berhasil diimpor dari Excel!" . (count($errors) > 0 ? " (dengan " . count($errors) . " error)" : ""))
                    ->with('import_errors', $errors);
            } else {
                return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $questionBank->id)
                    ->with('error', 'Gagal mengimpor soal. Pastikan format Excel sudah sesuai template.')
                    ->with('import_errors', $errors);
            }
        } catch (\Exception $e) {
            Log::error('Excel import failed: ' . $e->getMessage(), [
                'bank_id' => $questionBank->id,
                'line' => $e->getLine()
            ]);
            
            return redirect()->route('admin_pemeringkatan.sulitest_question_banks.show', $questionBank->id)
                ->with('error', 'Terjadi kesalahan sistem saat memproses file Excel: ' . $e->getMessage());
        }
    }
}
