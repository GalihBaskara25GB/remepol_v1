<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MatakuliahResource extends JsonResource
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
            'nama' => $this->nama,
            'dosen' => $this->dosen,
            'semester' => $this->semester,
            'keterangan' => $this->keterangan,
            'created_at' => $this->created_at->format('Y-m-d h:i'),
            'updated_at' => $this->updated_at->format('Y-m-d h:i'),
        ];
    }
}
