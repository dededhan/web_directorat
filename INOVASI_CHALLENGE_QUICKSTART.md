# 🚀 Innovation Challenge System - Quick Start Guide

## 📚 Dokumentasi yang Tersedia

Proyek Innovation Challenge System memiliki 3 dokumen utama:

1. **[INOVASI_CHALLENGE_DESIGN.md](INOVASI_CHALLENGE_DESIGN.md)** - Dokumen design lengkap
2. **[INOVASI_CHALLENGE_TRACKING.md](INOVASI_CHALLENGE_TRACKING.md)** - Tracking progress implementasi
3. **[INOVASI_CHALLENGE_QUICKSTART.md](INOVASI_CHALLENGE_QUICKSTART.md)** - Dokumen ini

---

## 🎯 Gambaran Umum Sistem

Innovation Challenge System adalah platform untuk mengelola kompetisi/challenge inovasi dengan **4 role baru**:

### 👥 Roles

1. **`inovchalange`** - Admin Innovation Challenge (sidebar khusus, hide admin inovasi)
2. **`reviewer_inovchalange`** - Reviewer submissions
3. **`alumni`** - Anggota eksternal tim (approval required)
4. **`dosen`** - Pengaju submission (tambahan menu sidebar)

### 🔄 Workflow 3 Phase

```
Phase 1: Form Submission + Team Building → Review → Approve
    ↓
Phase 2: Upload Module → Review → Approve
    ↓
Phase 3: Dynamic Form + Upload → Final Review → Approve
```

---

## 🗂️ Struktur Role & Sidebar

### Current State (Existing)

```
admin_inovasi          → Sidebar: Admin Inovasi (existing)
dosen                  → Sidebar: Dosen (existing)
```

### Target State (After Implementation)

```
inovchalange           → Sidebar: Admin Innovation Challenge (NEW, hide admin inovasi menu)
reviewer_inovchalange  → Sidebar: Reviewer Innovation Challenge (NEW)
alumni                 → Sidebar: Alumni (NEW ROLE)
dosen                  → Sidebar: Dosen + Menu "Innovation Challenge" (MODIFIED)
admin_inovasi          → Sidebar: Admin Inovasi (NO CHANGES, tetap seperti sekarang)
```

### ⚠️ PENTING - Sidebar Logic

- **`inovchalange`**: Tampilkan sidebar khusus Innovation Challenge, SEMBUNYIKAN menu admin inovasi
- **`admin_inovasi`**: Tetap pakai sidebar existing, TIDAK ADA perubahan
- **`dosen`**: Tambahkan menu baru "Innovation Challenge" di sidebar existing mereka
- **`alumni`** & **`reviewer_inovchalange`**: Sidebar baru sepenuhnya

---

## 📋 Checklist Mulai Implementasi

### Prerequisites

- [x] Laravel 10+ installed
- [x] Spatie Laravel Permission already installed
- [x] Tailwind CSS configured
- [x] Alpine.js available
- [x] Current role system understood

### Before Starting Sprint 1

- [ ] Read [INOVASI_CHALLENGE_DESIGN.md](INOVASI_CHALLENGE_DESIGN.md) completely
- [ ] Understand database schema (7 tables baru)
- [ ] Understand workflow 3 phase
- [ ] Setup development branch
- [ ] Backup database current

---

## 🏁 Langkah Implementasi Bertahap

### Step 1: Persiapan (Day 1-2)

```bash
# 1. Create feature branch
git checkout -b feature/innovation-challenge

# 2. Create folder structure
mkdir -p app/Http/Controllers/InovChallenge
mkdir -p app/Models/InovChallenge
mkdir -p resources/views/inov_challenge/{admin,dosen,alumni,reviewer}
mkdir -p database/migrations

# 3. Review design document
# Baca INOVASI_CHALLENGE_DESIGN.md section Database Schema
```

### Step 2: Database Setup (Day 3-5) - Sprint 1

```bash
# Create migrations satu per satu (lihat Task 1.1 - 1.7)
php artisan make:migration create_inov_challenge_sessions_table
php artisan make:migration create_inov_challenge_form_builders_table
# ... dst sesuai tracking document

# Run migrations
php artisan migrate

# Create models (Task 1.8 - 1.14)
php artisan make:model InovChallenge/InovChallengeSession
# ... dst

# Create seeder (Task 1.15)
php artisan make:seeder InovChallengeRolesSeeder
php artisan db:seed --class=InovChallengeRolesSeeder
```

### Step 3: Admin Module (Day 6-15) - Sprint 2

