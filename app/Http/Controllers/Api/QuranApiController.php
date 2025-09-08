<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuranXml;
use Illuminate\Http\Request;

class QuranApiController extends Controller
{
    // Pashto card titles
    private $cardTitles = [
        'lughat' => 'د آیه لغات',
        'tafseer' => 'د آیات تفسیر', 
        'faidi' => 'د آیات فایدی'
    ];

    // Surah names in Pashto and Arabic
    private $surahs = [
        1 => ['name' => 'الفاتحه', 'pashto' => 'فاتحه', 'ayahs' => 7],
        2 => ['name' => 'البقرة', 'pashto' => 'بقره', 'ayahs' => 286],
        3 => ['name' => 'آل عمران', 'pashto' => 'آل عمران', 'ayahs' => 200],
        4 => ['name' => 'النساء', 'pashto' => 'نساء', 'ayahs' => 176],
        5 => ['name' => 'المائدة', 'pashto' => 'مائده', 'ayahs' => 120],
        6 => ['name' => 'الأنعام', 'pashto' => 'انعام', 'ayahs' => 165],
        7 => ['name' => 'الأعراف', 'pashto' => 'اعراف', 'ayahs' => 206],
        8 => ['name' => 'الأنفال', 'pashto' => 'انفال', 'ayahs' => 75],
        9 => ['name' => 'التوبة', 'pashto' => 'توبه', 'ayahs' => 129],
        10 => ['name' => 'يونس', 'pashto' => 'یونس', 'ayahs' => 109],
        11 => ['name' => 'هود', 'pashto' => 'هود', 'ayahs' => 123],
        12 => ['name' => 'يوسف', 'pashto' => 'یوسف', 'ayahs' => 111],
        13 => ['name' => 'الرعد', 'pashto' => 'رعد', 'ayahs' => 43],
        14 => ['name' => 'إبراهيم', 'pashto' => 'ابراهیم', 'ayahs' => 52],
        15 => ['name' => 'الحجر', 'pashto' => 'حجر', 'ayahs' => 99],
        16 => ['name' => 'النحل', 'pashto' => 'نحل', 'ayahs' => 128],
        17 => ['name' => 'الإسراء', 'pashto' => 'اسراء', 'ayahs' => 111],
        18 => ['name' => 'الكهف', 'pashto' => 'کهف', 'ayahs' => 110],
        19 => ['name' => 'مريم', 'pashto' => 'مریم', 'ayahs' => 98],
        20 => ['name' => 'طه', 'pashto' => 'طه', 'ayahs' => 135],
        21 => ['name' => 'الأنبياء', 'pashto' => 'انبیاء', 'ayahs' => 112],
        22 => ['name' => 'الحج', 'pashto' => 'حج', 'ayahs' => 78],
        23 => ['name' => 'المؤمنون', 'pashto' => 'مؤمنون', 'ayahs' => 118],
        24 => ['name' => 'النور', 'pashto' => 'نور', 'ayahs' => 64],
        25 => ['name' => 'الفرقان', 'pashto' => 'فرقان', 'ayahs' => 77],
        26 => ['name' => 'الشعراء', 'pashto' => 'شعراء', 'ayahs' => 227],
        27 => ['name' => 'النمل', 'pashto' => 'نمل', 'ayahs' => 93],
        28 => ['name' => 'القصص', 'pashto' => 'قصص', 'ayahs' => 88],
        29 => ['name' => 'العنكبوت', 'pashto' => 'عنکبوت', 'ayahs' => 69],
        30 => ['name' => 'الروم', 'pashto' => 'روم', 'ayahs' => 60],
        31 => ['name' => 'لقمان', 'pashto' => 'لقمان', 'ayahs' => 34],
        32 => ['name' => 'السجدة', 'pashto' => 'سجده', 'ayahs' => 30],
        33 => ['name' => 'الأحزاب', 'pashto' => 'احزاب', 'ayahs' => 73],
        34 => ['name' => 'سبأ', 'pashto' => 'سبا', 'ayahs' => 54],
        35 => ['name' => 'فاطر', 'pashto' => 'فاطر', 'ayahs' => 45],
        36 => ['name' => 'يس', 'pashto' => 'یس', 'ayahs' => 83],
        37 => ['name' => 'الصافات', 'pashto' => 'صافات', 'ayahs' => 182],
        38 => ['name' => 'ص', 'pashto' => 'ص', 'ayahs' => 88],
        39 => ['name' => 'الزمر', 'pashto' => 'زمر', 'ayahs' => 75],
        40 => ['name' => 'غافر', 'pashto' => 'غافر', 'ayahs' => 85],
        41 => ['name' => 'فصلت', 'pashto' => 'فصلت', 'ayahs' => 54],
        42 => ['name' => 'الشورى', 'pashto' => 'شوری', 'ayahs' => 53],
        43 => ['name' => 'الزخرف', 'pashto' => 'زخرف', 'ayahs' => 89],
        44 => ['name' => 'الدخان', 'pashto' => 'دخان', 'ayahs' => 59],
        45 => ['name' => 'الجاثية', 'pashto' => 'جاثیه', 'ayahs' => 37],
        46 => ['name' => 'الأحقاف', 'pashto' => 'احقاف', 'ayahs' => 35],
        47 => ['name' => 'محمد', 'pashto' => 'محمد', 'ayahs' => 38],
        48 => ['name' => 'الفتح', 'pashto' => 'فتح', 'ayahs' => 29],
        49 => ['name' => 'الحجرات', 'pashto' => 'حجرات', 'ayahs' => 18],
        50 => ['name' => 'ق', 'pashto' => 'ق', 'ayahs' => 45],
        51 => ['name' => 'الذاريات', 'pashto' => 'ذاریات', 'ayahs' => 60],
        52 => ['name' => 'الطور', 'pashto' => 'طور', 'ayahs' => 49],
        53 => ['name' => 'النجم', 'pashto' => 'نجم', 'ayahs' => 62],
        54 => ['name' => 'القمر', 'pashto' => 'قمر', 'ayahs' => 55],
        55 => ['name' => 'الرحمن', 'pashto' => 'رحمن', 'ayahs' => 78],
        56 => ['name' => 'الواقعة', 'pashto' => 'واقعه', 'ayahs' => 96],
        57 => ['name' => 'الحديد', 'pashto' => 'حدید', 'ayahs' => 29],
        58 => ['name' => 'المجادلة', 'pashto' => 'مجادله', 'ayahs' => 22],
        59 => ['name' => 'الحشر', 'pashto' => 'حشر', 'ayahs' => 24],
        60 => ['name' => 'الممتحنة', 'pashto' => 'ممتحنه', 'ayahs' => 13],
        61 => ['name' => 'الصف', 'pashto' => 'صف', 'ayahs' => 14],
        62 => ['name' => 'الجمعة', 'pashto' => 'جمعه', 'ayahs' => 11],
        63 => ['name' => 'المنافقون', 'pashto' => 'منافقون', 'ayahs' => 11],
        64 => ['name' => 'التغابن', 'pashto' => 'تغابن', 'ayahs' => 18],
        65 => ['name' => 'الطلاق', 'pashto' => 'طلاق', 'ayahs' => 12],
        66 => ['name' => 'التحريم', 'pashto' => 'تحریم', 'ayahs' => 12],
        67 => ['name' => 'الملك', 'pashto' => 'ملک', 'ayahs' => 30],
        68 => ['name' => 'القلم', 'pashto' => 'قلم', 'ayahs' => 52],
        69 => ['name' => 'الحاقة', 'pashto' => 'حاقه', 'ayahs' => 52],
        70 => ['name' => 'المعارج', 'pashto' => 'معارج', 'ayahs' => 44],
        71 => ['name' => 'نوح', 'pashto' => 'نوح', 'ayahs' => 28],
        72 => ['name' => 'الجن', 'pashto' => 'جن', 'ayahs' => 28],
        73 => ['name' => 'المزمل', 'pashto' => 'مزمل', 'ayahs' => 20],
        74 => ['name' => 'المدثر', 'pashto' => 'مدثر', 'ayahs' => 56],
        75 => ['name' => 'القيامة', 'pashto' => 'قیامه', 'ayahs' => 40],
        76 => ['name' => 'الإنسان', 'pashto' => 'انسان', 'ayahs' => 31],
        77 => ['name' => 'المرسلات', 'pashto' => 'مرسلات', 'ayahs' => 50],
        78 => ['name' => 'النبأ', 'pashto' => 'نبا', 'ayahs' => 40],
        79 => ['name' => 'النازعات', 'pashto' => 'نازعات', 'ayahs' => 46],
        80 => ['name' => 'عبس', 'pashto' => 'عبس', 'ayahs' => 42],
        81 => ['name' => 'التكوير', 'pashto' => 'تکویر', 'ayahs' => 29],
        82 => ['name' => 'الانفطار', 'pashto' => 'انفطار', 'ayahs' => 19],
        83 => ['name' => 'المطففين', 'pashto' => 'مطففین', 'ayahs' => 36],
        84 => ['name' => 'الانشقاق', 'pashto' => 'انشقاق', 'ayahs' => 25],
        85 => ['name' => 'البروج', 'pashto' => 'بروج', 'ayahs' => 22],
        86 => ['name' => 'الطارق', 'pashto' => 'طارق', 'ayahs' => 17],
        87 => ['name' => 'الأعلى', 'pashto' => 'اعلی', 'ayahs' => 19],
        88 => ['name' => 'الغاشية', 'pashto' => 'غاشیه', 'ayahs' => 26],
        89 => ['name' => 'الفجر', 'pashto' => 'فجر', 'ayahs' => 30],
        90 => ['name' => 'البلد', 'pashto' => 'بلد', 'ayahs' => 20],
        91 => ['name' => 'الشمس', 'pashto' => 'شمس', 'ayahs' => 15],
        92 => ['name' => 'الليل', 'pashto' => 'لیل', 'ayahs' => 21],
        93 => ['name' => 'الضحى', 'pashto' => 'ضحی', 'ayahs' => 11],
        94 => ['name' => 'الشرح', 'pashto' => 'شرح', 'ayahs' => 8],
        95 => ['name' => 'التين', 'pashto' => 'تین', 'ayahs' => 8],
        96 => ['name' => 'العلق', 'pashto' => 'علق', 'ayahs' => 19],
        97 => ['name' => 'القدر', 'pashto' => 'قدر', 'ayahs' => 5],
        98 => ['name' => 'البينة', 'pashto' => 'بینه', 'ayahs' => 8],
        99 => ['name' => 'الزلزلة', 'pashto' => 'زلزله', 'ayahs' => 8],
        100 => ['name' => 'العاديات', 'pashto' => 'عادیات', 'ayahs' => 11],
        101 => ['name' => 'القارعة', 'pashto' => 'قارعه', 'ayahs' => 11],
        102 => ['name' => 'التكاثر', 'pashto' => 'تکاثر', 'ayahs' => 8],
        103 => ['name' => 'العصر', 'pashto' => 'عصر', 'ayahs' => 3],
        104 => ['name' => 'الهمزة', 'pashto' => 'همزه', 'ayahs' => 9],
        105 => ['name' => 'الفيل', 'pashto' => 'فیل', 'ayahs' => 5],
        106 => ['name' => 'قريش', 'pashto' => 'قریش', 'ayahs' => 4],
        107 => ['name' => 'الماعون', 'pashto' => 'ماعون', 'ayahs' => 7],
        108 => ['name' => 'الكوثر', 'pashto' => 'کوثر', 'ayahs' => 3],
        109 => ['name' => 'الكافرون', 'pashto' => 'کافرون', 'ayahs' => 6],
        110 => ['name' => 'النصر', 'pashto' => 'نصر', 'ayahs' => 3],
        111 => ['name' => 'المسد', 'pashto' => 'مسد', 'ayahs' => 5],
        112 => ['name' => 'الإخلاص', 'pashto' => 'اخلاص', 'ayahs' => 4],
        113 => ['name' => 'الفلق', 'pashto' => 'فلق', 'ayahs' => 5],
        114 => ['name' => 'الناس', 'pashto' => 'ناس', 'ayahs' => 6]
    ];

