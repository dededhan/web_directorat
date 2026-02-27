# 🚀 Innovation Challenge System - Design Document

## 📋 Ringkasan Eksekutif

Sistem Innovation Challenge adalah platform terintegrasi yang memungkinkan pengelolaan komprehensif dari kegiatan inovasi challange dengan sistem role-based yang mencakup admin, dosen, alumni, dan reviewer. Sistem ini memiliki 3 fase utama dengan form dinamis dan approval workflow yang kompleks.

---

## 🎯 Tujuan Sistem

1. Memberikan platform terpisah namun terintegrasi untuk mengelola Innovation Challenge
2. Memisahkan manajemen Innovation Challenge dari manajemen Inovasi reguler
3. Memfasilitasi kolaborasi antara dosen (internal) dan alumni (eksternal)
4. Memberikan sistem review dan approval yang terstruktur
5. Mengelola 3 fase submission dengan form builder dinamis

---

## 👥 Role & Hak Akses

### 1. **Admin Innovation Challenge (`inovchalange`)**

**Deskripsi**: Administrator penuh yang mengelola seluruh sistem Innovation Challenge

**Hak Akses**:

- ✅ Membuat dan mengelola sesi Innovation Challenge
- ✅ Membuat dan mengkonfigurasi form dinamis untuk setiap fase
- ✅ Assign reviewer ke submission dosen
- ✅ Approve/reject submission untuk melanjutkan ke fase berikutnya
- ✅ Melihat dashboard statistik dan laporan
- ✅ Mengelola pengaturan sistem
- ✅ Export data submission

**Sidebar Khusus**:

- Dashboard Innovation Challenge
- Kelola Sesi
- Form Builder (Phase 1, 2, 3)
- Manajemen Submission
- Assign Reviewer
- Laporan & Statistik
- Pengaturan

**PENTING**: Admin Inovasi sidebar (yang ada saat ini) akan di-hide untuk role ini

---

### 2. **Reviewer Innovation Challenge (`reviewer_inovchalange`)**

**Deskripsi**: Reviewer yang menilai submission pada setiap fase

**Hak Akses**:

- ✅ Melihat submission yang di-assign kepada mereka
- ✅ Memberikan score/penilaian berdasarkan kriteria
- ✅ Memberikan feedback/komentar
- ✅ Download file yang di-upload dosen
- ❌ Tidak bisa edit submission
- ❌ Tidak bisa approve ke fase selanjutnya (hanya admin)

**Sidebar Khusus**:

- Dashboard Reviewer
- Daftar Submission Saya
- History Review
- Profil

---

### 3. **Dosen**

**Deskripsi**: Dosen yang mengikuti Innovation Challenge dan mengajukan submission

**Hak Akses**:

- ✅ Melihat sesi Innovation Challenge yang aktif
- ✅ Daftar/Join ke sesi tertentu
- ✅ Mengisi form submission untuk setiap fase
- ✅ Undang anggota internal (dosen lain)
- ✅ Undang anggota eksternal (alumni) - memerlukan approval
- ✅ Upload file sesuai requirement
- ✅ Melihat status review dan feedback
- ✅ Edit submission sebelum deadline (jika diizinkan)
- ❌ Tidak bisa proceed ke fase berikutnya tanpa approval admin

**Tambahan Sidebar Menu**:
`Innovation Challenge` (menu baru di sidebar dosen existing)

- Sesi Aktif
- Submission Saya
- Tim Saya
- Status & Progress

---

### 4. **Alumni**

**Deskripsi**: Alumni yang diundang sebagai anggota eksternal tim dosen

**Hak Akses**:

- ✅ Menerima notifikasi undangan untuk join tim
- ✅ Approve/reject undangan
- ✅ Melihat detail submission yang mereka join
- ✅ Mengisi form khusus anggota eksternal (jika ada)
- ✅ Lihat progress tim
- ❌ Tidak bisa edit submission utama (hanya dosen ketua)

