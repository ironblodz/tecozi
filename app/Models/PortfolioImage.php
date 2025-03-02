<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PortfolioImage extends Model
{
    use HasFactory;

    protected $table = "portfolio_images";

    protected $fillable = [
        'portfolio_id',
        'path',
        'type',
    ];

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
