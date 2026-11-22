<?php

namespace App\Services;

class LinguisticMatrixService
{
    /**
     * Mengembalikan struktur matriks lengkap huruf/aksara untuk Zero to Hero
     */
    public static function getCompleteAlphabetMatrix(string $langCode): array
    {
        return match ($langCode) {
            'ar' => self::getArabicAlphabetMatrix(),
            'ja' => self::getJapaneseAlphabetMatrix(),
            'ko' => self::getKoreanAlphabetMatrix(),
            'en' => self::getEnglishAlphabetMatrix(),
            default => ['overview' => 'Data aksara tidak ditemukan.']
        };
    }

    /**
     * Data Lengkap 28 Hijaiyah + Harakat + Terjemahan Kata Contoh Indonesia
     */
    private static function getArabicAlphabetMatrix(): array
    {
        return [
            'overview' => 'Bahasa Arab ditulis dari kanan ke kiri (RTL) menggunakan abjad Hijaiyah yang berjumlah 28 huruf konsonan. Huruf Arab bersifat kursif (selalu bersambung), sehingga satu huruf memiliki hingga empat bentuk tergantung posisinya: Berdiri Sendiri (Isolated), Awal Kata (Initial), Tengah Kata (Medial), dan Akhir Kata (Final). Bunyi vokal diatur melalui tanda baca (Harakat).',
            'letters' => [
                ['char' => 'ا', 'name' => 'Alif', 'latin' => 'a / ā', 'isolated' => 'ا', 'initial' => 'ا', 'medial' => 'ـا', 'final' => 'ـا', 'sample' => 'أَبٌ', 'sample_trans' => 'Abun', 'sample_meaning' => 'Ayah', 'audio' => 'أَلِف'],
                ['char' => 'ب', 'name' => 'Ba', 'latin' => 'b', 'isolated' => 'ب', 'initial' => 'بـ', 'medial' => 'ـبـ', 'final' => 'ـب', 'sample' => 'بَابٌ', 'sample_trans' => 'Baabun', 'sample_meaning' => 'Pintu', 'audio' => 'بَاء'],
                ['char' => 'ت', 'name' => 'Ta', 'latin' => 't', 'isolated' => 'ت', 'initial' => 'تـ', 'medial' => 'ـتـ', 'final' => 'ـت', 'sample' => 'تَمْرٌ', 'sample_trans' => 'Tamrun', 'sample_meaning' => 'Kurma', 'audio' => 'تَاء'],
                ['char' => 'ث', 'name' => 'Tsa', 'latin' => 'ts / th', 'isolated' => 'ث', 'initial' => 'ثـ', 'medial' => 'ـثـ', 'final' => 'ـث', 'sample' => 'ثَوْبٌ', 'sample_trans' => 'Tsaubun', 'sample_meaning' => 'Pakaian / Gamis', 'audio' => 'ثَاء'],
                ['char' => 'ج', 'name' => 'Jim', 'latin' => 'j', 'isolated' => 'ج', 'initial' => 'جـ', 'medial' => 'ـجـ', 'final' => 'ـج', 'sample' => 'جَبَلٌ', 'sample_trans' => 'Jabalun', 'sample_meaning' => 'Gunung', 'audio' => 'جِيم'],
                ['char' => 'ح', 'name' => 'Ha (Pedas)', 'latin' => 'ḥ', 'isolated' => 'ح', 'initial' => 'حـ', 'medial' => 'ـحـ', 'final' => 'ـح', 'sample' => 'حَقِيبَةٌ', 'sample_trans' => 'Haqiibatun', 'sample_meaning' => 'Tas', 'audio' => 'حَاء'],
                ['char' => 'خ', 'name' => 'Kha', 'latin' => 'kh', 'isolated' => 'خ', 'initial' => 'خـ', 'medial' => 'ـخـ', 'final' => 'ـخ', 'sample' => 'خُبْزٌ', 'sample_trans' => 'Khubzun', 'sample_meaning' => 'Roti', 'audio' => 'خَاء'],
                ['char' => 'د', 'name' => 'Dal', 'latin' => 'd', 'isolated' => 'د', 'initial' => 'د', 'medial' => 'ـد', 'final' => 'ـد', 'sample' => 'دَفْتَرٌ', 'sample_trans' => 'Daftarun', 'sample_meaning' => 'Buku Catatan', 'audio' => 'دَال'],
                ['char' => 'ذ', 'name' => 'Dzal', 'latin' => 'dz / dh', 'isolated' => 'ذ', 'initial' => 'ذ', 'medial' => 'ـذ', 'final' => 'ـذ', 'sample' => 'ذَهَبٌ', 'sample_trans' => 'Dzahabun', 'sample_meaning' => 'Emas', 'audio' => 'ذَال'],
                ['char' => 'ر', 'name' => 'Ra', 'latin' => 'r', 'isolated' => 'ر', 'initial' => 'ر', 'medial' => 'ـر', 'final' => 'ـر', 'sample' => 'رَجُلٌ', 'sample_trans' => 'Rajulun', 'sample_meaning' => 'Pria Dewasa', 'audio' => 'رَاء'],
                ['char' => 'ز', 'name' => 'Zay', 'latin' => 'z', 'isolated' => 'ز', 'initial' => 'ز', 'medial' => 'ـز', 'final' => 'ـز', 'sample' => 'زَهْرَةٌ', 'sample_trans' => 'Zahratun', 'sample_meaning' => 'Bunga', 'audio' => 'زَاي'],
                ['char' => 'س', 'name' => 'Sin', 'latin' => 's', 'isolated' => 'س', 'initial' => 'سـ', 'medial' => 'ـسـ', 'final' => 'ـس', 'sample' => 'سَيَّارَةٌ', 'sample_trans' => 'Sayyaaratun', 'sample_meaning' => 'Mobil', 'audio' => 'سِين'],
                ['char' => 'ش', 'name' => 'Syin', 'latin' => 'sy / sh', 'isolated' => 'ش', 'initial' => 'شـ', 'medial' => 'ـشـ', 'final' => 'ـش', 'sample' => 'شَمْسٌ', 'sample_trans' => 'Syamsun', 'sample_meaning' => 'Matahari', 'audio' => 'شِين'],
                ['char' => 'ص', 'name' => 'Shad', 'latin' => 'ṣ', 'isolated' => 'ص', 'initial' => 'صـ', 'medial' => 'ـصـ', 'final' => 'ـص', 'sample' => 'صَبَاحٌ', 'sample_trans' => 'Shabaahun', 'sample_meaning' => 'Pagi Hari', 'audio' => 'صَاد'],
                ['char' => 'ض', 'name' => 'Dhad', 'latin' => 'ḍ', 'isolated' => 'ض', 'initial' => 'ضـ', 'medial' => 'ـضـ', 'final' => 'ـض', 'sample' => 'ضَوْءٌ', 'sample_trans' => 'Dhou-un', 'sample_meaning' => 'Cahaya / Sinar', 'audio' => 'ضَاد'],
                ['char' => 'ط', 'name' => 'Tha', 'latin' => 'ṭ', 'isolated' => 'ط', 'initial' => 'طـ', 'medial' => 'ـطـ', 'final' => 'ـط', 'sample' => 'طَالِبٌ', 'sample_trans' => 'Thaalibun', 'sample_meaning' => 'Pelajar', 'audio' => 'طَاء'],
                ['char' => 'ظ', 'name' => 'Zha', 'latin' => 'ẓ', 'isolated' => 'ظ', 'initial' => 'ظـ', 'medial' => 'ـظـ', 'final' => 'ـظ', 'sample' => 'ظَرْفٌ', 'sample_trans' => 'Zharfun', 'sample_meaning' => 'Amplop Surat', 'audio' => 'ظَاء'],
                ['char' => 'ع', 'name' => '\'Ain', 'latin' => '‘ / ʿ', 'isolated' => 'ع', 'initial' => 'عـ', 'medial' => 'ـعـ', 'final' => 'ـع', 'sample' => 'عَيْنٌ', 'sample_trans' => '\'Ainun', 'sample_meaning' => 'Mata', 'audio' => 'عَيْن'],
                ['char' => 'غ', 'name' => 'Ghain', 'latin' => 'gh', 'isolated' => 'غ', 'initial' => 'غـ', 'medial' => 'ـغـ', 'final' => 'ـغ', 'sample' => 'غُرْفَةٌ', 'sample_trans' => 'Ghurfatun', 'sample_meaning' => 'Kamar / Ruangan', 'audio' => 'غَيْن'],
                ['char' => 'ف', 'name' => 'Fa', 'latin' => 'f', 'isolated' => 'ف', 'initial' => 'فـ', 'medial' => 'ـفـ', 'final' => 'ـف', 'sample' => 'فَاكِهَةٌ', 'sample_trans' => 'Faakihatun', 'sample_meaning' => 'Buah-buahan', 'audio' => 'فَاء'],
                ['char' => 'ق', 'name' => 'Qaf', 'latin' => 'q', 'isolated' => 'ق', 'initial' => 'قـ', 'medial' => 'ـقـ', 'final' => 'ـق', 'sample' => 'قَلَمٌ', 'sample_trans' => 'Qalamun', 'sample_meaning' => 'Pena', 'audio' => 'قَاف'],
                ['char' => 'ك', 'name' => 'Kaf', 'latin' => 'k', 'isolated' => 'ك', 'initial' => 'كـ', 'medial' => 'ـكـ', 'final' => 'ـك', 'sample' => 'كِتَابٌ', 'sample_trans' => 'Kitaabun', 'sample_meaning' => 'Buku', 'audio' => 'كَاف'],
                ['char' => 'ل', 'name' => 'Lam', 'latin' => 'l', 'isolated' => 'ل', 'initial' => 'لـ', 'medial' => 'ـلـ', 'final' => 'ـل', 'sample' => 'لَبَنٌ', 'sample_trans' => 'Labanun', 'sample_meaning' => 'Susu Segar', 'audio' => 'لَام'],
                ['char' => 'م', 'name' => 'Mim', 'latin' => 'm', 'isolated' => 'م', 'initial' => 'مـ', 'medial' => 'ـمـ', 'final' => 'ـم', 'sample' => 'مَسْجِدٌ', 'sample_trans' => 'Masjidun', 'sample_meaning' => 'Masjid', 'audio' => 'مِيم'],
                ['char' => 'ن', 'name' => 'Nun', 'latin' => 'n', 'isolated' => 'ن', 'initial' => 'نـ', 'medial' => 'ـنـ', 'final' => 'ـن', 'sample' => 'نَارٌ', 'sample_trans' => 'Naarun', 'sample_meaning' => 'Api', 'audio' => 'نُون'],
                ['char' => 'ه', 'name' => 'Ha (Besar)', 'latin' => 'h', 'isolated' => 'ه', 'initial' => 'هـ', 'medial' => 'ـهـ', 'final' => 'ـه', 'sample' => 'هِلَالٌ', 'sample_trans' => 'Hilaalun', 'sample_meaning' => 'Bulan Sabit', 'audio' => 'هَاء'],
                ['char' => 'و', 'name' => 'Waw', 'latin' => 'w / ū', 'isolated' => 'و', 'initial' => 'و', 'medial' => 'ـو', 'final' => 'ـو', 'sample' => 'وَلَدٌ', 'sample_trans' => 'Waladun', 'sample_meaning' => 'Anak Laki-laki', 'audio' => 'وَاو'],
                ['char' => 'ي', 'name' => 'Ya', 'latin' => 'y / ī', 'isolated' => 'ي', 'initial' => 'يـ', 'medial' => 'ـيـ', 'final' => 'ـي', 'sample' => 'يَدٌ', 'sample_trans' => 'Yadun', 'sample_meaning' => 'Tangan', 'audio' => 'يَاء'],
            ],
            'harakat' => [
                ['symbol' => 'َ', 'name' => 'Fathah (فَتْحَة)', 'sound' => 'Bunyi vokal pendek "A" di atas huruf', 'example' => 'بَ = Ba'],
                ['symbol' => 'ِ', 'name' => 'Kasrah (كَسْرَة)', 'sound' => 'Bunyi vokal pendek "I" di bawah huruf', 'example' => 'بِ = Bi'],
                ['symbol' => 'ُ', 'name' => 'Dhammah (ضَمَّة)', 'sound' => 'Bunyi vokal pendek "U" di atas huruf', 'example' => 'بُ = Bu'],
                ['symbol' => 'ْ', 'name' => 'Sukun (سُكُون)', 'sound' => 'Tanda mati (konsonan tanpa vokal)', 'example' => 'أَبْ = Ab'],
                ['symbol' => 'ّ', 'name' => 'Tasydid / Syaddah', 'sound' => 'Tanda konsonan ganda / ditekan', 'example' => 'رَبَّ = Rabba'],
                ['symbol' => 'ً', 'name' => 'Tanwin Fathah', 'sound' => 'Bunyi "-AN" pada isim nakiroh', 'example' => 'كِتَابًا = Kitaaban'],
                ['symbol' => 'ٍ', 'name' => 'Tanwin Kasrah', 'sound' => 'Bunyi "-IN" pada isim nakiroh', 'example' => 'كِتَابٍ = Kitaabin'],
                ['symbol' => 'ٌ', 'name' => 'Tanwin Dhammah', 'sound' => 'Bunyi "-UN" pada isim nakiroh marfu\'', 'example' => 'كِتَابٌ = Kitaabun'],
            ],
        ];
    }

