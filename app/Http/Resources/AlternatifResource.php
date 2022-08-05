<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlternatifResource extends JsonResource
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
            'matakuliah_nama' => $this->matakuliah->nama,
            'matakuliah_id' => $this->matakuliah->id,
            'keterangan' => $this->keterangan,
            'created_at' => $this->created_at->format('Y-m-d h:i'),
            'updated_at' => $this->updated_at->format('Y-m-d h:i'),
        ];
    }
}
