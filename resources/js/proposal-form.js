document.addEventListener('alpine:init', () => {
    Alpine.data('proposalFormData', () => ({
        ketua: { provinsi: '', kota: '', kecamatan: '', kelurahan: '' },
        anggota: [],
        regions: {
            'DKI Jakarta': {
                'Jakarta Pusat': { 'Gambir': ['Gambir', 'Cideng', 'Petojo'], 'Tanah Abang': ['Bendungan Hilir', 'Karet Tengsin'] },
                'Jakarta Timur': { 'Cakung': ['Cakung Barat', 'Cakung Timur'], 'Jatinegara': ['Bali Mester', 'Kampung Melayu'] },
                'Jakarta Selatan': { 'Kebayoran Baru': ['Selong', 'Gunung'], 'Tebet': ['Tebet Barat', 'Tebet Timur'] },
                'Jakarta Barat': { 'Grogol Petamburan': ['Tomang', 'Grogol'], 'Kembangan': ['Kembangan Selatan', 'Kembangan Utara'] },
                'Jakarta Utara': { 'Penjaringan': ['Penjaringan', 'Pluit'], 'Tanjung Priok': ['Tanjung Priok', 'Kebon Bawang'] }
            },
            'Jawa Barat': {
                'Kota Bandung': { 'Coblong': ['Dago', 'Sekeloa'], 'Sukasari': ['Gegerkalong', 'Sarijadi'] },
                'Kota Bekasi': { 'Bekasi Timur': ['Aren Jaya', 'Bekasi Jaya'], 'Bekasi Barat': ['Bintara', 'Kranji'] }
            },
            'Banten': {
                'Kota Tangerang': { 'Cipondoh': ['Cipondoh', 'Poris Plawad'], 'Karawaci': ['Karawaci', 'Nambo Jaya'] },
                'Kota Tangerang Selatan': { 'Ciputat': ['Cipayung', 'Ciputat'], 'Serpong': ['Serpong', 'Rawabuntu'] }
            }
        },
        addAnggota() {
            this.anggota.push({
                provinsi: '',
                kota: '',
                kecamatan: '',
                kelurahan: ''
            });
        },
        removeAnggota(index) {
            this.anggota.splice(index, 1);
        }
    }));
});
