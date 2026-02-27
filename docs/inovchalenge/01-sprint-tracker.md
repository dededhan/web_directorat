# Innovation Challenge — Sprint Tracker

> **Feature:** Innovation Challenge (`inovchalenge`)
> **Version:** 2.0.0
> **Start Date:** 2026-02-27
> **Last Updated:** 2026-02-27
> **PRD Reference:** [00-overview.md](00-overview.md)

---

## Status Legend

| Symbol | Meaning                 |
| ------ | ----------------------- |
| ⬜     | Not Started             |
| 🔵     | In Progress             |
| ✅     | Done                    |
| ❌     | Blocked                 |
| ⏭️     | Deferred / Out of Scope |

---

## Sprint 0 — Database & Infrastructure

**Goal:** Create all database tables, enum class, and add the new reviewer role.
**Status:** ✅ Done

### Tasks

| #     | Task                                                                         | File                                                                                           | Status |
| ----- | ---------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------- | ------ |
| S0-01 | Migration: `inov_chalenge_sessions`                                          | `database/migrations/2026_02_27_160001_create_inov_chalenge_sessions_table.php`                | ✅     |
| S0-02 | Migration: `inov_chalenge_tahap` (3-per-session, seeded on session create)   | `database/migrations/2026_02_27_160002_create_inov_chalenge_tahap_table.php`                   | ✅     |
| S0-03 | Migration: `inov_chalenge_tahap_fields` (dynamic form fields)                | `database/migrations/2026_02_27_160003_create_inov_chalenge_tahap_fields_table.php`            | ✅     |
| S0-04 | Migration: `inov_chalenge_submissions`                                       | `database/migrations/2026_02_27_160004_create_inov_chalenge_submissions_table.php`             | ✅     |
| S0-05 | Migration: `inov_chalenge_submission_tahap` (per-Tahap status tracking)      | `database/migrations/2026_02_27_160005_create_inov_chalenge_submission_tahap_table.php`        | ✅     |
| S0-06 | Migration: `inov_chalenge_submission_field_values` (dynamic answers)         | `database/migrations/2026_02_27_160006_create_inov_chalenge_submission_field_values_table.php` | ✅     |
| S0-07 | Migration: `inov_chalenge_submission_members` (with alumni approval columns) | `database/migrations/2026_02_27_160007_create_inov_chalenge_submission_members_table.php`      | ✅     |
| S0-08 | Migration: `inov_chalenge_submission_reviewer` pivot                         | `database/migrations/2026_02_27_160008_create_inov_chalenge_submission_reviewer_table.php`     | ✅     |
| S0-09 | Migration: `inov_chalenge_reviews` (per Tahap)                               | `database/migrations/2026_02_27_160009_create_inov_chalenge_reviews_table.php`                 | ✅     |
| S0-10 | Migration: Add `alumni` + `reviewer_inovchalenge` to `users.role` enum       | `database/migrations/2026_02_27_160010_add_inovchalenge_roles_to_users_table.php`              | ✅     |
| S0-11 | Verify `alumni` exists in `users.role` enum (check existing migration)       | CLI / existing migrations                                                                      | ✅     |
| S0-12 | Enum class: `InovChalengeStatusEnum` + `InovChalengeTahapStatusEnum`         | `app/Enums/InovChalengeStatusEnum.php`, `app/Enums/InovChalengeTahapStatusEnum.php`            | ✅     |
| S0-13 | Run `php artisan migrate` — verify all tables created                        | CLI                                                                                            | ✅     |

### Acceptance Criteria

- [x] `php artisan migrate` runs without errors
- [x] All `inov_chalenge_*` tables exist (sessions, tahap, tahap_fields, submissions, submission_tahap, submission_field_values, submission_members, submission_reviewer, reviews)
- [x] `users.role` enum includes `reviewer_inovchalenge` and `alumni`
- [x] `InovChalengeStatusEnum` class is importable

---

## Sprint 1 — Admin Session & Tahap Field Builder

**Goal:** Admin can create/edit sessions and configure dynamic form fields per Tahap.
**Dependencies:** Sprint 0 complete
**Status:** ✅ Done

### Tasks

