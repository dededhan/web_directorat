# Innovation Challenge — Product Requirements Document (PRD)

> **Version:** 2.0.0  
> **Date:** 2026-02-27  
> **Author:** AI Agent (GitHub Copilot)  
> **Status:** Approved for Implementation

---

## 1. Overview

**Innovation Challenge** is a session-based competition management feature integrated into the `admin_inovasi` panel. Administrators create challenge sessions, each containing **3 fixed Tahap (stages)**. Every Tahap has fully **dynamic form fields** configured by the admin (types: text, textarea, number, date, dropdown, file upload, URL). Tahap 1 additionally includes sections for **anggota tim** (dosen + alumni, with alumni approval flow) and **fakultas**. Dosen fill and submit each Tahap independently; reviewers post per-Tahap comments and scores.

---

## 2. Goals

- Allow `admin_inovasi` to create sessions and configure each of the 3 Tahap with dynamic form fields
- Allow admin to set field types, labels, options, and required flags per field per Tahap
- Allow `dosen` to view active sessions, create submissions, fill each Tahap's dynamic form, add anggota tim (dosen + alumni), and submit per Tahap
- Allow `alumni` to see pending team invitations and approve/reject participation
- Allow admin to assign `reviewer_inovchalenge` users to submissions
- Allow reviewers to post per-Tahap comments and scores
- Track each Tahap's fill/submit/review status independently on both dosen and admin dashboards

---

## 3. Actors & Roles

| Role                     | Responsibility                                                                                       | Scope                       |
| ------------------------ | ---------------------------------------------------------------------------------------------------- | --------------------------- |
| `admin_inovasi`          | Full session CRUD, Tahap + field configuration, reviewer assignment, status management               | In scope — Sprint 1–3       |
| `dosen`                  | View active sessions, create submissions, fill dynamic forms per Tahap, manage tim, submit per Tahap | In scope — Sprint 2         |
| `alumni`                 | Receive team invitation from dosen, approve/reject membership via dashboard                          | In scope — Sprint 2         |
| `reviewer_inovchalenge`  | View assigned submissions, post per-Tahap reviews/scores                                             | In scope — Sprint 3         |
| `sub_admin_inovchalenge` | Delegated admin operations                                                                           | **Out of scope** — deferred |

> **Note:** `reviewer_inovchalenge` is a **new role** and must be added to the `users.role` enum migration (Sprint 0).

---

## 4. Out of Scope (This Version)

- Email / in-app notification system
- Data export (Excel/PDF)
- Dashboard statistics widget on main `admin_inovasi` dashboard
- Sub Admin role

---

## 5. Core Concept: 3 Fixed Tahap with Dynamic Fields

Each session has **exactly 3 Tahap** (not configurable in count). Admin configures the **content** of each Tahap:

```
Session
├── Tahap 1  (has_anggota = true, has_fakultas = true)
│   ├── [Section: Anggota Tim — fixed, always shown]
│   │     └── members: dosen + alumni, alumni must approve
│   ├── [Section: Fakultas — fixed, always shown]
│   └── [Dynamic Fields — admin configures]
│         ├── Field: type=text, label="Judul Proposal", required=true
│         ├── Field: type=textarea, label="Abstrak", required=true
│         ├── Field: type=file, label="Dokumen Proposal", required=true
│         └── ...any field types admin adds
│
├── Tahap 2  (has_anggota = false, has_fakultas = false)
│   └── [Dynamic Fields — admin configures]
│         ├── Field: type=url, label="Link Presentasi"
│         ├── Field: type=number, label="Nominal Dana"
│         └── ...
│
└── Tahap 3  (has_anggota = false, has_fakultas = false)
    └── [Dynamic Fields — admin configures]
          └── ...
```

### Supported Field Types

| Type       | Storage Column                          | Description                       |
| ---------- | --------------------------------------- | --------------------------------- |
| `text`     | `value_text`                            | Single-line input                 |
| `textarea` | `value_text`                            | Multi-line text                   |
| `number`   | `value_text`                            | Numeric input                     |
| `date`     | `value_text`                            | Date picker                       |
| `dropdown` | `value_text`                            | Single-select from options (JSON) |
| `file`     | `value_file_path` + `original_filename` | File upload (PDF, docx, etc.)     |
| `url`      | `value_url`                             | URL / link input                  |

---

## 6. Database Schema

### Naming Convention

All tables use prefix `inov_chalenge_*`.

---

### 6.1 `inov_chalenge_sessions`

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

