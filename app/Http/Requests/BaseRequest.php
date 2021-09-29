<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class BaseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @param mixed $data
     * @param mixed $status
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    /**
     * Response for validate error request.
     * @param array $data
     * @return JsonResponse
     */
    private function responseErrors($data = [], $status = 422)
    {
        $response = [
            'errors' => $data,
            'success' => false,
        ];

        return response()
            ->json($response, $status);
    }

    /**
     * Return pretty errors for response.
     * @param Validator $validator
     * @return array
     */
    private function formatErrors(Validator $validator)
    {
        $messages = $validator->errors()->getMessages();
        $errors = [];
        foreach ($messages as $field => $message) {
            $errors[] = $this->formatValidationErrors($field, $message);
        }

        return $errors;
    }

    /**
     * Formatted error for validate response.
     * @param $field
     * @param $message
     * @return array
     */
    private function formatValidationErrors($field, $message)
    {
        $error = [
            'field' => $field,
            'message' => $message,
        ];

        return $error;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->responseErrors($this->formatErrors($validator))
        );
    }
}