**Sidebar Alumni** (New Role):

- Dashboard Alumni
- Undangan Tim
- Tim Saya
- Profil

---

## 📊 Struktur Fase System

### **Phase 1: Form Submission & Team Building**

#### Aktivitas:

1. **Dosen** membuka sesi Innovation Challenge yang aktif
2. **Dosen** mengisi form dinamis yang telah dikonfigurasi admin
3. **Dosen** menambahkan anggota tim:
    - **Internal Members**: Dosen lain (langsung diterima)
    - **External Members**: Alumni (memerlukan approval dari alumni tersebut)
4. **Alumni** menerima notifikasi dan approve/reject
5. Setelah form lengkap dan tim terkonfirmasi, **Dosen** submit
6. **Admin** assign submission ke **Reviewer**
7. **Reviewer** evaluasi dan beri score
8. **Admin** review score dan approve untuk lanjut Phase 2

#### Field Form Dinamis (Contoh):

- Judul Inovasi
- Deskripsi Masalah
- Solusi yang Ditawarkan
- Target Outcome
- Anggota Tim (internal/external)
- Dokumen Pendukung (upload)

#### Status Flow Phase 1:

```
Draft → Submitted → Under Review → Reviewed → Approved/Rejected
```

---

### **Phase 2: Upload Module**

#### Aktivitas:

1. **Dosen** mengakses Phase 2 form (modul upload)
2. **Dosen** mengupload dokumen/file sesuai requirement admin
    - Proposal Detail
    - Business Model Canvas
    - Prototype (jika ada)
    - Video Pitch
3. **Dosen** submit upload
4. **Admin** assign ke **Reviewer** (bisa reviewer yang sama atau berbeda)
5. **Reviewer** review dokumen dan beri penilaian
6. **Admin** approve untuk lanjut Phase 3

#### Status Flow Phase 2:

```
Not Started → In Progress → Uploaded → Under Review → Reviewed → Approved/Rejected
```

---

### **Phase 3: Dynamic Form & Upload Kombinasi**

#### Aktivitas:

1. **Dosen** mengakses Phase 3 yang merupakan kombinasi form dan upload
2. Admin telah mengkonfigurasi field form secara dinamis
3. **Dosen** isi form tambahan:
    - Progress Report
    - Hasil Implementasi
    - Dokumentasi Foto/Video
    - Impact Analysis
    - Financial Report (jika ada)
4. **Dosen** upload file pelengkap
5. Submit untuk review final
6. **Reviewer** evaluasi submission final
7. **Admin** approve dan submission selesai

#### Status Flow Phase 3:

```
Not Started → In Progress → Submitted → Under Review → Reviewed → Final Approved/Rejected
```

---

## 🗃️ Database Schema

### Tabel Baru yang Dibutuhkan:

#### 1. **inov_challenge_sessions**

Menyimpan sesi Innovation Challenge

```sql
id (PK)
title VARCHAR(255)
description TEXT
start_date DATE
end_date DATE
registration_deadline DATE
status ENUM('draft', 'active', 'closed')
max_participants INT
created_by (FK ke users)
created_at TIMESTAMP
updated_at TIMESTAMP
```

#### 2. **inov_challenge_form_builders**

Menyimpan konfigurasi form dinamis

```sql
id (PK)
session_id (FK ke inov_challenge_sessions)
phase ENUM('phase_1', 'phase_2', 'phase_3')
form_config JSON (struktur field form)
created_at TIMESTAMP
updated_at TIMESTAMP
```

#### 3. **inov_challenge_submissions**

Menyimpan submission dosen

