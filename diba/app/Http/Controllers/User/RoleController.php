<?php

namespace App\Http\Controllers\User;

use App\Filters\User\PermissionFilter;
use App\Filters\User\RoleFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\PermissionRoleRequest;
use App\Http\Requests\User\RoleRequest;
use App\Http\Resources\User\PermissionResource;
use App\Http\Resources\User\RoleResource;
use App\Models\User\Permission;
use App\Models\User\Role;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    /**
     *
     * @param RoleFilter $filters RoleFilter.
     * @param Request    $request Request.
     *
     * @return AnonymousResourceCollection
     */
    public function index(RoleFilter $filters, Request $request): AnonymousResourceCollection
    {
        return RoleResource::collection(Role::with('permissions')
            ->filter($filters)->paginate($this->getPageSize($request)))
            ->additional($this->getAdditionals($filters, new Role()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request RoleRequest.
     *
     * @return JsonResponse|RoleResource
     */
    public function store(RoleRequest $request): JsonResponse|RoleResource
    {
        $role = Role::createObject($request->get(Role::TITLE));
        $role->permissions()->sync($request->get('permissions'));

        return new RoleResource($role->load('permissions'));
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role Role.
     *
     * @return RoleResource
     */
    public function show(Role $role): RoleResource
    {
        return new RoleResource($role->load('permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request RoleRequest.
     * @param Role        $role    Role.
     *
     * @return JsonResponse|RoleResource
     */
    public function update(RoleRequest $request, Role $role): JsonResponse|RoleResource
    {
        $custom = in_array($role->title, Role::$customRoles);
        $result = $role;

        if (!$custom) {
            $result = $role->updateObject($request->get(Role::TITLE));
        }
        $result->permissions()->sync($request->get('permissions'));

        return new RoleResource($result->load('permissions'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role Role.
     *
     * @return JsonResponse
     * @throws AuthorizationException Exception.
     */
    public function destroy(Role $role): JsonResponse
    {
        $this->authorize('delete', $role);
        try {
            $role->delete();

            return $this->getResponse([], Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            Log::error('Delete Role Error : ' . $exception->getMessage());

            return $this->getResponse(
                ['message' => __('error.can_not_delete_parameter', ['parameter' => __('error.role')])],
                Response::HTTP_CONFLICT
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Role             $role    Role.
     * @param PermissionFilter $filters Filter.
     * @param Request          $request Request.
     *
     * @return AnonymousResourceCollection
     */
    public function getPermissions(
        Role $role,
        PermissionFilter $filters,
        Request $request
    ): AnonymousResourceCollection {
        return PermissionResource::collection(
            $role->permissions()->filter($filters)->paginate($this->getPageSize($request))
        );
    }

    /**
     * @param Role             $role       Role.
     * @param Permission       $permission Permission.
     * @param PermissionFilter $filters    Filters.
     * @param Request          $request    Request.
     *
     * @return AnonymousResourceCollection
     */
    public function addPermission(
        Role $role,
        Permission $permission,
        PermissionFilter $filters,
        Request $request
    ): AnonymousResourceCollection {
        if (!$role->permissions()->find($permission->getId())) {
            $role->permissions()->attach($permission->getId());
        }

        return $this->getPermissions($role, $filters, $request);
    }

    /**
     * @param Role                  $role    Role.
     * @param PermissionRoleRequest $request Request.
     * @param PermissionFilter      $filters Filters.
     *
     * @return AnonymousResourceCollection
     */
    public function syncPermissions(
        Role $role,
        PermissionRoleRequest $request,
        PermissionFilter $filters
    ): AnonymousResourceCollection {
        $role->permissions()->sync($request->get('permission_ids'));

        return $this->getPermissions($role, $filters, $request);
    }

    /**
     * @param Role             $role       Role.
     * @param Permission       $permission Permission.
     * @param PermissionFilter $filters    Filters.
     * @param Request          $request    Request.
     *
     * @return AnonymousResourceCollection
     */
    public function deletePermission(
        Role $role,
        Permission $permission,
        PermissionFilter $filters,
        Request $request
    ): AnonymousResourceCollection {
        $role->permissions()->detach([$permission->id]);

        return $this->getPermissions($role, $filters, $request);
    }
}
