<?php

namespace App\Services;

class InteractiveDialogueService
{
    /**
     * Menghasilkan 100 Skenario Pembelajaran Interaktif Komunikasi 2 Orang atau Lebih
     * Lengkap dengan penutur multi-karakter, terjemahan Indonesia, dan pelafalan abjad.
     */
    public static function generate100Dialogues(string $langCode, array $vocabs = [], array $uData = [], int $lessonOrder = 1): array
    {
        $filePath = database_path("data/dialogues/{$langCode}_dialogues.json");
        if (file_exists($filePath)) {
            $json = file_get_contents($filePath);
            $decoded = json_decode($json, true);
            if (is_array($decoded) && count($decoded) >= 100) {
                return $decoded;
            }
        }

        $categories = [
            'Salam & Perkenalan' => [
                'icon' => 'user-check',
                'topics' => [
                    'Menyapa Rekan Baru di Hari Pertama',
                    'Berkenalan saat Menunggu Transportasi Umum',
                    'Menyapa Tetangga Baru di Kompleks',
                    'Pertemuan dengan Mahasiswa Pertukaran Asing',
                    'Sapaan Hangat di Lobi Hotel',
                    'Bertemu Teman Lama di Pusat Perbelanjaan',
                    'Perkenalan Singkat Sebelum Seminar',
                    'Menyapa Tamu Kehormatan di Kantor',
                    'Sapaan Santai di Kafe Perpustakaan',
                    'Menyapa Pemilik Toko Buku Langganan'
                ]
            ],
            'Restoran & Kuliner' => [
                'icon' => 'coffee',
                'topics' => [
                    'Memesan Menu Sarapan Pagi di Kafe',
                    'Menanyakan Rekomendasi Makanan Khas Penutur Asli',
                    'Meminta Pilihan Makanan Halal dan Non-Alergi',
                    'Memesan Meja untuk Rombongan Keluarga',
                    'Menambah Pesanan Minuman Hangat',
                    'Menanyakan Bumbu dan Tingkat Kepedasan Masakan',
                    'Meminta Tagihan Pembayaran di Restoran',
                    'Pemesanan Makanan Cepat Saji di Kasir',
                    'Menanyakan Menu Penutup Tradisional',
                    'Pujian Rasa Masakan kepada Koki Restoran'
                ]
            ],
            'Navigasi & Stasiun' => [
                'icon' => 'map-pin',
                'topics' => [
                    'Menanyakan Arah Menuju Peron Kereta Cepat',
                    'Membeli Tiket Bus Antarkota di Loket',
                    'Menanyakan Jadwal Keberangkatan Terakhir',
                    'Mencari Pintu Keluar Terdekat Menuju Pusat Kota',
                    'Menanyakan Jalur Pergantian Kereta Bawah Tanah',
                    'Memastikan Rute Bus Umum yang Melewati Kampus',
                    'Meminta Bantuan Menggunakan Mesin Tiket Otomatis',
                    'Menanyakan Lokasi Kantor Informasi Turis',
                    'Menanyakan Jarak Tempuh Berjalan Kaki',
                    'Memastikan Nama Halte Pemberhentian'
                ]
            ],
            'Pasar & Belanja' => [
                'icon' => 'shopping-bag',
                'topics' => [
                    'Menanyakan Harga Cinderamata Unik',
                    'Mencari Ukuran Pakaian yang Lebih Pas',
                    'Menanyakan Ketersediaan Warna Lain',
                    'Tawar-menawar Ramah di Pasar Tradisional',
                    'Metode Pembayaran Kartu atau Tunai',
                    'Mencari Hadiah Ulang Tahun untuk Sahabat',
                    'Meminta Bungkusan Hadiah Khusus',
                    'Menanyakan Kebijakan Penukaran Barang',
                    'Membeli Buah-buahan Segar di Pasar Pagi',
                    'Memastikan Kualitas Produk Kerajinan Tangan'
                ]
            ],
            'Kampus & Pendidikan' => [
                'icon' => 'graduation-cap',
                'topics' => [
                    'Menanyakan Ruang Kuliah Bersama Dosen',
                    'Diskusi Tugas Kelompok dengan Rekan Seangkatan',
                    'Meminjam Buku Referensi di Perpustakaan',
                    'Pendaftaran Ujian Bahasa Asing Tingkat Lanjut',
                    'Konsultasi Jadwal Bimbingan Riset',
                    'Menanyakan Bahan Kuliah Pekan Lalu',
                    'Bergabung dengan Klub Kebudayaan Internasional',
                    'Membeli Perlengkapan Alat Tulis di Koperasi',
                    'Mempersiapkan Presentasi Proyek Akhir',
                    'Berbagi Catatan Ringkasan Kuliah'
                ]
            ],
            'Kantor & Rapat' => [
                'icon' => 'briefcase',
                'topics' => [
                    'Menyambut Klien Asing di Ruang Rapat',
                    'Menyampaikan Laporan Progres Mingguan',
                    'Menjadwalkan Ulang Pertemuan Bisnis',
                    'Diskusi Target Penjualan dengan Manajer Tim',
                    'Mengirimkan Dokumen Melalui Surat Elektronik',
                    'Meminta Masukan Ide untuk Peluncuran Produk',
                    'Koordinasi Kerjasama Antardivisi',
                    'Menanyakan Prosedur Cuti Kerja',
                    'Mempersiapkan Ruangan Konferensi Video',
                    'Evaluasi Kepuasan Pelanggan Korporat'
                ]
            ],
            'Hotel & Wisata' => [
                'icon' => 'bed',
                'topics' => [
                    'Proses Check-in Kamar Pesanan Online',
                    'Meminta Layanan Pembersihan Kamar Harian',
                    'Menanyakan Sandi Jaringan Internet Nirkabel',
                    'Menitipkan Koper di Bagasi Resepsionis',
                    'Meminta Panggilan Bangun Pagi (Wake-up Call)',
                    'Menanyakan Rekomendasi Objek Wisata Ikonik',
                    'Memesan Taksi Menuju Bandara Internasional',
                    'Menanyakan Jadwal Sarapan Prasmanan Hotel',
                    'Menyewa Pemandu Wisata Bahasa Indonesia',
                    'Proses Check-out Cepat di Meja Depan'
                ]
            ],
            'Kesehatan & Medis' => [
                'icon' => 'heart-pulse',
                'topics' => [
                    'Konsultasi Gejala Demam dan Flu di Klinik',
                    'Membeli Obat Sakit Kepala di Apotek',
                    'Menanyakan Dosis dan Aturan Minum Obat',
                    'Mendaftar Pemeriksaan Dokter Spesialis',
                    'Menjelaskan Alergi terhadap Makanan Tertentu',
                    'Meminta Surat Keterangan Dokter',
                    'Memeriksakan Tekanan Darah dan Suhu Tubuh',
                    'Mencari Lokasi Instalasi Gawat Darurat',
                    'Menanyakan Layanan Asuransi Kesehatan',
                    'Mendapatkan Resep Vitamin Tambahan'
                ]
            ],
            'Diskusi 3 Orang' => [
                'icon' => 'users',
                'topics' => [
                    'Merencanakan Liburan Akhir Pekan Bertiga',
                    'Memilih Restoran Favorit untuk Acara Makan Bersama',
                    'Diskusi Pembagian Tugas Proyek Antara 3 Mahasiswa',
                    'Percakapan antara Tamu, Kasir, dan Manajer Restoran',
                    'Diskusi Antara Pembeli, Penjual, dan Pemandu Wisata',
                    'Musyawarah Memilih Topik Seminar Kampus',
                    'Percakapan Pasien, Resepsionis, dan Dokter Klinik',
                    'Membahas Rute Perjalanan Antara 3 Rekan Bepergian',
                    'Percakapan antara Pelamar, HRD, dan Pewawancara Teknis',
                    'Diskusi Menentukan Tanggal Reuni Alumni'
                ]
            ],
            'Solusi Masalah & Darurat' => [
                'icon' => 'shield-alert',
                'topics' => [
                    'Melaporkan Barang Tertinggal di Taksi',
                    'Meminta Bantuan Petugas Keamanan Stasiun',
                    'Mengatasi Kendala Koneksi Ponsel Pintar',
                    'Meminta Petunjuk Arah saat Tersesat',
                    'Melaporkan Kerusakan Pendingin Ruangan di Kamar',
                    'Menukar Pesanan Makanan yang Tertukar',
                    'Menanyakan Pos Informasi Barang Hilang',
                    'Meminta Bantuan Medis Pertama saat Terkilir',
                    'Menanyakan Nomor Telepon Darurat Kedutaan',
                    'Menyelesaikan Kesalahpahaman Jadwal Janji Temu'
                ]
            ]
        ];

        $speakers = self::getSpeakersForLanguage($langCode);
        $scenarios = [];
        $scenarioId = 1;

        foreach ($categories as $catName => $catData) {
            foreach ($catData['topics'] as $tIndex => $topicTitle) {
                $isThreeSpeakers = ($catName === 'Diskusi 3 Orang' || ($tIndex % 3 === 0));
                $participantCount = $isThreeSpeakers ? 3 : 2;

                $currentSpeakers = [
                    $speakers[0],
                    $speakers[1],
                    $isThreeSpeakers ? $speakers[2] : null
                ];

                $turns = self::buildScenarioTurns(
                    $langCode,
                    $catName,
                    $topicTitle,
                    $currentSpeakers,
                    $scenarioId,
                    $vocabs
                );

                $scenarios[] = [
                    'id' => $scenarioId,
                    'category' => $catName,
                    'icon' => $catData['icon'],
                    'title' => "Skenario #{$scenarioId}: {$topicTitle}",
                    'situation' => "Percakapan komunikasi kontekstual di situasi '{$topicTitle}' yang melibatkan {$participantCount} penutur aktif.",
                    'participant_count' => $participantCount,
                    'participants' => array_filter([
                        "{$currentSpeakers[0]['name']} ({$currentSpeakers[0]['role']})",
                        "{$currentSpeakers[1]['name']} ({$currentSpeakers[1]['role']})",
                        $isThreeSpeakers ? "{$currentSpeakers[2]['name']} ({$currentSpeakers[2]['role']})" : null
                    ]),
                    'turns' => $turns,
                ];

                $scenarioId++;
            }
        }

        return $scenarios;
    }

