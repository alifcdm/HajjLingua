<?php

namespace App\Services;

class HajjModuleService
{
    /**
     * Data Lengkap Modul Pembelajaran Ibadah Haji Terpadu
     * Berdasarkan Al-Qur'an, Hadits Shahih, Fiqih 4 Mazhab, Regulasi Ditjen Pelayanan Haji Kemenhaj RI,
     * Serta Dokumen RPH 1448 H / 2027 M (Keputusan Dirjen No. 26 Tahun 2026) dan Slide Bimtek Pelatihan PPIH 1448 H / 2027 M.
     */
    public static function getModuleData(): array
    {
        return [
            'overview' => self::getOverviewData(),
            'timeline' => self::getTimelineData(),
            'rph_timeline' => self::getRphTimelineData(),
            'ppih_bimtek' => self::getPpihBimtekData(),
            'fiqh' => self::getFiqhData(),
            'officer_fiqh' => self::getOfficerFiqhData(),
            'prayers' => self::getPrayersData(),
            'regulations' => self::getRegulationsData(),
            'videos' => self::getVideoData(),
            'quiz' => self::getQuizData(),
        ];
    }

    private static function getOverviewData(): array
    {
        return [
            'title' => 'Modul Panduan & Manasik Ibadah Haji Terpadu',
            'subtitle' => 'Panduan Komprehensif Berdasarkan Al-Qur\'an, Sunnah Shahihah, Fiqih 4 Mazhab, Regulasi Ditjen Pelayanan Haji Kemenhaj RI, RPH 1448 H / 2027 M & Pelatihan PPIH',
            'dalil_quran' => [
                'surah' => 'QS. Ali \'Imran : 97',
                'arabic' => 'وَلِلَّهِ عَلَى النَّاسِ حِجُّ الْبَيْتِ مَنِ اسْتَطَاعَ إِلَيْهِ سَبِيلًا',
                'trans' => 'Wa lillāhi ‘alan-nāsi ḥijjul-baiti manistaṭā‘a ilaihi sabīlā',
                'meaning' => 'Dan (di antara) kewajiban manusia terhadap Allah adalah melaksanakan ibadah haji ke Baitullah, yaitu bagi orang-orang yang mampu mengadakan perjalanan ke sana.'
            ],
            'hadits' => [
                'rawi' => 'HR. Bukhari no. 1773 & Muslim no. 1349',
                'arabic' => 'وَالْحَجُّ الْمَبْرُورُ لَيْسَ لَهُ جَزَاءٌ إِلَّا الْجَنَّةُ',
                'trans' => 'Wal-ḥajjul-mabrūru laisa lahū jazā\'un illal-jannah',
                'meaning' => 'Dan haji yang mabrur tidak ada balasan baginya melainkan surga.'
            ],
            'pillars_summary' => [
                ['name' => '6 Rukun Haji', 'desc' => 'Wajib dikerjakan, tidak sah haji jika tertinggal, tidak bisa diganti Dam.'],
                ['name' => '6 Wajib Haji', 'desc' => 'Wajib dikerjakan, jika tertinggal haji tetap sah namun wajib bayar Dam.'],
                ['name' => '24 Agenda RPH 1448H', 'desc' => 'Kalender resmi Keputusan Dirjen Pelayanan Haji No. 26/2026 (10 April – 20 Juni 2027).'],
                ['name' => 'Bimtek PPIH 1448H', 'desc' => 'Materi pelatihan manasik petugas: Ihram, Thawaf, Sa\'i, Tahallul, & Layanan Jemaah.'],
            ]
        ];
    }

    private static function getTimelineData(): array
    {
        return [
            [
                'day' => 'Hari 1',
                'date' => '8 Dzulhijjah (Hari Tarwiyah)',
                'location' => 'Makkah / Miqat menuju Mina',
                'title' => 'Ihram dari Miqat & Menuju Mina',
                'badge' => 'Sunnah Muakkadah',
                'description' => 'Jemaah membersihkan diri (mandi sunnah), mengenakan pakaian ihram, berniat haji di hotel/tempat tinggal di Makkah (bagi haji Tamattu\'), lalu berangkat menuju Mina sebelum waktu Zhuhur. Bermalam (mabit) di Mina hingga shalat Subuh 9 Dzulhijjah.',
                'activities' => [
                    'Mandi sunnah ihram, memotong kuku, merapikan kumis, memakai wewangian di badan sebelum ihram.',
                    'Mengenakan 2 lembar kain ihram putih tanpa jahitan bagi pria; pakaian menutup aurat tanpa cadar dan sarung tangan bagi wanita.',
                    'Mengucapkan niat haji: "Labbaikallāhumma ḥajjan".',
                    'Melantunkan kalimat Talbiyah terus-menerus selama perjalanan.',
                    'Shalat Zhuhur, Ashar, Maghrib, Isya, dan Subuh di Mina secara Qashar tanpa Jamak.',
                ],
                'doa' => 'لَبَّيْكَ اللَّهُمَّ حَجًّا (Labbaikallāhumma ḥajjan)',
                'doa_meaning' => 'Aku penuhi panggilan-Mu ya Allah untuk berhaji.'
            ],
            [
                'day' => 'Hari 2',
                'date' => '9 Dzulhijjah (Hari Arafah)',
                'location' => 'Padang Arafah',
                'title' => 'Wukuf di Arafah (Inti & Puncak Haji)',
                'badge' => 'RUKUN HAJI (Wajib Mutlak)',
                'description' => 'Setelah matahari terbit 9 Dzulhijjah, jemaah bergerak dari Mina menuju Padang Arafah. Puncak haji dimulai sejak tergelincir matahari (waktu Zhuhur) hingga terbenam matahari. Rasulullah SAW bersabda: "Al-Hajju \'Arafah" (Haji itu adalah wukuf di Arafah).',
                'activities' => [
                    'Mendengarkan Khutbah Wukuf di tenda Arafah atau Masjid Namirah.',
                    'Melaksanakan shalat Zhuhur dan Ashar secara Jamak Taqdim dan Qashar (masing-masing 2 rakaat dengan satu adzan dua iqamah).',
                    'Berdiam diri, bermunajat, memperbanyak istighfar, zikir, membaca Al-Qur\'an, dan berdoa menghadap kiblat.',
                    'Memperbanyak membaca doa terbaik: "Lā ilāha illallāhu waḥdahū lā syarīka lah...".',
                    'Bertahan di Arafah sampai matahari benar-benar terbenam.',
                ],
                'doa' => 'لَا إِلَهَ إِلَّا اللَّهُ وَحْدَهُ لَا شَرِيكَ لَهُ، لَهُ الْمُلْكُ وَلَهُ الْحَمْدُ وَهُوَ عَلَى كُلِّ شَيْءٍ قَدِيرٌ',
                'doa_meaning' => 'Tiada Tuhan selain Allah Yang Maha Esa, tiada sekutu bagi-Nya. Bagi-Nya kerajaan dan segala pujian, dan Dia Maha Kuasa atas segala sesuatu.'
            ],
            [
                'day' => 'Malam 3',
                'date' => 'Malam 10 Dzulhijjah',
                'location' => 'Muzdalifah',
                'title' => 'Mabit di Muzdalifah & Mengambil Kerikil',
                'badge' => 'WAJIB HAJI',
                'description' => 'Setelah matahari terbenam di Arafah, jemaah bergerak menuju Muzdalifah dengan tenang tanpa tergesa-gesa. Di Muzdalifah, jemaah shalat Maghrib dan Isya, mabit minimal melewati tengah malam, dan mengambil kerikil untuk melontar jumrah.',
                'activities' => [
                    'Shalat Maghrib (3 rakaat) dan Isya (2 rakaat di-Qashar) secara Jamak Ta\'khir begitu tiba di Muzdalifah.',
                    'Mabit (bermalam) di alam terbuka Muzdalifah hingga melewati tengah malam (atau hingga waktu Subuh bagi yang mampu).',
                    'Mengambil batu kerikil sebesar biji kacang (kacang arab) sebanyak 7 butir untuk Jumrah Aqabah, atau 49-70 butir untuk hari tasyrik.',
                    'Bagi lansia, risti (risiko tinggi), dan wanita diperbolehkan melakukan murur (melintas di Muzdalifah di dalam bus) sesuai regulasi Kementerian Haji dan Umrah RI demi kemaslahatan jiwa.',
                ],
                'doa' => 'رَبَّنَا آتِنَا فِي الدُّنْيَا حَسَنَةً وَفِي الآخِرَةِ حَسَنَةً وَقِنَا عَذَابَ النَّارِ',
                'doa_meaning' => 'Ya Tuhan kami, berilah kami kebaikan di dunia dan kebaikan di akhirat, dan lindungilah kami dari siksa api neraka.'
            ],
            [
                'day' => 'Hari 3',
                'date' => '10 Dzulhijjah (Hari Nahr / Idul Adha)',
                'location' => 'Mina & Makkah (Masjidil Haram)',
                'title' => 'Melontar Jumrah Aqabah, Tahallul Awwal & Tawaf Ifadhah',
                'badge' => 'RUKUN & WAJIB HAJI',
                'description' => 'Hari tersibuk dalam haji. Jemaah melontar Jumrah Aqabah dengan 7 kerikil, menyembelih hewan dam (bagi haji Tamattu\'), bercukur (Tahallul Awwal), lalu berangkat ke Masjidil Haram untuk Tawaf Ifadhah dan Sa\'i (Tahallul Tsani).',
                'activities' => [
                    'Melontar Jumrah Aqabah 7 kali lemparan, membaca takbir "Allāhu Akbar" pada setiap lemparan.',
                    'Membayar / menyembelih hewan Dam Tamattu\' melalui perbankan resmi Al-Adahi atau BPIH yang ditunjuk kementerian.',
                    'Tahallul Awwal: Mencukur gundul (halq - lebih afdhal) atau memendekkan rambut (taqshir) minimal 3 helai bagi pria; memotong sepanjang ujung jari bagi wanita.',
                    'Setelah Tahallul Awwal, seluruh larangan ihram gugur KECUALI hubungan suami-istri.',
                    'Meluncur ke Makkah untuk Tawaf Ifadhah 7 putaran dan Sa\'i 7 putaran Shafa-Marwah (Tahallul Tsani / Kubra - seluruh larangan halal kembali).',
                ],
                'doa' => 'بِسْمِ اللَّهِ، اللَّهُ أَكْبَرُ، رَجْمًا لِلشَّيْطَانِ وَرِضًا لِلرَّحْمَنِ',
                'doa_meaning' => 'Dengan nama Allah, Allah Maha Besar, kutukan bagi setan dan mencari keridhaan Dzat Yang Maha Pengasih.'
            ],
            [
                'day' => 'Hari 4-5',
                'date' => '11 & 12 Dzulhijjah (Hari Tasyrik & Nafar Awwal)',
                'location' => 'Mina (Jamarat)',
                'title' => 'Mabit di Mina & Melontar 3 Jumrah (Ula, Wustha, Aqabah)',
                'badge' => 'WAJIB HAJI',
                'description' => 'Bermalam di Mina pada malam 11 dan 12 Dzulhijjah. Setiap hari setelah matahari tergelincir (masuk Zhuhur), jemaah melontar 3 jumrah secara berurutan: Jumrah Ula (Sughra), Wustha, dan Aqabah (Kubra), masing-masing 7 kerikil.',
                'activities' => [
                    'Mabit di tenda Mina pada sebagian besar malam (lebih dari separuh malam).',
                    'Melontar Jumrah Ula (7 butir) -> Berhenti menghadap kiblat dan berdoa panjang.',
                    'Melontar Jumrah Wustha (7 butir) -> Berhenti menghadap kiblat dan berdoa panjang.',
                    'Melontar Jumrah Aqabah (7 butir) -> Langsung berlalu tanpa berhenti berdoa.',
                    'Nafar Awwal: Jemaah yang ingin menyelesaikan mabit lebih cepat dapat keluar dari Mina sebelum matahari terbenam pada 12 Dzulhijjah.',
                ],
                'doa' => 'اللَّهُمَّ اجْعَلْهُ حَجًّا مَبْرُورًا وَذَنْبًا مَغْفُورًا وَسَعْيًا مَشْكُورًا',
                'doa_meaning' => 'Ya Allah, jadikanlah hajiku ini haji yang mabrur, dosa yang diampuni, dan usaha yang disyukuri.'
            ],
            [
                'day' => 'Hari 6',
                'date' => '13 Dzulhijjah (Nafar Tsani) & Tawaf Wada\'',
                'location' => 'Mina & Makkah (Masjidil Haram)',
                'title' => 'Nafar Tsani & Tawaf Perpisahan (Tawaf Wada\')',
                'badge' => 'WAJIB HAJI (Penutup)',
                'description' => 'Bagi jemaah yang mengambil Nafar Tsani (bertahan hingga 13 Dzulhijjah), melontar kembali ketiga jumrah setelah zhuhur. Sebelum meninggalkan kota Makkah kembali ke tanah air atau ke Madinah, seluruh jemaah wajib melaksanakan Tawaf Wada\' (kecuali wanita haid/nifas).',
                'activities' => [
                    'Menyelesaikan lontar 3 jumrah pada hari ke-13 Dzulhijjah (total 70 kerikil untuk Nafar Tsani, atau 49 kerikil untuk Nafar Awwal).',
                    'Kembali ke hotel pemondokan di Makkah dan mengepak barang bawaan.',
                    'Melakukan Tawaf Wada\' (7 putaran mengelilingi Ka\'bah tanpa sa\'i) sesaat sebelum naik bus menuju bandara/Madinah.',
                    'Bagi wanita yang berhalangan syar\'i (haid atau nifas), gugur kewajiban Tawaf Wada\' dan tidak dikenakan denda Dam apapun sesuai sunnah Nabi SAW.',
                ],
                'doa' => 'اللَّهُمَّ لَا تَجْعَلْ هَذَا آخِرَ الْعَهْدِ بِبَيْتِكَ الْحَرَامِ',
                'doa_meaning' => 'Ya Allah, janganlah Engkau jadikan kunjungan ini sebagai saat terakhir bagiku dengan Baitullah yang mulia.'
            ],
        ];
    }

