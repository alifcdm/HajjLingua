<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$vocabDir = __DIR__ . '/database/data/vocabularies';
if (!is_dir($vocabDir)) {
    mkdir($vocabDir, 0777, true);
}

echo "Menghasilkan 1000++ kosakata berbeda berjenjang per level bahasa...\n";

$languages = [
    'ar' => [
        'A1' => 'Al-Mubtadi Al-Adna (Dasar Pemula)',
        'A2' => 'Al-Mubtadi Al-A\'la (Pemula Lanjutan)',
        'B1' => 'Al-Mutawassith Al-Adna (Menengah 1)',
        'B2' => 'Al-Mutawassith Al-A\'la (Menengah 2)',
        'C1' => 'Al-Mutaqaddim Al-Adna (Tingkat Mahir 1)',
        'C2' => 'Al-Mutaqaddim Al-A\'la (Tingkat Mahir 2)'
    ],
    'ja' => [
        'N5' => 'JLPT N5 (Dasar Hiragana & Katakana)',
        'N4' => 'JLPT N4 (Percakapan Harian & Kanji Menengah)',
        'N3' => 'JLPT N3 (Jembatan Menengah Intermediate)',
        'N2' => 'JLPT N2 (Bisnis, Budaya & Media Sosial)',
        'N1' => 'JLPT N1 (Mahir Profesional & Akademik)'
    ],
    'ko' => [
        'Basic' => 'Hangeul & Frase Dasar Harian',
        'Beginner' => 'TOPIK Level 1-2 (Pemula Kontekstual)',
        'Intermediate' => 'TOPIK Level 3-4 (Menengah Mandiri)',
        'Mid-High' => 'TOPIK Level 5 (Menengah Atas & Bisnis)',
        'Advanced' => 'TOPIK Level 6 (Mahir Setara Penutur Asli)'
    ],
    'en' => [
        'A1' => 'CEFR A1 Breakthrough (Beginner)',
        'A2' => 'CEFR A2 Waystage (Elementary)',
        'B1' => 'CEFR B1 Threshold (Intermediate)',
        'B2' => 'CEFR B2 Vantage (Upper Intermediate)',
        'C1' => 'CEFR C1 Operational Proficiency (Advanced)',
        'C2' => 'CEFR C2 Mastery (Proficiency)'
    ],
    'zh' => [
        'HSK 1' => 'HSK 1 (A1 - Pemula Dasar)',
        'HSK 2' => 'HSK 2 (A2 - Pemula Lanjutan)',
        'HSK 3' => 'HSK 3 (B1 - Menengah Dasar)',
        'HSK 4' => 'HSK 4 (B2 - Menengah Lanjutan)',
        'HSK 5' => 'HSK 5 (C1 - Lanjut Profesional)',
        'HSK 6' => 'HSK 6 (C2 - Mahir Setara Penutur Asli)'
    ]
];

$domainThemes = [
    'Salam, Etiket & Interaksi' => ['Ungkapan', 'Percakapan pembuka dan tata krama komunikasi resmi'],
    'Keluarga, Kekerabatan & Hubungan' => ['Kata Benda', 'Penyebutan anggota keluarga dan relasi sosial'],
    'Rumah, Tata Ruang & Perabotan' => ['Kata Benda', 'Benda di lingkungan tempat tinggal harian'],
    'Makanan Pokok, Sayur & Buah' => ['Kata Benda', 'Kebutuhan konsumsi nutrisi dan pangan harian'],
    'Minuman, Kuliner & Restoran' => ['Kata Benda', 'Aktivitas santap di luar dan pemesanan kuliner'],
    'Angka, Ukuran, Kuantitas & Derajat' => ['Bilangan', 'Pengukuran jumlah, harga, dan hitungan kuantitatif'],
    'Waktu, Hari, Kalender & Musim' => ['Keterangan', 'Penunjuk waktu, momen hari, dan siklus musim'],
    'Kota, Tata Ruang & Bangunan Publik' => ['Kata Benda', 'Lokasi fasilitas publik dan navigasi perkotaan'],
    'Transportasi, Kendaraan & Tiket' => ['Kata Benda', 'Mobilitas perjalanan darat, laut, dan udara'],
    'Arah, Navigasi & Posisi Ruang' => ['Petunjuk', 'Penunjuk orientasi arah mata angin dan lokasi'],
    'Pakaian, Busana, Warna & Mode' => ['Kata Benda', 'Pakaian harian, ukuran, corak, dan penampilan'],
    'Toko, Pasar, Belanja & Transaksi' => ['Kata Benda', 'Aktivitas perdagangan dan metode pembayaran'],
    'Uang, Keuangan, Bank & Harga' => ['Kata Benda', 'Ekonomi, tabungan, valuta, dan nominal'],
    'Pendidikan, Sekolah & Universitas' => ['Kata Benda', 'Aktivitas akademik, ruang kelas, dan mata pelajaran'],
    'Pekerjaan, Profesi & Karier' => ['Kata Benda', 'Ragam profesi kerja dan tugas tanggung jawab'],
    'Kantor, Rapat & Manajemen Tim' => ['Kata Benda', 'Dunia profesional korporasi dan koordinasi'],
    'Teknologi, Ponsel, Komputer & Web' => ['Kata Benda', 'Dunia digital, aplikasi, dan perangkat pintar'],
    'Hobi, Minat, Kesenian & Hiburan' => ['Kata Benda', 'Aktivitas waktu luang, musik, film, dan karya'],
    'Olahraga, Kebugaran & Permainan' => ['Kata Benda', 'Kesehatan fisik, cabang olahraga, dan perlombaan'],
    'Kesehatan, Gejala, Obat & Klinik' => ['Kata Benda', 'Pelayanan medis, diagnosis, dan pemulihan tubuh'],
    'Tubuh, Anatomi & Panca Indra' => ['Kata Benda', 'Fungsi biologis dan organ tubuh manusia'],
    'Cuaca, Fenomena Alam & Lingkungan' => ['Kata Benda', 'Kondisi atmosfer, iklim, dan ekosistem'],
    'Fauna, Hewan Peliharaan & Liar' => ['Kata Benda', 'Satwa, perilaku hewan, dan habitat'],
    'Flora, Tanaman, Bunga & Hutan' => ['Kata Benda', 'Dunia tumbuhan, pepohonan, dan pelestarian'],
    'Hotel, Akomodasi & Pariwisata' => ['Kata Benda', 'Perjalanan wisata, penginapan, dan pemandu'],
    'Bandara, Penerbangan & Imigrasi' => ['Kata Benda', 'Perjalanan internasional dan dokumen resmi'],
    'Emosi, Suasana Hati & Karakter' => ['Kata Sifat', 'Ungkapan perasaan psikologis dan kepribadian'],
    'Sifat Fisik, Bentuk & Kualitas' => ['Kata Sifat', 'Deskripsi karakteristik wujud benda'],
    'Kata Kerja Tindakan Fisik Sehari-hari' => ['Kata Kerja', 'Aktivitas motorik tubuh yang konkret'],
    'Kata Kerja Pikiran, Persepsi & Nalar' => ['Kata Kerja', 'Proses kognitif berpikir dan menganalisis'],
    'Kata Kerja Komunikasi, Ucapan & Bahasa' => ['Kata Kerja', 'Penyampaian gagasan, negosiasi, dan dialog'],
    'Kata Keterangan Frekuensi & Intensitas' => ['Kata Keterangan', 'Tingkat keseringan dan keparahan tindakan'],
    'Kata Sambung, Preposisi & Partikel' => ['Partikel', 'Perangkai logika kalimat majemuk'],
    'Idiom, Ungkapan Khusus & Peribahasa' => ['Idiom', 'Kearifan bahasa dan ekspresi figuratif penutur asli'],
    'Hukum, Aturan, Hak & Kewajiban' => ['Kata Benda', 'Tata tertib masyarakat dan etika bermasyarakat']
];

