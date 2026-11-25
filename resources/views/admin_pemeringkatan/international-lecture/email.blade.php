@extends('admin_pemeringkatan.index')

@section('contentadmin_pemeringkatan')
<style>[x-cloak]{display:none!important}</style>
@php
    $usedPercent = $dailyLimit > 0 ? min(100, round(($usedToday / $dailyLimit) * 100)) : 100;
    $hasOld = session()->hasOldInput();
@endphp

<script>
    window.__bulkEmailConfig = {
        userId: @json(auth()->id()),
        isAdmin: @json(auth()->user() && in_array(auth()->user()->role, ['admin_direktorat', 'admin_pemeringkatan'])),
        adminName: @json(auth()->user()?->name ?? 'Admin'),
        adminEmail: @json(auth()->user()?->email ?? ''),
        limit: @json($dailyLimit),
        used: @json($usedToday),
        remaining: @json($remainingQuota),
        hasSystemTemplate: @json($hasSystemTemplate),
        systemPreviews: @json($systemPreviews),
        systemSubjects: @json($systemSubjects),
        textTemplates: @json($textTemplates),
        dbTemplates: @json($dbTemplates),
        storeTemplateUrl: @json(route('admin_pemeringkatan.international-lecture.templates.store')),
        deleteTemplateUrlBase: @json(url('admin_pemeringkatan/international-lecture/templates')),
        csrfToken: @json(csrf_token()),
        filteredRecipients: @json($filteredRecipients),
        sampleConsentLink: @json(route('pemeringkatan.international-lecture.consent.show', ['token' => 'contoh-token'])),
        clearSelection: @json((bool) session('email_batch_sent')),
        openComposer: @json(request()->boolean('compose') || $hasOld || session()->has('success') || session()->has('error') || $errors->any()),
        old: {
            mode: @json(old('mode', 'template')),
            templateId: @json(old('template_id', 'default_qs')),
            languageMode: @json(old('language_mode', 'bilingual')),
            subject: @json(old('subject', '')),
            body: @json(old('body', '')),
            includeButton: @json($hasOld ? (bool) old('include_consent_button') : true),
            buttonText: @json(old('button_text', 'Give Consent / Berikan Persetujuan')),
        },
    };

    function bulkEmailPage(cfg) {
        const STORAGE_KEY = 'il_bulk_email_selected_user_' + (cfg.userId || 'guest');
        const esc = (s) => String(s ?? '')
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#039;');

        return {
            // ---- Komposisi email ----
            mode: cfg.old.mode === 'manual' ? 'manual' : 'template',
            templateId: cfg.old.templateId || 'default_qs',
            languageMode: cfg.old.languageMode || 'bilingual',
            subject: cfg.old.subject || '',
            body: cfg.old.body || '',
            photoName: '',
            photoPreview: '',
            includeButton: !!cfg.old.includeButton,
            buttonText: cfg.old.buttonText || 'Give Consent / Berikan Persetujuan',
            templateKey: '',
            templates: Array.isArray(cfg.dbTemplates) ? [...cfg.dbTemplates] : [],
            savingTemplate: false,
            showAdminModal: false,
            adminForm: {
                title: '',
                subject: '',
                body: '',
                include_consent_button: false,
                button_text: 'Give Consent / Berikan Persetujuan',
                is_system: true,
                saving: false,
            },
            placeholders: [
                { key: 'nama', label: 'Nama' },
                { key: 'title', label: 'Gelar' },
                { key: 'jabatan', label: 'Jabatan' },
                { key: 'universitas_asal', label: 'Institusi' },
                { key: 'negara', label: 'Negara' },
                { key: 'subject_1', label: 'Subject 1' },
                { key: 'prodi', label: 'Prodi' },
                { key: 'fakultas', label: 'Fakultas' },
                { key: 'email', label: 'Email' },
                { key: 'consent_link', label: 'Link Consent' },
            ],

            // ---- Penerima ----
            selected: {},
            limit: cfg.limit,
            remaining: cfg.remaining,
            showSelectedList: false,
            sending: false,
            showComposer: !!cfg.openComposer,

            init() {
                try { sessionStorage.removeItem('il_bulk_email_selected'); } catch (e) {}
                if (cfg.clearSelection) {
                    sessionStorage.removeItem(STORAGE_KEY);
                }
                try {
                    const saved = JSON.parse(sessionStorage.getItem(STORAGE_KEY) || '{}');
                    this.selected = saved && typeof saved === 'object' ? saved : {};
                } catch (e) { this.selected = {}; }

                // Sinkronkan state panel "Isi & Kirim Email" ke URL (?compose=1)
                // agar tetap terbuka saat halaman dimuat ulang (filter, reset, paginasi, refresh).
                const syncComposeUrl = (open) => {
                    const u = new URL(window.location.href);
                    if (open) u.searchParams.set('compose', '1');
                    else u.searchParams.delete('compose');
                    window.history.replaceState(window.history.state, '', u.toString());
                };
                syncComposeUrl(this.showComposer);
                this.$watch('showComposer', (v) => syncComposeUrl(v));

                // Setelah filter diterapkan/dihapus, kembalikan posisi layar ke bar filter.
                if (this.showComposer && window.location.hash === '#recipient-filter') {
                    this.$nextTick(() => setTimeout(() => {
                        document.getElementById('recipient-filter')?.scrollIntoView({ block: 'start' });
                    }, 50));
                }
            },

            // Placeholder dibentuk via JS agar tidak bentrok dengan sintaks Blade.
            ph(key) { return '{' + '{' + key + '}' + '}'; },

            get systemTemplates() {
                return this.templates.filter(t => !!t.is_system);
            },

            get myTemplates() {
                return this.templates.filter(t => !t.is_system && t.user_id === cfg.userId);
            },

            get selectedTemplate() {
                if (!this.templateId || this.templateId === 'default_qs') return null;
                return this.templates.find(t => String(t.id) === String(this.templateId)) || null;
            },

            canDeleteTemplate(tpl) {
                if (!tpl) return false;
                if (cfg.isAdmin) return true;
                return !tpl.is_system && tpl.user_id === cfg.userId;
            },

            get selectedCount() { return Object.keys(this.selected).length; },
            get selectedList() { return Object.values(this.selected); },
            get incompleteSelectedList() {
                return Object.values(this.selected).filter(r => Array.isArray(r.missing) && r.missing.length > 0);
            },
            get hasIncompleteSelected() {
                return this.incompleteSelectedList.length > 0;
            },
            get remainingAfter() { return this.remaining - this.selectedCount; },
            get overQuota() { return this.selectedCount > this.remaining; },
            get selectionPercent() {
                return this.remaining > 0 ? Math.min(100, Math.round(this.selectedCount / this.remaining * 100)) : 100;
            },

            persist() { sessionStorage.setItem(STORAGE_KEY, JSON.stringify(this.selected)); },
            isSelected(id) { return !!this.selected[id]; },

            add(r) {
                if (this.selected[r.id]) return true;
                if (this.selectedCount >= this.remaining) return false;
                this.selected[r.id] = {
                    id: String(r.id),
                    name: r.name,
                    email: r.email || '',
                    missing: Array.isArray(r.missing) ? r.missing : [],
                    editUrl: r.editUrl || ''
                };
                return true;
            },

            toggle(el) {
                if (el.dataset.emailValid !== 'true' && el.checked) {
                    el.checked = false;
                    Swal.fire({
                        icon: 'warning',
                        title: 'Email Tidak Valid / Belum Fix',
                        text: 'Email dosen ' + el.dataset.name + ' (' + (el.dataset.email || 'Kosong') + ') tidak valid atau masih diisi sembarang. Email harus fix sesuai email yang dituju sebelum dapat dipilih dan dikirim.',
                        confirmButtonColor: '#0d9488'
                    });
                    return;
                }

                let missing = [];
                try {
                    if (el.dataset.missing) missing = JSON.parse(el.dataset.missing);
                } catch(e) {}

                const r = {
                    id: String(el.dataset.id),
                    name: el.dataset.name,
                    email: el.dataset.email || '',
                    missing: missing,
                    editUrl: el.dataset.editUrl || ''
                };
                if (el.checked) {
                    if (!this.add(r)) {
                        el.checked = false;
                        this.quotaWarning();
                        return;
                    }
                } else {
                    delete this.selected[r.id];
                }
                this.persist();
            },

            handleRowClick(e, id) {
                if (e.target.closest('a, button, input, select, label, form')) return;
                const cb = document.querySelector(`.recipient-checkbox[data-id="${id}"]`);
                if (cb) {
                    if (cb.disabled || cb.dataset.emailValid !== 'true') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Email Belum Fix / Tidak Valid',
                            text: 'Dosen ini memiliki email yang tidak valid atau masih diisi sembarang (' + (cb.dataset.email || 'Kosong') + '). Email harus fix sesuai email yang dituju sebelum dapat dipilih dan dikirim.',
                            confirmButtonColor: '#0d9488'
                        });
                        return;
                    }
                    cb.checked = !cb.checked;
                    this.toggle(cb);
                }
            },

            pageCheckboxes() { return [...document.querySelectorAll('.recipient-checkbox:not(:disabled)')]; },

            pageAllSelected() {
                const cbs = this.pageCheckboxes();
                return cbs.length > 0 && cbs.every(cb => this.selected[cb.dataset.id]);
            },

            togglePage(e) {
                const cbs = this.pageCheckboxes();
                if (e.target.checked) {
                    let blocked = 0;
                    cbs.forEach(cb => {
                        let missing = [];
                        try {
                            if (cb.dataset.missing) missing = JSON.parse(cb.dataset.missing);
                        } catch(err) {}

                        if (!this.add({
                            id: String(cb.dataset.id),
                            name: cb.dataset.name,
                            email: cb.dataset.email || '',
                            missing: missing,
                            editUrl: cb.dataset.editUrl || ''
                        })) blocked++;
                    });
                    if (blocked > 0) this.quotaWarning(blocked);
                } else {
                    cbs.forEach(cb => delete this.selected[cb.dataset.id]);
                }
                this.persist();
            },

            selectAllFiltered() {
                let added = 0, blocked = 0;
                cfg.filteredRecipients.forEach(r => {
                    const already = !!this.selected[r.id];
                    if (this.add({
                        id: String(r.id),
                        name: r.name,
                        email: r.email || '',
                        missing: r.missing || [],
                        editUrl: r.editUrl || ''
                    })) {
                        if (!already) added++;
                    } else {
                        blocked++;
                    }
                });
                this.persist();
                if (blocked > 0) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Dibatasi kuota harian',
                        html: `<b>${added}</b> dosen ditambahkan. <b>${blocked}</b> dosen tidak dipilih karena sisa kuota hari ini hanya <b>${this.remaining}</b> email.`,
                        confirmButtonColor: '#2563eb',
                    });
                } else {
                    window.Alert?.success(`${added} dosen ditambahkan ke daftar penerima.`);
                }
            },

            remove(id) { delete this.selected[id]; this.persist(); },

            clearSelection() {
                if (!this.selectedCount) return;
                Swal.fire({
                    title: 'Kosongkan pilihan?',
                    text: `${this.selectedCount} penerima akan dihapus dari daftar.`,
                    icon: 'question', showCancelButton: true,
                    confirmButtonText: 'Kosongkan', cancelButtonText: 'Batal', confirmButtonColor: '#ef4444',
                }).then(r => { if (r.isConfirmed) { this.selected = {}; this.persist(); } });
            },

            quotaWarning(n = null) {
                const msg = this.remaining <= 0
                    ? `Kuota email hari ini (${this.limit}/hari) sudah habis.`
                    : `Maksimal ${this.remaining} penerima lagi hari ini (batas ${this.limit} email/hari).` + (n ? ` ${n} dosen tidak dipilih.` : '');
                window.Alert ? window.Alert.warning(msg) : alert(msg);
            },

            changePerPage(value) {
                const u = new URL(window.location.href);
                u.searchParams.set('per_page', value);
                u.searchParams.set('compose', '1');
                u.searchParams.delete('page');
                u.hash = 'recipient-filter';
                window.location = u.toString();
            },

            // ---- Template & editor ----
            loadTextTemplate() {
                const tpl = cfg.textTemplates[this.templateKey];
                if (!tpl) return;
                const apply = () => { this.subject = tpl.subject || ''; this.body = tpl.body || ''; };
                if (this.subject.trim() || this.body.trim()) {
                    Swal.fire({
                        title: 'Timpa isi email?', text: 'Subjek dan isi email saat ini akan diganti dengan template.',
                        icon: 'question', showCancelButton: true,
                        confirmButtonText: 'Ya, gunakan template', cancelButtonText: 'Batal', confirmButtonColor: '#2563eb',
                    }).then(r => { if (r.isConfirmed) apply(); });
                } else {
                    apply();
                }
            },

            copyToManual() {
                const tpl = this.selectedTemplate;
                if (!tpl) return;
                const apply = () => {
                    this.subject = tpl.subject || '';
                    this.body = tpl.body || '';
                    this.includeButton = !!tpl.include_consent_button;
                    this.buttonText = tpl.button_text || 'Give Consent / Berikan Persetujuan';
                    this.mode = 'manual';
                };

                if (this.subject.trim() || this.body.trim()) {
                    Swal.fire({
                        title: 'Timpa isi Tulis Manual?',
                        text: 'Subjek dan isi di mode Tulis Manual saat ini akan diganti dengan isi template ini.',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Salin & Edit',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#2563eb',
                    }).then(r => { if (r.isConfirmed) apply(); });
                } else {
                    apply();
                }
            },

            async saveManualAsTemplate() {
                if (!this.subject.trim() || !this.body.trim()) {
                    return Swal.fire({
                        icon: 'warning',
                        title: 'Email Belum Lengkap',
                        text: 'Subjek dan isi email wajib diisi sebelum menyimpan sebagai template.',
                        confirmButtonColor: '#2563eb'
                    });
                }

                const { value: title } = await Swal.fire({
                    title: 'Simpan ke Template Sistem',
                    html: '<p class="text-xs text-gray-500 mb-2">Template ini akan disimpan ke akun Anda dan otomatis muncul pada opsi dropdown template sistem.</p>',
                    input: 'text',
                    inputLabel: 'Nama / Judul Template',
                    inputPlaceholder: 'Contoh: Undangan Guest Lecture 2026',
                    inputAttributes: { maxlength: 100 },
                    showCancelButton: true,
                    confirmButtonText: '<i class="fa-solid fa-floppy-disk mr-1"></i> Simpan Template',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#2563eb',
                    inputValidator: (val) => {
                        if (!val || !val.trim()) return 'Nama / Judul template wajib diisi!';
                    }
                });

                if (!title) return;

                this.savingTemplate = true;
                try {
                    const res = await fetch(cfg.storeTemplateUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': cfg.csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            title: title.trim(),
                            subject: this.subject.trim(),
                            body: this.body.trim(),
                            include_consent_button: this.includeButton ? 1 : 0,
                            button_text: this.buttonText || '',
                            is_system: 0,
                        })
                    });

                    const json = await res.json();
                    if (!res.ok || !json.success) {
                        throw new Error(json.message || 'Gagal menyimpan template');
                    }

                    this.templates.unshift(json.template);
                    this.templateId = String(json.template.id);

                    Swal.fire({
                        icon: 'success',
                        title: 'Template Tersimpan!',
                        html: `Template <b>"${esc(json.template.title)}"</b> telah tersimpan di akun Anda dan kini tersedia di pilihan Template Sistem.`,
                        showCancelButton: true,
                        confirmButtonText: 'Lihat di Pilihan Template',
                        cancelButtonText: 'Tetap di Tulis Manual',
                        confirmButtonColor: '#2563eb',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.mode = 'template';
                        }
                    });
                } catch (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan',
                        text: err.message || 'Terjadi kesalahan sistem saat menyimpan template.',
                        confirmButtonColor: '#2563eb'
                    });
                } finally {
                    this.savingTemplate = false;
                }
            },

            openAdminCreateModal() {
                this.adminForm = {
                    title: '',
                    subject: '',
                    body: '',
                    include_consent_button: false,
                    button_text: 'Give Consent / Berikan Persetujuan',
                    is_system: true,
                    saving: false,
                };
                this.showAdminModal = true;
            },

            insertAdminPlaceholder(key) {
                const ta = this.$refs.adminBodyInput;
                const token = this.ph(key);
                if (!ta) { this.adminForm.body += token; return; }
                const start = ta.selectionStart ?? this.adminForm.body.length;
                const end = ta.selectionEnd ?? this.adminForm.body.length;
                this.adminForm.body = this.adminForm.body.slice(0, start) + token + this.adminForm.body.slice(end);
                this.$nextTick(() => { ta.focus(); ta.selectionStart = ta.selectionEnd = start + token.length; });
            },

            async submitAdminTemplate() {
                if (!this.adminForm.title.trim()) {
                    return Swal.fire({ icon: 'warning', title: 'Data belum lengkap', text: 'Nama / Judul template wajib diisi.', confirmButtonColor: '#2563eb' });
                }
                if (!this.adminForm.subject.trim()) {
                    return Swal.fire({ icon: 'warning', title: 'Data belum lengkap', text: 'Subjek email wajib diisi.', confirmButtonColor: '#2563eb' });
                }
                if (!this.adminForm.body.trim()) {
                    return Swal.fire({ icon: 'warning', title: 'Data belum lengkap', text: 'Isi email wajib diisi.', confirmButtonColor: '#2563eb' });
                }

                this.adminForm.saving = true;
                try {
                    const res = await fetch(cfg.storeTemplateUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': cfg.csrfToken,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            title: this.adminForm.title.trim(),
                            subject: this.adminForm.subject.trim(),
                            body: this.adminForm.body.trim(),
                            include_consent_button: this.adminForm.include_consent_button ? 1 : 0,
                            button_text: this.adminForm.button_text || '',
                            is_system: this.adminForm.is_system ? 1 : 0,
                        })
                    });

                    const json = await res.json();
                    if (!res.ok || !json.success) {
                        throw new Error(json.message || 'Gagal menyimpan template.');
                    }

                    this.templates.unshift(json.template);
                    this.templateId = String(json.template.id);
                    this.showAdminModal = false;

                    Swal.fire({
                        icon: 'success',
                        title: 'Template Berhasil Dibuat!',
                        text: json.message,
                        confirmButtonColor: '#2563eb'
                    });
                } catch (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan',
                        text: err.message || 'Terjadi kesalahan sistem.',
                        confirmButtonColor: '#2563eb'
                    });
                } finally {
                    this.adminForm.saving = false;
                }
            },

            async deleteTemplate(id) {
                const tpl = this.templates.find(t => String(t.id) === String(id));
                if (!tpl) return;

                const result = await Swal.fire({
                    title: 'Hapus Template?',
                    html: `Apakah Anda yakin ingin menghapus template <b>"${esc(tpl.title)}"</b>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ef4444',
                });

                if (!result.isConfirmed) return;

                try {
                    const res = await fetch(`${cfg.deleteTemplateUrlBase}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': cfg.csrfToken,
                            'Accept': 'application/json',
                        }
                    });

                    const json = await res.json();
                    if (!res.ok || !json.success) {
                        throw new Error(json.message || 'Gagal menghapus template.');
                    }

                    this.templates = this.templates.filter(t => String(t.id) !== String(id));
                    if (String(this.templateId) === String(id)) {
                        this.templateId = 'default_qs';
                    }

                    window.Alert ? window.Alert.success('Template berhasil dihapus.') : Swal.fire({ icon: 'success', title: 'Terhapus', text: 'Template telah dihapus.', timer: 1500, showConfirmButton: false });
                } catch (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menghapus',
                        text: err.message || 'Terjadi kesalahan saat menghapus.',
                        confirmButtonColor: '#2563eb'
                    });
                }
            },

            insertPlaceholder(key) {
                const ta = this.$refs.bodyInput;
                const token = this.ph(key);
                if (!ta) { this.body += token; return; }
                const start = ta.selectionStart ?? this.body.length;
                const end = ta.selectionEnd ?? this.body.length;
                this.body = this.body.slice(0, start) + token + this.body.slice(end);
                this.$nextTick(() => { ta.focus(); ta.selectionStart = ta.selectionEnd = start + token.length; });
            },

            sampleData() {
                const first = this.selectedList[0];
                const nama = first?.name || 'Prof. Dr. John Doe';
                const m = nama.trim().match(/^(Prof\. Dr\.|Prof\.|Dr\.|Mr\.|Mrs\.|Ms\.)/i);
                return {
                    nama, title: m ? m[1] : '',
                    email: first?.email || 'john.doe@university.edu',
                    jabatan: 'Professor', universitas_asal: 'University of Example', negara: 'United Kingdom',
                    subject_1: 'Education', subject_2: 'Linguistics', fakultas: 'FBS', prodi: 'Pendidikan Bahasa Inggris',
                    consent_link: cfg.sampleConsentLink,
                };
            },

            render(text, html) {
                const data = this.sampleData();
                let out = html ? esc(text) : String(text ?? '');
                Object.entries(data).forEach(([k, v]) => {
                    const val = !html ? v : (k === 'consent_link' ? `<a href="#" style="color:#2563eb">${esc(v)}</a>` : esc(v));
                    out = out.split(this.ph(k)).join(val);
                });
                return html ? out.replace(/\n/g, '<br>\n') : out;
            },

            get previewSubject() {
                if (this.mode === 'template') {
                    if (this.templateId === 'default_qs') {
                        return cfg.systemSubjects[this.languageMode] || '';
                    }
                    const tpl = this.selectedTemplate;
                    return tpl ? (this.render(tpl.subject, false) || '(Subjek template kosong)') : '(Template tidak ditemukan)';
                }
                return this.render(this.subject, false) || '(Subjek belum diisi)';
            },

            get previewHtml() {
                if (this.mode === 'template') {
                    if (this.templateId === 'default_qs') {
                        return cfg.systemPreviews[this.languageMode] || '';
                    }
                    const tpl = this.selectedTemplate;
                    if (!tpl) {
                        return '<!doctype html><html><body style="font-family:sans-serif;padding:32px;color:#9ca3af;text-align:center"><p>Silakan pilih template email di menu sebelah kiri.</p></body></html>';
                    }
                    const bodyHtml = this.render(tpl.body, true);
                    const button = tpl.include_consent_button
                        ? `<div style="margin-top:24px"><a href="#" style="display:inline-block;padding:12px 20px;background:#2563eb;color:#fff;text-decoration:none;border-radius:7px;font-weight:600">${esc(tpl.button_text || 'Give Consent / Berikan Persetujuan')}</a></div>`
                        : '';
                    return `<!doctype html><html><head><meta charset="utf-8"><style>body{font-family:Arial,sans-serif;line-height:1.65;color:#1f2937;background:#f3f4f6;margin:0;padding:24px}.wrap{max-width:720px;margin:0 auto;background:#fff;border-radius:12px;padding:32px;box-shadow:0 2px 12px rgba(0,0,0,.06)}</style></head><body><div class="wrap"><div>${bodyHtml}</div>${button}</div></body></html>`;
                }

                const bodyHtml = this.body.trim()
                    ? this.render(this.body, true)
                    : '<p style="color:#9ca3af;font-style:italic">Isi email akan tampil di sini...</p>';
                const button = this.includeButton
                    ? `<div style="margin-top:24px"><a href="#" style="display:inline-block;padding:12px 20px;background:#2563eb;color:#fff;text-decoration:none;border-radius:7px;font-weight:600">${esc(this.buttonText || 'Give Consent / Berikan Persetujuan')}</a></div>`
                    : '';
                return `<!doctype html><html><head><meta charset="utf-8"><style>body{font-family:Arial,sans-serif;line-height:1.65;color:#1f2937;background:#f3f4f6;margin:0;padding:24px}.wrap{max-width:720px;margin:0 auto;background:#fff;border-radius:12px;padding:32px;box-shadow:0 2px 12px rgba(0,0,0,.06)}</style></head><body><div class="wrap"><div>${bodyHtml}</div>${button}</div></body></html>`;
            },

            // ---- Kirim ----
            confirmSend() {
                if (this.remaining <= 0) return this.quotaWarning();
                if (!this.selectedCount) {
                    return Swal.fire({ icon: 'warning', title: 'Belum ada penerima', text: 'Pilih minimal satu dosen dari tabel di bawah.', confirmButtonColor: '#2563eb' });
                }
                if (this.overQuota) return this.quotaWarning();

                const missingEmailRecipients = Object.values(this.selected).filter(r => !r.email || !r.email.trim());
                if (missingEmailRecipients.length > 0) {
                    return Swal.fire({
                        icon: 'warning',
                        title: 'Alamat Email Belum Lengkap',
                        html: `Terdapat <b>${missingEmailRecipients.length} dosen terpilih</b> yang belum memiliki alamat email.<br><br>Mohon lengkapi data email dosen terlebih dahulu melalui menu edit sebelum melakukan pengiriman email.`,
                        confirmButtonColor: '#2563eb'
                    });
                }
                if (this.mode === 'manual' && (!this.subject.trim() || !this.body.trim())) {
                    return Swal.fire({ icon: 'warning', title: 'Email belum lengkap', text: 'Subjek dan isi email wajib diisi untuk mode tulis manual.', confirmButtonColor: '#2563eb' });
                }
                if (this.mode === 'template') {
                    if (this.templateId === 'default_qs' && !cfg.hasSystemTemplate) {
                        return Swal.fire({ icon: 'warning', title: 'Template belum tersedia', text: 'Template sistem QS Academic belum dikonfigurasi. Gunakan mode Tulis Manual atau pilih template lain.', confirmButtonColor: '#2563eb' });
                    }
                    if (this.templateId !== 'default_qs' && !this.selectedTemplate) {
                        return Swal.fire({ icon: 'warning', title: 'Pilih template', text: 'Silakan pilih template yang valid dari daftar dropdown.', confirmButtonColor: '#2563eb' });
                    }
                }

                const langLabels = { bilingual: 'Bilingual', en: 'English', id: 'Bahasa Indonesia' };
                let modeLabel = 'Tulis Manual';
                if (this.mode === 'template') {
                    if (this.templateId === 'default_qs') {
                        modeLabel = `Template Sistem QS (${langLabels[this.languageMode] || this.languageMode})`;
                    } else {
                        modeLabel = `Template: ${this.selectedTemplate?.title || ''}`;
                    }
                }

                Swal.fire({
                    title: 'Kirim email sekarang?',
                    html: `<div style="text-align:left;font-size:14px;line-height:1.8">
                        <div>Penerima: <b>${this.selectedCount} dosen</b></div>
                        <div>Mode: <b>${esc(modeLabel)}</b></div>
                        <div>Subjek: <b>${esc(this.previewSubject)}</b></div>
                        <div>Sisa kuota setelah kirim: <b>${this.remainingAfter}</b> / ${this.limit}</div>
                    </div>`,
                    icon: 'question', showCancelButton: true, reverseButtons: true,
                    confirmButtonText: 'Ya, kirim', cancelButtonText: 'Batal', confirmButtonColor: '#2563eb',
                }).then(r => {
                    if (!r.isConfirmed) return;
                    this.sending = true;
                    this.$nextTick(() => this.$refs.form.submit());
                });
            },
        };
    }