### 6.2 `inov_chalenge_tahap`

Exactly **3 rows per session** (seeded/created automatically when session is created).

```
id                          bigint PK auto-increment
inov_chalenge_session_id    bigint FK → inov_chalenge_sessions.id (cascade delete)
tahap_ke                    tinyint unsigned  (1, 2, or 3)
nama_tahap                  string(255)        e.g. "Tahap 1 — Proposal Awal"
deskripsi                   text nullable
periode_awal                datetime nullable
periode_akhir               datetime nullable
has_anggota                 boolean default false   (true only for tahap 1)
has_fakultas                boolean default false   (true only for tahap 1)
created_at
updated_at
UNIQUE (inov_chalenge_session_id, tahap_ke)
```

---

### 6.3 `inov_chalenge_tahap_fields`

Dynamic form fields configured by admin per Tahap.

```
id                          bigint PK auto-increment
inov_chalenge_tahap_id      bigint FK → inov_chalenge_tahap.id (cascade delete)
field_label                 string(255)
field_type                  enum('text','textarea','number','date','dropdown','file','url')
field_options               json nullable   (for dropdown: array of option strings)
is_required                 boolean default true
urutan                      tinyint unsigned default 0
created_at
updated_at
```

---

### 6.4 `inov_chalenge_submissions`

One submission per dosen per session.

```
id                          bigint PK auto-increment
inov_chalenge_session_id    bigint FK → inov_chalenge_sessions.id
user_id                     bigint FK → users.id  (dosen ketua tim)
status                      enum('draft','diajukan','menunggu_direview','sedang_direview',
                                  'perbaikan_diperlukan','proses_tahap_selanjutnya','selesai')
                            default 'draft'
reviewer_id                 bigint FK → users.id nullable  (legacy compat)
created_at
updated_at
UNIQUE (inov_chalenge_session_id, user_id)
```

---

### 6.5 `inov_chalenge_submission_tahap`

Tracks per-Tahap submission state (draft = sedang diisi; diajukan = submitted to admin).

```
id                              bigint PK auto-increment
inov_chalenge_submission_id     bigint FK → inov_chalenge_submissions.id (cascade delete)
inov_chalenge_tahap_id          bigint FK → inov_chalenge_tahap.id (cascade delete)
status                          enum('belum_diisi','draft','diajukan') default 'belum_diisi'
submitted_at                    timestamp nullable
admin_status                    enum('menunggu','disetujui','perbaikan','selesai') default 'menunggu'
nominal_evaluasi                decimal(15,2) nullable
catatan_admin                   text nullable
UNIQUE (inov_chalenge_submission_id, inov_chalenge_tahap_id)
created_at
updated_at
```

---

### 6.6 `inov_chalenge_submission_field_values`

Stores answers to each dynamic field.

```
id                                  bigint PK auto-increment
inov_chalenge_submission_id         bigint FK → inov_chalenge_submissions.id (cascade delete)
inov_chalenge_tahap_id              bigint FK → inov_chalenge_tahap.id (cascade delete)
inov_chalenge_tahap_field_id        bigint FK → inov_chalenge_tahap_fields.id (cascade delete)
value_text                          text nullable   (for text/textarea/number/date/dropdown)
value_file_path                     string nullable (for file type)
original_filename                   string nullable (for file type)
value_url                           text nullable   (for url type)
created_at
updated_at
UNIQUE (inov_chalenge_submission_id, inov_chalenge_tahap_field_id)
```

---

### 6.7 `inov_chalenge_submission_members`

Tim anggota (available in Tahap 1 section). Alumni must approve.

```
id                              bigint PK auto-increment
inov_chalenge_submission_id     bigint FK → inov_chalenge_submissions.id (cascade delete)
user_id                         bigint FK → users.id nullable  (if registered user/alumni)
peran                           enum('Ketua','Anggota')
tipe_anggota                    enum('dosen','alumni','eksternal')
nama_lengkap                    string(255)
nik_nim_nip                     string nullable
institusi_fakultas              string nullable
approval_status                 enum('not_required','pending','approved','rejected')
                                default 'not_required'
                                (alumni: starts as 'pending', dosen/eksternal: 'not_required')
responded_at                    timestamp nullable
created_at
updated_at
```

---

### 6.8 `inov_chalenge_submission_reviewer` (pivot)

```
id                              bigint PK auto-increment
inov_chalenge_submission_id     bigint FK → inov_chalenge_submissions.id (cascade delete)
reviewer_id                     bigint FK → users.id (cascade delete)
UNIQUE (inov_chalenge_submission_id, reviewer_id)
created_at
updated_at
```

