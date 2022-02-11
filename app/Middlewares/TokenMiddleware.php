<?php
namespace Middlewares;

use Model\User;
use Src\Request;
use Src\View;
use function Collect\collection;

class TokenMiddleware
{

    public function handle(Request $request)
    {
        $headers = getallheaders();
        if(isset($headers['Authorization'])){
            $api_token = explode(' ',$headers['Authorization'])[1];
        }
        if(empty($api_token)){
            return  (new View())->toJSON(['error'=>'invalid token']);
        }
        if(empty(User::where('api_token',$api_token)->first())){
            return (new View())->toJSON(['error'=>'invalid token']);
        }
    }
}
