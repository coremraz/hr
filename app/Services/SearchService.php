<?php

namespace App\Services;

use App\Models\Token;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use function Laravel\Prompts\search;

class SearchService
{
    private $vpsService;

    public function __construct()
    {
        $this->vpsService = new VpsService();
    }

    public function index($search)
    {
        $userTokens = $this->getUserTokens(2);
        $vpsName = $this->vpsService->generateName();

        $search['access_token'] = $userTokens['access_token'];
        $search['refresh_token'] = $userTokens['refresh_token'];
        $search['vps_name'] = $vpsName;

        Log::info($search);

        return $search;
    }
    private function getUserTokens($userId)
    {
        $tokens = Token::where('user_id', $userId)->first();

        $tokensData = [
          'access_token' => $tokens->access_token,
          'refresh_token' => $tokens->refresh_token,
        ];

        return $tokensData;
    }
}