---

### 6.9 `inov_chalenge_reviews`

Per-Tahap review by reviewer.

```
id                              bigint PK auto-increment
inov_chalenge_submission_id     bigint FK → inov_chalenge_submissions.id (cascade delete)
inov_chalenge_tahap_id          bigint FK → inov_chalenge_tahap.id (cascade delete)
reviewer_id                     bigint FK → users.id
komentar                        text
penilaian                       text nullable
created_at
updated_at
```

---

## 7. Entity Relationship Diagram

```
inov_chalenge_sessions
    ├── has many (3) → inov_chalenge_tahap
    │       └── has many → inov_chalenge_tahap_fields
    │
    └── has many → inov_chalenge_submissions
            ├── belongs to → users (dosen ketua)
            ├── many-to-many → users (inov_chalenge_submission_reviewer pivot)
            ├── has many → inov_chalenge_submission_members
            │       └── belongs to → users (for alumni/dosen)
            ├── has many → inov_chalenge_submission_tahap  [per-Tahap tracking]
            │       ├── belongs to → inov_chalenge_tahap
            │       └── has many → inov_chalenge_submission_field_values
            │               └── belongs to → inov_chalenge_tahap_fields
            └── has many → inov_chalenge_reviews
                    ├── belongs to → inov_chalenge_tahap
                    └── belongs to → users (reviewer)
```

---

## 8. Workflow Diagrams

### 8.1 Admin Workflow

```
Admin creates session (status: draft)
    │
    ▼
[Auto-created] 3 Tahap rows seeded for the session
    │
    ▼
Admin configures each Tahap:
    - nama_tahap, deskripsi, periode_awal/akhir
    - adds dynamic fields (label, type, required, options, order)
    │
    ▼
Admin activates session (status: active)
    │
    ▼
Dosen submissions arrive
    │
    ▼
Admin views submission list → assigns reviewer(s)
    (overall submission status → sedang_direview)
    │
    ▼
Reviewer posts per-Tahap komentar + penilaian
    │
    ▼
Admin updates per-Tahap admin_status (disetujui / perbaikan / selesai)
    │
    ▼
Admin closes session (status: closed)
```

### 8.2 Dosen Workflow

```
Dosen views active sessions list
    │
    ▼
Dosen opens session → sees 3 Tahap overview (locked / open / submitted)
    │
    ▼
Dosen creates submission (auto-creates submission_tahap rows for all 3)
    │
    ▼
Dosen fills Tahap 1:
    ├── Dynamic fields (configured by admin)
    ├── Anggota Tim section:
    │     - add dosen anggota (NIDN lookup)
    │     - add alumni (auto-sends approval request to alumni user)
    │     - add eksternal member (manual entry, no account needed)
    └── Fakultas section
    │
    ▼
Dosen SUBMIT Tahap 1 (submission_tahap.status → diajukan)
    │
    ▼
Alumni (added as anggota) sees pending invitation → APPROVE / REJECT from their dashboard
    │
    ▼
Dosen fills & submits Tahap 2
    │
    ▼
Dosen fills & submits Tahap 3
    │
    ▼
Overall submission status auto-advances based on all Tahap diajukan
    │
    ▼
Dosen tracks status (per Tahap) on their dashboard:
    [Tahap 1: ✅ Diajukan → Disetujui]
    [Tahap 2: 🔵 Diajukan → Menunggu Review]
    [Tahap 3: ⬜ Belum diisi]
```

### 8.3 Alumni Approval Workflow

```
Dosen adds alumni as Anggota → approval_status = 'pending'
    │
    ▼
Alumni logs in → sees "Undangan Tim" on dashboard
    │
    ├── APPROVE → approval_status = 'approved', responded_at = now()
    └── REJECT  → approval_status = 'rejected', responded_at = now()
                  (dosen notified; member remains but marked rejected)
```

### 8.4 Reviewer Workflow

```
Reviewer logs in → sees assigned submissions list
    │
    ▼
Reviewer opens submission → sees submitted Tahap list
    │
    ▼
Per submitted Tahap:
    - View all field values (text answers, files, URLs)
    - View anggota tim (Tahap 1)
    - Post komentar + penilaian
    │
    ▼
Admin sees reviews → updates admin_status per Tahap
```

---

## 9. Route Plan

**Route file:** `routes/inovchalange.php`

### Admin Routes

