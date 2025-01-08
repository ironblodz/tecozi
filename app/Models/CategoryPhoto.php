<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPhoto extends Model
{
    use HasFactory;

    protected $table = "category_photos";

    protected $fillable = [
        'category_id',
        'photo_path',
    ];

    public function category()
    {
        return $this->belongsTo(PortfolioCategory::class, 'category_id');
    }
}