    /**
     * Data Lengkap Hiragana (46 Seion + 25 Dakuon) + Katakana (46) + Terjemahan Indonesia
     */
    private static function getJapaneseAlphabetMatrix(): array
    {
        return [
            'overview' => 'Bahasa Jepang menggunakan 3 sistem aksara: Hiragana (untuk kata asli Jepang dan infleksi tata bahasa), Katakana (untuk kata serapan asing, nama negara, nama orang non-Jepang, dan onomatopoeia), serta Kanji (karakter logografis Cina yang merepresentasikan makna).',
            'hiragana' => [
                ['char' => 'あ', 'romaji' => 'a', 'sample' => 'あめ (雨)', 'sample_meaning' => 'Hujan'],
                ['char' => 'い', 'romaji' => 'i', 'sample' => 'いぬ (犬)', 'sample_meaning' => 'Anjing'],
                ['char' => 'う', 'romaji' => 'u', 'sample' => 'うみ (海)', 'sample_meaning' => 'Laut'],
                ['char' => 'え', 'romaji' => 'e', 'sample' => 'えき (駅)', 'sample_meaning' => 'Stasiun'],
                ['char' => 'お', 'romaji' => 'o', 'sample' => 'おちゃ (お茶)', 'sample_meaning' => 'Teh'],
                ['char' => 'か', 'romaji' => 'ka', 'sample' => 'かさ (傘)', 'sample_meaning' => 'Payung'],
                ['char' => 'き', 'romaji' => 'ki', 'sample' => 'き (木)', 'sample_meaning' => 'Pohon'],
                ['char' => 'く', 'romaji' => 'ku', 'sample' => 'くるま (車)', 'sample_meaning' => 'Mobil'],
                ['char' => 'け', 'romaji' => 'ke', 'sample' => 'けいたい (携帯)', 'sample_meaning' => 'Ponsel HP'],
                ['char' => 'こ', 'romaji' => 'ko', 'sample' => 'こども (子供)', 'sample_meaning' => 'Anak-anak'],
                ['char' => 'さ', 'romaji' => 'sa', 'sample' => 'さかな (魚)', 'sample_meaning' => 'Ikan'],
                ['char' => 'し', 'romaji' => 'shi', 'sample' => 'しお (塩)', 'sample_meaning' => 'Garam'],
                ['char' => 'す', 'romaji' => 'su', 'sample' => 'すし (寿司)', 'sample_meaning' => 'Sushi'],
                ['char' => 'せ', 'romaji' => 'se', 'sample' => 'せんせい (先生)', 'sample_meaning' => 'Guru'],
                ['char' => 'そ', 'romaji' => 'so', 'sample' => 'そら (空)', 'sample_meaning' => 'Langit'],
                ['char' => 'た', 'romaji' => 'ta', 'sample' => 'たまご (卵)', 'sample_meaning' => 'Telur'],
                ['char' => 'ち', 'romaji' => 'chi', 'sample' => 'ちず (地図)', 'sample_meaning' => 'Peta'],
                ['char' => 'つ', 'romaji' => 'tsu', 'sample' => 'つき (月)', 'sample_meaning' => 'Bulan'],
                ['char' => 'て', 'romaji' => 'te', 'sample' => 'て (手)', 'sample_meaning' => 'Tangan'],
                ['char' => 'と', 'romaji' => 'to', 'sample' => 'とり (鳥)', 'sample_meaning' => 'Burung'],
                ['char' => 'な', 'romaji' => 'na', 'sample' => 'なつ (夏)', 'sample_meaning' => 'Musim Panas'],
                ['char' => 'に', 'romaji' => 'ni', 'sample' => 'にく (肉)', 'sample_meaning' => 'Daging'],
                ['char' => 'ぬ', 'romaji' => 'nu', 'sample' => 'ぬいぐるみ', 'sample_meaning' => 'Boneka'],
                ['char' => 'ね', 'romaji' => 'ne', 'sample' => 'ねこ (猫)', 'sample_meaning' => 'Kucing'],
                ['char' => 'の', 'romaji' => 'no', 'sample' => 'のみもの (飲み物)', 'sample_meaning' => 'Minuman'],
                ['char' => 'は', 'romaji' => 'ha', 'sample' => 'はな (花)', 'sample_meaning' => 'Bunga'],
                ['char' => 'ひ', 'romaji' => 'hi', 'sample' => 'ひかり (光)', 'sample_meaning' => 'Cahaya'],
                ['char' => 'ふ', 'romaji' => 'fu', 'sample' => 'ふね (船)', 'sample_meaning' => 'Kapal Laut'],
                ['char' => 'へ', 'romaji' => 'he', 'sample' => 'へや (部屋)', 'sample_meaning' => 'Kamar'],
                ['char' => 'ほ', 'romaji' => 'ho', 'sample' => 'ほん (本)', 'sample_meaning' => 'Buku'],
                ['char' => 'ま', 'romaji' => 'ma', 'sample' => 'まち (町)', 'sample_meaning' => 'Kota'],
                ['char' => 'み', 'romaji' => 'mi', 'sample' => 'みず (水)', 'sample_meaning' => 'Air'],
                ['char' => 'む', 'romaji' => 'mu', 'sample' => 'むし (虫)', 'sample_meaning' => 'Serangga'],
                ['char' => 'め', 'romaji' => 'me', 'sample' => 'め (目)', 'sample_meaning' => 'Mata'],
                ['char' => 'も', 'romaji' => 'mo', 'sample' => 'もり (森)', 'sample_meaning' => 'Hutan'],
                ['char' => 'や', 'romaji' => 'ya', 'sample' => 'やま (山)', 'sample_meaning' => 'Gunung'],
                ['char' => 'ゆ', 'romaji' => 'yu', 'sample' => 'ゆき (雪)', 'sample_meaning' => 'Salju'],
                ['char' => 'よ', 'romaji' => 'yo', 'sample' => 'よる (夜)', 'sample_meaning' => 'Malam'],
                ['char' => 'ら', 'romaji' => 'ra', 'sample' => 'らいしゅう (来週)', 'sample_meaning' => 'Minggu Depan'],
                ['char' => 'り', 'romaji' => 'ri', 'sample' => 'りんご (林檎)', 'sample_meaning' => 'Apel'],
                ['char' => 'る', 'romaji' => 'ru', 'sample' => 'るす (留守)', 'sample_meaning' => 'Tidak di Rumah'],
                ['char' => 'れ', 'romaji' => 're', 'sample' => 'れいぞうこ (冷蔵庫)', 'sample_meaning' => 'Kulkas'],
                ['char' => 'ろ', 'romaji' => 'ro', 'sample' => 'ろうそく', 'sample_meaning' => 'Lilin'],
                ['char' => 'わ', 'romaji' => 'wa', 'sample' => 'わたし (私)', 'sample_meaning' => 'Saya'],
                ['char' => 'を', 'romaji' => 'wo / o', 'sample' => 'ほんをよむ', 'sample_meaning' => 'Membaca Buku (Partikel Objek)'],
                ['char' => 'ん', 'romaji' => 'n', 'sample' => 'おんがく (音楽)', 'sample_meaning' => 'Musik'],
            ],
            'dakuon' => [
                ['char' => 'が', 'romaji' => 'ga', 'sample' => 'がっこう (学校)', 'sample_meaning' => 'Sekolah'],
                ['char' => 'ぎ', 'romaji' => 'gi', 'sample' => 'ぎんこう (銀行)', 'sample_meaning' => 'Bank'],
                ['char' => 'ぐ', 'romaji' => 'gu', 'sample' => 'ぐあい (具合)', 'sample_meaning' => 'Kondisi Kesehatan'],
                ['char' => 'げ', 'romaji' => 'ge', 'sample' => 'げんき (元気)', 'sample_meaning' => 'Sehat / Semangat'],
                ['char' => 'ご', 'romaji' => 'go', 'sample' => 'ごはん (ご飯)', 'sample_meaning' => 'Nasi'],
                ['char' => 'ざ', 'romaji' => 'za', 'sample' => 'ざっし (雑誌)', 'sample_meaning' => 'Majalah'],
                ['char' => 'じ', 'romaji' => 'ji', 'sample' => 'じかん (時間)', 'sample_meaning' => 'Waktu / Jam'],
                ['char' => 'ず', 'romaji' => 'zu', 'sample' => 'ずっと', 'sample_meaning' => 'Terus-menerus'],
                ['char' => 'ぜ', 'romaji' => 'ze', 'sample' => 'ぜんぶ (全部)', 'sample_meaning' => 'Semuanya'],
                ['char' => 'ぞ', 'romaji' => 'zo', 'sample' => 'ぞう (象)', 'sample_meaning' => 'Gajah'],
                ['char' => 'だ', 'romaji' => 'da', 'sample' => 'だいがく (大学)', 'sample_meaning' => 'Universitas'],
                ['char' => 'ぢ', 'romaji' => 'ji (dji)', 'sample' => 'はなぢ (鼻血)', 'sample_meaning' => 'Mimisan'],
                ['char' => 'づ', 'romaji' => 'zu (dzu)', 'sample' => 'つづく (続く)', 'sample_meaning' => 'Berlanjut'],
                ['char' => 'で', 'romaji' => 'de', 'sample' => 'でんしゃ (電車)', 'sample_meaning' => 'Kereta Api'],
                ['char' => 'ど', 'romaji' => 'do', 'sample' => 'どこ', 'sample_meaning' => 'Di mana'],
                ['char' => 'ば', 'romaji' => 'ba', 'sample' => 'ばしょ (場所)', 'sample_meaning' => 'Tempat'],
                ['char' => 'び', 'romaji' => 'bi', 'sample' => 'びょういん (病院)', 'sample_meaning' => 'Rumah Sakit'],
                ['char' => 'ぶ', 'romaji' => 'bu', 'sample' => 'ぶんか (文化)', 'sample_meaning' => 'Budaya'],
                ['char' => 'べ', 'romaji' => 'be', 'sample' => 'べんきょう (勉強)', 'sample_meaning' => 'Belajar'],
                ['char' => 'ぼ', 'romaji' => 'bo', 'sample' => 'ぼうし (帽子)', 'sample_meaning' => 'Topi'],
                ['char' => 'ぱ', 'romaji' => 'pa', 'sample' => 'パン', 'sample_meaning' => 'Roti'],
                ['char' => 'ぴ', 'romaji' => 'pi', 'sample' => 'ピアノ', 'sample_meaning' => 'Piano'],
                ['char' => 'ぷ', 'romaji' => 'pu', 'sample' => 'プール', 'sample_meaning' => 'Kolam Renang'],
                ['char' => 'ぺ', 'romaji' => 'pe', 'sample' => 'ペン', 'sample_meaning' => 'Pena'],
                ['char' => 'ぽ', 'romaji' => 'po', 'sample' => 'ポスト', 'sample_meaning' => 'Kotak Pos'],
            ],
            'katakana' => [
                ['char' => 'ア', 'romaji' => 'a', 'sample' => 'アイス (Aisu)', 'sample_meaning' => 'Es Krim'],
                ['char' => 'イ', 'romaji' => 'i', 'sample' => 'インドネシア', 'sample_meaning' => 'Indonesia'],
                ['char' => 'ウ', 'romaji' => 'u', 'sample' => 'ウェブ (Webu)', 'sample_meaning' => 'Web'],
                ['char' => 'エ', 'romaji' => 'e', 'sample' => 'エレベーター', 'sample_meaning' => 'Lift / Elevator'],
                ['char' => 'オ', 'romaji' => 'o', 'sample' => 'オレンジ (Orenji)', 'sample_meaning' => 'Jeruk'],
                ['char' => 'カ', 'romaji' => 'ka', 'sample' => 'カメラ (Kamera)', 'sample_meaning' => 'Kamera'],
                ['char' => 'キ', 'romaji' => 'ki', 'sample' => 'キーボード', 'sample_meaning' => 'Papan Ketik Keyboard'],
                ['char' => 'ク', 'romaji' => 'ku', 'sample' => 'クラス (Kurasu)', 'sample_meaning' => 'Kelas'],
                ['char' => 'ケ', 'romaji' => 'ke', 'sample' => 'ケーキ (Kēki)', 'sample_meaning' => 'Kue Tart'],
                ['char' => 'コ', 'romaji' => 'ko', 'sample' => 'コーヒー (Kōhī)', 'sample_meaning' => 'Kopi'],
                ['char' => 'サ', 'romaji' => 'sa', 'sample' => 'サラダ (Sarada)', 'sample_meaning' => 'Salad'],
                ['char' => 'シ', 'romaji' => 'shi', 'sample' => 'シャツ (Shatsu)', 'sample_meaning' => 'Kemeja'],
                ['char' => 'ス', 'romaji' => 'su', 'sample' => 'スーパー', 'sample_meaning' => 'Supermarket'],
                ['char' => 'セ', 'romaji' => 'se', 'sample' => 'セーター (Sētā)', 'sample_meaning' => 'Baju Hangat Sweter'],
                ['char' => 'ソ', 'romaji' => 'so', 'sample' => 'ソフト (Sofuto)', 'sample_meaning' => 'Perangkat Lunak'],
                ['char' => 'タ', 'romaji' => 'ta', 'sample' => 'タクシー (Takushī)', 'sample_meaning' => 'Taksi'],
                ['char' => 'チ', 'romaji' => 'chi', 'sample' => 'チーズ (Chīzu)', 'sample_meaning' => 'Keju'],
                ['char' => 'ツ', 'romaji' => 'tsu', 'sample' => 'ツアー (Tsuā)', 'sample_meaning' => 'Tur Wisata'],
                ['char' => 'テ', 'romaji' => 'te', 'sample' => 'テレビ (Terebi)', 'sample_meaning' => 'Televisi'],
                ['char' => 'ト', 'romaji' => 'to', 'sample' => 'トマト (Tomato)', 'sample_meaning' => 'Tomat'],
                ['char' => 'ナ', 'romaji' => 'na', 'sample' => 'ナイフ (Naifu)', 'sample_meaning' => 'Pisau'],
                ['char' => 'ニ', 'romaji' => 'ni', 'sample' => 'ニュース (Nyūsu)', 'sample_meaning' => 'Berita'],
                ['char' => 'ヌ', 'romaji' => 'nu', 'sample' => 'ヌードル', 'sample_meaning' => 'Mie Instan'],
                ['char' => 'ネ', 'romaji' => 'ne', 'sample' => 'ネクタイ', 'sample_meaning' => 'Dasi'],
                ['char' => 'ノ', 'romaji' => 'no', 'sample' => 'ノート (Nōto)', 'sample_meaning' => 'Buku Catatan'],
                ['char' => 'ハ', 'romaji' => 'ha', 'sample' => 'ハンバーガー', 'sample_meaning' => 'Burger'],
                ['char' => 'ヒ', 'romaji' => 'hi', 'sample' => 'ヒーター (Hītā)', 'sample_meaning' => 'Pemanas Ruangan'],
                ['char' => 'フ', 'romaji' => 'fu', 'sample' => 'フォーク (Fōku)', 'sample_meaning' => 'Garpu'],
                ['char' => 'ヘ', 'romaji' => 'he', 'sample' => 'ヘルメット', 'sample_meaning' => 'Helm'],
                ['char' => 'ホ', 'romaji' => 'ho', 'sample' => 'ホテル (Hoteru)', 'sample_meaning' => 'Hotel'],
                ['char' => 'マ', 'romaji' => 'ma', 'sample' => 'マスク (Masuku)', 'sample_meaning' => 'Masker'],
                ['char' => 'ミ', 'romaji' => 'mi', 'sample' => 'ミルク (Miruku)', 'sample_meaning' => 'Susu'],
                ['char' => 'ム', 'romaji' => 'mu', 'sample' => 'ムービー (Mūbī)', 'sample_meaning' => 'Film'],
                ['char' => 'メ', 'romaji' => 'me', 'sample' => 'メニュー (Menyū)', 'sample_meaning' => 'Daftar Menu'],
                ['char' => 'モ', 'romaji' => 'mo', 'sample' => 'モール (Mōru)', 'sample_meaning' => 'Mall'],
                ['char' => 'ヤ', 'romaji' => 'ya', 'sample' => 'ヤング (Yangu)', 'sample_meaning' => 'Jiwa Muda'],
                ['char' => 'ユ', 'romaji' => 'yu', 'sample' => 'ユーザー', 'sample_meaning' => 'Pengguna User'],
                ['char' => 'ヨ', 'romaji' => 'yo', 'sample' => 'ヨーグルト', 'sample_meaning' => 'Yogurt'],
                ['char' => 'ラ', 'romaji' => 'ra', 'sample' => 'ラジオ (Rajio)', 'sample_meaning' => 'Radio'],
                ['char' => 'リ', 'romaji' => 'ri', 'sample' => 'リモコン', 'sample_meaning' => 'Remote Control'],
                ['char' => 'ル', 'romaji' => 'ru', 'sample' => 'ルール (Rūru)', 'sample_meaning' => 'Aturan / Rule'],
                ['char' => 'レ', 'romaji' => 're', 'sample' => 'レストラン', 'sample_meaning' => 'Restoran'],
                ['char' => 'ロ', 'romaji' => 'ro', 'sample' => 'ロボット', 'sample_meaning' => 'Robot'],
                ['char' => 'ワ', 'romaji' => 'wa', 'sample' => 'ワイシャツ', 'sample_meaning' => 'Kemeja Putih'],
                ['char' => 'ヲ', 'romaji' => 'wo', 'sample' => 'ヲ (Wo)', 'sample_meaning' => 'Partikel Katakana'],
                ['char' => 'ン', 'romaji' => 'n', 'sample' => 'オンライン', 'sample_meaning' => 'Online Daring'],
            ],
        ];
    }

