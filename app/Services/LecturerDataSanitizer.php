<?php

namespace App\Services;

class LecturerDataSanitizer
{
    /**
     * Variabel daftar nilai aneh / placeholder yang diisi sembarangan
     * dan harus otomatis dianggap kosong (null).
     */
    public static array $invalidPlaceholders = [
        '?', '??', '???', '????', '?????', '??????',
        '-', '--', '---', '----',
        '.', '..', '...',
        'tidak ada', 'tidak ada di internet', 'idak ada di interne', 'tidak tahu',
        'belum ada', 'belum diisi', 'belum tahu', 'belum',
        'n/a', 'na', 'n.a', 'n.a.', 'none', 'null', 'nil',
        'dummy', 'test', 'tester', 'testing',
        'kosong', 'undefined', 'unknown', 'anonym', 'anonymous',
        'sembarang', 'asal', 'asdf', '0', '00', '000',
    ];

    /**
     * Kamus deteksi salah ketik (typo) domain email populer.
     * Mengarahkan ke domain resmi yang benar.
     */
    public static array $commonDomainTypos = [
        // Gmail
        'gmail.co'       => 'gmail.com',
        'gmail.con'      => 'gmail.com',
        'gmail.cm'       => 'gmail.com',
        'gmail.cpm'      => 'gmail.com',
        'gmail.om'       => 'gmail.com',
        'gmail.comm'     => 'gmail.com',
        'gmai.com'       => 'gmail.com',
        'gamil.com'      => 'gmail.com',
        'gmaill.com'     => 'gmail.com',
        'gmal.com'       => 'gmail.com',
        'gmaul.com'      => 'gmail.com',
        'gmeil.com'      => 'gmail.com',
        'gmial.com'      => 'gmail.com',
        'gemail.com'     => 'gmail.com',
        'gmail.co.id'    => 'gmail.com', // Google tidak menyediakan domain @gmail.co.id
        'gmail.ac.id'    => 'gmail.com',
        'gmail.net'      => 'gmail.com',
        'gmail.org'      => 'gmail.com',
        'googlemail.co'  => 'googlemail.com',

        // Yahoo
        'yahoo.co'       => 'yahoo.com atau yahoo.co.id',
        'yahoo.con'      => 'yahoo.com',
        'yahoo.cm'       => 'yahoo.com',
        'yaho.com'       => 'yahoo.com',
        'yaho.co.id'     => 'yahoo.co.id',
        'yahooo.com'     => 'yahoo.com',
        'yhaoo.com'      => 'yahoo.com',
        'ymail.co'       => 'ymail.com',

        // Hotmail
        'hotmail.co'     => 'hotmail.com',
        'hotmail.con'    => 'hotmail.com',
        'hotmail.cm'     => 'hotmail.com',
        'hotmial.com'    => 'hotmail.com',
        'hotmai.com'     => 'hotmail.com',
        'hotmale.com'    => 'hotmail.com',

        // Outlook
        'outlook.co'     => 'outlook.com',
        'outlook.con'    => 'outlook.com',
        'outlook.cm'     => 'outlook.com',
        'outlok.com'     => 'outlook.com',
        'outloo.com'     => 'outlook.com',
        'outlock.com'    => 'outlook.com',

        // iCloud
        'icloud.co'      => 'icloud.com',
        'icloud.con'     => 'icloud.com',
        'iclud.com'      => 'icloud.com',
        'iclou.com'      => 'icloud.com',
    ];

    /**
     * Daftar domain sementara / disposable email yang dilarang.
     */
    public static array $disposableDomains = [
        'mailinator.com', 'tempmail.com', '10minutemail.com', 'yopmail.com', 'guerrillamail.com',
        'throwawaymail.com', 'getairmail.com', 'fakemailgenerator.com', 'dispostable.com',
        'sharklasers.com', 'generator.email', 'emailondeck.com', 'mohmal.com', 'crazymailing.com',
        'temp-mail.org', 'burnermail.io', 'maildrop.cc', 'trashmail.com', 'trashmail.net',
        'mailcatch.com', 'mytemp.email', 'inboxkitten.com', 'tempail.com', 'nada.ltd',
        'getnada.com', 'dropmail.me', 'inboxbear.com', 'crazymail.com', 'fakeinbox.com',
        'dayrep.com', 'teleworm.us', 'armyspy.com', 'cuvox.de', 'fleckens.hu', 'gustr.com',
        'jourrapide.com', 'rhyta.com', 'superrito.com',
    ];

