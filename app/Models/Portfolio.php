<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable  = [
        'title', 'short_description', 'description', 'category_id', 'main_image', 'highlighted','archived, order',
    ];

    public function category()
    {
        return $this->belongsTo(PortfolioCategory::class, 'category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(PortfolioImage::class);
    }
}
