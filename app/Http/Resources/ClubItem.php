<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClubItem extends JsonResource
{
    protected $resource;
    

    public function __construct($resource)
    {
        $resource = $resource;

        parent::__construct($resource);
    }
    
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => 200,
            'code' => 0,
            'message' => null,
            'errors' => [],
            'data' => [
                'club' => [
                    'id' => $this->id,
                    'name' => $this->name,
                    'created_at' => $this->created_at,
                    'image_url' => $this->image ? $this->image->url : null,
                ],
                'point' => $this->point ? new Point($this->point) : null,
            ]
        ];
    }
}
