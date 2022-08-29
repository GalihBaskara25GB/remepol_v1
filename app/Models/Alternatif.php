<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alternatif extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'keterangan',
        'matapelajaran_id',
    ];

    public function matapelajaran()
    {
        return $this->belongsTo('App\Models\Matapelajaran');
    }

    public function evaluations()
    {
        return $this->hasMany('App\Models\Evaluation');
    }
}