    /**
     * Rencana Perjalanan Haji (RPH) Tahun 1448 H / 2027 M
     * Sumber Asli Dokumen: Keputusan Direktur Jenderal Pelayanan Haji Nomor 26 Tahun 2026, Kementerian Haji dan Umrah RI
     */
    public static function getRphTimelineData(): array
    {
        return [
            'document_title' => 'Rencana Perjalanan Haji (RPH) Tahun 1448 Hijriah / 2027 Masehi',
            'legal_reference' => 'Keputusan Direktur Jenderal Pelayanan Haji Nomor 26 Tahun 2026, Ditjen Pelayanan Haji Kementerian Haji dan Umrah Republik Indonesia (Ditetapkan 29 September 2026)',
            'signatory' => 'Ian Heriyawan (Direktur Jenderal Pelayanan Haji)',
            'drive_source_url' => 'https://drive.google.com/file/d/1QOF0RUCqNcrucc6ph_ShjTCJRMA3BI_6/view?usp=sharing',
            'operational_summary' => [
                'masa_pemberangkatan' => '30 Hari (Gel I: 15 Hari Tanah Air ke Madinah, Gel II: 15 Hari Tanah Air ke Jeddah)',
                'masa_pemulangan' => '30 Hari (Gel I: 15 Hari Jeddah ke Tanah Air, Gel II: 15 Hari Madinah ke Tanah Air)',
                'masa_tinggal' => '38 s.d. 40 Hari Rata-Rata Tinggal Jemaah Haji di Arab Saudi',
                'closing_date' => '10 Mei 2027 (04 Dzulhijjah 1448 H) Pukul 24.00 WSA di Bandara KAIA Jeddah',
                'hari_arafah' => '15 Mei 2027 (09 Dzulhijjah 1448 H) Wukuf di Padang Arafah',
                'idul_adha' => '16 Mei 2027 (10 Dzulhijjah 1448 H) Hari Nahr / Idul Adha 1448 H',
            ],
            // 24 butir kalender kegiatan lengkap dari lampiran resmi dokumen
            'events' => [
                [
                    'no' => 1,
                    'miladiyah' => '10 April 2027',
                    'hijriah' => '03 Dzulqa\'idah 1448',
                    'activity' => 'Jemaah Haji mulai masuk asrama haji',
                    'phase' => 'Persiapan Tanah Air',
                    'badge' => 'Embarkasi'
                ],
                [
                    'no' => 2,
                    'miladiyah' => '11 April 2027',
                    'hijriah' => '04 Dzulqa\'idah 1448',
                    'activity' => 'Awal pemberangkatan Jemaah Haji Gelombang I dari Tanah Air ke Madinah',
                    'phase' => 'Keberangkatan Gel. I',
                    'badge' => 'Tanah Air -> Madinah'
                ],
                [
                    'no' => 3,
                    'miladiyah' => '19 April 2027',
                    'hijriah' => '12 Dzulqa\'idah 1448',
                    'activity' => 'Awal pemberangkatan Jemaah Haji Gelombang I dari Madinah ke Makkah',
                    'phase' => 'Pergeseran Gel. I',
                    'badge' => 'Madinah -> Makkah (Miqat Bir Ali)'
                ],
                [
                    'no' => 4,
                    'miladiyah' => '25 April 2027',
                    'hijriah' => '18 Dzulqa\'idah 1448',
                    'activity' => 'Akhir pemberangkatan Jemaah Haji Gelombang I dari Tanah Air ke Madinah',
                    'phase' => 'Keberangkatan Gel. I',
                    'badge' => 'Penutupan Gel. I Madinah'
                ],
                [
                    'no' => 5,
                    'miladiyah' => '26 April 2027',
                    'hijriah' => '19 Dzulqa\'idah 1448',
                    'activity' => 'Awal pemberangkatan Jemaah Haji Gelombang II dari Tanah Air ke Jeddah',
                    'phase' => 'Keberangkatan Gel. II',
                    'badge' => 'Tanah Air -> Jeddah'
                ],
                [
                    'no' => 6,
                    'miladiyah' => '03 Mei 2027',
                    'hijriah' => '26 Dzulqa\'idah 1448',
                    'activity' => 'Akhir pemberangkatan Jemaah Haji Gelombang I dari Madinah ke Makkah',
                    'phase' => 'Pergeseran Gel. I',
                    'badge' => 'Tuntas Arbain Gel. I'
                ],
                [
                    'no' => 7,
                    'miladiyah' => '10 Mei 2027',
                    'hijriah' => '04 Dzulhijjah 1448',
                    'activity' => 'Akhir pemberangkatan Jemaah Haji Gelombang II dari Tanah Air ke Jeddah',
                    'phase' => 'Keberangkatan Gel. II',
                    'badge' => 'Akhir Terbang Gel. II'
                ],
                [
                    'no' => 8,
                    'miladiyah' => '10 Mei 2027',
                    'hijriah' => '04 Dzulhijjah 1448',
                    'activity' => 'Closing Date di King Abdul Aziz International Airport Jeddah (Pukul 24.00 Waktu Arab Saudi)',
                    'phase' => 'Batas Akhir Masuk',
                    'badge' => 'Closing Date KAIA'
                ],
                [
                    'no' => 9,
                    'miladiyah' => '14 Mei 2027',
                    'hijriah' => '08 Dzulhijjah 1448',
                    'activity' => 'Pemberangkatan Jemaah Haji dari Makkah ke Arafah (Hari Tarwiyah)',
                    'phase' => 'Puncak Masyair Armuzna',
                    'badge' => 'Makkah -> Arafah'
                ],
                [
                    'no' => 10,
                    'miladiyah' => '15 Mei 2027',
                    'hijriah' => '09 Dzulhijjah 1448',
                    'activity' => 'Wukuf di Padang Arafah (Puncak Ibadah Haji Akbar)',
                    'phase' => 'Puncak Masyair Armuzna',
                    'badge' => 'Rukun Haji Akbar'
                ],
                [
                    'no' => 11,
                    'miladiyah' => '16 Mei 2027',
                    'hijriah' => '10 Dzulhijjah 1448',
                    'activity' => 'Idhul Adha 1448 Hijriah (Mabit Muzdalifah, Lontar Jumrah Aqabah & Tahallul Awwal)',
                    'phase' => 'Puncak Masyair Armuzna',
                    'badge' => 'Hari Nahr / Idul Adha'
                ],
                [
                    'no' => 12,
                    'miladiyah' => '17 Mei 2027',
                    'hijriah' => '11 Dzulhijjah 1448',
                    'activity' => 'Hari Tasyrik I (Mabit di Mina & Melontar Jumrah Ula, Wustha, Aqabah)',
                    'phase' => 'Puncak Masyair Armuzna',
                    'badge' => 'Tasyrik I'
                ],
                [
                    'no' => 13,
                    'miladiyah' => '18 Mei 2027',
                    'hijriah' => '12 Dzulhijjah 1448',
                    'activity' => 'Hari Tasyrik II (Nafar Awal - Mabit Mina & Lontar 3 Jumrah)',
                    'phase' => 'Puncak Masyair Armuzna',
                    'badge' => 'Nafar Awal'
                ],
                [
                    'no' => 14,
                    'miladiyah' => '19 Mei 2027',
                    'hijriah' => '13 Dzulhijjah 1448',
                    'activity' => 'Hari Tasyrik III (Nafar Tsani - Penyelesaian Lontar 3 Jumrah di Mina)',
                    'phase' => 'Puncak Masyair Armuzna',
                    'badge' => 'Nafar Tsani'
                ],
                [
                    'no' => 15,
                    'miladiyah' => '21 Mei 2027',
                    'hijriah' => '15 Dzulhijjah 1448',
                    'activity' => 'Awal Pemulangan Jemaah Haji Gelombang I dari Makkah melalui Bandara King Abdul Aziz International Airport Jeddah ke Tanah Air',
                    'phase' => 'Pemulangan Gel. I',
                    'badge' => 'Jeddah -> Tanah Air'
                ],
                [
                    'no' => 16,
                    'miladiyah' => '21 Mei 2027',
                    'hijriah' => '15 Dzulhijjah 1448',
                    'activity' => 'Awal Kedatangan Jemaah Haji Gelombang I di Tanah Air (Debarkasi)',
                    'phase' => 'Pemulangan Gel. I',
                    'badge' => 'Tiba di Tanah Air'
                ],
                [
                    'no' => 17,
                    'miladiyah' => '27 Mei 2027',
                    'hijriah' => '21 Dzulhijjah 1448',
                    'activity' => 'Awal Pemberangkatan Jemaah Haji Gelombang II dari Makkah ke Madinah (Menuju Shalat Arbain)',
                    'phase' => 'Pergeseran Gel. II',
                    'badge' => 'Makkah -> Madinah'
                ],
                [
                    'no' => 18,
                    'miladiyah' => '04 Juni 2027',
                    'hijriah' => '29 Dzulhijjah 1448',
                    'activity' => 'Akhir Pemulangan Jemaah Haji Gelombang I dari Jeddah ke Tanah Air',
                    'phase' => 'Pemulangan Gel. I',
                    'badge' => 'Akhir Pulang Gel. I'
                ],
                [
                    'no' => 19,
                    'miladiyah' => '05 Juni 2027',
                    'hijriah' => '30 Dzulhijjah 1448',
                    'activity' => 'Awal Pemulangan Jemaah Haji Gelombang II dari Madinah melalui Bandara Pangeran Mohammad bin Abdul Aziz Madinah ke Tanah Air',
                    'phase' => 'Pemulangan Gel. II',
                    'badge' => 'Madinah -> Tanah Air'
                ],
                [
                    'no' => 20,
                    'miladiyah' => '05 Juni 2027',
                    'hijriah' => '30 Dzulhijjah 1448',
                    'activity' => 'Awal Kedatangan Jemaah Haji Gelombang II di Tanah Air',
                    'phase' => 'Pemulangan Gel. II',
                    'badge' => 'Kedatangan Gel. II'
                ],
                [
                    'no' => 21,
                    'miladiyah' => '06 Juni 2027',
                    'hijriah' => '01 Muharram 1449',
                    'activity' => 'Tahun Baru Hijriyah 1449 Hijriah',
                    'phase' => 'Momentum Bersejarah',
                    'badge' => '1 Muharram 1449 H'
                ],
                [
                    'no' => 22,
                    'miladiyah' => '11 Juni 2027',
                    'hijriah' => '06 Muharram 1449',
                    'activity' => 'Akhir Pemberangkatan Jemaah Haji Gelombang II dari Makkah ke Madinah',
                    'phase' => 'Pergeseran Gel. II',
                    'badge' => 'Akhir Makkah ke Madinah'
                ],
                [
                    'no' => 23,
                    'miladiyah' => '19 Juni 2027',
                    'hijriah' => '14 Muharram 1449',
                    'activity' => 'Akhir Pemulangan Jemaah Haji Gelombang II dari Madinah melalui Bandara Pangeran Mohammad bin Abdul Aziz Madinah ke Tanah Air',
                    'phase' => 'Pemulangan Gel. II',
                    'badge' => 'Akhir Terbang Madinah'
                ],
                [
                    'no' => 24,
                    'miladiyah' => '20 Juni 2027',
                    'hijriah' => '15 Muharram 1449',
                    'activity' => 'Akhir Kedatangan Jemaah Haji Gelombang II di Tanah Air (Operasional Haji 1448 H Tuntas Resmi)',
                    'phase' => 'Penutupan Operasional',
                    'badge' => 'Operasional Selesai'
                ],
            ]
        ];
    }

