<?php

namespace App\services\UserServices;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
class LoginService
{
    protected User $model;
    function __construct()
    {
        $this->model = new User();
    }

    public function login($request)
    {
        $validator = $this->validation($request);
        $token = $this->isValidData($validator);

        if( $this->checkStatus($request->email) == "pending")
        {
            return response()->json(["message" => "Your Account is Pending"]);
        }

        return $this->createNewToken($token);
    }


    public function validation($request): \Illuminate\Validation\Validator|JsonResponse
    {
        $validator = Validator::make($request->all(), $request->rules());
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        return $validator;
    }


    function isValidData($data): JsonResponse|bool
    {
        if (! $token = auth()->guard('author')->attempt($data->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $token;
    }

    function checkStatus($email)
    {
        $author = $this->model->whereEmail($email)->first();
        $status = $author->status;
        return $status;
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->guard('author')->user()
        ]);
    }

}