    /**
     * Bersihkan nilai kolom dari nilai aneh seperti '???', '-', 'tidak ada', dsb.
     * Mengembalikan null jika terdeteksi data aneh / placeholder / kosong.
     */
    public static function cleanValue(?string $val): ?string
    {
        if ($val === null) {
            return null;
        }

        $val = trim((string) $val);
        if ($val === '') {
            return null;
        }

        $lower = mb_strtolower($val);

        if (in_array($lower, self::$invalidPlaceholders, true)) {
            return null;
        }

        // Jika hanya berisi tanda tanya (mis. ??? atau ?????) atau tanda baca simbol tanpa huruf/angka
        if (preg_match('/^[\?\s\-_.+*\/\\#@!~`=,;:^%&$|<>]+$/u', $val)) {
            return null;
        }

        // Jika merupakan teks placeholder seperti 'tidak ada...', 'idak ada...', 'belum...', 'n/a', dll.
        if (preg_match('/^(t?idak\s*ada(\s*di\s*interne?t?)?|belum\s*(ada|diisi|tahu)|n\/?a|none|null|dummy|test|kosong)$/iu', $lower)) {
            return null;
        }

        return $val;
    }

    /**
     * Bersihkan alamat email secara khusus.
     * Jika tidak memuat karakter '@' sama sekali, berarti bukan email (misal catatan 'tidak ada di internet').
     */
    public static function cleanEmail(?string $email): ?string
    {
        $val = self::cleanValue($email);
        if ($val === null) {
            return null;
        }

        // Jika tidak ada tanda '@', maka bukan email sama sekali -> jadikan null (data kosong)
        if (strpos($val, '@') === false) {
            return null;
        }

        // Jika ada beberapa email dipisah '/' atau ',', ambil email pertama yang valid
        if (strpos($val, '/') !== false || strpos($val, ',') !== false || strpos($val, ';') !== false) {
            $parts = preg_split('/[\/,;]+/', $val);
            foreach ($parts as $p) {
                $pClean = trim($p, " .\t\n\r\0\x0B/");
                if (filter_var($pClean, FILTER_VALIDATE_EMAIL)) {
                    $val = $pClean;
                    break;
                }
            }
        }

        // Hapus titik atau slash di awal atau akhir yang biasanya akibat typo copy-paste Excel (mis. '.utami@...' atau '...edu.')
        $val = trim($val, " .\t\n\r\0\x0B/");

        return $val !== '' ? $val : null;
    }

    /**
     * Periksa apakah domain aktif di DNS dan menerima email.
     * Mendukung:
     * 1. Deteksi RFC 7505 (Null MX) seperti 'gmail.co' yang secara resmi menolak email.
     * 2. Pengecekan server MX utama (Mail Exchange).
     * 3. Fallback RFC 5321 (record A/AAAA) jika domain kampus/institusi tidak menggunakan MX terpisah.
     */
    public static function checkDomainDns(string $domain, ?string &$reason = null): bool
    {
        // 1. Coba ambil record MX
        $mxRecords = @dns_get_record($domain, DNS_MX);

        if (!empty($mxRecords)) {
            // Filter target MX yang valid (bukan '.' / Null MX RFC 7505, dan bukan localhost)
            $validMx = array_filter($mxRecords, function ($r) {
                $target = strtolower(trim($r['target'] ?? ''));
                return !empty($target) && $target !== '.' && $target !== 'localhost';
            });

            if (empty($validMx)) {
                $reason = "Domain '@{$domain}' tidak menerima email (RFC 7505 Null MX / server mail tidak aktif)";
                return false;
            }

            return true;
        }

        // 2. Jika tidak ada record MX, standar RFC 5321 memperbolehkan fallback ke A atau AAAA
        $aRecords = @dns_get_record($domain, DNS_A);
        $aaaaRecords = @dns_get_record($domain, DNS_AAAA);

        if (!empty($aRecords) || !empty($aaaaRecords)) {
            return true;
        }

        // 3. Jika MX, A, dan AAAA tidak ditemukan sama sekali:
        // Cek apakah koneksi DNS host sedang aktif (hindari false negative jika server offline saat development)
        $isOnlineDns = @checkdnsrr('google.com', 'A') || @checkdnsrr('cloudflare.com', 'A');
        if ($isOnlineDns) {
            $reason = "Domain '@{$domain}' tidak ditemukan di internet atau tidak memiliki server email yang aktif";
            return false;
        }

        // Jika koneksi DNS host sedang offline/tidak dapat dijangkau, loloskan agar tidak memblokir di lingkungan lokal
        return true;
    }