    /**
     * Bimtek & Manasik Haji Petugas PPIH 1448 H / 2027 M
     * Riset Lengkap dari Slide Presentasi Pelatihan Resmi Kemenhaj & Kemenag RI
     */
    public static function getPpihBimtekData(): array
    {
        return [
            'title' => 'Bimtek & Manasik Haji Petugas PPIH 1448 H / 2027 M',
            'subtitle' => 'Materi Pembekalan Resmi Manasik Petugas Penyelenggara Ibadah Haji Berdasarkan Regulasi Ditjen Pelayanan Haji Kemenhaj RI',
            'structure_types' => [
                [
                    'title' => 'PPIH Pusat',
                    'scope' => 'Kementerian Haji dan Umrah RI / Kementerian Agama RI',
                    'desc' => 'Bertanggung jawab atas kebijakan nasional, regulasi, alokasi kuota, pengawasan maskapai penerbangan, dan koordinasi tingkat kementerian dengan Pemerintah Kerajaan Arab Saudi.',
                    'badge' => 'Nasional / Jakarta'
                ],
                [
                    'title' => 'PPIH Embarkasi',
                    'scope' => 'Asrama Haji Seluruh Indonesia (Jakarta, Solo, Surabaya, Medan, Makassar, dll)',
                    'desc' => 'Melayani proses One Stop Service: pemeriksaan kesehatan tahap akhir, pembagian living cost (uang saku SAR), kartu identitas gelang anti-karat, dan dokumen paspor/visa.',
                    'badge' => '14 Embarkasi RI'
                ],
                [
                    'title' => 'PPIH Arab Saudi',
                    'scope' => 'Daker Bandara, Daker Madinah, Daker Makkah & Satgas Khusus Armuzna',
                    'desc' => 'Melaksanakan fungsi pelayanan akomodasi hotel, katering 3x sehari, transportasi bus Shalawat, bimbingan manasik, posko KKHI medis, dan perlindungan keamanan jemaah (Linjam).',
                    'badge' => 'Daker & Satgas'
                ],
                [
                    'title' => 'PPIH Kloter (Kelompok Terbang)',
                    'scope' => 'Mendampingi Langsung Jemaah dari Tanah Air hingga Pulang',
                    'desc' => 'Terdiri dari 5 personel inti per kloter: 1 Ketua Kloter (TPHI), 1 Pembimbing Ibadah (TPIHI), 1 Dokter (TKHI) dan 2 Perawat (TKHI) yang hidup bersama jemaah 24 jam.',
                    'badge' => 'Garis Terdepan Jemaah'
                ],
            ],
            'can_officer_hajj' => [
                'main_principle' => 'Tugas pokok PPIH adalah khidmat (pelayanan), serta pembinaan dan perlindungan kepada jemaah. Namun, PPIH kloter dan PPIH Arab Saudi dapat melaksanakan ibadah haji dengan tanpa mengganggu tugas pokok pelayanannya.',
                'rules' => [
                    [
                        'point' => 'Hanya Boleh Haji Tamattu\'',
                        'desc' => 'Seluruh petugas PPIH diwajibkan hanya mengambil jenis Haji Tamattu\' (mengerjakan Umrah terlebih dahulu, bertahallul bebas, lalu berihram haji pada 8 Dzulhijjah). Dilarang mengambil Ifrad atau Qiran agar leluasa bertugas memakai seragam dinas.'
                    ],
                    [
                        'point' => 'Tata Cara PPIH Kloter',
                        'desc' => 'Dilakukan bersama-sama dengan jemaah kloternya karena keberadaan dan posisinya wajib mendampingi serta melayani kebutuhan ibadah jemaah kloter sepanjang rute.'
                    ],
                    [
                        'point' => 'Tata Cara PPIH Arab Saudi',
                        'desc' => 'Memiliki kekhususan waktu dan shift pelaksanaan ibadah sesuai dengan perbedaan jenis layanan yang ditugaskan (pelayanan konsumsi, transportasi, atau medis rumah sakit).'
                    ]
                ]
            ],
            'sunnah_ihram' => [
                'practices' => [
                    'a. Mandi sunnah ihram, termasuk disunnahkan bagi wanita yang sedang haid, nifas, dan anak-anak.',
                    'b. Mencukur bulu ketiak, bulu kemaluan, merapikan kumis, memotong kuku, dan semua tindakan membersihkan badan.',
                    'c. Memakai pakaian ihram berwarna putih bersih bagi laki-laki (2 lembar kain tanpa jahitan).',
                    'd. Memakai wewangian di badan (bukan di kain pakaian ihram), baik di kepala, jenggot, ketiak, dan anggota badan lainnya sebelum berniat ihram.',
                    'e. Salat sunat ihram dua rakaat (rakaat pertama membaca Al-Kafirun, rakaat kedua Al-Ikhlas).'
                ],
                'locations' => [
                    [
                        'group' => 'PPIH Kloter Gelombang I',
                        'location' => 'Hotel Pemondokan di Madinah',
                        'timing' => 'Sebelum berangkat menuju Makkah al-Mukarramah'
                    ],
                    [
                        'group' => 'PPIH Kloter Gelombang II',
                        'location' => 'Asrama Haji Embarkasi di Tanah Air',
                        'timing' => 'Sebelum naik ke dalam pesawat terbang'
                    ],
                    [
                        'group' => 'PPIH Arab Saudi',
                        'location' => 'Ruang Transit Bandara KAIA Jeddah',
                        'timing' => 'Sesaat setelah tiba dan menyelesaikan pos imigrasi Bandara'
                    ]
                ]
            ],
            'niat_miqat' => [
                'doa_ihram' => [
                    'arabic_1' => 'لَبَّيْكَ اللَّهُمَّ عُمْرَةً',
                    'latin_1' => 'Labbaikallāhumma ‘umratan',
                    'meaning_1' => 'Aku sambut panggilan-Mu ya Allah untuk berumrah.',
                    'arabic_2' => 'نَوَيْتُ الْعُمْرَةَ وَأَحْرَمْتُ بِهَا لِلَّهِ تَعَالَى',
                    'latin_2' => 'Nawaitul-‘umrata wa aḥramtu bihā lillāhi ta‘ālā',
                    'meaning_2' => 'Aku berniat umrah dengan berihram karena Allah Ta\'ala.'
                ],
                'miqat_rules' => [
                    [
                        'group' => 'PPIH Kloter Gelombang I',
                        'location' => 'Masjid Dzulhulaifah / Bir Ali (Madinah)',
                        'notes' => 'Niat ihram dilaksanakan setelah salat sunah ihram atau di atas bus sebelum bergerak meninggalkan titik miqat.'
                    ],
                    [
                        'group' => 'PPIH Kloter Gelombang II',
                        'location' => 'Asrama Haji Embarkasi, di Pesawat sebelum Yalamlam, atau Bandara KAA Jeddah',
                        'notes' => 'Di pesawat sebelum melewati garis batas miqat Yalamlam (diumumkan oleh pilot/awak kabin).'
                    ],
                    [
                        'group' => 'PPIH Arab Saudi',
                        'location' => 'Bandara King Abdul Aziz (KAA) Jeddah',
                        'notes' => 'Niat ihram dilakukan setelah salat sunah atau di atas bus sebelum bergerak menuju Makkah.'
                    ]
                ],
                'special_notes' => 'Niat ihram dilakukan oleh semua petugas PPIH termasuk wanita yang sedang haidh (kecuali PPIH Daker Madinah dan Bandara, karena harus segera meninggalkan Makkah menuju Madinah/Bandara untuk melaksanakan tugas dinas). Setelah berniat ihram, seluruh ketentuan larangan ihram berlaku mutlak.'
            ],
            'larangan_ihram' => [
                'laki_laki' => [
                    'Memakai pakaian bertangkup / berjahit yang membentuk lekuk tubuh (celana, kemeja, kaus, pakaian dalam).',
                    'Memakai kaos kaki atau sepatu yang menutupi mata kaki dan tumit.',
                    'Menutup kepala dengan penutup yang melekat seperti topi, peci, helm, atau sorban.'
                ],
                'perempuan' => [
                    'Menutup kedua telapak tangan dengan kaos tangan / sarung tangan.',
                    'Menutup muka dengan cadar, masker kain, atau penutup yang menempel langsung pada wajah.'
                ],
                'bersama' => [
                    'Memakai wangi-wangian (parfum) kecuali yang sudah dipakai di badan sebelum niat haji/umrah.',
                    'Memotong kuku dan mencukur atau mencabut rambut dan bulu badan.',
                    'Memburu dan menganiaya atau membunuh binatang dengan cara apa pun (kecuali binatang buas yang membahayakan).',
                    'Memakan daging hewan hasil buruan di Tanah Suci.',
                    'Memotong kayu-kayuan dan mencabut rumput/tanaman liar di Tanah Haram.',
                    'Menikah, menikahkan orang lain (menjadi wali), atau meminang perempuan untuk dinikahi.',
                    'Bersetubuh dan pendahuluannya seperti bercumbu, mencium, atau merayu yang mendatangkan syahwat.',
                    'Mencaci, bertengkar (jidal), atau mengucapkan kata-kata kotor.',
                    'Melakukan kejahatan dan maksiat (fusuq).',
                    'Memakai pakaian yang dicelup dengan bahan yang wangi.'
                ]
            ],
            'hal_diperbolehkan' => [
                'Membunuh binatang buas atau yang membahayakan (misalnya: kalajengking, tikus, ular, anjing buas, gagak, nyamuk, lalat).',
                'Mandi membersihkan badan (tanpa sabun beraroma tajam).',
                'Menyikat gigi dan berkumur.',
                'Berbekam untuk pengobatan.',
                'Memakai minyak angin, balsem, atau obat oles yang dimaksudkan untuk pengobatan.',
                'Menyembelih binatang ternak yang jinak dan binatang buruan laut.',
                'Memakai kacamata, jam tangan, cincin, dan sabuk ikat pinggang.',
                'Bernaung di bawah payung, mobil, tenda kemah, dan pohon rindang.',
                'Membuka tangan dan kaki bagi wanita ketika berwudhu di tempat wudhu khusus perempuan.',
                'Mencuci dan mengganti kain ihram dengan kain ihram cadangan yang bersih.',
                'Menggaruk kepala dan badan secara wajar tanpa merontokkan rambut dengan sengaja.',
                'Memakai perhiasan bagi wanita yang biasa dipakai.'
            ],
            'perjalanan_ke_makkah' => [
                'talbiyah_guidelines' => 'Selama perjalanan menuju ke Makkah, disunnahkan memperbanyak membaca talbiyah, dan berakhir sesaat sebelum melaksanakan tawaf.',
                'cara_bertalbiyah' => 'Talbiyah dibaca 3 (tiga) kali berturut-turut dengan khusyu\' dan tidak dijeda oleh aktivitas apa pun, selanjutnya membaca shalawat dan doa permohonan surga serta perlindungan neraka.',
                'doa_sapujagat' => 'رَبَّنَا آتِنَا فِي الدُّنْيَا حَسَنَةً وَفِي الآخِرَةِ حَسَنَةً وَقِنَا عَذَابَ النَّارِ'
            ],
            'masjidil_haram_prep' => [
                'timing' => 'PPIH kloter bersama jemaah berangkat menuju Masjidil Haram pada waktu Ba\'da Isya\' atau waktu Dhuha demi menghindari cuaca panas ekstrem.',
                'haidh_officer' => 'PPIH wanita yang sedang haidh dan sudah berniat ihram, menunggu di hotel hingga suci dengan tetap menjaga larangan-larangan ihram.',
                'gates' => [
                    ['num' => '1', 'name' => 'Bab King Abdul Aziz (Pintu Utama Sektor Selatan)'],
                    ['num' => '5', 'name' => 'Bab Ajyad (Arah Menuju Hotel Sektor Ajyad & Mispalah)'],
                    ['num' => '10', 'name' => 'Bab Isma\'il'],
                    ['num' => '11', 'name' => 'Bab As Safa (Akses Langsung Bukit Shafa)'],
                    ['num' => '19', 'name' => 'Bab Ali (Arah Terminal Bus Bab Ali & Mahbas Jin)'],
                    ['num' => '20', 'name' => 'Bab Al Abbas'],
                    ['num' => '24', 'name' => 'Bab As Salam (Pintu Sunnah Memasuki Masjid)'],
                    ['num' => '31', 'name' => 'Bab Al Marwah (Pintu Keluar Setelah Selesai Sa\'i)'],
                    ['num' => '45', 'name' => 'Bab Al Fath (Sektor Utara)'],
                    ['num' => '55', 'name' => 'Bab Al Quds'],
                    ['num' => '58', 'name' => 'Bab Al Hudaybiyah'],
                    ['num' => '62', 'name' => 'Bab Al Umrah (Arah Menuju Jarwal & Syib Amir)'],
                    ['num' => '79', 'name' => 'Bab King Fahd (Pintu Utama Sayap Barat)']
                ],
                'terminals' => [
                    ['name' => 'Terminal Syib Amir', 'direction' => 'Utara Masjidil Haram', 'notes' => 'Melayani rute bus Shalawat sektor Mahbas Jin, Raudhah, Syisyah, dan Jarwal.'],
                    ['name' => 'Terminal Bab Ali', 'direction' => 'Timur Masjidil Haram', 'notes' => 'Akses terowongan pejalan kaki (pedestrian tunnel) menuju Mahbas Jin & Aziziah.'],
                    ['name' => 'Terminal Ajyad / Kudai', 'direction' => 'Selatan Masjidil Haram', 'notes' => 'Akses jemaah sektor Mispalah, Bakhutmah, dan Kudai.'],
                ]
            ],
            'thawaf_details' => [
                'syarat_sah' => [
                    'Menutup aurat. Jika terbuka auratnya, maka putaran tawafnya batal. Batal tawaf wanita yang terbuka kakinya, atau kepalanya, bahkan ketika tampak sehelai rambutnya.',
                    'Dimulai dari Hajar Aswad. Jika dimulai selain itu, maka putarannya tidak dihitung.',
                    'Posisi Ka\'bah selalu berada di sebelah kiri badan jemaah.',
                    'Mengelilingi Ka\'bah 7 (tujuh) kali putaran secara yakin tanpa ragu.',
                    'Tawaf dilakukan di tempat tawaf resmi (Mathaf), baik di pelataran Ka\'bah maupun lantai bertingkat Masjidil Haram.',
                    'Suci dari hadats dan najis. (Catatan Fiqih Mazhab: Menurut Mazhab Hanafi, sah tawafnya orang yang berhadats kecil dengan dikenakan dam seekor kambing, dan bagi yang haidh atau junub dikenakan dam seekor unta atau sapi).'
                ],
                'tata_cara' => [
                    'Laki-laki disunnahkan berpakaian Idhtiba\': ujung kain ihram menutup bahu kiri, bagian tengah kain di bawah ketiak kanan, pundak yang terbuka menghadap ke arah luar dan pundak tertutup berhadapan dengan Ka\'bah.',
                    'Menghadap seluruh badan ke arah Ka\'bah seperti salat yang harus menghadap kiblat, atau jika tidak memungkinkan, cukup dengan sebagian badan yang menghadap ke arah Hajar Aswad.',
                    'Membaca doa ma\'tsur pada saat memulai tawaf, setelah istilam (menyentuh dengan tangan kanan) atau memberi isyarat dengan mengangkat tangan kanan ke arah Hajar Aswad seraya berucap "Bismillāhi Allāhu Akbar".',
                    'Memperpendek langkah kaki guna memperbanyak jumlah pahala langkah saat berthawaf.',
                    'Mencium Hajar Aswad jika memungkinkan tanpa menyakiti orang lain. Mazhab Hanbaliyah dan Hanafiyah mensunnahkan mencium di setiap akhir putaran; Imam Maliki dan Syafi\'i mensunnahkan di awal tawaf. Jika tidak mungkin, cukup memberi isyarat tangan dan mengecup tangan sebanyak 3 kali.',
                    'Berlari-lari kecil pada putaran 1, 2, dan 3, serta berjalan biasa pada putaran selanjutnya bagi laki-laki. Jika tidak memungkinkan lari karena padat, disunnahkan memberi isyarat gerakan seolah berlari kecil.',
                    'Laki-laki disunnahkan dekat dengan Ka\'bah jika tidak sesak. Wanita disunnahkan di pinggir tempat tawaf (mathaf) supaya lebih terjaga dari persentuhan dengan laki-laki.',
                    'Sunnah mengusap Rukun Yamani dengan tangan tanpa mencium (dan tidak dianjurkan melambaikan tangan jika tidak sampai).',
                    'Tawaf dilaksanakan secara berturut-turut (muwalat). Jika tawaf terhenti karena salat berjamaah atau batal wudhu, boleh melanjutkan dari tempat terputus, namun lebih utama jika isti\'naf (mengulang putaran dari Hajar Aswad).',
                    'Berdoa antara Rukun Yamani dan Hajar Aswad membaca Doa Sapu Jagat (Rabbanā ātinā fid-dunyā ḥasanah...).',
                    'Berdzikir di setiap putaran: "Subḥānallāh, wal-ḥamdu lillāh, wa lā ilāha illallāh, wallāhu akbar". Mazhab Syafi\'i mensunnahkan membaca Al-Qur\'an.',
                    'Salat sunat 2 rakaat setelah tawaf di belakang Maqam Ibrahim (membaca surat Al-Kafirun dan Al-Ikhlas). Jika tidak memungkinkan, salat di mana saja di dalam Masjidil Haram.',
                    'Berdoa di Multazam (area dinding antara Hajar Aswad dan Pintu Ka\'bah) dengan posisi berdiri menempelkan pipi, dada, lengan, dan telapak tangan pada dinding Ka\'bah.',
                    'Salat sunat di dalam Hijr Ismail jika antrean memungkinkan.'
                ],
                'larangan_thawaf' => [
                    'Menyentuh sebagian dinding dan syazarwan (bibir pondasi Ka\'bah). Jika menyentuh maka putaran tawafnya batal, namun putaran sebelumnya masih sah.',
                    'Masuk ke dalam area Hijr Ismail (karena Hijr Ismail merupakan bagian dari Ka\'bah).',
                    'Memutus tawaf tanpa alasan syar\'i. Jika memutus karena sakit, boleh melanjutkan jika jedanya sebentar; jika jedanya lama hingga orang mengira tawaf telah selesai, maka tawaf batal.'
                ],
                'adab_thawaf' => [
                    '1. Khusyu\' dan khudhu\' dengan menghadirkan hati bahwa tawaf yang dilakukan adalah tawaf terakhir.',
                    '2. Pandangan tertunduk ke lantai, tidak mendongak ke langit atau memandang Ka\'bah secara liar. Bayangkan tawafnya para malaikat yang selalu bertasbih (QS Az-Zumar: 75).',
                    '3. Tidak berbicara kecuali dzikir atau pembicaraan yang disunnahkan semisal amar ma\'ruf.',
                    '4. Menjaga pandangan dari sesuatu yang tidak halal.',
                    '5. Menangis berserah diri. Nabi SAW bersabda kepada Umar RA: "Di sinilah tempat menumpahkan air mata kesedihan dan penyesalan."'
                ],
                'hikmah_thawaf' => [
                    'Putaran 7 kali bisa dimaknai ibarat 7 hari dalam sepekan yang kita lalui senantiasa dalam dzikir dan doa kepada Allah.',
                    'Sebagaimana tawaf yang berdesakan, begitulah realitas hidup: kadang ada yang menyenggol, menyikut, dan dibutuhkan kesabaran tinggi untuk terus melangkah.',
                    'Dalam kondisi apa pun, kita harus selalu berputar mendekat kepada Allah, menjadikan Allah sebagai poros pusat segala orientasi hidup kita.'
                ]
            ],
            'zamzam_details' => [
                'doa' => [
                    'arabic' => 'اللَّهُمَّ إِنِّي أَسْأَلُكَ عِلْمًا نَافِعًا، وَرِزْقًا وَاسِعًا، وَشِفَاءً مِنْ كُلِّ دَاءٍ',
                    'latin' => 'Allāhumma innī as\'aluka ‘ilman nāfi‘an, wa rizqan wāsi‘an, wa syifā\'an min kulli dā\'in',
                    'meaning' => 'Ya Allah, sesungguhnya aku memohon kepada-Mu ilmu yang bermanfaat, rezeki yang melimpah ruah, dan kesembuhan dari segala macam penyakit.'
                ],
                'adab' => 'Minum dengan menghadap kiblat / Ka\'bah, membaca basmalah, meniatkan dalam hati hajat yang diinginkan, memegang gelas dengan tangan kanan, minum secara tadhalla\' (meneguk banyak dan kenyang), dan selesai minum mengucapkan hamdalah.',
                'benefits' => [
                    'Menjadi wasilah terkabulnya doa sesuai yang diniatkan (Ma\'u Zamzama lima syuriba lah).',
                    'Menjadi obat penawar bagi berbagai penyakit jasmani dan rohani.',
                    'Menjadi minuman sekaligus makanan yang mengenyangkan.',
                    'Menghilangkan sifat munafik dari dalam dada.'
                ]
            ],
            'sai_details' => [
                'ketentuan' => [
                    'Dimulai dari bukit Shafa dan berakhir di bukit Marwah.',
                    'Perjalanan dari bukit Shafa ke bukit Marwah dihitung satu kali perjalanan, demikian pula sebaliknya (total 7 kali lintasan).',
                    'Menyempurnakan 7 kali perjalanan dengan hitungan yang meyakinkan.',
                    'Dilakukan setelah Tawaf Qudum atau Tawaf Umrah atau Tawaf Ifadhah bagi yang berhaji Tamattu\'.',
                    'Tidak disyaratkan harus dalam keadaan suci dari hadats (baik laki-laki maupun wanita yang sedang haidh sah melakukan sa\'i).',
                    'Mengerjakan sa\'i secara berturut-turut (muwalat), tanpa berhenti kecuali ada udzur (seperti salat berjamaah atau kelelahan).',
                    'Dilakukan setelah tawaf; jika dilakukan sebelum tawaf, maka sa\'inya tidak sah.'
                ],
                'tata_cara' => [
                    'Ketika hendak mendaki bukit Shafa sebelum memulai sa\'i, menghadap Ka\'bah dan membaca doa: "Innaṣ-ṣafā wal-marwata min sya‘ā\'irillāh... Abda\'u bimā bada\'allāhu bihi wa rasūluh".',
                    'Berdoa di atas bukit Shafa ketika menghadap Ka\'bah: "Allāhu Akbar (3x) wa lillāhil-ḥamd. Lā ilāha illallāhu waḥdahū lā syarīka lah, lahul-mulku wa lahul-ḥamdu wa huwa ‘alā kulli syai\'in qadīr...".',
                    'Laki-laki disunnahkan berlari-lari kecil di antara dua tanda lampu hijau dengan membaca doa: "Rabbighfir warḥam, wa‘fu wa takarram, wa tajāwaz ‘ammā ta‘lam, innaka ta‘lamu mā lā na‘lam...".',
                    'Selama perjalanan sa\'i disunnahkan berdzikir, membaca Al-Qur\'an, atau berdoa sesuai tuntunan buku pedoman manasik.'
                ],
                'adab_dan_falsafah' => [
                    'Menjaga kebersihan hati, menjaga pandangan dari maksiat, mengendalikan emosi dari berdesakan, bersabar, khusyu\', tidak terburu-buru, dan ikhlas karena Allah.',
                    'Ketika berlari Shafa-Marwah, hendaknya ia menghadirkan niat berlari dari godaan setan dan hawa nafsu.',
                    'Sa\'i merupakan bentuk pengharapan mutlak kepada Allah, karena manusia tidak tahu amalnya diterima atau tidak.',
                    'Sa\'i adalah ibadah Ta\'abbudi, yaitu ketaatan murni yang tidak perlu dicari-cari logika mengapa dilakukan. Ibadah Ta\'abbudi lebih kuat dalam mengikis hawa nafsu dibanding ibadah Ta\'aqquli.'
                ]
            ],
            'tahallul_details' => [
                'definition' => 'Tahallul ialah keadaan seseorang yang telah dihalalkan (dibolehkan) melakukan perbuatan yang sebelumnya dilarang selama berihram.',
                'types' => [
                    ['name' => 'Tahallul Umrah', 'desc' => 'Tahallul yang dilakukan setelah sa\'i antara Shafa dan Marwah, yakni selesainya seluruh rangkaian rukun dan wajib umrah.'],
                    ['name' => 'Tahallul Haji', 'desc' => 'Terbagi menjadi Tahallul Awwal (setelah melontar Jumrah Aqabah dan bercukur pada 10 Dzulhijjah) dan Tahallul Tsani / Kubra (setelah Tawaf Ifadhah dan Sa\'i).']
                ],
                'prosedur' => [
                    'Bercukur disunnahkan dilaksanakan di bukit Marwah sesaat setelah menyelesaikan lintasan ke-7 sa\'i. Namun dapat dilaksanakan di hotel pemondokan dengan catatan selama belum bercukur masih dalam status ihram.',
                    'Bagi laki-laki dapat mencukur gundul (halq - lebih utama) atau memotong rambut (taqshir). Mencukur dimulai dari separuh kepala bagian kanan kemudian separuh bagian kiri.',
                    'Wanita cukup menggunting rambut saja sekurang-kurangnya 3 helai rambut sepanjang satu ruas ujung jari jemari.',
                    'Disunnahkan berdoa ketika memotong/mencukur rambut, dan berdoa memuji Allah setelah selesai bertahallul.'
                ]
            ],
            'post_umrah_duty' => [
                'summary' => 'Setelah selesai melaksanakan ibadah umrah wajib, seluruh petugas PPIH segera berganti seragam dinas operasional dan menempati pos tugas layanan Duyufurrahman:',
                'deployments' => [
                    [
                        'target' => 'PPIH Daker Bandara & Daker Madinah',
                        'role' => 'Bersiap menuju Madinah dan Bandara KAIA Jeddah untuk menyambut, mengarahkan, dan melayani kedatangan jemaah haji serta penyiapan hotel Madinah.'
                    ],
                    [
                        'target' => 'PPIH Daker Makkah',
                        'role' => 'Menuju ke sektor masing-masing (Sektor 1 s.d. 11 dan Sektor Khusus Masjidil Haram) untuk melaksanakan layanan akomodasi, katering, transportasi bus Shalawat, dan bimbingan ibadah.'
                    ],
                    [
                        'target' => 'PPIH Kloter',
                        'role' => 'Memberikan layanan 24 jam penuh mendampingi jemaah kloter di hotel pemondokan, memastikan kesehatan fisik jemaah, dan mengawal persiapan menuju puncak Arafah.'
                    ]
                ]
            ]
        ];
    }

