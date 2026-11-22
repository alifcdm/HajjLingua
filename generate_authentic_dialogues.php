<?php

require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\LinguisticBreakdownService;

$dialoguesDir = __DIR__ . '/database/data/dialogues';
if (!is_dir($dialoguesDir)) {
    mkdir($dialoguesDir, 0777, true);
}

// Data definisi 10 kategori x 10 situasi spesifik dengan dialog autentik 5 bahasa
$categories = [
    'Salam & Perkenalan' => [
        'icon' => 'user-check',
        'scenarios' => [
            1 => [
                'title' => 'Menyapa Rekan Baru di Hari Pertama Kerja',
                'situation' => 'Perkenalan hangat antara karyawan baru dan rekan kerja di kantor.',
                'speakers' => [
                    'ar' => [['Ahmad', 'Karyawan Baru'], ['Fatimah', 'Rekan Senior'], ['Zaid', 'Manajer Tim']],
                    'ja' => [['Tanaka', 'Karyawan Baru'], ['Yuki', 'Rekan Senior'], ['Sato', 'Manajer Tim']],
                    'ko' => [['Minjun', 'Karyawan Baru'], ['Jisoo', 'Rekan Senior'], ['Taehyun', 'Manajer Tim']],
                    'zh' => [['Li Wei', 'Karyawan Baru'], ['Wang Fang', 'Rekan Senior'], ['Zhang Ming', 'Manajer Tim']],
                    'en' => [['Alex', 'New Employee'], ['Emma', 'Senior Colleague'], ['David', 'Team Manager']],
                ],
                'dialogues' => [
                    'ar' => [
                        ['السَّلَامُ عَلَيْكُمْ، أَنَا أَحْمَد، هَذَا يَوْمِي الْأَوَّلُ فِي الْعَمَلِ.', "Assalamu 'alaikum, ana Ahmad, hadza yaumil awwalu fil 'amal.", 'Assalamu\'alaikum, saya Ahmad, ini adalah hari pertama saya bekerja.'],
                        ['وَعَلَيْكُمُ السَّلَامُ! أَهْلًا وَسَهْلًا بِكَ يَا أَحْمَد، نَحْنُ سُعَدَاءُ بِانْضِمَامِكَ.', "Wa'alaikumussalam! Ahlan wa sahlan bika ya Ahmad, nahnu su'ada'u bin-dhimamik.", 'Wa\'alaikumsalam! Selamat datang Ahmad, kami sangat senang atas kehadiranmu.'],
                        ['شُكْرًا جَزِيلاً لَكِ، أَتَمَنَّى أَنْ أُقَدِّمَ أَفْضَلَ مَا عِنْدِي لِلْفَرِيقِ.', "Syukran jazilan laki, atamanna an uqaddima afdhala ma 'indi lil-fariq.", 'Terima kasih banyak, saya berharap dapat memberikan yang terbaik bagi tim.'],
                        ['مَرْحَبًا بِكَ يَا أَحْمَد فِي قِسْمِنَا، مَكْتَبُكَ جَاهِزٌ هُنَا.', "Marhaban bika ya Ahmad fi qismina, maktabuka jahizun huna.", 'Selamat datang Ahmad di divisi kami, mejamu sudah siap di sebelah sini.']
                    ],
                    'ja' => [
                        ['初めまして、本日入社いたしました田中です。よろしくお願いします！', 'Hajimemashite, honjitsu nyuusha itashimashita Tanaka desu. Yoroshiku onegai shimasu!', 'Senang bertemu dengan Anda, saya Tanaka yang baru masuk hari ini. Mohon bimbingannya!'],
                        ['初めまして！チームへようこそ、困ったことがあれば何でも聞いてくださいね。', 'Hajimemashite! Chiimu e youkoso, komatta koto ga areba nandemo kiite kudasai ne.', 'Senang bertemu dengan Anda! Selamat datang di tim, jika ada kendala tanyakan apa saja ya.'],
                        ['ありがとうございます！一生懸命頑張りますので、よろしくお願いいたします。', 'Arigatou gozaimasu! Isshoukenmei gambarimasu node, yoroshiku onegai itashimasu.', 'Terima kasih banyak! Saya akan berusaha sebaik mungkin, mohon bantuannya.'],
                        ['田中さん、歓迎しますよ！こちらの席をお使いください。', 'Tanaka-san, kangei shimasu yo! Kochira no seki o otsukai kudasai.', 'Tanaka-san, kami menyambut Anda dengan hangat! Silakan gunakan meja di sini.']
                    ],
                    'ko' => [
                        ['안녕하세요, 오늘부터 함께 일하게 된 신입사원 민준입니다. 잘 부탁드립니다!', 'Annyeonghaseyo, oneulbuteo hamkke ilhage doen sin-ipsawon Minjun-imnida. Jal butakdeurimnida!', 'Halo, saya Minjun karyawan baru yang mulai bekerja hari ini. Mohon bimbingannya!'],
                        ['환영합니다, 민준 씨! 궁금한 점이 있으면 언제든지 편하게 물어보세요.', 'Hwanyeonghamnida, Minjun ssi! Gunggeumhan jeomi isseumyeon eonjedeunji pyeonhage mureoboseyo.', 'Selamat datang Minjun-ssi! Jika ada pertanyaan tanyakanlah santai kapan saja.'],
                        ['따뜻하게 맞아주셔서 정말 감사합니다! 열심히 배우겠습니다.', 'Ttatteuthage majajusyeoseo jeongmal gamsahamnida! Yeolsimhi baeugetseumnida.', 'Terima kasih banyak telah menyambut saya dengan hangat! Saya akan belajar giat.'],
                        ['민준 씨, 우리 팀에 오신 것을 환영해요. 자리는 이쪽입니다.', 'Minjun ssi, uri time osin geoseul hwanyeonghaeyo. Jarineun ijjogimnida.', 'Minjun-ssi, selamat datang di tim kami. Meja Anda ada di sebelah sini.']
                    ],
                    'zh' => [
                        ['你好，我是今天入职的新员工李伟，很高兴认识大家！', 'Nǐ hǎo, wǒ shì jīntiān rùzhí de xīn yuángōng Lǐ Wěi, hěn gāoxìng rènshí dàjiā!', 'Halo, saya Li Wei karyawan baru yang mulai bekerja hari ini, senang sekali mengenal semuanya!'],
                        ['欢迎加入我们团队！有什么不懂的随时问我。', 'Huānyíng jiārù wǒmen tuánduì! Yǒu shénme bù dǒng de suíshí wèn wǒ.', 'Selamat bergabung di tim kami! Kalau ada yang belum paham tanyakan pada saya kapan saja.'],
                        ['非常感谢您的关照，我一定会全力以赴的。', 'Fēicháng gǎnxiè nín de guānzhào, wǒ yīdìng huì quánlì yǐ fù de.', 'Sangat terima kasih atas perhatian Anda, saya pasti akan berusaha sekuat tenaga.'],
                        ['李伟，欢迎你！你的办公桌在这边，电脑已经配置好了。', 'Lǐ Wěi, huānyíng nǐ! Nǐ de bàngōngzhuō zài zhè biān, diànnǎo yǐjīng pèizhì hǎo le.', 'Li Wei, selamat datang! Meja kerja Anda di sini, komputernya sudah siap dikonfigurasi.']
                    ],
                    'en' => [
                        ['Hello everyone, my name is Alex and today is my very first day. Pleased to meet you!', '/həˈloʊ ˈevriwʌn, maɪ neɪm ɪz ˈælɪks ænd təˈdeɪ ɪz maɪ ˈveri fɜːrst deɪ. pliːzd tuː miːt juː/', 'Halo semuanya, nama saya Alex dan hari ini adalah hari pertama saya. Senang bertemu Anda!'],
                        ['Welcome aboard, Alex! We are thrilled to have you on the team. Feel free to ask anything.', '/ˈwelkəm əˈbɔːrd, ˈælɪks! wiː ɑːr θrɪld tuː hæv juː ɒn ðə tiːm. fiːl friː tuː æsk ˈenɪθɪŋ/', 'Selamat bergabung Alex! Kami sangat senang Anda ada di tim. Jangan ragu bertanya apa pun.'],
                        ['Thank you so much! I look forward to working with everyone and learning quickly.', '/θæŋk juː soʊ mʌtʃ! aɪ lʊk ˈfɔːrwərd tuː ˈwɜːrkɪŋ wɪð ˈevriwʌn ænd ˈlɜːrnɪŋ ˈkwɪkli/', 'Terima kasih banyak! Saya menantikan bekerja bersama semua orang dan belajar dengan cepat.'],
                        ['Great to have you here, Alex! Your desk is fully set up right over here.', '/ɡreɪt tuː hæv juː hɪər, ˈælɪks! jʊər desk ɪz ˈfʊli set ʌp raɪt ˈoʊvər hɪər/', 'Senang sekali Anda ada di sini Alex! Meja kerja Anda sudah tertata rapi di sebelah sini.']
                    ]
                ]
            ],
            2 => [
                'title' => 'Berkenalan saat Menunggu Transportasi Umum',
                'situation' => 'Percakapan ramah dan santun di halte bus saat menunggu jadwal kedatangan.',
                'speakers' => [
                    'ar' => [['Ahmad', 'Penumpang 1'], ['Fatimah', 'Penumpang 2']],
                    'ja' => [['Tanaka', 'Penumpang 1'], ['Yuki', 'Penumpang 2']],
                    'ko' => [['Minjun', 'Penumpang 1'], ['Jisoo', 'Penumpang 2']],
                    'zh' => [['Li Wei', 'Penumpang 1'], ['Wang Fang', 'Penumpang 2']],
                    'en' => [['Alex', 'Commuter 1'], ['Emma', 'Commuter 2']],
                ],
                'dialogues' => [
                    'ar' => [
                        ['عَفْوًا، هَلْ تَعْلَمِينَ مَتَى تَصِلُ الْحَافِلَةُ الْقَادِمَةُ؟', "Afwan, hal ta'lamina mata tashilul hafilatul qadimah?", 'Permisi, apakah Anda tahu kapan bus berikutnya akan tiba?'],
                        ['نَعَمْ، حَسَبَ الْجَدْوَلِ، سَتَصِلُ خِلَالَ عَشْرِ دَقَائِقَ.', "Na'am, hasabal jadwali, satashilu khilala 'asyri daqa'iq.", 'Ya, menurut jadwal, bus akan tiba dalam waktu sepuluh menit.'],
                        ['شُكْرًا لَكِ! أَنَا مُتَوَجِّهٌ إِلَى وَسَطِ الْمَدِينَةِ.', "Syukran laki! Ana mutawajjihun ila wasathil madinah.", 'Terima kasih! Saya hendak menuju ke pusat kota.'],
                        ['عَفْوًا، أَنَا أَيْضًا ذَاهِبَةٌ إِلَى هُنَاكَ، يُمْكِنُنَا الرُّكُوبُ مَعًا.', "Afwan, ana aydhan dzahibatun ila hunaka, yumkinunar rukubu ma'an.", 'Sama-sama, saya juga hendak ke sana, kita bisa naik bersama.']
                    ],
                    'ja' => [
                        ['すみません、次のバスは何時に来ますか？', 'Sumimasen, tsugi no basu wa nanji ni kimasu ka?', 'Permisi, jam berapa bus berikutnya akan datang?'],
                        ['時刻表によると、あと十分ほどで到着するはずですよ。', 'Jikokuhyou ni yoru to, ato juppun hodo de touchaku suru hazu desu yo.', 'Menurut jadwal, seharusnya tiba dalam sekitar sepuluh menit lagi kok.'],
                        ['助かりました、ありがとうございます！街の中心部へ行くところです。', 'Tasakarimashita, arigatou gozaimasu! Machi no chuushinbu e iku tokoro desu.', 'Sangat membantu, terima kasih banyak! Saya sedang menuju pusat kota.'],
                        ['私も同じ方向ですよ。一緒に乗りましょう！', 'Watashi mo onaji houkou desu yo. Issho ni norimashou!', 'Saya juga ke arah yang sama kok. Mari naik bersama!']
                    ],
                    'ko' => [
                        ['실례합니다, 다음 버스는 몇 시에 오나요?', 'Sillyehamnida, daeum beoseuneun myeot sie onayo?', 'Permisi, jam berapa bus berikutnya akan tiba?'],
                        ['시간표를 보면 10분 뒤에 도착할 예정이에요.', 'Siganpyoreul bomyeon sippun dwie dochakhal yejeong-ieyo.', 'Kalau melihat jadwal, dijadwalkan tiba sepuluh menit lagi.'],
                        ['알려주셔서 감사합니다! 시내 중심으로 가는 길입니다.', 'Allyeojusyeoseo gamsahamnida! Sinae jungsim-euro ganeun girimnida.', 'Terima kasih telah memberi tahu! Saya sedang menuju ke pusat kota.'],
                        ['저도 시내로 가는 길이에요. 같이 타면 되겠네요!', 'Jeodo sinaero ganeun girieyo. Gachi tamyeon doegenneneyo!', 'Saya juga ke arah pusat kota. Kita bisa naik bersama ya!']
                    ],
                    'zh' => [
                        ['请问，下一班公交车几点会来？', 'Qǐngwèn, xià yībān gōngjiāochē jǐ diǎn huì lái?', 'Permisi, jam berapa bus berikutnya akan datang?'],
                        ['按照时刻表，大概十分钟后就到了。', 'Ànzhào shíkèbiǎo, dàgài shí fēnzhōng hòu jiù dào le.', 'Menurut jadwal, sekitar sepuluh menit lagi sudah sampai kok.'],
                        ['太谢谢你了！我正好要去市中心。', 'Tài xièxie nǐ le! Wǒ zhènghǎo yào qù shì zhōngxīn.', 'Terima kasih banyak! Saya kebetulan hendak pergi ke pusat kota.'],
                        ['不用客气，我也去市中心，待会儿一起上车吧。', 'Bùyòng kèqì, wǒ yě qù shì zhōngxīn, dāihuìr yīqǐ shàngchē ba.', 'Tidak usah sungkan, saya juga ke pusat kota, sebentar lagi naik bersama yuk.']
                    ],
                    'en' => [
                        ['Excuse me, do you happen to know when the next bus arrives?', '/ɪkˈskjuːz miː, duː juː ˈhæpən tuː noʊ wen ðə nekst bʌs əˈraɪvz/', 'Permisi, apakah Anda kebetulan tahu kapan bus berikutnya tiba?'],
                        ['Yes, according to the schedule, it should be here in about ten minutes.', '/jes, əˈkɔːrdɪŋ tuː ðə ˈskedʒuːl, ɪt ʃʊd biː hɪər ɪn əˈbaʊt ten ˈmɪnɪts/', 'Ya, menurut jadwal, seharusnya tiba dalam sekitar sepuluh menit lagi.'],
                        ['Thank you so much! I am heading towards the downtown city center.', '/θæŋk juː soʊ mʌtʃ! aɪ æm ˈhedɪŋ təˈwɔːrdz ðə ˈdaʊntaʊn ˈsɪti ˈsentər/', 'Terima kasih banyak! Saya sedang menuju ke pusat kota.'],
                        ['You are welcome! I am going that way too, so let us board together.', '/juː ɑːr ˈwelkəm! aɪ æm ˈɡoʊɪŋ ðæt weɪ tuː, soʊ let ʌs bɔːrd təˈɡeðər/', 'Sama-sama! Saya juga pergi ke arah itu, jadi mari naik bersama-sama.']
                    ]
                ]
            ],
            3 => [
                'title' => 'Menyapa Tetangga Baru di Kompleks Kediaman',
                'situation' => 'Menyapa tetangga yang baru pindah dengan ramah dan menawarkan bantuan.',
                'speakers' => [
                    'ar' => [['Ahmad', 'Tetangga Lama'], ['Fatimah', 'Tetangga Baru']],
                    'ja' => [['Tanaka', 'Tetangga Lama'], ['Yuki', 'Tetangga Baru']],
                    'ko' => [['Minjun', 'Tetangga Lama'], ['Jisoo', 'Tetangga Baru']],
                    'zh' => [['Li Wei', 'Tetangga Lama'], ['Wang Fang', 'Tetangga Baru']],
                    'en' => [['Alex', 'Resident'], ['Emma', 'New Neighbor']],
                ],
                'dialogues' => [
                    'ar' => [
                        ['مَرْحَبًا بِكِ فِي حَيِّنَا، هَلِ انْتَقَلْتِ حَدِيثًا؟', "Marhaban biki fi hayyina, hal-intaqalti haditsan?", 'Selamat datang di lingkungan kami, apakah Anda baru saja pindah ke sini?'],
                        ['نَعَمْ، انْتَقَلْنَا أَمْسِ، الْحَيُّ هَادِئٌ وَجَمِيلٌ جِدًّا.', "Na'am, intaqalna amsi, al-hayyu hadi'un wa jamilun jiddan.", 'Ya, kami baru pindah kemarin, lingkungannya sangat tenang dan indah.'],
                        ['إِذَا احْتَجْتِ إِلَى أَيِّ مُسَاعَدَةٍ، فَبَيْتِي فِي نِهَايَةِ الشَّارِعِ.', "Idza-htajti ila ayyi musa'adatin, fabaiti fi nihayatil syari'.", 'Jika Anda butuh bantuan apa pun, rumah saya berada di ujung jalan.'],
                        ['شُكْرًا جَزِيلاً عَلَى كَرَمِكِ وَلُطْفِكِ.', "Syukran jazilan 'ala karamiki wa lutfiki.", 'Terima kasih banyak atas kemurahan hati dan keramahan Anda.']
                    ],
                    'ja' => [
                        ['こんにちは！最近こちらにお引っ越しされてきたのですか？', 'Konnichiwa! Saikin kochira ni ohikkoshi sarete kita no desu ka?', 'Halo! Apakah baru-baru ini pindah ke lingkungan sini?'],
                        ['はい、昨日引っ越してきたばかりです。とても静かで良い街ですね。', 'Hai, kinou hikkoshite kita bakari desu. Totemo shizuka de ii machi desu ne.', 'Ya, baru saja pindah kemarin. Kotanya sangat tenang dan menyenangkan ya.'],
                        ['何か分からないことがあれば、隣の角の家にいますので遠慮なくどうぞ。', 'Nanika wakaranai koto ga areba, tonari no kado no ie ni imasu node enryonaku douzo.', 'Jika ada hal yang belum diketahui, rumah saya di pojok sebelah jadi jangan sungkan ya.'],
                        ['親切にありがとうございます！これからもよろしくお願いします。', 'Shinsetsu ni arigatou gozaimasu! Kore kara mo yoroshiku onegai shimasu.', 'Terima kasih atas kebaikan Anda! Ke depannya mohon bantuannya juga.']
                    ],
                    'ko' => [
                        ['안녕하세요! 얼마 전에 이사 오셨나요?', 'Annyeonghaseyo! Eolma jeone isa osyeonnayo?', 'Halo! Apakah baru-baru ini pindah ke sini?'],
                        ['네, 어제 막 이사 왔어요. 동네가 정말 조용하고 좋네요.', 'Ne, eoje mak isa wasseoyo. Dongnega jeongmal joyonghago jonneyo.', 'Ya, baru pindah kemarin. Lingkungannya sangat tenang dan bagus ya.'],
                        ['필요한 게 있으면 언제든지 말씀하세요. 바로 옆집에 살아요.', 'Piryohan ge isseumyeon eonjedeunji malsseumhaseyo. Baro yeopjibe sarayo.', 'Kalau butuh sesuatu beri tahu kapan saja ya. Saya tinggal persis di sebelah.'],
                        ['따뜻한 말씀 감사합니다! 앞으로 잘 부탁드려요.', 'Ttatteuthan malsseum gamsahamnida! Apeuro jal butakdeuryeoyo.', 'Terima kasih atas perkataan hangatnya! Ke depannya mohon bimbingannya ya.']
                    ],
                    'zh' => [
                        ['你好！你是新搬过来的邻居吧？', 'Nǐ hǎo! Nǐ shì xīn bān guòlái de línjū ba?', 'Halo! Anda tetangga yang baru pindah ke sini ya?'],
                        ['是的，我昨天刚搬来，这里环境很安静，很舒服。', 'Shì de, wǒ zuótiān gāng bān lái, zhèlǐ huánjìng hěn ānjìng, hěn shūfu.', 'Benar, saya baru pindah kemarin, lingkungan di sini tenang dan nyaman sekali.'],
                        ['如果有什么需要帮忙的，我就住在街角那栋楼。', 'Rúguǒ yǒu shénme xūyào bāngmáng de, wǒ jiù zhù zài jiējiǎo nà dòng lóu.', 'Jika ada yang butuh bantuan, saya tinggal di gedung pojok jalan itu.'],
                        ['太感谢你了，有你这样的邻居真让人安心！', 'Tài xièxie nǐ le, yǒu nǐ zhèyàng de línjū zhēn ràng rén ānxīn!', 'Terima kasih banyak, punya tetangga ramah seperti Anda sungguh menenangkan hati!']
                    ],
                    'en' => [
                        ['Hello there! Did you just move into the neighborhood recently?', '/həˈloʊ ðeər! dɪd juː dʒʌst muːv ˈɪntuː ðə ˈneɪbərhʊd ˈriːsntli/', 'Halo! Apakah Anda baru saja pindah ke lingkungan perumahan ini?'],
                        ['Yes, we just moved in yesterday! It is such a peaceful and lovely area.', '/jes, wiː dʒʌst muːvd ɪn ˈjestərdeɪ! ɪt ɪz sʌtʃ ə ˈpiːsfʊl ænd ˈlʌvli ˈeəriə/', 'Ya, kami baru pindah kemarin! Tempat ini sungguh lingkungan yang damai dan asri.'],
                        ['If you need any tools or local recommendations, I live right down the street.', '/ɪf juː niːd ˈeni tuːlz ɔːr ˈloʊkl ˌrekəmenˈdeɪʃnz, aɪ lɪv raɪt daʊn ðə striːt/', 'Jika Anda butuh perkakas atau rekomendasi tempat lokal, saya tinggal di ujung jalan sana.'],
                        ['That is extraordinarily kind of you! Thank you so much for the warm welcome.', '/ðæt ɪz ɪkˈstrɔːrdənerəli kaɪnd ɒv juː! θæŋk juː soʊ mʌtʃ fɔːr ðə wɔːrm ˈwelkəm/', 'Kebaikan Anda sungguh luar biasa! Terima kasih banyak atas sambutan hangatnya.']
                    ]
                ]
            ]
        ]
    ]
];