</script>

<div x-data="bulkEmailPage(window.__bulkEmailConfig)" class="min-h-screen bg-gray-50 p-4 sm:p-6 lg:p-8">
    <div class="max-w-[1920px] mx-auto">

        {{-- ================= HEADER ================= --}}
        <div class="mb-6">
            <div class="mb-3">
                @include('admin_pemeringkatan.international-lecture.partials.back-button', [
                    'backRoute' => 'admin_pemeringkatan.international-lecture.index',
                    'backParams' => request('from_table') ? ['table' => 1] : [],
                    'backLabel' => 'Kembali ke International Lecture',
                ])
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Email International Lecturer</h1>
            <p class="text-gray-600 mt-1.5 text-sm sm:text-base">
                Kelola pengiriman email dosen asing dan pantau rekapitulasi pengiriman dalam satu fitur.
                Pengiriman dibatasi <b class="text-gray-800">{{ $dailyLimit }} email per hari</b>.
            </p>
        </div>

        {{-- ================= PILIHAN FITUR (3 TOMBOL TERPISAH) ================= --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-6">
            {{-- Tombol 1: Isi & Kirim Email --}}
            <button type="button" @click="showComposer = !showComposer"
                    class="group w-full text-left rounded-2xl border-2 p-5 sm:p-6 shadow-sm transition-all duration-200 focus:outline-none"
                    :class="showComposer 
                        ? 'bg-blue-50/80 border-blue-600 ring-4 ring-blue-100 shadow-md' 
                        : 'bg-white border-gray-200 hover:border-blue-500 hover:bg-blue-50/30 hover:shadow-md'">
                <div class="flex items-center gap-4 sm:gap-5">
                    <span class="flex h-14 w-14 sm:h-16 sm:w-16 shrink-0 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-md transition-transform duration-200 group-hover:scale-105">
                        <i class="fa-solid fa-paper-plane text-2xl"></i>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-lg sm:text-xl font-bold transition-colors"
                              :class="showComposer ? 'text-blue-900' : 'text-gray-900 group-hover:text-blue-600'">
                            Isi &amp; Kirim Email
                        </span>
                        <span class="block mt-1 text-sm sm:text-base transition-colors"
                              :class="showComposer ? 'text-blue-700' : 'text-gray-500'">
                            Buat template, pilih dosen, dan kirim email
                        </span>
                    </span>
                    <i class="fa-solid text-lg sm:text-xl transition-all duration-200"
                       :class="showComposer ? 'fa-chevron-up text-blue-600' : 'fa-chevron-right text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1'"></i>
                </div>
            </button>

            {{-- Tombol 2: Rekap Email --}}
            <a href="{{ route('admin_pemeringkatan.international-lecture.email-recap.index', array_filter(['from_table' => request('from_table')])) }}"
               class="group w-full text-left bg-white rounded-2xl border-2 border-gray-200 p-5 sm:p-6 shadow-sm transition-all duration-200 hover:border-emerald-500 hover:bg-emerald-50/30 hover:shadow-md focus:outline-none block">
                <div class="flex items-center gap-4 sm:gap-5">
                    <span class="flex h-14 w-14 sm:h-16 sm:w-16 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-md transition-transform duration-200 group-hover:scale-105">
                        <i class="fa-solid fa-chart-column text-2xl"></i>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-lg sm:text-xl font-bold text-gray-900 group-hover:text-emerald-700 transition-colors">
                            Rekap Email
                        </span>
                        <span class="block mt-1 text-sm sm:text-base text-gray-500">
                            Lihat riwayat, status, dan kontrol kirim ulang
                        </span>
                    </span>
                    <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-emerald-600 group-hover:translate-x-1 transition-all text-lg sm:text-xl"></i>
                </div>
            </a>

            {{-- Tombol 3: Laporan Email --}}
            <a href="{{ route('admin_pemeringkatan.international-lecture.report.index', array_filter(['from_table' => request('from_table')])) }}"
               class="group w-full text-left bg-white rounded-2xl border-2 border-gray-200 p-5 sm:p-6 shadow-sm transition-all duration-200 hover:border-purple-500 hover:bg-purple-50/30 hover:shadow-md focus:outline-none block">
                <div class="flex items-center gap-4 sm:gap-5">
                    <span class="flex h-14 w-14 sm:h-16 sm:w-16 shrink-0 items-center justify-center rounded-2xl bg-purple-600 text-white shadow-md transition-transform duration-200 group-hover:scale-105">
                        <i class="fa-solid fa-chart-pie text-2xl"></i>
                    </span>
                    <span class="min-w-0 flex-1">
                        <span class="block text-lg sm:text-xl font-bold text-gray-900 group-hover:text-purple-700 transition-colors">
                            Laporan Email
                        </span>
                        <span class="block mt-1 text-sm sm:text-base text-gray-500">
                            Grafik progres, tren, dan respons email dosen asing
                        </span>
                    </span>
                    <i class="fa-solid fa-chevron-right text-gray-400 group-hover:text-purple-600 group-hover:translate-x-1 transition-all text-lg sm:text-xl"></i>
                </div>
            </a>
        </div>

        {{-- ================= FORMULIR PENGIRIMAN EMAIL (TOGGLEABLE) ================= --}}
        <div x-cloak x-show="showComposer" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

            {{-- ================= FLASH & ERRORS ================= --}}
        @if(session('success'))
            <div class="mb-6 flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl shadow-sm">
                <i class="fa-solid fa-circle-check mt-0.5"></i><div class="text-sm whitespace-pre-line">{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 flex items-start gap-3 bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-xl shadow-sm">
                <i class="fa-solid fa-circle-exclamation mt-0.5"></i><div class="text-sm whitespace-pre-line">{{ session('error') }}</div>
            </div>
        @endif
        @if($errors->any())
            <div class="mb-6 bg-rose-50 border border-rose-200 p-4 rounded-xl shadow-sm">
                <ul class="list-disc ml-5 text-sm text-rose-700">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        @if($remainingQuota <= 0)
            <div class="mb-6 flex items-start gap-3 bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-xl shadow-sm">
                <i class="fa-solid fa-hourglass-half mt-0.5"></i>
                <div class="text-sm">Kuota pengiriman hari ini (<b>{{ $dailyLimit }} email</b>) sudah habis. Anda tetap bisa menyiapkan email & memilih penerima, namun pengiriman baru bisa dilakukan besok.</div>
            </div>
        @endif


        {{-- ================= STEP 1: KOMPOSISI EMAIL ================= --}}
        <form x-ref="form" id="bulkEmailForm" method="POST" enctype="multipart/form-data" action="{{ route('admin_pemeringkatan.international-lecture.email.send') }}" @submit.prevent="confirmSend()">
            @csrf
            <input type="hidden" name="template_id" :value="templateId">
            <template x-for="r in selectedList" :key="r.id">
                <input type="hidden" name="lecturer_ids[]" :value="r.id">
            </template>

            <section class="bg-white rounded-xl shadow-sm border border-gray-200/80 mb-6 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white text-sm font-bold shadow-sm">1</span>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">Isi Email</h2>
                    </div>
                </div>

                <div class="p-5 sm:p-6">
                    {{-- Pilihan mode --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                        <label id="mode-template-card" class="group relative cursor-pointer rounded-xl border-2 p-4 transition-all"
                               :class="mode === 'template' ? 'border-blue-600 bg-blue-50/70 shadow-sm ring-2 ring-blue-100' : 'border-gray-200 hover:border-blue-300 hover:bg-gray-50'">
                            <input type="radio" name="mode" value="template" x-model="mode" class="sr-only">
                            <div class="flex items-center gap-3">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg transition"
                                      :class="mode === 'template' ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-600'">
                                    <i class="fa-solid fa-file-lines text-lg"></i>
                                </span>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800">Gunakan Template Sistem</div>
                                </div>
                                <i class="fa-solid fa-circle-check text-blue-600 text-lg" x-show="mode === 'template'" x-transition></i>
                            </div>
                        </label>

                        <label id="mode-manual-card" class="group relative cursor-pointer rounded-xl border-2 p-4 transition-all"
                               :class="mode === 'manual' ? 'border-blue-600 bg-blue-50/70 shadow-sm ring-2 ring-blue-100' : 'border-gray-200 hover:border-blue-300 hover:bg-gray-50'">
                            <input type="radio" name="mode" value="manual" x-model="mode" class="sr-only">
                            <div class="flex items-center gap-3">
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg transition"
                                      :class="mode === 'manual' ? 'bg-blue-600 text-white' : 'bg-blue-50 text-blue-600'">
                                    <i class="fa-solid fa-pen-to-square text-lg"></i>
                                </span>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800">Tulis Manual</div>
                                </div>
                                <i class="fa-solid fa-circle-check text-blue-600 text-lg" x-show="mode === 'manual'" x-transition></i>
                            </div>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 xl:grid-cols-5 gap-6">
                        {{-- Kolom form --}}
                        <div class="xl:col-span-2">

                            {{-- MODE TEMPLATE --}}
                            <div x-show="mode === 'template'" x-transition.opacity class="space-y-4">
                                <div>
                                    <div class="flex items-center justify-between gap-2 mb-1.5">
                                        <label for="template_select" class="block text-sm font-semibold text-gray-700">Pilihan Template Email</label>
                                        @if(auth()->user() && in_array(auth()->user()->role, ['admin_direktorat', 'admin_pemeringkatan']))
                                            <button type="button" @click="openAdminCreateModal()"
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition shadow-2xs">
                                                <i class="fa-solid fa-circle-plus"></i> Buat Template Baru (Admin)
                                            </button>
                                        @endif
                                    </div>
                                    <select id="template_select" x-model="templateId"
                                            class="w-full px-3.5 py-2.5 text-sm bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                        <optgroup label="Template Sistem (Resmi & Global)">
                                            <option value="default_qs">QS Academic Respondent (Resmi Sistem - Multi Bahasa)</option>
                                            <template x-for="tpl in systemTemplates" :key="tpl.id">
                                                <option :value="String(tpl.id)" x-text="tpl.title"></option>
                                            </template>
                                        </optgroup>
                                        <template x-if="myTemplates.length > 0">
                                            <optgroup label="Template Saya (Tersimpan di Akun Ini)">
                                                <template x-for="tpl in myTemplates" :key="tpl.id">
                                                    <option :value="String(tpl.id)" x-text="tpl.title"></option>
                                                </template>
                                            </optgroup>
                                        </template>
                                    </select>
                                </div>

                                {{-- Jika memilih default QS: tampilkan pilihan bahasa --}}
                                <div x-show="templateId === 'default_qs'" x-transition class="space-y-4">
                                    <div>
                                        <label for="language_mode" class="block text-sm font-semibold text-gray-700 mb-1.5">Bahasa Template QS</label>
                                        <select id="language_mode" name="language_mode" x-model="languageMode" :disabled="mode !== 'template'"
                                                class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none">
                                            <option value="bilingual">Bilingual - English + Bahasa Indonesia</option>
                                            <option value="en">English</option>
                                            <option value="id">Bahasa Indonesia</option>
                                        </select>
                                    </div>
                                    @if(!$hasSystemTemplate)
                                        <div class="flex gap-3 bg-amber-50 border border-amber-200 text-amber-800 text-xs rounded-lg p-3.5">
                                            <i class="fa-solid fa-triangle-exclamation mt-0.5"></i>
                                            <div>Template sistem <b>QS Academic</b> belum dikonfigurasi. Silakan atur template email terlebih dahulu atau pilih template lain.</div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Jika memilih template kustom dari DB --}}
                                <div x-show="templateId !== 'default_qs' && selectedTemplate" x-transition class="space-y-3">
                                    <div class="flex items-center justify-between gap-2 pt-1">
                                        <button type="button" @click="copyToManual()"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 hover:text-blue-600 transition shadow-2xs">
                                            <i class="fa-solid fa-pen-to-square"></i> Pakai & Edit di Tulis Manual
                                        </button>
                                        <button type="button" x-show="canDeleteTemplate(selectedTemplate)" @click="deleteTemplate(selectedTemplate.id)"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-white border border-rose-300 text-rose-600 hover:bg-rose-50 transition ml-auto shadow-2xs">
                                            <i class="fa-solid fa-trash-can"></i> Buang Template
                                        </button>
                                    </div>

                                    <div class="flex gap-2.5 bg-blue-50 border border-blue-200 text-blue-800 text-xs rounded-lg p-3">
                                        <i class="fa-solid fa-circle-check mt-0.5 text-blue-600 shrink-0"></i>
                                        <div>Variabel seperti <code class="bg-blue-100 px-1 py-0.5 rounded text-[11px] font-mono">&#123;&#123;nama&#125;&#125;</code>, <code class="bg-blue-100 px-1 py-0.5 rounded text-[11px] font-mono">&#123;&#123;universitas_asal&#125;&#125;</code>, dll. pada template ini otomatis disesuaikan untuk masing-masing dosen penerima.</div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Subjek Email</label>
                                    <div class="w-full px-3.5 py-2.5 text-sm bg-gray-100 border border-gray-200 rounded-lg text-gray-700 font-medium truncate" x-text="previewSubject"></div>
                                </div>

                                {{-- Upload foto sederhana, tepat di bawah subjek email --}}
                                <div>
                                    <label for="email_photo_tpl" class="block text-sm font-semibold text-gray-700 mb-1.5">Upload Foto (Opsional)</label>
                                    <input id="email_photo_tpl" name="email_photo" type="file" accept="image/jpeg,image/png,image/webp" :disabled="mode !== 'template'"
                                           @change="const f = $event.target.files?.[0]; photoName = f?.name || ''; photoPreview = f ? URL.createObjectURL(f) : '';"
                                           class="w-full text-sm text-gray-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-600 file:px-3.5 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-700" />
                                    <div x-show="photoPreview" x-cloak class="mt-3">
                                        <img :src="photoPreview" alt="Preview foto" class="max-h-48 w-auto max-w-full rounded-lg border border-gray-200 object-contain shadow-sm">
                                    </div>
                                </div>
                            </div>

                            {{-- MODE MANUAL --}}
                            <div x-show="mode === 'manual'" x-transition.opacity class="space-y-5" x-cloak>
                                <div class="rounded-xl border border-gray-200 bg-white p-3.5 shadow-xs">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                                        <label for="text_template" class="block text-sm font-semibold text-gray-700">Ambil dari Template Teks (Opsional)</label>
                                        {{-- Tombol Simpan ke Template Sistem --}}
                                        <button type="button" id="save-as-template-btn" @click="saveManualAsTemplate()" :disabled="savingTemplate || !subject.trim() || !body.trim()"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 disabled:opacity-40 disabled:cursor-not-allowed transition shadow-xs self-start sm:self-auto">
                                            <i class="fa-solid" :class="savingTemplate ? 'fa-spinner fa-spin' : 'fa-bookmark'"></i>
                                            <span x-text="savingTemplate ? 'Menyimpan...' : 'Simpan ke Template Sistem'"></span>
                                        </button>
                                    </div>
                                    <div class="flex gap-2">
                                        <select id="text_template" x-model="templateKey"
                                                class="flex-1 min-w-0 px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg text-gray-800 focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none">
                                            <option value="">-- Pilih template bawaan --</option>
                                            @foreach($textTemplates as $key => $tpl)
                                                <option value="{{ $key }}">{{ $tpl['label'] ?? $key }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" id="load-template-btn" @click="loadTextTemplate()" :disabled="!templateKey"
                                                class="shrink-0 inline-flex items-center gap-1.5 px-3.5 py-2 text-sm font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-40 disabled:cursor-not-allowed transition">
                                            <i class="fa-solid fa-file-import"></i> Muat
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label for="subject" class="block text-sm font-semibold text-gray-700 mb-1.5">Subjek Email <span class="text-rose-500">*</span></label>
                                    <input id="subject" type="text" name="subject" x-model="subject" maxlength="255" :disabled="mode !== 'manual'"
                                           placeholder="Contoh: Invitation to QS Academic Respondent - Universitas Negeri Jakarta"
                                           class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none">
                                </div>

                                {{-- Upload foto sederhana, tepat di bawah subjek email --}}
                                <div>
                                    <label for="email_photo" class="block text-sm font-semibold text-gray-700 mb-1.5">Upload Foto (Opsional)</label>
                                    <input id="email_photo" name="email_photo" type="file" accept="image/jpeg,image/png,image/webp" :disabled="mode !== 'manual'"
                                           @change="const f = $event.target.files?.[0]; photoName = f?.name || ''; photoPreview = f ? URL.createObjectURL(f) : '';"
                                           class="w-full text-sm text-gray-600 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-600 file:px-3.5 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-blue-700" />
                                    <div x-show="photoPreview" x-cloak class="mt-3">
                                        <img :src="photoPreview" alt="Preview foto" class="max-h-48 w-auto max-w-full rounded-lg border border-gray-200 object-contain shadow-sm">
                                    </div>
                                </div>

                                <div>
                                    <div class="flex items-end justify-between mb-1.5">
                                        <label for="body" class="block text-sm font-semibold text-gray-700">Isi Email <span class="text-rose-500">*</span></label>
                                        <span class="text-[11px] text-gray-400" x-text="body.length.toLocaleString('id-ID') + ' karakter'"></span>
                                    </div>
                                    <div class="flex flex-wrap gap-1.5 mb-2">
                                        <span class="text-[11px] text-gray-500 mr-1 self-center">Sisipkan:</span>
                                        <template x-for="p in placeholders" :key="p.key">
                                            <button type="button" @click="insertPlaceholder(p.key)" :title="ph(p.key)"
                                                    class="px-2 py-0.5 text-[11px] font-medium rounded-md bg-gray-100 text-gray-700 border border-gray-200 hover:bg-blue-50 hover:text-blue-700 hover:border-blue-200 transition"
                                                    x-text="p.label"></button>
                                        </template>
                                    </div>
                                    <textarea id="body" name="body" x-ref="bodyInput" x-model="body" rows="14" :disabled="mode !== 'manual'"
                                              placeholder="Dear ...,&#10;&#10;Tulis isi email di sini. Gunakan tombol 'Sisipkan' di atas untuk menambahkan data dosen secara otomatis."
                                              class="w-full px-3.5 py-3 text-sm leading-relaxed bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none font-mono"></textarea>
                                    <p class="mt-1 text-[11px] text-gray-500">Data dalam kurung kurawal ganda akan otomatis diganti dengan data masing-masing dosen saat dikirim.</p>
                                </div>

                                <div class="rounded-xl border border-gray-200 p-3.5 space-y-3">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" id="include_consent_button" name="include_consent_button" value="1" x-model="includeButton" :disabled="mode !== 'manual'"
                                               class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm text-gray-700"><b>Sertakan tombol consent</b> <span class="text-gray-500">(link unik per dosen)</span></span>
                                    </label>
                                    <div x-show="includeButton" x-transition>
                                        <label for="button_text" class="block text-xs font-semibold text-gray-600 mb-1">Teks Tombol</label>
                                        <input id="button_text" type="text" name="button_text" x-model="buttonText" maxlength="100" :disabled="mode !== 'manual'"
                                               class="w-full px-3 py-2 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom preview --}}
                        <div class="xl:col-span-3">
                            <div class="rounded-xl border border-gray-200 overflow-hidden shadow-sm bg-white">
                                <div class="flex items-center gap-2 px-4 py-2.5 bg-gray-800 text-gray-200">
                                    <span class="h-2.5 w-2.5 rounded-full bg-rose-400"></span>
                                    <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                                    <span class="ml-2 text-xs font-semibold tracking-wide">Preview Email</span>
                                    <span class="ml-auto text-[10px] text-gray-400"
                                          x-text="selectedCount ? 'Contoh untuk: ' + selectedList[0].name : 'Menggunakan data contoh'"></span>
                                </div>
                                <div class="px-4 py-3 border-b border-gray-100 text-sm space-y-0.5">
                                    <div class="text-gray-500"><span class="inline-block w-16 text-gray-400">Dari</span> {{ config('mail.from.name') }} &lt;{{ config('mail.from.address') }}&gt;</div>
                                    <div class="text-gray-500 truncate"><span class="inline-block w-16 text-gray-400">Kepada</span>
                                        <span x-text="selectedCount ? (selectedList[0].email + (selectedCount > 1 ? ' (+' + (selectedCount - 1) + ' lainnya)' : '')) : '—'"></span>
                                    </div>
                                    <div class="font-semibold text-gray-800 truncate"><span class="inline-block w-16 font-normal text-gray-400">Subjek</span> <span x-text="previewSubject"></span></div>
                                </div>
                                <iframe id="email-preview-frame" title="Preview email" sandbox class="w-full h-[560px] bg-gray-100 block" :srcdoc="previewHtml"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </form>

        {{-- ================= PEMBATAS ANTARA STEP 1 & STEP 2 ================= --}}
        <div class="my-20 sm:my-28 lg:my-32 border-t-4 border-black rounded-full"></div>

        {{-- ================= STEP 2: PILIH PENERIMA ================= --}}
        <section class="mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200/80 mb-4 overflow-hidden">
                <div class="px-5 sm:px-6 py-4 border-b border-gray-100 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white text-sm font-bold shadow-sm">2</span>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Pilih Penerima</h2>
                        </div>
                    </div>
                </div>

                {{-- Ringkasan penerima terpilih --}}
                <div class="px-5 sm:px-6 py-3.5 bg-gray-50/70">
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="flex-1 min-w-[220px]">
                            <div class="flex items-center justify-between text-xs mb-1">
                                <span class="font-semibold text-gray-700"><span x-text="selectedCount"></span> dosen dipilih</span>
                                <span class="text-gray-500">maks. {{ $remainingQuota }} hari ini</span>
                            </div>
                            <div class="h-2 rounded-full bg-gray-200 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-300"
                                     :class="overQuota ? 'bg-rose-500' : (selectionPercent >= 90 ? 'bg-amber-500' : 'bg-blue-600')"
                                     :style="'width:' + selectionPercent + '%'"></div>
                            </div>
                        </div>
                        <button type="button" @click="showSelectedList = !showSelectedList" x-show="selectedCount"
                                class="text-xs font-semibold text-blue-700 hover:text-blue-900 inline-flex items-center gap-1">
                            <i class="fa-solid" :class="showSelectedList ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                            <span x-text="showSelectedList ? 'Sembunyikan daftar' : 'Lihat daftar penerima'"></span>
                        </button>
                    </div>
                    <div x-show="showSelectedList && selectedCount" x-transition x-cloak class="mt-3 max-h-48 overflow-y-auto flex flex-wrap gap-1.5">
                        <template x-for="r in selectedList" :key="r.id">
                            <span class="inline-flex items-center gap-1.5 pl-2.5 pr-1 py-1 rounded-full bg-white border border-blue-200 text-xs text-gray-700 shadow-sm">
                                <span class="font-medium" x-text="r.name"></span>
                                <span class="text-gray-400" x-text="r.email"></span>
                                <button type="button" @click="remove(r.id)" class="h-5 w-5 inline-flex items-center justify-center rounded-full text-gray-400 hover:bg-rose-50 hover:text-rose-600" title="Hapus">
                                    <i class="fa-solid fa-xmark text-[10px]"></i>
                                </button>
                            </span>
                        </template>
                    </div>
                </div>
            </div>

            {{-- ================= ALERT: DATA KOSONG PADA DOSEN TERPILIH ================= --}}
            <div id="incomplete-data-alert" x-show="hasIncompleteSelected" x-transition.duration.300ms x-cloak
                 class="mb-3 rounded-xl border-2 border-amber-300 bg-amber-50/95 p-4 sm:p-5 shadow-sm">
                <div class="flex items-start gap-3.5 sm:gap-4">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-700 border border-amber-200">
                        <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1.5">
                            <h3 class="text-base font-bold text-amber-900 flex items-center gap-2">
                                <span>Pemberitahuan: Terdapat Data Dosen Terpilih yang Belum Lengkap</span>
                            </h3>
                            <span class="text-xs font-semibold text-amber-800 bg-amber-200/80 px-2.5 py-0.5 rounded-full w-fit">
                                <span x-text="incompleteSelectedList.length"></span> Dosen Perlu Dilengkapi
                            </span>
                        </div>
                        <p class="text-xs sm:text-sm text-amber-800 mt-1.5 leading-relaxed">
                            Terdapat data yang masih kosong pada dosen yang Anda pilih. Mohon lengkapi kolom data tersebut terlebih dahulu melalui tombol di bawah ini sebelum melakukan pengiriman email:
                        </p>
                        
                        <div class="mt-3.5 space-y-2 max-h-56 overflow-y-auto pr-1">
                            <template x-for="item in incompleteSelectedList" :key="item.id">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 p-3 rounded-lg bg-white border border-amber-200 shadow-2xs">
                                    <div class="min-w-0">
                                        <div class="font-semibold text-gray-800 text-sm" x-text="item.name"></div>
                                        <div class="text-xs text-amber-800 mt-1 flex items-center gap-1.5 flex-wrap">
                                            <span class="font-medium text-gray-600">Data yang masih kosong:</span>
                                            <template x-for="(f, idx) in item.missing" :key="idx">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-200" x-text="f"></span>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2 shrink-0">
                                        <a :href="item.editUrl" target="_blank"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition shadow-2xs">
                                            <i class="fa-solid fa-pen-to-square text-[11px]"></i> Lengkapi Data
                                        </a>
                                        <button type="button" @click="remove(item.id)"
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium text-gray-500 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                                title="Hapus dari daftar pilihan">
                                            <i class="fa-solid fa-xmark text-xs"></i> Batal Pilih
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Alert data belum lengkap jika ada dosen terpilih yang tidak lengkap (Perhatian) --}}
            <div x-show="hasIncompleteSelected" x-transition.duration.300ms x-cloak
                 class="mb-4 rounded-xl border border-amber-300 bg-amber-50 p-3.5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs sm:text-sm text-amber-900 shadow-2xs">
                <div class="flex items-center gap-2.5 min-w-0">
                    <i class="fa-solid fa-triangle-exclamation text-amber-600 text-base shrink-0"></i>
                    <span>Perhatian: Terdapat <strong class="font-bold" x-text="incompleteSelectedList.length"></strong> dosen terpilih yang memiliki kolom data kosong. Mohon lengkapi data terlebih dahulu.</span>
                </div>
                <button type="button" @click="document.getElementById('incomplete-data-alert')?.scrollIntoView({ behavior: 'smooth', block: 'nearest' })"
                        class="inline-flex items-center justify-center gap-1.5 px-3 py-1.5 text-xs font-semibold rounded-lg bg-amber-200/80 hover:bg-amber-200 text-amber-900 transition shrink-0">
                    <i class="fa-solid fa-arrow-up text-[10px]"></i> Lihat Rincian di Atas
                </button>
            </div>

            <div id="recipient-filter" class="scroll-mt-4">
                @include('admin_pemeringkatan.international-lecture.partials.filter', [
                    'filterRoute' => 'admin_pemeringkatan.international-lecture.email.index',
                    'showBulkActions' => true,
                    'persistQuery' => ['compose' => 1],
                    'filterAnchor' => 'recipient-filter',
                ])
            </div>

            @include('admin_pemeringkatan.international-lecture.partials.table', [
                'showActions' => false,
                'selectable' => true,
                'persistQuery' => ['compose' => 1],
                'filterAnchor' => 'recipient-filter',
            ])
        </section>

        {{-- ================= STICKY ACTION BAR ================= --}}
        <div class="sticky bottom-4 z-30">
            <div class="rounded-xl border border-gray-200 bg-white/95 backdrop-blur shadow-lg px-4 sm:px-5 py-3 flex flex-col sm:flex-row sm:items-center gap-3">
                <div class="flex items-center gap-3 flex-1 min-w-0">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-600 text-white shadow-sm">
                        <i class="fa-solid" :class="mode === 'template' ? 'fa-file-lines' : 'fa-pen-to-square'"></i>
                    </span>
                    <div class="min-w-0">
                        <div class="text-sm font-semibold text-gray-800">
                            <span x-text="selectedCount"></span> penerima dipilih
                            <span class="font-normal text-gray-400">·</span>
                            <span class="font-normal text-gray-600" x-text="mode === 'template' ? 'Template Sistem' : 'Tulis Manual'"></span>
                        </div>
                        <div class="text-xs truncate" :class="overQuota || remaining <= 0 ? 'text-rose-600 font-semibold' : 'text-gray-500'"
                             x-text="remaining <= 0 ? 'Kuota hari ini habis ({{ $dailyLimit }}/hari)' : (overQuota ? 'Melebihi sisa kuota hari ini (' + remaining + ')' : 'Sisa kuota setelah kirim: ' + remainingAfter + ' / ' + limit)"></div>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" id="clear-selection-btn" @click="clearSelection()" :disabled="!selectedCount"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 text-sm font-medium rounded-lg bg-white text-rose-600 border border-rose-200 hover:bg-rose-50 disabled:opacity-40 disabled:cursor-not-allowed transition">
                        <i class="fa-solid fa-xmark text-xs"></i>
                        <span>Kosongkan Semua Penerima</span>
                    </button>
                    <a href="{{ route('admin_pemeringkatan.international-lecture.index', request('from_table') ? ['table' => 1] : []) }}" id="cancel-bulk-email"
                       class="px-4 py-2.5 text-sm font-medium rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition">Batal</a>
                    <button type="submit" form="bulkEmailForm" id="send-bulk-email-btn"
                            :disabled="sending || remaining <= 0 || !selectedCount || overQuota"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-semibold rounded-lg text-white shadow-md bg-blue-600 hover:bg-blue-700 active:translate-y-0.5 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fa-solid" :class="sending ? 'fa-spinner fa-spin' : 'fa-paper-plane'"></i>
                        <span x-text="sending ? 'Memproses...' : 'Kirim Email (' + selectedCount + ')'"></span>
                    </button>
                </div>
            </div>
        </div>

        {{-- ================= MODAL BUAT TEMPLATE BARU (ADMIN) ================= --}}
        @if(auth()->user() && in_array(auth()->user()->role, ['admin_direktorat', 'admin_pemeringkatan']))
            <div x-show="showAdminModal" x-cloak
                 class="fixed inset-0 z-50 overflow-y-auto bg-gray-900/60 backdrop-blur-xs flex items-center justify-center p-4"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <div class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col overflow-hidden border border-gray-200"
                     @click.away="showAdminModal = false">
                    
                    {{-- Header Modal --}}
                    <div class="px-6 py-4 bg-gray-800 text-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                                <i class="fa-solid fa-envelope-open-text text-lg"></i>
                            </span>
                            <div>
                                <h3 class="text-base font-bold">Buat Template Email Baru (Admin)</h3>
                                <p class="text-xs text-gray-300">
                                    Admin: <span class="font-semibold text-white">{{ auth()->user()?->name ?? 'Admin' }}</span>
                                    @if(auth()->user()?->email) <span class="text-gray-400">&lt;{{ auth()->user()->email }}&gt;</span> @endif
                                </p>
                            </div>
                        </div>
                        <button type="button" @click="showAdminModal = false" class="text-gray-400 hover:text-white p-1 rounded-lg hover:bg-gray-700 transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    {{-- Body Modal --}}
                    <div class="p-6 overflow-y-auto space-y-4 text-sm flex-1">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama / Judul Template <span class="text-rose-500">*</span></label>
                            <input type="text" x-model="adminForm.title" maxlength="150" placeholder="Contoh: Undangan Guest Lecture Semester Genap"
                                   class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Subjek Email <span class="text-rose-500">*</span></label>
                            <input type="text" x-model="adminForm.subject" maxlength="255" placeholder="Contoh: Invitation to Guest Lecture at Universitas Negeri Jakarta"
                                   class="w-full px-3.5 py-2.5 text-sm bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none">
                        </div>

                        <div>
                            <div class="flex items-end justify-between mb-1.5">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Isi Email <span class="text-rose-500">*</span></label>
                                <span class="text-[11px] text-gray-400" x-text="adminForm.body.length.toLocaleString('id-ID') + ' karakter'"></span>
                            </div>
                            <div class="flex flex-wrap gap-1.5 mb-2">
                                <span class="text-[11px] text-gray-500 mr-1 self-center">Sisipkan:</span>
                                <template x-for="p in placeholders" :key="p.key">
                                    <button type="button" @click="insertAdminPlaceholder(p.key)" :title="ph(p.key)"
                                            class="px-2 py-0.5 text-[11px] font-medium rounded-md bg-gray-100 text-gray-700 border border-gray-200 hover:bg-blue-50 hover:text-blue-700 hover:border-blue-200 transition"
                                            x-text="p.label"></button>
                                </template>
                            </div>
                            <textarea x-ref="adminBodyInput" x-model="adminForm.body" rows="8"
                                      placeholder="Dear @{{nama}},&#10;&#10;Tuliskan isi template di sini..."
                                      class="w-full px-3.5 py-3 text-sm leading-relaxed bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:bg-white focus:outline-none font-mono"></textarea>
                            <p class="mt-1 text-[11px] text-gray-500">Placeholder kurung kurawal ganda akan otomatis terisi data dosen saat email dikirim.</p>
                        </div>

                        <div class="rounded-xl border border-gray-200 p-3.5 space-y-3 bg-gray-50/50">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" x-model="adminForm.include_consent_button"
                                       class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="text-xs font-semibold text-gray-700">Sertakan tombol consent / konfirmasi persetujuan</span>
                            </label>
                            <div x-show="adminForm.include_consent_button" x-transition>
                                <label class="block text-xs font-semibold text-gray-600 mb-1">Teks Tombol</label>
                                <input type="text" x-model="adminForm.button_text" maxlength="100"
                                       class="w-full px-3 py-2 text-xs bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            </div>
                        </div>

                        <div class="rounded-xl border border-blue-200 bg-blue-50/50 p-3.5 space-y-2">
                            <div class="text-xs font-bold text-gray-800 uppercase tracking-wider">Pilihan Visibilitas Template</div>
                            <label class="flex items-start gap-2.5 cursor-pointer">
                                <input type="radio" name="admin_is_system" :value="true" x-model="adminForm.is_system"
                                       class="mt-0.5 text-blue-600 focus:ring-blue-500">
                                <div>
                                    <div class="text-xs font-semibold text-gray-800">Template Sistem (Global)</div>
                                    <p class="text-[11px] text-gray-500">Tampil di daftar template semua pengguna & admin.</p>
                                </div>
                            </label>
                            <label class="flex items-start gap-2.5 cursor-pointer pt-1">
                                <input type="radio" name="admin_is_system" :value="false" x-model="adminForm.is_system"
                                       class="mt-0.5 text-blue-600 focus:ring-blue-500">
                                <div>
                                    <div class="text-xs font-semibold text-gray-800">Template Khusus Akun Admin Saya (Privat)</div>
                                    <p class="text-[11px] text-gray-500">Hanya tampil di akun Anda saja.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Footer Modal --}}
                    <div class="px-6 py-3.5 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-2.5">
                        <button type="button" @click="showAdminModal = false" :disabled="adminForm.saving"
                                class="px-4 py-2 text-xs font-semibold rounded-lg bg-white border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                            Batal
                        </button>
                        <button type="button" @click="submitAdminTemplate()" :disabled="adminForm.saving"
                                class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-semibold rounded-lg bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 transition shadow-xs">
                            <i class="fa-solid" :class="adminForm.saving ? 'fa-spinner fa-spin' : 'fa-check'"></i>
                            <span x-text="adminForm.saving ? 'Menyimpan...' : 'Simpan Template'"></span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
        </div>
    </div>
</div>
@endsection
