<?php
namespace App\Repositories\Auth;

use Laravel\Passport\Client as OAuthClient;
use Laravel\Passport\RefreshToken;

class OAuthRepository implements IOAuthRepository {
    
    public function findClient($id) {
        return OAuthClient::find($id);
    }

    public function revokeRefreshToken($accessTokenId) {
        RefreshToken::where('access_token_id', $accessTokenId)->update(['revoked' => true]);
    }
}