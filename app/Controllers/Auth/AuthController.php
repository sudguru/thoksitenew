<?php

namespace App\Controllers\Auth;
use App\Controllers\Controller; 
use App\Models\User;
use Respect\Validation\Validator as v;

class AuthController extends Controller {

    public function getSignOut($request, $response) {
        $this->auth->logout();
        return $response->withRedirect($this->router->pathFor('home'));
    }

    public function getSignIn($request, $response) {
        return $this->view->render($response, 'ajax/signin.html');
    }

    public function PostSignIn($request, $response) {
       $auth = $this->auth->attempt(
           $request->getParam('email'),
           $request->getParam('password')
       );
       if (!$auth) {
            $this->flash->addMessage('error', 'Wrong Credentials');
            return $response->withRedirect($this->router->pathFor('auth.signin'));
       }
       return $response->withRedirect($this->router->pathFor('home'));
    }
    
    public function getSignUp($request, $response) {
        return $this->view->render($response, 'auth/signup.twig');
    }

    /**
     * is_admin, is_super is always 0 at creation and is manually/from backend only set as 1
     * is_customer = 0 at creation, when added products to cart or wistlist is_customer = 1
     * is_customer = is_potential_customer
     * if a user posts a product then is_vendor = 1
     */
    public function postSignUp($request, $response) {

        $validation = $this->validator->validate($request, [
            'name' => v::notEmpty()->alpha(),
            'email' => v::noWhitespace()->notEmpty()->email()->emailAvailable(), //->alpha()
            'password' => v::noWhitespace()->notEmpty(),
        ]);
        
        if($validation->failed()) {
            return $response->withRedirect($this->router->pathFor('auth.signup'));
        }
        User::create([
            'is_admin' => 0,
            'is_super' => 0,
            'is_customer' => 0,
            'is_vendor' => 0,
            'name' => $request->getParam('name'),
            'email' => $request->getParam('email'),
            'password' => password_hash($request->getParam('password'), PASSWORD_DEFAULT)
        ]);

        $this->flash->addMessage('success', 'Successfully Signed Up !');
        
        $c = $this->auth->attempt($request->getParam('email'), $request->getParam('password'));
        // var_dump($c);
        return $response->withRedirect($this->router->pathFor('home'));

    }
} 