| #     | Task                                                                                                                                                                                              | File                                                                   | Status |
| ----- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------- | ------ |
| S1-01 | Model: `InovChalengeSession` (hasMany tahap x3, hasMany submissions)                                                                                                                              | `app/Models/InovChalengeSession.php`                                   | ✅     |
| S1-02 | Model: `InovChalengeTahap` (belongsTo session, hasMany fields, has_anggota/has_fakultas flags)                                                                                                    | `app/Models/InovChalengeTahap.php`                                     | ✅     |
| S1-03 | Model: `InovChalengeTahapField` (belongsTo tahap, field_type enum cast)                                                                                                                           | `app/Models/InovChalengeTahapField.php`                                | ✅     |
| S1-04 | Controller: `SessionController` (index, create, store, show, edit, update, destroy, activate, close)                                                                                              | `app/Http/Controllers/InovChalenge/SessionController.php`              | ✅     |
| S1-05 | Controller: `TahapController` (edit tahap meta, store/update/destroy/reorder fields)                                                                                                              | `app/Http/Controllers/InovChalenge/TahapController.php`                | ✅     |
| S1-06 | View: `sessions/index.blade.php` — session list table with status badge, pagination                                                                                                               | `resources/views/admin_inovasi/inovchalenge/sessions/index.blade.php`  | ✅     |
| S1-07 | View: `sessions/create.blade.php` — create form (nama_sesi, deskripsi, dana_maks, periode, min/max anggota)                                                                                       | `resources/views/admin_inovasi/inovchalenge/sessions/create.blade.php` | ✅     |
| S1-08 | View: `sessions/edit.blade.php` — edit form + status control                                                                                                                                      | `resources/views/admin_inovasi/inovchalenge/sessions/edit.blade.php`   | ✅     |
| S1-09 | View: `sessions/show.blade.php` — session summary: 3-Tahap grid with edit links + submission count                                                                                                | `resources/views/admin_inovasi/inovchalenge/sessions/show.blade.php`   | ✅     |
| S1-10 | View: `tahap/edit.blade.php` — Tahap config (nama, deskripsi, periode) + **dynamic field builder** (Alpine.js: add/edit/delete/drag-sort fields, type selector shows options editor for dropdown) | `resources/views/admin_inovasi/inovchalenge/tahap/edit.blade.php`      | ✅     |
| S1-11 | Routes: Admin session + Tahap routes in `inovchalange.php`                                                                                                                                        | `routes/inovchalange.php`                                              | ✅     |

### Acceptance Criteria

- [x] Admin visits `/admin_inovasi/inovchalenge` — sees session list with empty state
- [x] Admin creates a session → 3 `inov_chalenge_tahap` rows auto-seeded
- [x] Admin edits session name, dates, status (draft → active → closed)
- [x] Admin deletes a session → cascades to all Tahap, fields, submissions
- [x] Admin opens Tahap edit page for any of the 3 Tahap
- [x] Admin adds a field: picks type (text/textarea/number/date/dropdown/file/url), sets label, required, order
- [x] Dropdown type shows an "options" editor (add/remove option strings)
- [x] Admin reorders fields via drag (PATCH reorder endpoint)
- [x] Admin deletes a field
- [x] Tahap 1 shows `has_anggota` + `has_fakultas` toggles (read-only or editable flags)

---

## Sprint 2 — Dosen Submission Flow + Alumni Approval

**Goal:** Dosen fill each Tahap's dynamic form, manage tim, submit per Tahap. Alumni approve/reject invitations.
**Dependencies:** Sprint 1 complete
**Status:** ✅ Done

### Tasks

| #     | Task                                                                                                                                                                                                         | File                                                                                    | Status |
| ----- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | --------------------------------------------------------------------------------------- | ------ |
| S2-01 | Model: `InovChalengeSubmission` (hasMany submissionTahap, hasMany members, belongsToMany reviewers)                                                                                                          | `app/Models/InovChalengeSubmission.php`                                                 | ✅     |
| S2-02 | Model: `InovChalengeSubmissionTahap` (belongsTo submission + tahap, hasMany fieldValues)                                                                                                                     | `app/Models/InovChalengeSubmissionTahap.php`                                            | ✅     |
| S2-03 | Model: `InovChalengeFieldValue` (belongsTo submissionTahap + field)                                                                                                                                          | `app/Models/InovChalengeFieldValue.php`                                                 | ✅     |
| S2-04 | Model: `InovChalengeSubmissionMember` (belongsTo submission, belongsTo user nullable, approval_status)                                                                                                       | `app/Models/InovChalengeSubmissionMember.php`                                           | ✅     |
| S2-05 | Controller: `DosenController` (sessions, showSession, mySubmissions, create, store, showSubmission, showTahap, saveTahap, submitTahap)                                                                       | `app/Http/Controllers/InovChalenge/DosenController.php`                                 | ✅     |
| S2-06 | Controller: `MemberController` (store, update, destroy — handles dosen/alumni/eksternal)                                                                                                                     | `app/Http/Controllers/InovChalenge/MemberController.php`                                | ✅     |
| S2-07 | Controller: `AlumniController` (invitations index, approve, reject)                                                                                                                                          | `app/Http/Controllers/InovChalenge/AlumniController.php`                                | ✅     |
| S2-08 | View: dosen `sessions/index.blade.php` — active sessions card grid                                                                                                                                           | `resources/views/subdirektorat-inovasi/dosen/inovchalenge/sessions/index.blade.php`     | ✅     |
| S2-09 | View: dosen `sessions/show.blade.php` — session detail + 3-Tahap progress overview + "Mulai Proposal" button                                                                                                 | `resources/views/subdirektorat-inovasi/dosen/inovchalenge/sessions/show.blade.php`      | ✅     |
| S2-10 | View: dosen `submissions/index.blade.php` — own submissions list with per-Tahap status chips                                                                                                                 | `resources/views/subdirektorat-inovasi/dosen/inovchalenge/submissions/index.blade.php`  | ✅     |
| S2-11 | View: dosen `submissions/show.blade.php` — 3-Tahap progress tracker (belum diisi / draft / diajukan / status admin)                                                                                          | `resources/views/subdirektorat-inovasi/dosen/inovchalenge/submissions/show.blade.php`   | ✅     |
| S2-12 | View: dosen `submissions/tahap.blade.php` — fill a single Tahap: dynamic form renderer (per field type) + Anggota Tim section (Tahap 1 only) + Fakultas section (Tahap 1 only) + Save draft / Submit buttons | `resources/views/subdirektorat-inovasi/dosen/inovchalenge/submissions/tahap.blade.php`  | ✅     |
| S2-13 | View: alumni `invitations/index.blade.php` — pending invitations list with session/submission info + Approve/Reject buttons                                                                                  | `resources/views/subdirektorat-inovasi/alumni/inovchalenge/invitations/index.blade.php` | ✅     |
| S2-14 | Routes: Dosen + Alumni route groups in `inovchalange.php`                                                                                                                                                    | `routes/inovchalange.php`                                                               | ✅     |
| S2-15 | File storage: ensure `storage/app/public/inovchalenge/` is writable, storage link exists                                                                                                                     | CLI / `config/filesystems.php`                                                          | ✅     |

