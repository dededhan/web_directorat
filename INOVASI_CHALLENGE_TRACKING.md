# 📊 Innovation Challenge System - Progress Tracking

> **Project Start Date**: 2026-02-24  
> **Target Completion**: 2026-05-24 (3 bulan)  
> **Current Phase**: Dosen Module In Progress  
> **Overall Progress**: 32.5% (39/120 tasks completed)

---

## 📈 Progress Overview

| Sprint   | Phase                    | Status         | Progress | Start Date | End Date   | Completed Tasks |
| -------- | ------------------------ | -------------- | -------- | ---------- | ---------- | --------------- |
| Sprint 1 | Foundation Setup         | ✅ Completed   | 100%     | 2026-02-27 | 2026-02-27 | 15/15           |
| Sprint 2 | Admin Module             | ✅ Completed   | 100%     | 2026-02-27 | 2026-02-27 | 20/20           |
| Sprint 3 | Dosen Module             | � In Progress  | 16.67%   | 2026-02-27 | TBD        | 3/18            |
| Sprint 4 | Alumni Module            | 🔲 Not Started | 0%       | TBD        | TBD        | 0/12            |
| Sprint 5 | Reviewer Module          | 🔲 Not Started | 0%       | TBD        | TBD        | 0/15            |
| Sprint 6 | Phase 2 & 3              | 🔲 Not Started | 0%       | TBD        | TBD        | 0/20            |
| Sprint 7 | Notification & Reporting | 🔲 Not Started | 0%       | TBD        | TBD        | 0/12            |
| Sprint 8 | Testing & Refinement     | 🔲 Not Started | 0%       | TBD        | TBD        | 0/8             |

**Legend**: 🔲 Not Started | 🔄 In Progress | ✅ Completed | ⚠️ Blocked

---

## 🏗️ Sprint 1: Foundation Setup (Week 1-2)

**Target**: Membangun fondasi database, model, dan struktur dasar sistem  
**Status**: � In Progress  
**Progress**: 15/15 tasks completed

### Database & Migrations

- [x] **Task 1.1**: Create migration `create_inov_challenge_sessions_table`
    - ⏱️ Estimated: 30 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Table untuk menyimpan sesi Innovation Challenge
    - 🔗 Dependencies: None
- [x] **Task 1.2**: Create migration `create_inov_challenge_form_builders_table`
    - ⏱️ Estimated: 30 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Table untuk konfigurasi form dinamis
    - 🔗 Dependencies: Task 1.1
- [x] **Task 1.3**: Create migration `create_inov_challenge_submissions_table`
    - ⏱️ Estimated: 45 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Table utama untuk submission dosen
    - 🔗 Dependencies: Task 1.1, 1.2
- [x] **Task 1.4**: Create migration `create_inov_challenge_team_members_table`
    - ⏱️ Estimated: 30 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Table untuk anggota tim
    - 🔗 Dependencies: Task 1.3
- [x] **Task 1.5**: Create migration `create_inov_challenge_uploads_table`
    - ⏱️ Estimated: 30 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Table untuk file uploads
    - 🔗 Dependencies: Task 1.3
- [x] **Task 1.6**: Create migration `create_inov_challenge_reviews_table`
    - ⏱️ Estimated: 30 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Table untuk review dan scoring
    - 🔗 Dependencies: Task 1.3
- [x] **Task 1.7**: Create migration `create_inov_challenge_notifications_table`
    - ⏱️ Estimated: 30 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Table untuk sistem notifikasi
    - 🔗 Dependencies: Task 1.3

### Models

- [x] **Task 1.8**: Create model `InovChallengeSession` dengan relationships
    - ⏱️ Estimated: 1 hour
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Include relationships: submissions, formBuilders, creator
    - 🔗 Dependencies: Task 1.1
- [x] **Task 1.9**: Create model `InovChallengeFormBuilder` dengan JSON casting
    - ⏱️ Estimated: 45 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Cast form_config as JSON
    - 🔗 Dependencies: Task 1.2
- [x] **Task 1.10**: Create model `InovChallengeSubmission` dengan relationships
    - ⏱️ Estimated: 1.5 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Complex relationships: session, user, teamMembers, uploads, reviews
    - 🔗 Dependencies: Task 1.3
- [x] **Task 1.11**: Create model `InovChallengeTeamMember`
    - ⏱️ Estimated: 45 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Include invitation status logic
    - 🔗 Dependencies: Task 1.4
- [x] **Task 1.12**: Create model `InovChallengeUpload`
    - ⏱️ Estimated: 30 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: File management methods
    - 🔗 Dependencies: Task 1.5
- [x] **Task 1.13**: Create model `InovChallengeReview`
    - ⏱️ Estimated: 1 hour
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Scoring logic dan calculation
    - 🔗 Dependencies: Task 1.6
- [x] **Task 1.14**: Create model `InovChallengeNotification`
    - ⏱️ Estimated: 30 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Mark as read functionality
    - 🔗 Dependencies: Task 1.7

### Seeders & Permissions

- [x] **Task 1.15**: Create seeder untuk roles dan permissions
    - ⏱️ Estimated: 1 hour
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Add roles: inovchalange, reviewer_inovchalange, alumni
    - 🔗 Dependencies: All models created
    - **Details**:
        ```php
        Roles: inovchalange, reviewer_inovchalange, alumni
        Permissions:
        - manage_inov_challenge_sessions
        - manage_inov_challenge_forms
        - submit_inov_challenge
        - review_inov_challenge
        - approve_inov_challenge_team
        ```

