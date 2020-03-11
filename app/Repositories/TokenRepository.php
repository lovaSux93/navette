<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TokenRepository extends Repository
{

    public function __construct(Model $model = null)
    {
        $this->model = new \App\Models\AccessToken();
    }
    
    /**
     * Generate token
     *
     * @params User $user
     * @return boolean
     */
    public function generateToken(\App\Models\User $user)
    {
        $token = $user->createToken(Str::random(500));
        
        $refresh_token = $token->createRefreshToken(Str::random(1000));

        return $token->refresh();
    }
}