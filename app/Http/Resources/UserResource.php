<?php

namespace App\Http\Resources;

use App\Models\profile;
use Illuminate\Http\Resources\Json\JsonResource;
use stdClass;

class UserResource extends JsonResource
{

    public function toArray($request)
    {

       


        return [
            'id' => $this->id,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'bank' => $this->bank,
            'iban' => $this->iban,
            'lat' => $this->lat,
            'long' => $this->lang,
            'active' => $this->active,
            'residence' => 'uploads/residenceUpload/'.$this->residence,
            'photo' => 'uploads/photoUpload/'.$this->photo,
            'subCategories'=>  SubCategoryResource::collection($this->category),
        ];



        

    }
}