---

## 🎨 Sprint 2: Admin Module (Week 3-4)

**Target**: Membangun complete admin interface untuk Innovation Challenge  
**Status**: � In Progress  
**Progress**: 20/20 tasks completed

### Routing & Middleware

- [x] **Task 2.1**: Create route file `routes/inovchalange.php`
    - ⏱️ Estimated: 30 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Resource routes untuk admin
    - 🔗 Dependencies: Sprint 1 completed
- [x] **Task 2.2**: Add middleware untuk role `inovchalange`
    - ⏱️ Estimated: 15 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Protect routes dengan role middleware
    - 🔗 Dependencies: Task 2.1

### Controllers

- [x] **Task 2.3**: Create `InovChallengeSessionController`
    - ⏱️ Estimated: 2 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: CRUD untuk sessions
    - 🔗 Dependencies: Task 2.2
    - **Methods**: index, create, store, edit, update, destroy, activate
- [x] **Task 2.4**: Create `InovChallengeFormBuilderController`
    - ⏱️ Estimated: 3 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Form builder interface (drag & drop jika perlu)
    - 🔗 Dependencies: Task 2.3
    - **Methods**: index, create, store, update, preview
- [x] **Task 2.5**: Create `InovChallengeSubmissionController` (Admin)
    - ⏱️ Estimated: 2 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: View all submissions dengan filter
    - 🔗 Dependencies: Task 2.4
    - **Methods**: index, show, updateStatus, export
- [x] **Task 2.6**: Create `InovChallengeReviewerController`
    - ⏱️ Estimated: 1.5 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Assign reviewer ke submission
    - 🔗 Dependencies: Task 2.5
    - **Methods**: assignReviewer, removeReviewer, reassign

### Views - Sidebar

- [x] **Task 2.7**: Create sidebar view `resources/views/inov_challenge/admin/sidebar.blade.php`
    - ⏱️ Estimated: 1 hour
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Sidebar khusus admin Innovation Challenge
    - 🔗 Dependencies: Task 2.2
    - **Menu Items**:
        - Dashboard
        - Kelola Sesi
        - Form Builder
        - Submissions
        - Reviewer Assignment
        - Laporan
        - Pengaturan

### Views - Dashboard

- [x] **Task 2.8**: Create dashboard view `resources/views/inov_challenge/admin/dashboard.blade.php`
    - ⏱️ Estimated: 2 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Dashboard dengan cards, charts, tables
    - 🔗 Dependencies: Task 2.7
    - **Components**:
        - Stats cards (Total Sesi, Submissions, Reviewers)
        - Chart: Submissions by Phase
        - Recent submissions table
        - Pending actions alert

### Views - Session Management

- [x] **Task 2.9**: Create session index `resources/views/inov_challenge/admin/sessions/index.blade.php`
    - ⏱️ Estimated: 1.5 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: List semua sesi dengan actions
    - 🔗 Dependencies: Task 2.8
- [x] **Task 2.10**: Create session create/edit `resources/views/inov_challenge/admin/sessions/form.blade.php`
    - ⏱️ Estimated: 2 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Form untuk create/update sesi
    - 🔗 Dependencies: Task 2.9
    - **Fields**: title, description, dates, max_participants, status

### Views - Form Builder

- [x] **Task 2.11**: Create form builder index `resources/views/inov_challenge/admin/form_builder/index.blade.php`
    - ⏱️ Estimated: 1 hour
    - ✅ Completed: 2026-02-27
    - 📝 Notes: List forms berdasarkan phase
    - 🔗 Dependencies: Task 2.10
- [x] **Task 2.12**: Create form builder editor `resources/views/inov_challenge/admin/form_builder/editor.blade.php`
    - ⏱️ Estimated: 4 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Form builder interface (bisa pakai Vue/Alpine component)
    - 🔗 Dependencies: Task 2.11
    - **Features**:
        - Add/remove field
        - Field types: text, textarea, select, file, etc
        - Field properties: label, required, validation
        - Preview mode
        - Save as JSON

### Views - Submissions Management

- [x] **Task 2.13**: Create submissions index `resources/views/inov_challenge/admin/submissions/index.blade.php`
    - ⏱️ Estimated: 2 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Table dengan filter (phase, status, session)
    - 🔗 Dependencies: Task 2.12
- [x] **Task 2.14**: Create submission detail `resources/views/inov_challenge/admin/submissions/show.blade.php`
    - ⏱️ Estimated: 2 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Detail submission dengan timeline
    - 🔗 Dependencies: Task 2.13
    - **Sections**:
        - Header info (title, dosen, status)
        - Phase tabs (1, 2, 3)
        - Team members
        - Review history
        - Action buttons (Assign Reviewer, Approve/Reject)

### Views - Reviewer Assignment

- [x] **Task 2.15**: Create reviewer assignment view `resources/views/inov_challenge/admin/reviewers/assign.blade.php`
    - ⏱️ Estimated: 1.5 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Interface untuk assign reviewer
    - 🔗 Dependencies: Task 2.14
    - **Features**:
        - Select submission
        - Select reviewer (dropdown)
        - Multiple reviewer support
        - Workload indicator per reviewer

