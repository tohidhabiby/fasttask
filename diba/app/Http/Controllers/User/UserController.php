<?php

namespace App\Http\Controllers\User;

use App\Filters\User\RoleFilter;
use App\Filters\User\UserFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RoleUserRequest;
use App\Http\Resources\User\RoleResource;
use App\Http\Resources\User\UserResource;
use App\Interfaces\Models\User\UserInterface;
use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserFilter $filters UserFilter.
     * @param Request    $request Request.
     *
     * @return AnonymousResourceCollection
     */
    public function index(UserFilter $filters, Request $request): AnonymousResourceCollection
    {
        return UserResource::collection(User::filter($filters)->paginate($this->getPageSize($request)))
            ->additional($this->getAdditionals($filters, new User()));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user User.
     *
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user User.
     *
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            $user->delete();

            return $this->getResponse([], Response::HTTP_NO_CONTENT);
        } catch (\Exception $exception) {
            Log::error('Delete User Error : ' . $exception->getMessage());

            return $this->getResponse(
                ['message' => __('error.can_not_delete_parameter', ['parameter' => __('error.user')])],
                Response::HTTP_CONFLICT
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param User       $user    User.
     * @param RoleFilter $filters Filter.
     * @param Request    $request Request.
     *
     * @return AnonymousResourceCollection
     */
    public function getRoles(
        User $user,
        RoleFilter $filters,
        Request $request
    ): AnonymousResourceCollection {
        return RoleResource::collection(
            $user->roles()->filter($filters)->paginate($this->getPageSize($request))
        )->additional([
            'meta' => [
                'filters' => $filters->attributes,
                'orderByColumns' => $filters->orderByColumns,
            ]
        ]);
    }

    /**
     * @param User       $user    User.
     * @param Role       $role    Role.
     * @param RoleFilter $filters Filters.
     * @param Request    $request Request.
     *
     * @return AnonymousResourceCollection
     */
    public function addRole(
        User $user,
        Role $role,
        RoleFilter $filters,
        Request $request
    ): AnonymousResourceCollection {
        if (!$user->roles()->find($role->getId())) {
            $user->roles()->attach($role->getId());
        }

        return $this->getRoles($user, $filters, $request);
    }

    /**
     * @param User            $user    User.
     * @param RoleUserRequest $request Request.
     * @param RoleFilter      $filters Filters.
     *
     * @return AnonymousResourceCollection
     */
    public function syncRoles(
        User $user,
        RoleUserRequest $request,
        RoleFilter $filters
    ): AnonymousResourceCollection {
        $user->roles()->sync($request->get('role_ids'));

        return $this->getRoles($user, $filters, $request);
    }

    /**
     * @param User       $user    User.
     * @param Role       $role    Role.
     * @param RoleFilter $filters Filters.
     * @param Request    $request Request.
     *
     * @return AnonymousResourceCollection
     */
    public function deleteRole(
        User $user,
        Role $role,
        RoleFilter $filters,
        Request $request
    ): AnonymousResourceCollection {
        $user->roles()->detach([$role->getId()]);

        return $this->getRoles($user, $filters, $request);
    }

    /**
     * Login user.
     *
     * @param LoginRequest $request Login Request.
     *
     * @return JsonResponse Json Response.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $response = null;
        //TODO move in the another method.
        $identifierValue = $request->all()[User::USERNAME];
//        $identifier = filter_var($identifierValue, FILTER_VALIDATE_EMAIL) ? User::EMAIL : User::USERNAME;

        /** @var UserInterface $user */
        $user = User::query()->where(User::USERNAME, $identifierValue)
            ->orWhere(User::EMAIL, $identifierValue)->first();
        if (Hash::check($request->get(User::PASSWORD), $user->getPassword())) {
            $token = $user->createToken('user');
            return $this->getResponse(
                [
                    'token' => $token->accessToken,
                    'token_id' => $token->token->id,
                    'user' => new UserResource(
                        $user->load('roles', 'roles.permissions'),
                        $user
                    ),
                ]
            );
        }

        return $this->getResponse(
            ['message' => __('error.incorrect_user_pass')],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    /**
     * Log out.
     *
     * @param Request $request Login Request.
     *
     * @return JsonResponse Json Response.
     */
    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()->token();
        $token->revoke();

        return $this->getResponse();
    }
}
