<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'project_id' => $this->project_id,
            'start_time' => $this->start_time,
            'end_time'   => $this->end_time,
            'hours'      => $this->hours,
            'tag'        => $this->tag,
            'created_at' => $this->created_at,
        ];
    }
}