### Acceptance Criteria

- [x] Dosen sees only `active` sessions (draft/closed hidden)
- [x] Creating a submission auto-creates 3 `inov_chalenge_submission_tahap` rows (status: `belum_diisi`)
- [x] Only one submission per dosen per session (unique constraint enforced)
- [x] Dosen fills and saves Tahap form as draft (`save` → `submission_tahap.status = draft`)
- [x] Each field type renders correctly (text, textarea, number, date, dropdown, file upload, URL input)
- [x] File upload saves to `storage/app/public/inovchalenge/submissions/{id}/tahap_{n}/{field_id}/`
- [x] Dosen submits Tahap → `submission_tahap.status = diajukan`, `submitted_at` set, form becomes read-only
- [x] Tahap 1 shows Anggota Tim section: add dosen (lookup by NIDN), add alumni (lookup by user), add eksternal (manual)
- [x] Adding an alumni member creates record with `approval_status = pending`
- [x] Alumni logs in → sees "Undangan Tim" panel → can approve or reject
- [x] Approval updates `approval_status` and `responded_at`; visible to dosen in Tahap 1 view
- [x] Tahap 1 shows Fakultas section
- [x] Dosen cannot re-edit a submitted Tahap unless admin sets `admin_status = perbaikan`
- [x] Submission show page renders 3-Tahap tracker with correct badge per status

---

## Sprint 3 — Admin Submission Management + Reviewer Portal

**Goal:** Admin manages submissions and per-Tahap status; reviewers post per-Tahap reviews.
**Dependencies:** Sprint 2 complete
**Status:** ✅ Done

### Tasks

| #     | Task                                                                                                                                                                                    | File                                                                     | Status |
| ----- | --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------ | ------ |
| S3-01 | Model: `InovChalengeReview` (belongsTo submission + tahap + reviewer)                                                                                                                   | `app/Models/InovChalengeReview.php`                                      | ✅     |
| S3-02 | Controller: `SubmissionAdminController` (index, show, assignReviewer, updateStatus, updateTahapStatus)                                                                                  | `app/Http/Controllers/InovChalenge/SubmissionAdminController.php`        | ✅     |
| S3-03 | Controller: `ReviewerController` (dashboard, index, show, store/update review per Tahap)                                                                                                | `app/Http/Controllers/InovChalenge/ReviewerController.php`               | ✅     |
| S3-04 | View: admin `submissions/index.blade.php` — submissions list (filter: status, Tahap status, search)                                                                                     | `resources/views/admin_inovasi/inovchalenge/submissions/index.blade.php` | ✅     |
| S3-05 | View: admin `submissions/show.blade.php` — submission detail: per-Tahap accordion (field values, files, anggota), reviewer assign modal, admin per-Tahap status controls, reviews panel | `resources/views/admin_inovasi/inovchalenge/submissions/show.blade.php`  | ✅     |
| S3-06 | View: reviewer `dashboard.blade.php` — stats (assigned, reviewed, pending)                                                                                                              | `resources/views/reviewer_inovchalenge/dashboard.blade.php`              | ✅     |
| S3-07 | View: reviewer `assignments/index.blade.php` — assigned submissions list with per-Tahap progress chips                                                                                  | `resources/views/reviewer_inovchalenge/assignments/index.blade.php`      | ✅     |
| S3-08 | View: reviewer `assignments/show.blade.php` — per-Tahap tabs: field values + anggota (Tahap 1) + review form (komentar + penilaian)                                                     | `resources/views/reviewer_inovchalenge/assignments/show.blade.php`       | ✅     |
| S3-09 | Routes: Reviewer route group in `inovchalange.php`                                                                                                                                      | `routes/inovchalange.php`                                                | ✅     |
| S3-10 | Block reviewer removal if they already posted a review for any Tahap                                                                                                                    | `SubmissionAdminController@assignReviewer`                               | ✅     |