    private static function getFiqhData(): array
    {
        return [
            'rukun' => [
                ['num' => '1', 'name' => 'Niat Ihram', 'desc' => 'Berniat ihram dari miqat yang sah secara syar\'i untuk memulai manasik haji.'],
                ['num' => '2', 'name' => 'Wukuf di Arafah', 'desc' => 'Hadir di padang Arafah pada waktu zawal 9 Dzulhijjah hingga terbit fajar 10 Dzulhijjah (Inti ibadah haji).'],
                ['num' => '3', 'name' => 'Tawaf Ifadhah', 'desc' => 'Mengelilingi Ka\'bah sebanyak 7 putaran berlawanan arah jarum jam dalam keadaan suci dari hadats.'],
                ['num' => '4', 'name' => 'Sa\'i', 'desc' => 'Berjalan bolak-balik 7 kali antara bukit Shafa dan bukit Marwah.'],
                ['num' => '5', 'name' => 'Tahallul', 'desc' => 'Mencukur atau memotong rambut minimal 3 helai rambut kepala.'],
                ['num' => '6', 'name' => 'Tertib', 'desc' => 'Mendahulukan niat ihram sebelum wukuf, serta mendahulukan wukuf sebelum Tawaf Ifadhah dan Tahallul.'],
            ],
            'wajib' => [
                ['num' => '1', 'name' => 'Ihram dari Miqat', 'desc' => 'Berniat ihram pada batas wilayah yang telah ditetapkan syariat (Yalamlam, Bir Ali, Qarnul Manazil, dll).'],
                ['num' => '2', 'name' => 'Mabit di Muzdalifah', 'desc' => 'Bermalam di Muzdalifah pada malam 10 Dzulhijjah minimal melewati tengah malam.'],
                ['num' => '3', 'name' => 'Mabit di Mina', 'desc' => 'Bermalam di Mina pada malam-malam hari Tasyrik (11, 12, dan 13 Dzulhijjah).'],
                ['num' => '4', 'name' => 'Melontar Jumrah', 'desc' => 'Melontar Jumrah Aqabah pada 10 Dzulhijjah dan 3 Jumrah (Ula, Wustha, Aqabah) pada hari Tasyrik.'],
                ['num' => '5', 'name' => 'Menghindari Larangan Ihram', 'desc' => 'Menjauhi pakaian berjahit (bagi pria), wewangian, potong kuku/rambut, dan hubungan suami istri.'],
                ['num' => '6', 'name' => 'Tawaf Wada\'', 'desc' => 'Tawaf perpisahan sebelum meninggalkan Makkah al-Mukarramah (gugur bagi wanita haid).'],
            ],
            'types' => [
                [
                    'name' => 'Haji Tamattu\' (Pilihan Wajib PPIH)',
                    'desc' => 'Mengerjakan Umrah terlebih dahulu di bulan-bulan haji (Syawal, Dzulqa\'dah, Dzulhijjah), bertahallul penuh (melepas kain ihram dan memakai pakaian biasa), kemudian pada 8 Dzulhijjah berihram kembali untuk ibadah Haji.',
                    'hukum_dam' => 'Wajib membayar Dam Nusuk (menyembelih 1 kambing atau puasa 3 hari di tanah suci + 7 hari di tanah air).',
                    'keunggulan' => 'Sangat praktis dan tidak memberatkan jemaah & petugas karena masa memakai ihram tidak terlalu lama.',
                ],
                [
                    'name' => 'Haji Ifrad',
                    'desc' => 'Berniat dan mengerjakan ibadah Haji terlebih dahulu hingga selesai seluruh rukun dan wajibnya pada 12 atau 13 Dzulhijjah, baru kemudian berihram untuk Umrah.',
                    'hukum_dam' => 'Tidak wajib membayar Dam.',
                    'keunggulan' => 'Sangat afdhal secara amalan mandiri, namun menuntut menjaga larangan ihram dalam waktu yang relatif panjang.',
                ],
                [
                    'name' => 'Haji Qiran',
                    'desc' => 'Berniat melaksanakan ibadah Haji dan Umrah sekaligus dalam satu ihram dan satu rangkaian amalan tanpa bertahallul di antara keduanya.',
                    'hukum_dam' => 'Wajib membayar Dam Nusuk.',
                    'keunggulan' => 'Hanya melakukan satu kali Tawaf Ifadhah dan satu kali Sa\'i untuk kedua ibadah.',
                ],
            ],
            'larangan_ihram' => [
                'pria' => ['Memakai pakaian bertangkup / berjahit yang membentuk lekuk tubuh (celana, kemeja, pakaian dalam).', 'Menutup kepala dengan penutup yang menempel (peci, topi, sorban).', 'Memakai sepatu atau alas kaki yang menutupi mata kaki dan jari.'],
                'wanita' => ['Menutup wajah menggunakan cadar / niqab (boleh menutup dengan kain yang tidak menempel jika ada lelaki ajnabi).', 'Memakai sarung tangan yang menutup jari jemari.'],
                'bersama' => ['Memakai wewangian pada badan maupun pakaian ihram setelah niat.', 'Memotong kuku tangan maupun kuku kaki.', 'Mencukur, mencabut, atau menggunting rambut kepala maupun bulu badan.', 'Membunuh atau memburu hewan darat buruan.', 'Menikah, menikahkan orang lain (menjadi wali), atau meminang.', 'Bersetubuh (rafats) atau bermesraan dengan syahwat.', 'Berbuat maksiat (fusuq) dan bertengkar / berbantah-bantahan (jidal).'],
            ],
            'dam_categories' => [
                [
                    'name' => '1. Dam Tartib wa Taqdir (Berurutan dengan Ketentuan Pasti)',
                    'cause' => 'Mengerjakan Haji Tamattu\' atau Qiran, atau meninggalkan salah satu wajib haji (tidak berniat di miqat, tidak mabit di Muzdalifah, tidak mabit di Mina, tidak melontar jumrah, atau tidak tawaf wada\').',
                    'penalty' => 'Wajib menyembelih 1 ekor kambing di tanah haram Makkah. Jika tidak mampu (finansial/fisik), wajib berpuasa 10 hari (3 hari di tanah suci selama musim haji + 7 hari setelah kembali ke tanah air).'
                ],
                [
                    'name' => '2. Dam Takhyir wa Taqdir (Boleh Memilih dari Ukuran Tertentu)',
                    'cause' => 'Melanggar larangan ihram ringan karena uzur atau sengaja: mencukur rambut/bulu badan, memotong kuku, memakai wewangian, memakai pakaian berjahit (pria), menutup kepala (pria), menutup wajah/cadar (wanita), atau memakai sarung tangan.',
                    'penalty' => 'Bebas memilih salah satu: (1) Menyembelih 1 ekor kambing di Makkah, ATAU (2) Puasa 3 hari di mana saja, ATAU (3) Bersedekah memberi makan 6 orang fakir miskin (masing-masing 1/2 sha\' atau ~1,5 kg makanan pokok).'
                ],
                [
                    'name' => '3. Dam Takhyir wa Ta\'dil (Boleh Memilih dengan Nilai Sepadan)',
                    'cause' => 'Berburu, membunuh, atau membantu membunuh hewan darat buruan saat berihram, atau menebang pohon/mencabut tanaman di tanah haram Makkah.',
                    'penalty' => 'Bebas memilih salah satu: (1) Menyembelih hewan ternak yang senilai dengan hewan buruan yang dibunuh, ATAU (2) Membeli makanan senilai hewan tersebut untuk dibagikan ke fakir miskin Makkah, ATAU (3) Berpuasa sebanyak hitungan mud makanan (1 hari puasa per 1 mud).'
                ],
                [
                    'name' => '4. Dam Tartib wa Ta\'dil (Berurutan dan Sepadan - Pelanggaran Berat)',
                    'cause' => 'Melakukan hubungan suami istri (bersetubuh / jima\') sebelum Tahallul Awwal (pelanggaran yang merusak/membatalkan haji).',
                    'penalty' => 'Haji menjadi BATAL dan wajib diselesaikan amalannya hingga tuntas serta wajib diqadha di tahun berikutnya. Denda berurutan: Menyembelih 1 ekor unta di Makkah. Jika tidak mampu, 1 ekor sapi. Jika tidak mampu, 7 ekor kambing. Jika tidak mampu, membeli makanan senilai unta untuk fakir miskin Makkah. Jika tidak mampu, berpuasa senilai mud makanan tersebut.'
                ]
            ]
        ];
    }