```bash
# Create routes (Task 2.1)
# Edit routes/web.php atau buat routes/inovchalange.php

# Create controllers (Task 2.3 - 2.6)
php artisan make:controller InovChallenge/InovChallengeSessionController --resource
php artisan make:controller InovChallenge/InovChallengeFormBuilderController
# ... dst

# Create views (Task 2.7 - 2.15)
# Mulai dari sidebar, lalu dashboard, lalu CRUD pages
```

### Step 4: Dosen Module (Day 16-25) - Sprint 3

- Update sidebar dosen existing
- Create submission pages
- Implement team invitation
- File upload functionality

### Step 5: Alumni Module (Day 26-30) - Sprint 4

- Create new alumni sidebar
- Invitation approval system
- Team view

### Step 6: Reviewer Module (Day 31-37) - Sprint 5

- Create reviewer interface
- Scoring system
- Review workflow

### Step 7: Phase Completion (Day 38-50) - Sprint 6

- Finalize Phase 2 & 3
- Phase progression logic
- Status management

### Step 8: Notifications (Day 51-57) - Sprint 7

- Email templates
- In-app notifications
- Reporting dashboard

### Step 9: Testing (Day 58-65) - Sprint 8

- Unit tests
- Feature tests
- UAT
- Bug fixing

---

## 📝 Development Workflow

### Daily Routine

1. **Morning**:
    - Check [INOVASI_CHALLENGE_TRACKING.md](INOVASI_CHALLENGE_TRACKING.md)
    - Mark current task as "in progress"
    - Update daily log

2. **During Development**:
    - Follow design specs in [INOVASI_CHALLENGE_DESIGN.md](INOVASI_CHALLENGE_DESIGN.md)
    - Commit regularly dengan message yang jelas
    - Test setiap feature setelah selesai

3. **End of Day**:
    - Mark completed tasks dengan `[x]`
    - Update progress percentage
    - Push ke git
    - Add notes jika ada blocker

### Commit Message Convention

```
feat(admin): add session management CRUD (Task 2.3)
feat(dosen): add phase 1 submission form (Task 3.9)
fix(reviewer): fix scoring calculation bug
docs: update tracking document progress
test: add unit tests for InovChallengeSession model
```

---

## 🎨 UI/UX Guidelines

### Sidebar Styling

- Gunakan style yang konsisten dengan sidebar existing
- Warna utama: Teal/Green (sesuai existing admin sidebar)
- Icons: BoxIcons (bx classes)
- Responsive: Mobile & desktop

### Form Styling

- Gunakan Tailwind CSS classes
- Consistent spacing (p-4, m-4, gap-4)
- Validation messages: text-red-500
- Success messages: text-green-500

### Components to Reuse

- Table styling dari existing admin tables
- Card components dari existing dashboard
- Button styles dari existing forms
- Modal/popup dari existing UI

---

## 🧪 Testing Strategy

### What to Test

1. **Authorization**: Role-based access
2. **Form Validation**: Dynamic form validation
3. **File Upload**: Size, type, storage
4. **Phase Progression**: Unlock logic
5. **Scoring**: Calculation accuracy
6. **Notifications**: Email delivery
7. **Team Invitation**: Approval workflow

### Test Commands

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/InovChallengeSessionTest.php

# Run with coverage
php artisan test --coverage

# Run specific test method
php artisan test --filter testCanCreateSession
```

---

## 🐛 Common Issues & Solutions

### Issue 1: Migration Error

**Problem**: Foreign key constraint fails  
**Solution**: Pastikan urutan migration benar, parent table dulu

### Issue 2: Role Not Found

**Problem**: Role tidak ditemukan saat testing  
**Solution**: Run seeder dulu `php artisan db:seed --class=InovChallengeRolesSeeder`

### Issue 3: File Upload 413 Error

**Problem**: File terlalu besar  
**Solution**: Update `upload_max_filesize` di php.ini dan `post_max_size`

### Issue 4: Permission Denied

**Problem**: User tidak bisa akses route  
**Solution**: Check middleware role dan assign role dengan benar

---

## 📞 Support & Resources

### Laravel Documentation

- [Laravel Routing](https://laravel.com/docs/10.x/routing)
- [Laravel Controllers](https://laravel.com/docs/10.x/controllers)
- [Laravel Validation](https://laravel.com/docs/10.x/validation)
- [Laravel File Storage](https://laravel.com/docs/10.x/filesystem)
- [Spatie Permission](https://spatie.be/docs/laravel-permission/v5/introduction)

### Packages Used

- **Spatie Laravel Permission**: Role & permission management
- **Maatwebsite Excel**: Data export
- **Laravel Sanctum**: API authentication (if needed)

---

## 🔄 Progress Update Guide

### Cara Update [INOVASI_CHALLENGE_TRACKING.md](INOVASI_CHALLENGE_TRACKING.md)

#### 1. Start Working on Task

```markdown
# Before