### Acceptance Criteria

- [x] Admin sees all submissions for a session with status filters
- [x] Admin opens submission detail → per-Tahap accordion shows submitted field values, file download links, anggota + alumni approval status (Tahap 1)
- [x] Admin assigns one or more `reviewer_inovchalenge` users to a submission
- [x] Admin changes overall submission status via dropdown
- [x] Admin sets per-Tahap `admin_status` (menunggu / disetujui / perbaikan / selesai)
- [x] Setting `admin_status = perbaikan` unlocks that Tahap for dosen re-edit
- [x] Reviewer logs in → sees assigned submissions
- [x] Reviewer opens submission → sees tabs for each submitted Tahap only
- [x] Reviewer posts komentar + penilaian per Tahap → saved as `inov_chalenge_reviews` row
- [x] Reviewer with existing reviews cannot be unassigned

---

## Sprint 4 — Navigation Integration

**Goal:** Add Innovation Challenge link to admin_inovasi sidebar.
**Dependencies:** Sprint 1 complete (routes registered)
**Status:** ✅ Done

### Tasks

| #     | Task                                                                           | File                                              | Status |
| ----- | ------------------------------------------------------------------------------ | ------------------------------------------------- | ------ |
| S4-01 | Add "Innovation Challenge" nav group with dropdown to sidebar (after KATSINOV) | `resources/views/admin_inovasi/sidebar.blade.php` | ✅     |

### Acceptance Criteria

- [x] "Innovation Challenge" nav group appears in sidebar after KATSINOV section
- [x] Dropdown items: "Daftar Sesi" + "Submissions" with correct route links
- [x] Active state highlights when on any `admin_inovasi.inovchalenge.*` route

---

## Backlog (Deferred)

| Item                     | Description                                                                | Target Sprint |
| ------------------------ | -------------------------------------------------------------------------- | ------------- |
| Sub Admin role           | `sub_admin_inovchalenge` — limited admin access                            | Future        |
| Data export              | Excel/PDF export of submissions and reviews                                | Future        |
| Dashboard stats widget   | InovChalenge stats on `admin_inovasi` dashboard                            | Future        |
| Logbook                  | Per-submission activity log                                                | Future        |
| Notification system      | Email/in-app on status change + alumni invitation                          | Future        |
| Session analytics        | Laporan view per session                                                   | Future        |
| Re-submission lock rules | Lock dosen from submitting Tahap 2 before Tahap 1 approved (optional gate) | Future        |

---

## Cleanup Note

The following files from a **previous failed attempt** exist in the codebase and must **not** be referenced by new code:

| Type        | Path                                       | Note                                     |
| ----------- | ------------------------------------------ | ---------------------------------------- |
| Models      | `app/Models/InovChallenge*.php` (7 files)  | Old naming (double-L), different schema  |
| Controllers | `app/Http/Controllers/InovChallenge/*.php` | Old namespace, references missing tables |
| Views       | `resources/views/inov_challenge/`          | Separate layout, not integrated          |
| Config      | `config/inov_challenge.php`                | Old references                           |

**New code uses:**

- Model names: `InovChalenge*` (one-L "chalenge")
- Namespace: `App\Http\Controllers\InovChalenge\`
- View path: `resources/views/admin_inovasi/inovchalenge/`
- Table prefix: `inov_chalenge_*`

---

## Progress Summary

| Sprint    | Goal                                    | Status  | Completion  |
| --------- | --------------------------------------- | ------- | ----------- |
| Sprint 0  | Database & Infrastructure               | ✅ Done | 13 / 13     |
| Sprint 1  | Admin Session & Tahap Field Builder     | ✅ Done | 11 / 11     |
| Sprint 2  | Dosen Submission Flow + Alumni Approval | ✅ Done | 15 / 15     |
| Sprint 3  | Admin Submission Mgmt + Reviewer Portal | ✅ Done | 10 / 10     |
| Sprint 4  | Navigation Integration                  | ✅ Done | 1 / 1       |
| **Total** |                                         |         | **50 / 50** |
