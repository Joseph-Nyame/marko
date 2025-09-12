<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'url', 'order', 'parent_id'];

    public function children() {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }
}
