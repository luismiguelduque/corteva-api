<?php

namespace App\Http\Resources\Settings;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\Institution\InstitutionResource;

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
        return [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'email'                 => $this->email,
            'status'                => $this->status == null ? 1 : $this->status,
            'image_url'             => $this->url,
            'original_image_name'   => $this->image,
            'roles'                 => RoleResource::collection($this->roles),
            'role_id'               => RoleResource::collection($this->roles),
        ];
    }
}
