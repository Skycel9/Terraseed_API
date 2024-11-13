<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseCollection extends ResourceCollection
{
    private int $code;
    private string|null $message = null;
    private bool $success;

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array {
        // Make an unique structure for API responses
        return $this->resource->toArray();
    }

    // Define the response status according to status code
    public function withResponse(Request $request, JsonResponse $response) :void
    {
        $response->setStatusCode($this->getCode());
    }

    public function with(Request $request) :array {
        return array(
            "success"=> $this->getSuccess(),
            "code"=> $this->getCode(),
            "message"=> $this->getMessage()
        );
    }


    // Set the response status to success
    public function success(): BaseCollection {
        $this->success = true;
        return $this;
    }

    public function setCode($code): BaseCollection {
        $this->code = $code;
        return $this;
    }
    public function setMessage($message): BaseCollection {
        $this->message = $message;
        return $this;
    }

    public function getCode(): int {
        return $this->code;
    }
    public function getMessage(): string|null {
        return $this->message;
    }
    public function getSuccess(): bool {
        return $this->success;
    }
}