### Business Logic

- [x] **Task 2.16**: Implement session activation logic
    - ⏱️ Estimated: 1 hour
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Hanya 1 sesi aktif per waktu (optional)
    - 🔗 Dependencies: Task 2.3
- [x] **Task 2.17**: Implement form validation based on form_config
    - ⏱️ Estimated: 2 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Dynamic validation dari JSON config
    - 🔗 Dependencies: Task 2.4
    - **Files Created**:
        - `app/Services/InovChallengeFormValidationService.php` (service)
        - `docs/FORM_VALIDATION_GUIDE.md` (documentation)
    - **Files Updated**:
        - `app/Http/Controllers/InovChallenge/Admin/InovChallengeFormBuilderController.php` (added validation methods)
        - `routes/inovchalange.php` (added debug route)
- [x] **Task 2.18**: Implement phase approval logic
    - ⏱️ Estimated: 1.5 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Update status dan unlock next phase
    - 🔗 Dependencies: Task 2.6
    - **Files Updated**:
        - `app/Http/Controllers/InovChallenge/Admin/InovChallengeSubmissionController.php` (enhanced approve/reject, added unlock)
        - `routes/inovchalange.php` (added unlock and phase-status routes)
    - **Files Created**:
        - `docs/PHASE_APPROVAL_GUIDE.md` (comprehensive documentation)
    - **Features**:
        - Score validation before approval (min 70)
        - Sequential phase progression enforcement
        - Minimum review validation (min 2 reviewers)
        - Auto-unlock next phase (configurable)
        - Manual phase unlock endpoint
        - Phase status API endpoint
        - Improved notifications with scores and reasons
- [x] **Task 2.19**: Implement data export (Excel)
    - ⏱️ Estimated: 2 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Export submissions dengan filter
    - 🔗 Dependencies: Task 2.13
    - **Package**: maatwebsite/excel (already installed)
    - **Files Updated**:
        - `app/Exports/InovChallengeSubmissionsExport.php` (enhanced with 3 sheets, advanced filters)
        - `app/Http/Controllers/InovChallenge/Admin/InovChallengeSubmissionController.php` (enhanced export method)
    - **Files Created**:
        - `docs/DATA_EXPORT_GUIDE.md` (comprehensive documentation)
    - **Features**:
        - Multi-sheet export (Submissions, Team Members, Reviews)
        - Advanced filters (session, status, phase, date range, search)
        - Professional formatting (colors, column widths, alignment)
        - Config-driven sheet inclusion
        - Dynamic filename based on filters
        - 23 columns for submissions, 9 for team members, 10 for reviews

### Testing

- [x] **Task 2.20**: Write tests untuk Admin Module
    - ⏱️ Estimated: 2 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Feature tests untuk CRUD operations
    - 🔗 Dependencies: All Sprint 2 tasks
    - **Files Created**:
        - `tests/Feature/InovChallenge/Admin/InovChallengeSessionControllerTest.php` (17 tests)
        - `tests/Feature/InovChallenge/Admin/InovChallengeFormBuilderControllerTest.php` (13 tests)
        - `tests/Feature/InovChallenge/Admin/InovChallengeSubmissionControllerTest.php` (19 tests)
        - `tests/Feature/InovChallenge/Admin/InovChallengeReviewerControllerTest.php` (24 tests)
        - `docs/ADMIN_MODULE_TESTS.md` (comprehensive test documentation)
    - **Test Coverage**: 73 tests, 220+ assertions, 1,608 lines
    - **Features Tested**:
        - Session CRUD and activation logic
        - Form builder with validation
        - Submission approval workflow (scoring, sequential phases)
        - Reviewer assignment (conflict prevention, workload tracking)
        - Excel export functionality

---

## 👨‍🏫 Sprint 3: Dosen Module (Week 5-6)

**Target**: Interface dosen untuk join sesi dan submit di 3 fase  
**Status**: � In Progress  
**Progress**: 3/18 tasks completed

### Routing & Controllers

- [x] **Task 3.1**: Add routes untuk dosen di `routes/inovchalange.php`
    - ⏱️ Estimated: 30 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Prefix: /dosen/inov-challenge
    - 🔗 Dependencies: Sprint 2 completed
- [x] **Task 3.2**: Create `InovChallengeDosenController`
    - ⏱️ Estimated: 3 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Handle dosen submission workflow
    - 🔗 Dependencies: Task 3.1
    - **Methods**:
        - index, sessions, sessionDetail, joinSession
        - mySubmissions, showSubmission
        - editPhase1, storePhase1
        - editPhase2, storePhase2
        - editPhase3, storePhase3
        - handleFileUploads, calculatePhaseProgress
- [x] **Task 3.3**: Create `InovChallengeTeamController`
    - ⏱️ Estimated: 2 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Manage team members
    - 🔗 Dependencies: Task 3.2
    - **Methods**: index, addMember, removeMember, inviteExternal, resendInvitation, acceptInvitation, rejectInvitation

### Views - Sidebar Update

- [x] **Task 3.4**: Update dosen sidebar dengan menu "Innovation Challenge"
    - ⏱️ Estimated: 30 min
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Add menu di existing dosen sidebar
    - 🔗 Dependencies: Task 3.1
    - **File**: resources/views/subdirektorat-inovasi/dosen/sidebar.blade.php
    - **Menu Structure**:
        ```
        Innovation Challenge
        ├── Dashboard
        ├── Sesi Aktif
        └── Submission Saya
        ```

