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
     * Data Lengkap 28 Hijaiyah + Harakat
     */
    private static function getArabicAlphabetMatrix(): array
    {
        return [
            'overview' => 'Bahasa Arab ditulis dari kanan ke kiri (RTL) menggunakan abjad Hijaiyah yang berjumlah 28 huruf konsonan. Huruf Arab bersifat kursif (selalu bersambung), sehingga satu huruf memiliki hingga empat bentuk tergantung posisinya: Berdiri Sendiri (Isolated), Awal Kata (Initial), Tengah Kata (Medial), dan Akhir Kata (Final). Bunyi vokal diatur melalui tanda baca (Harakat).',
            'letters' => [
                ['char' => 'ا', 'name' => 'Alif', 'latin' => 'a / ā', 'isolated' => 'ا', 'initial' => 'ا', 'medial' => 'ـا', 'final' => 'ـا', 'audio' => 'أَلِف'],
                ['char' => 'ب', 'name' => 'Ba', 'latin' => 'b', 'isolated' => 'ب', 'initial' => 'بـ', 'medial' => 'ـبـ', 'final' => 'ـب', 'audio' => 'بَاء'],
                ['char' => 'ت', 'name' => 'Ta', 'latin' => 't', 'isolated' => 'ت', 'initial' => 'تـ', 'medial' => 'ـتـ', 'final' => 'ـت', 'audio' => 'تَاء'],
                ['char' => 'ث', 'name' => 'Tsa', 'latin' => 'ts / th', 'isolated' => 'ث', 'initial' => 'ثـ', 'medial' => 'ـثـ', 'final' => 'ـث', 'audio' => 'ثَاء'],
                ['char' => 'ج', 'name' => 'Jim', 'latin' => 'j', 'isolated' => 'ج', 'initial' => 'جـ', 'medial' => 'ـجـ', 'final' => 'ـج', 'audio' => 'جِيم'],
                ['char' => 'ح', 'name' => 'Ha (Pedas)', 'latin' => 'ḥ', 'isolated' => 'ح', 'initial' => 'حـ', 'medial' => 'ـحـ', 'final' => 'ـح', 'audio' => 'حَاء'],
                ['char' => 'خ', 'name' => 'Kha', 'latin' => 'kh', 'isolated' => 'خ', 'initial' => 'خـ', 'medial' => 'ـخـ', 'final' => 'ـخ', 'audio' => 'خَاء'],
                ['char' => 'د', 'name' => 'Dal', 'latin' => 'd', 'isolated' => 'د', 'initial' => 'د', 'medial' => 'ـد', 'final' => 'ـد', 'audio' => 'دَال'],
                ['char' => 'ذ', 'name' => 'Dzal', 'latin' => 'dz / dh', 'isolated' => 'ذ', 'initial' => 'ذ', 'medial' => 'ـذ', 'final' => 'ـذ', 'audio' => 'ذَال'],
                ['char' => 'ر', 'name' => 'Ra', 'latin' => 'r', 'isolated' => 'ر', 'initial' => 'ر', 'medial' => 'ـر', 'final' => 'ـر', 'audio' => 'رَاء'],
                ['char' => 'ز', 'name' => 'Zay', 'latin' => 'z', 'isolated' => 'ز', 'initial' => 'ز', 'medial' => 'ـز', 'final' => 'ـز', 'audio' => 'زَاي'],
                ['char' => 'س', 'name' => 'Sin', 'latin' => 's', 'isolated' => 'س', 'initial' => 'سـ', 'medial' => 'ـسـ', 'final' => 'ـس', 'audio' => 'سِين'],
                ['char' => 'ش', 'name' => 'Syin', 'latin' => 'sy / sh', 'isolated' => 'ش', 'initial' => 'شـ', 'medial' => 'ـشـ', 'final' => 'ـش', 'audio' => 'شِين'],
                ['char' => 'ص', 'name' => 'Shad', 'latin' => 'ṣ', 'isolated' => 'ص', 'initial' => 'صـ', 'medial' => 'ـصـ', 'final' => 'ـص', 'audio' => 'صَاد'],
                ['char' => 'ض', 'name' => 'Dhad', 'latin' => 'ḍ', 'isolated' => 'ض', 'initial' => 'ضـ', 'medial' => 'ـضـ', 'final' => 'ـض', 'audio' => 'ضَاد'],
                ['char' => 'ط', 'name' => 'Tha', 'latin' => 'ṭ', 'isolated' => 'ط', 'initial' => 'طـ', 'medial' => 'ـطـ', 'final' => 'ـط', 'audio' => 'طَاء'],
                ['char' => 'ظ', 'name' => 'Zha', 'latin' => 'ẓ', 'isolated' => 'ظ', 'initial' => 'ظـ', 'medial' => 'ـظـ', 'final' => 'ـظ', 'audio' => 'ظَاء'],
                ['char' => 'ع', 'name' => '\'Ain', 'latin' => '‘ / ʿ', 'isolated' => 'ع', 'initial' => 'عـ', 'medial' => 'ـعـ', 'final' => 'ـع', 'audio' => 'عَيْن'],
                ['char' => 'غ', 'name' => 'Ghain', 'latin' => 'gh', 'isolated' => 'غ', 'initial' => 'غـ', 'medial' => 'ـغـ', 'final' => 'ـغ', 'audio' => 'غَيْن'],
                ['char' => 'ف', 'name' => 'Fa', 'latin' => 'f', 'isolated' => 'ف', 'initial' => 'فـ', 'medial' => 'ـفـ', 'final' => 'ـف', 'audio' => 'فَاء'],
                ['char' => 'ق', 'name' => 'Qaf', 'latin' => 'q', 'isolated' => 'ق', 'initial' => 'قـ', 'medial' => 'ـقـ', 'final' => 'ـق', 'audio' => 'قَاف'],
                ['char' => 'ك', 'name' => 'Kaf', 'latin' => 'k', 'isolated' => 'ك', 'initial' => 'كـ', 'medial' => 'ـكـ', 'final' => 'ـك', 'audio' => 'كَاف'],
                ['char' => 'ل', 'name' => 'Lam', 'latin' => 'l', 'isolated' => 'ل', 'initial' => 'لـ', 'medial' => 'ـلـ', 'final' => 'ـل', 'audio' => 'لَام'],
                ['char' => 'م', 'name' => 'Mim', 'latin' => 'm', 'isolated' => 'م', 'initial' => 'مـ', 'medial' => 'ـمـ', 'final' => 'ـم', 'audio' => 'مِيم'],
                ['char' => 'ن', 'name' => 'Nun', 'latin' => 'n', 'isolated' => 'ن', 'initial' => 'نـ', 'medial' => 'ـنـ', 'final' => 'ـن', 'audio' => 'نُون'],
                ['char' => 'ه', 'name' => 'Ha (Besar)', 'latin' => 'h', 'isolated' => 'ه', 'initial' => 'هـ', 'medial' => 'ـهـ', 'final' => 'ـه', 'audio' => 'هَاء'],
                ['char' => 'و', 'name' => 'Waw', 'latin' => 'w / ū', 'isolated' => 'و', 'initial' => 'و', 'medial' => 'ـو', 'final' => 'ـو', 'audio' => 'وَاو'],
                ['char' => 'ي', 'name' => 'Ya', 'latin' => 'y / ī', 'isolated' => 'ي', 'initial' => 'يـ', 'medial' => 'ـيـ', 'final' => 'ـي', 'audio' => 'يَاء'],
            ],
            'harakat' => [
                ['symbol' => 'َ', 'name' => 'Fathah (فَتْحَة)', 'sound' => 'Bunyi vokal pendek "A" di atas huruf'],
                ['symbol' => 'ِ', 'name' => 'Kasrah (كَسْرَة)', 'sound' => 'Bunyi vokal pendek "I" di bawah huruf'],
                ['symbol' => 'ُ', 'name' => 'Dhammah (ضَمَّة)', 'sound' => 'Bunyi vokal pendek "U" di atas huruf'],
                ['symbol' => 'ْ', 'name' => 'Sukun (سُكُون)', 'sound' => 'Tanda mati (konsonan tanpa vokal)'],
                ['symbol' => 'ّ', 'name' => 'Tasydid / Syaddah', 'sound' => 'Tanda konsonan ganda / ditekan'],
                ['symbol' => 'ً', 'name' => 'Tanwin Fathah', 'sound' => 'Bunyi "-AN" pada isim nakiroh'],
                ['symbol' => 'ٍ', 'name' => 'Tanwin Kasrah', 'sound' => 'Bunyi "-IN" pada isim nakiroh'],
                ['symbol' => 'ٌ', 'name' => 'Tanwin Dhammah', 'sound' => 'Bunyi "-UN" pada isim nakiroh marfu\''],
            ],
        ];
    }

    /**
     * Data Lengkap Hiragana (46 Seion + 25 Dakuon) + Katakana (46)
     */
    private static function getJapaneseAlphabetMatrix(): array
    {
        return [
            'overview' => 'Bahasa Jepang menggunakan 3 sistem aksara: Hiragana (untuk kata asli Jepang dan infleksi tata bahasa), Katakana (untuk kata serapan asing, nama negara, nama orang non-Jepang, dan onomatopoeia), serta Kanji (karakter logografis Cina yang merepresentasikan makna).',
            'hiragana' => [
                ['char' => 'あ', 'romaji' => 'a'], ['char' => 'い', 'romaji' => 'i'], ['char' => 'う', 'romaji' => 'u'], ['char' => 'え', 'romaji' => 'e'], ['char' => 'お', 'romaji' => 'o'],
                ['char' => 'か', 'romaji' => 'ka'], ['char' => 'き', 'romaji' => 'ki'], ['char' => 'く', 'romaji' => 'ku'], ['char' => 'け', 'romaji' => 'ke'], ['char' => 'こ', 'romaji' => 'ko'],
                ['char' => 'さ', 'romaji' => 'sa'], ['char' => 'し', 'romaji' => 'shi'], ['char' => 'す', 'romaji' => 'su'], ['char' => 'せ', 'romaji' => 'se'], ['char' => 'そ', 'romaji' => 'so'],
                ['char' => 'た', 'romaji' => 'ta'], ['char' => 'ち', 'romaji' => 'chi'], ['char' => 'つ', 'romaji' => 'tsu'], ['char' => 'て', 'romaji' => 'te'], ['char' => 'と', 'romaji' => 'to'],
                ['char' => 'な', 'romaji' => 'na'], ['char' => 'に', 'romaji' => 'ni'], ['char' => 'ぬ', 'romaji' => 'nu'], ['char' => 'ね', 'romaji' => 'ne'], ['char' => 'の', 'romaji' => 'no'],
                ['char' => 'は', 'romaji' => 'ha'], ['char' => 'ひ', 'romaji' => 'hi'], ['char' => 'ふ', 'romaji' => 'fu'], ['char' => 'へ', 'romaji' => 'he'], ['char' => 'ほ', 'romaji' => 'ho'],
                ['char' => 'ま', 'romaji' => 'ma'], ['char' => 'み', 'romaji' => 'mi'], ['char' => 'む', 'romaji' => 'mu'], ['char' => 'め', 'romaji' => 'me'], ['char' => 'も', 'romaji' => 'mo'],
                ['char' => 'や', 'romaji' => 'ya'], ['char' => 'ゆ', 'romaji' => 'yu'], ['char' => 'よ', 'romaji' => 'yo'],
                ['char' => 'ら', 'romaji' => 'ra'], ['char' => 'り', 'romaji' => 'ri'], ['char' => 'る', 'romaji' => 'ru'], ['char' => 'れ', 'romaji' => 're'], ['char' => 'ろ', 'romaji' => 'ro'],
                ['char' => 'わ', 'romaji' => 'wa'], ['char' => 'を', 'romaji' => 'wo / o'], ['char' => 'ん', 'romaji' => 'n'],
            ],
            'dakuon' => [
                ['char' => 'が', 'romaji' => 'ga'], ['char' => 'ぎ', 'romaji' => 'gi'], ['char' => 'ぐ', 'romaji' => 'gu'], ['char' => 'げ', 'romaji' => 'ge'], ['char' => 'ご', 'romaji' => 'go'],
                ['char' => 'ざ', 'romaji' => 'za'], ['char' => 'じ', 'romaji' => 'ji'], ['char' => 'ず', 'romaji' => 'zu'], ['char' => 'ぜ', 'romaji' => 'ze'], ['char' => 'ぞ', 'romaji' => 'zo'],
                ['char' => 'だ', 'romaji' => 'da'], ['char' => 'ぢ', 'romaji' => 'ji (dji)'], ['char' => 'づ', 'romaji' => 'zu (dzu)'], ['char' => 'で', 'romaji' => 'de'], ['char' => 'ど', 'romaji' => 'do'],
                ['char' => 'ば', 'romaji' => 'ba'], ['char' => 'び', 'romaji' => 'bi'], ['char' => 'ぶ', 'romaji' => 'bu'], ['char' => 'べ', 'romaji' => 'be'], ['char' => 'ぼ', 'romaji' => 'bo'],
                ['char' => 'ぱ', 'romaji' => 'pa'], ['char' => 'ぴ', 'romaji' => 'pi'], ['char' => 'ぷ', 'romaji' => 'pu'], ['char' => 'ぺ', 'romaji' => 'pe'], ['char' => 'ぽ', 'romaji' => 'po'],
            ],
            'katakana' => [
                ['char' => 'ア', 'romaji' => 'a'], ['char' => 'イ', 'romaji' => 'i'], ['char' => 'ウ', 'romaji' => 'u'], ['char' => 'エ', 'romaji' => 'e'], ['char' => 'オ', 'romaji' => 'o'],
                ['char' => 'カ', 'romaji' => 'ka'], ['char' => 'キ', 'romaji' => 'ki'], ['char' => 'ク', 'romaji' => 'ku'], ['char' => 'ケ', 'romaji' => 'ke'], ['char' => 'コ', 'romaji' => 'ko'],
                ['char' => 'サ', 'romaji' => 'sa'], ['char' => 'シ', 'romaji' => 'shi'], ['char' => 'ス', 'romaji' => 'su'], ['char' => 'セ', 'romaji' => 'se'], ['char' => 'ソ', 'romaji' => 'so'],
                ['char' => 'タ', 'romaji' => 'ta'], ['char' => 'チ', 'romaji' => 'chi'], ['char' => 'ツ', 'romaji' => 'tsu'], ['char' => 'テ', 'romaji' => 'te'], ['char' => 'ト', 'romaji' => 'to'],
                ['char' => 'ナ', 'romaji' => 'na'], ['char' => 'ニ', 'romaji' => 'ni'], ['char' => 'ヌ', 'romaji' => 'nu'], ['char' => 'ネ', 'romaji' => 'ne'], ['char' => 'ノ', 'romaji' => 'no'],
                ['char' => 'ハ', 'romaji' => 'ha'], ['char' => 'ヒ', 'romaji' => 'hi'], ['char' => 'フ', 'romaji' => 'fu'], ['char' => 'ヘ', 'romaji' => 'he'], ['char' => 'ホ', 'romaji' => 'ho'],
                ['char' => 'マ', 'romaji' => 'ma'], ['char' => 'ミ', 'romaji' => 'mi'], ['char' => 'ム', 'romaji' => 'mu'], ['char' => 'メ', 'romaji' => 'me'], ['char' => 'モ', 'romaji' => 'mo'],
                ['char' => 'ヤ', 'romaji' => 'ya'], ['char' => 'ユ', 'romaji' => 'yu'], ['char' => 'ヨ', 'romaji' => 'yo'],
                ['char' => 'ラ', 'romaji' => 'ra'], ['char' => 'リ', 'romaji' => 'ri'], ['char' => 'ル', 'romaji' => 'ru'], ['char' => 'レ', 'romaji' => 're'], ['char' => 'ロ', 'romaji' => 'ro'],
                ['char' => 'ワ', 'romaji' => 'wa'], ['char' => 'ヲ', 'romaji' => 'wo'], ['char' => 'ン', 'romaji' => 'n'],
            ],
        ];
    }

    /**
     * Data Lengkap Hangeul (40 Karakter: 19 Konsonan + 21 Vokal + Kaidah Batchim)
     */
    private static function getKoreanAlphabetMatrix(): array
    {
        return [
            'overview' => 'Hangeul (한글) adalah sistem penulisan alfabetik ilmiah yang diciptakan oleh Raja Sejong yang Agung pada tahun 1443. Terdiri dari total 40 huruf: 14 konsonan dasar, 5 konsonan ganda, 10 vokal dasar, dan 11 vokal gabungan/diftong. Setiap suku kata dikelompokkan ke dalam satu blok persegi silabel (konsonan awal + vokal + konsonan akhir/batchim).',
            'basic_consonants' => [
                ['char' => 'ㄱ', 'name' => 'Giyeok (기역)', 'sound' => 'g / k'],
                ['char' => 'ㄴ', 'name' => 'Nieun (니은)', 'sound' => 'n'],
                ['char' => 'ㄷ', 'name' => 'Digeut (디귿)', 'sound' => 'd / t'],
                ['char' => 'ㄹ', 'name' => 'Rieul (리을)', 'sound' => 'r / l'],
                ['char' => 'ㅁ', 'name' => 'Mieum (미음)', 'sound' => 'm'],
                ['char' => 'ㅂ', 'name' => 'Bieup (비읍)', 'sound' => 'b / p'],
                ['char' => 'ㅅ', 'name' => 'Siot (시옷)', 'sound' => 's'],
                ['char' => 'ㅇ', 'name' => 'Ieung (이응)', 'sound' => 'silent diawal / ng diakhir'],
                ['char' => 'ㅈ', 'name' => 'Jieut (지읒)', 'sound' => 'j / ch'],
                ['char' => 'ㅊ', 'name' => 'Chieut (치읓)', 'sound' => 'ch (aspirated)'],
                ['char' => 'ㅋ', 'name' => 'Kieuk (키읔)', 'sound' => 'k (aspirated)'],
                ['char' => 'ㅌ', 'name' => 'Tieut (티읕)', 'sound' => 't (aspirated)'],
                ['char' => 'ㅍ', 'name' => 'Pieup (피읖)', 'sound' => 'p (aspirated)'],
                ['char' => 'ㅎ', 'name' => 'Hieut (히읗)', 'sound' => 'h'],
            ],
            'double_consonants' => [
                ['char' => 'ㄲ', 'name' => 'Ssang-giyeok (쌍기역)', 'sound' => 'kk (tense k)'],
                ['char' => 'ㄸ', 'name' => 'Ssang-digeut (쌍디귿)', 'sound' => 'tt (tense t)'],
                ['char' => 'ㅃ', 'name' => 'Ssang-bieup (쌍비읍)', 'sound' => 'pp (tense p)'],
                ['char' => 'ㅆ', 'name' => 'Ssang-siot (쌍시옷)', 'sound' => 'ss (tense s)'],
                ['char' => 'ㅉ', 'name' => 'Ssang-jieut (쌍지읒)', 'sound' => 'jj (tense j)'],
            ],
            'basic_vowels' => [
                ['char' => 'ㅏ', 'romaja' => 'a'], ['char' => 'ㅑ', 'romaja' => 'ya'],
                ['char' => 'ㅓ', 'romaja' => 'eo (o terbuka)'], ['char' => 'ㅕ', 'romaja' => 'yeo'],
                ['char' => 'ㅗ', 'romaja' => 'o (o bulat)'], ['char' => 'ㅛ', 'romaja' => 'yo'],
                ['char' => 'ㅜ', 'romaja' => 'u'], ['char' => 'ㅠ', 'romaja' => 'yu'],
                ['char' => 'ㅡ', 'romaja' => 'eu (seperti "pegal")'], ['char' => 'ㅣ', 'romaja' => 'i'],
            ],
            'compound_vowels' => [
                ['char' => 'ㅐ', 'romaja' => 'ae'], ['char' => 'ㅒ', 'romaja' => 'yae'],
                ['char' => 'ㅔ', 'romaja' => 'e'], ['char' => 'ㅖ', 'romaja' => 'ye'],
                ['char' => 'ㅘ', 'romaja' => 'wa'], ['char' => 'ㅙ', 'romaja' => 'wae'],
                ['char' => 'ㅚ', 'romaja' => 'oe (we)'], ['char' => 'ㅝ', 'romaja' => 'wo'],
                ['char' => 'ㅞ', 'romaja' => 'we'], ['char' => 'ㅟ', 'romaja' => 'wi'],
                ['char' => 'ㅢ', 'romaja' => 'ui'],
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
     * Data 26 Abjad Inggris + Fonem IPA
     */
    private static function getEnglishAlphabetMatrix(): array
    {
        return [
            'overview' => 'Bahasa Inggris menggunakan 26 abjad Latin modern, namun memiliki kurang lebih 44 fonem suara vokal dan konsonan dalam International Phonetic Alphabet (IPA). Memahami relasi grafem-fonem dan stress kata adalah kunci pelafalan fasih standar penutur asli.',
            'letters' => [
                ['char' => 'A a', 'phonetic' => '/eɪ/ ; /æ/', 'sample' => 'Apple, Anchor, Able', 'audio' => 'Apple'],
                ['char' => 'B b', 'phonetic' => '/biː/ ; /b/', 'sample' => 'Book, Bridge, Bright', 'audio' => 'Book'],
                ['char' => 'C c', 'phonetic' => '/siː/ ; /k/, /s/', 'sample' => 'Cat, City, Courage', 'audio' => 'Cat'],
                ['char' => 'D d', 'phonetic' => '/diː/ ; /d/', 'sample' => 'Dream, Doctor, Deep', 'audio' => 'Dream'],
                ['char' => 'E e', 'phonetic' => '/iː/ ; /e/, /iː/', 'sample' => 'Energy, Eagle, Echo', 'audio' => 'Energy'],
                ['char' => 'F f', 'phonetic' => '/ef/ ; /f/', 'sample' => 'Future, Flame, Free', 'audio' => 'Future'],
                ['char' => 'G g', 'phonetic' => '/dʒiː/ ; /ɡ/, /dʒ/', 'sample' => 'Growth, Giant, Great', 'audio' => 'Growth'],
                ['char' => 'H h', 'phonetic' => '/eɪtʃ/ ; /h/', 'sample' => 'Harmony, Hope, Heart', 'audio' => 'Harmony'],
                ['char' => 'I i', 'phonetic' => '/aɪ/ ; /ɪ/, /aɪ/', 'sample' => 'Insight, Island, Impact', 'audio' => 'Insight'],
                ['char' => 'J j', 'phonetic' => '/dʒeɪ/ ; /dʒ/', 'sample' => 'Journey, Joy, Justice', 'audio' => 'Journey'],
                ['char' => 'K k', 'phonetic' => '/keɪ/ ; /k/', 'sample' => 'Knowledge, Key, Kind', 'audio' => 'Key'],
                ['char' => 'L l', 'phonetic' => '/el/ ; /l/', 'sample' => 'Leadership, Light, Life', 'audio' => 'Leadership'],
                ['char' => 'M m', 'phonetic' => '/em/ ; /m/', 'sample' => 'Mastery, Mind, Melody', 'audio' => 'Mastery'],
                ['char' => 'N n', 'phonetic' => '/en/ ; /n/', 'sample' => 'Network, Nature, Noble', 'audio' => 'Network'],
                ['char' => 'O o', 'phonetic' => '/oʊ/ ; /ɒ/, /oʊ/', 'sample' => 'Opportunity, Origin, Open', 'audio' => 'Opportunity'],
                ['char' => 'P p', 'phonetic' => '/piː/ ; /p/', 'sample' => 'Progress, People, Peak', 'audio' => 'Progress'],
                ['char' => 'Q q', 'phonetic' => '/kjuː/ ; /kw/', 'sample' => 'Quality, Quantum, Quest', 'audio' => 'Quality'],
                ['char' => 'R r', 'phonetic' => '/ɑːr/ ; /r/', 'sample' => 'Resilience, Reason, Rise', 'audio' => 'Resilience'],
                ['char' => 'S s', 'phonetic' => '/es/ ; /s/', 'sample' => 'Success, Strategy, Sky', 'audio' => 'Success'],
                ['char' => 'T t', 'phonetic' => '/tiː/ ; /t/', 'sample' => 'Talent, Theory, Trust', 'audio' => 'Talent'],
                ['char' => 'U u', 'phonetic' => '/juː/ ; /ʌ/, /uː/', 'sample' => 'Universe, Unity, Unique', 'audio' => 'Universe'],
                ['char' => 'V v', 'phonetic' => '/viː/ ; /v/', 'sample' => 'Vision, Value, Victory', 'audio' => 'Vision'],
                ['char' => 'W w', 'phonetic' => '/ˈdʌb.əl.juː/ ; /w/', 'sample' => 'Wisdom, World, Wonder', 'audio' => 'Wisdom'],
                ['char' => 'X x', 'phonetic' => '/eks/ ; /ks/, /z/', 'sample' => 'Xylophone, Xenon, Apex', 'audio' => 'Apex'],
                ['char' => 'Y y', 'phonetic' => '/waɪ/ ; /j/, /aɪ/', 'sample' => 'Yield, Youth, Year', 'audio' => 'Yield'],
                ['char' => 'Z z', 'phonetic' => '/zed/ ; /z/', 'sample' => 'Zenith, Zeal, Zone', 'audio' => 'Zenith'],
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
