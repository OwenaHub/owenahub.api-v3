<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'notifications' => [
                'id' => $this->id,
                'isRead' => $this->is_read,
                'source' => $this->source,
                'content' => $this->content,
                'createdAt' => $this->created_at,
            ]
        ];
    }
}