    /**
     * Periksa apakah email merupakan email fix/valid dan siap dikirim.
     * Mengembalikan false jika email masih kosong, dummy, sembarang, atau berformat salah.
     */
    public static function isFixDeliverableEmail(?string $email, ?string &$reason = null): bool
    {
        $cleaned = self::cleanEmail($email);
        if ($cleaned === null) {
            $reason = 'Email masih kosong atau berupa data aneh/placeholder';
            return false;
        }

        // 1. Validasi Sintaks RFC
        if (!filter_var($cleaned, FILTER_VALIDATE_EMAIL)) {
            $reason = 'Format penulisan email tidak valid (harus nama@domain.tld)';
            return false;
        }

        // Panjang maksimum email sesuai RFC 5321
        if (strlen($cleaned) > 254) {
            $reason = 'Panjang email melebihi batas maksimal 254 karakter';
            return false;
        }

        $parts = explode('@', $cleaned);
        if (count($parts) !== 2) {
            $reason = 'Email harus memiliki tepat satu tanda @';
            return false;
        }

        [$user, $domain] = $parts;
        $userLower = strtolower(trim($user));
        $domainLower = strtolower(trim($domain));

        // 2. Deteksi Typo Domain Populer Terlebih Dahulu (Gmail, Yahoo, Outlook, Hotmail, iCloud)
        if (isset(self::$commonDomainTypos[$domainLower])) {
            $suggest = self::$commonDomainTypos[$domainLower];
            $reason = "Domain '@{$domain}' terindikasi salah ketik (typo). Apakah maksud Anda '@{$suggest}'?";
            return false;
        }

        // 3. Deteksi Typo Ekstensi Domain Umum (.con, .cpm, .comm, .ed)
        if (preg_match('/\.con$/i', $domainLower)) {
            $suggest = preg_replace('/\.con$/i', '.com', $domainLower);
            $reason = "Ekstensi domain '.con' pada '@{$domain}' terindikasi typo. Apakah maksud Anda '@{$suggest}'?";
            return false;
        }
        if (preg_match('/\.cpm$/i', $domainLower) || preg_match('/\.comm$/i', $domainLower)) {
            $suggest = preg_replace('/\.(cpm|comm)$/i', '.com', $domainLower);
            $reason = "Ekstensi domain pada '@{$domain}' terindikasi typo. Apakah maksud Anda '@{$suggest}'?";
            return false;
        }
        if (preg_match('/\.ed$/i', $domainLower)) {
            $suggest = preg_replace('/\.ed$/i', '.edu', $domainLower);
            $reason = "Ekstensi domain '.ed' pada '@{$domain}' terindikasi typo. Apakah maksud Anda '@{$suggest}'?";
            return false;
        }
        if (preg_match('/\.ac\.i$/i', $domainLower) || preg_match('/\.ac\.idd$/i', $domainLower)) {
            $suggest = preg_replace('/\.ac\.(i|idd)$/i', '.ac.id', $domainLower);
            $reason = "Ekstensi domain pada '@{$domain}' terindikasi typo. Apakah maksud Anda '@{$suggest}'?";
            return false;
        }

        // 4. Deteksi Domain Sementara / Disposable Email
        if (in_array($domainLower, self::$disposableDomains, true)) {
            $reason = "Domain '@{$domain}' terindikasi penyedia email sementara (disposable/temp mail) yang dilarang";
            return false;
        }

        // 5. Validasi Struktur Domain & TLD (harus memiliki titik dan TLD minimal 2 huruf alfabet)
        if (!preg_match('/^[a-z0-9-]+(\.[a-z0-9-]+)*\.[a-z]{2,}$/i', $domainLower)) {
            $reason = 'Domain email tidak lengkap atau ekstensi domain (.tld) tidak valid';
            return false;
        }

        // 6. Verifikasi Keberadaan Domain di DNS & Server Mail (MX/A Record Check)
        // Mengecek apakah domain benar-benar ada di internet dan memiliki server penerima email
        if (!self::checkDomainDns($domainLower, $reason)) {
            return false;
        }

        // 7. Validasi Username (Local-part)
        if (strlen($userLower) < 2) {
            $reason = 'Nama pengguna email terlalu pendek (minimal 2 karakter)';
            return false;
        }

        // Cegah username berisi karakter berulang aneh seperti '..' atau '__'
        if (strpos($userLower, '..') !== false || strpos($userLower, '__') !== false) {
            $reason = 'Nama pengguna email memuat karakter titik/garis bawah berurutan';
            return false;
        }

        // Cegah username berupa placeholder / dummy murni
        $dummyUsers = [
            'test', 'tester', 'testing', 'dummy', 'fake', 'sample', 'contoh',
            'asdf', 'qwerty', 'qwer', 'sembarang', 'tidakada', 'belumada', 'unknown',
            'noemail', 'temp', 'null', 'none', 'xxx', 'anonymous', 'anon',
            'aaa', 'bbb', 'abc'
        ];
        if (in_array($userLower, $dummyUsers, true) || preg_match('/^(test|dummy|tester|fake|sample)[0-9]*$/i', $userLower)) {
            $reason = "Nama pengguna email terindikasi sembarang/dummy ('{$user}')";
            return false;
        }

        // Cegah deretan angka pendek sembarang seperti '123' atau '12345'
        if (ctype_digit($userLower) && strlen($userLower) < 6) {
            $reason = "Nama pengguna email tidak boleh hanya berupa angka pendek sembarang ('{$user}')";
            return false;
        }

        return true;
    }