- [ ] **Task 2.3**: Create InovChallengeSessionController

# After (mark in progress manually in notes)

- [ ] **Task 2.3**: Create InovChallengeSessionController
    - 🔄 Status: In Progress
    - Started: 2026-02-24 09:00
```

#### 2. Complete Task

```markdown
# Change to

- [x] **Task 2.3**: Create InovChallengeSessionController
    - ✅ Completed: 2026-02-24 14:30
    - Duration: 5.5 hours
    - Notes: Added all CRUD methods
```

#### 3. Update Sprint Progress

```markdown
# Update header

**Status**: 🔄 In Progress  
**Progress**: 3/20 tasks completed (15%)
```

#### 4. Add Blocker if Any

```markdown
| INC-001 | Cannot access storage folder | 🔴 Critical | ⚠️ Blocked | Developer | 2026-02-25 |
```

---

## 🎯 Sprint Planning Template

Untuk setiap sprint, lakukan:

### Sprint Planning Meeting (Before Sprint Start)

1. Review semua tasks dalam sprint
2. Estimate effort untuk setiap task
3. Identifikasi dependencies
4. Setup sprint dates
5. Assign tasks ke team members

### Daily Standup (During Sprint)

1. **Yesterday**: Task apa yang selesai?
2. **Today**: Task apa yang akan dikerjakan?
3. **Blockers**: Ada masalah yang menghambat?

### Sprint Review (After Sprint End)

1. Demo features yang sudah selesai
2. Get feedback dari stakeholders
3. Update tracking document
4. Plan next sprint

---

## 📊 Key Metrics to Track

- **Velocity**: Tasks completed per sprint
- **Quality**: Bugs found per sprint
- **Coverage**: Test coverage percentage
- **Performance**: Page load time, query time
- **Timeline**: On schedule vs delayed

---

## ✅ Definition of Done

Sebuah task dianggap "Done" jika:

- [x] Code lengkap dan tested
- [x] Unit tests passed
- [x] Feature tests passed
- [x] Code reviewed (jika ada reviewer)
- [x] Documentation updated
- [x] No critical bugs
- [x] Merged to main branch
- [x] Deployed to staging (if applicable)

---

## 🚀 Quick Reference: Main Features

### Admin Features

1. ✅ Create & manage sessions
2. ✅ Build dynamic forms untuk 3 phases
3. ✅ View all submissions
4. ✅ Assign reviewers
5. ✅ Approve/reject phase progression
6. ✅ Export reports

### Dosen Features

1. ✅ Browse active sessions
2. ✅ Join session
3. ✅ Submit Phase 1 (form + team)
4. ✅ Submit Phase 2 (uploads)
5. ✅ Submit Phase 3 (form + uploads)
6. ✅ Invite team members (internal/external)
7. ✅ Track submission status

### Alumni Features

1. ✅ Receive team invitation
2. ✅ Accept/reject invitation
3. ✅ View team submissions
4. ✅ Track team progress

### Reviewer Features

1. ✅ View assigned submissions
2. ✅ Download uploaded files
3. ✅ Score submissions based on criteria
4. ✅ Provide feedback
5. ✅ View review history

---

## 📞 Contact & Escalation

### For Technical Issues

- Check [Known Issues section](INOVASI_CHALLENGE_TRACKING.md#known-issues--blockers)
- Search Laravel documentation
- Ask in team chat

### For Design Questions

- Refer to [Design Document](INOVASI_CHALLENGE_DESIGN.md)
- Discuss with Product Owner
- Document decisions in tracking doc

### For Blockers

- Add to tracking document immediately
- Notify team lead
- Find workaround if possible

---

**🎉 You're Ready to Start!**

1. Read [INOVASI_CHALLENGE_DESIGN.md](INOVASI_CHALLENGE_DESIGN.md) thoroughly
2. Open [INOVASI_CHALLENGE_TRACKING.md](INOVASI_CHALLENGE_TRACKING.md)
3. Start with Sprint 1, Task 1.1
4. Update progress daily
5. Ask questions when stuck

**Good luck! Mari kita buat Innovation Challenge System yang luar biasa! 🚀**

---

**Document Version**: 1.0  
**Created**: 2026-02-24  
**Last Updated**: 2026-02-24
