<?php
namespace App\Repositories\User;

use App\Models\File;
use App\Models\User;

interface IUserRepository
{

    public function list(array $query, $paginate = false);

    public function count($conditions = null);

    public function find($id);

    public function findWithUserGroups($id);

    public function searchForOne($params);

    public function create($data);

    public function update(User $user, $data);

    public function resetPassword(User $user, $password);

    public function saveAvatar(User $user, File $file);
}
