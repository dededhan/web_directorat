# Innovation Challenge — Sprint Tracker

> **Feature:** Innovation Challenge (`inovchalenge`)  
> **Start Date:** 2026-02-27  
> **Last Updated:** 2026-02-27  
> **PRD Reference:** [00-overview.md](00-overview.md)

---

## Status Legend

| Symbol | Meaning |
|---|---|
| ⬜ | Not Started |
| 🔵 | In Progress |
| ✅ | Done |
| ❌ | Blocked |
| ⏭️ | Deferred / Out of Scope |

---

## Sprint 0 — Database & Infrastructure

**Goal:** Create all database tables and add the new reviewer role to the users enum.  
**Status:** ⬜ Not Started

### Tasks

| # | Task | File | Status |
|---|---|---|---|
| S0-01 | Migration: `inov_chalenge_sessions` | `database/migrations/XXXX_create_inov_chalenge_sessions_table.php` | ⬜ |
| S0-02 | Migration: `inov_chalenge_modules` | `database/migrations/XXXX_create_inov_chalenge_modules_table.php` | ⬜ |
| S0-03 | Migration: `inov_chalenge_sub_chapters` | `database/migrations/XXXX_create_inov_chalenge_sub_chapters_table.php` | ⬜ |
| S0-04 | Migration: `inov_chalenge_submissions` | `database/migrations/XXXX_create_inov_chalenge_submissions_table.php` | ⬜ |
| S0-05 | Migration: `inov_chalenge_submission_reviewer` pivot | `database/migrations/XXXX_create_inov_chalenge_submission_reviewer_table.php` | ⬜ |
| S0-06 | Migration: `inov_chalenge_submission_members` | `database/migrations/XXXX_create_inov_chalenge_submission_members_table.php` | ⬜ |
| S0-07 | Migration: `inov_chalenge_submission_files` | `database/migrations/XXXX_create_inov_chalenge_submission_files_table.php` | ⬜ |
| S0-08 | Migration: `inov_chalenge_reviews` | `database/migrations/XXXX_create_inov_chalenge_reviews_table.php` | ⬜ |
| S0-09 | Migration: `inov_chalenge_submission_module_statuses` | `database/migrations/XXXX_create_inov_chalenge_submission_module_statuses_table.php` | ⬜ |
| S0-10 | Migration: Add `reviewer_inovchalenge` to `users.role` enum | `database/migrations/XXXX_add_reviewer_inovchalenge_to_users_role_enum.php` | ⬜ |
| S0-11 | Enum class: `InovChalengeStatusEnum` | `app/Enums/InovChalengeStatusEnum.php` | ⬜ |
| S0-12 | Run `php artisan migrate` — verify all 9 tables created | CLI | ⬜ |

### Acceptance Criteria
- [ ] `php artisan migrate` runs without errors
- [ ] All 9 `inov_chalenge_*` tables exist in the database
- [ ] `users.role` enum includes `reviewer_inovchalenge`
- [ ] `InovChalengeStatusEnum` class is importable

---

## Sprint 1 — Admin Session & Module Management

**Goal:** Admin can create/edit/delete sessions and configure modules + sub-chapters.  
**Dependencies:** Sprint 0 complete  
**Status:** ⬜ Not Started

### Tasks

| # | Task | File | Status |
|---|---|---|---|
| S1-01 | Model: `InovChalengeSession` | `app/Models/InovChalengeSession.php` | ⬜ |
| S1-02 | Model: `InovChalengeModule` | `app/Models/InovChalengeModule.php` | ⬜ |
| S1-03 | Model: `InovChalengeSubChapter` | `app/Models/InovChalengeSubChapter.php` | ⬜ |
| S1-04 | Controller: `SessionController` (index, create, store, show, edit, update, destroy, activate, close) | `app/Http/Controllers/InovChalenge/SessionController.php` | ⬜ |
| S1-05 | Controller: `ModuleController` (index, store, update, destroy + sub-chapter CRUD) | `app/Http/Controllers/InovChalenge/ModuleController.php` | ⬜ |
| S1-06 | View: `sessions/index.blade.php` — session list table with status badge, pagination | `resources/views/admin_inovasi/inovchalenge/sessions/index.blade.php` | ⬜ |
| S1-07 | View: `sessions/create.blade.php` — create form (nama_sesi, deskripsi, dana_maksimal, periode, anggota) | `resources/views/admin_inovasi/inovchalenge/sessions/create.blade.php` | ⬜ |
| S1-08 | View: `sessions/edit.blade.php` — edit form (same fields + status change) | `resources/views/admin_inovasi/inovchalenge/sessions/edit.blade.php` | ⬜ |
| S1-09 | View: `sessions/show.blade.php` — session summary cards + quick links | `resources/views/admin_inovasi/inovchalenge/sessions/show.blade.php` | ⬜ |
| S1-10 | View: `modules/index.blade.php` — module + sub-chapter manager (Alpine.js modals, drag-order) | `resources/views/admin_inovasi/inovchalenge/modules/index.blade.php` | ⬜ |
| S1-11 | Routes: Admin session + module routes in `inovchalange.php` | `routes/inovchalange.php` | ⬜ |

