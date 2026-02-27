# Innovation Challenge — Product Requirements Document (PRD)

> **Version:** 1.0.0  
> **Date:** 2026-02-27  
> **Author:** AI Agent (GitHub Copilot)  
> **Status:** Approved for Implementation  

---

## 1. Overview

**Innovation Challenge** is a session-based competition management feature integrated into the `admin_inovasi` panel. It allows administrators to create and manage challenge sessions that **Dosen** users can participate in by submitting proposals through a structured workflow.

The design mirrors the proven **Comdev** (Community Development) feature structure, adapted for innovation competitions.

---

## 2. Goals

- Allow `admin_inovasi` to create, open, edit, close, and delete challenge sessions
- Allow admin to configure modules and sub-chapters per session (structured submission stages)
- Allow `dosen` users to see available sessions, create submissions, upload files per sub-chapter, and track their progress
- Allow admin to assign dedicated `reviewer_inovchalenge` users to review submissions
- Allow reviewers to post per-module comments and scores

---

## 3. Actors & Roles

| Role | Responsibility | Scope |
|---|---|---|
| `admin_inovasi` | Full session CRUD, module configuration, reviewer assignment, status management | In scope — Sprint 1–3 |
| `dosen` | View active sessions, create and submit proposals, upload files per sub-chapter | In scope — Sprint 2 |
| `reviewer_inovchalenge` | View assigned submissions, post per-module reviews/scores | In scope — Sprint 3 |
| `alumni` | Future participation (same as dosen flow) | **Out of scope** — deferred |
| sub_admin_inovchalenge | Delegated admin operations | **Out of scope** — deferred |

> **Note:** `reviewer_inovchalenge` is a **new role** and must be added to the `users.role` enum migration (Sprint 0).

---

## 4. Out of Scope (This Version)

- `alumni` role participation
- Dynamic form builder (JSON-based custom form fields per session)
- Email / in-app notification system
- Data export (Excel/PDF)
- Dashboard statistics widget on main `admin_inovasi` dashboard
- Sub Admin role

---

## 5. Database Schema

### Naming Convention
All tables use prefix `inov_chalenge_*` (matching the existing route file naming: `inovchalange.php`).

---

### 5.1 `inov_chalenge_sessions`

```
id                  bigint PK auto-increment
nama_sesi           string(255)
deskripsi           text nullable
dana_maksimal       decimal(15,2) nullable
periode_awal        date
periode_akhir       date
min_anggota         tinyint unsigned default 1
max_anggota         tinyint unsigned default 4
status              enum('draft','active','closed') default 'draft'
created_by          bigint FK → users.id nullable
created_at
updated_at
```

---

### 5.2 `inov_chalenge_modules`

```
id                      bigint PK auto-increment
inov_chalenge_session_id  bigint FK → inov_chalenge_sessions.id (cascade delete)
nama_modul              string(255)
deskripsi               text nullable
urutan                  tinyint unsigned default 0
form_penilaian          json nullable   (custom review criteria, future use)
created_at
updated_at
```

---

### 5.3 `inov_chalenge_sub_chapters`

```
id                          bigint PK auto-increment
inov_chalenge_module_id     bigint FK → inov_chalenge_modules.id (cascade delete)
nama_sub_bab                string(255)
deskripsi_instruksi         text nullable
urutan                      tinyint unsigned default 0
periode_awal                datetime nullable
periode_akhir               datetime nullable
is_wajib                    boolean default true
created_at
updated_at
```

---

### 5.4 `inov_chalenge_submissions`

```
id                          bigint PK auto-increment
inov_chalenge_session_id    bigint FK → inov_chalenge_sessions.id
user_id                     bigint FK → users.id  (dosen ketua tim)
judul                       string(255) nullable
tahun_usulan                year nullable
tempat_pelaksanaan          string(255) nullable
abstrak                     text nullable
nominal_usulan              decimal(15,2) nullable
kata_kunci                  json nullable
sdgs_fokus                  json nullable
sdgs_pendukung              json nullable
luaran_wajib                json nullable
luaran_opsional             json nullable
status                      string default 'draft'
reviewer_id                 bigint FK → users.id nullable  (legacy single, kept for compat)
created_at
updated_at
```

**Status values:** `draft` → `diajukan` → `menunggu_direview` → `sedang_direview` → `perbaikan_diperlukan` → `proses_tahap_selanjutnya` → `selesai`

---

### 5.5 `inov_chalenge_submission_reviewer` (pivot)

```
id                          bigint PK auto-increment
inov_chalenge_submission_id bigint FK → inov_chalenge_submissions.id (cascade delete)
reviewer_id                 bigint FK → users.id (cascade delete)
UNIQUE (inov_chalenge_submission_id, reviewer_id)
created_at
updated_at
```

---