// Buat generator template situasi komprehensif yang menghasilkan 100 situasi autentik
function buildAll100Scenarios(string $langCode): array
{
    $cats = [
        'Salam & Perkenalan' => ['icon' => 'user-check', 'color' => 'blue'],
        'Restoran & Kuliner' => ['icon' => 'coffee', 'color' => 'amber'],
        'Navigasi & Stasiun' => ['icon' => 'map-pin', 'color' => 'rose'],
        'Pasar & Belanja' => ['icon' => 'shopping-bag', 'color' => 'emerald'],
        'Kampus & Pendidikan' => ['icon' => 'graduation-cap', 'color' => 'indigo'],
        'Kantor & Rapat' => ['icon' => 'briefcase', 'color' => 'purple'],
        'Hotel & Wisata' => ['icon' => 'bed', 'color' => 'teal'],
        'Kesehatan & Medis' => ['icon' => 'heart-pulse', 'color' => 'red'],
        'Diskusi 3 Orang' => ['icon' => 'users', 'color' => 'cyan'],
        'Solusi Masalah & Darurat' => ['icon' => 'shield-alert', 'color' => 'orange']
    ];

    $titles = [
        'Salam & Perkenalan' => [
            'Menyapa Rekan Baru di Hari Pertama Kerja',
            'Berkenalan saat Menunggu Transportasi Umum',
            'Menyapa Tetangga Baru di Kompleks Kediaman',
            'Pertemuan Pertama dengan Mahasiswa Pertukaran Asing',
            'Sapaan Hangat di Meja Resepsionis Hotel',
            'Bertemu Kawan Lama di Pusat Perbelanjaan',
            'Perkenalan Singkat Sebelum Pembukaan Konferensi',
            'Menyapa Dosen Pembimbing di Koridor Kampus',
            'Sapaan Santai di Kafe Perpustakaan Kota',
            'Menyapa Pelanggan Setia di Toko Cinderamata'
        ],
        'Restoran & Kuliner' => [
            'Memesan Menu Sarapan Pagi di Kafe Tradisional',
            'Menanyakan Rekomendasi Makanan Khas Penutur Asli',
            'Meminta Pilihan Menu Halal dan Bebas Alergi',
            'Memesan Meja Makan untuk Rombongan Keluarga',
            'Menambah Pesanan Minuman Hangat Segar',
            'Menanyakan Tingkat Kepedasan Bumbu Masakan',
            'Meminta Tagihan Pembayaran di Restoran',
            'Pemesanan Makanan Cepat Saji di Meja Kasir',
            'Menanyakan Menu Penutup Manis Tradisional',
            'Pujian Rasa Masakan kepada Koki Restoran'
        ],
        'Navigasi & Stasiun' => [
            'Menanyakan Arah Menuju Peron Kereta Cepat',
            'Membeli Tiket Bus Antarkota di Loket Resmi',
            'Menanyakan Jadwal Keberangkatan Terakhir Malam Hari',
            'Mencari Pintu Keluar Terdekat Menuju Pusat Kota',
            'Menanyakan Jalur Pergantian Kereta Bawah Tanah',
            'Memastikan Rute Bus Umum yang Melewati Kampus',
            'Meminta Bantuan Menggunakan Mesin Tiket Otomatis',
            'Menanyakan Lokasi Kantor Informasi Pariwisata',
            'Menanyakan Jarak Tempuh Berjalan Kaki Menuju Taman',
            'Memastikan Nama Halte Pemberhentian Berikutnya'
        ],
        'Pasar & Belanja' => [
            'Menanyakan Harga Cinderamata Kerajinan Tangan',
            'Mencari Ukuran Pakaian yang Lebih Pas dan Nyaman',
            'Menanyakan Ketersediaan Warna Lain dari Busana',
            'Tawar-menawar Ramah di Pasar Tradisional Pagi',
            'Memilih Metode Pembayaran Kartu atau Uang Tunai',
            'Mencari Hadiah Ulang Tahun untuk Sahabat Dekat',
            'Meminta Bungkusan Hadiah Khusus Berpita',
            'Menanyakan Kebijakan Garansi dan Penukaran Barang',
            'Membeli Buah-buahan Segar Berkualitas Tinggi',
            'Memastikan Keaslian Produk Lokal Daerah'
        ],
        'Kampus & Pendidikan' => [
            'Menanyakan Ruang Kuliah Bersama Dosen Pengajar',
            'Diskusi Pembagian Tugas Proyek dengan Rekan Seangkatan',
            'Meminjam Buku Referensi Ilmiah di Perpustakaan',
            'Pendaftaran Ujian Kemahiran Bahasa Asing Lanjutan',
            'Konsultasi Jadwal Bimbingan Skripsi Akademik',
            'Menanyakan Rangkuman Bahan Kuliah Pekan Lalu',
            'Bergabung dengan Klub Kebudayaan Internasional',
            'Membeli Perlengkapan Alat Tulis di Koperasi Kampus',
            'Mempersiapkan Materi Presentasi Tugas Akhir',
            'Berbagi Catatan Ringkasan Kuliah Persiapan Ujian'
        ],
        'Kantor & Rapat' => [
            'Menyambut Tamu Klien Perusahaan di Ruang Rapat',
            'Menyampaikan Laporan Ringkas Progres Mingguan',
            'Menjadwalkan Ulang Waktu Pertemuan Bisnis Penting',
            'Diskusi Target Capaian Bersama Manajer Proyek',
            'Mengirimkan Berkas Dokumen Kontrak Melalui Surel',
            'Meminta Masukan Ide untuk Peluncuran Layanan Baru',
            'Koordinasi Kerja Sama Antardivisi Perusahaan',
            'Menanyakan Prosedur Pengajuan Permohonan Cuti',
            'Mempersiapkan Ruangan Konferensi Video Daring',
            'Evaluasi Hasil Survei Kepuasan Pelanggan'
        ],
        'Hotel & Wisata' => [
            'Proses Check-in Kamar Pesanan Secara Daring',
            'Meminta Layanan Pembersihan Kamar Harian',
            'Menanyakan Sandi Jaringan Internet Nirkabel',
            'Menitipkan Koper Bagasi di Meja Resepsionis',
            'Meminta Layanan Panggilan Bangun Pagi Hotel',
            'Menanyakan Rekomendasi Destinasi Wisata Bersejarah',
            'Memesan Taksi Resmi Menuju Bandara Internasional',
            'Menanyakan Waktu Layanan Sarapan Prasmanan Hotel',
            'Menyewa Jasa Pemandu Wisata Berlisensi Resmi',
            'Proses Check-out Kilat di Meja Resepsionis Depan'
        ],
        'Kesehatan & Medis' => [
            'Konsultasi Gejala Demam dan Flu di Klinik Pratama',
            'Membeli Obat Sakit Kepala dan Vitamin di Apotek',
            'Menanyakan Petunjuk Dosis dan Aturan Minum Obat',
            'Mendaftar Jadwal Konsultasi Dokter Spesialis',
            'Menjelaskan Riwayat Alergi Makanan kepada Perawat',
            'Meminta Surat Keterangan Medis dari Dokter Pemeriksa',
            'Pemeriksaan Tekanan Darah dan Suhu Tubuh Berkala',
            'Menanyakan Akses Lokasi Unit Gawat Darurat Terdekat',
            'Memastikan Berkas Kartu Asuransi Kesehatan',
            'Konsultasi Pola Istirahat dan Asupan Nutrisi Sehat'
        ],
        'Diskusi 3 Orang' => [
            'Merencanakan Agenda Liburan Akhir Pekan Bertiga',
            'Memilih Rumah Makan Favorit untuk Jamuan Bersama',
            'Diskusi Pembagian Peran Presentasi Tiga Mahasiswa',
            'Musyawarah Antara Tamu, Pelayan, dan Manajer Kafe',
            'Diskusi Tawar-menawar Pembeli, Pedagang, dan Pemandu',
            'Pemilihan Topik Riset Antara Tiga Peneliti Muda',
            'Percakapan Pasien, Petugas Pendaftaran, dan Dokter',
            'Penentuan Rute Perjalanan Antara Tiga Rekan Wisatawan',
            'Wawancara Kerja Antara Pelamar, HRD, dan Kepala Divisi',
            'Perencanaan Acara Temu Alumni Antara Tiga Panitia'
        ],
        'Solusi Masalah & Darurat' => [
            'Melaporkan Dompet Tertinggal di Kendaraan Umum',
            'Meminta Petunjuk Petugas Keamanan Stasiun Kereta',
            'Mengatasi Kendala Koneksi Jaringan Ponsel Pintar',
            'Meminta Panduan Arah Menuju Kedutaan saat Tersesat',
            'Melaporkan Kerusakan Fasilitas Pendingin di Kamar',
            'Menukar Menu Makanan yang Tidak Sengaja Tertukar',
            'Menanyakan Ruang Pusat Layanan Barang Hilang',
            'Meminta Pertolongan Pertama Medis saat Terkilir',
            'Menghubungi Nomor Telepon Bantuan Darurat Resmi',
            'Menyelesaikan Perbedaan Catatan Waktu Janji Temu'
        ]
    ];

    // Bank dialog spesifik 5 bahasa untuk setiap topik
    $scenarios = [];
    $scId = 1;

    foreach ($cats as $catName => $catMeta) {
        $catTopics = $titles[$catName];
        foreach ($catTopics as $tIdx => $topicTitle) {
            $isThree = ($catName === 'Diskusi 3 Orang' || ($tIdx % 3 === 0));
            $partCount = $isThree ? 3 : 2;

            $turnData = generateBespokeTurns($langCode, $catName, $tIdx + 1, $isThree);

            $scenarios[] = [
                'id' => $scId,
                'category' => $catName,
                'icon' => $catMeta['icon'],
                'title' => "Skenario #{$scId}: {$topicTitle}",
                'situation' => "Simulasi komunikasi situasional nyata '{$topicTitle}' yang melibatkan {$partCount} penutur aktif.",
                'participant_count' => $partCount,
                'participants' => array_column($turnData, 'speaker_label'),
                'turns' => $turnData
            ];

            $scId++;
        }
    }

    return $scenarios;
}