### Acceptance Criteria
- [ ] Admin can visit `/admin_inovasi/inovchalenge` and see session list (empty state handled)
- [ ] Admin can create a new session with all fields validated
- [ ] Admin can edit session name, dates, status (draft → active → closed)
- [ ] Admin can delete a session (also deletes modules/sub-chapters via cascade)
- [ ] Admin can visit `/admin_inovasi/inovchalenge/sessions/{id}/modules`
- [ ] Admin can add/edit/delete modules within a session
- [ ] Admin can add/edit/delete sub-chapters within a module
- [ ] Sub-chapters have optional date window (periode_awal/akhir) and is_wajib toggle

---

## Sprint 2 — Dosen Submission Flow

**Goal:** Dosen can view active sessions, create proposals, upload files per sub-chapter, and submit.  
**Dependencies:** Sprint 1 complete  
**Status:** ⬜ Not Started

### Tasks

| # | Task | File | Status |
|---|---|---|---|
| S2-01 | Model: `InovChalengeSubmission` | `app/Models/InovChalengeSubmission.php` | ⬜ |
| S2-02 | Model: `InovChalengeSubmissionMember` | `app/Models/InovChalengeSubmissionMember.php` | ⬜ |
| S2-03 | Model: `InovChalengeSubmissionFile` | `app/Models/InovChalengeSubmissionFile.php` | ⬜ |
| S2-04 | Controller: `DosenController` (sessions list, show session, my submissions, create, store, show, edit, update, submit) | `app/Http/Controllers/InovChalenge/DosenController.php` | ⬜ |
| S2-05 | Controller: `FileController` (store, destroy, preview) | `app/Http/Controllers/InovChalenge/FileController.php` | ⬜ |
| S2-06 | View: dosen sessions index — active sessions card grid | `resources/views/subdirektorat-inovasi/dosen/inovchalenge/sessions/index.blade.php` | ⬜ |
| S2-07 | View: dosen sessions show — session detail, module/sub-chapter overview, create submission btn | `resources/views/subdirektorat-inovasi/dosen/inovchalenge/sessions/show.blade.php` | ⬜ |
| S2-08 | View: dosen submissions index — own submissions list with status tracking | `resources/views/subdirektorat-inovasi/dosen/inovchalenge/submissions/index.blade.php` | ⬜ |
| S2-09 | View: dosen submissions create — proposal form (judul, abstrak, anggota, kata_kunci, SDGs) | `resources/views/subdirektorat-inovasi/dosen/inovchalenge/submissions/create.blade.php` | ⬜ |
| S2-10 | View: dosen submissions show — proposal detail with per-sub-chapter file upload sections | `resources/views/subdirektorat-inovasi/dosen/inovchalenge/submissions/show.blade.php` | ⬜ |
| S2-11 | Routes: Dosen route group in `inovchalange.php` (inside `subdirektorat-inovasi/dosen` group) | `routes/inovchalange.php` | ⬜ |
| S2-12 | File storage config: `storage/app/public/inovchalenge/` | `config/filesystems.php` or storage symlink | ⬜ |

### Acceptance Criteria
- [ ] Dosen can visit dosen sessions list and see all `active` sessions
- [ ] Dosen cannot see `draft` or `closed` sessions
- [ ] Dosen can create a submission for an active session (only one per session per dosen)
- [ ] Dosen can add/edit tim anggota (min/max enforced from session settings)
- [ ] Dosen can upload file or add URL link per sub-chapter
- [ ] Dosen can submit the proposal (status changes from draft → diajukan)
- [ ] Dosen cannot edit after submission unless admin sets status back
- [ ] File preview/download works for dosen's own files

---

## Sprint 3 — Admin Review + Reviewer Portal

**Goal:** Admin can view and manage submissions; reviewer can post per-module reviews.  
**Dependencies:** Sprint 2 complete  
**Status:** ⬜ Not Started

### Tasks

