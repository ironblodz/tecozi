<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioCategory extends Model
{
    use HasFactory;

    protected $table = "portfolio_categories";

    protected $fillable = [
        'name',
        'img',
        'subtitle',
        'reference',
        'label',
        'description',
        'archived',
        'visible_in_materials',
        'visible_on_portfolio',
    ];

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function photos()
{
    return $this->hasMany(CategoryPhoto::class, 'category_id');
}


}