```
Prefix:     /admin_inovasi/inovchalenge
Middleware: auth, role:admin_inovasi
Name prefix: admin_inovasi.inovchalenge.
```

| Name                             | Method | URI                                              | Controller                                  |
| -------------------------------- | ------ | ------------------------------------------------ | ------------------------------------------- |
| `.sessions.index`                | GET    | `/`                                              | SessionController@index                     |
| `.sessions.create`               | GET    | `/sessions/create`                               | SessionController@create                    |
| `.sessions.store`                | POST   | `/sessions`                                      | SessionController@store                     |
| `.sessions.show`                 | GET    | `/sessions/{session}`                            | SessionController@show                      |
| `.sessions.edit`                 | GET    | `/sessions/{session}/edit`                       | SessionController@edit                      |
| `.sessions.update`               | PUT    | `/sessions/{session}`                            | SessionController@update                    |
| `.sessions.destroy`              | DELETE | `/sessions/{session}`                            | SessionController@destroy                   |
| `.sessions.activate`             | PATCH  | `/sessions/{session}/activate`                   | SessionController@activate                  |
| `.sessions.close`                | PATCH  | `/sessions/{session}/close`                      | SessionController@close                     |
| `.tahap.edit`                    | GET    | `/sessions/{session}/tahap/{tahap}/edit`         | TahapController@edit                        |
| `.tahap.update`                  | PUT    | `/sessions/{session}/tahap/{tahap}`              | TahapController@update                      |
| `.tahap.fields.store`            | POST   | `/tahap/{tahap}/fields`                          | TahapController@storeField                  |
| `.tahap.fields.update`           | PUT    | `/tahap/{tahap}/fields/{field}`                  | TahapController@updateField                 |
| `.tahap.fields.destroy`          | DELETE | `/tahap/{tahap}/fields/{field}`                  | TahapController@destroyField                |
| `.tahap.fields.reorder`          | POST   | `/tahap/{tahap}/fields/reorder`                  | TahapController@reorderFields               |
| `.submissions.index`             | GET    | `/sessions/{session}/submissions`                | SubmissionAdminController@index             |
| `.submissions.show`              | GET    | `/sessions/{session}/submissions/{submission}`   | SubmissionAdminController@show              |
| `.submissions.assign`            | POST   | `/submissions/{submission}/assign-reviewer`      | SubmissionAdminController@assignReviewer    |
| `.submissions.updateStatus`      | PUT    | `/submissions/{submission}/status`               | SubmissionAdminController@updateStatus      |
| `.submissions.updateTahapStatus` | PUT    | `/submissions/{submission}/tahap/{tahap}/status` | SubmissionAdminController@updateTahapStatus |

### Dosen Routes

```
Prefix:     subdirektorat-inovasi/dosen/inovchalenge
Middleware: checked, role:dosen
Name prefix: subdirektorat-inovasi.dosen.inovchalenge.
```

| Name                  | Method | URI                                             | Controller                     |
| --------------------- | ------ | ----------------------------------------------- | ------------------------------ |
| `.sessions.index`     | GET    | `sessions`                                      | DosenController@sessions       |
| `.sessions.show`      | GET    | `sessions/{session}`                            | DosenController@showSession    |
| `.submissions.index`  | GET    | `submissions`                                   | DosenController@mySubmissions  |
| `.submissions.create` | GET    | `sessions/{session}/submissions/create`         | DosenController@create         |
| `.submissions.store`  | POST   | `sessions/{session}/submissions`                | DosenController@store          |
| `.submissions.show`   | GET    | `submissions/{submission}`                      | DosenController@showSubmission |
| `.tahap.show`         | GET    | `submissions/{submission}/tahap/{tahap}`        | DosenController@showTahap      |
| `.tahap.save`         | POST   | `submissions/{submission}/tahap/{tahap}/save`   | DosenController@saveTahap      |
| `.tahap.submit`       | PATCH  | `submissions/{submission}/tahap/{tahap}/submit` | DosenController@submitTahap    |
| `.members.store`      | POST   | `submissions/{submission}/members`              | MemberController@store         |
| `.members.update`     | PUT    | `submissions/{submission}/members/{member}`     | MemberController@update        |
| `.members.destroy`    | DELETE | `submissions/{submission}/members/{member}`     | MemberController@destroy       |

### Alumni Routes

```
Prefix:     subdirektorat-inovasi/alumni/inovchalenge
Middleware: checked, role:alumni
Name prefix: subdirektorat-inovasi.alumni.inovchalenge.
```

