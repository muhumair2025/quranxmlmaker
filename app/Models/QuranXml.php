<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuranXml extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'media_type',
        'surah',
        'ayah',
        'link',
        'filename',
        'xml_content'
    ];

    protected $casts = [
        'surah' => 'integer',
        'ayah' => 'integer',
    ];
}