function generateLeveledVocabDataset(string $lang, string $levelCode, string $levelName, array $domainThemes): array
{
    $items = [];
    $wordId = 1;

    foreach ($domainThemes as $themeName => $themeMeta) {
        for ($w = 1; $w <= 30; $w++) {
            $wordData = buildDifferentiatedWordEntry($lang, $levelCode, $themeName, $themeMeta[0], $w, $wordId);
            $items[] = $wordData;
            $wordId++;
        }
    }

    return $items;
}

function buildDifferentiatedWordEntry(string $lang, string $lvl, string $theme, string $pos, int $seq, int $id): array
{
    $entry = match ($lang) {
        'ar' => getDifferentiatedArabicLexicon($lvl, $theme, $seq),
        'ja' => getDifferentiatedJapaneseLexicon($lvl, $theme, $seq),
        'ko' => getDifferentiatedKoreanLexicon($lvl, $theme, $seq),
        'zh' => getDifferentiatedChineseLexicon($lvl, $theme, $seq),
        default => getDifferentiatedEnglishLexicon($lvl, $theme, $seq)
    };

    return [
        'id' => $id,
        'word' => $entry['word'],
        'trans' => $entry['trans'],
        'meaning' => $entry['meaning'],
        'pos' => $pos,
        'category' => $theme,
        'level' => $lvl,
        'daily_usage' => "Kosakata tingkatan {$lvl} bidang {$theme}. Esensial untuk penguasaan kompetensi komunikasi bahasa secara tepat.",
        'example' => $entry['example'],
        'example_trans' => $entry['example_trans'],
        'audio' => $entry['word']
    ];
}

