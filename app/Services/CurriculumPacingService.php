<?php

namespace App\Services;

use App\Models\Level;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\LessonExercise;
use Illuminate\Support\Facades\DB;

class CurriculumPacingService
{
    /**
     * Memastikan setiap level memiliki minimal 100 materi pembelajaran (10 Unit x 10 Pelajaran)
     * yang membutuhkan total alokasi 20 jam pembelajaran (12 menit per materi).
     */
    public static function ensure100CurriculumLessonsForLevel(Level $level): void
    {
        $existingLessonCount = Lesson::whereHas('unit', function ($q) use ($level) {
            $q->where('level_id', $level->id);
        })->count();

        if ($existingLessonCount >= 100) {
            return;
        }

        $langCode = $level->language->code;
        $vocabPool = self::getLevelOneVocabularyBank($langCode);
        $unitsTemplate = self::getThematicUnitsTemplate($langCode, $level->code);

        DB::beginTransaction();
        try {
            foreach ($unitsTemplate as $uIdx => $uData) {
                $unitOrder = $uIdx + 1;
                $unit = Unit::firstOrCreate([
                    'level_id' => $level->id,
                    'sort_order' => $unitOrder,
                ], [
                    'title' => "Unit {$unitOrder}: " . $uData['title'],
                    'description' => $uData['description'] . " (Alokasi: 2 Jam Pembelajaran • 10 Variasi Materi).",
                ]);

                // Pastikan 10 materi/lesson pada unit ini
                for ($lIdx = 1; $lIdx <= 10; $lIdx++) {
                    $lessonOrder = $lIdx;
                    $lessonTitle = "Materi {$lessonOrder}: " . ($uData['lessons'][$lIdx - 1] ?? "Penguatan Aplikasi Praktis {$uData['title']} Bagian {$lessonOrder}");

                    // Ambil rotasi kosakata untuk materi ini (3 kosakata per materi)
                    $vocabsForLesson = [];
                    $poolCount = count($vocabPool);
                    if ($poolCount > 0) {
                        for ($v = 0; $v < 3; $v++) {
                            $vIndex = (($unitOrder - 1) * 10 + $lessonOrder * 3 + $v) % $poolCount;
                            $vocabsForLesson[] = $vocabPool[$vIndex];
                        }
                    }

                    $primaryWord = $vocabsForLesson[0] ?? ['word' => 'Dasar', 'trans' => '-', 'meaning' => 'Kosakata Dasar', 'daily_usage' => 'Digunakan sehari-hari'];

                    $lesson = Lesson::firstOrCreate([
                        'unit_id' => $unit->id,
                        'sort_order' => $lessonOrder,
                    ], [
                        'title' => $lessonTitle,
                        'content_type' => ($lessonOrder % 3 === 0) ? 'conversation' : (($lessonOrder % 2 === 0) ? 'grammar' : 'vocabulary'),
                        'content_body' => [
                            'summary' => "Materi ke-{$lessonOrder} pada {$unit->title}. Berisi target kompetensi komunikasi aktif dengan kosakata berterjemahan Indonesia, pola kalimat kontekstual, dan simulasi kasus nyata.",
                            'duration_minutes' => 12,
                            'pacing_badge' => 'Estimasi: 12 Menit • Silabus 20 Jam Belajar Mandiri',
                            'tips' => "Detail Penggunaan Sehari-hari: Perhatikan konteks pengucapan [{$primaryWord['word']}] ({$primaryWord['meaning']}). {$primaryWord['daily_usage']}",
                            'vocabularies' => $vocabsForLesson,
                            'grammar_rules' => [
                                [
                                    'title' => "Pola Kalimat Esensial: " . $uData['grammar_title'],
                                    'explanation' => "Tata bahasa ini digunakan untuk mengekspresikan topik bahasan unit ini secara tepat dalam situasi percakapan sehari-hari.",
                                    'formula' => $uData['grammar_formula'],
                                    'examples' => [
                                        [
                                            'target' => $primaryWord['example'] ?? $primaryWord['word'],
                                            'trans' => LinguisticBreakdownService::getSentenceTransliteration($langCode, $primaryWord['example'] ?? $primaryWord['word'], $primaryWord['trans'] ?? null),
                                            'meaning' => $primaryWord['example_trans'] ?? $primaryWord['meaning'],
                                            'audio' => $primaryWord['word'],
                                        ]
                                    ]
                                ]
                            ],
                            'dialogues' => [
                                [
                                    'speaker' => 'Penutur A',
                                    'line' => $primaryWord['word'] . '?',
                                    'trans' => ($primaryWord['trans'] ?? '') . '?',
                                    'meaning' => "Apakah ini terkait dengan {$primaryWord['meaning']}?",
                                    'audio' => $primaryWord['word'],
                                ],
                                [
                                    'speaker' => 'Penutur B',
                                    'line' => ($primaryWord['example'] ?? $primaryWord['word']),
                                    'trans' => LinguisticBreakdownService::getSentenceTransliteration($langCode, $primaryWord['example'] ?? $primaryWord['word'], $primaryWord['trans'] ?? null),
                                    'meaning' => ($primaryWord['example_trans'] ?? $primaryWord['meaning']),
                                    'audio' => $primaryWord['word'],
                                ],
                            ]
                        ],
                        'audio_script' => $primaryWord['word'],
                    ]);

                    // Exercise untuk materi ini
                    if ($lesson->exercises()->count() === 0) {
                        $distractors = ['Buku Catatan', 'Stasiun Utama', 'Minuman Dingin'];
                        $options = array_merge([$primaryWord['meaning']], $distractors);
                        shuffle($options);

                        LessonExercise::create([
                            'lesson_id' => $lesson->id,
                            'question_text' => "Apakah terjemahan bahasa Indonesia yang tepat dari kata '{$primaryWord['word']}' ({$primaryWord['trans']})?",
                            'prompt_script' => $primaryWord['word'],
                            'options_json' => $options,
                            'correct_answer' => $primaryWord['meaning'],
                            'explanation' => "Kata [{$primaryWord['word']}] ({$primaryWord['trans']}) berarti '{$primaryWord['meaning']}'. Penggunaan sehari-hari: {$primaryWord['daily_usage']}",
                            'sort_order' => 1,
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * 10 Unit Tematik Kurikulum Terstruktur (Total 20 Jam Pembelajaran)
     */
    private static function getThematicUnitsTemplate(string $langCode, string $levelCode): array
    {
        return [
            [
                'title' => 'Salam, Perkenalan & Identitas Diri (2 Jam)',
                'description' => 'Mempelajari etiket sapaan formal-informal, perkenalan nama, asal negara, dan latar belakang pribadi.',
                'grammar_title' => 'Struktur Kalimat Nominal & Predikat Pengenal',
                'grammar_formula' => '[Subjek] + [Penanda Topik] + [Predikat Identitas]',
                'lessons' => [
                    'Sapaan Pagi, Siang & Malam Formal',
                    'Menanyakan Kabar & Respon Sopan',
                    'Memperkenalkan Diri & Mengeja Nama',
                    'Menyatakan Asal Negara & Kebangsaan',
                    'Menyebutkan Usia & Tanggal Lahir',
                    'Etiket Bertukar Kontak & Kartu Nama',
                    'Ungkapan Terima Kasih & Permintaan Maaf',
                    'Ungkapan Perpisahan & Sampai Jumpa',
                    'Memperkenalkan Teman atau Kolega Lain',
                    'Simulasi Lengkap: Pertemuan Pertama Kali',
                ]
            ],
            [
                'title' => 'Bilangan, Waktu, Tanggal & Jadwal Rutinitas (2 Jam)',
                'description' => 'Sistem penomoran asli dan Sino/Arab, membaca jam menit, hari dalam sepekan, dan kalender.',
                'grammar_title' => 'Partikel & Kata Bantu Waktu',
                'grammar_formula' => '[Waktu/Jam] + [Penanda Waktu] + [Aktivitas Rutin]',
                'lessons' => [
                    'Mengenal Angka Kardinal 1 sampai 100',
                    'Menyatakan Jam, Menit, dan Setengah Jam',
                    'Hari dalam Seminggu & Nama-nama Bulan',
                    'Menanyakan Waktu Pertemuan & Janji Temu',
                    'Jadwal Rutinitas Pagi Sebelum Berangkat',
                    'Menyatakan Durasi Waktu & Jangka Waktu',
                    'Menyatakan Frekuensi (Selalu, Sering, Kadang)',
                    'Angka Ordinal (Pertama, Kedua, Ketiga)',
                    'Menghitung Nominal Uang & Harga Barang',
                    'Simulasi Lengkap: Mengatur Agenda Harian',
                ]
            ],
            [
                'title' => 'Keluarga, Rumah & Lingkungan Sekitar (2 Jam)',
                'description' => 'Sebutan anggota keluarga inti dan besar, ruangan di dalam rumah, serta perabotan sehari-hari.',
                'grammar_title' => 'Kepemilikan & Penunjuk Lokasi Ruang',
                'grammar_formula' => '[Benda/Orang] + [Penunjuk Milik] + [Ruangan/Posisi]',
                'lessons' => [
                    'Sebutan Anggota Keluarga Inti',
                    'Sebutan Keluarga Besar & Panggilan Hormat',
                    'Mendeskripsikan Ciri Fisik & Karakter Seseorang',
                    'Nama-nama Ruangan di Rumah (Dapur, Kamar, dll)',
                    'Perabot Rumah Tangga & Elektronik',
                    'Menunjukkan Letak Posisi (Atas, Bawah, Dalam)',
                    'Aktivitas di Rumah (Membersihkan, Memasak)',
                    'Tetangga & Hubungan Sosial Lingkungan',
                    'Mendeskripsikan Hewan Peliharaan',
                    'Simulasi Lengkap: Menceritakan Kehidupan Rumah',
                ]
            ],
            [
                'title' => 'Kuliner, Makanan, Minuman & Transaksi Restoran (2 Jam)',
                'description' => 'Memesan makanan di kafe atau restoran, menanyakan rasa, bahan makanan, dan membayar tagihan.',
                'grammar_title' => 'Pola Permintaan Sopan & Pemesanan',
                'grammar_formula' => '[Nama Menu] + [Jumlah Pesanan] + [Mohon/Tolong]',
                'lessons' => [
                    'Kosakata Makanan Pokok & Hidangan Tradisional',
                    'Kosakata Aneka Minuman Hangat & Dingin',
                    'Rasa Makanan (Manis, Asin, Pedas, Pahit, Asam)',
                    'Meminta Buku Menu & Rekomendasi Koki',
                    'Menyatakan Alergi & Pantangan Makanan',
                    'Etiket Makan & Ungkapan Sebelum/Sesudah Makan',
                    'Menambah Porsi & Meminta Air Tambahan',
                    'Meminta Tagihan Pembayaran & Metode Bayar',
                    'Membeli Makanan Cepat Saji & Pesan Bawa Pulang',
                    'Simulasi Lengkap: Jamuan Makan di Restoran',
                ]
            ],
            [
                'title' => 'Arah, Lokasi, Navigasi & Transportasi Publik (2 Jam)',
                'description' => 'Membaca peta, menanyakan arah jalan, naik bus, kereta, taksi, dan transportasi umum modern.',
                'grammar_title' => 'Kata Arah, Gerakan & Partikel Tujuan',
                'grammar_formula' => '[Tempat Tujuan] + [Ke/Menuju] + [Moda Transportasi]',
                'lessons' => [
                    'Kosakata Moda Transportasi (Bus, Kereta, Mobil)',
                    'Membeli Tiket di Stasiun & Mesin Otomatis',
                    'Menanyakan Arah (Lurus, Belok Kanan, Belok Kiri)',
                    'Menanyakan Jarak & Lama Perjalanan',
                    'Di Dalam Kereta: Stasiun Transit & Pengumuman',
                    'Menaiki Taksi & Memberitahu Tujuan ke Pengemudi',
                    'Nama-nama Fasilitas Publik (Taman, Kantor Pos)',
                    'Membaca Peta Digital & Rambu Petunjuk Arah',
                    'Menanyakan Halte Bus & Jadwal Keberangkatan',
                    'Simulasi Lengkap: Bepergian Antar Kota Sendiri',
                ]
            ],
            [
                'title' => 'Pekerjaan, Karir, Komunikasi Kantor & Akademik (2 Jam)',
                'description' => 'Mendiskusikan profesi, aktivitas kantor, email profesional, presentasi, dan suasana ruang kerja.',
                'grammar_title' => 'Bentuk Formal & Komunikasi Profesional',
                'grammar_formula' => '[Topik Tugas] + [Bentuk Hormat/Keigo] + [Laporan Tindakan]',
                'lessons' => [
                    'Ragam Profesi & Bidang Pekerjaan',
                    'Fasilitas & Alat Kantor (Komputer, Berkas)',
                    'Menyampaikan Tugas & Tanggung Jawab Harian',
                    'Menjadwalkan Rapat & Mengundang Partisipan',
                    'Menulis Pembuka & Penutup Pesan Formal',
                    'Menyampaikan Opini dalam Diskusi Kerja',
                    'Menjelaskan Grafik & Perkembangan Proyek',
                    'Meminta Izin Cuti & Alasan Berhalangan Hadir',
                    'Etiket Menerima & Menolak Permintaan Rekan Kerja',
                    'Simulasi Lengkap: Wawancara Kerja & Presentasi',
                ]
            ],
            [
                'title' => 'Berbelanja, Uang, Negosiasi & Kebutuhan Pasar (2 Jam)',
                'description' => 'Membeli pakaian, tawar menawar di pasar tradisional, kasir swalayan, ukuran, dan kebijakan retur.',
                'grammar_title' => 'Komparatif & Ungkapan Preferensi',
                'grammar_formula' => '[Opsi A] + [Lebih ... Dari] + [Opsi B]',
                'lessons' => [
                    'Jenis-jenis Toko (Swalayan, Pasar, Butik)',
                    'Pakaian, Sepatu, Warna, dan Ukuran (S/M/L)',
                    'Menanyakan Ketersediaan Stok & Warna Lain',
                    'Mencoba Pakaian di Ruang Ganti (Fitting Room)',
                    'Menanyakan Harga & Potongan Diskon',
                    'Tawar Menawar Harga di Pasar Tradisional',
                    'Membayar dengan Tunai, Kartu, atau QRIS/E-Wallet',
                    'Meminta Nota Pembelian & Kantong Belanja',
                    'Menukar Barang & Kebijakan Pengembalian Dana',
                    'Simulasi Lengkap: Berbelanja Oleh-Oleh di Pasar',
                ]
            ],
            [
                'title' => 'Tubuh Manusia, Kesehatan, Gejala Sakit & Medis (2 Jam)',
                'description' => 'Bagian anatomi tubuh, menjelaskan gejala sakit kepada dokter atau apoteker, dan resep obat.',
                'grammar_title' => 'Menyatakan Kondisi Fisik & Gejala',
                'grammar_formula' => '[Bagian Tubuh] + [Partikel Rasa Sakit] + [Intensitas Keluhan]',
                'lessons' => [
                    'Kosakata Anggota Tubuh Luar (Kepala, Mata, Kaki)',
                    'Menyatakan Gejala Sakit (Demam, Pusing, Batuk)',
                    'Pendaftaran Pasien di Klinik atau Rumah Sakit',
                    'Menjawab Pertanyaan Dokter Saat Pemeriksaan',
                    'Menebus Resep Obat di Apotek',
                    'Aturan Minum Obat (Sebelum/Sesudah Makan)',
                    'Kondisi Darurat & Memanggil Ambulans/Bantuan',
                    'Menjelaskan Riwayat Penyakit Ringan',
                    'Tips Menjaga Kebugaran & Istirahat Cukup',
                    'Simulasi Lengkap: Konsultasi ke Dokter Spesialis',
                ]
            ],
            [
                'title' => 'Cuaca, Musim, Sandang & Kegiatan Waktu Luang (2 Jam)',
                'description' => 'Kondisi cuaca harian, 4 musim (musim semi, panas, gugur, dingin), hobi, musik, dan liburan.',
                'grammar_title' => 'Bentuk Prediksi Cuaca & Preferensi Hobi',
                'grammar_formula' => '[Kondisi Cuaca] + [Bentuk Prediksi/Tampaknya]',
                'lessons' => [
                    'Kosakata Cuaca (Cerah, Hujan, Berawan, Bersalju)',
                    'Empat Musim & Ciri Khas Suhunya',
                    'Mendengarkan Prakiraan Cuaca Hari Esok',
                    'Hobi Kreatif (Membaca, Menggambar, Menulis)',
                    'Olahraga & Aktivitas Luar Ruangan (Lari, Renang)',
                    'Menonton Film, Konser Musik, dan Teater',
                    'Merencanakan Liburan Akhir Pekan',
                    'Mendeskripsikan Pemandangan Alam & Tempat Wisata',
                    'Mengambil Foto & Berbagi Pengalaman Wisata',
                    'Simulasi Lengkap: Percakapan Santai Mengenai Hobi',
                ]
            ],
            [
                'title' => 'Sintesis Komprehensif, Studi Kasus & Refleks Fasih (2 Jam)',
                'description' => 'Integrasi seluruh materi 1-9 ke dalam simulasi kasus nyata tingkat lanjut untuk menguji refleks.',
                'grammar_title' => 'Kalimat Majemuk & Penalaran Kontekstual',
                'grammar_formula' => '[Kalimat Sebab] + [Kata Penghubung] + [Kalimat Akibat]',
                'lessons' => [
                    'Mengatasi Masalah Bagasi Hilang di Bandara',
                    'Menyelesaikan Kesalahpahaman Pesanan di Restoran',
                    'Melaporkan Kehilangan Barang ke Kantor Polisi',
                    'Meminta Bantuan Darurat Kepada Warga Lokal',
                    'Membahas Rencana Perjalanan Wisata Terperinci',
                    'Diskusi Negosiasi Kerjasama Bisnis Sederhana',
                    'Memberikan Opini & Solusi Terhadap Masalah',
                    'Menulis Catatan Ringkas & Pesan Penting',
                    'Simulasi Menjawab Pertanyaan Spontan Tanpa Ragu',
                    'Uji Refleks Akhir: Percakapan Bebas Selama 15 Menit',
                ]
            ],
        ];
    }

    /**
     * Bank 100+ Kosakata Inti Level 1 Terjemahan Bahasa Indonesia & Detail Penggunaan
     */
    public static function getLevelOneVocabularyBank(string $langCode): array
    {
        return match ($langCode) {
            'ar' => self::getArabicLevelOneVocabBank(),
            'ja' => self::getJapaneseLevelOneVocabBank(),
            'ko' => self::getKoreanLevelOneVocabBank(),
            'en' => self::getEnglishLevelOneVocabBank(),
            default => []
        };
    }

    private static function getArabicLevelOneVocabBank(): array
    {
        return [
            [
                'word' => 'مَرْحَبًا',
                'trans' => 'Marhaban',
                'meaning' => 'Halo / Selamat Datang',
                'pos' => 'Ungkapan Sapaan',
                'daily_usage' => 'Sapaan santai dan ramah saat berpapasan dengan teman, rekan sejawat, atau menyambut tamu.',
                'example' => 'مَرْحَبًا بِكَ يَا أَخِي',
                'example_trans' => 'Selamat datang wahai saudaraku.',
                'audio' => 'مَرْحَبًا'
            ],
            [
                'word' => 'صَبَاحُ الخَيْرِ',
                'trans' => 'Shabaahul khair',
                'meaning' => 'Selamat Pagi',
                'pos' => 'Ungkapan Sapaan',
                'daily_usage' => 'Diucapkan sejak fajar hingga menjelang siang hari. Lawan bicara biasanya membalas dengan "Shabaahun Nuur".',
                'example' => 'صَبَاحُ الخَيْرِ يَا أُسْتَاذُ',
                'example_trans' => 'Selamat pagi wahai guru.',
                'audio' => 'صَبَاحُ الخَيْرِ'
            ],
            [
                'word' => 'مَسَاءُ الخَيْرِ',
                'trans' => 'Masaa-ul khair',
                'meaning' => 'Selamat Sore / Malam',
                'pos' => 'Ungkapan Sapaan',
                'daily_usage' => 'Diucapkan selepas matahari tergelincir (ba\'da dzuhur hingga malam). Dibalas dengan "Masaa-un Nuur".',
                'example' => 'مَسَاءُ الخَيْرِ جَمِيعًا',
                'example_trans' => 'Selamat sore semuanya.',
                'audio' => 'مَسَاءُ الخَيْرِ'
            ],
            [
                'word' => 'شُكْرًا',
                'trans' => 'Syukran',
                'meaning' => 'Terima Kasih',
                'pos' => 'Ungkapan Sopan',
                'daily_usage' => 'Ekspresi terima kasih mendasar dalam setiap transaksi, bantuan, atau pelayanan sehari-hari.',
                'example' => 'شُكْرًا جَزِيلاً عَلَى المُسَاعَدَةِ',
                'example_trans' => 'Terima kasih banyak atas bantuannya.',
                'audio' => 'شُكْرًا'
            ],
            [
                'word' => 'عَفْوًا',
                'trans' => '\'Afwan',
                'meaning' => 'Sama-sama / Maaf',
                'pos' => 'Ungkapan Sopan',
                'daily_usage' => 'Digunakan sebagai jawaban atas ucapan "Syukran", atau ungkapan permisi ringan saat melewati kerumunan.',
                'example' => 'عَفْوًا، أَيْنَ المَسْجِدُ؟',
                'example_trans' => 'Permisi, di manakah masjid?',
                'audio' => 'عَفْوًا'
            ],
            [
                'word' => 'كِتَابٌ',
                'trans' => 'Kitaabun',
                'meaning' => 'Buku',
                'pos' => 'Kata Benda (Mudzakkar)',
                'daily_usage' => 'Merujuk pada buku bacaan, modul pelajaran, atau dokumen berjilid.',
                'example' => 'هَذَا كِتَابٌ مُفِيدٌ',
                'example_trans' => 'Ini adalah buku yang bermanfaat.',
                'audio' => 'كِتَابٌ'
            ],
            [
                'word' => 'قَلَمٌ',
                'trans' => 'Qalamun',
                'meaning' => 'Pena / Alat Tulis',
                'pos' => 'Kata Benda (Mudzakkar)',
                'daily_usage' => 'Digunakan di kelas atau kantor saat meminta atau meminjam alat tulis.',
                'example' => 'أُرِيدُ قَلَمًا لِأَكْتُبَ',
                'example_trans' => 'Saya ingin pena untuk menulis.',
                'audio' => 'قَلَمٌ'
            ],
            [
                'word' => 'مَدْرَسَةٌ',
                'trans' => 'Madrasatun',
                'meaning' => 'Sekolah',
                'pos' => 'Kata Benda (Muannats)',
                'daily_usage' => 'Lembaga pendidikan formal tempat menimba ilmu.',
                'example' => 'أَذْهَبُ إِلَى المَدْرَسَةِ صَبَاحًا',
                'example_trans' => 'Saya pergi ke sekolah di pagi hari.',
                'audio' => 'مَدْرَسَةٌ'
            ],
            [
                'word' => 'بَيْتٌ',
                'trans' => 'Baitun',
                'meaning' => 'Rumah / Tempat Tinggal',
                'pos' => 'Kata Benda (Mudzakkar)',
                'daily_usage' => 'Merujuk pada rumah tinggal keluarga atau kediaman pribadi.',
                'example' => 'بَيْتِي قَرِيبٌ مِنَ المَسْجِدِ',
                'example_trans' => 'Rumah saya dekat dari masjid.',
                'audio' => 'بَيْتٌ'
            ],
            [
                'word' => 'مَاءٌ',
                'trans' => 'Maa-un',
                'meaning' => 'Air',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Sangat esensial saat memesan air minum di restoran atau meminta air wudhu.',
                'example' => 'أُرِيدُ مَاءً بَارِدًا',
                'example_trans' => 'Saya ingin air dingin.',
                'audio' => 'مَاءٌ'
            ],
            [
                'word' => 'طَعَامٌ',
                'trans' => 'Tha\'aamun',
                'meaning' => 'Makanan',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Menyebut makanan pokok atau hidangan meja makan.',
                'example' => 'الطَّعَامُ لَذِيذٌ جِدًّا',
                'example_trans' => 'Makanan ini sangat lezat.',
                'audio' => 'طَعَامٌ'
            ],
            [
                'word' => 'سَيَّارَةٌ',
                'trans' => 'Sayyaaratun',
                'meaning' => 'Mobil',
                'pos' => 'Kata Benda (Muannats)',
                'daily_usage' => 'Kendaraan pribadi beroda empat untuk transportasi harian.',
                'example' => 'هَذِهِ سَيَّارَةٌ جَدِيدَةٌ',
                'example_trans' => 'Ini adalah mobil baru.',
                'audio' => 'سَيَّارَةٌ'
            ],
            [
                'word' => 'شَارِعٌ',
                'trans' => 'Syaari\'un',
                'meaning' => 'Jalan Raya',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Digunakan saat menanyakan alamat atau petunjuk navigasi.',
                'example' => 'أَسْكُنُ فِي شَارِعِ المَلِكِ فَهْدٍ',
                'example_trans' => 'Saya tinggal di Jalan Raja Fahd.',
                'audio' => 'شَارِعٌ'
            ],
            [
                'word' => 'سَاعَةٌ',
                'trans' => 'Saa\'atun',
                'meaning' => 'Jam / Waktu',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Digunakan saat menanyakan waktu ("Kamis saa\'ah?" = Jam berapa sekarang?).',
                'example' => 'كَمِ السَّاعَةُ الآنَ؟',
                'example_trans' => 'Jam berapa sekarang?',
                'audio' => 'سَاعَةٌ'
            ],
            [
                'word' => 'طَالِبٌ',
                'trans' => 'Thaalibun',
                'meaning' => 'Pelajar / Mahasiswa',
                'pos' => 'Kata Benda (Profesi)',
                'daily_usage' => 'Menyebut status pelajar putra di jenjang sekolah maupun universitas.',
                'example' => 'أَنَا طَالِبٌ فِي الجَامِعَةِ',
                'example_trans' => 'Saya adalah mahasiswa di universitas.',
                'audio' => 'طَالِبٌ'
            ],
            [
                'word' => 'أُسْتَاذٌ',
                'trans' => 'Ustaadzun',
                'meaning' => 'Guru / Dosen',
                'pos' => 'Kata Benda (Profesi)',
                'daily_usage' => 'Panggilan kehormatan kepada pengajar atau tenaga pendidik.',
                'example' => 'الأُسْتَاذُ يَشْرَحُ الدَّرْسَ',
                'example_trans' => 'Guru sedang menerangkan pelajaran.',
                'audio' => 'أُسْتَاذٌ'
            ],
            [
                'word' => 'طَبِيبٌ',
                'trans' => 'Thabiibun',
                'meaning' => 'Dokter',
                'pos' => 'Kata Benda (Profesi)',
                'daily_usage' => 'Digunakan di rumah sakit atau klinik saat membutuhkan pemeriksaan medis.',
                'example' => 'الطَّبِيبُ يُعَالِجُ المَرِيضَ',
                'example_trans' => 'Dokter sedang mengobati pasien.',
                'audio' => 'طَبِيبٌ'
            ],
            [
                'word' => 'مُسْتَشْفَى',
                'trans' => 'Mustasyfaa',
                'meaning' => 'Rumah Sakit',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Fasilitas kesehatan rujukan saat kondisi sakit darurat.',
                'example' => 'المُسْتَشْفَى كَبِيرٌ وَنَظِيفٌ',
                'example_trans' => 'Rumah sakit itu besar dan bersih.',
                'audio' => 'مُسْتَشْفَى'
            ],
            [
                'word' => 'مَطَارٌ',
                'trans' => 'Mathaarun',
                'meaning' => 'Bandara Udara',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Digunakan saat bepergian ke luar negeri atau naik taksi bandara.',
                'example' => 'نَحْنُ فِي طَرِيقِنَا إِلَى المَطَارِ',
                'example_trans' => 'Kami sedang di jalan menuju bandara.',
                'audio' => 'مَطَارٌ'
            ],
            [
                'word' => 'سُوقٌ',
                'trans' => 'Suuqun',
                'meaning' => 'Pasar / Pusat Perbelanjaan',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Tempat berbelanja kebutuhan pokok atau suvenir.',
                'example' => 'ذَهَبْتُ إِلَى السُّوقِ لِشِرَاءِ الخُضَارِ',
                'example_trans' => 'Saya pergi ke pasar untuk membeli sayur-mayur.',
                'audio' => 'سُوقٌ'
            ],
            [
                'word' => 'نَعَمْ',
                'trans' => 'Na\'am',
                'meaning' => 'Ya (Persetujuan)',
                'pos' => 'Partikel Jawaban',
                'daily_usage' => 'Konfirmasi persetujuan dalam percakapan formal dan santai.',
                'example' => 'نَعَمْ، أَنَا جَاهِزٌ',
                'example_trans' => 'Ya, saya sudah siap.',
                'audio' => 'نَعَمْ'
            ],
            [
                'word' => 'لَا',
                'trans' => 'Laa',
                'meaning' => 'Tidak / Bukan',
                'pos' => 'Partikel Penolakan',
                'daily_usage' => 'Menolak tawaran secara sopan atau menyatakan ketidakbenaran suatu fakta.',
                'example' => 'لَا، لَسْتُ تَعْبَانًا',
                'example_trans' => 'Tidak, saya tidak lelah.',
                'audio' => 'لَا'
            ],
            [
                'word' => 'مِنْ فَضْلِكَ',
                'trans' => 'Min fadhlik',
                'meaning' => 'Tolong / Mohon (Permintaan Sopan)',
                'pos' => 'Ungkapan Sopan',
                'daily_usage' => 'Kunci kesopanan saat meminta tolong kepada seseorang atau pelayan toko.',
                'example' => 'أَعْطِنِي الفَاتُورَةَ مِنْ فَضْلِكَ',
                'example_trans' => 'Tolong berikan tagihannya kepada saya.',
                'audio' => 'مِنْ فَضْلِكَ'
            ],
            [
                'word' => 'كَمْ ثَمَنُ هَذَا؟',
                'trans' => 'Kam tsamanu haadza?',
                'meaning' => 'Berapa harga barang ini?',
                'pos' => 'Kalimat Tanya Praktis',
                'daily_usage' => 'Pertanyaan wajib saat berbelanja di toko atau pasar Arab.',
                'example' => 'كَمْ ثَمَنُ هَذَا القَمِيصِ؟',
                'example_trans' => 'Berapa harga kemeja ini?',
                'audio' => 'كَمْ ثَمَنُ هَذَا؟'
            ],
            [
                'word' => 'مَعَ السَّلَامَةِ',
                'trans' => 'Ma\'as salaamah',
                'meaning' => 'Selamat Jalan / Sampai Jumpa',
                'pos' => 'Ungkapan Perpisahan',
                'daily_usage' => 'Ungkapan berpisah yang mendoakan keselamatan bagi lawan bicara.',
                'example' => 'مَعَ السَّلَامَةِ، أَرَاكَ غَدًا',
                'example_trans' => 'Selamat jalan, sampai jumpa besok.',
                'audio' => 'مَعَ السَّلَامَةِ'
            ],
        ];
    }

    private static function getJapaneseLevelOneVocabBank(): array
    {
        return [
            [
                'word' => 'こんにちは',
                'trans' => 'Konnichiwa',
                'meaning' => 'Halo / Selamat Siang',
                'pos' => 'Ungkapan Sapaan',
                'daily_usage' => 'Sapaan umum dari pukul 10.00 hingga petang saat bertemu rekan kerja, tetangga, atau kenalan.',
                'example' => '田中さん、こんにちは！',
                'example_trans' => 'Pak Tanaka, halo selamat siang!',
                'audio' => 'こんにちは'
            ],
            [
                'word' => 'おはようございます',
                'trans' => 'Ohayou gozaimasu',
                'meaning' => 'Selamat Pagi (Sopan)',
                'pos' => 'Ungkapan Sapaan',
                'daily_usage' => 'Diucapkan saat awal bertemu di pagi hari di kantor, sekolah, atau lingkungan perumahan.',
                'example' => '先生、おはようございます。',
                'example_trans' => 'Guru, selamat pagi.',
                'audio' => 'おはようございます'
            ],
            [
                'word' => 'こんばんは',
                'trans' => 'Konbanwa',
                'meaning' => 'Selamat Malam',
                'pos' => 'Ungkapan Sapaan',
                'daily_usage' => 'Sapaan pembuka ketika bertemu seseorang setelah matahari terbenam.',
                'example' => '皆さん、こんばんは。',
                'example_trans' => 'Semuanya, selamat malam.',
                'audio' => 'こんばんは'
            ],
            [
                'word' => 'ありがとうございます',
                'trans' => 'Arigatou gozaimasu',
                'meaning' => 'Terima Kasih Banyak (Sopan)',
                'pos' => 'Ungkapan Sopan',
                'daily_usage' => 'Bentuk formal ucapan terima kasih kepada atasan, kasir, guru, atau orang yang membantu kita.',
                'example' => 'ご親切にありがとうございます。',
                'example_trans' => 'Terima kasih banyak atas kebaikan Anda.',
                'audio' => 'ありがとうございます'
            ],
            [
                'word' => 'すみません',
                'trans' => 'Sumimasen',
                'meaning' => 'Permisi / Maaf / Tolong',
                'pos' => 'Ungkapan Multifungsi',
                'daily_usage' => 'Paling sering dipakai: memanggil pelayan restoran, meminta maaf ringan, atau meminta jalan di kereta padat.',
                'example' => 'すみません、注文をお願いします。',
                'example_trans' => 'Permisi, tolong kami mau memesan makanan.',
                'audio' => 'すみません'
            ],
            [
                'word' => 'はい',
                'trans' => 'Hai',
                'meaning' => 'Ya / Mengerti / Hadir',
                'pos' => 'Partikel Respon',
                'daily_usage' => 'Digunakan saat mengiyakan pertanyaan atau sebagai respon tanda menyimak (aizuchi).',
                'example' => 'はい、わかりました。',
                'example_trans' => 'Ya, saya mengerti.',
                'audio' => 'はい'
            ],
            [
                'word' => 'いいえ',
                'trans' => 'Iie',
                'meaning' => 'Tidak / Sama-sama',
                'pos' => 'Partikel Respon',
                'daily_usage' => 'Menolak pernyataan atau merendah saat dipuji ("Iie, madamada desu").',
                'example' => 'いいえ、結構です。',
                'example_trans' => 'Tidak, sudah cukup terima kasih.',
                'audio' => 'いいえ'
            ],
            [
                'word' => 'ほん (本)',
                'trans' => 'Hon',
                'meaning' => 'Buku',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Merujuk pada buku cetak, novel, atau buku pelajaran.',
                'example' => '日本語の本を読みます。',
                'example_trans' => 'Saya membaca buku bahasa Jepang.',
                'audio' => 'ほん'
            ],
            [
                'word' => 'みず (水)',
                'trans' => 'Mizu',
                'meaning' => 'Air Dingin / Air Putih',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Meminta air minum di kedai ("O-mizu kudasai").',
                'example' => 'お水を一杯ください。',
                'example_trans' => 'Tolong berikan saya segelas air.',
                'audio' => 'みず'
            ],
            [
                'word' => 'ごはん (ご飯)',
                'trans' => 'Gohan',
                'meaning' => 'Nasi / Makanan Pokok',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Arti harfiah nasi matang, juga sinonim santapan waktu makan (Asa-gohan = sarapan pagi).',
                'example' => '朝ご飯を食べましたか？',
                'example_trans' => 'Apakah Anda sudah sarapan pagi?',
                'audio' => 'ごはん'
            ],
            [
                'word' => 'たべます (食べます)',
                'trans' => 'Tabemasu',
                'meaning' => 'Makan',
                'pos' => 'Kata Kerja (Golongan 2)',
                'daily_usage' => 'Aktivitas makan sehari-hari dalam bentuk sopan (-masu).',
                'example' => '寿司を食べます。',
                'example_trans' => 'Saya makan sushi.',
                'audio' => 'たべます'
            ],
            [
                'word' => 'のみます (飲みます)',
                'trans' => 'Nomimasu',
                'meaning' => 'Minum',
                'pos' => 'Kata Kerja (Golongan 1)',
                'daily_usage' => 'Meminum cairan (teh, kopi, air mineral).',
                'example' => '緑茶を飲みます。',
                'example_trans' => 'Saya minum teh hijau.',
                'audio' => 'のみます'
            ],
            [
                'word' => 'いきます (行きます)',
                'trans' => 'Ikimasu',
                'meaning' => 'Pergi',
                'pos' => 'Kata Kerja (Golongan 1)',
                'daily_usage' => 'Pergerakan menuju suatu tempat dengan partikel tujuan "e" (へ) atau "ni" (に).',
                'example' => '東京へ行きます。',
                'example_trans' => 'Saya pergi ke Tokyo.',
                'audio' => 'いきます'
            ],
            [
                'word' => 'きます (来ます)',
                'trans' => 'Kimasu',
                'meaning' => 'Datang',
                'pos' => 'Kata Kerja (Irregular)',
                'daily_usage' => 'Pergerakan menghampiri tempat pembicara berada.',
                'example' => '友達がうちに来ます。',
                'example_trans' => 'Teman datang ke rumah saya.',
                'audio' => 'きます'
            ],
            [
                'word' => 'せんせい (先生)',
                'trans' => 'Sensei',
                'meaning' => 'Guru / Dosen / Dokter',
                'pos' => 'Kata Benda (Gelar)',
                'daily_usage' => 'Sebutan hormat untuk pengajar, dokter, pengacara, atau mentor.',
                'example' => '先生、質問があります。',
                'example_trans' => 'Guru, saya memiliki pertanyaan.',
                'audio' => 'せんせい'
            ],
            [
                'word' => 'がくせい (学生)',
                'trans' => 'Gakusei',
                'meaning' => 'Siswa / Mahasiswa',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Menyatakan status pelajar.',
                'example' => '私は留学生です。',
                'example_trans' => 'Saya adalah mahasiswa internasional.',
                'audio' => 'がくせい'
            ],
            [
                'word' => 'がっこう (学校)',
                'trans' => 'Gakkou',
                'meaning' => 'Sekolah',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Institusi tempat belajar.',
                'example' => '毎日学校へ通います。',
                'example_trans' => 'Setiap hari saya pergi ke sekolah.',
                'audio' => 'がっこう'
            ],
            [
                'word' => 'くるま (車)',
                'trans' => 'Kuruma',
                'meaning' => 'Mobil',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Kendaraan roda empat.',
                'example' => '車を運転します。',
                'example_trans' => 'Saya mengemudikan mobil.',
                'audio' => 'くるま'
            ],
            [
                'word' => 'でんしゃ (電車)',
                'trans' => 'Densha',
                'meaning' => 'Kereta Listrik',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Transportasi utama di kota-kota Jepang.',
                'example' => '電車で会社へ行きます。',
                'example_trans' => 'Saya pergi ke kantor naik kereta listrik.',
                'audio' => 'でんしゃ'
            ],
            [
                'word' => 'えき (駅)',
                'trans' => 'Eki',
                'meaning' => 'Stasiun Kereta',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Titik pertemuan dan stasiun pemberangkatan.',
                'example' => '駅の前で会いましょう。',
                'example_trans' => 'Mari kita bertemu di depan stasiun.',
                'audio' => 'えき'
            ],
            [
                'word' => 'いくら',
                'trans' => 'Ikura',
                'meaning' => 'Berapa Harganya?',
                'pos' => 'Kata Tanya',
                'daily_usage' => 'Menanyakan harga saat berbelanja ("Kore wa ikura desu ka?").',
                'example' => 'これはいくらですか？',
                'example_trans' => 'Berapa harga barang ini?',
                'audio' => 'いくら'
            ],
            [
                'word' => 'どこ',
                'trans' => 'Doko',
                'meaning' => 'Di mana?',
                'pos' => 'Kata Tanya Lokasi',
                'daily_usage' => 'Menanyakan lokasi fasilitas atau barang.',
                'example' => 'トイレはどこですか？',
                'example_trans' => 'Di manakah toilet?',
                'audio' => 'どこ'
            ],
            [
                'word' => 'さようなら',
                'trans' => 'Sayounara',
                'meaning' => 'Selamat Tinggal / Sampai Jumpa',
                'pos' => 'Ungkapan Perpisahan',
                'daily_usage' => 'Perpisahan formal (dalam keseharian sesama teman lebih lazim "Mata ne" atau "Ja, mata").',
                'example' => '先生、さようなら。また明日。',
                'example_trans' => 'Guru, selamat tinggal. Sampai jumpa besok.',
                'audio' => 'さようなら'
            ],
            [
                'word' => 'はじめまして',
                'trans' => 'Hajimemashite',
                'meaning' => 'Senang Berkenalan dengan Anda',
                'pos' => 'Salam Perkenalan',
                'daily_usage' => 'Kalimat pertama yang diucapkan saat pertama kali bertemu seseorang.',
                'example' => 'はじめまして、アリフと申します。',
                'example_trans' => 'Senang berkenalan dengan Anda, nama saya Alif.',
                'audio' => 'はじめまして'
            ],
            [
                'word' => 'よろしくおねがいします',
                'trans' => 'Yoroshiku onegaishimasu',
                'meaning' => 'Mohon Bimbingan / Mohon Kerjasamanya',
                'pos' => 'Ungkapan Budaya Sakral',
                'daily_usage' => 'Diucapkan di akhir perkenalan, saat memulai kerja sama tim, atau menitipkan permohonan.',
                'example' => 'これからよろしくお願いします。',
                'example_trans' => 'Mulai sekarang, mohon bimbingan dan kerja samanya.',
                'audio' => 'よろしくおねがいします'
            ],
        ];
    }

    private static function getKoreanLevelOneVocabBank(): array
    {
        return [
            [
                'word' => '안녕하세요',
                'trans' => 'Annyeonghaseyo',
                'meaning' => 'Halo / Selamat Pagi/Siang/Sore',
                'pos' => 'Ungkapan Sapaan Sopan',
                'daily_usage' => 'Sapaan universal paling penting dalam bahasa Korea dengan membungkukkan badan sedikit.',
                'example' => '안녕하세요! 만나서 반갑습니다.',
                'example_trans' => 'Halo! Senang bertemu dengan Anda.',
                'audio' => '안녕하세요'
            ],
            [
                'word' => '감사합니다',
                'trans' => 'Gamsahamnida',
                'meaning' => 'Terima Kasih (Formal)',
                'pos' => 'Ungkapan Sopan',
                'daily_usage' => 'Ucapan rasa terima kasih resmi dan sopan kepada siapa saja dalam kehidupan sehari-hari.',
                'example' => '도와주셔서 감사합니다.',
                'example_trans' => 'Terima kasih atas bantuan Anda.',
                'audio' => '감사합니다'
            ],
            [
                'word' => '죄송합니다',
                'trans' => 'Joesonghamnida',
                'meaning' => 'Mohon Maaf (Formal/Sopan)',
                'pos' => 'Ungkapan Sopan',
                'daily_usage' => 'Permintaan maaf formal saat melakukan kesalahan atau saat terlambat datang.',
                'example' => '늦어서 죄송합니다.',
                'example_trans' => 'Mohon maaf saya terlambat.',
                'audio' => '죄송합니다'
            ],
            [
                'word' => '네',
                'trans' => 'Ne',
                'meaning' => 'Ya / Benar',
                'pos' => 'Partikel Persetujuan',
                'daily_usage' => 'Respon positif sopan saat dipanggil atau menyetujui pernyataan.',
                'example' => '네, 알겠습니다.',
                'example_trans' => 'Ya, saya mengerti.',
                'audio' => '네'
            ],
            [
                'word' => '아니요',
                'trans' => 'Aniyo',
                'meaning' => 'Tidak / Bukan',
                'pos' => 'Partikel Penolakan',
                'daily_usage' => 'Menolak atau menyanggah pertanyaan dengan santun.',
                'example' => '아니요, 괜찮습니다.',
                'example_trans' => 'Tidak, saya baik-baik saja terima kasih.',
                'audio' => '아니요'
            ],
            [
                'word' => '물',
                'trans' => 'Mul',
                'meaning' => 'Air',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Meminta air minum di restoran Korea ("Mul jom juseyo").',
                'example' => '시원한 물 주세요.',
                'example_trans' => 'Tolong berikan air dingin.',
                'audio' => '물'
            ],
            [
                'word' => '밥',
                'trans' => 'Bap',
                'meaning' => 'Nasi / Makanan',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Simbol kepedulian masyarakat Korea ("Bap meogeosseoyo?" = Sudah makan?).',
                'example' => '밥을 맛있게 먹었어요.',
                'example_trans' => 'Saya makan nasi dengan lahap.',
                'audio' => '밥'
            ],
            [
                'word' => '책',
                'trans' => 'Chaek',
                'meaning' => 'Buku',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Buku bacaan atau buku pelajaran.',
                'example' => '한국어 책을 읽어요.',
                'example_trans' => 'Saya membaca buku bahasa Korea.',
                'audio' => '책'
            ],
            [
                'word' => '학교',
                'trans' => 'Hakgyo',
                'meaning' => 'Sekolah',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Lembaga pendidikan formal.',
                'example' => '아침에 학교에 가요.',
                'example_trans' => 'Saya pergi ke sekolah di pagi hari.',
                'audio' => '학교'
            ],
            [
                'word' => '선생님',
                'trans' => 'Seonsaengnim',
                'meaning' => 'Guru / Pengajar / Dokter',
                'pos' => 'Kata Benda (Gelar Hormat)',
                'daily_usage' => 'Panggilan hormat di kelas atau klinik medis.',
                'example' => '선생님, 질문이 있습니다.',
                'example_trans' => 'Guru, saya ada pertanyaan.',
                'audio' => '선생님'
            ],
            [
                'word' => '친구',
                'trans' => 'Chingu',
                'meaning' => 'Teman / Sahabat Sebaya',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Teman akrab yang seusia (di Korea konsep umur sangat penting).',
                'example' => '주말에 친구를 만나요.',
                'example_trans' => 'Saya bertemu teman di akhir pekan.',
                'audio' => '친구'
            ],
            [
                'word' => '집',
                'trans' => 'Jip',
                'meaning' => 'Rumah',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Tempat tinggal atau kediaman keluarga.',
                'example' => '집에 일찍 갈 거예요.',
                'example_trans' => 'Saya akan pulang ke rumah lebih awal.',
                'audio' => '집'
            ],
            [
                'word' => '회사',
                'trans' => 'Hoesa',
                'meaning' => 'Perusahaan / Tempat Kerja',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Kantor tempat seseorang bekerja.',
                'example' => '회사에서 일해요.',
                'example_trans' => 'Saya bekerja di kantor perusahaan.',
                'audio' => '회사'
            ],
            [
                'word' => '병원',
                'trans' => 'Byeongwon',
                'meaning' => 'Rumah Sakit / Klinik',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Fasilitas kesehatan saat merasa kurang sehat.',
                'example' => '감기 때문에 병원에 갔어요.',
                'example_trans' => 'Saya pergi ke klinik karena flu.',
                'audio' => '병원'
            ],
            [
                'word' => '지하철',
                'trans' => 'Jihacheol',
                'meaning' => 'Kereta Bawah Tanah (Subway)',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Moda angkutan cepat utama di kota metropolitan Korea.',
                'example' => '지하철을 타고 이동해요.',
                'example_trans' => 'Saya bepergian naik kereta subway.',
                'audio' => '지하철'
            ],
            [
                'word' => '공항',
                'trans' => 'Gonghang',
                'meaning' => 'Bandara Udara',
                'pos' => 'Kata Benda',
                'daily_usage' => 'Bandara Incheon atau Gimpo saat bepergian keluar masuk Korea.',
                'example' => '인천공항에 도착했습니다.',
                'example_trans' => 'Saya telah tiba di Bandara Incheon.',
                'audio' => '공항'
            ],
            [
                'word' => '얼마예요?',
                'trans' => 'Eolmayeyo?',
                'meaning' => 'Berapa harganya?',
                'pos' => 'Kalimat Tanya Belanja',
                'daily_usage' => 'Pertanyaan wajib saat berbelanja di Myeongdong atau pasar tradisional.',
                'example' => '이 사과 얼마예요?',
                'example_trans' => 'Apel ini berapa harganya?',
                'audio' => '얼마예요'
            ],
            [
                'word' => '어디예요?',
                'trans' => 'Eodiyeyo?',
                'meaning' => 'Di manakah letaknya?',
                'pos' => 'Kalimat Tanya Lokasi',
                'daily_usage' => 'Menanyakan keberadaan seseorang atau tempat umum.',
                'example' => '화장실이 어디예요?',
                'example_trans' => 'Di manakah toilet?',
                'audio' => '어디예요'
            ],
            [
                'word' => '안녕히 가세요',
                'trans' => 'Annyeonghi gaseyo',
                'meaning' => 'Selamat Jalan (Kepada Orang yang Pergi)',
                'pos' => 'Ungkapan Perpisahan',
                'daily_usage' => 'Diucapkan tuan rumah atau orang yang tetap tinggal kepada tamu yang pulang.',
                'example' => '오늘 감사했습니다. 안녕히 가세요!',
                'example_trans' => 'Terima kasih untuk hari ini. Selamat jalan!',
                'audio' => '안녕히 가세요'
            ],
            [
                'word' => '안녕히 계세요',
                'trans' => 'Annyeonghi gyeseyo',
                'meaning' => 'Selamat Tinggal (Kepada Orang yang Tinggal)',
                'pos' => 'Ungkapan Perpisahan',
                'daily_usage' => 'Diucapkan oleh orang yang pamit pulang kepada tuan rumah.',
                'example' => '먼저 일어나겠습니다. 안녕히 계세요!',
                'example_trans' => 'Saya pamit duluan. Selamat tinggal!',
                'audio' => '안녕히 계세요'
            ],
            [
                'word' => '주세요',
                'trans' => 'Juseyo',
                'meaning' => 'Tolong Berikan / Mohon',
                'pos' => 'Akhiran Permintaan Sopan',
                'daily_usage' => 'Digunakan saat meminta barang atau pesanan di toko dan kafe.',
                'example' => '아메리카노 한 잔 주세요.',
                'example_trans' => 'Tolong berikan satu cangkir Americano.',
                'audio' => '주세요'
            ],
            [
                'word' => '맛있어요',
                'trans' => 'Masisseoyo',
                'meaning' => 'Enak / Lezat',
                'pos' => 'Kata Sifat',
                'daily_usage' => 'Memuji hidangan di restoran Korea agar koki senang.',
                'example' => '이 음식이 정말 맛있어요!',
                'example_trans' => 'Makanan ini sungguh enak sekali!',
                'audio' => '맛있어요'
            ],
            [
                'word' => '지금',
                'trans' => 'Jigeum',
                'meaning' => 'Sekarang',
                'pos' => 'Keterangan Waktu',
                'daily_usage' => 'Menyatakan momentum saat ini.',
                'example' => '지금 몇 시예요?',
                'example_trans' => 'Sekarang jam berapa?',
                'audio' => '지금'
            ],
            [
                'word' => '오늘',
                'trans' => 'Oneul',
                'meaning' => 'Hari Ini',
                'pos' => 'Keterangan Waktu',
                'daily_usage' => 'Rencana atau kegiatan di hari yang sedang berlangsung.',
                'example' => '오늘 날씨가 아주 좋아요.',
                'example_trans' => 'Hari ini cuacanya sangat bagus.',
                'audio' => '오늘'
            ],
            [
                'word' => '내일',
                'trans' => 'Naeil',
                'meaning' => 'Besok',
                'pos' => 'Keterangan Waktu',
                'daily_usage' => 'Merencanakan janji pertemuan hari esok.',
                'example' => '내일 다시 만나요.',
                'example_trans' => 'Sampai bertemu lagi besok.',
                'audio' => '내일'
            ],
        ];
    }

    private static function getEnglishLevelOneVocabBank(): array
    {
        return [
            [
                'word' => 'Hello',
                'trans' => '/həˈloʊ/',
                'meaning' => 'Halo / Hai',
                'pos' => 'Greeting',
                'daily_usage' => 'Universal greeting used when meeting someone face-to-face or answering a phone call.',
                'example' => 'Hello, nice to meet you!',
                'example_trans' => 'Halo, senang berkenalan dengan Anda!',
                'audio' => 'Hello'
            ],
            [
                'word' => 'Good morning',
                'trans' => '/ɡʊd ˈmɔːr.nɪŋ/',
                'meaning' => 'Selamat Pagi',
                'pos' => 'Greeting',
                'daily_usage' => 'Polite greeting used from dawn until 12:00 PM at school, office, or in the neighborhood.',
                'example' => 'Good morning, how are you today?',
                'example_trans' => 'Selamat pagi, bagaimana kabar Anda hari ini?',
                'audio' => 'Good morning'
            ],
            [
                'word' => 'Thank you',
                'trans' => '/ˈθæŋk ˌjuː/',
                'meaning' => 'Terima Kasih',
                'pos' => 'Polite Expression',
                'daily_usage' => 'Essential polite phrase when receiving help, a purchase receipt, or a kind gesture.',
                'example' => 'Thank you very much for your kind support.',
                'example_trans' => 'Terima kasih banyak atas dukungan baik Anda.',
                'audio' => 'Thank you'
            ],
            [
                'word' => 'You are welcome',
                'trans' => '/jʊər ˈwel.kəm/',
                'meaning' => 'Sama-sama / Kembali',
                'pos' => 'Polite Response',
                'daily_usage' => 'Standard gracious reply after someone says "Thank you".',
                'example' => 'You are always welcome here.',
                'example_trans' => 'Sama-sama, Anda selalu disambut baik di sini.',
                'audio' => 'You are welcome'
            ],
            [
                'word' => 'Excuse me',
                'trans' => '/ɪkˈskjuːz ˌmiː/',
                'meaning' => 'Permisi / Maaf',
                'pos' => 'Polite Expression',
                'daily_usage' => 'Used to get someone\'s attention, ask for directions, or pass through a crowded aisle.',
                'example' => 'Excuse me, where is the nearest station?',
                'example_trans' => 'Permisi, di manakah stasiun terdekat?',
                'audio' => 'Excuse me'
            ],
            [
                'word' => 'I am sorry',
                'trans' => '/aɪ æm ˈsɒr.i/',
                'meaning' => 'Saya Minta Maaf',
                'pos' => 'Apology',
                'daily_usage' => 'Used when acknowledging an accidental mistake or expressing sympathy.',
                'example' => 'I am sorry for being a few minutes late.',
                'example_trans' => 'Saya minta maaf karena terlambat beberapa menit.',
                'audio' => 'I am sorry'
            ],
            [
                'word' => 'Please',
                'trans' => '/pliːz/',
                'meaning' => 'Tolong / Silakan',
                'pos' => 'Polite Marker',
                'daily_usage' => 'Turns any command into a courteous and polite request.',
                'example' => 'Could you please help me with this form?',
                'example_trans' => 'Bisakah Anda tolong membantu saya mengisi formulir ini?',
                'audio' => 'Please'
            ],
            [
                'word' => 'Water',
                'trans' => '/ˈwɔː.tər/',
                'meaning' => 'Air Minum',
                'pos' => 'Noun',
                'daily_usage' => 'Vital noun when dining out or ordering drinks.',
                'example' => 'Can I have a glass of water, please?',
                'example_trans' => 'Bolehkah saya minta segelas air putih, tolong?',
                'audio' => 'Water'
            ],
            [
                'word' => 'Food',
                'trans' => '/fuːd/',
                'meaning' => 'Makanan',
                'pos' => 'Noun',
                'daily_usage' => 'General term for meals, groceries, and dining.',
                'example' => 'The local street food here is delicious.',
                'example_trans' => 'Makanan jalanan lokal di sini sangat lezat.',
                'audio' => 'Food'
            ],
            [
                'word' => 'Book',
                'trans' => '/bʊk/',
                'meaning' => 'Buku / Memesan',
                'pos' => 'Noun / Verb',
                'daily_usage' => 'Reading material as a noun, or booking a room/ticket as a verb.',
                'example' => 'I need to book a hotel room for tomorrow.',
                'example_trans' => 'Saya perlu memesan kamar hotel untuk besok.',
                'audio' => 'Book'
            ],
            [
                'word' => 'Friend',
                'trans' => '/frend/',
                'meaning' => 'Teman / Sahabat',
                'pos' => 'Noun',
                'daily_usage' => 'Refers to companion, peer, or acquaintance.',
                'example' => 'She is my closest friend from university.',
                'example_trans' => 'Dia adalah sahabat terdekat saya dari universitas.',
                'audio' => 'Friend'
            ],
            [
                'word' => 'Family',
                'trans' => '/ˈfæm.əl.i/',
                'meaning' => 'Keluarga',
                'pos' => 'Noun',
                'daily_usage' => 'Describing personal life and relatives.',
                'example' => 'I love spending the weekend with my family.',
                'example_trans' => 'Saya suka menghabiskan akhir pekan bersama keluarga.',
                'audio' => 'Family'
            ],
            [
                'word' => 'School',
                'trans' => '/skuːl/',
                'meaning' => 'Sekolah',
                'pos' => 'Noun',
                'daily_usage' => 'Educational institution for children or teenagers.',
                'example' => 'The students walk to school every morning.',
                'example_trans' => 'Para siswa berjalan kaki ke sekolah setiap pagi.',
                'audio' => 'School'
            ],
            [
                'word' => 'Hospital',
                'trans' => '/ˈhɒs.pɪ.təl/',
                'meaning' => 'Rumah Sakit',
                'pos' => 'Noun',
                'daily_usage' => 'Medical center for consultations and emergencies.',
                'example' => 'Where is the general hospital located?',
                'example_trans' => 'Di manakah lokasi rumah sakit umum berada?',
                'audio' => 'Hospital'
            ],
            [
                'word' => 'Airport',
                'trans' => '/ˈeə.pɔːt/',
                'meaning' => 'Bandara Udara',
                'pos' => 'Noun',
                'daily_usage' => 'Key travel hub when flying domestic or international flights.',
                'example' => 'We need to arrive at the airport two hours before departure.',
                'example_trans' => 'Kita harus tiba di bandara dua jam sebelum keberangkatan.',
                'audio' => 'Airport'
            ],
            [
                'word' => 'Office',
                'trans' => '/ˈɒf.ɪs/',
                'meaning' => 'Kantor / Tempat Kerja',
                'pos' => 'Noun',
                'daily_usage' => 'Workplace for corporate, administrative, or business jobs.',
                'example' => 'Our company office is situated in the city center.',
                'example_trans' => 'Kantor perusahaan kami terletak di pusat kota.',
                'audio' => 'Office'
            ],
            [
                'word' => 'Time',
                'trans' => '/taɪm/',
                'meaning' => 'Waktu / Jam',
                'pos' => 'Noun',
                'daily_usage' => 'Asking or managing schedule ("What time is it?").',
                'example' => 'What time does the conference begin?',
                'example_trans' => 'Jam berapa konferensi akan dimulai?',
                'audio' => 'Time'
            ],
            [
                'word' => 'Today',
                'trans' => '/təˈdeɪ/',
                'meaning' => 'Hari Ini',
                'pos' => 'Adverb / Noun',
                'daily_usage' => 'Referring to the current date and ongoing events.',
                'example' => 'Today is a great day to learn something new.',
                'example_trans' => 'Hari ini adalah hari yang luar biasa untuk mempelajari hal baru.',
                'audio' => 'Today'
            ],
            [
                'word' => 'Tomorrow',
                'trans' => '/təˈmɒr.oʊ/',
                'meaning' => 'Besok',
                'pos' => 'Adverb / Noun',
                'daily_usage' => 'Planning commitments for the following day.',
                'example' => 'See you tomorrow morning at nine.',
                'example_trans' => 'Sampai bertemu lagi besok pagi pukul sembilan.',
                'audio' => 'Tomorrow'
            ],
            [
                'word' => 'How much',
                'trans' => '/haʊ mʌtʃ/',
                'meaning' => 'Berapa harganya? / Berapa banyak?',
                'pos' => 'Question Phrase',
                'daily_usage' => 'Used when shopping to inquire about price or uncountable quantities.',
                'example' => 'How much does this souvenir cost?',
                'example_trans' => 'Berapa harga oleh-oleh suvenir ini?',
                'audio' => 'How much'
            ],
            [
                'word' => 'Where',
                'trans' => '/weər/',
                'meaning' => 'Di mana? / Ke mana?',
                'pos' => 'Question Word',
                'daily_usage' => 'Locating places, facilities, or items.',
                'example' => 'Where can I find an ATM machine around here?',
                'example_trans' => 'Di manakah saya bisa menemukan mesin ATM di sekitar sini?',
                'audio' => 'Where'
            ],
            [
                'word' => 'Goodbye',
                'trans' => '/ɡʊdˈbaɪ/',
                'meaning' => 'Selamat Tinggal / Sampai Jumpa',
                'pos' => 'Farewell',
                'daily_usage' => 'Universal parting expression when leaving.',
                'example' => 'Goodbye, take care and have a safe trip!',
                'example_trans' => 'Selamat tinggal, hati-hati dan semoga perjalanan Anda aman!',
                'audio' => 'Goodbye'
            ],
            [
                'word' => 'Understand',
                'trans' => '/ˌʌn.dəˈstænd/',
                'meaning' => 'Memahami / Mengerti',
                'pos' => 'Verb',
                'daily_usage' => 'Verifying comprehension during study or workplace instruction.',
                'example' => 'Do you understand the grammar rule now?',
                'example_trans' => 'Apakah Anda memahami aturan tata bahasa ini sekarang?',
                'audio' => 'Understand'
            ],
            [
                'word' => 'Help',
                'trans' => '/help/',
                'meaning' => 'Bantuan / Menolong',
                'pos' => 'Noun / Verb',
                'daily_usage' => 'Calling for assistance or offering aid to others.',
                'example' => 'Can someone please help me with these heavy bags?',
                'example_trans' => 'Bisakah seseorang tolong membantu saya dengan tas berat ini?',
                'audio' => 'Help'
            ],
            [
                'word' => 'Delicious',
                'trans' => '/dɪˈlɪʃ.əs/',
                'meaning' => 'Lezat / Enak Sekali',
                'pos' => 'Adjective',
                'daily_usage' => 'Praising meal flavors at a dinner or restaurant.',
                'example' => 'This traditional dish is absolutely delicious.',
                'example_trans' => 'Hidangan tradisional ini sungguh sangat lezat.',
                'audio' => 'Delicious'
            ],
        ];
    }
}
