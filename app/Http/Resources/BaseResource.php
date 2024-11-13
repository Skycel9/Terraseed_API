<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class BaseResource extends JsonResource
{
    private int $code;
    private string|null $message = null;
    private bool $success;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        // Make an unique structure for API responses
        return array(
            "data"=> $this->resource, // Data retrieved by the request
            "success"=> $this->getSuccess(), // Defined the
            "code"=> $this->getCode(),
            "message"=> $this->getMessage()
        );
    }

    // Define the response status according to status code
    public function withResponse(Request $request, JsonResponse $response)
    {
        $response->setStatusCode($this->getCode());
    }


    // Set the response status to success
    public function success() {
        $this->success = true;
        return $this;
    }

    public function setCode($code): BaseResource {
        $this->code = $code;
        return $this;
    }
    public function setMessage($message): BaseResource {
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