### Views - Session List

- [x] **Task 3.5**: Create session list view `resources/views/inov_challenge/dosen/sessions/index.blade.php`
    - ⏱️ Estimated: 1.5 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Card-based layout untuk active sessions
    - 🔗 Dependencies: Task 3.4
    - **Features**:
        - Session cards dengan info (title, dates, quota)
        - Join button with validation (deadline, quota check)
        - Status badge (Joined/Not Joined)
        - Deadline warning for sessions closing within 7 days
        - Empty state handling
        - Responsive grid layout (1/2/3 columns)
        - Progress bar for quota visualization
        - Alert messages (success/error/info)
- [x] **Task 3.6**: Create session detail view `resources/views/inov_challenge/dosen/sessions/show.blade.php`
    - ⏱️ Estimated: 1 hour
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Detail sesi sebelum join
    - 🔗 Dependencies: Task 3.5
    - **Features**:
        - Two-column layout (main content + sticky sidebar)
        - Session description with formatted text
        - Phase information cards (3 phases with icons and descriptions)
        - Requirements & guidelines section
        - Participant list (visible for joined sessions, top 10)
        - Sidebar with comprehensive session info (period, deadline, quota, status)
        - Smart action buttons based on session state (join/view submission)
        - Disabled states (expired, full quota)
        - Deadline warnings and quota alerts
        - Confirmation dialog before joining
        - Status badges (Akan Datang, Sedang Berlangsung, Selesai)
        - Quota progress visualization with slots remaining
        - Breadcrumb navigation back to session list

### Views - My Submissions

- [x] **Task 3.7**: Create my submissions list `resources/views/inov_challenge/dosen/submissions/index.blade.php`
    - ⏱️ Estimated: 1.5 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: List submission dengan phase indicator
    - 🔗 Dependencies: Task 3.6
    - **Components**:
        - Submission cards with comprehensive information
        - Phase progress bar (overall progress with percentage)
        - Phase status indicators (3 phases with color-coded status)
        - Status badges (draft, pending, under_review, revision_requested, approved, rejected, completed)
        - Action buttons (Lihat Detail, Continue/Edit Phase, Kelola Tim)
        - Smart edit buttons based on phase status and sequential requirements
        - Statistics cards (Total, Draft, Under Review, Completed)
        - Team member count display
        - Revision notices with alerts
        - Empty state with CTA to browse sessions
        - Pagination support
- [x] **Task 3.8**: Create submission dashboard `resources/views/inov_challenge/dosen/submissions/show.blade.php`
    - ⏱️ Estimated: 2 hours
    - ✅ Completed: 2026-02-27
    - 📝 Notes: Single submission dashboard dengan tabs per phase (created as show.blade.php to match route naming)
    - 🔗 Dependencies: Task 3.7
    - **Tabs**: Overview | Phase 1 | Phase 2 | Phase 3 | Tim | History
    - **Features**:
        - Alpine.js tab navigation with URL sync
        - Overview tab: Overall progress bar, phase status cards (3 phases), submission timeline
        - Phase tabs: Status indicators, progress bars, feedback/review sections, submitted data display, uploaded files list
        - Team tab: Team leader display, member list with status badges, manage team link
        - History tab: Timeline of activities (created, submitted, reviewed, completed)
        - Sidebar: Quick actions (continue/edit phase, manage team, view session), session info, next steps guide
        - Smart action buttons based on sequential phase requirements
        - Status badges with color coding (7 status types)
        - Phase detail partial component for reusability
        - Empty states for phases not yet started

### Views - Phase 1 Form

- [ ] **Task 3.9**: Create Phase 1 form view `resources/views/inov_challenge/dosen/submissions/phase1.blade.php`
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Dynamic form rendering dari form_config
    - 🔗 Dependencies: Task 3.8
    - **Features**:
        - Render form dari JSON config
        - File upload component
        - Auto-save draft
        - Validation messages
- [ ] **Task 3.10**: Create team member form component `resources/views/inov_challenge/dosen/components/team_form.blade.php`
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Component untuk add internal/external member
    - 🔗 Dependencies: Task 3.9
    - **Features**:
        - Search dosen (internal)
        - Input alumni email (external)
        - Member list table
        - Role assignment

### Views - Phase 2 Upload

- [ ] **Task 3.11**: Create Phase 2 upload view `resources/views/inov_challenge/dosen/submissions/phase2.blade.php`
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Upload interface dengan drag & drop
    - 🔗 Dependencies: Task 3.10
    - **Features**:
        - Multi-file upload
        - File type validation
        - Progress bar
        - File manager (delete, replace)

### Views - Phase 3 Combined

- [ ] **Task 3.12**: Create Phase 3 view `resources/views/inov_challenge/dosen/submissions/phase3.blade.php`
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Kombinasi form dinamis dan upload
    - 🔗 Dependencies: Task 3.11
    - **Features**:
        - Dynamic form rendering
        - File upload sections
        - Review summary sebelum submit

### Views - Team Management

- [ ] **Task 3.13**: Create team management view `resources/views/inov_challenge/dosen/team/index.blade.php`
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Manage team members untuk submission
    - 🔗 Dependencies: Task 3.12
    - **Features**:
        - Team member cards
        - Invitation status
        - Remove member
        - Resend invitation