    /**
     * Peta normalisasi nama negara (Indonesia, typo, singkatan, nama alternatif)
     * ke nama standar bahasa Inggris pada config('international_lecture.countries').
     */
    public static array $countryAliases = [
        // A
        'afganistan' => 'Afghanistan',
        'aljazair' => 'Algeria',
        'amerika' => 'United States',
        'amerika serikat' => 'United States',
        'arab saudi' => 'Saudi Arabia',
        'azerbaijan' => 'Azerbaijan',
        // B
        'belanda' => 'Netherlands',
        'belgia' => 'Belgium',
        'bosnia' => 'Bosnia and Herzegovina',
        'brasil' => 'Brazil',
        'britania raya' => 'United Kingdom',
        'brunei darussalam' => 'Brunei',
        'burma' => 'Myanmar',
        // C
        'ceko' => 'Czech Republic',
        'cheko' => 'Czech Republic',
        'chili' => 'Chile',
        'china' => 'China',
        'chinese taipei' => 'Taiwan',
        'cina' => 'China',
        'congo' => 'Congo',
        'cote d\'ivoire' => 'Ivory Coast',
        'côte d\'ivoire' => 'Ivory Coast',
        'czechia' => 'Czech Republic',
        // D
        'democratic republic of the congo' => 'DR Congo',
        'deutschland' => 'Germany',
        'dprk' => 'North Korea',
        // E
        'east timor' => 'Timor-Leste',
        'england' => 'United Kingdom',
        'eswatini' => 'Eswatini',
        'etiopia' => 'Ethiopia',
        // F
        'filipina' => 'Philippines',
        'finlandia' => 'Finland',
        // G
        'german' => 'Germany',
        'great britain' => 'United Kingdom',
        // H
        'holland' => 'Netherlands',
        'holy see' => 'Vatican City',
        'hongaria' => 'Hungary',
        'hongkong' => 'Hong Kong',
        'hungaria' => 'Hungary',
        // I
        'inggris' => 'United Kingdom',
        'irak' => 'Iraq',
        'irlandia' => 'Ireland',
        'islandia' => 'Iceland',
        'italia' => 'Italy',
        // J
        'jepang' => 'Japan',
        'jerman' => 'Germany',
        // K
        'kamboja' => 'Cambodia',
        'kanada' => 'Canada',
        'kirgizstan' => 'Kyrgyzstan',
        'kolombia' => 'Colombia',
        'korea' => 'South Korea',
        'korea selatan' => 'South Korea',
        'korea utara' => 'North Korea',
        'kroasia' => 'Croatia',
        'ksa' => 'Saudi Arabia',
        'kuba' => 'Cuba',
        // L
        'libanon' => 'Lebanon',
        'luksemburg' => 'Luxembourg',
        // M
        'macao' => 'Macau',
        'makau' => 'Macau',
        'maladewa' => 'Maldives',
        'maroko' => 'Morocco',
        'meksiko' => 'Mexico',
        'mesir' => 'Egypt',
        'muangthai' => 'Thailand',
        // N
        'netherland' => 'Netherlands',
        'nippon' => 'Japan',
        'norwegia' => 'Norway',
        // P
        'palestina' => 'Palestine',
        'pantai gading' => 'Ivory Coast',
        'people\'s republic of china' => 'China',
        'perancis' => 'France',
        'philippine' => 'Philippines',
        'pilipina' => 'Philippines',
        'polandia' => 'Poland',
        'prancis' => 'France',
        'prc' => 'China',
        // R
        'republic of china' => 'Taiwan',
        'republic of korea' => 'South Korea',
        'republic of uzbekistan' => 'Uzbekistan',
        'republik ceko' => 'Czech Republic',
        'republik rakyat tiongkok' => 'China',
        'republik turki' => 'Turkey',
        'republik uzbekistan' => 'Uzbekistan',
        'rok' => 'South Korea',
        'rumania' => 'Romania',
        'rusia' => 'Russia',
        'russian federation' => 'Russia',
        // S
        'scotland' => 'United Kingdom',
        'selandia baru' => 'New Zealand',
        'singapura' => 'Singapore',
        'siprus' => 'Cyprus',
        'slovakia' => 'Slovakia',
        'slovenia' => 'Slovenia',
        'spanyol' => 'Spain',
        'srilanka' => 'Sri Lanka',
        'state of palestine' => 'Palestine',
        'suriah' => 'Syria',
        'swaziland' => 'Eswatini',
        'swedia' => 'Sweden',
        'swiss' => 'Switzerland',
        // T
        'taiwam' => 'Taiwan',
        'the netherlands' => 'Netherlands',
        'timor leste' => 'Timor-Leste',
        'tiongkok' => 'China',
        'turki' => 'Turkey',
        'turkiye' => 'Turkey',
        'türkiye' => 'Turkey',
        // U
        'uae' => 'United Arab Emirates',
        'uk' => 'United Kingdom',
        'ukraina' => 'Ukraine',
        'uni emirat arab' => 'United Arab Emirates',
        'united kingdom of great britain and northern ireland' => 'United Kingdom',
        'united states of america' => 'United States',
        'us' => 'United States',
        'usa' => 'United States',
        // V
        'vatikan' => 'Vatican City',
        'viet nam' => 'Vietnam',
        // W
        'wales' => 'United Kingdom',
        // Y
        'yaman' => 'Yemen',
        'yordania' => 'Jordan',
        'yunani' => 'Greece',
    ];

