<?php

namespace App\Services;

class HajjModuleService
{
    /**
     * Data Lengkap Modul Pembelajaran Ibadah Haji Terpadu
     */
    public static function getModuleData(): array
    {
        return [
            'overview' => self::getOverviewData(),
            'timeline' => self::getTimelineData(),
            'rph_timeline' => self::getRphTimelineData(),
            'fiqh' => self::getFiqhData(),
            'officer_fiqh' => self::getOfficerFiqhData(),
            'prayers' => self::getPrayersData(),
            'regulations' => self::getRegulationsData(),
            'officers_portal' => self::getOfficersPortalData(),
            'videos' => self::getVideoData(),
            'quiz' => self::getQuizData(),
        ];
    }

    private static function getOverviewData(): array
    {
        return [
            'title' => 'Modul Panduan & Manasik Ibadah Haji Terpadu',
            'subtitle' => 'Panduan Komprehensif Berdasarkan Al-Qur\'an, Sunnah Shahihah, Fiqih 4 Mazhab, & Regulasi Resmi Kementerian Haji dan Umrah RI',
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
                ['name' => '16 Doa Manasik', 'desc' => 'Teks Arab, transliterasi huruf abjad latin, arti bahasa Indonesia & audio asli.'],
                ['name' => 'Regulasi Kemenhaj RI', 'desc' => 'Perpres 92/2025, UU 8/2019 jo UU 14/2025, Siskohatkes, Bipih & Smart Card Nusuk.'],
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
                    'name' => 'Haji Tamattu\' (Paling Populer)',
                    'desc' => 'Mengerjakan Umrah terlebih dahulu di bulan-bulan haji (Syawal, Dzulqa\'dah, Dzulhijjah), bertahallul penuh (bisa melepas kain ihram dan hidup normal), kemudian pada 8 Dzulhijjah berihram kembali untuk ibadah Haji.',
                    'hukum_dam' => 'Wajib membayar Dam Nusuk (menyembelih 1 kambing atau puasa 3 hari di tanah suci + 7 hari di tanah air).',
                    'keunggulan' => 'Sangat praktis dan tidak memberatkan jemaah karena masa memakai ihram tidak terlalu lama.',
                ],
                [
                    'name' => 'Haji Ifrad',
                    'desc' => 'Berniat dan mengerjakan ibadah Haji terlebih dahulu hingga selesai seluruh rukun dan wajibnya pada 12 atau 13 Dzulhijjah, baru kemudian berihram untuk Umrah.',
                    'hukum_dam' => 'Tidak wajib membayar Dam.',
                    'keunggulan' => 'Sangat afdhal secara amalan mandiri, namun menuntut jemaah menjaga larangan ihram dalam waktu yang relatif panjang.',
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

    /**
     * Rencana Perjalanan Haji (RPH) Tahun 1448 H / 2027 M
     * Sumber: Keputusan Direktur Jenderal Pelayanan Haji No. 26 Tahun 2026, Kementerian Haji dan Umrah RI
     */
    private static function getRphTimelineData(): array
    {
        return [
            'document_title' => 'Rencana Perjalanan Haji (RPH) Tahun 1448 Hijriah / 2027 Masehi',
            'legal_reference' => 'Keputusan Direktur Jenderal Pelayanan Haji Nomor 26 Tahun 2026, Kementerian Haji dan Umrah Republik Indonesia',
            'drive_source_url' => 'https://drive.google.com/file/d/1QOF0RUCqNcrucc6ph_ShjTCJRMA3BI_6/view?usp=sharing',
            'operational_duration' => '40 Hari Masa Operasional Haji di Arab Saudi',
            'phases' => [
                [
                    'milestone' => 'Tahap 1: Masuk Asrama Haji',
                    'date_masehi' => '10 April 2027',
                    'date_hijriah' => '03 Dzulqa\'dah 1448 H',
                    'badge' => 'Embarkasi RI',
                    'summary' => 'Jemaah haji mulai masuk ke asrama haji embarkasi seluruh Indonesia untuk pemeriksaan akhir kesehatan (One Stop Service), pembagian paspor, gelang logam anti-karat, dan living cost (uang saku SAR).'
                ],
                [
                    'milestone' => 'Tahap 2: Keberangkatan Gelombang I (ke Madinah)',
                    'date_masehi' => '11 – 25 April 2027',
                    'date_hijriah' => '04 – 18 Dzulqa\'dah 1448 H',
                    'badge' => 'Gelombang I',
                    'summary' => 'Pemberangkatan jemaah haji Gelombang I dari Tanah Air langsung menuju Bandara AMAA Madinah untuk menunaikan Shalat Arbain (40 waktu di Masjid Nabawi) dan ziarah Raudhah.'
                ],
                [
                    'milestone' => 'Tahap 3: Pergerakan Gelombang I (Madinah ke Makkah)',
                    'date_masehi' => '20 April – 04 Mei 2027',
                    'date_hijriah' => '13 – 27 Dzulqa\'dah 1448 H',
                    'badge' => 'Miqat Bir Ali',
                    'summary' => 'Jemaah Gelombang I yang telah menyelesaikan Arbain diberangkatkan bergelombang dari Madinah ke Makkah, mengambil miqat dan berniat ihram di Masjid Dzulhulaifah (Bir Ali).'
                ],
                [
                    'milestone' => 'Tahap 4: Keberangkatan Gelombang II (ke Jeddah)',
                    'date_masehi' => '26 April – 10 Mei 2027',
                    'date_hijriah' => '19 Dzulqa\'dah – 04 Dzulhijjah 1448 H',
                    'badge' => 'Gelombang II',
                    'summary' => 'Pemberangkatan jemaah haji Gelombang II dari Tanah Air mendarat di Bandara KAIA Jeddah, berniat ihram di pesawat di atas Yalamlam / asrama embarkasi, langsung menuju Makkah untuk Umrah Wajib.'
                ],
                [
                    'milestone' => 'Tahap 5: Closing Date Bandara Arab Saudi',
                    'date_masehi' => '10 Mei 2027 (Pukul 24:00 WSA)',
                    'date_hijriah' => '04 Dzulhijjah 1448 H',
                    'badge' => 'Batas Akhir Masuk',
                    'summary' => 'Batas akhir (closing date) seluruh penerbangan jemaah haji internasional mendarat di Bandara King Abdul Aziz Jeddah dan Bandara AMAA Madinah.'
                ],
                [
                    'milestone' => 'Tahap 6: Pergerakan Menuju Arafah & Mina',
                    'date_masehi' => '14 Mei 2027',
                    'date_hijriah' => '08 Dzulhijjah 1448 H (Tarwiyah)',
                    'badge' => 'Pemberangkatan Armuzna',
                    'summary' => 'Jemaah haji Indonesia diberangkatkan dari hotel pemondokan Makkah menuju tenda Padang Arafah atau Mina dengan pengawalan Satgas Operasional Armuzna PPIH.'
                ],
                [
                    'milestone' => 'Tahap 7: Puncak Wukuf di Padang Arafah',
                    'date_masehi' => '15 Mei 2027',
                    'date_hijriah' => '09 Dzulhijjah 1448 H',
                    'badge' => 'Rukun Haji Akbar',
                    'summary' => 'Pelaksanaan puncak ibadah haji: Wukuf di Padang Arafah mulai tergelincir matahari (waktu Zhuhur) hingga terbenam matahari, dilanjutkan pergerakan mabit ke Muzdalifah.'
                ],
                [
                    'milestone' => 'Tahap 8: Hari Raya Idul Adha (Hari Nahr)',
                    'date_masehi' => '16 Mei 2027',
                    'date_hijriah' => '10 Dzulhijjah 1448 H',
                    'badge' => 'Nahr & Tahallul',
                    'summary' => 'Melontar Jumrah Aqabah 7 kerikil di Jamarat Mina, penyembelihan Dam Tamattu\' melalui Rumah Potong Hewan Adahi resmi, Tahallul Awwal, dan Tawaf Ifadhah di Masjidil Haram.'
                ],
                [
                    'milestone' => 'Tahap 9: Hari-Hari Tasyrik di Mina',
                    'date_masehi' => '17 – 19 Mei 2027',
                    'date_hijriah' => '11 – 13 Dzulhijjah 1448 H',
                    'badge' => 'Mabit & Jamarat',
                    'summary' => 'Bermalam (mabit) di tenda Mina dan melontar 3 jumrah (Ula, Wustha, Aqabah). Nafar Awwal selesai 12 Dzulhijjah (18 Mei), Nafar Tsani selesai 13 Dzulhijjah (19 Mei).'
                ],
                [
                    'milestone' => 'Tahap 10: Pemulangan Gelombang I (via Jeddah)',
                    'date_masehi' => '21 Mei – 04 Juni 2027',
                    'date_hijriah' => '15 – 29 Dzulhijjah 1448 H',
                    'badge' => 'Pemulangan Gel. I',
                    'summary' => 'Pemulangan jemaah haji Gelombang I dari Makkah setelah Tawaf Wada\' melalui Bandara Internasional King Abdul Aziz (KAIA) Jeddah kembali ke Tanah Air.'
                ],
                [
                    'milestone' => 'Tahap 11: Pergeseran Gelombang II (Makkah ke Madinah)',
                    'date_masehi' => '27 Mei – 11 Juni 2027',
                    'date_hijriah' => '21 Dzulhijjah 1448 H – 06 Muharram 1449 H',
                    'badge' => 'Arbain Gel. II',
                    'summary' => 'Pergerakan jemaah haji Gelombang II dari Makkah menuju Madinah al-Munawwarah untuk melaksanakan ibadah Shalat Arbain di Masjid Nabawi dan ziarah bersejarah.'
                ],
                [
                    'milestone' => 'Tahap 12: Pemulangan Gelombang II (via Madinah)',
                    'date_masehi' => '05 – 20 Juni 2027',
                    'date_hijriah' => '30 Dzulhijjah 1448 H – 15 Muharram 1449 H',
                    'badge' => 'Pemulangan Gel. II (Penutup)',
                    'summary' => 'Pemulangan jemaah haji Gelombang II dari Bandara AMAA Madinah menuju debarkasi masing-masing di Tanah Air. Operasional haji tahun 1448 H resmi berakhir.'
                ]
            ]
        ];
    }

    /**
     * Fiqih Petugas Haji: Riset Panduan Resmi Kementerian Agama & Kementerian Haji dan Umrah RI
     */
    private static function getOfficerFiqhData(): array
    {
        return [
            'title' => 'Fiqih Petugas Haji (Tuntunan Manasik Pelayan Dhuyufurrahman)',
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

    /**
     * Portal Pelatihan & Presensi Petugas Haji (PPIH) Kementerian Haji dan Umrah RI
     */
    private static function getOfficersPortalData(): array
    {
        return [
            'institution' => 'Kementerian Haji dan Umrah',
            'country' => 'REPUBLIK INDONESIA',
            'program_title' => 'Bimbingan Teknis (Bimtek) Terintegrasi Petugas Haji PPIH',
            'sample_officer' => [
                'registration_id' => '4858941',
                'name' => 'Alif Chandramaya',
                'officer_type' => 'PPIH Arab Saudi / PPIH Kloter Terintegrasi',
                'service_type' => 'Layanan Konsumsi & Akomodasi Masyair',
                'date' => '22-11-2026 · 10:25 WIB',
                'attendance_summary' => '2 dari 4 Sesi',
                'attended_sessions' => ['Sesi 1', 'Sesi 2'],
                'sessions_schedule' => [
                    ['session' => 'Sesi 1', 'class' => 'Kelas Besar', 'status' => 'ditutup 08:00', 'color' => 'bg-rose-950/70 text-rose-300 border-rose-800'],
                    ['session' => 'Sesi 2', 'class' => 'Kelas Besar', 'status' => 'ditutup 09:30', 'color' => 'bg-rose-950/70 text-rose-300 border-rose-800'],
                    ['session' => 'Sesi 3', 'class' => 'Kelas Besar', 'status' => 'buka 16:00', 'color' => 'bg-amber-950/70 text-amber-300 border-amber-800'],
                    ['session' => 'Sesi 4', 'class' => 'Kelas Tusi', 'status' => 'buka 19:30', 'color' => 'bg-amber-950/70 text-amber-300 border-amber-800'],
                ],
                'current_detail' => [
                    'session_title' => 'Sesi 1 (04:00-08:00)',
                    'subject' => 'Pendidikan Jasmani & Ketahanan Fisik Lapangan',
                    'class_name' => 'Kelas Besar',
                    'speaker' => 'Kolonel (Purn.) Muftiono',
                    'moderator' => 'Letkol (Purn.) Tulus Widodo',
                    'competencies' => [
                        'Bina fisik ketahanan cuaca ekstrem tanah suci (suhu 45°C - 50°C)',
                        'Protokol evakuasi jemaah tersesat dan crowd emergency di Mina-Jamarat',
                        'Kerjasama tim terintegrasi antar seksi tusi akomodasi, katering, dan linjam'
                    ]
                ]
            ],
            'tusi_categories' => [
                ['name' => 'Layanan Akomodasi', 'desc' => 'Penempatan hotel Makkah & Madinah, distribusi kunci, dan kelaikan fasilitas sanitasi.'],
                ['name' => 'Layanan Konsumsi', 'desc' => 'Standar higienitas 3x makan sehari bercita rasa nusantara & distribusi katering Armuzna.'],
                ['name' => 'Layanan Transportasi', 'desc' => 'Bus antarkota (Madinah-Makkah), Bus Shalawat 24 jam, dan armada feeder Masyair.'],
                ['name' => 'Bimbingan Ibadah (Bimbad)', 'desc' => 'Konsultasi manasik, safari wukuf lansia risti, dan penanganan kasus fiqih khusus.'],
                ['name' => 'Perlindungan Jemaah (Linjam)', 'desc' => 'Pengamanan sektor, sweeping jemaah terpisah, koordinasi Askar Saudi dan Maktab.'],
                ['name' => 'Layanan Lansia & Disabilitas', 'desc' => 'Pendampingan khusus kursi roda, tenda prioritas Arafah-Mina, dan skema murur.'],
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
                'question' => 'Kapan waktu pelaksanaan Wukuf di Padang Arafah yang sah menurut syariat?',
                'options' => [
                    'Mulai tergelincir matahari (Zhuhur) 9 Dzulhijjah hingga terbit fajar 10 Dzulhijjah',
                    'Sejak terbit matahari 8 Dzulhijjah hingga maghrib',
                    'Pada tanggal 10 Dzulhijjah setelah shalat Idul Adha',
                    'Sepanjang hari-hari Tasyrik (11-13 Dzulhijjah)'
                ],
                'correct' => 'Mulai tergelincir matahari (Zhuhur) 9 Dzulhijjah hingga terbit fajar 10 Dzulhijjah',
                'explanation' => 'Waktu wukuf sah dimulai sejak zawal (masuk waktu Zhuhur) 9 Dzulhijjah hingga fajar 10 Dzulhijjah.'
            ],
            [
                'id' => 3,
                'question' => 'Berdasarkan regulasi resmi Kementerian Haji dan Umrah RI, syarat mutlak sebelum jemaah dapat melakukan pelunasan Biaya Perjalanan Ibadah Haji (Bipih) adalah:',
                'options' => [
                    'Lulus verifikasi dan dinyatakan Memenuhi Syarat Istitha\'ah Kesehatan di Siskohatkes',
                    'Mengikuti bimbingan manasik minimal 20 kali',
                    'Memiliki paspor dengan masa berlaku minimal 3 bulan',
                    'Membayar asuransi penerbangan mandiri'
                ],
                'correct' => 'Lulus verifikasi dan dinyatakan Memenuhi Syarat Istitha\'ah Kesehatan di Siskohatkes',
                'explanation' => 'Sesuai regulasi Kemenhaj RI, status istitha\'ah kesehatan yang diterbitkan Dinas Kesehatan via Siskohatkes merupakan syarat mutlak sebelum pelunasan Bipih di bank persepsi.'
            ],
            [
                'id' => 4,
                'question' => 'Bagi wanita yang sedang mengalami haid atau nifas ketika hendak pulang meninggalkan Makkah, bagaimanakah status Tawaf Wada\'-nya?',
                'options' => [
                    'Gugur kewajibannya dan tidak wajib membayar Dam apapun',
                    'Wajib membayar denda menyembelih 1 ekor unta',
                    'Wajib menunggu di Makkah hingga suci bagaimanapun keadaannya',
                    'Hajinya batal dan harus mengulang tahun depan'
                ],
                'correct' => 'Gugur kewajibannya dan tidak wajib membayar Dam apapun',
                'explanation' => 'Rasulullah SAW memberi keringanan (rukhsah) bagi wanita haid/nifas untuk tidak melaksanakan Tawaf Wada\' tanpa denda apapun (HR. Bukhari & Muslim).'
            ],
            [
                'id' => 5,
                'question' => 'Kartu pintar resmi berteknologi RFID dari Pemerintah Arab Saudi yang wajib dimiliki jemaah untuk akses masuk Armuzna adalah:',
                'options' => ['Nusuk Smart Card', 'Hajj Passport Card', 'Iqama Gold Card', 'Saudi Green Pass'],
                'correct' => 'Nusuk Smart Card',
                'explanation' => 'Kartu Pintar Nusuk (Nusuk Smart Card) adalah identitas resmi digital yang diwajibkan Kementerian Haji Saudi untuk verifikasi visa haji resmi dan akses Armuzna.'
            ]
        ];
    }
}