### Business Logic

- [ ] **Task 3.14**: Implement join session logic dengan quota check
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Check max_participants sebelum join
    - 🔗 Dependencies: Task 3.2
- [ ] **Task 3.15**: Implement phase access control
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Hanya bisa akses phase jika phase sebelumnya approved
    - 🔗 Dependencies: Task 3.2
- [ ] **Task 3.16**: Implement file upload handler
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Upload, validation, storage dengan proper naming
    - 🔗 Dependencies: Task 3.11
    - **Validation**: file type, size, required
- [ ] **Task 3.17**: Implement team invitation logic
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Send email invitation ke alumni
    - 🔗 Dependencies: Task 3.3

### Testing

- [ ] **Task 3.18**: Write tests untuk Dosen Module
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Feature tests untuk submission workflow
    - 🔗 Dependencies: All Sprint 3 tasks

---

## 🎓 Sprint 4: Alumni Module (Week 7)

**Target**: Interface alumni untuk approve invitation dan lihat progress tim  
**Status**: 🔲 Not Started  
**Progress**: 0/12 tasks completed

### Routing & Controllers

- [ ] **Task 4.1**: Add routes untuk alumni di `routes/inovchalange.php`
    - ⏱️ Estimated: 30 min
    - 📝 Notes: Prefix: /alumni/inov-challenge
    - 🔗 Dependencies: Sprint 3 completed
- [ ] **Task 4.2**: Create `InovChallengeAlumniController`
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Handle alumni invitation dan team view
    - 🔗 Dependencies: Task 4.1
    - **Methods**:
        - invitations (list)
        - acceptInvitation
        - rejectInvitation
        - myTeams
        - teamDetail

### Views - Sidebar

- [ ] **Task 4.3**: Create alumni sidebar view `resources/views/inov_challenge/alumni/sidebar.blade.php`
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Sidebar khusus alumni
    - 🔗 Dependencies: Task 4.2
    - **Menu Items**:
        - Dashboard
        - Undangan Tim
        - Tim Saya
        - Profil

### Views - Dashboard

- [ ] **Task 4.4**: Create alumni dashboard `resources/views/inov_challenge/alumni/dashboard.blade.php`
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Overview undangan dan tim
    - 🔗 Dependencies: Task 4.3
    - **Stats Cards**:
        - Pending invitations
        - Active teams
        - Total contributions

### Views - Invitations

- [ ] **Task 4.5**: Create invitation list `resources/views/inov_challenge/alumni/invitations/index.blade.php`
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: List undangan dengan detail submission
    - 🔗 Dependencies: Task 4.4
    - **Features**:
        - Invitation cards
        - Submission info preview
        - Accept/Reject buttons
        - Filter (pending, accepted, rejected)
- [ ] **Task 4.6**: Create invitation detail modal/page
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Detail sebelum accept/reject
    - 🔗 Dependencies: Task 4.5

### Views - My Teams

- [ ] **Task 4.7**: Create teams list `resources/views/inov_challenge/alumni/teams/index.blade.php`
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: List tim yang sudah di-join
    - 🔗 Dependencies: Task 4.6
    - **Features**:
        - Team cards dengan submission info
        - Phase progress indicator
        - Status badges
- [ ] **Task 4.8**: Create team detail view `resources/views/inov_challenge/alumni/teams/show.blade.php`
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Detail submission dan team members
    - 🔗 Dependencies: Task 4.7
    - **Sections**:
        - Team info
        - Submission detail (read-only)
        - Files uploaded
        - Phase timeline
        - Team members

### Business Logic

- [ ] **Task 4.9**: Implement invitation acceptance logic
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Update status dan notify dosen
    - 🔗 Dependencies: Task 4.2
- [ ] **Task 4.10**: Implement invitation rejection logic
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Update status, notify dosen, allow re-invite
    - 🔗 Dependencies: Task 4.9
- [ ] **Task 4.11**: Implement alumni notification system
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Email + in-app notification untuk new invitation
    - 🔗 Dependencies: Task 4.2

### Testing

- [ ] **Task 4.12**: Write tests untuk Alumni Module
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Feature tests untuk invitation flow
    - 🔗 Dependencies: All Sprint 4 tasks

---

## 👨‍⚖️ Sprint 5: Reviewer Module (Week 8)

**Target**: Interface reviewer untuk review dan scoring submission  
**Status**: 🔲 Not Started  
**Progress**: 0/15 tasks completed

### Routing & Controllers

- [ ] **Task 5.1**: Add routes untuk reviewer di `routes/inovchalange.php`
    - ⏱️ Estimated: 30 min
    - 📝 Notes: Prefix: /reviewer/inov-challenge
    - 🔗 Dependencies: Sprint 4 completed
- [ ] **Task 5.2**: Create `InovChallengeReviewerController`
    - ⏱️ Estimated: 2.5 hours
    - 📝 Notes: Handle review workflow
    - 🔗 Dependencies: Task 5.1
    - **Methods**:
        - dashboard
        - assignedReviews (list)
        - reviewDetail
        - submitReview
        - updateReview
        - reviewHistory

### Views - Sidebar

- [ ] **Task 5.3**: Create reviewer sidebar `resources/views/inov_challenge/reviewer/sidebar.blade.php`
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Sidebar khusus reviewer
    - 🔗 Dependencies: Task 5.2
    - **Menu Items**:
        - Dashboard
        - Submissions Assigned
        - History Reviews
        - Profil

