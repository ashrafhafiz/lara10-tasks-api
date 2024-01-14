<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'owner_id' => $this->owner,
            // 'tasks' => TaskResource::collection($this->tasks),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
            'members' => UserResource::collection($this->whenLoaded('members')),
            'scheduled_at' => $this->scheduled_at,
            'due_at' => $this->due_at,
            'updated_at' => $this->updated_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