    /**
     * Get all sections data for a specific ayah
     * GET /api/ayah/{surah}/{ayah}
     */
    public function getAyahData($surah, $ayah)
    {
        // Validate surah and ayah
        if (!isset($this->surahs[$surah]) || $ayah < 1 || $ayah > $this->surahs[$surah]['ayahs']) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid surah or ayah number'
            ], 404);
        }

        $data = [];
        
        foreach (['lughat', 'tafseer', 'faidi'] as $type) {
            $audioEntry = QuranXml::where([
                'type' => $type,
                'media_type' => 'audio',
                'surah' => $surah,
                'ayah' => $ayah
            ])->first();

            $videoEntry = QuranXml::where([
                'type' => $type,
                'media_type' => 'video',
                'surah' => $surah,
                'ayah' => $ayah
            ])->first();

            $data[$type] = [
                'success' => true,
                'section_name' => $this->cardTitles[$type],
                'section_key' => $type,
                'surah' => (string)$surah,
                'ayah' => (string)$ayah,
                'surah_info' => [
                    'name_arabic' => $this->surahs[$surah]['name'],
                    'name_pashto' => $this->surahs[$surah]['pashto'],
                    'total_ayahs' => $this->surahs[$surah]['ayahs']
                ],
                'audio_url' => $audioEntry ? $audioEntry->link : null,
                'video_url' => $videoEntry ? $videoEntry->link : null
            ];
        }

        return response()->json($data);
    }

    /**
     * Get specific section data for an ayah
     * GET /api/ayah/{surah}/{ayah}/{type}
     */
    public function getAyahTypeData($surah, $ayah, $type)
    {
        // Validate inputs
        if (!isset($this->surahs[$surah]) || $ayah < 1 || $ayah > $this->surahs[$surah]['ayahs']) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid surah or ayah number'
            ], 404);
        }

        if (!array_key_exists($type, $this->cardTitles)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid section type. Valid types: lughat, tafseer, faidi'
            ], 404);
        }

        $audioEntry = QuranXml::where([
            'type' => $type,
            'media_type' => 'audio',
            'surah' => $surah,
            'ayah' => $ayah
        ])->first();

        $videoEntry = QuranXml::where([
            'type' => $type,
            'media_type' => 'video',
            'surah' => $surah,
            'ayah' => $ayah
        ])->first();

        return response()->json([
            'success' => true,
            'section_name' => $this->cardTitles[$type],
            'section_key' => $type,
            'surah' => (string)$surah,
            'ayah' => (string)$ayah,
            'surah_info' => [
                'name_arabic' => $this->surahs[$surah]['name'],
                'name_pashto' => $this->surahs[$surah]['pashto'],
                'total_ayahs' => $this->surahs[$surah]['ayahs']
            ],
            'audio_url' => $audioEntry ? $audioEntry->link : null,
            'video_url' => $videoEntry ? $videoEntry->link : null
        ]);
    }

    /**
     * Get all data for a specific section (lughat, tafseer, faidi)
     * GET /api/section/{type}
     */
    public function getSectionData($type)
    {
        if (!array_key_exists($type, $this->cardTitles)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid section type. Valid types: lughat, tafseer, faidi'
            ], 404);
        }

        $entries = QuranXml::where('type', $type)
            ->orderBy('surah')
            ->orderBy('ayah')
            ->orderBy('media_type')
            ->get();

        $data = [];
        
        foreach ($entries as $entry) {
            $key = "surah_{$entry->surah}_ayah_{$entry->ayah}";
            
            if (!isset($data[$key])) {
                $data[$key] = [
                    'success' => true,
                    'section_name' => $this->cardTitles[$type],
                    'section_key' => $type,
                    'surah' => (string)$entry->surah,
                    'ayah' => (string)$entry->ayah,
                    'surah_info' => [
                        'name_arabic' => $this->surahs[$entry->surah]['name'],
                        'name_pashto' => $this->surahs[$entry->surah]['pashto'],
                        'total_ayahs' => $this->surahs[$entry->surah]['ayahs']
                    ],
                    'audio_url' => null,
                    'video_url' => null
                ];
            }
            
            if ($entry->media_type === 'audio') {
                $data[$key]['audio_url'] = $entry->link;
            } else {
                $data[$key]['video_url'] = $entry->link;
            }
        }

        return response()->json([
            'success' => true,
            'section_name' => $this->cardTitles[$type],
            'section_key' => $type,
            'total_entries' => count($data),
            'data' => array_values($data)
        ]);
    }

    /**
     * Get all data for a specific surah and section
     * GET /api/surah/{surah}/{type}
     */
    public function getSurahSectionData($surah, $type)
    {
        // Validate inputs
        if (!isset($this->surahs[$surah])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid surah number'
            ], 404);
        }

        if (!array_key_exists($type, $this->cardTitles)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid section type. Valid types: lughat, tafseer, faidi'
            ], 404);
        }

        $entries = QuranXml::where([
            'type' => $type,
            'surah' => $surah
        ])->orderBy('ayah')->orderBy('media_type')->get();

        $data = [];
        
        foreach ($entries as $entry) {
            $key = "ayah_{$entry->ayah}";
            
            if (!isset($data[$key])) {
                $data[$key] = [
                    'success' => true,
                    'section_name' => $this->cardTitles[$type],
                    'section_key' => $type,
                    'surah' => (string)$entry->surah,
                    'ayah' => (string)$entry->ayah,
                    'surah_info' => [
                        'name_arabic' => $this->surahs[$entry->surah]['name'],
                        'name_pashto' => $this->surahs[$entry->surah]['pashto'],
                        'total_ayahs' => $this->surahs[$entry->surah]['ayahs']
                    ],
                    'audio_url' => null,
                    'video_url' => null
                ];
            }
            
            if ($entry->media_type === 'audio') {
                $data[$key]['audio_url'] = $entry->link;
            } else {
                $data[$key]['video_url'] = $entry->link;
            }
        }

        return response()->json([
            'success' => true,
            'section_name' => $this->cardTitles[$type],
            'section_key' => $type,
            'surah' => (string)$surah,
            'surah_info' => [
                'name_arabic' => $this->surahs[$surah]['name'],
                'name_pashto' => $this->surahs[$surah]['pashto'],
                'total_ayahs' => $this->surahs[$surah]['ayahs']
            ],
            'total_entries' => count($data),
            'data' => array_values($data)
        ]);
    }

    /**
     * Get all available surahs with their info
     * GET /api/surahs
     */
    public function getSurahs()
    {
        return response()->json([
            'success' => true,
            'total_surahs' => count($this->surahs),
            'surahs' => $this->surahs
        ]);
    }

    /**
     * Get specific surah info
     * GET /api/surah/{surah}
     */
    public function getSurahInfo($surah)
    {
        if (!isset($this->surahs[$surah])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid surah number'
            ], 404);
        }

        // Get statistics for this surah
        $stats = [];
        foreach (['lughat', 'tafseer', 'faidi'] as $type) {
            $audioCount = QuranXml::where([
                'type' => $type,
                'media_type' => 'audio',
                'surah' => $surah
            ])->count();

            $videoCount = QuranXml::where([
                'type' => $type,
                'media_type' => 'video',
                'surah' => $surah
            ])->count();

            $stats[$type] = [
                'section_name' => $this->cardTitles[$type],
                'audio_count' => $audioCount,
                'video_count' => $videoCount,
                'total_count' => $audioCount + $videoCount
            ];
        }

        return response()->json([
            'success' => true,
            'surah' => (string)$surah,
            'surah_info' => [
                'name_arabic' => $this->surahs[$surah]['name'],
                'name_pashto' => $this->surahs[$surah]['pashto'],
                'total_ayahs' => $this->surahs[$surah]['ayahs']
            ],
            'statistics' => $stats
        ]);
    }
}