### 5.6 `inov_chalenge_submission_members`

```
id                          bigint PK auto-increment
inov_chalenge_submission_id bigint FK → inov_chalenge_submissions.id (cascade delete)
peran                       string  ('Ketua' | 'Anggota')
nama_lengkap                string(255)
nik_nim_nip                 string nullable
alamat_jalan                string nullable
provinsi                    string nullable
kota_kabupaten              string nullable
kecamatan                   string nullable
kelurahan                   string nullable
kode_pos                    string(10) nullable
```

> No timestamps (matching Comdev's `proposal_members` pattern).

---

### 5.7 `inov_chalenge_submission_files`

```
id                              bigint PK auto-increment
inov_chalenge_submission_id     bigint FK → inov_chalenge_submissions.id (cascade delete)
inov_chalenge_sub_chapter_id    bigint FK → inov_chalenge_sub_chapters.id (cascade delete)
user_id                         bigint FK → users.id
type                            enum('file','link') default 'file'
judul_luaran                    string nullable
status_luaran                   string nullable
file_path                       string nullable
original_filename               string nullable
url                             text nullable
created_at
updated_at
```

---

### 5.8 `inov_chalenge_reviews`

```
id                              bigint PK auto-increment
inov_chalenge_submission_id     bigint FK → inov_chalenge_submissions.id (cascade delete)
inov_chalenge_module_id         bigint FK → inov_chalenge_modules.id (cascade delete)
reviewer_id                     bigint FK → users.id
komentar                        text
penilaian                       text nullable
created_at
updated_at
```

---

### 5.9 `inov_chalenge_submission_module_statuses`

```
id                              bigint PK auto-increment
inov_chalenge_submission_id     bigint FK → inov_chalenge_submissions.id (cascade delete)
inov_chalenge_module_id         bigint FK → inov_chalenge_modules.id (cascade delete)
status                          string default 'proses'
nominal_evaluasi                decimal(15,2) nullable
catatan_admin                   text nullable
UNIQUE (inov_chalenge_submission_id, inov_chalenge_module_id)
created_at
updated_at
```

---

## 6. Entity Relationship Diagram

```
inov_chalenge_sessions
    ├── has many → inov_chalenge_modules
    │       └── has many → inov_chalenge_sub_chapters
    │
    └── has many → inov_chalenge_submissions
            ├── belongs to → users (user_id = dosen ketua)
            ├── many-to-many → users (inov_chalenge_submission_reviewer pivot)
            ├── has many → inov_chalenge_submission_members
            ├── has many → inov_chalenge_submission_files
            │       ├── belongs to → inov_chalenge_sub_chapters
            │       └── belongs to → users (uploader)
            ├── has many → inov_chalenge_reviews
            │       ├── belongs to → inov_chalenge_modules
            │       └── belongs to → users (reviewer)
            └── has many → inov_chalenge_submission_module_statuses
                    └── belongs to → inov_chalenge_modules
```

---

## 7. Workflow Diagrams

### 7.1 Admin Workflow

```
Admin creates session (draft)
    │
    ▼
Admin adds Modules to session
    │
    ▼
Admin adds Sub-chapters to each Module
    │
    ▼
Admin changes session status → "active"
    │
    ▼
Dosen submissions arrive (status: diajukan)
    │
    ▼
Admin views submission list, assigns reviewer(s)
    │  (submission status → sedang_direview)
    ▼
Reviewer posts per-module review
    │
    ▼
Admin updates module-level status (approve/request revision/complete)
    │
    ▼
Admin changes overall submission status → selesai
    │
    ▼
Admin closes session (status: closed)
```

### 7.2 Dosen Workflow

```
Dosen views list of active sessions
    │
    ▼
Dosen selects session → sees modules & sub-chapters
    │
    ▼
Dosen creates submission (status: draft)
    │
    ▼
Dosen fills judul, abstrak, anggota tim, kata_kunci
    │
    ▼
Dosen uploads files / links per sub-chapter
    │
    ▼
Dosen submits proposal (status: draft → diajukan)
    │
    ▼
Dosen tracks status on dashboard
```

### 7.3 Reviewer Workflow

```
Reviewer logs in → sees assigned submissions
    │
    ▼
Reviewer opens submission detail
    │
    ▼
Reviewer posts komentar + penilaian per module
    │
    ▼
Status updated (admin can see reviews)
```

---

## 8. Route Plan

**Route file:** `routes/inovchalange.php` (cleared and rewritten)

### Admin Routes
```
Prefix:     /admin_inovasi/inovchalenge
Middleware: auth, role:admin_inovasi
Name prefix: admin_inovasi.inovchalenge.
```

| Name | Method | URI | Controller |
|---|---|---|---|
| `.sessions.index` | GET | `/` | SessionController@index |
| `.sessions.create` | GET | `/sessions/create` | SessionController@create |
| `.sessions.store` | POST | `/sessions` | SessionController@store |
| `.sessions.show` | GET | `/sessions/{session}` | SessionController@show |
| `.sessions.edit` | GET | `/sessions/{session}/edit` | SessionController@edit |
| `.sessions.update` | PUT | `/sessions/{session}` | SessionController@update |
| `.sessions.destroy` | DELETE | `/sessions/{session}` | SessionController@destroy |
| `.sessions.activate` | PATCH | `/sessions/{session}/activate` | SessionController@activate |
| `.sessions.close` | PATCH | `/sessions/{session}/close` | SessionController@close |
| `.modules.index` | GET | `/sessions/{session}/modules` | ModuleController@index |
| `.modules.store` | POST | `/sessions/{session}/modules` | ModuleController@store |
| `.modules.update` | PUT | `/modules/{module}` | ModuleController@update |
| `.modules.destroy` | DELETE | `/modules/{module}` | ModuleController@destroy |
| `.subchapters.store` | POST | `/modules/{module}/subchapters` | ModuleController@storeSubChapter |
| `.subchapters.update` | PUT | `/subchapters/{subChapter}` | ModuleController@updateSubChapter |
| `.subchapters.destroy` | DELETE | `/subchapters/{subChapter}` | ModuleController@destroySubChapter |
| `.submissions.index` | GET | `/sessions/{session}/submissions` | SubmissionAdminController@index |
| `.submissions.show` | GET | `/sessions/{session}/submissions/{submission}` | SubmissionAdminController@show |
| `.submissions.assign` | POST | `/submissions/{submission}/assign-reviewer` | SubmissionAdminController@assignReviewer |
| `.submissions.updateStatus` | PUT | `/submissions/{submission}/status` | SubmissionAdminController@updateStatus |
| `.submissions.updateModuleStatus` | PUT | `/submissions/{submission}/modules/{module}/status` | SubmissionAdminController@updateModuleStatus |

### Dosen Routes
```
Prefix:     subdirektorat-inovasi/dosen/inovchalenge
Middleware: checked, role:dosen   (inside subdirektorat-inovasi > dosen group)
Name prefix: subdirektorat-inovasi.dosen.inovchalenge.
```

| Name | Method | URI | Controller |
|---|---|---|---|
| `.sessions.index` | GET | `inovchalenge/sessions` | DosenController@sessions |
| `.sessions.show` | GET | `inovchalenge/sessions/{session}` | DosenController@showSession |
| `.submissions.index` | GET | `inovchalenge/submissions` | DosenController@mySubmissions |
| `.submissions.create` | GET | `inovchalenge/sessions/{session}/submissions/create` | DosenController@create |
| `.submissions.store` | POST | `inovchalenge/sessions/{session}/submissions` | DosenController@store |
| `.submissions.show` | GET | `inovchalenge/submissions/{submission}` | DosenController@showSubmission |
| `.submissions.edit` | GET | `inovchalenge/submissions/{submission}/edit` | DosenController@edit |
| `.submissions.update` | PUT | `inovchalenge/submissions/{submission}` | DosenController@update |
| `.submissions.submit` | PATCH | `inovchalenge/submissions/{submission}/submit` | DosenController@submit |
| `.files.store` | POST | `inovchalenge/submissions/{submission}/files` | FileController@store |
| `.files.destroy` | DELETE | `inovchalenge/files/{file}` | FileController@destroy |
| `.files.preview` | GET | `inovchalenge/files/{file}/preview` | FileController@preview |

### Reviewer Routes
```
Prefix:     reviewer_inovchalenge
Middleware: auth, role:reviewer_inovchalenge
Name prefix: reviewer_inovchalenge.
```

| Name | Method | URI | Controller |
|---|---|---|---|
| `.dashboard` | GET | `/dashboard` | ReviewerController@dashboard |
| `.assignments.index` | GET | `/assignments` | ReviewerController@index |
| `.assignments.show` | GET | `/assignments/{submission}` | ReviewerController@show |
| `.reviews.store` | POST | `/assignments/{submission}/modules/{module}/review` | ReviewerController@store |

---

## 9. Controller Plan

**Namespace:** `App\Http\Controllers\InovChalenge\`

| Controller | Location |
|---|---|
| `SessionController` | `app/Http/Controllers/InovChalenge/SessionController.php` |
| `ModuleController` | `app/Http/Controllers/InovChalenge/ModuleController.php` |
| `SubmissionAdminController` | `app/Http/Controllers/InovChalenge/SubmissionAdminController.php` |
| `DosenController` | `app/Http/Controllers/InovChalenge/DosenController.php` |
| `FileController` | `app/Http/Controllers/InovChalenge/FileController.php` |
| `ReviewerController` | `app/Http/Controllers/InovChalenge/ReviewerController.php` |

---

## 10. View Plan

**Base layout:** extends `admin_inovasi.index` (same sidebar/navbar as KATSINOV)

**Admin views** — extends `admin_inovasi.index`
```
resources/views/admin_inovasi/inovchalenge/
├── sessions/
│   ├── index.blade.php      — Session list (table + pagination)
│   ├── create.blade.php     — Create session form
│   ├── edit.blade.php       — Edit session form
│   └── show.blade.php       — Session detail (stats + links)
├── modules/
│   └── index.blade.php      — Module + sub-chapter manager (Alpine.js modals)
└── submissions/
    ├── index.blade.php      — Submissions list (filter by status/prodi/search)
    └── show.blade.php       — Submission detail (files, reviews, reviewer assignment)
```

**Dosen views** — extends dosen layout (under `subdirektorat-inovasi.dosen` view namespace)
```
resources/views/subdirektorat-inovasi/dosen/inovchalenge/
├── sessions/
│   ├── index.blade.php      — Available active sessions for dosen
│   └── show.blade.php       — Session detail + module/sub-chapter overview
└── submissions/
    ├── index.blade.php      — Dosen's own submissions list with status
    ├── create.blade.php     — Create/edit submission form (judul, abstrak, tim, SDGs)
    └── show.blade.php       — Submission detail + file upload per sub-chapter
```

**Reviewer views** — extends reviewer layout
```
resources/views/reviewer_inovchalenge/
├── dashboard.blade.php      — Reviewer dashboard (stats + quick links)
├── assignments/
│   ├── index.blade.php      — Assigned submissions list
│   └── show.blade.php       — Submission detail + per-module review form
```

---

## 11. Model Plan

**Namespace:** `App\Models\`

| Model | Table | Key Relations |
|---|---|---|
| `InovChalengeSession` | `inov_chalenge_sessions` | hasMany modules, hasMany submissions |
| `InovChalengeModule` | `inov_chalenge_modules` | belongsTo session, hasMany subChapters |
| `InovChalengeSubChapter` | `inov_chalenge_sub_chapters` | belongsTo module, hasMany files |
| `InovChalengeSubmission` | `inov_chalenge_submissions` | belongsTo session, belongsTo user, hasMany files, hasMany reviews, belongsToMany reviewers |
| `InovChalengeSubmissionMember` | `inov_chalenge_submission_members` | belongsTo submission |
| `InovChalengeSubmissionFile` | `inov_chalenge_submission_files` | belongsTo submission, belongsTo subChapter |
| `InovChalengeReview` | `inov_chalenge_reviews` | belongsTo submission, belongsTo module, belongsTo reviewer |
| `InovChalengeModuleStatus` | `inov_chalenge_submission_module_statuses` | belongsTo submission, belongsTo module |

---

## 12. Enum: Submission Status

Using a dedicated `App\Enums\InovChalengeStatusEnum`:

```php
draft                    // Dosen belum submit
diajukan                 // Dosen submit, menunggu admin
menunggu_direview        // Admin terima, belum assign reviewer
sedang_direview          // Reviewer sudah diassign
perbaikan_diperlukan     // Admin/reviewer minta revisi
proses_tahap_selanjutnya // Lanjut ke tahap berikutnya
selesai                  // Selesai
```

---

## 13. Role Changes Required

### Migration: Add `reviewer_inovchalenge` to `users.role` enum

A new migration must be created to alter the `users` table `role` column enum to add `reviewer_inovchalenge`.

```php
// In migration up():
DB::statement("ALTER TABLE users MODIFY role ENUM(
    'super_admin','admin_direktorat','admin_pemeringkatan',
    'admin_inovasi','admin_hilirisasi','kepala_direktorat',
    'fakultas','prodi','dosen','kepala_sub_direktorat','wr3',
    'mahasiswa','validator','registered_user','sulitest_user',
    'admin_equity','sub_admin_equity','reviewer_equity',
    'reviewer_hibah','equity_fakultas',
    'reviewer_inovchalenge'   ← NEW
) DEFAULT 'registered_user'");
```

---

## 14. File Storage

Uploaded files stored at: `storage/app/public/inovchalenge/submissions/{submission_id}/{sub_chapter_id}/`

Accessible via: `Storage::url(...)` → `storage/inovchalenge/...`

---

## 15. Navigation Integration

Add "Innovation Challenge" dropdown to `resources/views/admin_inovasi/sidebar.blade.php` after the KATSINOV section.

```
admin_inovasi sidebar
├── Dashboard
├── KATSINOV (existing)
├── Innovation Challenge  ← ADD (Sprint 4)
│   ├── Daftar Sesi
│   └── Laporan
└── Pengaturan
```
