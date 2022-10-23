<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $url = url('storage/app/public/');

        return [
            'user_id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile' => $this->profile_url,
            'growUnit' => $this->growUnit,
            'electricalConductivity' => $this->electricalConductivity,
            'flower' => $this->flower,
            'clone' => $this->clone,
            'mother' => $this->mother,
            'vegitative' => $this->vegitative
            // 'auth' => $this->token,
        ];
    }
}