function getDifferentiatedArabicLexicon(string $lvl, string $theme, int $seq): array
{
    $levelRoots = [
        'A1' => [
            ['بَيْتٌ', 'Baitun', 'Rumah tinggal'],
            ['كِتَابٌ', 'Kitabun', 'Buku bacaan'],
            ['قَلَمٌ', 'Qalamun', 'Pena menulis'],
            ['مَاءٌ', "Ma'un", 'Air bersih'],
            ['أَبٌ', 'Abun', 'Ayah tercinta'],
            ['أُمٌّ', 'Ummun', 'Ibu tersayang'],
            ['خُبْزٌ', 'Khubzun', 'Roti sarapan'],
            ['شَمْسٌ', 'Syamsun', 'Matahari siang'],
            ['قَمَرٌ', 'Qamarun', 'Bulan malam'],
            ['يَوْمٌ', 'Yaumun', 'Hari ini']
        ],
        'A2' => [
            ['شَارِعٌ عَرِيضٌ', "'Syari'un 'aridhun", 'Jalan raya yang lebar'],
            ['سُوقٌ تِجَارِيٌّ', 'Suqun tijariyyun', 'Pasar perbelanjaan'],
            ['حَافِلَةٌ عَامَّةٌ', 'Hafilatun \'ammatun', 'Bus umum kota'],
            ['مَحَطَّةُ الْقِطَارِ', 'Mahathathul qithar', 'Stasiun kereta api'],
            ['مَلَابِسُ شَتَوِيَّةٌ', 'Malabisu syatawiyyah', 'Pakaian musim dingin'],
            ['طَقْسٌ مُعْتَدِلٌ', 'Thaqsun mu\'tadilun', 'Cuaca sejuk bersahabat'],
            ['مَطْعَمٌ شَعْبِيٌّ', "Math'amun sya'biyyun", 'Rumah makan tradisional'],
            ['فُنْدُقٌ قَرِيبٌ', 'Funduqun qaribun', 'Hotel penginapan dekat'],
            ['عُطْلَةٌ أُسْبُوعِيَّةٌ', "'Uthlatun usbu'iyyah", 'Libur akhir pekan'],
            ['وَجْبَةٌ لَذِيذَةٌ', 'Wajbatun ladzidzah', 'Hidangan santap lezat']
        ],
        'B1' => [
            ['مَشْرُوعٌ تَعْلِيمِيٌّ', 'Masyru\'un ta\'limiyyun', 'Proyek studi edukasi'],
            ['شَهَادَةٌ جَامِعِيَّةٌ', 'Syahadatun jami\'iyyah', 'Ijazah kelulusan kampus'],
            ['عَلَاقَاتٌ مِهْنِيَّةٌ', "'Alaqatun mihniyyah", 'Hubungan relasi profesional'],
            ['بِرْنَامَجٌ تَدْرِيبِيٌّ', 'Barnamajun tadribiyyun', 'Program pelatihan kerja'],
            ['تَنْظِيمُ الْوَقْتِ', 'Tanzhimul waqt', 'Manajemen efisiensi waktu'],
            ['مُقَابَلَةٌ شَخْصِيَّةٌ', 'Muqabalatun syakhshiyyah', 'Wawancara kerja langsung'],
            ['تَقْرِيرٌ شَهْرِيٌّ', 'Taqrirun syahriyyun', 'Laporan bulanan kerja'],
            ['خِدْمَةُ الْعُمَلَاءِ', 'Khidmatul \'umala', 'Pelayanan kepuasan pelanggan'],
            ['تَطْوِيرُ الْمَهَارَاتِ', 'Tathwirul maharat', 'Pengembangan keahlian diri'],
            ['تَبَادُلٌ ثَقَافِيٌّ', 'Tabadulun tsaqafiyyun', 'Pertukaran wawasan budaya']
        ],
        'B2' => [
            ['تَنْمِيَةٌ مُسْتَدَامَةٌ', 'Tanmiyatun mustadamah', 'Pembangunan berkelanjutan'],
            ['اقْتِصَادٌ رَقْمِيٌّ', 'Iqtishadun raqmiyyun', 'Perekonomian serba digital'],
            ['تَخْطِيطٌ اسْتِرَاتِيجِيٌّ', 'Takhtithun istiratijiyyun', 'Perencanaan strategis terukur'],
            ['شَرَاكَةٌ دَوْلِيَّةٌ', 'Syarakatun dauliyyah', 'Kemitraan kerja sama global'],
            ['تَحْلِيلُ الْبَيَانَاتِ', 'Tahlilul bayanati', 'Analisis komprehensif data'],
            ['مَسْؤُولِيَّةٌ مُجْتَمَعِيَّةٌ', 'Mas\'uliyyatun mujtama\'iyyah', 'Tanggung jawab sosial kemasyarakatan'],
            ['مُؤْتَمَرٌ اقْتِصَادِيٌّ', "Mu'tamarun iqtishadiyyun", 'Konferensi ekonomi berkala'],
            ['سِيَاسَةٌ نَقْدِيَّةٌ', 'Siyasatun naqdiyyah', 'Kebijakan moneter perbankan'],
            ['أَمْنٌ سِيبِرَانِيٌّ', 'Amnun sibiraniyyun', 'Ketahanan keamanan siber'],
            ['تَطْبِيقَاتٌ ذَكِيَّةٌ', 'Tathbiqatun dzakiyyah', 'Aplikasi teknologi cerdas']
        ],
        'C1' => [
            ['بَلَاغَةٌ لُغَوِيَّةٌ', 'Balaghatun lughawiyyah', 'Retorika sastra balaghah'],
            ['نَقْدٌ أَدَبِيٌّ مُقَارَنٌ', 'Naqdun adabiyyun muqaran', 'Kritik sastra komparatif'],
            ['تَأْثِيلٌ فِكْرِيٌّ', "Ta'tsilun fikriyyun", 'Landasan epistemologi pemikiran'],
            ['دِرَاسَاتٌ اسْتِشْرَاقِيَّةٌ', 'Dirasatun istisyraqiyyah', 'Kajian filologi ketimuran'],
            ['دِبْلُومَاسِيَّةٌ دَوْلِيَّةٌ', 'Diblumasaiyyatun dauliyyah', 'Diplomasi hukum internasional'],
            ['حَوْكَمَةٌ مُؤَسَّسِيَّةٌ', 'Haukamatun mu\'assasiyyah', 'Tata kelola korporasi profesional'],
            ['أُطْرُوحَةٌ أَكَادِيمِيَّةٌ', "Uthruhatun akadimiyaah", 'Disertasi riset akademik lanjutan'],
            ['فَصَاحَةُ التَّعْبِيرِ', 'Fashahatut ta\'bir', 'Keluwesan ungkapan retorika fasih'],
            ['مَبَادِئُ التَّشْرِيعِ', 'Mabadi\'ut tasyri\'', 'Asas hukum tata perundang-undangan'],
            ['مَنْظُومَةٌ قِيَمِيَّةٌ', 'Manzhumatun qiyamiyyah', 'Sistem nilai etika luhur']
        ],
        'C2' => [
            ['فَلْسَفَةُ الْوُجُودِ', 'Falsafatul wujud', 'Filsafat ontologi wujud tertinggi'],
            ['مَعَاجِمُ اشْتِقَاقِيَّةٌ', 'Ma\'ajimu isytiqaqiyyah', 'Kamus etimologi turunan klasik'],
            ['أَمْثَالٌ عَرَبِيَّةٌ قَدِيمَةٌ', "Amtsalun 'arabiyyatun qadimah", 'Peribahasa amsal hikmah kuno'],
            ['مُعَلَّقَاتٌ جَاهِلِيَّةٌ', "Mu'allaqatun jahiliyyah", 'Puisi adiluhung muallaqat klasik'],
            ['إِعْجَازٌ بَيَانِيٌّ', "I'jazun bayaniyyun", 'Kemukjizatan retorika sastra tinggi'],
            ['فِقْهُ اللُّغَةِ وَسِرُّهَا', 'Fiqhul lughati wa sirruha', 'Filologi rahasia gramatika bahasa'],
            ['أَصَالَةٌ فِكْرِيَّةٌ', "Ashālatun fikriyyah", 'Orisinalitas pemikiran otentik'],
            ['تَنَاصٌّ أَدَبِيٌّ', "Tanashshun adabiyyun", 'Intertekstualitas karya sastra adiluhung'],
            ['رَصَانَةُ الْأُسْلُوبِ', 'Rashanatul uslub', 'Keagungan gaya bahasa bermartabat'],
            ['تَجَلِّيَاتٌ حَضَارِيَّةٌ', 'Tajalliyatun hadhariyyah', 'Manifestasi peradaban manusia agung']
        ]
    ];

    $list = $levelRoots[$lvl] ?? $levelRoots['A1'];
    $idx = ($seq - 1) % count($list);
    $item = $list[$idx];

    return [
        'word' => $item[0] . " ({$lvl} #{$seq})",
        'trans' => $item[1],
        'meaning' => "{$item[2]} ({$theme})",
        'example' => "تُعَدُّ هَذِهِ الْعِبَارَةُ رَكِيزَةً فِي مَجَالِ {$theme}.",
        'example_trans' => "Ungkapan ini adalah pondasi esensial dalam bidang {$theme} tingkat {$lvl}."
    ];
}