```sql
id (PK)
session_id (FK ke inov_challenge_sessions)
user_id (FK ke users - dosen leader)
title VARCHAR(255)
phase_1_data JSON
phase_1_status ENUM('draft', 'submitted', 'under_review', 'reviewed', 'approved', 'rejected')
phase_1_submitted_at TIMESTAMP
phase_2_data JSON
phase_2_status ENUM('not_started', 'in_progress', 'uploaded', 'under_review', 'reviewed', 'approved', 'rejected')
phase_2_submitted_at TIMESTAMP
phase_3_data JSON
phase_3_status ENUM('not_started', 'in_progress', 'submitted', 'under_review', 'reviewed', 'approved', 'rejected')
phase_3_submitted_at TIMESTAMP
final_status ENUM('draft', 'in_progress', 'completed', 'rejected')
created_at TIMESTAMP
updated_at TIMESTAMP
```

#### 4. **inov_challenge_team_members**

Menyimpan anggota tim

```sql
id (PK)
submission_id (FK ke inov_challenge_submissions)
user_id (FK ke users)
member_type ENUM('internal', 'external')
role VARCHAR(100) - (Leader, Member, Advisor, etc)
invitation_status ENUM('pending', 'accepted', 'rejected')
invited_at TIMESTAMP
responded_at TIMESTAMP
created_at TIMESTAMP
updated_at TIMESTAMP
```

#### 5. **inov_challenge_uploads**

Menyimpan file upload untuk setiap fase

```sql
id (PK)
submission_id (FK ke inov_challenge_submissions)
phase ENUM('phase_1', 'phase_2', 'phase_3')
file_name VARCHAR(255)
file_path VARCHAR(500)
file_type VARCHAR(50)
file_size INT
uploaded_by (FK ke users)
description TEXT
created_at TIMESTAMP
```

#### 6. **inov_challenge_reviews**

Menyimpan hasil review dari reviewer

```sql
id (PK)
submission_id (FK ke inov_challenge_submissions)
reviewer_id (FK ke users)
phase ENUM('phase_1', 'phase_2', 'phase_3')
score DECIMAL(5,2)
feedback TEXT
review_criteria JSON (detail scoring per kriteria)
status ENUM('assigned', 'in_progress', 'completed')
assigned_at TIMESTAMP
reviewed_at TIMESTAMP
created_at TIMESTAMP
updated_at TIMESTAMP
```

#### 7. **inov_challenge_notifications**

Sistem notifikasi untuk workflow

```sql
id (PK)
user_id (FK ke users)
submission_id (FK ke inov_challenge_submissions)
notification_type VARCHAR(100)
message TEXT
is_read BOOLEAN DEFAULT FALSE
created_at TIMESTAMP
read_at TIMESTAMP
```

---

## 🔄 Workflow Diagram

### Workflow Phase 1

```
[Dosen] Create Submission
    ↓
[Dosen] Fill Form (dynamic)
    ↓
[Dosen] Add Internal Members → [Dosen] Accept/Join
    ↓
[Dosen] Invite External Members → [Alumni] Receive Notification
    ↓                                       ↓
[Alumni] Approve/Reject ←------------------┘
    ↓
[Dosen] Submit Form
    ↓
[Admin] Assign Reviewer
    ↓
[Reviewer] Review & Score
    ↓
[Admin] Review Score → Approve/Reject
    ↓
If Approved → Phase 2
If Rejected → Phase 1 (Revisi)
```

### Workflow Phase 2

```
[Dosen] Access Phase 2
    ↓
[Dosen] Upload Required Files
    ↓
[Dosen] Submit Upload
    ↓
[Admin] Assign Reviewer
    ↓
[Reviewer] Review Files & Score
    ↓
[Admin] Review Score → Approve/Reject
    ↓
If Approved → Phase 3
If Rejected → Phase 2 (Re-upload)
```

### Workflow Phase 3

```
[Dosen] Access Phase 3
    ↓
[Dosen] Fill Dynamic Form + Upload
    ↓
[Dosen] Submit Final
    ↓
[Admin] Assign Reviewer
    ↓
[Reviewer] Final Review & Score
    ↓
[Admin] Final Approve/Reject
    ↓
If Approved → COMPLETED
If Rejected → Phase 3 (Revisi)
```

