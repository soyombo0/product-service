<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowAvatarRequest;
use App\Http\Requests\StoreAvatarRequest;
use App\Http\Requests\UserUpdateNickRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return UserResource::collection(User::query()->where('role_id', Role::IS_USER)->get());
    }
    public function show(Request $request,int $userId)
    {
        return UserResource::make(User::query()->where('id', $userId)->first());
    }
    public function updateName(UserUpdateNickRequest $request, int $userId)
    {
        $data = $request->validated();
        $user = User::query()->where('id', $userId)->first();
        $user->update($data);
        $user->save();
        return UserResource::make($user->fresh());
    }

    public function storeAvatar(StoreAvatarRequest $request)
    {
        $file = $request->file('image');
        Storage::disk('public')->deleteDirectory('pfp-' . auth()->user()->id);
        $path = Storage::disk('public')->put('pfp-' . auth()->user()->id, $file);
        return \response()->json([
            "data" => $path
        ]);
    }

    public function showAvatar(ShowAvatarRequest $request, string $userId)
    {
        $path = Storage::disk('public')->files('pfp-' . $userId)[0];
        return Storage::disk('public')->get($path);
    }
}