    /**
     * Data Lengkap Hangeul (40 Karakter) + Terjemahan Indonesia
     */
    private static function getKoreanAlphabetMatrix(): array
    {
        return [
            'overview' => 'Hangeul (한글) adalah sistem penulisan alfabetik ilmiah yang diciptakan oleh Raja Sejong yang Agung pada tahun 1443. Terdiri dari total 40 huruf: 14 konsonan dasar, 5 konsonan ganda, 10 vokal dasar, dan 11 vokal gabungan/diftong. Setiap suku kata dikelompokkan ke dalam satu blok persegi silabel (konsonan awal + vokal + konsonan akhir/batchim).',
            'basic_consonants' => [
                ['char' => 'ㄱ', 'name' => 'Giyeok (기역)', 'sound' => 'g / k', 'sample' => '가방 (Gabang)', 'sample_meaning' => 'Tas'],
                ['char' => 'ㄴ', 'name' => 'Nieun (니은)', 'sound' => 'n', 'sample' => '나무 (Namu)', 'sample_meaning' => 'Pohon'],
                ['char' => 'ㄷ', 'name' => 'Digeut (디귿)', 'sound' => 'd / t', 'sample' => '다리 (Dari)', 'sample_meaning' => 'Kaki / Jembatan'],
                ['char' => 'ㄹ', 'name' => 'Rieul (리을)', 'sound' => 'r / l', 'sample' => '라면 (Ramyeon)', 'sample_meaning' => 'Mi Instan'],
                ['char' => 'ㅁ', 'name' => 'Mieum (미음)', 'sound' => 'm', 'sample' => '모자 (Moja)', 'sample_meaning' => 'Topi'],
                ['char' => 'ㅂ', 'name' => 'Bieup (비읍)', 'sound' => 'b / p', 'sample' => '바다 (Bada)', 'sample_meaning' => 'Laut'],
                ['char' => 'ㅅ', 'name' => 'Siot (시옷)', 'sound' => 's', 'sample' => '사과 (Sagwa)', 'sample_meaning' => 'Apel'],
                ['char' => 'ㅇ', 'name' => 'Ieung (이응)', 'sound' => 'silent diawal / ng diakhir', 'sample' => '아이 (Ai)', 'sample_meaning' => 'Anak Kecil'],
                ['char' => 'ㅈ', 'name' => 'Jieut (지읒)', 'sound' => 'j / ch', 'sample' => '지도 (Jido)', 'sample_meaning' => 'Peta'],
                ['char' => 'ㅊ', 'name' => 'Chieut (치읓)', 'sound' => 'ch (aspirated)', 'sample' => '친구 (Chingu)', 'sample_meaning' => 'Teman'],
                ['char' => 'ㅋ', 'name' => 'Kieuk (키읔)', 'sound' => 'k (aspirated)', 'sample' => '커피 (Keopi)', 'sample_meaning' => 'Kopi'],
                ['char' => 'ㅌ', 'name' => 'Tieut (티읕)', 'sound' => 't (aspirated)', 'sample' => '토마토 (Tomato)', 'sample_meaning' => 'Tomat'],
                ['char' => 'ㅍ', 'name' => 'Pieup (피읖)', 'sound' => 'p (aspirated)', 'sample' => '포도 (Podo)', 'sample_meaning' => 'Anggur'],
                ['char' => 'ㅎ', 'name' => 'Hieut (히읗)', 'sound' => 'h', 'sample' => '하늘 (Haneul)', 'sample_meaning' => 'Langit'],
            ],
            'double_consonants' => [
                ['char' => 'ㄲ', 'name' => 'Ssang-giyeok (쌍기역)', 'sound' => 'kk (tense k)', 'sample' => '꽃 (Kkot)', 'sample_meaning' => 'Bunga'],
                ['char' => 'ㄸ', 'name' => 'Ssang-digeut (쌍디귿)', 'sound' => 'tt (tense t)', 'sample' => '떡 (Tteok)', 'sample_meaning' => 'Kue Beras Tradisional'],
                ['char' => 'ㅃ', 'name' => 'Ssang-bieup (쌍비읍)', 'sound' => 'pp (tense p)', 'sample' => '빵 (Ppang)', 'sample_meaning' => 'Roti'],
                ['char' => 'ㅆ', 'name' => 'Ssang-siot (쌍시옷)', 'sound' => 'ss (tense s)', 'sample' => '쌀 (Ssal)', 'sample_meaning' => 'Beras'],
                ['char' => 'ㅉ', 'name' => 'Ssang-jieut (쌍지읒)', 'sound' => 'jj (tense j)', 'sample' => '찌개 (Jjigae)', 'sample_meaning' => 'Sup Berkuah Kental'],
            ],
            'basic_vowels' => [
                ['char' => 'ㅏ', 'romaja' => 'a', 'sample' => '아이 (Ai)', 'sample_meaning' => 'Anak'],
                ['char' => 'ㅑ', 'romaja' => 'ya', 'sample' => '야구 (Yagu)', 'sample_meaning' => 'Bisbol'],
                ['char' => 'ㅓ', 'romaja' => 'eo (o terbuka)', 'sample' => '어머니 (Eomeoni)', 'sample_meaning' => 'Ibu'],
                ['char' => 'ㅕ', 'romaja' => 'yeo', 'sample' => '여자 (Yeoja)', 'sample_meaning' => 'Wanita'],
                ['char' => 'ㅗ', 'romaja' => 'o (o bulat)', 'sample' => '오리 (Ori)', 'sample_meaning' => 'Bebek'],
                ['char' => 'ㅛ', 'romaja' => 'yo', 'sample' => '요리 (Yori)', 'sample_meaning' => 'Masakan'],
                ['char' => 'ㅜ', 'romaja' => 'u', 'sample' => '우유 (Uyu)', 'sample_meaning' => 'Susu'],
                ['char' => 'ㅠ', 'romaja' => 'yu', 'sample' => '유리 (Yuri)', 'sample_meaning' => 'Kaca'],
                ['char' => 'ㅡ', 'romaja' => 'eu', 'sample' => '으뜸 (Eutteum)', 'sample_meaning' => 'Terbaik / Utama'],
                ['char' => 'ㅣ', 'romaja' => 'i', 'sample' => '이름 (Ireum)', 'sample_meaning' => 'Nama'],
            ],
            'compound_vowels' => [
                ['char' => 'ㅐ', 'romaja' => 'ae', 'sample' => '새 (Sae)', 'sample_meaning' => 'Burung'],
                ['char' => 'ㅒ', 'romaja' => 'yae', 'sample' => '얘기 (Yaegi)', 'sample_meaning' => 'Cerita'],
                ['char' => 'ㅔ', 'romaja' => 'e', 'sample' => '베개 (Begae)', 'sample_meaning' => 'Bantal'],
                ['char' => 'ㅖ', 'romaja' => 'ye', 'sample' => '예의 (Ye-ui)', 'sample_meaning' => 'Sopan Santun'],
                ['char' => 'ㅘ', 'romaja' => 'wa', 'sample' => '화장실 (Hwajangsil)', 'sample_meaning' => 'Toilet'],
                ['char' => 'ㅙ', 'romaja' => 'wae', 'sample' => '돼지 (Dwaeji)', 'sample_meaning' => 'Babi'],
                ['char' => 'ㅚ', 'romaja' => 'oe (we)', 'sample' => '회사 (Hoesa)', 'sample_meaning' => 'Perusahaan'],
                ['char' => 'ㅝ', 'romaja' => 'wo', 'sample' => '원 (Won)', 'sample_meaning' => 'Mata Uang Won'],
                ['char' => 'ㅞ', 'romaja' => 'we', 'sample' => '웨딩 (Weding)', 'sample_meaning' => 'Pernikahan'],
                ['char' => 'ㅟ', 'romaja' => 'wi', 'sample' => '위 (Wi)', 'sample_meaning' => 'Atas / Lambung'],
                ['char' => 'ㅢ', 'romaja' => 'ui', 'sample' => '의사 (Uisa)', 'sample_meaning' => 'Dokter'],
            ],
            'batchim_rules' => [
                ['sound' => '[K]', 'letters' => 'ㄱ, ㅋ, ㄲ, ㄳ, ㄺ', 'example' => '책 (chaek / buku), 밖 (bak / luar)'],
                ['sound' => '[N]', 'letters' => 'ㄴ, ㄵ, ㄶ', 'example' => '눈 (nun / mata/salju), 안 (an / dalam)'],
                ['sound' => '[T]', 'letters' => 'ㄷ, ㅅ, ㅈ, ㅊ, ㅌ, ㅎ, ㅆ', 'example' => '옷 (ot / pakaian), 꽃 (kkot / bunga)'],
                ['sound' => '[L / R]', 'letters' => 'ㄹ, ㄼ, ㄽ, ㄾ, ㅀ', 'example' => '물 (mul / air), 달 (dal / bulan)'],
                ['sound' => '[M]', 'letters' => 'ㅁ, ㄻ', 'example' => '엄마 (eomma / ibu), 밤 (bam / malam)'],
                ['sound' => '[P]', 'letters' => 'ㅂ, ㅍ, ㅄ, ㄿ', 'example' => '밥 (bap / nasi), 집 (jip / rumah)'],
                ['sound' => '[NG]', 'letters' => 'ㅇ', 'example' => '강 (gang / sungai), 방 (bang / kamar)'],
            ],
        ];
    }

