<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'status', 'meta_description'];

    public function blocks() {
        return $this->hasMany(Block::class)->orderBy('order');
    }
}
