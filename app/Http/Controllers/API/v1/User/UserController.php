<?php

namespace App\Http\Controllers\API\v1\User;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Http\Resources\Users\UserResource;
use App\Http\Resources\Users\UserCollection;
use App\Repositories\User\IUserRepository;
use App\Repositories\File\IFileRepository;

use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\UploadAvatarRequest;
use App\Http\Requests\User\UpdateProfileRequest;

class UserController extends ApiController {

    private $userRepository;
    private $fileRepository;

    public function __construct(IUserRepository $iUserRepository,
        IFileRepository $iFileRepository) {
        $this->middleware('auth:api');
        $this->userRepository = $iUserRepository;
        $this->fileRepository = $iFileRepository;
    }
    
    public function list(Request $request) {
        if ($request->type != 'formcontrol')
            $this->authorize('viewAny', User::class);
            
        $users = $this->userRepository->list($request->all(), true);
        return $this->responseWithData(200, $users);
    }

    public function profile(Request $request) {
        $user = $this->userRepository->find(auth()->id());
        return $this->responseWithData(200, $user); 
    }

    public function myPermissions(Request $request) {
        $user = auth()->user();
        $permissions = $this->userRepository->permissions($user);
        return $this->responseWithData(200, $permissions);
    }

    public function updateProfile(UpdateProfileRequest $request) {
        $authUser = auth()->user();
        $this->authorize('updateProfile', $authUser);

        // prevent user from updating anything else like status, verified_at etc
        $data = $request->only(['name', 'phone', 'gender', 'date_of_birth']);

        // if user has oldPassword filled,
        // user attempting to change password
        if ($request->has('oldPassword') && $request->oldPassword != null) {
            $credentials = ['email' => $authUser->email, 'password' => $request->oldPassword];
            
            if (!Auth::guard('web')->attempt($credentials)) {
                return $this->responseWithMessage(401, 'Invalid old password.');
            }
            $data['password'] = $request->newPassword;
        }

        $user = $this->userRepository->update(auth()->user(), $data);
        $userResource = new UserResource($user);
        return $this->responseWithMessageAndData(200, $userResource, 'Profile updated.');  
    }

    public function uploadProfileAvatar(UploadAvatarRequest $request) {
        $user = auth()->user();
        $this->authorize('updateProfile', $user);
        
        // delete old avatar
        if ($user->avatar)
            $user->avatar->delete();

        // upload new avatar
        $file = $this->fileRepository->uploadOne('avatars', $request->file('avatar'), User::class, $user->id);

        // save
        $this->userRepository->saveAvatar(auth()->user(), $file);
        return $this->responseWithMessageAndData(200, $file, 'Profile avatar updated.');
    }

    public function uploadUserAvatar(UploadAvatarRequest $request, User $user) {
        $this->authorize('update', $user);

        if ($user->avatar)
            $user->avatar->delete();

        // upload new avatar
        $file = $this->fileRepository->uploadOne('avatars', $request->file('avatar'), User::class, $user->id);
        // save
        $this->userRepository->saveAvatar($user, $file);
        return $this->responseWithMessageAndData(200, $file, 'User avatar updated.');
    }
 
    public function details(Request $request, User $user) {
        $this->authorize('view', $user);
        $user = $this->userRepository->findWithUserGroups($user->id);
        $userResource = new UserResource($user);
        return $this->responseWithData(200, $userResource); 
    }

    public function update(UpdateRequest $request, User $user) {
        $this->authorize('update', $user);
        $user = $this->userRepository->update($user, $request->all());
        $userResource = new UserResource($user);
        return $this->responseWithMessageAndData(200, $userResource, 'User updated.'); 
    }

    public function resetPassword(Request $request, User $user) {
        $this->authorize('update', $user);
        $random_password = $this->userRepository->randomizePassword($user);
        return $this->responseWithData(200, $random_password);
    }
}