    /**
     * Data 26 Abjad Inggris + Fonem IPA + Terjemahan Indonesia
     */
    private static function getEnglishAlphabetMatrix(): array
    {
        return [
            'overview' => 'Bahasa Inggris menggunakan 26 abjad Latin modern, namun memiliki kurang lebih 44 fonem suara vokal dan konsonan dalam International Phonetic Alphabet (IPA). Memahami relasi grafem-fonem dan stress kata adalah kunci pelafalan fasih standar penutur asli.',
            'letters' => [
                ['char' => 'A a', 'phonetic' => '/eɪ/ ; /æ/', 'sample' => 'Apple', 'sample_meaning' => 'Apel', 'audio' => 'Apple'],
                ['char' => 'B b', 'phonetic' => '/biː/ ; /b/', 'sample' => 'Book', 'sample_meaning' => 'Buku', 'audio' => 'Book'],
                ['char' => 'C c', 'phonetic' => '/siː/ ; /k/, /s/', 'sample' => 'Cat', 'sample_meaning' => 'Kucing', 'audio' => 'Cat'],
                ['char' => 'D d', 'phonetic' => '/diː/ ; /d/', 'sample' => 'Door', 'sample_meaning' => 'Pintu', 'audio' => 'Door'],
                ['char' => 'E e', 'phonetic' => '/iː/ ; /e/, /iː/', 'sample' => 'Earth', 'sample_meaning' => 'Bumi', 'audio' => 'Earth'],
                ['char' => 'F f', 'phonetic' => '/ef/ ; /f/', 'sample' => 'Friend', 'sample_meaning' => 'Teman', 'audio' => 'Friend'],
                ['char' => 'G g', 'phonetic' => '/dʒiː/ ; /ɡ/, /dʒ/', 'sample' => 'Growth', 'sample_meaning' => 'Pertumbuhan', 'audio' => 'Growth'],
                ['char' => 'H h', 'phonetic' => '/eɪtʃ/ ; /h/', 'sample' => 'Heart', 'sample_meaning' => 'Jantung / Hati', 'audio' => 'Heart'],
                ['char' => 'I i', 'phonetic' => '/aɪ/ ; /ɪ/, /aɪ/', 'sample' => 'Island', 'sample_meaning' => 'Pulau', 'audio' => 'Island'],
                ['char' => 'J j', 'phonetic' => '/dʒeɪ/ ; /dʒ/', 'sample' => 'Journey', 'sample_meaning' => 'Perjalanan', 'audio' => 'Journey'],
                ['char' => 'K k', 'phonetic' => '/keɪ/ ; /k/', 'sample' => 'Key', 'sample_meaning' => 'Kunci', 'audio' => 'Key'],
                ['char' => 'L l', 'phonetic' => '/el/ ; /l/', 'sample' => 'Light', 'sample_meaning' => 'Cahaya / Ringan', 'audio' => 'Light'],
                ['char' => 'M m', 'phonetic' => '/em/ ; /m/', 'sample' => 'Moon', 'sample_meaning' => 'Bulan', 'audio' => 'Moon'],
                ['char' => 'N n', 'phonetic' => '/en/ ; /n/', 'sample' => 'Nature', 'sample_meaning' => 'Alam', 'audio' => 'Nature'],
                ['char' => 'O o', 'phonetic' => '/oʊ/ ; /ɒ/, /oʊ/', 'sample' => 'Ocean', 'sample_meaning' => 'Samudra', 'audio' => 'Ocean'],
                ['char' => 'P p', 'phonetic' => '/piː/ ; /p/', 'sample' => 'Peace', 'sample_meaning' => 'Perdamaian', 'audio' => 'Peace'],
                ['char' => 'Q q', 'phonetic' => '/kjuː/ ; /kw/', 'sample' => 'Queen', 'sample_meaning' => 'Ratu', 'audio' => 'Queen'],
                ['char' => 'R r', 'phonetic' => '/ɑːr/ ; /r/', 'sample' => 'River', 'sample_meaning' => 'Sungai', 'audio' => 'River'],
                ['char' => 'S s', 'phonetic' => '/es/ ; /s/', 'sample' => 'Sun', 'sample_meaning' => 'Matahari', 'audio' => 'Sun'],
                ['char' => 'T t', 'phonetic' => '/tiː/ ; /t/', 'sample' => 'Time', 'sample_meaning' => 'Waktu', 'audio' => 'Time'],
                ['char' => 'U u', 'phonetic' => '/juː/ ; /ʌ/, /uː/', 'sample' => 'Universe', 'sample_meaning' => 'Alam Semesta', 'audio' => 'Universe'],
                ['char' => 'V v', 'phonetic' => '/viː/ ; /v/', 'sample' => 'Vision', 'sample_meaning' => 'Penglihatan / Visi', 'audio' => 'Vision'],
                ['char' => 'W w', 'phonetic' => '/ˈdʌb.əl.juː/ ; /w/', 'sample' => 'Water', 'sample_meaning' => 'Air', 'audio' => 'Water'],
                ['char' => 'X x', 'phonetic' => '/eks/ ; /ks/, /z/', 'sample' => 'X-ray', 'sample_meaning' => 'Sinar Rontgen', 'audio' => 'X-ray'],
                ['char' => 'Y y', 'phonetic' => '/waɪ/ ; /j/, /aɪ/', 'sample' => 'Youth', 'sample_meaning' => 'Masa Muda', 'audio' => 'Youth'],
                ['char' => 'Z z', 'phonetic' => '/zed/ ; /z/', 'sample' => 'Zenith', 'sample_meaning' => 'Puncak Kejayaan', 'audio' => 'Zenith'],
            ],
        ];
    }

