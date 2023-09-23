<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

trait ApiResponse
{
    public function successResponse(string $dataName ,  $data ,  $status = 200): JsonResponse
    {
        $response = [
            'status' => $status,
             $dataName => $data
        ];

        return response()->json($response , $status);
    }

    public function successResponseWithMessage(string $dataName ,  $data  , string $msg = null , int $status = 200): JsonResponse
    {
        $response = [
            'status' => $status,
            'massage' => $msg,
            $dataName => $data
        ];

        return response()->json($response , $status);
    }
    public function showMessage(string $msg , int $status = 201): JsonResponse
    {
        return response()->json(['success' => $msg, 'status' => $status] , $status);
    }

    protected function errorResponse($errors, string $message  , int $status = 400): JsonResponse
    {
        $response = [
            'status' => $status,
            'massage' => $message,
            'errors' => $errors
        ];

        return response()->json($response , $status);
    }

    public function getCurrentLang()
    {
        return app()->getLocale();
    }

    public function uploadFile( &$request  , $path , $fileName): void
    {

        $data = $request->except($fileName);

        if( $request->hasFile($fileName) ) {

            $file = $request->file($fileName); //Uploaded File object
            $path = $file->store($path , [
                'disk' => 'public'
            ]);

            $request[$fileName] = $path;
        }
    }

    public function deleteFile($model, $filename): void
    {
        $old_file = $model[$filename];

        if ($old_file){
            Storage::disk('public')->delete($old_file);
        }

    }

    public function returnValidationError($validator , $status = 422): JsonResponse
    {
        return $this->errorResponse($validator->errors() , "validation error" , $status);
    }
}