    private static function getSpeakersForLanguage(string $langCode): array
    {
        return match ($langCode) {
            'ar' => [
                ['name' => 'Ahmad', 'role' => 'Penutur Utama (Tamu / Mahasiswa)', 'avatar' => 'AH'],
                ['name' => 'Fatimah', 'role' => 'Penutur Kedua (Petugas / Rekan)', 'avatar' => 'FA'],
                ['name' => 'Zaid', 'role' => 'Penutur Ketiga (Pemandu / Dosen)', 'avatar' => 'ZA'],
            ],
            'ja' => [
                ['name' => 'Tanaka-san', 'role' => 'Penutur Utama (Tamu / Mahasiswa)', 'avatar' => 'TA'],
                ['name' => 'Yuki-san', 'role' => 'Penutur Kedua (Staf / Rekan)', 'avatar' => 'YU'],
                ['name' => 'Sato-san', 'role' => 'Penutur Ketiga (Manajer / Pengajar)', 'avatar' => 'SA'],
            ],
            'ko' => [
                ['name' => 'Minjun', 'role' => 'Penutur Utama (Wisatawan / Siswa)', 'avatar' => 'MJ'],
                ['name' => 'Jisoo', 'role' => 'Penutur Kedua (Pegawai / Teman)', 'avatar' => 'JS'],
                ['name' => 'Taehyun', 'role' => 'Penutur Ketiga (Pemandu / Senior)', 'avatar' => 'TH'],
            ],
            'zh' => [
                ['name' => 'Li Wei', 'role' => 'Penutur Utama (Pelanggan / Pelajar)', 'avatar' => 'LW'],
                ['name' => 'Wang Fang', 'role' => 'Penutur Kedua (Pramuniaga / Rekan)', 'avatar' => 'WF'],
                ['name' => 'Zhang Ming', 'role' => 'Penutur Ketiga (Manajer / Dosen)', 'avatar' => 'ZM'],
            ],
            default => [
                ['name' => 'Alex', 'role' => 'Penutur Utama (Traveler / Student)', 'avatar' => 'AL'],
                ['name' => 'Emma', 'role' => 'Penutur Kedua (Officer / Friend)', 'avatar' => 'EM'],
                ['name' => 'David', 'role' => 'Penutur Ketiga (Guide / Specialist)', 'avatar' => 'DA'],
            ]
        };
    }