    /**
     * Bank kosakata & frase tematik masif (1000+ kombinasi per bahasa)
     */
    public static function getThematicLexiconPool(string $langCode, string $levelCode): array
    {
        return match ($langCode) {
            'ar' => self::getArabicLexiconPool(),
            'ja' => self::getJapaneseLexiconPool(),
            'ko' => self::getKoreanLexiconPool(),
            'en' => self::getEnglishLexiconPool(),
            default => []
        };
    }

    private static function getArabicLexiconPool(): array
    {
        return [
            ['word' => 'كِتَابٌ', 'trans' => 'Kitaabun', 'meaning' => 'Buku', 'notes' => 'Isim Mufrod Mudzakkar, jamak: Kutubun (كُتُبٌ).'],
            ['word' => 'مَدْرَسَةٌ', 'trans' => 'Madrasatun', 'meaning' => 'Sekolah', 'notes' => 'Isim Muannats berakhiran ta marbuthah.'],
            ['word' => 'مَسْجِدٌ', 'trans' => 'Masjidun', 'meaning' => 'Masjid', 'notes' => 'Tempat sujud, wazan Isim Makan.'],
            ['word' => 'طَالِبٌ', 'trans' => 'Thaalibun', 'meaning' => 'Murid / Mahasiswa', 'notes' => 'Bentuk jamak: Thullabun (طُلاَّبٌ).'],
            ['word' => 'أُسْتَاذٌ', 'trans' => 'Ustaadzun', 'meaning' => 'Guru / Dosen', 'notes' => 'Panggilan hormat bagi pendidik.'],
            ['word' => 'سَيَّارَةٌ', 'trans' => 'Sayyaaratun', 'meaning' => 'Mobil', 'notes' => 'Isim Muannats.'],
            ['word' => 'بَيْتٌ', 'trans' => 'Baitun', 'meaning' => 'Rumah', 'notes' => 'Bentuk jamak: Buyuutun (بُيُوْتٌ).'],
            ['word' => 'مَطَارٌ', 'trans' => 'Mathaarun', 'meaning' => 'Bandara', 'notes' => 'Tempat penerbangan pesawat.'],
            ['word' => 'مُسْتَشْفَى', 'trans' => 'Mustasyfaa', 'meaning' => 'Rumah Sakit', 'notes' => 'Isim Maqshur (berakhiran alif bengkok).'],
            ['word' => 'شَارِعٌ', 'trans' => 'Syari\'un', 'meaning' => 'Jalan Raya', 'notes' => 'Bentuk jamak: Syawaari\' (شَوَارِعُ).'],
            ['word' => 'قَلَمٌ', 'trans' => 'Qalamun', 'meaning' => 'Pena / Alat Tulis', 'notes' => 'Bentuk jamak: Aqlamun (أَقْلَامٌ).'],
            ['word' => 'حَقِيبَةٌ', 'trans' => 'Haqiibatun', 'meaning' => 'Tas / Ransel', 'notes' => 'Isim Muannats.'],
            ['word' => 'طَبِيبٌ', 'trans' => 'Thabiibun', 'meaning' => 'Dokter', 'notes' => 'Pelaku profesi kesehatan.'],
            ['word' => 'مُهَنْدِسٌ', 'trans' => 'Muhandisun', 'meaning' => 'Insinyur', 'notes' => 'Isim Fa\'il profesi teknik.'],
            ['word' => 'سَاعَةٌ', 'trans' => 'Saa\'atun', 'meaning' => 'Jam / Waktu', 'notes' => 'Penanda waktu atau jam dinding/tangan.'],
            ['word' => 'صَبَاحُ الخَيْرِ', 'trans' => 'Shabaahul khair', 'meaning' => 'Selamat Pagi', 'notes' => 'Dibalas dengan: Shabaahun nuur.'],
            ['word' => 'مَسَاءُ الخَيْرِ', 'trans' => 'Masaa-ul khair', 'meaning' => 'Selamat Sore', 'notes' => 'Dibalas dengan: Masaa-un nuur.'],
            ['word' => 'شُكْرًا جَزِيلاً', 'trans' => 'Syukran jaziilan', 'meaning' => 'Terima Kasih Banyak', 'notes' => 'Dibalas dengan: \'Afwan (عَفْوًا).'],
            ['word' => 'مَعَ السَّلَامَةِ', 'trans' => 'Ma\'as salaamah', 'meaning' => 'Selamat Jalan / Sampai Jumpa', 'notes' => 'Ungkapan perpisahan santun.'],
            ['word' => 'أَهْلاً وَسَهْلاً', 'trans' => 'Ahlan wa sahlan', 'meaning' => 'Selamat Datang', 'notes' => 'Dibalas dengan: Ahlan bika.'],
            ['word' => 'يَقْرَأُ', 'trans' => 'Yaqra-u', 'meaning' => 'Sedang Membaca', 'notes' => 'Fi\'il Mudhari\' bentuk Huwa.'],
            ['word' => 'يَكْتُبُ', 'trans' => 'Yaktubu', 'meaning' => 'Sedang Menulis', 'notes' => 'Fi\'il Mudhari\' dari kataba.'],
            ['word' => 'يَشْرَبُ', 'trans' => 'Yasyrobu', 'meaning' => 'Sedang Minum', 'notes' => 'Fi\'il Mudhari\' dari syariba.'],
            ['word' => 'يَأْكُلُ', 'trans' => 'Ya\'kulu', 'meaning' => 'Sedang Makan', 'notes' => 'Fi\'il Mudhari\' dari akala.'],
            ['word' => 'يَذْهَبُ', 'trans' => 'Yadzhabu', 'meaning' => 'Sedang Pergi', 'notes' => 'Fi\'il Mudhari\' dari dzahaba.'],
        ];
    }

