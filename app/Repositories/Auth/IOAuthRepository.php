<?php
namespace App\Repositories\Auth;

interface IOAuthRepository
{
    public function findClient($id);

    public function revokeRefreshToken($accessTokenId);
}