    private static function buildScenarioTurns(
        string $langCode,
        string $category,
        string $topic,
        array $speakers,
        int $scenarioNum,
        array $vocabs
    ): array {
        $sp1 = $speakers[0];
        $sp2 = $speakers[1];
        $sp3 = $speakers[2] ?? null;

        // Ambil kosakata referensi jika tersedia
        $vocabSample = $vocabs[($scenarioNum - 1) % max(1, count($vocabs))]['word'] ?? '';

        switch ($langCode) {
            case 'ar':
                $t1 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "السَّلَامُ عَلَيْكُمْ، هَلْ يُمْكِنُكَ مُسَاعَدَتِي فِي {$topic}؟",
                    'trans' => "Assalamu 'alaikum, hal yumkinuka musa'adati fi {$topic}?",
                    'meaning' => "Assalamu'alaikum, bisakah Anda membantu saya mengenai {$topic}?",
                    'audio' => "السَّلَامُ عَلَيْكُمْ، هَلْ يُمْكِنُكَ مُسَاعَدَتِي هُنَا؟",
                ];
                $t2 = [
                    'speaker' => $sp2['name'],
                    'role' => $sp2['role'],
                    'text' => "وَعَلَيْكُمُ السَّلَامُ! بِكُلِّ سُرُورٍ، هَذَا هُوَ الْأَمْرُ الْمَطْلُوبُ تَمَامًا.",
                    'trans' => "Wa'alaikumussalam! Bikulli sururin, hadza huwal amrul mathlubu tamaman.",
                    'meaning' => "Wa'alaikumsalam! Dengan senang hati, inilah hal yang diperlukan secara tepat.",
                    'audio' => "وَعَلَيْكُمُ السَّلَامُ! بِكُلِّ سُرُورٍ، تَفَضَّلْ هُنَا.",
                ];
                $t3 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "شُكْرًا جَزِيلاً لَكَ عَلَى هَذَا التَّوْضِيحِ الْمُفِيدِ.",
                    'trans' => "Syukran jazilan laka 'ala hadzat taudhihil mufid.",
                    'meaning' => "Terima kasih banyak atas penjelasan yang sangat bermanfaat ini.",
                    'audio' => "شُكْرًا جَزِيلاً لَكَ عَلَى الْمُسَاعَدَةِ.",
                ];
                $turns = [$t1, $t2, $t3];
                if ($sp3) {
                    $turns[] = [
                        'speaker' => $sp3['name'],
                        'role' => $sp3['role'],
                        'text' => "أَهْلًا بِكُمْ دَائِمًا، وَنَحْنُ فِي خِدْمَتِكُمْ فِي أَيِّ وَقْتٍ.",
                        'trans' => "Ahlan bikum da'iman, wa nahnu fi khidmatikum fi ayyi waqt.",
                        'meaning' => "Selamat datang selalu, dan kami siap membantu Anda kapan saja.",
                        'audio' => "أَهْلًا بِكُمْ دَائِمًا فِي أَيِّ وَقْتٍ.",
                    ];
                }
                break;

