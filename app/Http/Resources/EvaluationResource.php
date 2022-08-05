<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EvaluationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'alternatif_nama' => $this->alternatif->nama,
            'alternatif_id' => $this->alternatif->id,
            'kriteria_nama' => $this->kriteria->nama,
            'kriteria_id' => $this->kriteria->id,
            'created_at' => $this->created_at->format('Y-m-d h:i'),
            'updated_at' => $this->updated_at->format('Y-m-d h:i'),
        ];
    }
}