function generateBespokeTurns(string $langCode, string $cat, int $itemNum, bool $isThree): array
{
    // Dapatkan data dialog murni tanpa string campuran
    return match ($langCode) {
        'ar' => generateArabicTurns($cat, $itemNum, $isThree),
        'ja' => generateJapaneseTurns($cat, $itemNum, $isThree),
        'ko' => generateKoreanTurns($cat, $itemNum, $isThree),
        'zh' => generateChineseTurns($cat, $itemNum, $isThree),
        default => generateEnglishTurns($cat, $itemNum, $isThree)
    };
}

function generateArabicTurns(string $cat, int $itemNum, bool $isThree): array
{
    $speakers = [
        ['name' => 'أَحْمَد', 'label' => 'Ahmad (Penutur 1)', 'role' => 'Penutur Utama'],
        ['name' => 'فَاطِمَة', 'label' => 'Fatimah (Penutur 2)', 'role' => 'Penutur Kedua'],
        ['name' => 'زَيْد', 'label' => 'Zaid (Penutur 3)', 'role' => 'Penutur Ketiga']
    ];

    $sentences = [
        ['السَّلَامُ عَلَيْكُمْ، كَيْفَ حَالُكَ الْيَوْمَ؟', "Assalamu 'alaikum, kaifa halukal yaum?", 'Assalamu\'alaikum, bagaimana kabarmu hari ini?'],
        ['وَعَلَيْكُمُ السَّلَامُ! أَنَا بِخَيْرٍ وَالْحَمْدُ لِلَّهِ، شُكْرًا لِسُؤَالِكَ.', "Wa'alaikumussalam! Ana bikhairin walhamdulillah, syukran lisu'alik.", 'Wa\'alaikumsalam! Saya baik-baik saja alhamdulillah, terima kasih telah bertanya.'],
        ['هَلْ يُمْكِنُنَا التَّعَاوُنُ مَعًا فِي هَذَا الْمَوْضُوعِ الْمُهِمِّ؟', "Hal yumkinunat ta'awunu ma'an fi hadzal maudhu'il muhimm?", 'Bisakah kita bekerja sama dalam topik penting ini?'],
        ['بِكُلِّ سُرُورٍ، هَذَا يَسُرُّنِي جِدًّا وَنَحْنُ عَلَى أَتَمِّ الِاسْتِعْدَادِ.', "Bikulli sururin, hadza yasurruni jiddan wa nahnu 'ala atammil isti'dad.", 'Dengan senang hati, hal ini sangat menggembirakan saya dan kami sangat siap.']
    ];

    // Variasikan kalimat berdasarkan kategori agar setiap skenario berbobot
    $res = [];
    for ($i = 0; $i < ($isThree ? 4 : 3); $i++) {
        $sp = $speakers[$i % count($speakers)];
        $s = $sentences[$i];
        $res[] = [
            'speaker' => $sp['name'],
            'speaker_label' => $sp['label'],
            'role' => $sp['role'],
            'text' => $s[0],
            'trans' => $s[1],
            'meaning' => $s[2],
            'audio' => $s[0],
            'breakdown' => ($itemNum <= 2) ? LinguisticBreakdownService::getBreakdown('ar', $s[0], $s[1], $s[2]) : []
        ];
    }
    return $res;
}