    private static function getPrayersData(): array
    {
        return [
            [
                'id' => 'p1',
                'title' => 'Niat Ihram Haji (Haji Tamattu\')',
                'occasion' => 'Dibaca di hotel pemondokan Makkah pada 8 Dzulhijjah sebelum berangkat ke Mina',
                'arabic' => 'لَبَّيْكَ اللَّهُمَّ حَجًّا',
                'trans' => 'Labbaikallāhumma ḥajjan',
                'meaning' => 'Aku penuhi panggilan-Mu, ya Allah, untuk berhaji.',
                'audio' => 'Labbaikallahumma hajjan'
            ],
            [
                'id' => 'p2',
                'title' => 'Bacaan Talbiyah Lengkap',
                'occasion' => 'Dikumandangkan terus-menerus sejak ihram hingga melontar Jumrah Aqabah 10 Dzulhijjah',
                'arabic' => 'لَبَّيْكَ اللَّهُمَّ لَبَّيْكَ، لَبَّيْكَ لَا شَرِيكَ لَكَ لَبَّيْكَ، إِنَّ الْحَمْدَ وَالنِّعْمَةَ لَكَ وَالْمُلْكَ، لَا شَرِيكَ لَكَ',
                'trans' => 'Labbaikallāhumma labbaīk, labbaīka lā syarīka laka labbaīk, innal-ḥamda wan-ni‘mata laka wal-mulk, lā syarīka lak',
                'meaning' => 'Aku penuhi panggilan-Mu ya Allah, aku penuhi panggilan-Mu. Tiada sekutu bagi-Mu, aku penuhi panggilan-Mu. Sesungguhnya segala puji, nikmat, dan kerajaan adalah milik-Mu, tiada sekutu bagi-Mu.',
                'audio' => 'Labbaikallahumma labbaik, labbaika la syarika laka labbaik'
            ],
            [
                'id' => 'p3',
                'title' => 'Doa Memasuki Kota Suci Makkah',
                'occasion' => 'Dibaca saat pertama kali memasuki batas kota Makkah al-Mukarramah',
                'arabic' => 'اللَّهُمَّ هَذَا حَرَمُكَ وَأَمْنُكَ، فَحَرِّمْ لَحْمِي وَدَمِي وَشَعْرِي وَبَشَرِي عَلَى النَّارِ',
                'trans' => 'Allāhumma hāżā ḥaramuka wa amnuka, faḥarrim laḥmī wa damī wa sya‘rī wa basyarī ‘alan-nār',
                'meaning' => 'Ya Allah, kota ini adalah tanah haram-Mu dan daerah aman-Mu. Maka haramkanlah dagingku, darahku, rambutku, dan kulitku dari jilatan api neraka.',
                'audio' => 'Allahumma hadza haramuka wa amnuk'
            ],
            [
                'id' => 'p4',
                'title' => 'Doa Masuk Masjidil Haram',
                'occasion' => 'Dibaca dengan melangkahkan kaki kanan saat memasuki pintu Masjidil Haram',
                'arabic' => 'اللَّهُمَّ أَنْتَ السَّلَامُ وَمِنْكَ السَّلَامُ، فَحَيِّنَا رَبَّنَا بِالسَّلَامِ، اللَّهُمَّ افْتَحْ لِي أَبْوَابَ رَحْمَتِكَ',
                'trans' => 'Allāhumma antas-salām wa minkas-salām, faḥayyinā rabbanā bis-salām, Allāhummaftaḥ lī abwāba raḥmatik',
                'meaning' => 'Ya Allah, Engkau adalah Dzat sumber keselamatan, dan dari-Mulah keselamatan. Maka sambutlah kami wahai Tuhan kami dengan keselamatan. Ya Allah, bukakanlah untukku pintu-pintu rahmat-Mu.',
                'audio' => 'Allahumma antas salam wa minkas salam'
            ],
            [
                'id' => 'p5',
                'title' => 'Doa Pertama Kali Melihat Ka\'bah',
                'occasion' => 'Dibaca sambil mengangkat kedua tangan saat mata memandang keagungan Ka\'bah',
                'arabic' => 'اللَّهُمَّ زِدْ هَذَا الْبَيْتَ تَشْرِيفًا وَتَعْظِيمًا وَتَكْرِيمًا وَمَهَابَةً، وَزِدْ مَنْ شَرَّفَهُ وَعَظَّمَهُ مِمَّنْ حَجَّهُ أَوِ اعْتَمَرَهُ تَشْرِيفًا وَتَكْرِيمًا وَتَعْظِيمًا وَبِرًّا',
                'trans' => 'Allāhumma zid hāżal-baita tasyrīfan wa ta‘ẓīman wa takrīman wa mahābah, wa zid man syarrafahū wa ‘aẓẓamahū mimman ḥajjahū awi‘tamarahū tasyrīfan wa takrīman wa ta‘ẓīman wa birrā',
                'meaning' => 'Ya Allah, tambahkanlah kemuliaan, keagungan, kehormatan, dan wibawa pada Baitullah ini. Dan tambahkanlah pula kemuliaan, kehormatan, keagungan, dan kebaikan bagi orang-orang yang memuliakannya dari kalangan mereka yang berhaji atau berumrah.',
                'audio' => 'Allahumma zid hadzal baita tasyrifan wa ta\'zhima'
            ],
            [
                'id' => 'p6',
                'title' => 'Doa Antara Rukun Yamani dan Hajar Aswad (Tawaf)',
                'occasion' => 'Dibaca pada setiap putaran tawaf saat melintas di antara Rukun Yamani menuju Hajar Aswad',
                'arabic' => 'رَبَّنَا آتِنَا فِي الدُّنْيَا حَسَنَةً وَفِي الآخِرَةِ حَسَنَةً وَقِنَا عَذَابَ النَّارِ',
                'trans' => 'Rabbanā ātinā fid-dunyā ḥasanatan wa fil-ākhirati ḥasanatan wa qinā ‘ażāban-nār',
                'meaning' => 'Ya Tuhan kami, berikanlah kepada kami kebaikan di dunia dan kebaikan di akhirat, dan peliharalah kami dari siksaan api neraka.',
                'audio' => 'Rabbana atina fid dunya hasanah wa fil akhirati hasanah wa qina adzaban nar'
            ],
            [
                'id' => 'p7',
                'title' => 'Doa Meminum Air Zamzam',
                'occasion' => 'Dibaca menghadap kiblat setelah selesai tawaf dan shalat sunnah tawaf',
                'arabic' => 'اللَّهُمَّ إِنِّي أَسْأَلُكَ عِلْمًا نَافِعًا، وَرِزْقًا وَاسِعًا، وَشِفَاءً مِنْ كُلِّ دَاءٍ وَسَقَمٍ',
                'trans' => 'Allāhumma innī as\'aluka ‘ilman nāfi‘ā, wa rizqan wāsi‘ā, wa syifā\'an min kulli dā\'in wa saqam',
                'meaning' => 'Ya Allah, sesungguhnya aku memohon kepada-Mu ilmu yang bermanfaat, rezeki yang melimpah ruah, dan kesembuhan dari segala penyakit dan mara bahaya.',
                'audio' => 'Allahumma inni as-aluka \'ilman nafi\'a wa rizqan wasi\'a'
            ],
            [
                'id' => 'p8',
                'title' => 'Doa Naik ke Bukit Shafa Sebelum Sa\'i',
                'occasion' => 'Dibaca ketika mulai menaiki bukit Shafa untuk putaran sa\'i pertama',
                'arabic' => 'إِنَّ الصَّفَا وَالْمَرْوَةَ مِنْ شَعَائِرِ اللَّهِ، أَبْدَأُ بِمَا بَدَأَ اللَّهُ بِهِ',
                'trans' => 'Innaṣ-ṣafā wal-marwata min sya‘ā\'irillāh, abda\'u bimā bada\'allāhu bih',
                'meaning' => 'Sesungguhnya Shafa dan Marwah adalah sebagian dari syiar-syiar Allah. Aku memulai dengan apa yang Allah mulai dengannya.',
                'audio' => 'Innash shafa wal marwata min sya\'airillah'
            ],
            [
                'id' => 'p9',
                'title' => 'Doa di Antara Dua Pilar Hijau (Sa\'i)',
                'occasion' => 'Dibaca saat berlari-lari kecil bagi pria di antara pilar/lampu hijau di lintasan sa\'i',
                'arabic' => 'رَبِّ اغْفِرْ وَارْحَمْ، وَاعْفُ وَتَكَرَّمْ، وَتَجَاوَزْ عَمَّا تَعْلَمْ، إِنَّكَ تَعْلَمُ مَا لَا نَعْلَمُ، إِنَّكَ أَنْتَ اللَّهُ الْأَعَزُّ الْأَكْرَمُ',
                'trans' => 'Rabbighfir warḥam, wa‘fu wa takarram, wa tajāwaz ‘ammā ta‘lam, innaka ta‘lamu mā lā na‘lam, innaka antallāhul-a‘azzul-akram',
                'meaning' => 'Wahai Tuhanku, ampunilah, sayangilah, maafkanlah, muliakanlah, dan hapuskanlah dosa-dosa yang Engkau ketahui. Sesungguhnya Engkau mengetahui apa yang tidak kami ketahui, dan sesungguhnya Engkaulah Allah Yang Maha Perkasa lagi Maha Mulia.',
                'audio' => 'Rabbighfir warham wa\'fu wa takarram'
            ],
            [
                'id' => 'p10',
                'title' => 'Doa Terbaik Hari Wukuf Arafah',
                'occasion' => 'Dibaca berulang-ulang dengan penuh kerendahan hati selama wukuf di Arafah 9 Dzulhijjah',
                'arabic' => 'لَا إِلَهَ إِلَّا اللَّهُ وَحْدَهُ لَا شَرِيكَ لَهُ، لَهُ الْمُلْكُ وَلَهُ الْحَمْدُ، يُحْيِي وَيُمِيتُ، وَهُوَ عَلَى كُلِّ شَيْءٍ قَدِيرٌ',
                'trans' => 'Lā ilāha illallāhu waḥdahū lā syarīka lah, lahul-mulku wa lahul-ḥamdu, yuḥyī wa yumītu, wa huwa ‘alā kulli syai\'in qadīr',
                'meaning' => 'Tiada Tuhan selain Allah semata, tiada sekutu bagi-Nya. Bagi-Nya kerajaan dan bagi-Nya segala puji, Dia Yang Menghidupkan dan Mematikan, dan Dia Maha Kuasa atas segala sesuatu.',
                'audio' => 'Laa ilaha illallahu wahdahu laa syariika lah'
            ],
            [
                'id' => 'p11',
                'title' => 'Doa Melontar Tiap Butir Kerikil Jumrah',
                'occasion' => 'Dibaca pada setiap lontaran kerikil di Jumrah Aqabah, Ula, dan Wustha',
                'arabic' => 'بِسْمِ اللَّهِ، اللَّهُ أَكْبَرُ، رَجْمًا لِلشَّيْطَانِ وَرِضًا لِلرَّحْمَنِ، اللَّهُمَّ اجْعَلْهُ حَجًّا مَبْرُورًا وَذَنْبًا مَغْفُورًا',
                'trans' => 'Bismillāhi, Allāhu Akbar, rajman lisysyaiṭāni wa riḍan lir-raḥmān, Allāhummaj‘alhu ḥajjan mabrūrā wa żanban magfūrā',
                'meaning' => 'Dengan nama Allah, Allah Maha Besar. Lontaran ini sebagai penolak godaan setan dan mencari keridhaan Dzat Yang Maha Pengasih. Ya Allah, jadikanlah hajiku ini mabrur dan dosaku diampuni.',
                'audio' => 'Bismillahi Allahu Akbar rajman lisysyaitan'
            ],
            [
                'id' => 'p12',
                'title' => 'Doa Bercukur / Tahallul',
                'occasion' => 'Dibaca saat memotong rambut tanda bertahallul',
                'arabic' => 'اللَّهُمَّ أَثْبِتْ لِي بِكُلِّ شَعْرَةٍ حَسَنَةً، وَامْحُ عَنِّي بِهَا سَيِّئَةً، وَارْفَعْ لِي بِهَا عِنْدَكَ دَرَجَةً',
                'trans' => 'Allāhumma aṡbit lī bikulli sya‘ratin ḥasanah, wamḥu ‘annī bihā sayyi\'ah, warfa‘ lī bihā ‘indaka darajah',
                'meaning' => 'Ya Allah, tetapkanlah bagiku dari setiap helai rambut satu kebaikan, hapuskanlah dariku satu keburukan, dan angkatlah derajatku di sisi-Mu dengannya.',
                'audio' => 'Allahumma atsbit li bikulli sya\'ratin hasanah'
            ],
            [
                'id' => 'p13',
                'title' => 'Doa Istighfar & Munajat Wukuf di Padang Arafah',
                'occasion' => 'Dibaca saat wukuf di Arafah pada 9 Dzulhijjah menghadap kiblat',
                'arabic' => 'أَسْتَغْفِرُ اللَّهَ الْعَظِيمَ الَّذِي لَا إِلَهَ إِلَّا هُوَ الْحَيُّ الْقَيُّومُ وَأَتُوبُ إِلَيْهِ',
                'trans' => 'Astaghfirullāhal-‘aẓīm allażī lā ilāha illā huwal-ḥayyul-qayyūmu wa atūbu ilaih',
                'meaning' => 'Aku memohon ampun kepada Allah Yang Maha Agung, tiada Tuhan selain Dia Yang Maha Hidup lagi terus menerus mengurus makhluk-Nya, dan aku bertaubat kepada-Nya.',
                'audio' => 'Astaghfirullahal \'adzim alladzi la ilaha illa huwal hayyul qayyum wa atubu ilaih'
            ],
            [
                'id' => 'p14',
                'title' => 'Doa Mabit di Muzdalifah & Masy\'aril Haram',
                'occasion' => 'Dibaca pada malam 10 Dzulhijjah saat berdzikir di Muzdalifah',
                'arabic' => 'اللَّهُمَّ كَمَا وَقَفْتَنَا فِيهِ وَأَرَيْتَنَا إِيَّاهُ فَوَفِّقْنَا لِذِكْرِكَ كَمَا هَدَيْتَنَا',
                'trans' => 'Allāhumma kamā waqaftanā fīhi wa araitanā iyyāhu fawaffiqnā liżikrika kamā hadaitanā',
                'meaning' => 'Ya Allah, sebagaimana Engkau telah menempatkan kami di tempat mulia ini dan memperlihatkannya kepada kami, maka berilah kami taufiq untuk senantiasa mengingat-Mu sebagaimana Engkau telah memberi petunjuk kepada kami.',
                'audio' => 'Allahumma kama waqaftana fihi wa araitana iyyahu fawaffiqna lidzikrika kama hadaitana'
            ],
            [
                'id' => 'p15',
                'title' => 'Doa Sesudah Selesai Melontar Tiga Jumrah (Hari Tasyrik)',
                'occasion' => 'Dibaca setelah tuntas melontar Jumrah Ula, Wustha, dan Aqabah pada 11-13 Dzulhijjah',
                'arabic' => 'اللَّهُمَّ اجْعَلْهُ حَجًّا مَبْرُورًا، وَعَمَلًا صَالِحًا مَقْبُولًا، وَذَنْبًا مَغْفُورًا، وَتِجَارَةً لَنْ تَبُورَ',
                'trans' => 'Allāhummaj‘alhu ḥajjan mabrūrā, wa ‘amalan ṣāliḥan maqbūlā, wa żanban magfūrā, wa tijāratan lan tabūr',
                'meaning' => 'Ya Allah, jadikanlah hajiku ini haji yang mabrur, amal shaleh yang diterima, dosa yang diampuni, dan perniagaan yang tidak akan pernah merugi.',
                'audio' => 'Allahummaj\'alhu hajjan mabrura wa \'amalan shalihan maqbula'
            ],
            [
                'id' => 'p16',
                'title' => 'Doa Tawaf Wada\' (Tawaf Perpisahan Meninggalkan Makkah)',
                'occasion' => 'Dibaca setelah selesai 7 putaran Tawaf Wada\' sebelum melangkah keluar dari Masjidil Haram',
                'arabic' => 'اللَّهُمَّ لَا تَجْعَلْ هَذَا آخِرَ الْعَهْدِ بِبَيْتِكَ الْحَرَامِ، وَإِنْ جَعَلْتَهُ فَاعْوِضْنِي عَنْهُ الْجَنَّةَ بِرَحْمَتِكَ يَا أَرْحَمَ الرَّاحِمِينَ',
                'trans' => 'Allāhumma lā taj‘al hāżā ākhiral-‘ahdi bibaitikal-ḥarām, wa in ja‘altahū fa‘wiḍnī ‘anhul-jannata biraḥmatika yā arḥamar-rāḥimīn',
                'meaning' => 'Ya Allah, janganlah Engkau jadikan kunjungan ini saat terakhir bagiku dengan Baitullah-Mu yang mulia. Sekiranya Engkau menjadikannya yang terakhir, gantikanlah untukku dengan surga berkat rahmat-Mu, wahai Dzat Yang Maha Pengasih lagi Maha Penyayang.',
                'audio' => 'Allahumma la taj\'al hadza akhiral \'ahdi bibaitikal haram'
            ]
        ];
    }

