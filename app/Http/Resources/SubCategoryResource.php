<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;


class SubCategoryResource extends JsonResource
{

    public function toArray($request)
    {

       


        return [
            'id' => $this->id,
            'name' => $this->name,
            'category'=> new CategoryResource1($this->category)
        ];



        

    }
}