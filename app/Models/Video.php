<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';
    protected $fillable = [
        'video_url',
        'caption',
        'author_id',
        'created_at',
        'updated_at'
    ];
    public function likes()
    {
        return $this->hasMany('\App\Models\Like', 'video_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo('\App\Models\User', 'author_id', 'id');
    }
}
