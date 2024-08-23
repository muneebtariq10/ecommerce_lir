<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Role;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Role::query();

        $field = request("field", "created_at");
        $direction = request("direction", "desc");

        if (request("name")) {
            $query->where("name", "like", "%".request("name")."%");
        }
        if (request("status")) {
            $query->where("status", "like", "%".request("status")."%");
        }

        $roles = $query->orderBy($field, $direction)->paginate(10)->onEachSide(1);

        return inertia("Admin/Role/Index", [
            "roles" => RoleResource::collection($roles),
            "queryParams" => request()->query() ?: null,
            "success" => session("success")
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia("Admin/Role/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $data = $request->validated();

        Role::create($data);

        return to_route("role.index")->with('success', 'Role was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return inertia("Admin/Role/Edit", [
            "role" => new RoleResource($role)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $data = $request->validated();

        $role->update($data);

        return to_route("role.index")->with("success", "Role \"$role->name\" was updated.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $name = $role->name;
        $role->users()->delete();
        $role->delete();

        return to_route("role.index")->with("success", "Role \"$name\" was deleted.");
    }
}