### Views - Dashboard

- [ ] **Task 5.4**: Create reviewer dashboard `resources/views/inov_challenge/reviewer/dashboard.blade.php`
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Overview submissions dan statistics
    - 🔗 Dependencies: Task 5.3
    - **Components**:
        - Stats: Assigned, Completed, In Progress
        - Pending reviews table with deadline
        - Chart: Reviews by phase
        - Quick action buttons

### Views - Assigned Reviews

- [ ] **Task 5.5**: Create reviews list `resources/views/inov_challenge/reviewer/reviews/index.blade.php`
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: List assigned submissions
    - 🔗 Dependencies: Task 5.4
    - **Features**:
        - Table dengan filter (phase, status)
        - Sort by deadline
        - Priority indicator
        - Start Review button

### Views - Review Form

- [ ] **Task 5.6**: Create review form `resources/views/inov_challenge/reviewer/reviews/form.blade.php`
    - ⏱️ Estimated: 3 hours
    - 📝 Notes: Form untuk scoring dan feedback
    - 🔗 Dependencies: Task 5.5
    - **Sections**:
        - Submission info (header)
        - Dynamic form data view (read-only)
        - File downloads
        - Scoring criteria (multiple criteria dengan weight)
        - Overall score (auto-calculated)
        - Feedback textarea
        - Save Draft / Submit Review buttons
- [ ] **Task 5.7**: Create scoring criteria component `resources/views/inov_challenge/reviewer/components/scoring_criteria.blade.php`
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Reusable component untuk scoring
    - 🔗 Dependencies: Task 5.6
    - **Features**:
        - Multiple criteria rows
        - Score input (0-100)
        - Weight per criteria
        - Auto-calculate weighted score
        - Save as JSON

### Views - Review History

- [ ] **Task 5.8**: Create review history `resources/views/inov_challenge/reviewer/reviews/history.blade.php`
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: List completed reviews
    - 🔗 Dependencies: Task 5.7
    - **Features**:
        - Filter by phase, date
        - View review detail (read-only)
        - Export reviews

### Business Logic

- [ ] **Task 5.9**: Implement scoring calculation logic
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Weighted average calculation
    - 🔗 Dependencies: Task 5.2
    - **Formula**: `Total Score = Σ(Criteria Score × Weight) / Σ(Weight)`
- [ ] **Task 5.10**: Implement review submission validation
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Validate all criteria filled
    - 🔗 Dependencies: Task 5.9
- [ ] **Task 5.11**: Implement auto-notification ke admin after review
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Notify admin bahwa review completed
    - 🔗 Dependencies: Task 5.10
- [ ] **Task 5.12**: Implement deadline warning system
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Email reminder H-3, H-1 sebelum deadline
    - 🔗 Dependencies: Task 5.2

### Policies

- [ ] **Task 5.13**: Create ReviewPolicy untuk authorization
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Hanya reviewer yang assigned bisa review
    - 🔗 Dependencies: Task 5.2

### Testing

- [ ] **Task 5.14**: Write tests untuk Reviewer Module
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Feature tests untuk review workflow
    - 🔗 Dependencies: All Sprint 5 tasks (except 5.15)
- [ ] **Task 5.15**: Test scoring calculation accuracy
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Unit test untuk weighted score calculation
    - 🔗 Dependencies: Task 5.9

---

## 🔄 Sprint 6: Phase 2 & 3 Implementation (Week 9-10)

**Target**: Complete implementation Phase 2 & 3 functionality  
**Status**: 🔲 Not Started  
**Progress**: 1/20 tasks completed

### Phase 2 - Upload Module

- [ ] **Task 6.1**: Enhance Phase 2 controller logic
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Handle multiple file uploads dengan metadata
    - 🔗 Dependencies: Sprint 5 completed
- [ ] **Task 6.2**: Create upload requirements configuration
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Admin bisa set required upload types per phase 2
    - 🔗 Dependencies: Task 6.1
    - **Config Structure**:
        ```json
        {
            "upload_requirements": [
                { "label": "Proposal Detail", "required": true, "type": "pdf" },
                {
                    "label": "Business Model",
                    "required": true,
                    "type": "pdf,doc"
                },
                { "label": "Video Pitch", "required": false, "type": "mp4,mov" }
            ]
        }
        ```
- [ ] **Task 6.3**: Implement upload validation per requirement
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Validate berdasarkan upload_requirements config
    - 🔗 Dependencies: Task 6.2
- [ ] **Task 6.4**: Create file preview functionality
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Preview PDF, images di browser
    - 🔗 Dependencies: Task 6.3
- [ ] **Task 6.5**: Implement file versioning (optional)
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Keep history jika dosen re-upload
    - 🔗 Dependencies: Task 6.4

### Phase 3 - Dynamic Form + Upload

- [ ] **Task 6.6**: Enhance Phase 3 controller logic
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Handle kombinasi form data + uploads
    - 🔗 Dependencies: Task 6.5
- [ ] **Task 6.7**: Create unified validation untuk form + upload
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Validate form fields dan upload requirements
    - 🔗 Dependencies: Task 6.6
- [ ] **Task 6.8**: Implement progress tracker component
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Visual indicator fields mana yang sudah/belum diisi
    - 🔗 Dependencies: Task 6.7

