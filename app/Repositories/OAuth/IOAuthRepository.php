<?php
namespace App\Repositories\Auth;

interface IOAuthRepository
{
    /**
     * Retrieve oauth client
     * 
     * @param integer $id
     * 
     * @return OAuthClient
     */
    public function findClient($id);
    
    /**
     * Invalidates refresh_token
     * 
     * @param integer $accessTokenId
     * 
     * @return void
     */
    public function revokeRefreshToken($accessTokenId);
}