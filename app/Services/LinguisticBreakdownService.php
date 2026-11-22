<?php

namespace App\Services;

class LinguisticBreakdownService
{
    /**
     * Mengembalikan bedah suku kata dan kata per kata untuk suatu kalimat.
     * Output: array of ['token' => '...', 'syllables' => '...', 'meaning' => '...']
     */
    public static function getBreakdown(string $langCode, string $target, ?string $trans = null, ?string $meaning = null): array
    {
        $cleanTarget = trim($target);
        
        // 1. Cek repositori kalimat yang sudah dipetakan secara mendalam
        $known = self::getKnownSentenceBreakdowns($langCode);
        if (isset($known[$cleanTarget])) {
            return $known[$cleanTarget];
        }

        // 2. Jika belum ada di repositori statis, lakukan algoritma segmentasi otomatis
        return self::autoSegmentSentence($langCode, $cleanTarget, $trans, $meaning);
    }

    /**
     * Database kalimat dan bedah suku kata presisi tinggi
     */
    private static function getKnownSentenceBreakdowns(string $langCode): array
    {
        return match ($langCode) {
            'ar' => [
                'أَنَا طَالِبٌ' => [
                    ['token' => 'أَنَا', 'syllables' => 'A-na', 'meaning' => 'Saya'],
                    ['token' => 'طَالِبٌ', 'syllables' => 'Thaa-li-bun', 'meaning' => 'Siswa / Murid'],
                ],
                'أَنْتَ أُسْتَاذٌ' => [
                    ['token' => 'أَنْتَ', 'syllables' => 'An-ta', 'meaning' => 'Kamu (Laki-laki)'],
                    ['token' => 'أُسْتَاذٌ', 'syllables' => 'Us-taa-dzun', 'meaning' => 'Guru / Dosen'],
                ],
                'هِيَ طَبِيْبَةٌ' => [
                    ['token' => 'هِيَ', 'syllables' => 'Hi-ya', 'meaning' => 'Dia (Perempuan)'],
                    ['token' => 'طَبِيْبَةٌ', 'syllables' => 'Tha-bii-ba-tun', 'meaning' => 'Dokter (Perempuan)'],
                ],
                'السَّلَامُ عَلَيْكُمْ، مَا اسْمُكَ؟' => [
                    ['token' => 'السَّلَامُ', 'syllables' => 'As-sa-laa-mu', 'meaning' => 'Keselamatan / Salam'],
                    ['token' => 'عَلَيْكُمْ', 'syllables' => '\'A-lay-kum', 'meaning' => 'Atas kalian'],
                    ['token' => 'مَا', 'syllables' => 'Maa', 'meaning' => 'Apa / Siapa'],
                    ['token' => 'اسْمُكَ', 'syllables' => 'Is-mu-ka', 'meaning' => 'Namamu'],
                ],
                'وَعَلَيْكُمُ السَّلَامُ، اِسْمِي فَيْصَل.' => [
                    ['token' => 'وَعَلَيْكُمُ', 'syllables' => 'Wa-\'a-lay-ku-mu', 'meaning' => 'Dan atas kalian juga'],
                    ['token' => 'السَّلَامُ', 'syllables' => 'As-sa-laa-mu', 'meaning' => 'Keselamatan'],
                    ['token' => 'اِسْمِي', 'syllables' => 'Is-mii', 'meaning' => 'Nama saya'],
                    ['token' => 'فَيْصَل', 'syllables' => 'Fay-shal', 'meaning' => 'Faisal'],
                ],
                'كَتَبْتُ الرِّسَالَةَ أَمْسِ' => [
                    ['token' => 'كَتَبْتُ', 'syllables' => 'Ka-tab-tu', 'meaning' => 'Saya telah menulis'],
                    ['token' => 'الرِّسَالَةَ', 'syllables' => 'Ar-ri-saa-la-ta', 'meaning' => 'Surat tersebut'],
                    ['token' => 'أَمْسِ', 'syllables' => 'Am-si', 'meaning' => 'Kemarin'],
                ],
                'ذَهَبَ عَلِيٌّ إِلَى السُّوْقِ' => [
                    ['token' => 'ذَهَبَ', 'syllables' => 'Dza-ha-ba', 'meaning' => 'Telah pergi'],
                    ['token' => 'عَلِيٌّ', 'syllables' => '\'A-li-yyun', 'meaning' => 'Ali'],
                    ['token' => 'إِلَى', 'syllables' => 'I-laa', 'meaning' => 'Ke / Menuju'],
                    ['token' => 'السُّوْقِ', 'syllables' => 'As-suu-qi', 'meaning' => 'Pasar'],
                ],
                'هَذَا كِتَابٌ جَدِيدٌ' => [
                    ['token' => 'هَذَا', 'syllables' => 'Haa-dzaa', 'meaning' => 'Ini'],
                    ['token' => 'كِتَابٌ', 'syllables' => 'Ki-taa-bun', 'meaning' => 'Buku'],
                    ['token' => 'جَدِيدٌ', 'syllables' => 'Ja-dii-dun', 'meaning' => 'Baru'],
                ],
            ],
            'ja' => [
                'わたし は がくせい です' => [
                    ['token' => 'わたし', 'syllables' => 'Wa-ta-shi', 'meaning' => 'Saya'],
                    ['token' => 'は', 'syllables' => 'wa', 'meaning' => 'Partikel Topik'],
                    ['token' => 'がくせい', 'syllables' => 'Ga-ku-se-i', 'meaning' => 'Siswa / Mahasiswa'],
                    ['token' => 'です', 'syllables' => 'De-su', 'meaning' => 'Adalah (Kopula Sopan)'],
                ],
                'わたしは がくせい です' => [
                    ['token' => 'わたし', 'syllables' => 'Wa-ta-shi', 'meaning' => 'Saya'],
                    ['token' => 'は', 'syllables' => 'wa', 'meaning' => 'Partikel Topik'],
                    ['token' => 'がくせい', 'syllables' => 'Ga-ku-se-i', 'meaning' => 'Siswa / Mahasiswa'],
                    ['token' => 'です', 'syllables' => 'De-su', 'meaning' => 'Adalah (Kopula Sopan)'],
                ],
                'はじめまして、たなか です。' => [
                    ['token' => 'はじめまして', 'syllables' => 'Ha-ji-me-ma-shi-te', 'meaning' => 'Senang berkenalan'],
                    ['token' => 'たなか', 'syllables' => 'Ta-na-ka', 'meaning' => 'Tanaka'],
                    ['token' => 'です', 'syllables' => 'De-su', 'meaning' => 'Adalah'],
                ],
                'これは あたらしい ほん です' => [
                    ['token' => 'これ', 'syllables' => 'Ko-re', 'meaning' => 'Ini'],
                    ['token' => 'は', 'syllables' => 'wa', 'meaning' => 'Partikel Topik'],
                    ['token' => 'あたらしい', 'syllables' => 'A-ta-ra-shi-i', 'meaning' => 'Baru'],
                    ['token' => 'ほん', 'syllables' => 'Hon', 'meaning' => 'Buku'],
                    ['token' => 'です', 'syllables' => 'De-su', 'meaning' => 'Adalah'],
                ],
            ],
            'ko' => [
                '저는 학생입니다' => [
                    ['token' => '저', 'syllables' => 'Jeo', 'meaning' => 'Saya (Sopan)'],
                    ['token' => '는', 'syllables' => 'neun', 'meaning' => 'Partikel Topik'],
                    ['token' => '학생', 'syllables' => 'Hak-saeng', 'meaning' => 'Siswa / Murid'],
                    ['token' => '입니다', 'syllables' => 'Im-ni-da', 'meaning' => 'Adalah (Formal)'],
                ],
                '이것은 책입니다' => [
                    ['token' => '이것', 'syllables' => 'I-geot', 'meaning' => 'Benda ini'],
                    ['token' => '은', 'syllables' => 'eun', 'meaning' => 'Partikel Topik'],
                    ['token' => '책', 'syllables' => 'Chaek', 'meaning' => 'Buku'],
                    ['token' => '입니다', 'syllables' => 'Im-ni-da', 'meaning' => 'Adalah (Formal)'],
                ],
                '만나서 반갑습니다' => [
                    ['token' => '만나서', 'syllables' => 'Man-na-seo', 'meaning' => 'Karena bertemu'],
                    ['token' => '반갑습니다', 'syllables' => 'Ban-gap-seum-ni-da', 'meaning' => 'Saya senang'],
                ],
                '이것은 새 책입니다' => [
                    ['token' => '이것', 'syllables' => 'I-geot', 'meaning' => 'Ini'],
                    ['token' => '은', 'syllables' => 'eun', 'meaning' => 'Partikel Topik'],
                    ['token' => '새', 'syllables' => 'Sae', 'meaning' => 'Baru'],
                    ['token' => '책', 'syllables' => 'Chaek', 'meaning' => 'Buku'],
                    ['token' => '입니다', 'syllables' => 'Im-ni-da', 'meaning' => 'Adalah'],
                ],
            ],
            'en' => [
                'This is a new book' => [
                    ['token' => 'This', 'syllables' => 'ðɪs', 'meaning' => 'Ini'],
                    ['token' => 'is', 'syllables' => 'ɪz', 'meaning' => 'Adalah'],
                    ['token' => 'a', 'syllables' => 'ə', 'meaning' => 'Sebuah'],
                    ['token' => 'new', 'syllables' => 'njuː', 'meaning' => 'Baru'],
                    ['token' => 'book', 'syllables' => 'bʊk', 'meaning' => 'Buku'],
                ],
                'I am a student' => [
                    ['token' => 'I', 'syllables' => 'aɪ', 'meaning' => 'Saya'],
                    ['token' => 'am', 'syllables' => 'æm', 'meaning' => 'Adalah'],
                    ['token' => 'a', 'syllables' => 'ə', 'meaning' => 'Seorang'],
                    ['token' => 'student', 'syllables' => 'ˈstjuː.dənt', 'meaning' => 'Murid / Siswa'],
                ]
            ],
            default => []
        };
    }

