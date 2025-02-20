<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MaterialPhoto;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'photo'];

    public function photos()
{
    return $this->hasMany(MaterialPhoto::class);
}

}
