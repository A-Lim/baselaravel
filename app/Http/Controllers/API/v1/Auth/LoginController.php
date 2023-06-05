<?php
namespace App\Http\Controllers\API\v1\Auth;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\UploadedFile;
use Laravel\Passport\Passport;
use Laravel\Socialite\Facades\Socialite;


use App\Http\Controllers\ApiController;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LogoutRequest;

use App\Repositories\Auth\IOAuthRepository;
use App\Repositories\User\IUserRepository;
use App\Repositories\Device\IDeviceRepository;
use App\Repositories\File\IFileRepository;
use App\Repositories\SystemSetting\ISystemSettingRepository;

class LoginController extends ApiController {

    use AuthenticatesUsers, ThrottlesLogins;

    private $oAuthRepository;
    private $userRepository;
    private $systemRepository;
    private $deviceRepository;
    private $fileRepository;

    public function __construct(IOAuthRepository $iOAuthRepository,
        IUserRepository $iUserRepository,
        IDeviceRepository $iDeviceRepository,
        ISystemSettingRepository $iSystemSettingRepository,
        IFileRepository $iFileRepository) {
        $this->middleware('auth:api')->only('logout');

        $this->oAuthRepository = $iOAuthRepository;
        $this->userRepository = $iUserRepository;
        $this->deviceRepository = $iDeviceRepository;
        $this->systemRepository = $iSystemSettingRepository;
        $this->fileRepository = $iFileRepository;
    }

    public function login(LoginRequest $request) {
        // if too many login attemps
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            $this->clearLoginAttempts($request);

            // retrieve user with avatar details
            $user = $this->userRepository->find(auth()->id());
            $tokenResult = $user->createToken('accesstoken');
            $permissions = $this->userRepository->permissions($user);

            // save device and token details if exists
            if ($request->filled('uuid'))
                $this->deviceRepository->createOrUpdate($user, $request->only(['uuid', 'token', 'type']));

            return $this->responseWithLoginData(200, $tokenResult, $user, $permissions);
        }

        // if unsuccessful, increase login attempt count
        // lock user count limit reached
        $this->incrementLoginAttempts($request);

        return $this->responseWithMessage(401, 'Invalid login credentials.');
    }

    public function facebookLogin(Request $request) {
        $socialUser = Socialite::driver('facebook')
            ->stateless()
            ->userFromToken($request->authToken);

        $user = $this->userRepository->searchForOne(['email' => $socialUser->email]);

        // if user does not exist, register new user
        if (!$user) {
            $user_data = [
                'email' => $socialUser->email,
                'name' => $socialUser->name,
            ];
            $user = $this->userRepository->create($user_data);

            // assign default usergroup
            $default_usergroups = $this->systemSettingRepository->findByCode('default_usergroups');

            if (!empty($default_usergroups->value)) {
                $userGroupIds = $default_usergroups->value;
                $activeUserGroupsIds = $this->userGroupRepository->findByIdsWhereActive($userGroupIds)
                    ->pluck('id')
                    ->toArray();

                $user->assignUserGroupsByIds($activeUserGroupIds);
            }
        }

        if ($socialUser->avatar_original)
            $file = $this->saveAvatar($user, $socialUser->avatar_original);

        // save device and token details if exists
        if ($request->filled('uuid'))
            $this->deviceRepository->createOrUpdate($user, $request->only(['uuid', 'token', 'type']));

        $tokenResult = $user->createToken('accesstoken');
        $permissions = $this->userRepository->permissions($user);
        return $this->responseWithLoginData(200, $tokenResult, $user, $permissions);
    }

    public function logout(LogoutRequest $request) {
        $user = auth()->user();
        $accessToken = $user->token();
        // revoke refresh token
        $this->oAuthRepository->revokeRefreshToken($accessToken->id);
        // revoke access token
        $accessToken->revoke();

        if ($request->filled('uuid'))
            $this->deviceRepository->delete($user, $request->uuid);

        return $this->responseWithMessage(201, "Successfully logged out.");
    }

    private function saveAvatar(User $user, $avatarUrl) {
        // remove existing avatar
        if ($user->avatar)
            $user->avatar->delete();

        // create uploaded file from contents of url
        $fileName = uniqid();
        $contents = file_get_contents($avatarUrl);
        $file = '/tmp/' . $fileName;
        file_put_contents($file, $contents);
        $uploaded_file = new UploadedFile($file, uniqid(), 'image/jpeg', null, false);

        return $this->fileRepository->uploadOne('avatars', $uploaded_file, User::class, $user->id);
    }
}