---

## 🎨 UI/UX Requirements

### Admin Dashboard

- **Cards**: Total Sesi, Total Submissions, Reviewers Active, Completion Rate
- **Charts**: Submissions by Phase, Success Rate, Timeline
- **Tables**: Recent Submissions, Pending Reviews

### Dosen Dashboard

- **Cards**: Active Sessions, My Submissions, Team Members, Current Phase
- **Timeline**: Phase Progress Indicator
- **Notifications**: Team invitations, Review feedback, Approvals

### Reviewer Dashboard

- **Cards**: Assigned Reviews, Completed Reviews, Average Score
- **Tables**: Pending Reviews with deadline
- **Quick Actions**: Start Review button

### Alumni Dashboard

- **Cards**: Team Invitations, Active Teams, Contribution Count
- **Tables**: Invitation list with Accept/Reject action

---

## 🔐 Security & Validation

### Authorization Checks

1. **Middleware**: Role-based middleware untuk setiap route
2. **Policy**: Laravel Policy untuk submission access control
3. **Gates**: Custom gates untuk phase access
4. **Team Verification**: Hanya anggota tim yang bisa akses submission

### Validation Rules

1. **Form Submission**: Validate berdasarkan form builder config
2. **File Upload**:
    - Max file size: 10MB per file
    - Allowed types: PDF, DOC, DOCX, PPT, PPTX, MP4, JPG, PNG
3. **Phase Access**: Validate status sebelum allow akses ke phase selanjutnya
4. **Deadline**: Check deadline sebelum allow submission

---

## 📱 Notification System

### Email Notifications

1. **Dosen**:
    - Submission berhasil
    - Team member joined
    - Review completed
    - Phase approved/rejected
    - Deadline reminder

2. **Alumni**:
    - Team invitation
    - Submission update
    - Phase completion

3. **Reviewer**:
    - New assignment
    - Deadline reminder

4. **Admin**:
    - New submission
    - Review completed
    - System alerts

### In-App Notifications

- Real-time menggunakan broadcasting (optional)
- Badge counter untuk unread notifications
- Notification center dengan history

---

## 🛠️ Technical Stack

### Backend

- **Framework**: Laravel 10+
- **Database**: MySQL
- **Authentication**: Laravel Sanctum / Session
- **Authorization**: Spatie Laravel Permission (existing)
- **Storage**: Laravel Storage (local/S3)
- **Validation**: Laravel Form Requests

### Frontend

- **Template Engine**: Blade
- **CSS Framework**: Tailwind CSS (existing)
- **JavaScript**: Alpine.js (existing)
- **Icons**: BoxIcons (existing)
- **AJAX**: Fetch API / Axios

### Additional Packages (Recommended)

- **Form Builder**: https://github.com/qirolab/laravel-dynamic-forms
- **File Upload**: Livewire File Upload / Dropzone.js
- **Notifications**: Laravel Echo + Pusher (optional)
- **Export**: Laravel Excel (maatwebsite/excel) - already installed

---

## 📋 Form Builder Configuration

### JSON Structure untuk Form Config

```json
{
    "fields": [
        {
            "id": "judul_inovasi",
            "label": "Judul Inovasi",
            "type": "text",
            "required": true,
            "max_length": 255,
            "placeholder": "Masukkan judul inovasi"
        },
        {
            "id": "deskripsi",
            "label": "Deskripsi Masalah",
            "type": "textarea",
            "required": true,
            "rows": 5
        },
        {
            "id": "kategori",
            "label": "Kategori Inovasi",
            "type": "select",
            "required": true,
            "options": [
                { "value": "teknologi", "label": "Teknologi" },
                { "value": "sosial", "label": "Sosial" },
                { "value": "lingkungan", "label": "Lingkungan" }
            ]
        },
        {
            "id": "dokumen_pendukung",
            "label": "Dokumen Pendukung",
            "type": "file",
            "required": false,
            "accept": ".pdf,.doc,.docx",
            "max_size": "10MB",
            "multiple": true
        }
    ]
}
```