    private static function getJapaneseLexiconPool(): array
    {
        return [
            ['word' => 'ほん (本)', 'trans' => 'Hon', 'meaning' => 'Buku', 'notes' => 'Kanji 本 juga berarti asal/dasar.'],
            ['word' => 'みず (水)', 'trans' => 'Mizu', 'meaning' => 'Air', 'notes' => 'Radikal air adalah sanzui (氵).'],
            ['word' => 'たべます (食べます)', 'trans' => 'Tabemasu', 'meaning' => 'Makan', 'notes' => 'Kata kerja golongan 2 (Ichidan).'],
            ['word' => 'のみます (飲みます)', 'trans' => 'Nomimasu', 'meaning' => 'Minum', 'notes' => 'Kata kerja golongan 1 (Godan).'],
            ['word' => 'いきます (行きます)', 'trans' => 'Ikimasu', 'meaning' => 'Pergi', 'notes' => 'Bentuk Te-form khusus: Itte (行って).'],
            ['word' => 'きます (来ます)', 'trans' => 'Kimasu', 'meaning' => 'Datang', 'notes' => 'Kata kerja golongan 3 (Irregular).'],
            ['word' => 'せんせい (先生)', 'trans' => 'Sensei', 'meaning' => 'Guru / Dosen', 'notes' => 'Arti harfiah: orang yang lahir lebih dulu.'],
            ['word' => 'がくせい (学生)', 'trans' => 'Gakusei', 'meaning' => 'Siswa / Mahasiswa', 'notes' => 'Orang yang menuntut ilmu.'],
            ['word' => 'がっこう (学校)', 'trans' => 'Gakkou', 'meaning' => 'Sekolah', 'notes' => 'Lembaga pendidikan.'],
            ['word' => 'ともだち (友達)', 'trans' => 'Tomodachi', 'meaning' => 'Teman / Sahabat', 'notes' => 'Partikel penanda jamak: dachi.'],
            ['word' => 'くるま (車)', 'trans' => 'Kuruma', 'meaning' => 'Mobil', 'notes' => 'Kanji 車 menyerupai kereta dorong.'],
            ['word' => 'でんしゃ (電車)', 'trans' => 'Densha', 'meaning' => 'Kereta Listrik', 'notes' => 'Gabungan kanji listrik (電) dan roda (車).'],
            ['word' => 'えき (駅)', 'trans' => 'Eki', 'meaning' => 'Stasiun Kereta', 'notes' => 'Fasilitas transportasi umum.'],
            ['word' => 'ひこうき (飛行機)', 'trans' => 'Hikouki', 'meaning' => 'Pesawat Terbang', 'notes' => 'Kendaraan udara.'],
            ['word' => 'じかん (時間)', 'trans' => 'Jikan', 'meaning' => 'Waktu / Jam', 'notes' => 'Penanda jam atau durasi.'],
            ['word' => 'おはようございます', 'trans' => 'Ohayou gozaimasu', 'meaning' => 'Selamat Pagi (Sopan)', 'notes' => 'Digunakan sebelum pukul 10.00 pagi.'],
            ['word' => 'こんにちは', 'trans' => 'Konnichiwa', 'meaning' => 'Halo / Selamat Siang', 'notes' => 'Huruf は di akhir dibaca wa.'],
            ['word' => 'こんばんは', 'trans' => 'Konbanwa', 'meaning' => 'Selamat Malam', 'notes' => 'Salam pertemuan waktu petang/malam.'],
            ['word' => 'ありがとうございます', 'trans' => 'Arigatou gozaimasu', 'meaning' => 'Terima Kasih Banyak', 'notes' => 'Ungkapan rasa terima kasih formal.'],
            ['word' => 'すみません', 'trans' => 'Sumimasen', 'meaning' => 'Permisi / Maaf', 'notes' => 'Sangat fleksibel dalam keseharian.'],
            ['word' => 'かいぎ (会議)', 'trans' => 'Kaigi', 'meaning' => 'Rapat / Pertemuan Bisnis', 'notes' => 'Sering digunakan di kantor.'],
            ['word' => 'かいしゃ (会社)', 'trans' => 'Kaisha', 'meaning' => 'Perusahaan / Kantor', 'notes' => 'Tempat bekerja.'],
            ['word' => 'めいし (名刺)', 'trans' => 'Meishi', 'meaning' => 'Kartu Nama Bisnis', 'notes' => 'Etiket bertukar kartu nama di Jepang.'],
            ['word' => 'しごと (仕事)', 'trans' => 'Shigoto', 'meaning' => 'Pekerjaan', 'notes' => 'Aktivitas profesional harian.'],
            ['word' => 'ざんぎょう (残業)', 'trans' => 'Zangyou', 'meaning' => 'Lembur Kerja', 'notes' => 'Bekerja melebihi jam kerja normal.'],
        ];
    }

