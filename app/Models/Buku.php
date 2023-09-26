<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Buku extends Model implements HasMedia
{
    use HasFactory,InteractsWithMedia;
    protected $fillable = [
        'judul_buku', 
        'slug',
        'sinopsis', 
        'kategori_id',
        'penulis_id',
        'penerbit_id'];

    public function kategori(){
        return $this->belongsTo(Kategori::class);
    }
    public function penerbit(){
        return $this->belongsTo(Penerbit::class);
    }
    public function penulis(){
        return $this->belongsTo(penulis::class);
    }

}
