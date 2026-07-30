<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StructureOrgMember;

class StructureOrgMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if root already exists
        if (StructureOrgMember::whereNull('parent_id')->exists()) {
            return;
        }
        $rektor = StructureOrgMember::create([
            'name' => 'Prof. Dr. Komarudin, M.Si',
            'title' => 'REKTOR',
            'parent_id' => null,
            'level' => 1,
            'order' => 1,
        ]);
        $wakilrektor = StructureOrgMember::create([
            'name' => 'Prof. Dr. Fahrurrozi, M.Pd',
            'title' => 'WAKIL REKTOR BID. RISET, INOVASI DAN SISTEM INFORMASI',
            'parent_id' => $rektor->id,
            'level' => 2,
            'order' => 1,
        ]);
        $direktor = StructureOrgMember::create([
            'name' => 'Dr. R.A. Murti Kusuma W. S.IP. M.Si.',
            'title' => 'DIREKTUR INOVASI, SISTEM INFORMASI DAN PEMERINGKATAN',
            'parent_id' => $wakilrektor->id,
            'level' => 3,
            'order' => 1,
        ]);
        StructureOrgMember::create([
            'name' => 'Dr. Vera Utami Gede Putri, M.Ds',
            'title' => 'Staf Ahli WR III - Bid. Inovasi dan Hilirisasi',
            'parent_id' => $wakilrektor->id,
            'level' => 3,
            'order' => 2,
        ]);
        StructureOrgMember::create([
            'name' => 'Massus Subekti, S.Pd, M.T.',
            'title' => 'Staf Ahli WR III - Bid. Sistem Informasi',
            'parent_id' => $wakilrektor->id,
            'level' => 3,
            'order' => 3,
        ]);
        StructureOrgMember::create([
            'name' => 'Dr. Uswatun Hasanah, M.Pd.',
            'title' => 'Staf Ahli WR III - Bid. Pemeringkatan',
            'parent_id' => $wakilrektor->id,
            'level' => 3,
            'order' => 4,
        ]);
        $kepalaHumas = StructureOrgMember::create([
            'name' => 'Syaifudin, S.Pd, M.Kesos.',
            'title' => 'Kepala Kantor Hubungan Masyarakat dan Informasi Publik',
            'parent_id' => $wakilrektor->id,
            'level' => 3,
            'order' => 5,
        ]);
        StructureOrgMember::create([
            'name' => 'Irna Khaerunnisa Azzahra, S.S.',
            'title' => 'Staf',
            'parent_id' => $direktor->id,
            'level' => 4,
            'order' => 1,
        ]);
        StructureOrgMember::create([
            'name' => 'Nungky Ratna Anggraini, S.E.',
            'title' => 'Staf',
            'parent_id' => $direktor->id,
            'level' => 4,
            'order' => 2,
        ]);
        StructureOrgMember::create([
            'name' => 'Hana Nurina, S.Sos.',
            'title' => 'Staf',
            'parent_id' => $direktor->id,
            'level' => 4,
            'order' => 3,
        ]);
        StructureOrgMember::create([
            'name' => 'Yusi Rahmaniar, S.E, M.M.',
            'title' => 'Staf',
            'parent_id' => $direktor->id,
            'level' => 4,
            'order' => 4,
        ]);
        StructureOrgMember::create([
            'name' => 'Taryudi, ST, MT, Ph.D.',
            'title' => 'Kepala Subdit Inovasi dan Hilirisasi',
            'parent_id' => $direktor->id,
            'level' => 4,
            'order' => 5,
        ]);
        StructureOrgMember::create([
            'name' => 'Tian Abdul Azis, S.Pd, Ph.D.',
            'title' => 'Kepala Subdit Pemeringkatan dan Sistem Informasi',
            'parent_id' => $direktor->id,
            'level' => 4,
            'order' => 6,
        ]);
        StructureOrgMember::create([
            'name' => 'Ririn Listiana',
            'title' => 'Staf',
            'parent_id' => $direktor->id,
            'level' => 4,
            'order' => 7,
        ]);
        StructureOrgMember::create([
            'name' => 'Maulana Irfan, S.E.',
            'title' => 'Staf',
            'parent_id' => $direktor->id,
            'level' => 4,
            'order' => 8,
        ]);
        StructureOrgMember::create([
            'name' => 'Edi Supriadi',
            'title' => 'Driver',
            'parent_id' => $direktor->id,
            'level' => 4,
            'order' => 9,
        ]);
        StructureOrgMember::create([
            'name' => 'Abdullah Ferry',
            'title' => 'Driver',
            'parent_id' => $direktor->id,
            'level' => 4,
            'order' => 10,
        ]);
        StructureOrgMember::create([
            'name' => 'Prima Yustitia Nurul Islami, S.KPm, M.Si.',
            'title' => 'Kepala Divisi Layanan Informasi Kantor Hubungan Masyarakat dan Informasi Publik',
            'parent_id' => $kepalaHumas->id,
            'level' => 4,
            'order' => 1,
        ]);
        StructureOrgMember::create([
            'name' => 'Wina Puspita Sari, M.Si.',
            'title' => 'Kepala Divisi Peliputan dan Pemberitaan Kantor Hubungan Masyarakat dan Informasi Publik',
            'parent_id' => $kepalaHumas->id,
            'level' => 4,
            'order' => 2,
        ]);
        StructureOrgMember::create([
            'name' => 'Nada Arina Romli, S.I.Kom, M.I.kom.',
            'title' => 'Sekretaris Kantor Hubungan Masyarakat dan Informasi Publik',
            'parent_id' => $kepalaHumas->id,
            'level' => 4,
            'order' => 3,
        ]);
    }
}
