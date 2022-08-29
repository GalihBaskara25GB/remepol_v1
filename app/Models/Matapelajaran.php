<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matapelajaran extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'semester',
        'guru',
        'keterangan'
    ];

    public function alternatifs()
    {
        return $this->hasMany('App\Models\Alternatif');
    }
}