    /**
     * Normalisasi nama negara ke standar baku agar tidak ada duplikat (mis. Turki/Turkey, USA/Amerika Serikat).
     */
    public static function normalizeCountry(?string $value): ?string
    {
        $cleaned = self::cleanValue($value);
        if ($cleaned === null) {
            return null;
        }

        $collapsed = preg_replace('/\s+/u', ' ', trim($cleaned));
        $lower = mb_strtolower($collapsed);
        $compact = str_replace('.', '', $lower);

        if (in_array($lower, ['belum ditentukan', 'tidak diketahui', 'tidak ada data'], true)) {
            return null;
        }

        foreach (config('international_lecture.countries', []) as $canonical) {
            if (mb_strtolower($canonical) === $lower) {
                return $canonical;
            }
        }

        if (isset(self::$countryAliases[$lower])) {
            return self::$countryAliases[$lower];
        }
        if (isset(self::$countryAliases[$compact])) {
            return self::$countryAliases[$compact];
        }

        return ucwords($lower);
    }

    /**
     * Daftar negara lengkap beserta kata kunci alias (Indonesia/Inggris) untuk pencarian dropdown.
     *
     * @return array<int, array{name:string, keywords:string}>
     */
    public static function countrySearchIndex(): array
    {
        $aliasesByCanonical = [];
        foreach (self::$countryAliases as $alias => $canonical) {
            $aliasesByCanonical[$canonical][] = $alias;
        }

        $items = [];
        foreach (config('international_lecture.countries', []) as $country) {
            $keywords = array_unique(array_merge([mb_strtolower($country)], $aliasesByCanonical[$country] ?? []));
            $items[] = [
                'name' => $country,
                'keywords' => implode(' ', $keywords),
            ];
        }

        return $items;
    }

