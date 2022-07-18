<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if(strpos($this->path(), 'filterBy')) {
            $path = $this->path();
            $queryOperator = '&';
        } else {
            $path = $this->getOptions()['path'];
            $queryOperator = '?';
        }
        return [
            "current_page" => $this->currentPage(),
            "first_page_url" =>  $path.$queryOperator.$this->getOptions()['pageName'].'=1',
            "prev_page_url" =>  $this->previousPageUrl(),
            "next_page_url" =>  $this->nextPageUrl(),
            "last_page_url" =>  $path.$queryOperator.$this->getOptions()['pageName'].'='.$this->lastPage(),
            "last_page" =>  $this->lastPage(),
            "per_page" =>  $this->perPage(),
            "total" =>  $this->total(),
            "path" =>  $path,
        ];
    }
}
