<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\User;
use App\Models\Dokumen;
use App\Models\Gallery;
use App\Models\Youtube;
use App\Models\Instagram;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get metrics data from database
        $totalBerita = Berita::count();
        $totalUsers = User::count();
        $totalDokumen = Dokumen::count();
        $totalGaleri = Gallery::count();
        
        // Build metrics array with real data
        $metrics = [
            [
                'label' => 'Total Berita',
                'value' => number_format($totalBerita),
                'icon' => 'bx bxs-news',
                'description' => 'Total artikel berita yang telah dipublikasikan',
                'color' => 'from-blue-500 to-blue-600',
                'bg' => 'bg-blue-50',
                'text' => 'text-blue-600',
            ],
            [
                'label' => 'Total Users',
                'value' => number_format($totalUsers),
                'icon' => 'bx bxs-user-account',
                'description' => 'Jumlah pengguna terdaftar di sistem',
                'color' => 'from-teal-500 to-teal-600',
                'bg' => 'bg-teal-50',
                'text' => 'text-teal-600',
            ],
            [
                'label' => 'Dokumen',
                'value' => number_format($totalDokumen),
                'icon' => 'bx bxs-file',
                'description' => 'Total dokumen yang tersimpan',
                'color' => 'from-purple-500 to-purple-600',
                'bg' => 'bg-purple-50',
                'text' => 'text-purple-600',
            ],
            [
                'label' => 'Galeri Foto',
                'value' => number_format($totalGaleri),
                'icon' => 'bx bxs-photo-album',
                'description' => 'Total foto di galeri',
                'color' => 'from-pink-500 to-pink-600',
                'bg' => 'bg-pink-50',
                'text' => 'text-pink-600',
            ],
        ];

        // Quick links remain static as they're navigation items
        $quickLinks = [
            [
                'title' => 'Kelola Berita',
                'description' => 'Tambah, edit, atau hapus berita',
                'icon' => 'bx bxs-news',
                'route' => route('admin.news.index'),
                'color' => 'text-blue-600',
                'bg' => 'bg-blue-50',
            ],
            [
                'title' => 'Manage Users',
                'description' => 'Kelola pengguna sistem',
                'icon' => 'bx bxs-user',
                'route' => route('admin.manageuser.index'),
                'color' => 'text-teal-600',
                'bg' => 'bg-teal-50',
            ],
            [
                'title' => 'Dokumen',
                'description' => 'Kelola dokumen penting',
                'icon' => 'bx bxs-file',
                'route' => route('admin.document.index'),
                'color' => 'text-purple-600',
                'bg' => 'bg-purple-50',
            ],
            [
                'title' => 'Galeri',
                'description' => 'Kelola galeri foto',
                'icon' => 'bx bxs-photo-album',
                'route' => route('admin.gallery.index'),
                'color' => 'text-pink-600',
                'bg' => 'bg-pink-50',
            ],
            [
                'title' => 'Youtube',
                'description' => 'Kelola video Youtube',
                'icon' => 'bx bxl-youtube',
                'route' => route('admin.youtube.index'),
                'color' => 'text-red-600',
                'bg' => 'bg-red-50',
            ],
            [
                'title' => 'Instagram',
                'description' => 'Kelola konten Instagram',
                'icon' => 'bx bxl-instagram',
                'route' => route('admin.instagram.index'),
                'color' => 'text-orange-600',
                'bg' => 'bg-orange-50',
            ],
        ];

        // UNJ Statistics - These are relatively static institutional data
        // In a real scenario, these might come from a settings table or cached data
        $stats = [
            ['label' => 'Mahasiswa', 'value' => '30,673', 'icon' => 'bx bxs-group', 'color' => 'blue'],
            ['label' => 'Dosen', 'value' => '1,132', 'icon' => 'bx bxs-user-voice', 'color' => 'teal'],
            ['label' => 'Tendik', 'value' => '774', 'icon' => 'bx bxs-user', 'color' => 'purple'],
            ['label' => 'Fakultas', 'value' => '8', 'icon' => 'bx bxs-building-house', 'color' => 'pink'],
            ['label' => 'Program Studi', 'value' => '116', 'icon' => 'bx bxs-grid', 'color' => 'orange'],
            ['label' => 'Guru Besar', 'value' => '130', 'icon' => 'bx bxs-bulb', 'color' => 'yellow'],
            ['label' => 'Mahasiswa Internasional', 'value' => '125', 'icon' => 'bx bx-world', 'color' => 'green'],
            ['label' => 'Dosen Internasional', 'value' => '4', 'icon' => 'bx bxs-user-badge', 'color' => 'indigo'],
            ['label' => 'Scopus', 'value' => '3,681', 'icon' => 'bx bxs-graduation', 'color' => 'red'],
        ];

        // Get recent activities (latest 5 news as example)
        $recentActivities = Berita::latest()
            ->take(5)
            ->get()
            ->map(function ($berita) {
                return [
                    'title' => $berita->judul_berita,
                    'description' => 'Berita dipublikasikan',
                    'date' => $berita->created_at->diffForHumans(),
                    'type' => 'news',
                    'icon' => 'bx bxs-news',
                ];
            });

        // Get system info (can be expanded with real server metrics)
        $systemInfo = [
            'status' => 'online',
            'uptime' => '99.9%',
            'database_size' => $this->getDatabaseSize(),
            'total_tables' => $this->getTotalTables(),
        ];

        return view('admin.dashboardadmin', compact(
            'user',
            'metrics',
            'quickLinks',
            'stats',
            'recentActivities',
            'systemInfo'
        ));
    }

    /**
     * Get approximate database size
     */
    private function getDatabaseSize()
    {
        try {
            $database = config('database.connections.mysql.database');
            $result = DB::select("
                SELECT 
                    ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size_mb
                FROM information_schema.TABLES
                WHERE table_schema = ?
            ", [$database]);
            
            $sizeMB = $result[0]->size_mb ?? 0;
            
            if ($sizeMB > 1000) {
                return round($sizeMB / 1024, 1) . ' GB';
            }
            
            return round($sizeMB, 1) . ' MB';
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    /**
     * Get total number of tables
     */
    private function getTotalTables()
    {
        try {
            $database = config('database.connections.mysql.database');
            $result = DB::select("
                SELECT COUNT(*) as total
                FROM information_schema.TABLES
                WHERE table_schema = ?
            ", [$database]);
            
            return $result[0]->total ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
}