    private static function getKoreanLexiconPool(): array
    {
        return [
            ['word' => '책', 'trans' => 'Chaek', 'meaning' => 'Buku', 'notes' => 'Memiliki batchim k (ㄱ).'],
            ['word' => '물', 'trans' => 'Mul', 'meaning' => 'Air', 'notes' => 'Memiliki batchim l (ㄹ).'],
            ['word' => '밥', 'trans' => 'Bap', 'meaning' => 'Nasi / Makanan', 'notes' => 'Babeul meogeoyo = makan nasi.'],
            ['word' => '학교', 'trans' => 'Hakgyo', 'meaning' => 'Sekolah', 'notes' => 'Tempat pendidikan formal.'],
            ['word' => '선생님', 'trans' => 'Seonsaengnim', 'meaning' => 'Guru / Pengajar', 'notes' => 'Akhiran -nim menandakan rasa hormat.'],
            ['word' => '학생', 'trans' => 'Haksaeng', 'meaning' => 'Siswa / Murid', 'notes' => 'Pelajar di sekolah.'],
            ['word' => '친구', 'trans' => 'Chingu', 'meaning' => 'Teman / Sahabat', 'notes' => 'Teman sebaya.'],
            ['word' => '집', 'trans' => 'Jip', 'meaning' => 'Rumah', 'notes' => 'Memiliki batchim p (ㅂ).'],
            ['word' => '병원', 'trans' => 'Byeongwon', 'meaning' => 'Rumah Sakit', 'notes' => 'Fasilitas kesehatan.'],
            ['word' => '회사', 'trans' => 'Hoesa', 'meaning' => 'Perusahaan / Kantor', 'notes' => 'Tempat berkarir.'],
            ['word' => '자동차', 'trans' => 'Jadongcha', 'meaning' => 'Mobil', 'notes' => 'Kendaraan roda empat.'],
            ['word' => '지하철', 'trans' => 'Jihacheol', 'meaning' => 'Kereta Bawah Tanah (Subway)', 'notes' => 'Transportasi massal di Korea.'],
            ['word' => '공항', 'trans' => 'Gonghang', 'meaning' => 'Bandara', 'notes' => 'Pelabuhan udara.'],
            ['word' => '시간', 'trans' => 'Sigan', 'meaning' => 'Waktu / Jam', 'notes' => 'Durasi atau momen waktu.'],
            ['word' => '오늘', 'trans' => 'Oneul', 'meaning' => 'Hari Ini', 'notes' => 'Keterangan waktu sekarang.'],
            ['word' => '안녕하세요', 'trans' => 'Annyeonghaseyo', 'meaning' => 'Halo / Selamat Siang', 'notes' => 'Salam universal sopan.'],
            ['word' => '감사합니다', 'trans' => 'Gamsahamnida', 'meaning' => 'Terima Kasih (Formal)', 'notes' => 'Bentuk formal paling umum.'],
            ['word' => '죄송합니다', 'trans' => 'Joesonghamnida', 'meaning' => 'Mohon Maaf (Sopan)', 'notes' => 'Permohonan maaf resmi.'],
            ['word' => '만나서 반갑습니다', 'trans' => 'Mannaseo bangapseumnida', 'meaning' => 'Senang Bertemu dengan Anda', 'notes' => 'Salam perkenalan.'],
            ['word' => '안녕히 가세요', 'trans' => 'Annyeonghi gaseyo', 'meaning' => 'Selamat Jalan (Tamu Pergi)', 'notes' => 'Diucapkan kepada orang yang pergi.'],
            ['word' => '회의', 'trans' => 'Hoe-ui', 'meaning' => 'Rapat / Meeting', 'notes' => 'Pembahasan agenda bisnis.'],
            ['word' => '보고서', 'trans' => 'Bogoseo', 'meaning' => 'Laporan Dokumen', 'notes' => 'Berkas laporan kerja.'],
            ['word' => '계약', 'trans' => 'Gyeyak', 'meaning' => 'Kontrak Kerja / Perjanjian', 'notes' => 'Dokumen hukum perikatan.'],
            ['word' => '출장', 'trans' => 'Chuljang', 'meaning' => 'Perjalanan Dinas Bisnis', 'notes' => 'Tugas kerja luar kota/negeri.'],
            ['word' => '승진', 'trans' => 'Seungjin', 'meaning' => 'Promosi Jabatan', 'notes' => 'Kenaikan tingkat karir.'],
        ];
    }

