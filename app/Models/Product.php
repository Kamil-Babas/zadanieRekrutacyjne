<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nazwa_produktu',
        'producent',
        'jednostka_ceny',
        'waga',
        'srednica',
        'dlugosc',
        'szerokosc',
        'wysokosc',
        'grubosc',
        'typ_opakowania',
        'jednostki_zakupu',
    ];

}
