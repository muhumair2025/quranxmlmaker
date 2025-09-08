<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\QuranXml;
use Illuminate\Support\Facades\Storage;

class QuranXmlController extends Controller
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

    public function index()
    {
        return view('home', [
            'cardTitles' => $this->cardTitles
        ]);
    }

    public function audioForm($type)
    {
        if (!array_key_exists($type, $this->cardTitles)) {
            abort(404);
        }

        return view('audio.form', [
            'type' => $type,
            'title' => $this->cardTitles[$type],
            'surahs' => $this->surahs
        ]);
    }

    public function audioFormWithAyah($type, $surah, $ayah)
    {
        if (!array_key_exists($type, $this->cardTitles)) {
            abort(404);
        }

        if (!isset($this->surahs[$surah]) || $ayah > $this->surahs[$surah]['ayahs'] || $ayah < 1) {
            abort(404);
        }

        // Get existing URL if available
        $existingEntry = QuranXml::where([
            'type' => $type,
            'media_type' => 'audio',
            'surah' => $surah,
            'ayah' => $ayah
        ])->first();

        // Get all saved verses for this surah to show indicators
        $savedVerses = QuranXml::where([
            'type' => $type,
            'media_type' => 'audio',
            'surah' => $surah
        ])->pluck('ayah')->toArray();

        return view('audio.form-with-navigation', [
            'type' => $type,
            'title' => $this->cardTitles[$type],
            'surahs' => $this->surahs,
            'currentSurah' => $surah,
            'currentAyah' => $ayah,
            'existingUrl' => $existingEntry ? $existingEntry->link : '',
            'maxAyahs' => $this->surahs[$surah]['ayahs'],
            'savedVerses' => $savedVerses
        ]);
    }

    public function videoForm($type)
    {
        if (!array_key_exists($type, $this->cardTitles)) {
            abort(404);
        }

        return view('video.form', [
            'type' => $type,
            'title' => $this->cardTitles[$type],
            'surahs' => $this->surahs
        ]);
    }

    public function videoFormWithAyah($type, $surah, $ayah)
    {
        if (!array_key_exists($type, $this->cardTitles)) {
            abort(404);
        }

        if (!isset($this->surahs[$surah]) || $ayah > $this->surahs[$surah]['ayahs'] || $ayah < 1) {
            abort(404);
        }

        // Get existing URL if available
        $existingEntry = QuranXml::where([
            'type' => $type,
            'media_type' => 'video',
            'surah' => $surah,
            'ayah' => $ayah
        ])->first();

        // Get all saved verses for this surah to show indicators
        $savedVerses = QuranXml::where([
            'type' => $type,
            'media_type' => 'video',
            'surah' => $surah
        ])->pluck('ayah')->toArray();

        return view('video.form-with-navigation', [
            'type' => $type,
            'title' => $this->cardTitles[$type],
            'surahs' => $this->surahs,
            'currentSurah' => $surah,
            'currentAyah' => $ayah,
            'existingUrl' => $existingEntry ? $existingEntry->link : '',
            'maxAyahs' => $this->surahs[$surah]['ayahs'],
            'savedVerses' => $savedVerses
        ]);
    }

    public function selectSurah($type)
    {
        if (!array_key_exists($type, $this->cardTitles)) {
            abort(404);
        }

        return view('select-surah', [
            'type' => $type,
            'title' => $this->cardTitles[$type],
            'surahs' => $this->surahs
        ]);
    }

    public function saveAudioUrl(Request $request, $type)
    {
        $request->validate([
            'surah' => 'required|integer|min:1|max:114',
            'ayah' => 'required|integer|min:1',
            'audio_link' => 'required|url'
        ]);

        $surahIndex = $request->surah;
        $ayahIndex = $request->ayah;
        $audioLink = $request->audio_link;

        // Validate ayah number for the selected surah
        if ($ayahIndex > $this->surahs[$surahIndex]['ayahs']) {
            return back()->withErrors(['ayah' => 'Verse number is greater than the total verses in this surah']);
        }

        // Save or update the URL
        QuranXml::updateOrCreate([
            'type' => $type,
            'media_type' => 'audio',
            'surah' => $surahIndex,
            'ayah' => $ayahIndex
        ], [
            'link' => $audioLink,
            'filename' => "audio_{$type}_surah_{$surahIndex}_ayah_{$ayahIndex}_" . time() . ".xml",
            'xml_content' => $this->generateXmlContent($surahIndex, $ayahIndex, $audioLink, 'audiolink')
        ]);

        // Determine next action
        $action = $request->input('action');
        
        if ($action === 'generate_complete_xml') {
            return $this->generateCompleteAudioXml($type);
        }
        
        $nextAyah = $ayahIndex;
        $nextSurah = $surahIndex;

        if ($action === 'next') {
            if ($ayahIndex < $this->surahs[$surahIndex]['ayahs']) {
                $nextAyah = $ayahIndex + 1;
            } else if ($surahIndex < 114) {
                $nextSurah = $surahIndex + 1;
                $nextAyah = 1;
            }
        } elseif ($action === 'previous') {
            if ($ayahIndex > 1) {
                $nextAyah = $ayahIndex - 1;
            } else if ($surahIndex > 1) {
                $nextSurah = $surahIndex - 1;
                $nextAyah = $this->surahs[$nextSurah]['ayahs'];
            }
        } elseif ($action === 'stay') {
            // Stay on the same verse - don't navigate
            return redirect()->route('audio.form.ayah', [$type, $surahIndex, $ayahIndex])
                            ->with('success', 'URL saved successfully!');
        }

        return redirect()->route('audio.form.ayah', [$type, $nextSurah, $nextAyah])
                        ->with('success', 'URL saved successfully!');
    }

    public function saveVideoUrl(Request $request, $type)
    {
        $request->validate([
            'surah' => 'required|integer|min:1|max:114',
            'ayah' => 'required|integer|min:1',
            'video_link' => 'required|url'
        ]);

        $surahIndex = $request->surah;
        $ayahIndex = $request->ayah;
        $videoLink = $request->video_link;

        // Validate ayah number for the selected surah
        if ($ayahIndex > $this->surahs[$surahIndex]['ayahs']) {
            return back()->withErrors(['ayah' => 'Verse number is greater than the total verses in this surah']);
        }

        // Save or update the URL
        QuranXml::updateOrCreate([
            'type' => $type,
            'media_type' => 'video',
            'surah' => $surahIndex,
            'ayah' => $ayahIndex
        ], [
            'link' => $videoLink,
            'filename' => "video_{$type}_surah_{$surahIndex}_ayah_{$ayahIndex}_" . time() . ".xml",
            'xml_content' => $this->generateXmlContent($surahIndex, $ayahIndex, $videoLink, 'vidoelink')
        ]);

        // Determine next action
        $action = $request->input('action');
        
        if ($action === 'generate_complete_xml') {
            return $this->generateCompleteVideoXml($type);
        }
        
        $nextAyah = $ayahIndex;
        $nextSurah = $surahIndex;

        if ($action === 'next') {
            if ($ayahIndex < $this->surahs[$surahIndex]['ayahs']) {
                $nextAyah = $ayahIndex + 1;
            } else if ($surahIndex < 114) {
                $nextSurah = $surahIndex + 1;
                $nextAyah = 1;
            }
        } elseif ($action === 'previous') {
            if ($ayahIndex > 1) {
                $nextAyah = $ayahIndex - 1;
            } else if ($surahIndex > 1) {
                $nextSurah = $surahIndex - 1;
                $nextAyah = $this->surahs[$nextSurah]['ayahs'];
            }
        } elseif ($action === 'stay') {
            // Stay on the same verse - don't navigate
            return redirect()->route('video.form.ayah', [$type, $surahIndex, $ayahIndex])
                            ->with('success', 'URL saved successfully!');
        }

        return redirect()->route('video.form.ayah', [$type, $nextSurah, $nextAyah])
                        ->with('success', 'URL saved successfully!');
    }

    public function generateAudioXml(Request $request, $type)
    {
        $request->validate([
            'surah' => 'required|integer|min:1|max:114',
            'ayah' => 'required|integer|min:1',
            'audio_link' => 'required|url'
        ]);

        $surahIndex = $request->surah;
        $ayahIndex = $request->ayah;
        $audioLink = $request->audio_link;

        // Validate ayah number for the selected surah
        if ($ayahIndex > $this->surahs[$surahIndex]['ayahs']) {
            return back()->withErrors(['ayah' => 'Verse number is greater than the total verses in this surah']);
        }

        // Generate XML
        $xml = $this->generateXmlContent($surahIndex, $ayahIndex, $audioLink, 'audiolink');
        
        // Save to database
        $filename = "audio_{$type}_surah_{$surahIndex}_ayah_{$ayahIndex}_" . time() . ".xml";
        $quranXml = QuranXml::create([
            'type' => $type,
            'media_type' => 'audio',
            'surah' => $surahIndex,
            'ayah' => $ayahIndex,
            'link' => $audioLink,
            'filename' => $filename,
            'xml_content' => $xml
        ]);

        // Save XML file to storage
        Storage::put("xml/{$filename}", $xml);

        return view('xml.generated', [
            'xml' => $xml,
            'filename' => $filename,
            'type' => $type,
            'surah' => $this->surahs[$surahIndex],
            'ayah' => $ayahIndex,
            'mediaType' => 'audio'
        ]);
    }

    public function generateVideoXml(Request $request, $type)
    {
        $request->validate([
            'surah' => 'required|integer|min:1|max:114',
            'ayah' => 'required|integer|min:1',
            'video_link' => 'required|url'
        ]);

        $surahIndex = $request->surah;
        $ayahIndex = $request->ayah;
        $videoLink = $request->video_link;

        // Validate ayah number for the selected surah
        if ($ayahIndex > $this->surahs[$surahIndex]['ayahs']) {
            return back()->withErrors(['ayah' => 'Verse number is greater than the total verses in this surah']);
        }

        // Generate XML
        $xml = $this->generateXmlContent($surahIndex, $ayahIndex, $videoLink, 'vidoelink');
        
        // Save to database
        $filename = "video_{$type}_surah_{$surahIndex}_ayah_{$ayahIndex}_" . time() . ".xml";
        $quranXml = QuranXml::create([
            'type' => $type,
            'media_type' => 'video',
            'surah' => $surahIndex,
            'ayah' => $ayahIndex,
            'link' => $videoLink,
            'filename' => $filename,
            'xml_content' => $xml
        ]);

        // Save XML file to storage
        Storage::put("xml/{$filename}", $xml);

        return view('xml.generated', [
            'xml' => $xml,
            'filename' => $filename,
            'type' => $type,
            'surah' => $this->surahs[$surahIndex],
            'ayah' => $ayahIndex,
            'mediaType' => 'video'
        ]);
    }

    public function downloadXml($type, $filename)
    {
        $filePath = "xml/{$filename}";
        
        if (!Storage::exists($filePath)) {
            abort(404);
        }

        return Storage::download($filePath, $filename, [
            'Content-Type' => 'application/xml',
        ]);
    }

    public function generateCompleteAudioXml($type)
    {
        // Get all audio entries for this type
        $entries = QuranXml::where([
            'type' => $type,
            'media_type' => 'audio'
        ])->orderBy('surah')->orderBy('ayah')->get();

        if ($entries->isEmpty()) {
            return back()->with('error', 'No audio URLs found. Please add some URLs first.');
        }

        // Generate complete XML
        $xml = $this->generateCompleteXmlContent($entries, 'audiolink');
        
        // Save XML file
        $filename = "complete_audio_{$type}_" . time() . ".xml";
        Storage::put("xml/{$filename}", $xml);

        return view('xml.generated', [
            'xml' => $xml,
            'filename' => $filename,
            'type' => $type,
            'surah' => ['name' => 'Complete Quran', 'pashto' => 'بشپړ قرآن'],
            'ayah' => $entries->count() . ' verses',
            'mediaType' => 'audio'
        ]);
    }

    public function generateCompleteVideoXml($type)
    {
        // Get all video entries for this type
        $entries = QuranXml::where([
            'type' => $type,
            'media_type' => 'video'
        ])->orderBy('surah')->orderBy('ayah')->get();

        if ($entries->isEmpty()) {
            return back()->with('error', 'No video URLs found. Please add some URLs first.');
        }

        // Generate complete XML
        $xml = $this->generateCompleteXmlContent($entries, 'vidoelink');
        
        // Save XML file
        $filename = "complete_video_{$type}_" . time() . ".xml";
        Storage::put("xml/{$filename}", $xml);

        return view('xml.generated', [
            'xml' => $xml,
            'filename' => $filename,
            'type' => $type,
            'surah' => ['name' => 'Complete Quran', 'pashto' => 'بشپړ قرآن'],
            'ayah' => $entries->count() . ' verses',
            'mediaType' => 'video'
        ]);
    }

    private function generateCompleteXmlContent($entries, $linkAttribute)
    {
        $xml = '<?xml version="1.0" encoding="utf-8" ?>' . "\n";
        $xml .= "<quran>\n";
        
        $currentSurah = null;
        foreach ($entries as $entry) {
            if ($currentSurah !== $entry->surah) {
                // Close previous surah if exists
                if ($currentSurah !== null) {
                    $xml .= "\t</sura>\n";
                }
                // Start new surah
                $xml .= "\t<sura index=\"{$entry->surah}\">\n";
                $currentSurah = $entry->surah;
            }
            
            // Add ayah
            $xml .= "\t\t<aya index=\"{$entry->ayah}\" {$linkAttribute}=\"{$entry->link}\"/>\n";
        }
        
        // Close last surah
        if ($currentSurah !== null) {
            $xml .= "\t</sura>\n";
        }
        
        $xml .= "</quran>";
        
        return $xml;
    }

    private function generateXmlContent($surahIndex, $ayahIndex, $link, $linkAttribute)
    {
        $xml = '<?xml version="1.0" encoding="utf-8" ?>' . "\n";
        $xml .= "<quran>\n";
        $xml .= "\t<sura index=\"{$surahIndex}\">\n";
        $xml .= "\t\t<aya index=\"{$ayahIndex}\" {$linkAttribute}=\"{$link}\"/>\n";
        $xml .= "\t</sura>\n";
        $xml .= "</quran>";
        
        return $xml;
    }
}
