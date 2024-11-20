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

    private array $excludes = array();

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

    /**
     * Define fields to exclude dynamically.
     *
     * @param array $fields
     * @return $this
     */
    public function except(array $fields = array()): static
    {
        $this->excludes = $fields;
        return $this;
    }

    /**
     * Exclude specified fields from data.
     *
     * @param array $data
     * @return array
     */
    protected function applyExcludes(array $data): array
    {
        foreach ($this->excludes as $field) {
            unset($data[$field]);
        }
        return $data;
    }
    /*public function except($fields): self {

        $this->fields = $fields;

        return $this;
    }
    public function only(array $fields): self {
        $this->fields = $fields;
        return $this;
    }

    public function clear($arr): array {


        /*if (count($this->fields) > 0) {
            foreach ($this->fields as $field) {
                unset($arr[$field]);
            }
        }

        return $arr;
    }*/


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
