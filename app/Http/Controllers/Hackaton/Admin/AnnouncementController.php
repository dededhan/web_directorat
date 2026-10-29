<?php

namespace App\Http\Controllers\Hackaton\Admin;

use App\Http\Controllers\Controller;
use App\Models\HackatonAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = HackatonAnnouncement::with('author')->latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->string('type')->toString());
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $announcements = $query->paginate(12)->withQueryString();
        $totalCount = HackatonAnnouncement::count();
        $activeCount = HackatonAnnouncement::where('is_active', true)->count();

        return view('admin_hackaton.announcements.index', compact('announcements', 'totalCount', 'activeCount'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => ['required', 'string', 'max:255'],
            'content'   => ['required', 'string'],
            'type'      => ['required', 'in:info,penting,urgent'],
            'link_url'  => ['nullable', 'url', 'max:500'],
            'link_text' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'title.required'   => 'Judul pengumuman wajib diisi.',
            'content.required' => 'Isi pengumuman wajib diisi.',
            'type.required'    => 'Pilih tipe pengumuman.',
            'link_url.url'     => 'Format link URL tidak valid (harus menyertakan http:// atau https://).',
        ]);

        HackatonAnnouncement::create([
            'title'      => $validated['title'],
            'content'    => $validated['content'],
            'type'       => $validated['type'],
            'link_url'   => $validated['link_url'] ?? null,
            'link_text'  => $validated['link_text'] ?? null,
            'is_active'  => $request->boolean('is_active', true),
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', 'Pengumuman baru berhasil diterbitkan!');
    }

    public function update(Request $request, HackatonAnnouncement $announcement)
    {
        $validated = $request->validate([
            'title'     => ['required', 'string', 'max:255'],
            'content'   => ['required', 'string'],
            'type'      => ['required', 'in:info,penting,urgent'],
            'link_url'  => ['nullable', 'url', 'max:500'],
            'link_text' => ['nullable', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ], [
            'title.required'   => 'Judul pengumuman wajib diisi.',
            'content.required' => 'Isi pengumuman wajib diisi.',
            'type.required'    => 'Pilih tipe pengumuman.',
            'link_url.url'     => 'Format link URL tidak valid (harus menyertakan http:// atau https://).',
        ]);

        $announcement->update([
            'title'     => $validated['title'],
            'content'   => $validated['content'],
            'type'      => $validated['type'],
            'link_url'  => $validated['link_url'] ?? null,
            'link_text' => $validated['link_text'] ?? null,
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : $announcement->is_active,
        ]);

        return back()->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function toggle(HackatonAnnouncement $announcement)
    {
        $announcement->update([
            'is_active' => !$announcement->is_active,
        ]);

        $statusMsg = $announcement->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Status pengumuman berhasil {$statusMsg}.");
    }

    public function destroy(HackatonAnnouncement $announcement)
    {
        $announcement->delete();

        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