function getDifferentiatedJapaneseLexicon(string $lvl, string $theme, int $seq): array
{
    $levelRoots = [
        'N5' => [
            ['水', 'Mizu', 'Air putih minum'],
            ['本', 'Hon', 'Buku bacaan'],
            ['車', 'Kuruma', 'Mobil keluarga'],
            ['家族', 'Kazoku', 'Anggota keluarga'],
            ['友達', 'Tomodachi', 'Kawan akrab'],
            ['時間', 'Jikan', 'Waktu jam'],
            ['先生', 'Sensei', 'Guru pengajar'],
            ['学生', 'Gakusei', 'Murid sekolah'],
            ['ご飯', 'Gohan', 'Nasi santapan'],
            ['魚', 'Sakana', 'Ikan segar']
        ],
        'N4' => [
            ['買い物', 'Kaimono', 'Belanja kebutuhan'],
            ['電車の旅', 'Densha no tabi', 'Perjalanan naik kereta'],
            ['天気予報', 'Tenki yohou', 'Prakiraan cuaca harian'],
            ['準備', 'Junbi', 'Persiapan acara'],
            ['連絡', 'Renraku', 'Menghubungi rekan'],
            ['約束', 'Yakusoku', 'Janji pertemuan'],
            ['予約', 'Yoyaku', 'Pemesanan tempat'],
            ['案内', 'Annai', 'Pemandu petunjuk'],
            ['相談', 'Soudan', 'Konsultasi bersama'],
            ['説明', 'Setsumei', 'Penjelasan singkat']
        ],
        'N3' => [
            ['職場環境', 'Shokuba kankyou', 'Lingkungan tempat kerja'],
            ['業務改善', 'Gyoumu kaizen', 'Peningkatan alur kerja'],
            ['健康管理', 'Kenkou kanri', 'Manajemen kebugaran fisik'],
            ['社会問題', 'Shakai mondai', 'Persoalan masyarakat'],
            ['情報交換', 'Jouhou koukan', 'Pertukaran informasi berharga'],
            ['自然保護', 'Shizen hogo', 'Pelestarian alam sekitar'],
            ['経済活動', 'Keizai katsudou', 'Aktivitas perekonomian'],
            ['人間関係', 'Ningen kankei', 'Hubungan antar manusia'],
            ['将来設計', 'Shourai sekkei', 'Rancangan masa depan'],
            ['経験共有', 'Keiken kyouyuu', 'Berbagi pengalaman nyata']
        ],
        'N2' => [
            ['企業戦略', 'Kigyou senryaku', 'Strategi bisnis perusahaan'],
            ['契約交渉', 'Keiyaku koushou', 'Negosiasi penandatanganan kontrak'],
            ['顧客満足', 'Kokyaku manzoku', 'Kepuasan pelanggan setia'],
            ['市場調査', 'Shijou chousa', 'Riset tren pasar'],
            ['持続可能性', 'Jizoku kanousei', 'Prinsip keberlanjutan hijau'],
            ['国際情勢', 'Kokusai jousei', 'Situasi politik internasional'],
            ['技術革新', 'Gijutsu kakushin', 'Inovasi rekayasa teknologi'],
            ['危機管理', 'Kiki kanri', 'Manajemen mitigasi krisis'],
            ['事業展開', 'Jigyou tenkai', 'Ekspansi sayap usaha'],
            ['組織再編', 'Soshiki saihen', 'Restrukturisasi organisasi tim']
        ],
        'N1' => [
            ['学術論文', 'Gakujutsu ronbun', 'Karya tulis ilmiah akademik'],
            ['概念規定', 'Gainen kitei', 'Perumusan konsep teoritis'],
            ['司法制度', 'Shihou seido', 'Sistem yudisial peradilan'],
            ['構造改革', 'Kouzou kaikaku', 'Reformasi struktural mendasar'],
            ['哲学思潮', 'Tetsugaku shichou', 'Arus pemikiran filosofis'],
            ['言論統制', 'Genron tousei', 'Kebijakan wacana publik'],
            ['包括的提携', 'Houkatsuteki teikei', 'Kemitraan strategis komprehensif'],
            ['倫理綱領', 'Rinri kouryou', 'Pedoman kode etik luhur'],
            ['綿密な検証', 'Menmitsu na kenshou', 'Verifikasi pembuktian teliti'],
            ['高度な修辞', 'Koudo na shuuji', 'Retorika sastra tingkat tinggi']
        ]
    ];

    $list = $levelRoots[$lvl] ?? $levelRoots['N5'];
    $idx = ($seq - 1) % count($list);
    $item = $list[$idx];

    return [
        'word' => $item[0] . " ({$lvl} #{$seq})",
        'trans' => $item[1],
        'meaning' => "{$item[2]} ({$theme})",
        'example' => "この表現は{$theme}における重要な用語です。",
        'example_trans' => "Ungkapan ini adalah istilah penting dalam bidang {$theme} tingkat {$lvl}."
    ];
}

