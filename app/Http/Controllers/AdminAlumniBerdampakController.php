<?php

namespace App\Http\Controllers;


use App\Models\AlumniBerdampak;
use App\Http\Requests\StoreAlumniBerdampakRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class AdminAlumniBerdampakController extends Controller
{
    public function index()
    {
        $alumniBerdampak = AlumniBerdampak::latest()->get();

        if (Auth::user()->role === 'admin_direktorat') {
            return view('admin.alumniberdampak', compact('alumniBerdampak'));
        } else if (Auth::user()->role === 'prodi') {
            return view('prodi.alumniberdampak', compact('alumniBerdampak'));
        } else if (Auth::user()->role === 'fakultas') {
            return view('fakultas.alumniberdampak', compact('alumniBerdampak'));
        } else if (Auth::user()->role === 'admin_pemeringkatan'){
            return view('admin_pemeringkatan.alumniberdampak', compact('alumniBerdampak'));
        }
        // return view('admin.alumniberdampak', compact('alumniBerdampak'));
    }

    public function store(StoreAlumniBerdampakRequest $request)
    {
        $prodiMapping = [
            'fmipa' => [
                'ilmu_komputer' => 'Ilmu Komputer',
                'matematika' => 'Matematika',
                'pendidikan_matematika' => 'Pendidikan Matematika',
                'fisika' => 'Fisika',
                'pendidikan_fisika' => 'Pendidikan Fisika',
                'biologi' => 'Biologi',
                'pendidikan_biologi' => 'Pendidikan Biologi',
                'kimia' => 'Kimia',
                'pendidikan_kimia' => 'Pendidikan Kimia',
            ],
            'fik' => [
                'pendidikan_teknologi_informasi' => 'Pendidikan Teknologi Informasi',
                'pendidikan_teknik_elektronika' => 'Pendidikan Teknik Elektronika',
                'pendidikan_teknik_elektro' => 'Pendidikan Teknik Elektro',
                'teknik_informatika_dan_komputer' => 'Teknik Informatika dan Komputer',
            ],
            'ft' => [
            'teknik_sipil' => 'Teknik Sipil',
            'teknik_mesin' => 'Teknik Mesin',
            'teknik_elektro' => 'Teknik Elektro',
            'pendidikan_teknik_bangunan' => 'Pendidikan Teknik Bangunan',
            'pendidikan_teknik_mesin' => 'Pendidikan Teknik Mesin',
        ],
        'fbs' => [
            'pendidikan_bahasa_indonesia' => 'Pendidikan Bahasa Indonesia',
            'pendidikan_bahasa_inggris' => 'Pendidikan Bahasa Inggris',
            'pendidikan_bahasa_jerman' => 'Pendidikan Bahasa Jerman',
            'pendidikan_bahasa_prancis' => 'Pendidikan Bahasa Prancis',
            'pendidikan_seni_rupa' => 'Pendidikan Seni Rupa',
        ],
        'fip' => [
            'pendidikan_guru_sekolah_dasar' => 'Pendidikan Guru Sekolah Dasar',
            'pendidikan_anak_usia_dini' => 'Pendidikan Anak Usia Dini',
            'bimbingan_dan_konseling' => 'Bimbingan dan Konseling',
            'teknologi_pendidikan' => 'Teknologi Pendidikan',
            'pendidikan_luar_biasa' => 'Pendidikan Luar Biasa',
        ],
        'fe' => [
            'pendidikan_ekonomi' => 'Pendidikan Ekonomi',
            'manajemen' => 'Manajemen',
            'akuntansi' => 'Akuntansi',
            'pendidikan_administrasi_perkantoran' => 'Pendidikan Administrasi Perkantoran',
        ],
        'fis' => [
            'pendidikan_pancasila_dan_kewarganegaraan' => 'Pendidikan Pancasila dan Kewarganegaraan',
            'pendidikan_sejarah' => 'Pendidikan Sejarah',
            'pendidikan_geografi' => 'Pendidikan Geografi',
            'pendidikan_sosiologi' => 'Pendidikan Sosiologi',
            'ilmu_komunikasi' => 'Ilmu Komunikasi',
        ]
    ];

        $validated = $request->validated();
        $validated['prodi'] = $prodiMapping[$validated['fakultas']][$validated['prodi']] ?? 'Unknown Prodi';

        AlumniBerdampak::create($validated);

        if (Auth::user()->role === 'admin_direktorat') {
            return redirect()->route('admin.alumniberdampak.index')
                ->with('success', 'Data berhasil disimpan!');
        } else if (Auth::user()->role === 'prodi') {
            return redirect()->route('prodi.alumniberdampak.index')
                ->with('success', 'Data berhasil disimpan!');
        } else if (Auth::user()->role === 'fakultas') {
            return redirect()->route('fakultas.alumniberdampak.index')
                ->with('success', 'Data berhasil disimpan!');
        } else if (Auth::user()->role === 'admin_pemeringkatan'){
            return redirect()->route('admin_pemeringkatan.alumniberdampak.index')
                ->with('success', 'Data berhasil disimpan!');
        }

        // return redirect()->route('admin.alumniberdampak.index')
        //     ->with('success', 'Data berhasil disimpan!');
    }
}  //