| Name                   | Method | URI                            | Controller                   |
| ---------------------- | ------ | ------------------------------ | ---------------------------- |
| `.invitations.index`   | GET    | `invitations`                  | AlumniController@invitations |
| `.invitations.approve` | PATCH  | `invitations/{member}/approve` | AlumniController@approve     |
| `.invitations.reject`  | PATCH  | `invitations/{member}/reject`  | AlumniController@reject      |

### Reviewer Routes

```
Prefix:     reviewer_inovchalenge
Middleware: auth, role:reviewer_inovchalenge
Name prefix: reviewer_inovchalenge.
```

| Name                 | Method | URI                                              | Controller                   |
| -------------------- | ------ | ------------------------------------------------ | ---------------------------- |
| `.dashboard`         | GET    | `/dashboard`                                     | ReviewerController@dashboard |
| `.assignments.index` | GET    | `/assignments`                                   | ReviewerController@index     |
| `.assignments.show`  | GET    | `/assignments/{submission}`                      | ReviewerController@show      |
| `.reviews.store`     | POST   | `/assignments/{submission}/tahap/{tahap}/review` | ReviewerController@store     |
| `.reviews.update`    | PUT    | `/assignments/{submission}/tahap/{tahap}/review` | ReviewerController@update    |

---

## 10. Controller Plan

**Namespace:** `App\Http\Controllers\InovChalenge\`

| Controller                  | Location                          | Responsibility                                                     |
| --------------------------- | --------------------------------- | ------------------------------------------------------------------ |
| `SessionController`         | `…/SessionController.php`         | Session CRUD + status transitions                                  |
| `TahapController`           | `…/TahapController.php`           | Tahap config + dynamic field CRUD                                  |
| `SubmissionAdminController` | `…/SubmissionAdminController.php` | Admin view/manage submissions + reviewer assign + per-Tahap status |
| `DosenController`           | `…/DosenController.php`           | Dosen session browse, submission create/fill/submit per Tahap      |
| `MemberController`          | `…/MemberController.php`          | Add/edit/remove anggota tim, alumni lookup                         |
| `AlumniController`          | `…/AlumniController.php`          | Alumni invitation approval/rejection                               |
| `ReviewerController`        | `…/ReviewerController.php`        | Reviewer dashboard, assignments, post review per Tahap             |

---

## 11. View Plan

**Admin views** — extends `admin_inovasi.index`

```
resources/views/admin_inovasi/inovchalenge/
├── sessions/
│   ├── index.blade.php      — Session list table + status badge
│   ├── create.blade.php     — Create session form
│   ├── edit.blade.php       — Edit session form
│   └── show.blade.php       — Session summary (3-Tahap grid + submission count)
├── tahap/
│   └── edit.blade.php       — Tahap config (nama, deskripsi, periode) +
│                              Dynamic field builder (Alpine.js drag-sortable)
└── submissions/
    ├── index.blade.php      — Submissions list (filter: status, Tahap, search)
    └── show.blade.php       — Submission detail:
                               · Per-Tahap accordion (field values, files)
                               · Anggota tim + approval status (Tahap 1)
                               · Reviewer assign modal
                               · Admin per-Tahap status controls
                               · Review history
```

**Dosen views** — extends dosen layout

```
resources/views/subdirektorat-inovasi/dosen/inovchalenge/
├── sessions/
│   ├── index.blade.php      — Active sessions card grid
│   └── show.blade.php       — Session detail + 3-Tahap progress overview
└── submissions/
    ├── index.blade.php      — Dosen's submissions list with per-Tahap status chips
    ├── show.blade.php       — Submission overview: 3 Tahap progress tracker
    └── tahap.blade.php      — Fill a single Tahap:
                               · Dynamic form fields (rendered by type)
                               · Anggota Tim section (Tahap 1 only)
                               · Fakultas section (Tahap 1 only)
                               · Save draft / Submit buttons
```

**Alumni views** — extends alumni layout

```
resources/views/subdirektorat-inovasi/alumni/inovchalenge/
└── invitations/
    └── index.blade.php      — Pending invitations list + approve/reject buttons
```

**Reviewer views** — extends reviewer layout

```
resources/views/reviewer_inovchalenge/
├── dashboard.blade.php
└── assignments/
    ├── index.blade.php      — Assigned submissions + per-Tahap status summary
    └── show.blade.php       — Submission detail:
                               · Per-Tahap tabs (only submitted Tahap visible)
                               · Field values, files, anggota tim
                               · Review form (komentar + penilaian) per Tahap
