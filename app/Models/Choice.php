<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Choice extends Model
{
    use HasFactory;

    protected $fillable = ['chapter_id', 'label', 'target_chapter_id'];

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function targetChapter()
    {
        return $this->belongsTo(Chapter::class, 'target_chapter_id');
    }
}