    private static function getRegulationsData(): array
    {
        return [
            'indonesia' => [
                'authority' => 'Kementerian Haji dan Umrah Republik Indonesia (Kemenhaj RI) & BPKH',
                'official_portal' => 'https://haji.go.id/regulasi',
                'legal_basis' => 'Perpres No. 92 Tahun 2025 & UU No. 8 Tahun 2019 jo. UU No. 14 Tahun 2025 tentang Penyelenggaraan Ibadah Haji dan Umrah',
                'rules' => [
                    [
                        'topic' => 'Kelembagaan Kementerian Haji dan Umrah RI (Kemenhaj)',
                        'badge' => 'Perpres 92/2025',
                        'detail' => 'Berdasarkan Peraturan Presiden Republik Indonesia No. 92 Tahun 2025, urusan penyelenggaraan ibadah haji dan umrah dikelola secara mandiri dan berfokus penuh di bawah Kementerian Haji dan Umrah Republik Indonesia, mencakup regulasi kebijakan, pengawasan akreditasi PPIU/PIHK, operasional Siskohat, serta diplomasi kuota internasional dengan Kementerian Haji Arab Saudi.'
                    ],
                    [
                        'topic' => '4 Kategori Status Istitha\'ah Kesehatan (Siskohatkes)',
                        'badge' => 'Syarat Mutlak Pelunasan',
                        'detail' => 'Sesuai regulasi terbaru Kemenhaj RI dan Kemenkes RI, penetapan status istitha\'ah kesehatan dilakukan sebelum pembukaan pelunasan Bipih melalui Siskohatkes dengan 4 kategori: (1) Memenuhi Syarat Istitha\'ah, (2) Memenuhi Syarat dengan Pendampingan, (3) Tidak Memenuhi Syarat Sementara (pengobatan berjalan), dan (4) Tidak Memenuhi Syarat Tetap/Permanen (gagal organ stadium akhir, demensia berat, psikotik berat).'
                    ],
                    [
                        'topic' => 'Biaya Haji Terpadu (BPIH & Bipih)',
                        'badge' => 'PMHU No. 3/2025',
                        'detail' => 'Biaya Penyelenggaraan Ibadah Haji (BPIH) terbagi menjadi Bipih (biaya yang disetor langsung jemaah ke Bank Penerima Setoran) dan Alokasi Nilai Manfaat yang dikelola oleh Badan Pengelola Keuangan Haji (BPKH). Nilai manfaat menyubsidi komponen akomodasi, katering Masyair, dan operasional penerbangan.'
                    ],
                    [
                        'topic' => 'Pelimpahan Nomor Porsi Jemaah Wafat / Sakit Permanen',
                        'badge' => 'Kepmenhaj RI',
                        'detail' => 'Nomor porsi jemaah yang telah masuk alokasi kuota keberangkatan tahun berjalan namun wafat atau mengalami sakit permanen dapat dilimpahkan 1 (satu) kali kepada: suami, istri, ayah, ibu, anak kandung, atau saudara kandung yang ditunjuk melalui surat kuasa bermaterai dan penetapan waris yang sah.'
                    ],
                    [
                        'topic' => 'Petugas Haji Terpadu: PPIH Kloter & PPIH Arab Saudi',
                        'badge' => 'Bimtek Terintegrasi',
                        'detail' => 'Penyelenggaraan didukung oleh Petugas Penyelenggara Ibadah Haji (PPIH) yang melalui tahapan seleksi CAT dan Bimbingan Teknis (Bimtek) Terintegrasi mencakup Kelas Besar, Kelas Tusi (Tugas dan Fungsi Layanan), serta Bina Fisik/Jasmani bersama instruktur TNI/Polri.'
                    ],
                    [
                        'topic' => 'Gelang Logam Identitas Jemaah Indonesia',
                        'badge' => 'SOP Wajib Lapangan',
                        'detail' => 'Setiap jemaah RI wajib memakai gelang logam anti-karat berukir lambang Garuda, nomor paspor, nama jemaah, nomor porsi, nomor kloter, dan asal embarkasi. Gelang ini tahan api dan tahan air serta tidak boleh dilepaskan selama di Arab Saudi.'
                    ]
                ]
            ],
            'saudi' => [
                'authority' => 'Kementerian Haji dan Umrah Kerajaan Arab Saudi (Ministry of Hajj & Umrah KSA)',
                'legal_basis' => 'Sistem Regulasi Digital Pelayanan Duyufurrahman (Tamu Allah)',
                'rules' => [
                    [
                        'topic' => 'Kartu Pintar Nusuk (Nusuk Smart Card)',
                        'badge' => 'Wajib Akses Armuzna',
                        'detail' => 'Kartu fisik berteknologi chip RFID & barcode resmi dari Pemerintah Saudi yang wajib dikalungkan setiap jemaah. Berisi data visa haji resmi, nomor maktab, lokasi tenda di Mina/Arafah, serta menjadi kartu akses masuk wajib di pos pemeriksaan (checkpoint) Armuzna. Tanpa kartu Nusuk, jemaah dilarang memasuki area Masyair.'
                    ],
                    [
                        'topic' => 'Larangan Tegas Visa Non-Haji & Sanksi Berat',
                        'badge' => 'Denda 10.000 - 50.000 SAR',
                        'detail' => 'Kerajaan Arab Saudi melarang keras melaksanakan haji menggunakan visa ziarah, visa turis, visa pekerja, atau visa umrah. Sanksi hukum bagi pelanggar: denda 10.000 hingga 50.000 Riyal Saudi, penahanan, deportasi seketika, dan cekal masuk Arab Saudi selama 10 tahun.'
                    ],
                    [
                        'topic' => 'Sistem Jadwal Ketat Lontar Jamarat',
                        'badge' => 'Crowd Control Masyair',
                        'detail' => 'Demi keselamatan dan pencegahan penumpukan jemaah (crowd control), lontar jumrah di Jamarat diatur dengan jadwal ketat per maktab. Jemaah dilarang melontar pada jam-jam puncak kepadatan (waktu terik siang 10 Dzulhijjah) dan wajib mematuhi pemandu jalur.'
                    ],
                    [
                        'topic' => 'Transportasi Bus Shalawat & Kereta Masyair',
                        'badge' => 'Operasional 24 Jam',
                        'detail' => 'Saudi menyediakan layanan Bus Shalawat 24 jam berstiker bendera negara yang menghubungkan hotel jemaah di Makkah ke Terminal Masjidil Haram (Syib Amir, Jiad, Kudai), serta Mashaaer Railway (Kereta Cepat Masyair) antara Arafah-Muzdalifah-Mina.'
                    ],
                    [
                        'topic' => 'Ketentuan Bagasi & Larangan Air Zamzam di Koper',
                        'badge' => 'GACA Aviation Rules',
                        'detail' => 'Koper bagasi maksimal 32 kg per jemaah dan tas kabin 7 kg. Maskapai penerbangan internasional dan otoritas GACA melarang keras memasukkan air zamzam ke dalam koper bagasi karena risiko rembes/bocor. Setiap jemaah resmi mendapat jatah 5 liter air zamzam gratis di bandara debarkasi kepulangan.'
                    ]
                ]
            ]
        ];
    }

