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
            'fiqh' => self::getFiqhData(),
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
            'subtitle' => 'Panduan Komprehensif Berdasarkan Al-Qur\'an, Sunnah Shahihah, Fiqih 4 Mazhab, & Regulasi Resmi Terkini',
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
                ['name' => 'Regulasi RI & Saudi', 'desc' => 'Aturan Kemenag RI, UU 8/2019, Smart Card Nusuk, dan regulasi Masyair.'],
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
                    'Bagi lansia, risti (risiko tinggi), dan wanita diperbolehkan melakukan murur (melintas di Muzdalifah di dalam bus) atas dasar fatwa kemaslahatan fiqih.',
                ],
                'doa' => 'رَبَّنَا آتِنَا فِي الدُّنْيَا حَسَنَةً وَفِي الآخِرَةِ حَسَنَةً وَقِنَا عَذَابَ النَّارِ',
                'doa_meaning' => 'Ya Tuhan kami, berilah kami kebaikan di dunia dan kebaikan di akhirat, dan lindungilah kami dari siksa api neraka.'
            ],
            [
                'day' => 'Hari 3',
                'date' => '10 Dzulhijjah (Hari Nahr / Idul Adha)',
                'location' => 'Mina & Masjidil Haram (Makkah)',
                'title' => 'Lempar Jumrah Aqabah, Hadyu, Tahallul & Tawaf Ifadhah',
                'badge' => 'Hari Paling Padat Amalan',
                'description' => 'Pagi hari 10 Dzulhijjah, jemaah dari Muzdalifah menuju Mina untuk melontar Jumrah Aqabah, menyembelih hewan dam/hadyu, bercukur (Tahallul Awwal), lalu ke Makkah untuk Tawaf Ifadhah dan Sa\'i (Tahallul Tsani).',
                'activities' => [
                    'Melontar Jumrah Aqabah (Kubra) dengan 7 batu kerikil secara bertahap sambil membaca: "Bismillāhi Allāhu Akbar" setiap lemparan. Hentikan talbiyah saat lontaran pertama.',
                    'Membayar/menyembelih hewan Dam Hadyu (bagi haji Tamattu\' dan Qiran) melalui lembaga resmi Adahi Kerajaan Arab Saudi.',
                    'Tahallul Awwal: Mencukur rambut (pria disunnahkan gundul/halq atau memendekkan/taqshir; wanita memotong ujung rambut sepanjang 2 cm). Seluruh larangan ihram gugur KECUALI hubungan suami-istri.',
                    'Menuju Masjidil Haram untuk melaksanakan Tawaf Ifadhah (7 putaran mengelilingi Ka\'bah) dan Sa\'i (7 kali dari bukit Shafa ke Marwah).',
                    'Tahallul Tsani: Setelah selesai Tawaf Ifadhah dan Sa\'i, seluruh larangan ihram halal kembali secara sempurna termasuk hubungan suami-istri.',
                ],
                'doa' => 'بِسْمِ اللَّهِ، اللَّهُ أَكْبَرُ، رَجْمًا لِلشَّيَاطِينِ وَرِضًا لِلرَّحْمَنِ',
                'doa_meaning' => 'Dengan nama Allah, Allah Maha Besar. Kutukan bagi setan dan keridhaan bagi Dzat Yang Maha Pengasih.'
            ],
            [
                'day' => 'Hari 4-6',
                'date' => '11, 12, dan 13 Dzulhijjah (Hari Tasyrik)',
                'location' => 'Mina (Jamarat)',
                'title' => 'Mabit di Mina & Melontar Tiga Jumrah (Ula, Wustha, Aqabah)',
                'badge' => 'WAJIB HAJI',
                'description' => 'Jemaah tinggal di tenda Mina untuk bermalam dan melontar 3 jumrah setiap siang setelah tergelincir matahari (ba\'da zawal). Jemaah dapat memilih menyelesaikan pada 12 Dzulhijjah (Nafar Awwal) atau 13 Dzulhijjah (Nafar Tsani).',
                'activities' => [
                    'Mabit di Mina pada malam 11 dan 12 Dzulhijjah (serta malam 13 bagi Nafar Tsani).',
                    'Melontar 3 Jumrah berurutan setelah waktu Zhuhur: 1) Jumrah Ula (7 batu), lalu berdoa; 2) Jumrah Wustha (7 batu), lalu berdoa; 3) Jumrah Aqabah (7 batu), langsung pergi tanpa berdoa di tempat.',
                    'Nafar Awwal: Meninggalkan Mina menuju Makkah pada 12 Dzulhijjah sebelum matahari terbenam (total melontar 49 kerikil).',
                    'Nafar Tsani: Tetap tinggal semalam lagi di Mina dan melontar pada 13 Dzulhijjah sebelum pulang (total melontar 70 kerikil - amalan lebih utama).',
                ],
                'doa' => 'اللَّهُمَّ اجْعَلْهُ حَجًّا مَبْرُورًا وَذَنْبًا مَغْفُورًا وَسَعْيًا مَشْكُورًا',
                'doa_meaning' => 'Ya Allah, jadikanlah hajiku ini haji yang mabrur, dosa yang diampuni, dan usaha yang disyukuri.'
            ],
            [
                'day' => 'Penutup',
                'date' => 'Sebelum Pulang ke Tanah Air / ke Madinah',
                'location' => 'Masjidil Haram (Ka\'bah)',
                'title' => 'Tawaf Wada\' (Tawaf Perpisahan)',
                'badge' => 'WAJIB HAJI',
                'description' => 'Tawaf 7 putaran mengelilingi Ka\'bah sebagai penghormatan terakhir sebelum meninggalkan kota suci Makkah. Tidak ada ibadah sa\'i setelah Tawaf Wada\'.',
                'activities' => [
                    'Dilakukan saat semua barang bawaan telah dikemas dan jemaah siap berangkat meninggalkan Makkah.',
                    'Melaksanakan tawaf 7 putaran mengitari Ka\'bah dengan penuh khusyuk.',
                    'Shalat sunnah tawaf 2 rakaat di belakang Maqam Ibrahim.',
                    'Wanita yang sedang haid atau nifas GUGUR kewajiban Tawaf Wada\'-nya dan tidak dikenakan denda/dam apapun sesuai sabda Rasulullah SAW.',
                ],
                'doa' => 'اللَّهُمَّ لَا تَجْعَلْ هَذَا آخِرَ الْعَهْدِ بِبَيْتِكَ الْحَرَامِ',
                'doa_meaning' => 'Ya Allah, janganlah Engkau jadikan kunjungan ini sebagai saat terakhir bagiku dengan Baitullah yang mulia.'
            ]
        ];
    }

    private static function getFiqhData(): array
    {
        return [
            'syarat' => [
                ['title' => 'Islam', 'desc' => 'Haji tidak sah dan tidak wajib bagi orang non-muslim.'],
                ['title' => 'Baligh (Dewasa)', 'desc' => 'Telah mencapai usia dewasa. Anak kecil yang berhaji tetap mendapat pahala, namun wajib mengulang haji saat dewasa.'],
                ['title' => 'Berakal Sehat', 'desc' => 'Tidak wajib bagi orang yang mengalami gangguan kejiwaan/hilang ingatan.'],
                ['title' => 'Merdeka', 'desc' => 'Bebas bukan sebagai budak.'],
                ['title' => 'Istitha\'ah (Mampu)', 'desc' => 'Mampu secara finansial (ongkos berangkat & nafkah keluarga yang ditinggalkan), fisik sehat (istitha\'ah kesehatan), aman dalam perjalanan, dan memiliki kuota/visa haji resmi.'],
            ],
            'rukun' => [
                ['num' => '1', 'name' => 'Niat Ihram', 'desc' => 'Berniat masuk ke dalam rangkaian ibadah haji di dalam hati disertai ucapan lisan.'],
                ['num' => '2', 'name' => 'Wukuf di Arafah', 'desc' => 'Hadir di padang Arafah pada waktu wukuf (9 Dzulhijjah Zhuhur s.d. Fajar 10 Dzulhijjah).'],
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
                ['num' => '6', 'name' => 'Tawaf Wada\'', 'desc' => 'Tawaf perpisahan sebelum meninggalkan Makkah al-Mukarramah.'],
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
                'title' => 'Niat Ihram Haji',
                'occasion' => 'Diucapkan saat berada di Miqat sebelum melewati batas tanah halal',
                'arabic' => 'لَبَّيْكَ اللَّهُمَّ حَجًّا، نَوَيْتُ الْحَجَّ وَأَحْرَمْتُ بِهِ لِلَّهِ تَعَالَى',
                'trans' => 'Labbaikallāhumma ḥajjan, nawaitul-ḥajja wa aḥramtu bihī lillāhi ta‘ālā',
                'meaning' => 'Aku penuhi panggilan-Mu ya Allah untuk berhaji. Aku niat berhaji dan berihram karena Allah Ta\'ala.',
                'audio' => 'Labbaika Allahumma hajjan'
            ],
            [
                'id' => 'p2',
                'title' => 'Bacaan Talbiyah Lengkap',
                'occasion' => 'Dilantunkan terus-menerus sejak berihram hingga melontar Jumrah Aqabah 10 Dzulhijjah',
                'arabic' => 'لَبَّيْكَ اللَّهُمَّ لَبَّيْكَ، لَبَّيْكَ لَا شَرِيكَ لَكَ لَبَّيْكَ، إِنَّ الْحَمْدَ وَالنِّعْمَةَ لَكَ وَالْمُلْكَ، لَا شَرِيكَ لَكَ',
                'trans' => 'Labbaikallāhumma labbaīk, labbaīka lā syarīka laka labbaīk, innal-ḥamda wan-ni‘mata laka wal-mulk, lā syarīka lak',
                'meaning' => 'Aku penuhi panggilan-Mu ya Allah, aku penuhi panggilan-Mu. Aku penuhi panggilan-Mu, tiada sekutu bagi-Mu, aku penuhi panggilan-Mu. Sesungguhnya segala puji, nikmat, dan kerajaan adalah milik-Mu, tiada sekutu bagi-Mu.',
                'audio' => 'Labbaika Allahumma labbaik, labbaika laa syariika laka labbaik'
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
                'authority' => 'Kementerian Agama Republik Indonesia (Kemenag RI) & BPKH',
                'legal_basis' => 'Undang-Undang Nomor 8 Tahun 2019 tentang Penyelenggaraan Ibadah Haji dan Umrah',
                'rules' => [
                    [
                        'topic' => 'Biaya Haji (BPIH & Bipih)',
                        'detail' => 'Biaya Penyelenggaraan Ibadah Haji (BPIH) terdiri dari Bipih (biaya yang dibayar langsung oleh jemaah) dan nilai manfaat dari pengelolaan dana haji oleh BPKH yang menanggung subsidi operasional pemondokan, konsumsi, dan tiket pesawat.'
                    ],
                    [
                        'topic' => 'Istitha\'ah Kesehatan (Syarat Mutlak Pelunasan)',
                        'detail' => 'Jemaah haji wajib dinyatakan lulus pemeriksaan kesehatan (Medical Check Up) oleh Dinas Kesehatan sebelum dapat melakukan pelunasan Bipih. Jemaah berstatus Penyakit Kronis stadium lanjut / gagal ginjal cuci darah / demensia berat tidak dapat diberangkatkan demi keselamatan jiwa.'
                    ],
                    [
                        'topic' => 'Pembagian Gelombang Keberangkatan',
                        'detail' => 'Gelombang I: Terbang dari embarkasi Indonesia mendarat di Bandara Amir Muhammad bin Abdul Aziz (AMAA) Madinah. Tinggal 8-9 hari untuk shalat Arbain dan ziarah, lalu berihram dari Bir Ali menuju Makkah. Gelombang II: Mendarat di Bandara Internasional King Abdulaziz (KAIA) Jeddah langsung mengenakan ihram dari embarkasi/pesawat di atas Yalamlam, melaksanakan haji di Makkah lebih dulu, baru ke Madinah setelah prosesi haji selesai.'
                    ],
                    [
                        'topic' => 'Struktur Kloter & Petugas Pendamping',
                        'detail' => 'Setiap kloter didampingi oleh: TPHI (Ketua Kloter administrasi), TPIHI (Pembimbing Ibadah), 3 Tenaga Medis TKHI (1 Dokter, 2 Perawat), serta didukung penuh oleh Panitia Penyelenggara Ibadah Haji (PPIH) Arab Saudi di sektor Makkah, Madinah, dan Armuzna.'
                    ],
                    [
                        'topic' => 'Gelang Logam Identitas Jemaah',
                        'detail' => 'Setiap jemaah RI wajib memakai gelang logam anti-karat berukir logo Garuda, nomor paspor, nama jemaah, nomor kloter, dan asal embarkasi. Gelang ini tahan api dan air, tidak boleh dilepas selama berada di tanah suci.'
                    ]
                ]
            ],
            'saudi' => [
                'authority' => 'Kementerian Haji dan Umrah Kerajaan Arab Saudi (Ministry of Hajj & Umrah KSA)',
                'legal_basis' => 'Peraturan Keselamatan & Sistem Digital Pelayanan Duyufurrahman (Tamu Allah)',
                'rules' => [
                    [
                        'topic' => 'Kartu Pintar Nusuk (Nusuk Smart Card)',
                        'detail' => 'Kartu fisik berteknologi chip RFID & barcode resmi dari Pemerintah Saudi yang wajib dikalungkan setiap jemaah. Berisi data visa haji resmi, nomor maktab, lokasi tenda di Mina/Arafah, serta menjadi kartu akses masuk wajib di pos pemeriksaan (checkpoint) Armuzna. Tanpa kartu Nusuk, jemaah dilarang memasuki area Masyair.'
                    ],
                    [
                        'topic' => 'Larangan Tegas Visa Non-Haji & Sanksi Berat',
                        'detail' => 'Kerajaan Arab Saudi melarang keras melaksanakan haji menggunakan visa ziarah, visa turis, visa pekerja, atau visa umrah. Sanksi hukum bagi pelanggar: denda 10.000 hingga 50.000 Riyal Saudi, penahanan, deportasi seketika, dan cekal masuk Arab Saudi selama 10 tahun.'
                    ],
                    [
                        'topic' => 'Sistem Jadwal Ketat Lontar Jamarat',
                        'detail' => 'Demi keselamatan dan pencegahan penumpukan jemaah (crowd control), lontar jumrah di Jamarat diatur dengan jadwal ketat per maktab. Jemaah dilarang melontar pada jam-jam puncak kepadatan (waktu terik siang 10 Dzulhijjah) dan wajib mematuhi pemandu jalur.'
                    ],
                    [
                        'topic' => 'Transportasi Bus Shalawat & Kereta Masyair',
                        'detail' => 'Saudi menyediakan layanan Bus Shalawat 24 jam berstiker bendera negara yang menghubungkan hotel jemaah di Makkah ke Terminal Masjidil Haram (Syib Amir, Jiad, Kudai), serta Mashaaer Railway (Kereta Cepat Masyair) antara Arafah-Muzdalifah-Mina.'
                    ],
                    [
                        'topic' => 'Ketentuan Bagasi & Larangan Air Zamzam di Koper',
                        'detail' => 'Koper bagasi maksimal 32 kg per jemaah dan tas kabin 7 kg. Maskapai penerbangan internasional dan otoritas GACA melarang keras memasukkan air zamzam ke dalam koper bagasi karena risiko rembes/bocor. Setiap jemaah resmi mendapat jatah 5 liter air zamzam gratis di bandara debarkasi kepulangan.'
                    ]
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
                'title' => 'Panduan Manasik Haji Lengkap Kementerian Agama RI',
                'source' => 'Ditjen PHU Kemenag RI',
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
                'question' => 'Jenis haji yang paling banyak dilaksanakan jemaah Indonesia karena mendahulukan Umrah baru kemudian berhaji adalah:',
                'options' => ['Haji Tamattu\'', 'Haji Ifrad', 'Haji Qiran', 'Haji Badal'],
                'correct' => 'Haji Tamattu\'',
                'explanation' => 'Haji Tamattu\' adalah mengerjakan Umrah di bulan haji lalu bertahallul bebas, kemudian pada 8 Dzulhijjah berihram haji. Pelakunya dikenakan Dam Nusuk.'
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
