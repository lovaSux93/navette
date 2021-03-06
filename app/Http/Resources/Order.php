<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Order extends JsonResource
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
            'order' => [
                'rid' => $this->id,
                'place' => $this->place,
                'amount' => $this->amount,
                'subtotal' => $this->subtotal,
                'total' => $this->total,
                'vat' => $this->vat,
                'currency' => $this->currency,
                'privatized' => $this->privatized,
                'preordered' => $this->preordered,
                'created_at' => $this->created_at,
            ],
            'club' => $this->club ? new ClubSingle($this->club) : null,
            'car' => $this->car ? new CarSingle($this->car) : null,
            'points' => Point::collection($this->points),
            'phone' => Phone::collection($this->phones),
        ];
    }
}