    /**
     * Peta normalisasi subject non-QS / multi-subject / typo ke daftar resmi 60 Subject QS.
     */
    public static array $subjectAliases = [
        // Education & Pedagogy
        'primary education' => 'Education',
        'early childhood education' => 'Education',
        'higher education' => 'Education',
        'educational management, higher education policy, & curriculum studies' => 'Education',
        'mathematics education' => 'Education',
        'curriculum development' => 'Education',
        'digital learning and education' => 'Education',
        'pedagogy and education' => 'Education',
        'stem, play-based pedagogy, augmented reality, teacher professional development, children’s learning' => 'Education',
        'stem, play-based pedagogy, augmented reality, teacher professional development, children\'s learning' => 'Education',

        // Psychology
        'sociology/psychology' => 'Psychology',
        'applied cognitive neuroscience' => 'Psychology',
        'counseling psychology' => 'Psychology',
        'physcology' => 'Psychology',
        'educational psychology' => 'Psychology',
        'parenting; emotion regulation; psychological capital; student well-being; cross-cultural research' => 'Psychology',
        'psychology / educational psychology' => 'Psychology',
        'guidance and counseling' => 'Psychology',

        // Engineering
        'engineering' => 'Engineering - Other',
        'aerospace engineering' => 'Engineering - Aeronautical & Aerospace',
        'chemical engineering' => 'Engineering - Chemical',
        'chemical engineering (miscellaneous)| colloid and surface chemistry| electrochemistry| materials chemistry' => 'Engineering - Chemical',
        'electrical & electronic engineering' => 'Engineering - Electrical & Electronic',
        'electrical and electronic engineering| electronic, optical and magnetic materials| condensed matter physics| atomic and molecular physics, and optics' => 'Engineering - Electrical & Electronic',
        'physical and theoretical chemistry| energy engineering and power technology| renewable energy, sustainability and the environment| electrical and electronic engineering' => 'Engineering - Electrical & Electronic',
        'mechanical, aeronautical & manufacturing engineering' => 'Engineering - Mechanical & Manufacturing',
        'mechanical engineering' => 'Engineering - Mechanical & Manufacturing',
        'intelligent mechanical systems / robotics / mechatronics' => 'Engineering - Mechanical & Manufacturing',
        'computer science applications| software| control and systems engineering| industrial and manufacturing engineering| mechanical engineering' => 'Engineering - Mechanical & Manufacturing',

        // Sciences & Computing
        'general physics and astronomy' => 'Physics',
        'physics & astronomy' => 'Physics',
        'chemistry (miscellaneous)| analytical chemistry| inorganic chemistry| organic chemistry' => 'Chemistry',
        'general chemistry| environmental chemistry| environmental engineering| health, toxicology and mutagenesis| pollution| public health, environmental and occupational health' => 'Chemistry',
        'chemical sciences' => 'Chemistry',
        'electrochemistry' => 'Chemistry',
        'bioengineering| environmental chemistry| environmental engineering| pollution| microbiology' => 'Environmental Sciences',
        'environmental management' => 'Environmental Sciences',
        'materials sciences' => 'Materials Science',
        'materials science (miscellaneous)| biomaterials| ceramics and composites| electronic, optical and magnetic materials' => 'Materials Science',
        'nanotechnology & catalysis research centre' => 'Materials Science',
        'earth & marine sciences' => 'Earth Sciences',
        'computer science & information systems' => 'Computer Science',
        'computer science (miscellaneous)' => 'Computer Science',
        'artificial intelligence| computer networks and communications| computer science applications| information systems| software| communication' => 'Computer Science',
        'artificial intelligence' => 'Computer Science',
        'computer engineering' => 'Computer Science',
        'agricultural sciences' => 'Agriculture & Forestry',
        'natural science' => 'Other',

        // Health & Sports
        'public health & social gerontology' => 'Medicine',
        'health/ medical/ education' => 'Medicine',
        'physiology' => 'Anatomy & Physiology',
        'sport sciences' => 'Sports-related Subjects',
        'sport science and coaching' => 'Sports-related Subjects',
        'sport sciences and coaching' => 'Sports-related Subjects',

        // Languages, Arts, Humanities & Social
        'applied linguistics' => 'Linguistics',
        'japanese language & culture' => 'Modern Languages',
        'arabic language' => 'Modern Languages',
        'literature' => 'English Language & Literature',
        'english literature' => 'English Language & Literature',
        'comparative literature' => 'English Language & Literature',
        'music education' => 'Music',
        'film and television art' => 'Art & Design',
        'communication arts' => 'Communication & Media Studies',
        'communication & media studies, social sciences' => 'Communication & Media Studies',
        'urban culture' => 'Cultural Studies',
        'international development' => 'Development Studies',
        'political science' => 'Politics & International Studies',
        'theology, divinity & religious studies' => 'Theology; Divinity & Religious Studies',
        'academic writing, academic integrity, citing skill, reference manager' => 'Library & Information Management',
        'cosmetology' => 'Other',

        // Business, Finance, Economics & Hospitality
        'human resources' => 'Business & Management Studies',
        'consulting/professional service' => 'Business & Management Studies',
        'management' => 'Business & Management Studies',
        'business administration/management' => 'Business & Management Studies',
        'strategic management' => 'Business & Management Studies',
        'business/ management' => 'Business & Management Studies',
        'business' => 'Business & Management Studies',
        'operations management' => 'Business & Management Studies',
        'operations and technology management' => 'Business & Management Studies',
        'business & management studies, computer science' => 'Business & Management Studies',
        'business & management studies, social sciences' => 'Business & Management Studies',
        'halal industry' => 'Business & Management Studies',
        'community service; entrepreneurship; technology; business model canvas; redesign canvas' => 'Business & Management Studies',
        'business/marketing/e-commerce' => 'Marketing',
        'marketing/ business' => 'Marketing',
        'business/ marketing management' => 'Marketing',
        'finance/ banking' => 'Accounting & Finance',
        'finance/banking' => 'Accounting & Finance',
        'corporate finance' => 'Accounting & Finance',
        'finance' => 'Accounting & Finance',
        'accounting' => 'Accounting & Finance',
        'finance/ accounting' => 'Accounting & Finance',
        'managerial/cost accounting' => 'Accounting & Finance',
        'economic' => 'Economics & Econometrics',
        'economics' => 'Economics & Econometrics',
        'hospitality & tourism management' => 'Hospitality & Leisure Management',
        'tourism & hospitality management' => 'Hospitality & Leisure Management',
    ];