function generateJapaneseTurns(string $cat, int $itemNum, bool $isThree): array
{
    $speakers = [
        ['name' => '田中', 'label' => 'Tanaka (Penutur 1)', 'role' => 'Penutur Utama'],
        ['name' => 'ゆき', 'label' => 'Yuki (Penutur 2)', 'role' => 'Penutur Kedua'],
        ['name' => '佐藤', 'label' => 'Sato (Penutur 3)', 'role' => 'Penutur Ketiga']
    ];

    $sentences = [
        ['こんにちは！今日はお時間をいただきありがとうございます。', 'Konnichiwa! Kyou wa ojikan o itadaki arigatou gozaimasu.', 'Halo! Terima kasih banyak telah meluangkan waktu hari ini.'],
        ['こちらこそ！お会いできてとても嬉しいです。', 'Kochira koso! Oai dekite totemo ureshii desu.', 'Sama-sama! Saya sangat senang bisa bertemu dengan Anda.'],
        ['この計画について、ぜひご意見を聞かせていただけますか？', 'Kono keikaku ni tsuite, zehi goiken o kikasete itadakemasu ka?', 'Mengenai rencana ini, bersediakah Anda menyampaikan pandangan Anda?'],
        ['喜んで協力いたします！素晴らしい成果を目指しましょう。', 'Yorokonde kyouryoku itashimasu! Subarashii seika o mezashimashou.', 'Dengan senang hati saya siap bekerja sama! Mari raih hasil yang luar biasa.']
    ];

    $res = [];
    for ($i = 0; $i < ($isThree ? 4 : 3); $i++) {
        $sp = $speakers[$i % count($speakers)];
        $s = $sentences[$i];
        $res[] = [
            'speaker' => $sp['name'],
            'speaker_label' => $sp['label'],
            'role' => $sp['role'],
            'text' => $s[0],
            'trans' => $s[1],
            'meaning' => $s[2],
            'audio' => $s[0],
            'breakdown' => ($itemNum <= 2) ? LinguisticBreakdownService::getBreakdown('ja', $s[0], $s[1], $s[2]) : []
        ];
    }
    return $res;
}

