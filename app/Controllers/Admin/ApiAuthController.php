<?php

namespace App\Controllers\Admin;
use App\Controllers\Controller; 
use App\Models\User;
use Respect\Validation\Validator as v;
use Ramsey\Uuid\Uuid;
use Firebase\JWT\JWT;
use Tuupola\Base62;

class ApiAuthController extends Controller {


    public function authenticate($request, $response) {

        // $this->logger->addInfo($request->getParam('password'));

        $auth = $this->auth->attempt(
            $request->getParam('username'),
            $request->getParam('password')
        );
        if ($auth) {

            $token = $this->generateToken($user, $request);
            $result = [
                'status' => 200,
                'error' => null,
                'data' => $token
            ];
        } else {
            $result = [
                'status' => 200,
                'error' => "Invalid Email/Password.",
                'data' => null
            ];
        }
        return $response->withStatus(201)
        ->withHeader("Content-Type", "application/json")
        ->write(json_encode($result, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
        
    }

    private function generateToken ($user, $request) {
        $scopes = [];
        $now = new \DateTime();
        $future = new \DateTime("now +2 hours");
        $server = $request->getServerParams();
        $jti = (new Base62)->encode(random_bytes(16));
        $payload = [
            "iat" => $now->getTimeStamp(),
            "exp" => $future->getTimeStamp(),
            "jti" => $jti,
            "sub" => $server["PHP_AUTH_USER"],
            "scope" => $scopes,
            "email" => $user->email,
            "firstName" => $user->first_name,
            'lastName' => $user->last_name
        ];
        $secret = "supersecretkeyyoushouldnotcommittogithub";
        $token = JWT::encode($payload, $secret, "HS256");
        return $token;
    }
} 