<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialPhoto extends Model
{
    use HasFactory;

    protected $fillable = ['material_id', 'photo'];

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
