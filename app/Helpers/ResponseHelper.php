<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function makeResponse($message, $data = null, $error = false, $errorCode = null)
    {
        // Initialize the response array
        $response = [
            'status' => $error ? false : true,
        ];
        
        $response['message'] = $message;

        // If there's an error and it's specifically a validation error, format the message to include the validation messages.
        if ($error && is_array($data) && isset($data['errors'])) {
            // Extract and concatenate all validation error messages.
            $errorMessage = [];
            foreach ($data['errors'] as $fieldErrors) { // Loop through each field's errors.
                foreach ($fieldErrors as $fieldError) { // Loop through each error for the field.
                    $errorMessage[] = $fieldError; // Add the error message to the list.
                }
            }
            $response['message'] = implode(' ', $errorMessage);
           
        } 
    
        $response['data'] = $data;
    
       
        return response()->json($response, $error ? $errorCode : 200);
    }
    
}