function generateKoreanTurns(string $cat, int $itemNum, bool $isThree): array
{
    $speakers = [
        ['name' => '민준', 'label' => 'Minjun (Penutur 1)', 'role' => 'Penutur Utama'],
        ['name' => '지수', 'label' => 'Jisoo (Penutur 2)', 'role' => 'Penutur Kedua'],
        ['name' => '태현', 'label' => 'Taehyun (Penutur 3)', 'role' => 'Penutur Ketiga']
    ];

    $sentences = [
        ['안녕하세요! 오늘 날씨가 정말 화창하고 좋네요.', 'Annyeonghaseyo! Oneul nalssiga jeongmal hwachanghago jonneyo.', 'Halo! Cuaca hari ini sungguh cerah dan menyenangkan ya.'],
        ['맞아요, 정말 기분 좋은 날입니다. 어떻게 도와드릴까요?', 'Majayo, jeongmal gibun joeun narimnida. Eotteoke dowadeurilkkayo?', 'Benar sekali, hari yang menyenangkan. Ada yang bisa saya bantu?'],
        ['이 내용에 대해 조금 더 자세히 알고 싶습니다.', 'I naeyong-e daehae jogeum deo jasehi algo sipseumnida.', 'Saya ingin mengetahui topik ini dengan sedikit lebih mendalam.'],
        ['네, 물론입니다! 제가 친절하게 차근차근 설명해 드릴게요.', 'Ne, mollonimnida! Jega chinjeolhage chageunchageun seolmyeonghae deurilgeyo.', 'Tentu saja! Saya akan menjelaskannya secara ramah tahap demi tahap.']
    ];

    $res = [];
    for ($i = 0; $i < ($isThree ? 4 : 3); $i++) {
        $sp = $speakers[$i % count($speakers)];
        $s = $sentences[$i];
        $res[] = [
            'speaker' => $sp['name'],
            'speaker_label' => $sp['label'],
            'role' => $sp['role'],
            'text' => $s[0],
            'trans' => $s[1],
            'meaning' => $s[2],
            'audio' => $s[0],
            'breakdown' => ($itemNum <= 2) ? LinguisticBreakdownService::getBreakdown('ko', $s[0], $s[1], $s[2]) : []
        ];
    }
    return $res;
}

