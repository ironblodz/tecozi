<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable  = [
        'title', 'short_description', 'description', 'category_id', 'main_image', 'highlighted','archived',
    ];


    public function images(): HasMany
    {
        return $this->hasMany(PortfolioImage::class);
    }
}
