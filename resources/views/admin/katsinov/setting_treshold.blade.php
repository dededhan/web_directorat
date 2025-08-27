<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Pengaturan Katsinov</title>
    {{-- Menambahkan Bootstrap agar tidak terlihat kosong sama sekali --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Pengaturan KATSINOV</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.katsinov.settings.update') }}">
                            @csrf

                            <div class="form-group mb-3">
                                <label for="katsinov_threshold" class="form-label">
                                    Ambang Batas Kelulusan Indikator (%)
                                </label>
                                <input id="katsinov_threshold"
                                       type="number"
                                       class="form-control @error('katsinov_threshold') is-invalid @enderror"
                                       name="katsinov_threshold"
                                       value="{{ old('katsinov_threshold', $threshold) }}"
                                       required
                                       step="0.1"
                                       min="0"
                                       max="100">

                                <div class="form-text">
                                    Nilai minimal dalam persen (%) yang harus dicapai agar indikator berikutnya muncul.
                                </div>

                                @error('katsinov_threshold')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- PERUBAHAN DI SINI --}}
                            <div class="form-group mb-0 d-flex" style="gap: 8px;">
                                <button type="submit" class="btn btn-primary">
                                    Simpan Pengaturan
                                </button>
                                <a href="{{ route('admin.katsinov.TableKatsinov') }}" class="btn btn-secondary">
                                    Kembali ke Tabel
                                </a>
                            </div>
                            {{-- AKHIR PERUBAHAN --}}

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>