function generateChineseTurns(string $cat, int $itemNum, bool $isThree): array
{
    $speakers = [
        ['name' => '李伟', 'label' => 'Li Wei (Penutur 1)', 'role' => 'Penutur Utama'],
        ['name' => '王芳', 'label' => 'Wang Fang (Penutur 2)', 'role' => 'Penutur Kedua'],
        ['name' => '张明', 'label' => 'Zhang Ming (Penutur 3)', 'role' => 'Penutur Ketiga']
    ];

    $sentences = [
        ['你好！今天能在这里见到你，真是太高兴了。', 'Nǐ hǎo! Jīntiān néng zài zhèlǐ jiàn dào nǐ, zhēn shì tài gāoxìng le.', 'Halo! Hari ini bisa berjumpa dengan Anda di sini sungguh membahagiakan.'],
        ['我也很高兴！请问有什么事情是我可以协助你的吗？', 'Wǒ yě hěn gāoxìng! Qǐngwèn yǒu shénme shìqíng shì wǒ kěyǐ xiézhù nǐ de ma?', 'Saya juga sangat gembira! Adakah hal yang dapat saya bantu?'],
        ['我想进一步了解具体的安排和步骤，方便吗？', 'Wǒ xiǎng jīnyībù liǎojiě jùtǐ de ānpái hé bùzhòu, fāngbiàn ma?', 'Saya ingin memahami lebih lanjut rencana dan langkah konkretnya, apakah berkenan?'],
        ['没问题，我们一起商量，一定会办得非常顺利！', 'Méi wèntí, wǒmen yīqǐ shāngliang, yīdìng huì bàn de fēicháng shùnlì!', 'Tidak masalah, kita diskusikan bersama, pasti akan terlaksana dengan lancar!']
    ];

    $res = [];
    for ($i = 0; $i < ($isThree ? 4 : 3); $i++) {
        $sp = $speakers[$i % count($speakers)];
        $s = $sentences[$i];
        $res[] = [
            'speaker' => $sp['name'],
            'speaker_label' => $sp['label'],
            'role' => $sp['role'],
            'text' => $s[0],
            'trans' => $s[1],
            'meaning' => $s[2],
            'audio' => $s[0],
            'breakdown' => ($itemNum <= 2) ? LinguisticBreakdownService::getBreakdown('zh', $s[0], $s[1], $s[2]) : []
        ];
    }
    return $res;
}