### Supported Field Types

- `text` - Single line text
- `textarea` - Multi line text
- `number` - Numeric input
- `email` - Email input
- `date` - Date picker
- `select` - Dropdown
- `radio` - Radio buttons
- `checkbox` - Checkboxes
- `file` - File upload

---

## 🚀 Implementation Phases

### **Sprint 1: Foundation Setup (Week 1-2)**

1. Database migration creation
2. Model creation dengan relationships
3. Seeder untuk roles & permissions
4. Basic routing structure

### **Sprint 2: Admin Module (Week 3-4)**

1. Admin sidebar & dashboard
2. Session management CRUD
3. Form builder interface
4. Reviewer assignment system

### **Sprint 3: Dosen Module (Week 5-6)**

1. Dosen sidebar menu addition
2. Session listing & join
3. Phase 1 form submission
4. Team member invitation

### **Sprint 4: Alumni Module (Week 7)**

1. Alumni role setup
2. Alumni sidebar & dashboard
3. Team invitation approval
4. Team member view

### **Sprint 5: Reviewer Module (Week 8)**

1. Reviewer sidebar & dashboard
2. Submission review interface
3. Scoring system
4. Feedback form

### **Sprint 6: Phase 2 & 3 (Week 9-10)**

1. Phase 2 upload module
2. Phase 3 dynamic form
3. Phase progression logic
4. Status management

### **Sprint 7: Notification & Reporting (Week 11)**

1. Email notifications
2. In-app notifications
3. Admin reporting dashboard
4. Export functionality

### **Sprint 8: Testing & Refinement (Week 12)**

1. Unit testing
2. Integration testing
3. User acceptance testing
4. Bug fixing & optimization

---

## ✅ Success Criteria

1. ✅ Admin dapat membuat sesi dan form dinamis
2. ✅ Dosen dapat submit di 3 fase dengan form yang berbeda
3. ✅ Alumni dapat approve/reject invitation
4. ✅ Reviewer dapat review dan scoring
5. ✅ Admin dapat approve phase progression
6. ✅ Email notification terkirim sesuai workflow
7. ✅ File upload berhasil dengan validation
8. ✅ Role-based access control bekerja sempurna
9. ✅ Export data submission berfungsi
10. ✅ Mobile responsive

---

## 📝 Notes & Considerations

### Pertimbangan Teknis

1. **Performance**: Gunakan eager loading untuk relationship yang kompleks
2. **Scalability**: Index database columns yang sering di-query
3. **Storage**: Pertimbangkan storage capacity untuk file uploads
4. **Caching**: Implement caching untuk form config dan session data

### Future Enhancements (Post-MVP)

1. Real-time collaboration (multiple users edit form)
2. Advanced analytics dashboard
3. Mobile app (React Native / Flutter)
4. Integration dengan sistem eksternal
5. Automated scoring menggunakan AI (optional)
6. Public submission showcase/gallery

---

## 📞 Support & Maintenance

### Documentation Required

1. API Documentation (jika ada REST API)
2. User Manual (Admin, Dosen, Alumni, Reviewer)
3. Developer Guide
4. Deployment Guide

### Maintenance Plan

1. Regular database backup
2. Log monitoring
3. Security updates
4. Performance optimization
5. Bug tracking system

---

**Document Version**: 1.0  
**Last Updated**: 2026-02-24  
**Author**: Development Team  
**Status**: Ready for Implementation

---

## 🔗 Quick Reference Links

- [Main Implementation Tracking](INOVASI_CHALLENGE_TRACKING.md)
- [Database Migration Files](database/migrations/)
- [Routes Configuration](routes/)
- [Controllers](app/Http/Controllers/InovChallenge/)
- [Models](app/Models/InovChallenge/)
- [Views](resources/views/inov_challenge/)
