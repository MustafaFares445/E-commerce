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

    protected function errorResponse($message,  int $status = 400): JsonResponse
    {
        return response()->json(['error' => $message, 'status' => $status], $status);
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

    public function returnValidationError($validator , $code = 422): JsonResponse
    {
        return $this->errorResponse($validator->errors()->first() , $code);
    }
}