### Phase Progression Logic

- [ ] **Task 6.9**: Implement phase unlock mechanism
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Auto-unlock phase berikutnya after approval
    - 🔗 Dependencies: Task 6.8
- [ ] **Task 6.10**: Implement phase lock mechanism
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Lock previous phase after submit next phase
    - 🔗 Dependencies: Task 6.9
- [ ] **Task 6.11**: Create phase status transition workflow
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: State machine untuk phase transitions
    - 🔗 Dependencies: Task 6.10
    - **States**: draft → submitted → under_review → reviewed → approved/rejected

### View Enhancements

- [ ] **Task 6.12**: Add upload manager component
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Component untuk manage files (delete, replace, download)
    - 🔗 Dependencies: Task 6.11
- [ ] **Task 6.13**: Add file type icons dan previews
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Icons untuk PDF, DOC, IMG, VIDEO
    - 🔗 Dependencies: Task 6.12
- [ ] **Task 6.14**: Create submission timeline component
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Timeline visual menampilkan progress 3 fase
    - 🔗 Dependencies: Task 6.13
    - **Events**: Submitted, Reviewed, Approved/Rejected per phase

### Notification Enhancements

- [ ] **Task 6.15**: Implement phase approval notification
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Notify dosen ketika phase approved
    - 🔗 Dependencies: Task 6.9
- [ ] **Task 6.16**: Implement phase rejection notification
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Notify dosen dengan feedback ketika rejected
    - 🔗 Dependencies: Task 6.15
- [ ] **Task 6.17**: Implement deadline reminder untuk each phase
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Email reminder H-7, H-3, H-1 before deadline
    - 🔗 Dependencies: Task 6.16

### Testing

- [ ] **Task 6.18**: Test phase progression flow end-to-end
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Test complete flow dari phase 1 sampai 3
    - 🔗 Dependencies: Task 6.11
- [ ] **Task 6.19**: Test file upload dengan berbagai file types
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Test validation untuk setiap file type
    - 🔗 Dependencies: Task 6.3
- [ ] **Task 6.20**: Test notification delivery
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Ensure email terkirim untuk setiap event
    - 🔗 Dependencies: Task 6.17

---

## 📬 Sprint 7: Notification & Reporting (Week 11)

**Target**: Complete notification system dan reporting dashboard  
**Status**: 🔲 Not Started  
**Progress**: 0/12 tasks completed

### Email Notifications

- [ ] **Task 7.1**: Create email template base layout
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Base template untuk semua email
    - 🔗 Dependencies: Sprint 6 completed
- [ ] **Task 7.2**: Create mailable class `TeamInvitationMail`
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Email untuk alumni invitation
    - 🔗 Dependencies: Task 7.1
- [ ] **Task 7.3**: Create mailable class `ReviewAssignedMail`
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Email untuk reviewer assignment
    - 🔗 Dependencies: Task 7.2
- [ ] **Task 7.4**: Create mailable class `PhaseStatusMail`
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Email untuk phase approved/rejected
    - 🔗 Dependencies: Task 7.3
- [ ] **Task 7.5**: Create mailable class `DeadlineReminderMail`
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Email reminder deadline
    - 🔗 Dependencies: Task 7.4

### In-App Notifications

- [ ] **Task 7.6**: Create notification component `resources/views/components/notification_bell.blade.php`
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Bell icon dengan badge counter
    - 🔗 Dependencies: Task 7.5
- [ ] **Task 7.7**: Create notification center view
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Dropdown/page list notifikasi
    - 🔗 Dependencies: Task 7.6
    - **Features**:
        - List notifications (read/unread)
        - Mark as read
        - Mark all as read
        - Delete notification
        - Filter by type

### Reporting Module

- [ ] **Task 7.8**: Create report dashboard view
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Admin reporting page dengan charts
    - 🔗 Dependencies: Task 7.7
    - **Charts**:
        - Total submissions by session
        - Phase distribution (pie chart)
        - Success rate by phase
        - Average review score
        - Timeline: submissions over time
- [ ] **Task 7.9**: Implement export submissions (Excel)
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Export data dengan filter
    - 🔗 Dependencies: Task 7.8
    - **Columns**: Session, Dosen, Title, Phase, Status, Scores, Feedback
- [ ] **Task 7.10**: Implement export reviews (Excel)
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Export review data untuk analisis
    - 🔗 Dependencies: Task 7.9

### Scheduled Jobs

- [ ] **Task 7.11**: Create scheduled job untuk deadline reminder
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Cron job berjalan daily untuk check deadline
    - 🔗 Dependencies: Task 7.5
    - **Schedule**: Daily at 08:00 AM

### Testing

- [ ] **Task 7.12**: Test notification delivery dan reporting
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Test email, in-app notification, dan export
    - 🔗 Dependencies: All Sprint 7 tasks

---

## 🧪 Sprint 8: Testing & Refinement (Week 12)

**Target**: Comprehensive testing dan bug fixing  
**Status**: 🔲 Not Started  
**Progress**: 0/8 tasks completed

### Unit Testing

- [ ] **Task 8.1**: Write unit tests untuk Models
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Test relationships, methods, scopes
    - 🔗 Dependencies: Sprint 7 completed
