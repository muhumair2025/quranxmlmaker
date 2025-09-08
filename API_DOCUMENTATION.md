# Quran XML Maker API Documentation

## Base URL
```
http://your-domain.com/api
```

## Available Endpoints

### 1. Get All Sections Data for a Specific Ayah
**Endpoint:** `GET /api/ayah/{surah}/{ayah}`

**Example:** `GET /api/ayah/1/1`

**Response:**
```json
{
    "success": true,
    "surah": 1,
    "ayah": 1,
    "data": {
        "lughat": {
            "section_name": "د آیه لغات",
            "section_key": "lughat",
            "surah": 1,
            "ayah": 1,
            "surah_info": {
                "name_arabic": "الفاتحه",
                "name_pashto": "فاتحه",
                "total_ayahs": 7
            },
            "audio_url": "https://example.com/audio1.mp3",
            "video_url": "https://example.com/video1.mp4",
            "has_audio": true,
            "has_video": true
        },
        "tafseer": {
            "section_name": "د آیات تفسیر",
            "section_key": "tafseer",
            "surah": 1,
            "ayah": 1,
            "surah_info": {
                "name_arabic": "الفاتحه",
                "name_pashto": "فاتحه",
                "total_ayahs": 7
            },
            "audio_url": null,
            "video_url": "https://example.com/video2.mp4",
            "has_audio": false,
            "has_video": true
        },
        "faidi": {
            "section_name": "د آیات فایدی",
            "section_key": "faidi",
            "surah": 1,
            "ayah": 1,
            "surah_info": {
                "name_arabic": "الفاتحه",
                "name_pashto": "فاتحه",
                "total_ayahs": 7
            },
            "audio_url": "https://example.com/audio3.mp3",
            "video_url": null,
            "has_audio": true,
            "has_video": false
        }
    }
}
```

### 2. Get Specific Section Data for an Ayah
**Endpoint:** `GET /api/ayah/{surah}/{ayah}/{type}`

**Example:** `GET /api/ayah/1/1/lughat`

**Response:**
```json
{
    "success": true,
    "section_name": "د آیه لغات",
    "section_key": "lughat",
    "surah": 1,
    "ayah": 1,
    "surah_info": {
        "name_arabic": "الفاتحه",
        "name_pashto": "فاتحه",
        "total_ayahs": 7
    },
    "audio_url": "https://example.com/audio1.mp3",
    "video_url": "https://example.com/video1.mp4",
    "has_audio": true,
    "has_video": true
}
```

### 3. Get All Data for a Specific Section
**Endpoint:** `GET /api/section/{type}`

**Example:** `GET /api/section/lughat`

**Response:**
```json
{
    "success": true,
    "section_name": "د آیه لغات",
    "section_key": "lughat",
    "total_entries": 2,
    "data": [
        {
            "section_name": "د آیه لغات",
            "section_key": "lughat",
            "surah": 1,
            "ayah": 1,
            "surah_info": {
                "name_arabic": "الفاتحه",
                "name_pashto": "فاتحه",
                "total_ayahs": 7
            },
            "audio_url": "https://example.com/audio1.mp3",
            "video_url": "https://example.com/video1.mp4",
            "has_audio": true,
            "has_video": true
        },
        {
            "section_name": "د آیه لغات",
            "section_key": "lughat",
            "surah": 1,
            "ayah": 2,
            "surah_info": {
                "name_arabic": "الفاتحه",
                "name_pashto": "فاتحه",
                "total_ayahs": 7
            },
            "audio_url": null,
            "video_url": "https://example.com/video2.mp4",
            "has_audio": false,
            "has_video": true
        }
    ]
}
```

### 4. Get All Data for a Specific Surah and Section
**Endpoint:** `GET /api/surah/{surah}/{type}`

**Example:** `GET /api/surah/1/lughat`

**Response:**
```json
{
    "success": true,
    "section_name": "د آیه لغات",
    "section_key": "lughat",
    "surah": 1,
    "surah_info": {
        "name_arabic": "الفاتحه",
        "name_pashto": "فاتحه",
        "total_ayahs": 7
    },
    "total_entries": 3,
    "data": [
        {
            "section_name": "د آیه لغات",
            "section_key": "lughat",
            "surah": 1,
            "ayah": 1,
            "surah_info": {
                "name_arabic": "الفاتحه",
                "name_pashto": "فاتحه",
                "total_ayahs": 7
            },
            "audio_url": "https://example.com/audio1.mp3",
            "video_url": "https://example.com/video1.mp4",
            "has_audio": true,
            "has_video": true
        }
    ]
}
```

### 5. Get All Available Surahs
**Endpoint:** `GET /api/surahs`

**Response:**
```json
{
    "success": true,
    "total_surahs": 114,
    "surahs": {
        "1": {
            "name": "الفاتحه",
            "pashto": "فاتحه",
            "ayahs": 7
        },
        "2": {
            "name": "البقرة",
            "pashto": "بقره",
            "ayahs": 286
        }
        // ... all 114 surahs
    }
}
```

### 6. Get Specific Surah Info with Statistics
**Endpoint:** `GET /api/surah/{surah}`

**Example:** `GET /api/surah/1`

**Response:**
```json
{
    "success": true,
    "surah": 1,
    "surah_info": {
        "name_arabic": "الفاتحه",
        "name_pashto": "فاتحه",
        "total_ayahs": 7
    },
    "statistics": {
        "lughat": {
            "section_name": "د آیه لغات",
            "audio_count": 5,
            "video_count": 3,
            "total_count": 8
        },
        "tafseer": {
            "section_name": "د آیات تفسیر",
            "audio_count": 2,
            "video_count": 4,
            "total_count": 6
        },
        "faidi": {
            "section_name": "د آیات فایدی",
            "audio_count": 1,
            "video_count": 2,
            "total_count": 3
        }
    }
}
```

## Section Types
- `lughat` - د آیه لغات (Verse Vocabulary)
- `tafseer` - د آیات تفسیر (Verse Commentary/Interpretation)
- `faidi` - د آیات فایدی (Verse Benefits/Lessons)

## Error Responses
```json
{
    "success": false,
    "message": "Invalid surah or ayah number"
}
```

## Usage Examples for Android App

### Get data for Surah 1, Ayah 1, Lughat section:
```
GET /api/ayah/1/1/lughat
```

### Get all Lughat data:
```
GET /api/section/lughat
```

### Get all Lughat data for Surah 1:
```
GET /api/surah/1/lughat
```

### Get complete data for Ayah (all sections):
```
GET /api/ayah/1/1
```

## Response Format
All responses include:
- `success`: Boolean indicating if request was successful
- `section_name`: Pashto name of the section
- `section_key`: English key (lughat/tafseer/faidi)
- `surah`: Surah number
- `ayah`: Ayah number
- `surah_info`: Arabic name, Pashto name, and total ayahs
- `audio_url`: URL to audio file (null if not available)
- `video_url`: URL to video file (null if not available)
- `has_audio`: Boolean indicating if audio is available
- `has_video`: Boolean indicating if video is available