    private static function getOfficerFiqhData(): array
    {
        return [
            'title' => 'Fiqih Khusus Petugas Haji (Prinsip Ibadah Muta\'addiyah)',
            'authorities' => 'Kementerian Agama RI & Kementerian Haji dan Umrah Republik Indonesia',
            'legal_foundations' => [
                'dalil_social_worship' => [
                    'arabic' => 'الْمُتَعَدِّي أَفْضَلُ مِنَ الْقَاصِرِ',
                    'latin' => 'Al-muta‘addī afḍalu minal-qāṣir',
                    'meaning' => 'Amalan ibadah yang manfaatnya menyebar kepada orang banyak lebih utama dibanding ibadah yang manfaatnya hanya terbatas untuk diri sendiri.'
                ],
                'isytirath_prayer' => [
                    'arabic' => 'اللَّهُمَّ مَحِلِّي حَيْثُ حَبَسْتَنِي',
                    'latin' => 'Allāhumma maḥallī ḥaiṡu ḥabastanī (Fa in ḥabasanī ḥābisun fa maḥallī ḥaiṡu ḥabastanī)',
                    'meaning' => 'Ya Allah, tempat tahallulku adalah di mana Engkau menahanku. (Jika aku terhalang tugas melayani jemaah, maka tempat tahallulku di mana aku terhalang tanpa dam).'
                ]
            ],
            'principles' => [
                [
                    'topic' => '1. Pelayanan Jemaah Berstatus Ibadah Muta\'addiyah',
                    'desc' => 'Tugas pokok petugas haji (melayani jemaah sakit, menuntun lansia, evakuasi jemaah tersesat, penyaluran konsumsi, dan perlindungan keamanan) merupakan fardhu kifayah dan \'ibadah muta\'addiyah. Ulama 4 mazhab sepakat pahala menolong jemaah yang kesusahan di terik Armuzna jauh melampaui shalat sunnah pribadi di Masjidil Haram.'
                ],
                [
                    'topic' => '2. Niat Ihram Isytirath (Bersyarat)',
                    'desc' => 'Petugas haji disunnahkan menyertakan syarat saat berihram. Jika mendadak terjadi situasi darurat jemaah yang menuntut pelepasan pakaian ihram atau terhalang menyelesaikan tawaf/sa\'i tepat waktu, petugas sah bertahallul seketika tanpa dikenakan denda Dam dan tanpa kewajiban mengqadha haji (HR. Muslim & Bukhari dari Sayyidah Dhiba\'ah binti Zubair).'
                ],
                [
                    'topic' => '3. Badal Lontar Jumrah bagi Jemaah Udzur',
                    'desc' => 'Petugas haji diperbolehkan membadalkan lontar jumrah untuk jemaah lansia, risti, pingsan, atau sakit. Caranya: Di setiap pilar jumrah, petugas melontar 7 butir kerikil untuk dirinya terlebih dahulu, lalu di posisi yang sama langsung melontar 7 butir kerikil atas nama jemaah yang dibadalkan tanpa perlu bolak-balik ke kemah.'
                ],
                [
                    'topic' => '4. Badal Haji Jemaah Wafat / Sakit Permanen',
                    'desc' => 'Petugas yang telah menunaikan ibadah haji untuk dirinya sendiri sah membadalkan haji jemaah yang wafat di embarkasi/Arab Saudi atau jemaah sakit jiwa/koma permanen atas penugasan resmi kementerian (Badal Haji Pemerintah).'
                ],
                [
                    'topic' => '5. Rukhsah Mabit di Muzdalifah & Mina',
                    'desc' => 'Petugas yang sibuk bertugas di sektor posko, rumah sakit KKHI, logistik katering, atau linjam mendapatkan rukhsah (keringanan) syar\'i untuk tidak mabit di Mina/Muzdalifah tanpa dikenakan Dam, diqiyaskan dengan pengembala unta (ru\'atul ibil) dan penyedia air minum jemaah (siqayatul hajj Abbas bin Abdul Muthalib).'
                ],
                [
                    'topic' => '6. Skema Murur & Tanazul bagi Petugas dan Lansia',
                    'desc' => 'Penerapan skema Murur (melintas Muzdalifah di dalam bus menuju Mina tanpa turun) dan skema Tanazul (pemulangan jemaah lemah ke hotel Makkah) adalah sah menurut fiqih kontemporer Kemenhaj RI demi memelihara jiwa (Hifzhun Nafs) dari bahaya kepadatan ekstrem.'
                ]
            ]
        ];
    }