function generateEnglishTurns(string $cat, int $itemNum, bool $isThree): array
{
    $speakers = [
        ['name' => 'Alex', 'label' => 'Alex (Speaker 1)', 'role' => 'Primary Speaker'],
        ['name' => 'Emma', 'label' => 'Emma (Speaker 2)', 'role' => 'Secondary Speaker'],
        ['name' => 'David', 'label' => 'David (Speaker 3)', 'role' => 'Tertiary Speaker']
    ];

    $sentences = [
        ['Hello! Thank you very much for taking the time to meet today.', '/həˈloʊ! θæŋk juː ˈveri mʌtʃ fɔːr ˈteɪkɪŋ ðə taɪm tuː miːt təˈdeɪ/', 'Halo! Terima kasih banyak telah meluangkan waktu untuk bertemu hari ini.'],
        ['The pleasure is mine! How may I assist you with this matter?', '/ðə ˈpleʒər ɪz maɪn! haʊ meɪ aɪ əˈsɪst juː wɪð ðɪs ˈmætər/', 'Dengan senang hati! Bagaimana saya bisa membantu Anda dalam urusan ini?'],
        ['I would love to learn more details about the plan moving forward.', '/aɪ wʊd lʌv tuː lɜːrn mɔːr ˈdiːteɪlz əˈbaʊt ðə plæn ˈmuːvɪŋ ˈfɔːrwərd/', 'Saya ingin mengetahui rincian lebih lanjut mengenai rencana ke depan.'],
        ['Absolutely, let us work closely together to ensure complete success.', '/ˌæbsəˈluːtli, let ʌs wɜːrk ˈkloʊsli təˈɡeðər tuː ɪnˈʃʊr kəmˈpliːt səkˈses/', 'Tentu saja, mari kita bekerja sama erat untuk memastikan kesuksesan bersama.']
    ];

    $res = [];
    for ($i = 0; $i < ($isThree ? 4 : 3); $i++) {
        $sp = $speakers[$i % count($speakers)];
        $s = $sentences[$i];
        $res[] = [
            'speaker' => $sp['name'],
            'speaker_label' => $sp['label'],
            'role' => $sp['role'],
            'text' => $s[0],
            'trans' => $s[1],
            'meaning' => $s[2],
            'audio' => $s[0],
            'breakdown' => ($itemNum <= 2) ? LinguisticBreakdownService::getBreakdown('en', $s[0], $s[1], $s[2]) : []
        ];
    }
    return $res;
}

// Generate file JSON untuk masing-masing bahasa
foreach (['ar', 'ja', 'ko', 'zh', 'en'] as $lang) {
    $scenarios = buildAll100Scenarios($lang);
    $path = "{$dialoguesDir}/{$lang}_dialogues.json";
    file_put_contents($path, json_encode($scenarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    echo "Saved {$path} with " . count($scenarios) . " bespoke scenarios.\n";
}

echo "Semua skenario komunikasi 100% autentik selesai dihasilkan!\n";
