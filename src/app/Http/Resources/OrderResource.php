<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'game' => $this->game,
            'price' => $this->price,
            'total_games' => $this->games_in_total,
            'efriend_id' => $this->efriend_id,
            'customer_id' => $this->customer_id,
        ];
    }
}
