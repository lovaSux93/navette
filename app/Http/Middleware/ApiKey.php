<?php

namespace App\Http\Middleware;

use App\Models\ApiKey as ApiKeyModel;
use Closure;
use Illuminate\Contracts\Encryption\DecryptException;

class ApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('x-api-key');
        if( empty($token) || !$this->isValidApiKey($token)){
            abort(403, 'Invalid Api Key');
        }
        
        return $next($request);
    }
    
    private function isValidApiKey($token){
        try {
            $decrypted = decrypt($token);
        } catch (DecryptException $e) {
            return false;
        }
        return null != ApiKeyModel::where('scopes', $decrypted)
                ->where('revoked', 0)
                ->where('expires_at', '>', date('Y-m-d H:i:s'))
                ->first();
    }
}