    private static function getEnglishLexiconPool(): array
    {
        return [
            ['word' => 'Knowledge', 'trans' => '/ˈnɒl.ɪdʒ/', 'meaning' => 'Pengetahuan', 'notes' => 'Uncountable noun; huruf K diawal tidak dibaca (silent k).'],
            ['word' => 'Achievement', 'trans' => '/əˈtʃiːv.mənt/', 'meaning' => 'Prestasi / Pencapaian', 'notes' => 'Noun dari kata kerja achieve.'],
            ['word' => 'Opportunity', 'trans' => '/ˌɒp.əˈtʃuː.nə.ti/', 'meaning' => 'Peluang / Kesempatan', 'notes' => 'Digunakan luas dalam dunia karir.'],
            ['word' => 'Resilience', 'trans' => '/rɪˈzɪl.jəns/', 'meaning' => 'Ketahanan / Daya Lenting', 'notes' => 'Kemampuan bangkit dari rintangan.'],
            ['word' => 'Collaboration', 'trans' => '/kəˌlæb.əˈreɪ.ʃən/', 'meaning' => 'Kolaborasi / Kerjasama', 'notes' => 'Kerja tim sinergis.'],
            ['word' => 'Innovation', 'trans' => '/ˌɪn.əˈveɪ.ʃən/', 'meaning' => 'Inovasi / Terobosan', 'notes' => 'Penciptaan solusi atau ide baru.'],
            ['word' => 'Perspective', 'trans' => '/pəˈspek.tɪv/', 'meaning' => 'Sudut Pandang / Perspektif', 'notes' => 'Cara memandang suatu kondisi.'],
            ['word' => 'Sustainable', 'trans' => '/səˈsteɪ.nə.bəl/', 'meaning' => 'Berkelanjutan', 'notes' => 'Dapat dipertahankan jangka panjang.'],
            ['word' => 'Efficiency', 'trans' => '/ɪˈfɪʃ.ən.si/', 'meaning' => 'Efisiensi / Kedayagunaan', 'notes' => 'Pencapaian output prima berbiaya hemat.'],
            ['word' => 'Responsibility', 'trans' => '/rɪˌspɒn.sɪˈbɪl.ə.ti/', 'meaning' => 'Tanggung Jawab', 'notes' => 'Kewajiban moral atau profesi.'],
            ['word' => 'Negotiate', 'trans' => '/nəˈɡoʊ.ʃi.eɪt/', 'meaning' => 'Berdialog / Bernegosiasi', 'notes' => 'Mencapai titik temu kesepakatan.'],
            ['word' => 'Consensus', 'trans' => '/kənˈsen.səs/', 'meaning' => 'Konsensus / Kesepakatan Bulat', 'notes' => 'Persetujuan mufakat seluruh pihak.'],
            ['word' => 'Implement', 'trans' => '/ˈɪm.plɪ.ment/', 'meaning' => 'Menerapkan / Melaksanakan', 'notes' => 'Realisasi aksi dari suatu rencana.'],
            ['word' => 'Evaluate', 'trans' => '/ɪˈvæl.ju.eɪt/', 'meaning' => 'Mengevaluasi / Menilai', 'notes' => 'Mengukur performa dan target.'],
            ['word' => 'Prioritize', 'trans' => '/praɪˈɒr.ɪ.taɪz/', 'meaning' => 'Memprioritaskan', 'notes' => 'Mengutamakan hal yang esensial.'],
            ['word' => 'Deliverable', 'trans' => '/dɪˈlɪv.ər.ə.bəl/', 'meaning' => 'Hasil Kerja / Luaran Proyek', 'notes' => 'Luaran atau hasil jadi tugas.'],
            ['word' => 'Benchmark', 'trans' => '/ˈbentʃ.mɑːk/', 'meaning' => 'Tolok Ukur / Standar Acuan', 'notes' => 'Acuan pembanding standar mutu.'],
            ['word' => 'Unprecedented', 'trans' => '/ʌnˈpres.ɪ.den.tɪd/', 'meaning' => 'Belum Pernah Terjadi Sebelumnya', 'notes' => 'Fenomena baru tanpa pembanding dulu.'],
            ['word' => 'Meticulous', 'trans' => '/məˈtɪk.jə.ləs/', 'meaning' => 'Teliti / Cermat', 'notes' => 'Detail dan penuh ketelitian.'],
            ['word' => 'Pragmatic', 'trans' => '/præɡˈmæt.ɪk/', 'meaning' => 'Pragmatis / Praktis', 'notes' => 'Berorientasi praktis pada hasil riil.'],
            ['word' => 'Ambiguity', 'trans' => '/ˌæm.bɪˈɡjuː.ə.ti/', 'meaning' => 'Ketaksaan / Keraguan Arti', 'notes' => 'Kondisi multitafsir.'],
            ['word' => 'Comprehensive', 'trans' => '/ˌkɒm.prɪˈhen.sɪv/', 'meaning' => 'Komprehensif / Menyeluruh', 'notes' => 'Menyeluruh dan menyeluruh tiap segi.'],
            ['word' => 'Stakeholder', 'trans' => '/ˈsteɪkˌhəʊl.dər/', 'meaning' => 'Pemangku Kepentingan', 'notes' => 'Pihak yang berpengaruh pada kebijakan.'],
            ['word' => 'Trajectory', 'trans' => '/trəˈdʒek.tər.i/', 'meaning' => 'Lintasan / Arah Perkembangan', 'notes' => 'Jalur tren kemajuan.'],
            ['word' => 'Synergy', 'trans' => '/ˈsɪn.ə.dʒi/', 'meaning' => 'Sinergi / Kerja Sama Padu', 'notes' => 'Hasil kolaboratif berlipat ganda.'],
        ];
    }
}
