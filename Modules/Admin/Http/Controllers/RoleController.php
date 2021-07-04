<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\RestController;
use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends RestController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $roles = Role::all();

        return $this->success(RoleResource::collection($roles));
    }
}