```

---

## 12. Model Plan

**Namespace:** `App\Models\`

| Model                          | Table                                   | Key Relations                                                                                        |
| ------------------------------ | --------------------------------------- | ---------------------------------------------------------------------------------------------------- |
| `InovChalengeSession`          | `inov_chalenge_sessions`                | hasMany tahap (3), hasMany submissions                                                               |
| `InovChalengeTahap`            | `inov_chalenge_tahap`                   | belongsTo session, hasMany fields, hasMany submissionTahap                                           |
| `InovChalengeTahapField`       | `inov_chalenge_tahap_fields`            | belongsTo tahap, hasMany fieldValues                                                                 |
| `InovChalengeSubmission`       | `inov_chalenge_submissions`             | belongsTo session, belongsTo user, hasMany submissionTahap, hasMany members, belongsToMany reviewers |
| `InovChalengeSubmissionTahap`  | `inov_chalenge_submission_tahap`        | belongsTo submission, belongsTo tahap, hasMany fieldValues                                           |
| `InovChalengeFieldValue`       | `inov_chalenge_submission_field_values` | belongsTo submissionTahap, belongsTo field                                                           |
| `InovChalengeSubmissionMember` | `inov_chalenge_submission_members`      | belongsTo submission, belongsTo user (nullable)                                                      |
| `InovChalengeReview`           | `inov_chalenge_reviews`                 | belongsTo submission, belongsTo tahap, belongsTo reviewer                                            |

---

## 13. Enum: Submission Status

`App\Enums\InovChalengeStatusEnum`:

```php
draft                    // Submission dibuat, belum ada Tahap yang diajukan
diajukan                 // Minimal 1 Tahap sudah diajukan
menunggu_direview        // Admin terima, belum assign reviewer
sedang_direview          // Reviewer sudah diassign
perbaikan_diperlukan     // Admin/reviewer minta revisi
proses_tahap_selanjutnya // Lanjut ke tahap berikutnya
selesai                  // Seluruh tahap selesai
```

Per-Tahap `admin_status`:

```php
menunggu           // Baru diajukan, belum diproses admin
disetujui          // Admin setujui Tahap ini
perbaikan          // Admin minta perbaikan (dosen bisa edit & re-submit)
selesai            // Tahap ini final
```

---

## 14. Role Changes Required

```php
// Migration up():
DB::statement("ALTER TABLE users MODIFY role ENUM(
    'super_admin','admin_direktorat','admin_pemeringkatan',
    'admin_inovasi','admin_hilirisasi','kepala_direktorat',
    'fakultas','prodi','dosen','kepala_sub_direktorat','wr3',
    'mahasiswa','validator','registered_user','sulitest_user',
    'admin_equity','sub_admin_equity','reviewer_equity',
    'reviewer_hibah','equity_fakultas',
    'reviewer_inovchalenge'   -- NEW
) DEFAULT 'registered_user'");
```

> `alumni` role is assumed to already exist in the enum. Verify before migration.

---

## 15. File Storage

Uploaded files stored at:
`storage/app/public/inovchalenge/submissions/{submission_id}/tahap_{tahap_ke}/{field_id}/`

Accessible via: `Storage::url(...)` → `/storage/inovchalenge/...`

---

## 16. Navigation Integration

Add "Innovation Challenge" dropdown to `resources/views/admin_inovasi/sidebar.blade.php` after the KATSINOV section.

```
admin_inovasi sidebar
├── Dashboard
├── KATSINOV (existing)
├── Innovation Challenge  ← ADD (Sprint 4)
│   ├── Daftar Sesi       → admin_inovasi.inovchalenge.sessions.index
│   └── Laporan           (deferred)
└── Pengaturan
```

---

## 17. Key Design Decisions

| Decision                                      | Rationale                                                                                     |
| --------------------------------------------- | --------------------------------------------------------------------------------------------- |
| 3 Tahap fixed (not dynamic count)             | Simplicity; each Tahap has semantic meaning in the competition flow                           |
| Fields dynamic per Tahap                      | Admin can tailor each stage without code changes                                              |
| Tahap submitted independently                 | Allows partial progress tracking; admin can review Tahap 1 while dosen still works on Tahap 2 |
| Alumni approval in-app                        | Alumni are registered users; they see invitation in their dashboard, no email dependency      |
| Field values stored flat (one row per field)  | Easy to query, render, and validate; avoids JSON blob issues                                  |
| File stored per field (not per "sub-chapter") | Cleaner 1:1 mapping; field_type=file is self-contained                                        |
