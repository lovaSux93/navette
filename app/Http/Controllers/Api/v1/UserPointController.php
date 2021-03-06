<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserPoint as StoreUserPointRequest;
use App\Http\Resources\UserPoint as UserPointResource;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use App\Models\UserPosition;
use App\Models\Point;
use Illuminate\Http\Request;

class UserPointController extends Controller
{
    
    /**
     * Store a new user postion.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(StoreUserPointRequest $request)
    {
        $data = $request->validated();
        $point = Point::create($data);
        
        $user = $request->user();
        $user->positions()->attach($point->id, ['created_at' => now()]);
        
        event(new \App\Events\UserPointCreated($user, $point));

        return $this->success(200, "Position created");
    }
}
