document.addEventListener('alpine:init', () => {
    Alpine.data('proposalFormData', () => ({
        ketua: { provinsi: '', kota: '', kecamatan: '', kelurahan: '' },
        anggota: [],
        regions: {
            'Banten': {
                'Kota Serang': {
                    'Serang': ['Cipare', 'Cimuncang', 'Lopang'],
                    'Taktakan': ['Taktakan', 'Pancur', 'Sayar']
                },
                'Kota Tangerang': {
                    'Cipondoh': ['Cipondoh', 'Poris Plawad', 'Kenanga'],
                    'Karawaci': ['Karawaci', 'Nambo Jaya', 'Pabuaran']
                },
                'Kota Tangerang Selatan': {
                    'Ciputat': ['Cipayung', 'Ciputat', 'Sawah Baru'],
                    'Serpong': ['Serpong', 'Rawabuntu', 'Ciater']
                },
                 'Kabupaten Lebak': {
                    'Rangkasbitung': ['Cijoro Lebak', 'Muara Ciujung Timur', 'Rangkasbitung Barat'],
                    'Maja': ['Maja', 'Gubugan Cibeureum', 'Sindangmulya']
                }
            },
            'DKI Jakarta': {
                'Jakarta Pusat': {
                    'Gambir': ['Gambir', 'Cideng', 'Petojo Selatan'],
                    'Tanah Abang': ['Bendungan Hilir', 'Karet Tengsin', 'Kebon Melati']
                },
                'Jakarta Timur': {
                    'Cakung': ['Cakung Barat', 'Cakung Timur', 'Rawa Terate'],
                    'Jatinegara': ['Bali Mester', 'Kampung Melayu', 'Bidara Cina']
                },
                'Jakarta Selatan': {
                    'Kebayoran Baru': ['Selong', 'Gunung', 'Kramat Pela'],
                    'Tebet': ['Tebet Barat', 'Tebet Timur', 'Kebon Baru']
                },
                'Jakarta Barat': {
                    'Grogol Petamburan': ['Tomang', 'Grogol', 'Jelambar'],
                    'Kembangan': ['Kembangan Selatan', 'Kembangan Utara', 'Meruya Utara']
                },
                'Jakarta Utara': {
                    'Penjaringan': ['Penjaringan', 'Pluit', 'Kapuk Muara'],
                    'Tanjung Priok': ['Tanjung Priok', 'Kebon Bawang', 'Sunter Agung']
                }
            },
            'Jawa Barat': {
                'Kota Bandung': {
                    'Coblong': ['Dago', 'Sekeloa', 'Cipaganti'],
                    'Sukasari': ['Gegerkalong', 'Sarijadi', 'Isola']
                },
                'Kota Bogor': {
                    'Bogor Tengah': ['Pabaton', 'Sempur', 'Cibogor'],
                    'Bogor Timur': ['Baranangsiang', 'Katulampa', 'Sukasari']
                },
                'Kota Bekasi': {
                    'Bekasi Timur': ['Aren Jaya', 'Bekasi Jaya', 'Duren Jaya'],
                    'Bekasi Barat': ['Bintara', 'Kranji', 'Jakasampurna']
                },
                 'Kabupaten Bandung': {
                    'Cileunyi': ['Cileunyi Kulon', 'Cileunyi Wetan', 'Cinunuk'],
                    'Dayeuhkolot': ['Citeureup', 'Dayeuhkolot', 'Pasawahan']
                }
            },
            'Jawa Tengah': {
                'Kota Semarang': {
                    'Semarang Tengah': ['Miroto', 'Pendrikan Kidul', 'Sekayu'],
                    'Banyumanik': ['Banyumanik', 'Gedawang', 'Pudakpayung']
                },
                'Kota Surakarta (Solo)': {
                    'Laweyan': ['Bumi', 'Laweyan', 'Penumping'],
                    'Pasar Kliwon': ['Baluwarti', 'Gajahan', 'Kampung Baru']
                },
                'Kabupaten Magelang': {
                    'Mungkid': ['Mendut', 'Mungkid', 'Sawitan'],
                    'Borobudur': ['Borobudur', 'Candirejo', 'Wanurejo']
                }
            },
            'DI Yogyakarta': {
                'Kota Yogyakarta': {
                    'Gondokusuman': ['Demangan', 'Klitren', 'Terban'],
                    'Kotagede': ['Prenggan', 'Rejowinangun', 'Purbayan']
                },
                'Kabupaten Sleman': {
                    'Depok': ['Condongcatur', 'Caturtunggal', 'Maguwoharjo'],
                    'Mlati': ['Sinduadi', 'Tirtoadi', 'Tlogoadi']
                },
                'Kabupaten Bantul': {
                    'Bantul': ['Bantul', 'Palbapang', 'Trirenggo'],
                    'Kasihan': ['Bangunjiwo', 'Ngestiharjo', 'Tirtonirmolo']
                }
            },
            'Jawa Timur': {
                'Kota Surabaya': {
                    'Gubeng': ['Airlangga', 'Gubeng', 'Kertajaya'],
                    'Wonokromo': ['Darmo', 'Jagir', 'Wonokromo']
                },
                'Kota Malang': {
                    'Klojen': ['Klojen', 'Rampal Celaket', 'Samaan'],
                    'Lowokwaru': ['Jatimulyo', 'Lowokwaru', 'Tulusrejo']
                },
                'Kabupaten Sidoarjo': {
                    'Sidoarjo': ['Celep', 'Magersari', 'Sidokumpul'],
                    'Waru': ['Bungurasih', 'Waru', 'Medaeng']
                }
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
