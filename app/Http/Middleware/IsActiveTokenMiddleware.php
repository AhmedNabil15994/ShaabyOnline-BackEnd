<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Modules\User\Entities\OauthAccessTokens;

class IsActiveTokenMiddleware
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
        $user = auth('api')->user();
        $userSerialize = serialize($user);
        $userUnserializeArray = (array) unserialize($userSerialize);

        $arrayKeys = array_keys($userUnserializeArray);

        foreach ($arrayKeys as $value) {

            if (strpos($value, 'accessToken') !== false) {

                $userAccessTokenArray = (array) $userUnserializeArray[$value];
                $arrayAccessKeys = array_keys($userAccessTokenArray);
                foreach ($arrayAccessKeys as $arrayAccessValue) {

                    if (strpos($arrayAccessValue, 'original') !== false) {

                        $userTokenId = $userAccessTokenArray[$arrayAccessValue]['id'];
                        $checkToken = OauthAccessTokens::where([
                            ['id', '=', $userTokenId],
                            ['expires_at', '>', Carbon::now()],
                        ])->first();

                        if (!$checkToken) {
                            return response()->json([
                                'success' => false,
                                'message' => __('Session has expired, please logout & login again'),
                            ], 401);
                        }
                    }
                }
            }
        }

        return $next($request);
    }
}
