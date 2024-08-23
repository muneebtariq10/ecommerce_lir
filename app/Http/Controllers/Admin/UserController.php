<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Role;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::query()->where("status", "enabled")->orderBy("name", "asc")->get();

        $query = User::query();

        $field = request("field", "created_at");
        $direction = request("direction", "desc");

        if (request("name")) {
            $query->where("name", "like", "%".request("name")."%");
        }
        if (request("email")) {
            $query->where("email", "like", "%".request("email")."%");
        }
        if (request("role_id")) {
            $query->where("role_id", request("role_id"));
        }

        $users = $query->orderBy($field, $direction)->paginate(10)->onEachSide(1);

        return inertia("Admin/User/Index", [
            "users" => UserResource::collection($users),
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
        $roles = Role::query()->where("status", "enabled")->orderBy("name", "asc")->get();

        return inertia("Admin/User/Create", [
            "roles" => RoleResource::collection($roles)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['email_verified_at'] = time();
        $data['password'] = bcrypt($data['password']);

        User::create($data);

        return to_route("user.index")->with('success', 'User was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::query()->where("status", "enabled")->orderBy("name", "asc")->get();

        return inertia("Admin/User/Edit", [
            "user" => new UserResource($user),
            "roles" => RoleResource::collection($roles)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $password = $data['password'] ?? null;
        if ($password) {
            $data['password'] = bcrypt($password);
        } else {
            unset($data['password']);
        }
        $user->update($data);

        return to_route("user.index")->with("success", "User \"$user->name\" was updated.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $name = $user->name;
        $user->delete();

        return to_route("user.index")->with("success", "User \"$name\" was deleted.");
    }
}
