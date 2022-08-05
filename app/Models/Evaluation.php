<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'alternatif_id',
        'kriteria_id',
        'value',
    ];

    public function alternatif()
    {
        return $this->belongsTo('App\Models\Alternatif');
    }

    public function kriteria()
    {
        return $this->belongsTo('App\Models\Kriteria');
    }
}
