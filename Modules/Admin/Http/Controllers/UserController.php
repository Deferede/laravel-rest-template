<?php

namespace Modules\Admin\Http\Controllers;

use App\Dto\UserDto;
use App\Http\Controllers\RestController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Modules\Admin\Http\Requests\UserRequest;
use Modules\Admin\Services\UserService;

class UserController extends RestController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::simplePaginate();

        return $this->success(UserResource::collection($users));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request, UserService $service)
    {

        $dto = new UserDto($request->validated());
        
        $user = $service->createUser($dto);

        return $this->success(UserResource::make($user), trans('admin.users.created', ['login' => $user->login]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
       return $this->success(UserResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user, UserService $service)
    {
        $dto = new UserDto($request->validated());
        $user = $service->updateUser($user, $dto);

        return $this->success(UserResource::make($user), trans('admin.users.updated', ['login' => $user->login]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, UserService $service)
    {
        $service->deleteUser($user);

        return $this->success(null, trans('admin.users.deleted'));
    }
}