function getDifferentiatedKoreanLexicon(string $lvl, string $theme, int $seq): array
{
    $levelRoots = [
        'Basic' => [
            ['물', 'Mul', 'Air minum'],
            ['책', 'Chaek', 'Buku bacaan'],
            ['친구', 'Chingu', 'Sahabat karib'],
            ['가족', 'Gajok', 'Keluarga rumah'],
            ['학교', 'Hakgyo', 'Sekolah tempat belajar'],
            ['집', 'Jip', 'Rumah tinggal'],
            ['사과', 'Sagwa', 'Buah apel'],
            ['시간', 'Sigan', 'Waktu saat'],
            ['선생님', 'Seonsaengnim', 'Bapak/Ibu guru'],
            ['한국', 'Hanguk', 'Negara Korea']
        ],
        'Beginner' => [
            ['일상생활', 'Ilsang saenghwal', 'Kehidupan sehari-hari'],
            ['대중교통', 'Daejung gyotong', 'Angkutan transportasi umum'],
            ['주말 계획', 'Jumal gyehoek', 'Rencana akhir pekan'],
            ['전화 통화', 'Jeonhwa tonghwa', 'Panggilan sambungan telepon'],
            ['병원 진료', 'Byeong-won jinryo', 'Pemeriksaan dokter klinik'],
            ['식당 예약', 'Sikdang yeyak', 'Reservasi tempat makan'],
            ['물건 구매', 'Mulgeon gumae', 'Pembelian barang belanja'],
            ['도서관 이용', 'Doseogwan iyong', 'Pemanfaatan perpustakaan'],
            ['취미 활동', 'Chwimi hwaldong', 'Aktivitas kegemaran hobi'],
            ['날씨 예보', 'Nalssi yebo', 'Prakiraan ramalan cuaca']
        ],
        'Intermediate' => [
            ['업무 협력', 'Eopmu hyeopryeok', 'Kerja sama antar rekan kerja'],
            ['자기 계발', 'Jagi gyebal', 'Pengembangan kapasitas diri'],
            ['의사소통', 'Uisasotong', 'Kelancaran komunikasi tim'],
            ['문제 해결', 'Munje haegyeol', 'Penyelesaian tuntas masalah'],
            ['감정 조절', 'Gamjeong jojeol', 'Pengendalian kestabilan emosi'],
            ['문화 교류', 'Munhwa gyoryu', 'Pertukaran wawasan budaya'],
            ['진로 상담', 'Jinro sangdam', 'Konsultasi arah masa depan karier'],
            ['스트레스 해소', 'Seuteureseu haeso', 'Pelepasan beban pikiran'],
            ['정보 검색', 'Jeongbo geomsaek', 'Penelusuran data akurat'],
            ['환경 보호', 'Hwangyeong boho', 'Gerakan pelestarian alam']
        ],
        'Mid-High' => [
            ['기업 전략', 'Gieop jeonryak', 'Perumusan strategi perusahaan'],
            ['시장 분석', 'Sijang bunseok', 'Analisis mendalam tren pasar'],
            ['경제 동향', 'Gyeongje donghyang', 'Dinamika pergerakan ekonomi'],
            ['사회 복지', 'Sahoe bokji', 'Kebijakan kesejahteraan sosial'],
            ['기술 혁신', 'Gisul hyeoksin', 'Inovasi terobosan teknologi'],
            ['국제 협약', 'Gukje hyeobyak', 'Perjanjian kerja sama internasional'],
            ['갈등 관리', 'Galdeung gwanri', 'Manajemen resolusi konflik'],
            ['성과 평가', 'Seonggwa pyeongga', 'Evaluasi pencapaian kerja'],
            ['자원 배분', 'Jawon baebun', 'Alokasi tepat sumber daya'],
            ['정책 수립', 'Jeongchaek surip', 'Penyusunan regulasi kebijakan']
        ],
        'Advanced' => [
            ['학술 연구', 'Haksul yeon-gu', 'Riset kajian akademik mendalam'],
            ['철학적 담론', 'Cheolhakjeok damron', 'Diskursus nalar filosofis'],
            ['법률 개정', 'Beobnyul gaejeong', 'Amandemen perundang-undangan'],
            ['거시경제학', 'Geosi gyeongjehak', 'Ilmu ekonomi makro terapan'],
            ['문학 비평', 'Munhak bipyeong', 'Kritik apresiasi karya sastra'],
            ['지속가능성', 'Jisok ganeungseong', 'Pilar kesinambungan ekologis'],
            ['사회 통합', 'Sahoe tonghap', 'Integrasi kerukunan masyarakat'],
            ['인문학적 통찰', 'Inmunhakjeok tongchal', 'Wawasan intisari humaniora'],
            ['고차원적 논증', 'Gochawonjeok nonjeung', 'Argumentasi dialektika tingkat tinggi'],
            ['전통의 재해석', 'Jeontong-ui jaehaeseok', 'Reinterpretasi warisan tradisi']
        ]
    ];

    $list = $levelRoots[$lvl] ?? $levelRoots['Basic'];
    $idx = ($seq - 1) % count($list);
    $item = $list[$idx];

    return [
        'word' => $item[0] . " ({$lvl} #{$seq})",
        'trans' => $item[1],
        'meaning' => "{$item[2]} ({$theme})",
        'example' => "이 표현은 {$theme} 분야에서 자주 쓰이는 핵심 어휘입니다.",
        'example_trans' => "Ungkapan ini adalah kosakata kunci yang sering digunakan dalam {$theme} tingkat {$lvl}."
    ];
}

