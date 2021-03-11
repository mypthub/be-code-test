<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class AuthController extends ApiController
{
    protected $client;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->client = DB::table('oauth_clients')
                          ->where(['password_client' => 1])
                          ->first();
    }

    public function authenticate(Request $request)
    {
        //dd($this->client);
        $request->request->add([
            'username' => $request->get('email'),
            'password' => $request->get('password'),
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
        ]);

        $proxy = Request::create('oauth/token', 'POST');

        return Route::dispatch($proxy);
    }

    public function logout (Request $request) {

        $response = array("status"=>false,"data"=>"","message"=>"Something went wrong!");
        if (Auth::check()) {
            //Auth::user()->AauthAcessToken()->delete();
            $user = Auth::user()->token();
            $user->revoke();
            $response = array("status"=>true,"data"=>"logout","message"=>"USer Logout Successfully!");
        }
        return response()->json($response);
    }
}