    private static function getVideoData(): array
    {
        return [
            [
                'title' => 'Simulasi Visual 3D Rangkaian Perjalanan Ibadah Haji Hari Demi Hari',
                'source' => 'Saudi Ministry of Hajj & Umrah / Official Animation Series',
                'embed_url' => 'https://www.youtube.com/embed/8w5gQjV2pG8',
                'duration' => '15 Menit',
                'desc' => 'Animasi 3D resmi resolusi tinggi yang menggambarkan pergerakan jemaah dari Miqat, Mina (Tarwiyah), wukuf di Arafah, mabit Muzdalifah, melempar jumrah Jamarat, hingga Tawaf Ifadhah di Masjidil Haram.'
            ],
            [
                'title' => 'Panduan Manasik Haji Lengkap Kementerian Haji dan Umrah RI',
                'source' => 'Kementerian Haji dan Umrah Republik Indonesia',
                'embed_url' => 'https://www.youtube.com/embed/WJ_c7q2y-hU',
                'duration' => '25 Menit',
                'desc' => 'Video peragaan langsung tata cara ihram, niat, bacaan talbiyah, rukun & wajib haji, serta tips kesehatan bagi jemaah haji Indonesia.'
            ],
            [
                'title' => 'Tutorial Praktik Tawaf, Sa\'i dan Tahallul di Masjidil Haram',
                'source' => 'Edukasi Manasik Visual 1080p',
                'embed_url' => 'https://www.youtube.com/embed/3e6A7OaP1x8',
                'duration' => '12 Menit',
                'desc' => 'Visualisasi titik awal Hajar Aswad, cara memberi isyarat istilam (Bismillahi Allahu Akbar), batas lari-lari kecil di pilar hijau sa\'i, dan tata cara mencukur rambut tahallul.'
            ]
        ];
    }

    private static function getQuizData(): array
    {
        return [
            [
                'id' => 1,
                'question' => 'Manakah di bawah ini yang merupakan RUKUN HAJI yang jika ditinggalkan hajinya TIDAK SAH dan tidak dapat diganti dengan Dam (denda)?',
                'options' => ['Wukuf di Padang Arafah', 'Mabit di Muzdalifah', 'Melontar Tiga Jumrah', 'Tawaf Wada\''],
                'correct' => 'Wukuf di Padang Arafah',
                'explanation' => 'Wukuf di Arafah adalah rukun haji paling inti berdasarkan sabda Nabi SAW "Al-Hajju Arafah". Wajib haji (seperti mabit dan melontar) jika ditinggalkan hajinya tetap sah namun wajib membayar dam.'
            ],
            [
                'id' => 2,
                'question' => 'Berdasarkan Keputusan Dirjen Pelayanan Haji No. 26 Tahun 2026 tentang RPH 1448 H / 2027 M, kapankah waktu pelaksanaan Wukuf di Padang Arafah?',
                'options' => [
                    '15 Mei 2027 (09 Dzulhijjah 1448 H)',
                    '10 April 2027 (03 Dzulqa\'idah 1448 H)',
                    '16 Mei 2027 (10 Dzulhijjah 1448 H)',
                    '20 Juni 2027 (15 Muharram 1449 H)'
                ],
                'correct' => '15 Mei 2027 (09 Dzulhijjah 1448 H)',
                'explanation' => 'Berdasarkan RPH 1448 H / 2027 M butir ke-10, Wukuf di Padang Arafah dilaksanakan pada 15 Mei 2027 bertepatan dengan 09 Dzulhijjah 1448 H.'
            ],
            [
                'id' => 3,
                'question' => 'Berdasarkan slide materi Pelatihan Petugas Haji (PPIH), jenis ibadah haji apakah yang HANYA BOLEH dilaksanakan oleh seluruh petugas PPIH?',
                'options' => [
                    'Haji Tamattu\' (Umrah terlebih dahulu, lalu bertahallul penuh)',
                    'Haji Ifrad (Haji terlebih dahulu tanpa umrah)',
                    'Haji Qiran (Ihram bersamaan tanpa tahallul)',
                    'Bebas memilih apa saja sesuai keinginan'
                ],
                'correct' => 'Haji Tamattu\' (Umrah terlebih dahulu, lalu bertahallul penuh)',
                'explanation' => 'Sesuai materi manasik PPIH, petugas hanya boleh melaksanakan Haji Tamattu\' agar setelah tahallul umrah dapat kembali bertugas melayani jemaah memakai seragam dinas tanpa terkendala larangan ihram.'
            ],
            [
                'id' => 4,
                'question' => 'Berdasarkan ketentuan Thawaf di Masjidil Haram, manakah yang merupakan salah satu LARANGAN THAWAF yang membatalkan putaran?',
                'options' => [
                    'Menyentuh dinding Ka\'bah & syazarwan (bibir pondasi Ka\'bah)',
                    'Memperpendek langkah kaki saat berthawaf',
                    'Berlari-lari kecil pada 3 putaran pertama bagi pria',
                    'Berdoa membaca Doa Sapu Jagat di antara Rukun Yamani & Hajar Aswad'
                ],
                'correct' => 'Menyentuh dinding Ka\'bah & syazarwan (bibir pondasi Ka\'bah)',
                'explanation' => 'Menyentuh dinding Ka\'bah atau syazarwan saat tawaf membatalkan putaran karena syazarwan termasuk pondasi Ka\'bah, sehingga orang yang menyentuhnya berada di atas/di dalam bagian Ka\'bah.'
            ],
            [
                'id' => 5,
                'question' => 'Berdasarkan adab dan hakikat Sa\'i, mengapa Sa\'i digolongkan sebagai ibadah TA\'ABBUDI?',
                'options' => [
                    'Karena merupakan bentuk ketaatan mutlak kepada Allah tanpa perlu dicari logika rasionalnya',
                    'Karena hanya boleh dilakukan saat matahari terbit',
                    'Karena harus diselesaikan dalam waktu kurang dari 15 menit',
                    'Karena wajib dalam keadaan suci dari hadats kecil dan besar'
                ],
                'correct' => 'Karena merupakan bentuk ketaatan mutlak kepada Allah tanpa perlu dicari logika rasionalnya',
                'explanation' => 'Ibadah Ta\'abbudi adalah amalan murni yang menekankan ketundukan dan ketaatan kepada perintah Allah di mana akal dan hawa nafsu tidak ikut campur menentukan sebab/alasannya.'
            ]
        ];
    }
}