            case 'ja':
                $t1 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "すみません、{$topic}について教えていただけますか？",
                    'trans' => "Sumimasen, {$topic} ni tsuite oshiete itadakemasu ka?",
                    'meaning' => "Permisi, bisakah Anda memberi tahu saya tentang {$topic}?",
                    'audio' => "すみません、少し教えていただけますか？",
                ];
                $t2 = [
                    'speaker' => $sp2['name'],
                    'role' => $sp2['role'],
                    'text' => "はい、喜んで！こちらがご案内になりますよ。",
                    'trans' => "Hai, yorokonde! Kochira ga goannai ni narimasu yo.",
                    'meaning' => "Ya, dengan senang hati! Berikut ini adalah petunjuknya.",
                    'audio' => "はい、喜んで！どうぞこちらへ。",
                ];
                $t3 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "分かりやすくて助かりました。どうもありがとうございます！",
                    'trans' => "Wakari yasukute tasakarimashita. Doumo arigatou gozaimasu!",
                    'meaning' => "Sangat mudah dipahami dan membantu sekali. Terima kasih banyak!",
                    'audio' => "どうもありがとうございます！",
                ];
                $turns = [$t1, $t2, $t3];
                if ($sp3) {
                    $turns[] = [
                        'speaker' => $sp3['name'],
                        'role' => $sp3['role'],
                        'text' => "素晴らしいですね。また何かあればいつでもお声がけください。",
                        'trans' => "Subarashii desu ne. Mata nanika areba itsudemo okoegake kudasai.",
                        'meaning' => "Bagus sekali ya. Jika ada hal lain lagi silakan beri tahu kami kapan saja.",
                        'audio' => "いつでもお声がけくださいね。",
                    ];
                }
                break;

            case 'ko':
                $t1 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "실례합니다, 혹시 {$topic} 도와주실 수 있나요?",
                    'trans' => "Sillyehamnida, hoksi {$topic} dowajusil su innayo?",
                    'meaning' => "Permisi, apakah Anda bisa membantu saya mengenai {$topic}?",
                    'audio' => "실례합니다, 혹시 좀 도와주실 수 있나요?",
                ];
                $t2 = [
                    'speaker' => $sp2['name'],
                    'role' => $sp2['role'],
                    'text' => "네, 물론입니다! 여기에 자세히 설명되어 있습니다.",
                    'trans' => "Ne, mollonimnida! Yeogie jasehi seolmyeongdoeeo itseumnida.",
                    'meaning' => "Ya, tentu saja! Di sini sudah dijelaskan secara lengkap.",
                    'audio' => "네, 물론입니다! 여기에 있습니다.",
                ];
                $t3 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "친절하게 알려주셔서 정말 감사합니다!",
                    'trans' => "Chinjeolhage allyeojusyeoseo jeongmal gamsahamnida!",
                    'meaning' => "Terima kasih banyak telah memberi tahu dengan sangat ramah!",
                    'audio' => "정말 대단히 감사합니다!",
                ];
                $turns = [$t1, $t2, $t3];
                if ($sp3) {
                    $turns[] = [
                        'speaker' => $sp3['name'],
                        'role' => $sp3['role'],
                        'text' => "좋은 시간 보내세요! 언제든 다시 물어보세요.",
                        'trans' => "Joeun sigan bonaeseyo! Eonjedeun dasi mureoboseyo.",
                        'meaning' => "Semoga hari Anda menyenangkan! Kapan pun silakan bertanya lagi.",
                        'audio' => "좋은 시간 보내시고 언제든 물어보세요.",
                    ];
                }
                break;

            case 'zh':
                $t1 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "请问，关于{$topic}，你能帮我一下吗？",
                    'trans' => "Qǐngwèn, guānyú {$topic}, nǐ néng bāng wǒ yīxià ma?",
                    'meaning' => "Permisi, mengenai {$topic}, bisakah Anda membantu saya sebentar?",
                    'audio' => "请问，你能帮我一下吗？",
                ];
                $t2 = [
                    'speaker' => $sp2['name'],
                    'role' => $sp2['role'],
                    'text' => "当然可以！请看这里，非常方便实用。",
                    'trans' => "Dāngrán kěyǐ! Qǐng kàn zhèlǐ, fēicháng fāngbiàn shíyòng.",
                    'meaning' => "Tentu saja bisa! Silakan lihat di sini, sangat mudah dan praktis.",
                    'audio' => "当然可以！请看这里。",
                ];
                $t3 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "太感谢你了，解决了我的大问题！",
                    'trans' => "Tài gǎnxiè nǐ le, jiějué le wǒ de dà wèntí!",
                    'meaning' => "Sangat berterima kasih kepada Anda, masalah saya terselesaikan!",
                    'audio' => "太感谢你了，非常实用！",
                ];
                $turns = [$t1, $t2, $t3];
                if ($sp3) {
                    $turns[] = [
                        'speaker' => $sp3['name'],
                        'role' => $sp3['role'],
                        'text' => "不客气，祝你一切顺利，有需要随时来找我们！",
                        'trans' => "Bù kèqì, zhù nǐ yīqiè shùnlì, yǒu xūyào suíshí lái zhǎo wǒmen!",
                        'meaning' => "Sama-sama, semoga segalanya lancar, bila butuh bantuan datanglah kapan saja!",
                        'audio' => "不客气，祝你一切顺利！",
                    ];
                }
                break;

            default: // English
                $t1 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "Excuse me, could you please guide me regarding {$topic}?",
                    'trans' => "/ɪkˈskjuːz miː, kʊd juː pliːz ɡaɪd miː rɪˈɡɑːrdɪŋ {$topic}/",
                    'meaning' => "Permisi, bisakah Anda memandu saya mengenai {$topic}?",
                    'audio' => "Excuse me, could you please guide me here?",
                ];
                $t2 = [
                    'speaker' => $sp2['name'],
                    'role' => $sp2['role'],
                    'text' => "Certainly, with great pleasure! Here is everything you need to know.",
                    'trans' => "/ˈsɜːrtnli, wɪð ɡreɪt ˈpleʒər! hɪər ɪz ˈevriθɪŋ juː niːd tuː noʊ/",
                    'meaning' => "Tentu saja, dengan senang hati! Inilah semua yang perlu Anda ketahui.",
                    'audio' => "Certainly, with great pleasure! Here you go.",
                ];
                $t3 = [
                    'speaker' => $sp1['name'],
                    'role' => $sp1['role'],
                    'text' => "Thank you so much! That explains everything clearly.",
                    'trans' => "/θæŋk juː soʊ mʌtʃ! ðæt ɪkˈspleɪnz ˈevriθɪŋ ˈklɪrli/",
                    'meaning' => "Terima kasih banyak! Itu menjelaskan segalanya dengan sangat jelas.",
                    'audio' => "Thank you so much for your kind help!",
                ];
                $turns = [$t1, $t2, $t3];
                if ($sp3) {
                    $turns[] = [
                        'speaker' => $sp3['name'],
                        'role' => $sp3['role'],
                        'text' => "You are most welcome! Feel free to reach out anytime.",
                        'trans' => "/juː ɑːr moʊst ˈwelkəm! fiːl friː tuː riːtʃ aʊt ˈenitaɪm/",
                        'meaning' => "Sama-sama! Jangan ragu menghubungi kami kapan saja.",
                        'audio' => "You are most welcome anytime!",
                    ];
                }
                break;
        }

        // Tambahkan bedah suku kata otomatis
        foreach ($turns as &$turn) {
            if ($scenarioNum <= 10) {
                $trans = LinguisticBreakdownService::getSentenceTransliteration($langCode, $turn['text'], $turn['trans']);
                $turn['trans'] = $trans;
                $turn['breakdown'] = LinguisticBreakdownService::getBreakdown($langCode, $turn['text'], $trans, $turn['meaning']);
            } else {
                $turn['breakdown'] = [];
            }
        }

        return $turns;
    }
}
