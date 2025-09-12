<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Block extends Model
{
    use HasFactory;
    protected $fillable = ['page_id', 'type', 'content', 'order', 'status'];

    protected $casts = ['content' => 'array'];  

    public function page() {
        return $this->belongsTo(Page::class);
    }
}
