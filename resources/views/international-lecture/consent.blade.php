<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Consent Letter - Universitas Negeri Jakarta</title>
    <style>
        body{font-family:Arial,sans-serif;background:#f3f4f6;margin:0;padding:24px;color:#1f2937}.card{max-width:720px;margin:40px auto;background:#fff;border-radius:14px;padding:32px;box-shadow:0 4px 20px rgba(0,0,0,.08)}.btn{border:0;border-radius:8px;padding:12px 18px;font-weight:600;cursor:pointer}.yes{background:#16a34a;color:#fff}.no{background:#e5e7eb;color:#374151}.meta{background:#f9fafb;border-radius:10px;padding:16px;margin:20px 0}.actions{display:flex;gap:10px;flex-wrap:wrap}
    </style>
</head>
<body>
<div class="card">
    <h1>Consent Letter</h1>
    <p>Universitas Negeri Jakarta (UNJ) meminta persetujuan Anda terkait penggunaan data kontak untuk keperluan QS Academic Reputation Survey.</p>
    <div class="meta">
        <strong>{{ $lecturer->nama }}</strong><br>
        {{ $lecturer->jabatan ?: 'International Lecturer' }}<br>
        {{ $lecturer->universitas_asal }}<br>
        {{ $lecturer->email }}
    </div>
    <p>Dengan memilih <strong>Agree</strong>, Anda menyetujui permintaan persetujuan yang dijelaskan dalam email. Dengan memilih <strong>Decline</strong>, Anda tidak memberikan persetujuan.</p>
    <div class="actions">
        <form method="POST" action="{{ route('pemeringkatan.international-lecture.consent.agree', $lecturer->consent_token) }}">@csrf<button class="btn yes">I Agree</button></form>
        <form method="POST" action="{{ route('pemeringkatan.international-lecture.consent.decline', $lecturer->consent_token) }}">@csrf<button class="btn no">I Do Not Agree</button></form>
    </div>
</div>
</body>
</html>