    /**
     * Normalisasi dan pilih 1 subject paling cocok dari daftar resmi 60 Subject QS.
     */
    public static function normalizeSubject(?string $value, ?string $fakultas = null, ?string $prodi = null): ?string
    {
        $cleaned = self::cleanValue($value);
        if ($cleaned === null) {
            return null;
        }

        $collapsed = preg_replace('/\s+/u', ' ', trim($cleaned));
        $lower = mb_strtolower($collapsed);
        $facLower = mb_strtolower(trim((string) $fakultas));
        $prodiLower = mb_strtolower(trim((string) $prodi));
        $isFip = $facLower === 'fip' || str_contains($prodiLower, 'pendidikan') || str_contains($prodiLower, 'pgsd') || str_contains($prodiLower, 'pgpaud') || str_contains($prodiLower, 'bimbingan');

        if (in_array($lower, ['belum ditentukan', 'tidak diketahui', 'tidak ada data'], true)) {
            return null;
        }

        // 1. Cocok langsung dengan daftar resmi QS
        foreach (config('international_lecture.subjects', []) as $canonical) {
            if (mb_strtolower($canonical) === $lower) {
                return $canonical;
            }
        }

        // 2. Kasus kontekstual berdasarkan fakultas/prodi
        if (in_array($lower, ['social sciences', 'social', 'general social sciences'], true)) {
            return $isFip ? 'Education' : 'Sociology';
        }
        if ($lower === 'management, pedagogy, entrepreneurship, and innovation') {
            return $isFip ? 'Education' : 'Business & Management Studies';
        }
        if ($lower === 'developmental and educational psychology| education| health (social science)') {
            return $isFip ? 'Education' : 'Psychology';
        }

        // 3. Peta alias langsung
        if (isset(self::$subjectAliases[$lower])) {
            return self::$subjectAliases[$lower];
        }

        // 4. Fallback cerdas untuk input Excel multi-subject / kata kunci baru di masa depan
        $keywordRules = [
            'Engineering - Electrical & Electronic' => ['electrical', 'electronic', 'power technology', 'telecommunication'],
            'Engineering - Mechanical & Manufacturing' => ['mechanical', 'manufacturing', 'robotics', 'mechatronics', 'industrial engineering'],
            'Engineering - Chemical' => ['chemical engineering', 'process engineering'],
            'Engineering - Civil & Structural' => ['civil engineering', 'structural engineering', 'geotechnical'],
            'Engineering - Aeronautical & Aerospace' => ['aerospace', 'aeronautical', 'aviation'],
            'Engineering - Mineral & Mining' => ['mining', 'mineral', 'metallurgy', 'petroleum'],
            'Engineering - Other' => ['engineering'],
            'Computer Science' => ['computer science', 'artificial intelligence', 'machine learning', 'software', 'data science', 'informatics', 'information system', 'cyber'],
            'Accounting & Finance' => ['accounting', 'finance', 'banking', 'auditing', 'taxation'],
            'Economics & Econometrics' => ['economics', 'economic', 'econometrics', 'macroeconomics', 'microeconomics'],
            'Marketing' => ['marketing', 'e-commerce', 'branding', 'consumer behavior'],
            'Hospitality & Leisure Management' => ['hospitality', 'tourism', 'leisure', 'hotel'],
            'Business & Management Studies' => ['business', 'management', 'entrepreneurship', 'human resource', 'supply chain'],
            'Education' => ['education', 'pedagogy', 'curriculum', 'teaching', 'learning', 'teacher'],
            'Psychology' => ['psychology', 'counseling', 'cognitive', 'mental health', 'well-being'],
            'Linguistics' => ['linguistics', 'phonetics', 'syntax', 'applied linguistics'],
            'English Language & Literature' => ['english literature', 'english language', 'literature'],
            'Modern Languages' => ['arabic', 'japanese', 'chinese', 'mandarin', 'french', 'german', 'korean', 'language'],
            'Communication & Media Studies' => ['communication', 'media', 'journalism', 'broadcasting', 'public relations'],
            'Politics & International Studies' => ['political', 'politics', 'international relations', 'diplomacy'],
            'Development Studies' => ['development studies', 'international development'],
            'Cultural Studies' => ['cultural', 'culture'],
            'Sociology' => ['sociology', 'social science'],
            'Environmental Sciences' => ['environmental', 'ecology', 'climate', 'sustainability', 'pollution'],
            'Materials Science' => ['materials science', 'nanotechnology', 'biomaterials', 'polymer', 'ceramics'],
            'Chemistry' => ['chemistry', 'electrochemistry', 'biochemistry'],
            'Physics' => ['physics', 'optics', 'quantum'],
            'Mathematics' => ['mathematics', 'algebra', 'calculus', 'geometry'],
            'Statistics & Operational Research' => ['statistics', 'operational research', 'stochastic'],
            'Biological Sciences' => ['biology', 'biological', 'microbiology', 'genetics', 'biotechnology'],
            'Earth Sciences' => ['earth science', 'geology', 'geophysics', 'meteorology'],
            'Marine Sciences' => ['marine', 'oceanography'],
            'Agriculture & Forestry' => ['agriculture', 'agricultural', 'forestry', 'agronomy'],
            'Sports-related Subjects' => ['sport', 'kinesiology', 'physical education', 'coaching'],
            'Medicine' => ['medicine', 'medical', 'public health', 'clinical'],
            'Nursing' => ['nursing'],
            'Pharmacy' => ['pharmacy', 'pharmaceutical'],
            'Pharmacology' => ['pharmacology', 'toxicology'],
            'Anatomy & Physiology' => ['anatomy', 'physiology'],
            'Law' => ['law', 'legal', 'jurisprudence'],
            'Architecture & Built Environment' => ['architecture', 'urban planning', 'built environment'],
            'Art & Design' => ['art', 'design', 'film', 'television', 'visual'],
            'Music' => ['music'],
            'Drama; Dance & Performing Arts' => ['drama', 'dance', 'theatre', 'performing arts'],
            'History' => ['history'],
            'Philosophy' => ['philosophy', 'ethics'],
            'Theology; Divinity & Religious Studies' => ['theology', 'divinity', 'islamic', 'religious'],
            'Library & Information Management' => ['library', 'information management', 'academic writing', 'archival'],
        ];

        $bestSubject = null;
        $bestScore = 0;
        foreach ($keywordRules as $qsSubject => $keywords) {
            $score = 0;
            foreach ($keywords as $kw) {
                if (str_contains($lower, $kw)) {
                    $score++;
                }
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $bestSubject = $qsSubject;
            }
        }

        return $bestSubject ?? 'Other';
    }
}
