<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    use ApiResponser;
    /**
     * @SWG\Post(
     *   path="/login",
     *   summary="User Login",
     *   @SWG\Parameter(
     *     name="email",
     *     in="formData",
     *     description="User Email",
     *     required=true,
     *     type="string"
     *   ),
     *   @SWG\Parameter(
     *     name="password",
     *     in="formData",
     *     description="User Password",
     *     required=true,
     *     type="string"
     *   ),
     *   tags={"Auth"},
     *   @SWG\Response(response=200, description="successful operation"),
     *   @SWG\Response(response=401, description="unauthorized")
     * )
     *
     */
    public function __invoke()
    {
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $data['token'] =  $user->createToken(env('API_CLIENT'))-> accessToken;
            $data['user'] = $user;
            return $this->successResponse($data);
        }
        else{
            return $this->errorResponse('Please check your credentials', Response::HTTP_FORBIDDEN);
        }
    }
}
