<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class BaseResource extends JsonResource
{
    private int $code;
    private string|null $message = null;
    private mixed $errors = null;
    private bool $success = false;

    public static function error(): self {
        return new static([]);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        // Make an unique structure for API responses
        return $this->resource; // Data retrieved by the request
    }

    // Define the response status according to status code
    public function withResponse(Request $request, JsonResponse $response): void
    {
        $response->setStatusCode($this->getCode());
    }
    public function with(Request $request) {
        $arr = array(
            "success"=> $this->getSuccess(), // Include status of the request response
            "code"=> $this->getCode(), // Define the response
            "message"=> $this->getMessage()
        );

        if (!$this->getSuccess()) $arr["errors"] = $this->getErrors(); // Include any errors related to the request response
        return $arr;
    }



    public function setCode($code): self {
        $this->code = $code;
        return $this;
    }
    public function setMessage($message): self {
        $this->message = $message;
        return $this;
    }
    public function setErrors($errors): self {
        $this->errors = json_decode($errors);
        return $this;
    }
    // Set the response status to success
    public function success(): self {
        $this->success = true;
        return $this;
    }

    public function getCode(): int {
        return $this->code;
    }
    public function getMessage(): string|null {
        return $this->message;
    }
    public function getErrors(): mixed {
        return $this->errors;
    }
    public function getSuccess(): bool {
        return $this->success;
    }
}