    /**
     * Segmentasi kata dan perkiraan suku kata secara dinamis jika kalimat kustom
     */
    private static function autoSegmentSentence(string $langCode, string $target, ?string $trans, ?string $meaning): array
    {
        // Pisahkan token berdasarkan spasi
        $words = preg_split('/\s+/u', trim($target), -1, PREG_SPLIT_NO_EMPTY);
        $transWords = $trans ? preg_split('/\s+/u', trim($trans), -1, PREG_SPLIT_NO_EMPTY) : [];
        $meaningWords = $meaning ? preg_split('/\s+/u', trim($meaning), -1, PREG_SPLIT_NO_EMPTY) : [];

        $breakdown = [];
        $count = count($words);

        for ($i = 0; $i < $count; $i++) {
            $w = $words[$i];
            $t = $transWords[$i] ?? self::estimateSyllables($langCode, $w);
            $m = $meaningWords[$i] ?? (count($meaningWords) === 1 ? $meaningWords[0] : 'Bagian kalimat');

            $breakdown[] = [
                'token' => $w,
                'syllables' => $t,
                'meaning' => $m,
            ];
        }

        return $breakdown;
    }

    /**
     * Estimasi bunyi suku kata berdasarkan karakter
     */
    private static function estimateSyllables(string $langCode, string $word): string
    {
        return match ($langCode) {
            'ja' => preg_replace('/(.)/u', '$1-', rtrim($word, '-')),
            'ko' => preg_replace('/(.)/u', '$1-', rtrim($word, '-')),
            default => $word,
        };
    }
}