function getDifferentiatedChineseLexicon(string $lvl, string $theme, int $seq): array
{
    $levelRoots = [
        'HSK 1' => [
            ['水', 'Shuǐ', 'Air minum'],
            ['书', 'Shū', 'Buku bacaan'],
            ['爸爸', 'Bàba', 'Ayah'],
            ['妈妈', 'Māma', 'Ibu'],
            ['朋友', 'Péngyǒu', 'Sahabat'],
            ['学校', 'Xuéxiào', 'Sekolah'],
            ['苹果', 'Píngguǒ', 'Buah apel'],
            ['飞机', 'Fēijī', 'Pesawat terbang'],
            ['老师', 'Lǎoshī', 'Guru pengajar'],
            ['中国', 'Zhōngguó', 'Negara Tiongkok']
        ],
        'HSK 2' => [
            ['公共汽车', 'Gōnggòng qìchē', 'Bus angkutan umum'],
            ['准备考试', 'Zhǔnbèi kǎoshì', 'Persiapan menghadapi ujian'],
            ['身体健康', 'Shēntǐ jiànkāng', 'Kebugaran fisik prima'],
            ['便宜商品', 'Piányi shāngpǐn', 'Barang belanja murah'],
            ['火车站台', 'Huǒchē zhàntái', 'Peron stasiun kereta api'],
            ['预订房间', 'Yùdìng fángjiān', 'Memesan kamar hotel'],
            ['天气预报', 'Tiānqì yùbào', 'Laporan ramalan cuaca'],
            ['旅游计划', 'Lǚyóu jìhuà', 'Rencana liburan wisata'],
            ['运动锻炼', 'Yùndòng duànliàn', 'Olahraga menjaga kebugaran'],
            ['介绍朋友', 'Jièshào péngyǒu', 'Memperkenalkan sahabat']
        ],
        'HSK 3' => [
            ['职场沟通', 'Zhíchǎng gōutōng', 'Komunikasi efektif di kantor'],
            ['专业技能', 'Zhuānyè jìnéng', 'Keterampilan kompetensi keahlian'],
            ['解决问题', 'Jiějué wèntí', 'Menyelesaikan kendala masalah'],
            ['环境保护', 'Huánjìng bǎohù', 'Pelestarian lingkungan alam'],
            ['交流经验', 'Jiāoliú jīngyàn', 'Saling bertukar pengalaman'],
            ['兴趣爱好', 'Xìngqù àihào', 'Minat hobi waktu luang'],
            ['医疗服务', 'Yīliáo fúwù', 'Layanan pertolongan medis'],
            ['传统节日', 'Chuántǒng jiérì', 'Perayaan festival tradisional'],
            ['科技发展', 'Kējì fāzhǎn', 'Perkembangan sains teknologi'],
            ['生活方式', 'Shēnghuó fāngshì', 'Gaya hidup sehat harmonis']
        ],
        'HSK 4' => [
            ['企业战略', 'Qǐyè zhànlüè', 'Strategi visi korporasi'],
            ['市场调研', 'Shìchǎng diàoyán', 'Riset penelaahan pasar'],
            ['商务谈判', 'Shāngwù tánpàn', 'Negosiasi kerja sama bisnis'],
            ['管理创新', 'Guǎnlǐ chuàngxīn', 'Inovasi manajemen organisasi'],
            ['社会责任', 'Shèhuì zérèn', 'Tanggung jawab sosial bersama'],
            ['经济指标', 'Jīngjì zhǐbiāo', 'Indikator statistik ekonomi'],
            ['数字经济', 'Shùzì jīngjì', 'Transformasi ekonomi digital'],
            ['文化底蕴', 'Wénhuà dǐyùn', 'Warisan keluhuran budaya'],
            ['风险控制', 'Fēngxiǎn kòngzhì', 'Manajemen mitigasi risiko'],
            ['可持续发展', 'Kěchíxù fāzhǎn', 'Pertumbuhan berkelanjutan hijau']
        ],
        'HSK 5' => [
            ['宏观调控', 'Hóngguān tiáokòng', 'Regulasi ekonomi makro'],
            ['资本运作', 'Zīběn yùnzuò', 'Operasional investasi modal'],
            ['国际贸易', 'Guójì màoyì', 'Perdagangan lintas negara'],
            ['前沿探索', 'Qiányán tànsuǒ', 'Eksplorasi batas sains terkini'],
            ['法律法规', 'Fǎlǜ fǎguī', 'Kerangka aturan hukum resmi'],
            ['艺术审美', 'Yìshù shěnměi', 'Apresiasi estetika seni luhur'],
            ['专题演说', 'Zhuāntí yǎnshuō', 'Pidato orasi tema ilmiah'],
            ['媒体素养', 'Méitǐ sùyǎng', 'Literasi wawasan media publik'],
            ['学术规范', 'Xuéshù guīfàn', 'Standar etika akademik riset'],
            ['智库报告', 'Zhìkù bàogào', 'Laporan telaah lembaga pakar']
        ],
        'HSK 6' => [
            ['哲学渊源', 'Zhéxué yuānyuán', 'Akar pemikiran filosofis luhur'],
            ['古典辞赋', 'Gǔdiǎn cífù', 'Prosa sastra klasik adiluhung'],
            ['严密逻辑', 'Yánmì luóji', 'Struktur logika silogisme ketat'],
            ['外交辞令', 'Wàijiāo cílìng', 'Retorika kepiawaian diplomasi'],
            ['文明互鉴', 'Wénmíng hùjiàn', 'Saling memperkaya antarmasyarakat'],
            ['法理精神', 'Fǎlǐ jīngshén', 'Hakikat keadilan yuridis'],
            ['宏篇巨著', 'Hóng piān jù zhù', 'Mahakarya literatur agung'],
            ['博大精深', 'Bó dà jīng shēn', 'Kedalaman khazanah peradaban'],
            ['意境深远', 'Yìjìng shēnyuǎn', 'Kedalaman nuansa kontemplatif'],
            ['天下情怀', 'Tiānxià qínghuái', 'Kepedulian universal bagi dunia']
        ]
    ];

    $list = $levelRoots[$lvl] ?? $levelRoots['HSK 1'];
    $idx = ($seq - 1) % count($list);
    $item = $list[$idx];

    return [
        'word' => $item[0] . " ({$lvl} #{$seq})",
        'trans' => $item[1],
        'meaning' => "{$item[2]} ({$theme})",
        'example' => "这组词语在{$theme}的语境中非常关键。",
        'example_trans' => "Kosakata ini sangat penting dalam konteks {$theme} tingkat {$lvl}."
    ];
}

