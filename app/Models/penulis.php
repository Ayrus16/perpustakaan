<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penulis extends Model
{
    use HasFactory;
    protected $fillable = ['nama_penulis','cerita_singkat', 'slug'];

    public function posts(){
        return $this->hasMany(Buku::class);
    }
}