| # | Task | File | Status |
|---|---|---|---|
| S3-01 | Model: `InovChalengeReview` | `app/Models/InovChalengeReview.php` | ⬜ |
| S3-02 | Model: `InovChalengeModuleStatus` | `app/Models/InovChalengeModuleStatus.php` | ⬜ |
| S3-03 | Controller: `SubmissionAdminController` (index, show, assignReviewer, updateStatus, updateModuleStatus) | `app/Http/Controllers/InovChalenge/SubmissionAdminController.php` | ⬜ |
| S3-04 | Controller: `ReviewerController` (index, show, store review) | `app/Http/Controllers/InovChalenge/ReviewerController.php` | ⬜ |
| S3-05 | View: `submissions/index.blade.php` — submissions list (filter: status, session, search) | `resources/views/admin_inovasi/inovchalenge/submissions/index.blade.php` | ⬜ |
| S3-06 | View: `submissions/show.blade.php` — submission detail (files per sub-chapter, reviewer assign modal, module status, reviews) | `resources/views/admin_inovasi/inovchalenge/submissions/show.blade.php` | ⬜ |
| S3-07 | View: reviewer dashboard | `resources/views/reviewer_inovchalenge/dashboard.blade.php` | ⬜ |
| S3-08 | View: reviewer assignments index — assigned submissions list | `resources/views/reviewer_inovchalenge/assignments/index.blade.php` | ⬜ |
| S3-09 | View: reviewer assignments show — submission detail + per-module review form | `resources/views/reviewer_inovchalenge/assignments/show.blade.php` | ⬜ |
| S3-10-r | Routes: Reviewer route group in `inovchalange.php` (prefix: `reviewer_inovchalenge`) | `routes/inovchalange.php` | ⬜ |
| S3-11 | Block reviewer removal if they already posted a review (same as Comdev) | `SubmissionAdminController@assignReviewer` | ⬜ |

### Acceptance Criteria
- [ ] Admin can see all submissions for a session with filter by status
- [ ] Admin can open submission detail and see all uploaded files grouped by module/sub-chapter
- [ ] Admin can assign one or more `reviewer_inovchalenge` users to a submission
- [ ] Admin can change submission status (dropdown per submission)
- [ ] Admin can change per-module status (proses / disetujui / perbaikan / selesai)
- [ ] Reviewer can log in and see their assigned submissions list
- [ ] Reviewer can post komentar + penilaian per module
- [ ] Reviewer with existing reviews cannot be removed from submission

---

## Sprint 4 — Navigation Integration

**Goal:** Add Innovation Challenge link to admin_inovasi sidebar.  
**Dependencies:** Sprint 1 complete (routes registered)  
**Status:** ⬜ Not Started

### Tasks

| # | Task | File | Status |
|---|---|---|---|
| S4-01 | Add "Innovation Challenge" nav item with dropdown to sidebar | `resources/views/admin_inovasi/sidebar.blade.php` | ⬜ |

### Acceptance Criteria
- [ ] "Innovation Challenge" nav group appears in sidebar after KATSINOV
- [ ] Dropdown items: Daftar Sesi → `admin_inovasi.inovchalenge.sessions.index`
- [ ] Active state highlights correctly when on any `admin_inovasi.inovchalenge.*` route

---

## Backlog (Deferred)

| Item | Description | Target Sprint |
|---|---|---|
| Sub Admin role | `sub_admin_inovchalenge` — limited admin access | Future |
| Alumni participation | `alumni` role, same flow as dosen | Future |
| Data export | Excel/PDF export of submissions | Future |
| Dashboard stats widget | Inject InovChalenge stats into `admin_inovasi` dashboard | Future |
| Logbook | Per-submission activity log (like Comdev) | Future |
| Notification system | Email/in-app notifications on status change | Future |
| Session analytics / reports | Laporan view per session | Future |

---

## Cleanup Note

The following files from a **previous failed attempt** exist in the codebase and should be **ignored** (not deleted yet, but never referenced by new code):

| Type | Path | Note |
|---|---|---|
| Models | `app/Models/InovChallenge*.php` (7 files) | Old, different naming convention |
| Controllers | `app/Http/Controllers/InovChallenge/*.php` | Old namespace, references missing tables |
| Views | `resources/views/inov_challenge/` | Separate layout, not integrated |
| Config | `config/inov_challenge.php` | Old references |

**New code uses:**
- Model names: `InovChalenge*` (one-L "chalenge")
- Namespace: `App\Http\Controllers\InovChalenge\`
- View path: `resources/views/admin_inovasi/inovchalenge/`
- Table prefix: `inov_chalenge_*`

---

## Progress Summary

| Sprint | Goal | Status | Completion |
|---|---|---|---|
| Sprint 0 | Database & Infrastructure | ⬜ Not Started | 0 / 12 |
| Sprint 1 | Admin Session & Module Management | ⬜ Not Started | 0 / 11 |
| Sprint 2 | Dosen Submission Flow | ⬜ Not Started | 0 / 12 |
| Sprint 3 | Admin Review + Reviewer Portal | ⬜ Not Started | 0 / 11 |
| Sprint 4 | Navigation Integration | ⬜ Not Started | 0 / 1 |
| **Total** | | | **0 / 47** |