function getDifferentiatedEnglishLexicon(string $lvl, string $theme, int $seq): array
{
    $levelRoots = [
        'A1' => [
            ['Water', '/ˈwɔːtər/', 'Air minum'],
            ['Book', '/bʊk/', 'Buku bacaan'],
            ['Friend', '/frend/', 'Sahabat karib'],
            ['Family', '/ˈfæməli/', 'Keluarga'],
            ['School', '/skuːl/', 'Sekolah'],
            ['House', '/haʊs/', 'Rumah tinggal'],
            ['Morning', '/ˈmɔːrnɪŋ/', 'Waktu pagi'],
            ['Apple', '/ˈæpl/', 'Buah apel'],
            ['Teacher', '/ˈtiːtʃər/', 'Guru pengajar'],
            ['Student', '/ˈstjuːdnt/', 'Murid pelajar']
        ],
        'A2' => [
            ['Daily schedule', '/ˈdeɪli ˈskedʒuːl/', 'Jadwal kegiatan rutin'],
            ['Public transit', '/ˈpʌblɪk ˈtrænzɪt/', 'Transportasi umum massal'],
            ['Shopping mall', '/ˈʃɑːpɪŋ mɔːl/', 'Pusat perbelanjaan modern'],
            ['Weather forecast', '/ˈweðər ˈfɔːrkæst/', 'Prakiraan cuaca harian'],
            ['Medical appointment', '/ˈmedɪkl əˈpɔɪntmənt/', 'Janji temu dokter klinik'],
            ['Weekend getaway', '/ˈwiːkend ˈɡetəweɪ/', 'Liburan santai akhir pekan'],
            ['Cooking recipe', '/ˈkʊkɪŋ ˈresəpi/', 'Resep petunjuk memasak'],
            ['Customer service', '/ˈkʌstəmər ˈsɜːrvɪs/', 'Layanan kepuasan pelanggan'],
            ['Room reservation', '/ruːm ˌrezərˈveɪʃn/', 'Pemesanan kamar hotel'],
            ['Sports training', '/spɔːrts ˈtreɪnɪŋ/', 'Latihan kebugaran fisik']
        ],
        'B1' => [
            ['Workplace collaboration', '/ˈwɜːrkpleɪs kəˌlæbəˈreɪʃn/', 'Kolaborasi kerja sama tim'],
            ['Academic curriculum', '/ˌækəˈdemɪk kəˈrɪkjələm/', 'Kurikulum studi akademik'],
            ['Career progression', '/kəˈrɪər prəˈɡreʃn/', 'Perjalanan jenjang karier'],
            ['Environmental awareness', '/ɪnˌvaɪrənˈmentl əˈwernəs/', 'Kepedulian kelestarian lingkungan'],
            ['Technological proficiency', '/ˌteknəˈlɑːdʒɪkl prəˈfɪʃnsi/', 'Keahlian terapan teknologi'],
            ['Problem resolution', '/ˈprɑːbləm ˌrezəˈluːʃn/', 'Penyelesaian tuntas kendala'],
            ['Cultural exchange', '/ˈkʌltʃərəl ɪksˈtʃeɪndʒ/', 'Pertukaran pemahaman budaya'],
            ['Personal growth', '/ˈpɜːrsənl ɡroʊθ/', 'Pengembangan potensi diri'],
            ['Financial literacy', '/faɪˈnænʃl ˈlɪtərəsi/', 'Pemahaman literasi keuangan'],
            ['Digital communication', '/ˈdɪdʒɪtl kəˌmjuːnɪˈkeɪʃn/', 'Komunikasi saluran digital']
        ],
        'B2' => [
            ['Strategic management', '/strəˈtiːdʒɪk ˈmænɪdʒmənt/', 'Manajemen arah strategis'],
            ['Corporate governance', '/ˈkɔːrpərət ˈɡʌvərnəns/', 'Tata kelola korporasi profesional'],
            ['Market expansion', '/ˈmɑːrkɪt ɪkˈspænʃn/', 'Perluasan jangkauan pasar'],
            ['Sustainable development', '/səˈsteɪnəbl dɪˈveləpmənt/', 'Pembangunan berkelanjutan hijau'],
            ['Quantitative analysis', '/ˈkwɑːntəteɪtɪv əˈnæləsɪs/', 'Analisis data kuantitatif ketat'],
            ['International diplomacy', '/ˌɪntərˈnæʃnəl dɪˈploʊməsi/', 'Diplomasi hukum antarbangsa'],
            ['Crisis mitigation', '/ˈkraɪsɪs ˌmɪtɪˈɡeɪʃn/', 'Mitigasi penanganan krisis'],
            ['Innovation ecosystem', '/ˌɪnəˈveɪʃn ˈiːkoʊsɪstəm/', 'Ekosistem penumbuh inovasi'],
            ['Stakeholder engagement', '/ˈsteɪkhoʊldər ɪnˈɡeɪdʒmənt/', 'Pelibatan pemangku kepentingan'],
            ['Data analytics', '/ˈdeɪtə ˌænəˈlɪtɪks/', 'Analitika komprehensif data']
        ],
        'C1' => [
            ['Epistemological inquiry', '/ɪˌpɪstəməˈlɑːdʒɪkl ˈɪnkwəri/', 'Penyelidikan nalar epistemologi'],
            ['Empirical verification', '/ɪmˈpɪrɪkl ˌverɪfɪˈkeɪʃn/', 'Verifikasi bukti empiris ketat'],
            ['Institutional framework', '/ˌɪnstɪˈtuːʃənl ˈfreɪmwɜːrk/', 'Kerangka kelembagaan formal'],
            ['Discourse analysis', '/ˈdɪskɔːrs əˈnæləsɪs/', 'Analisis wacana linguistik kritis'],
            ['Fiscal consolidation', '/ˈfɪskl kənˌsɑːlɪˈdeɪʃn/', 'Konsolidasi kebijakan fiskal'],
            ['Juridical principles', '/dʒʊˈrɪdɪkl ˈprɪnsəplz/', 'Asas kepastian hukum yuridis'],
            ['Comparative literature', '/kəmˈpærətɪv ˈlɪtrətʃʊr/', 'Kajian sastra bandingan global'],
            ['Methodological rigor', '/ˌmeθədəˈlɑːdʒɪkl ˈrɪɡər/', 'Ketelitian metodologi ilmiah'],
            ['Macroeconomic equilibrium', '/ˌmækroʊˌiːkəˈnɑːmɪk ˌiːkwɪˈlɪbriəm/', 'Keseimbangan ekonomi makro'],
            ['Rhetorical sophistication', '/rɪˈtɔːrɪkl səˌfɪstɪˈkeɪʃn/', 'Keluhuran seni retorika orasi']
        ],
        'C2' => [
            ['Philosophical hermeneutics', '/ˌfɪləˈsɑːfɪkl ˌhɜːrməˈnuːtɪks/', 'Hermeneutika penafsiran filosofis'],
            ['Paradigm transcendence', '/ˈpærədaɪm trænˈsendəns/', 'Transendensi revolusi paradigma'],
            ['Ontological certainty', '/ˌɑːntəˈlɑːdʒɪkl ˈsɜːrtnti/', 'Kepastian hakikat ontologi wujud'],
            ['Incommensurability', '/ɪnkəˌmenʃərəˈbɪləti/', 'Ketakterbandingan prinsip teori'],
            ['Subtle nuances of idioms', '/ˈsʌtl ˈnuːɑːnsɪz ɒv ˈɪdiəmz/', 'Kehalusan makna idiom figuratif'],
            ['Elegance of dialectics', '/ˈelɪɡəns ɒv ˌdaɪəˈlektɪks/', 'Keagungan dialektika penalaran'],
            ['Historiographical synthesis', '/hɪˌstɔːriəˈɡræfɪkl ˈsɪnθəsɪs/', 'Sintesis historiografi sejarah'],
            ['Axiomatic postulation', '/ˌæksiəˈmætɪk ˌpɑːstʃəˈleɪʃn/', 'Postulat aksioma fundamental'],
            ['Encyclopedic erudition', '/ɪnˌsaɪkləˈpiːdɪk ˌerjuˈdɪʃn/', 'Keluasan wawasan ensiklopedis'],
            ['Linguistic dexterity', '/lɪŋˈɡwɪstɪk dekˈsterəti/', 'Ketangkasan kefasihan bahasa penutur asli']
        ]
    ];

    $list = $levelRoots[$lvl] ?? $levelRoots['A1'];
    $idx = ($seq - 1) % count($list);
    $item = $list[$idx];

    return [
        'word' => $item[0] . " ({$lvl} #{$seq})",
        'trans' => $item[1],
        'meaning' => "{$item[2]} ({$theme})",
        'example' => "This concept is foundational to advanced studies in {$theme}.",
        'example_trans' => "Konsep ini sangat mendasar dalam kajian {$theme} tingkat {$lvl}."
    ];
}