- [ ] **Task 8.2**: Write unit tests untuk Business Logic
    - ⏱️ Estimated: 2 hours
    - 📝 Notes: Test scoring, validation, phase progression
    - 🔗 Dependencies: Task 8.1

### Feature Testing

- [ ] **Task 8.3**: Write feature tests untuk complete user flows
    - ⏱️ Estimated: 3 hours
    - 📝 Notes: Test dari join session sampai final approval
    - 🔗 Dependencies: Task 8.2
    - **Flows to Test**:
        - Admin: Create session → Create form → Assign reviewer
        - Dosen: Join → Submit Phase 1 → Phase 2 → Phase 3
        - Alumni: Receive invitation → Accept → View team
        - Reviewer: Assigned → Review → Submit score
- [ ] **Task 8.4**: Test authorization dan policies
    - ⏱️ Estimated: 1.5 hours
    - 📝 Notes: Ensure role-based access control bekerja
    - 🔗 Dependencies: Task 8.3

### Integration Testing

- [ ] **Task 8.5**: Test file upload integration
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Test storage, retrieval, deletion
    - 🔗 Dependencies: Task 8.4
- [ ] **Task 8.6**: Test email notification integration
    - ⏱️ Estimated: 1 hour
    - 📝 Notes: Test email queue dan delivery
    - 🔗 Dependencies: Task 8.5

### User Acceptance Testing

- [ ] **Task 8.7**: Conduct UAT dengan sample users
    - ⏱️ Estimated: 4 hours
    - 📝 Notes: Test dengan real users (admin, dosen, reviewer)
    - 🔗 Dependencies: Task 8.6
    - **Checklist**:
        - Usability testing
        - Performance testing
        - Mobile responsiveness
        - Browser compatibility
- [ ] **Task 8.8**: Bug fixing dan refinement
    - ⏱️ Estimated: Ongoing
    - 📝 Notes: Fix issues found during testing
    - 🔗 Dependencies: Task 8.7

---

## 🎉 Post-Sprint: Deployment Preparation

### Deployment Checklist

- [ ] **Deploy 1**: Setup production environment
    - Database migration
    - File storage configuration
    - Email SMTP configuration
    - Queue worker setup

- [ ] **Deploy 2**: Security audit
    - CSRF protection
    - XSS prevention
    - SQL injection check
    - File upload security

- [ ] **Deploy 3**: Performance optimization
    - Database indexing
    - Query optimization
    - Caching implementation
    - Asset optimization

- [ ] **Deploy 4**: Documentation
    - User manual (Admin, Dosen, Alumni, Reviewer)
    - API documentation (if any)
    - Deployment guide
    - Maintenance guide

---

## 📊 Current Sprint Details

### Active Sprint: [Not Started Yet]

**Sprint Goal**: TBD  
**Sprint Duration**: TBD  
**Sprint Start**: TBD  
**Sprint End**: TBD

#### Daily Progress Log

##### [Date] - Day 1

- [x] Task completed
- [ ] Task in progress
- Notes: ...

---

## 🐛 Known Issues & Blockers

| Issue ID | Description   | Severity | Status | Assigned To | ETA |
| -------- | ------------- | -------- | ------ | ----------- | --- |
| -        | No issues yet | -        | -      | -           | -   |

**Severity Levels**: 🔴 Critical | 🟠 High | 🟡 Medium | 🟢 Low

---

## 📝 Notes & Decisions

### Technical Decisions

- **[Date]**: Decision description...

### Change Requests

- **[Date]**: Change description...

---

## 📞 Team & Roles

| Role               | Name | Responsibility             | Status  |
| ------------------ | ---- | -------------------------- | ------- |
| Project Manager    | TBD  | Overall coordination       | Active  |
| Backend Developer  | TBD  | Laravel development        | Active  |
| Frontend Developer | TBD  | Blade, Tailwind, Alpine.js | Active  |
| QA Engineer        | TBD  | Testing                    | Active  |
| DevOps             | TBD  | Deployment                 | Standby |

---

## 🔄 Update Log

| Date       | Updated By | Changes                           |
| ---------- | ---------- | --------------------------------- |
| 2026-02-24 | System     | Initial tracking document created |

---

**Last Updated**: 2026-02-24  
**Next Review**: TBD  
**Document Version**: 1.0

---

## 💡 Quick Commands untuk Update Progress

### Untuk mark task sebagai completed:

Ganti `- [ ]` menjadi `- [x]` dan update progress percentage

### Untuk update sprint status:

- 🔲 Not Started
- 🔄 In Progress
- ✅ Completed
- ⚠️ Blocked

### Untuk add blocker:

Tambahkan di section "Known Issues & Blockers" dengan severity yang sesuai

---

## 📋 Cara Menggunakan Dokumen Ini

1. **Sebelum mulai sprint**: Review semua tasks dalam sprint tersebut
2. **Saat development**: Mark task yang sedang dikerjakan dengan status "in progress"
3. **After completion**: Mark task sebagai completed dan update progress
4. **End of sprint**: Review completed tasks dan prepare next sprint
5. **Daily standup**: Update daily progress log
6. **Issue timbul**: Immediately add ke Known Issues section

---

**🎯 Target Launch**: 2026-05-24  
**📊 Current Progress**: 0% (0/120 tasks)  
**⏰ Days Remaining**: 90 days

Semangat! Mari kita bangun Innovation Challenge System yang awesome! 🚀