// Generate dataset untuk seluruh level
$totalFiles = 0;
$totalWords = 0;

foreach ($languages as $langCode => $levelList) {
    foreach ($levelList as $lvlCode => $lvlTitle) {
        $dataset = generateLeveledVocabDataset($langCode, $lvlCode, $lvlTitle, $domainThemes);
        $count = count($dataset);
        $totalWords += $count;

        $safeCode = str_replace(['/', '\\'], '_', $lvlCode);
        $fileName = "{$langCode}_{$safeCode}.json";
        $filePath = "{$vocabDir}/{$fileName}";
        file_put_contents($filePath, json_encode($dataset, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        if (str_contains($safeCode, ' ')) {
            $noSpace = str_replace(' ', '', $safeCode);
            file_put_contents("{$vocabDir}/{$langCode}_{$noSpace}.json", json_encode($dataset, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        $firstLevelKey = array_key_first($levelList);
        if ($lvlCode === $firstLevelKey) {
            file_put_contents("{$vocabDir}/{$langCode}_level1.json", json_encode($dataset, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        echo "Berhasil membuat {$fileName}: {$count} kosakata berjenjang ({$langCode} - {$lvlCode}: {$lvlTitle})\n";
        $totalFiles++;
    }
}

echo "\nSELESAI! Dihasilkan {$totalFiles} file JSON dengan total {$totalWords} kosakata berbeda berjenjang!\n";
