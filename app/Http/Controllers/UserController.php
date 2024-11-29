<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Inscription
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:25|unique:users,user_login',
            'user_email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return BaseResource::error()
                ->setCode(400)
                ->setMessage("Data validation failed")
                ->setErrors($validator->errors());
        }

//        dd(Hash::make($request->password));

        $user = User::create([
            'user_login' => $request->name,
            'user_email' => $request->user_email,
            'user_password' => Hash::make($request->password),
        ]);

        // Générer un token d'authentification
        $token = $user->createToken('auth_token')->plainTextToken;

        return (new UserResource($user))
            ->success()
            ->setCode(201)
            ->setMessage("User registered successfully")
            ->additional(['token' => $token]);
    }

    // Connexion
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials = [
            'user_email' => $credentials['email'], // Email
            'password' => $credentials["password"], // Laravel mappe automatiquement sur "password"
        ];

//        dd(Auth::attempt($credentials));

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('YourAppName')->plainTextToken;

            return (new UserResource($user))
                ->success()
                ->setCode(200)
                ->setMessage("Login successful")
                ->additional(['token' => $token]);
        }

        return BaseResource::error()
            ->setCode(401)
            ->setMessage("Invalid credentials")
            ->setErrors(json_encode(['message' => 'Invalid email or password']));
    }

    public function me()
    {
        // Récupérer l'utilisateur connecté
        $user = Auth::user();

        if (!$user) {
            return BaseResource::error()
                ->setCode(401)
                ->setMessage("Unauthenticated")
                ->setErrors(['message' => 'You are not authenticated.']);
        }

        // Retourner les informations de l'utilisateur avec un format uniforme
        return (new UserResource($user))
            ->success()
            ->setCode(200)
            ->setMessage("User information retrieved successfully");
    }

    public function getProfile(int $id) {
        $user = User::Find(Auth::id());

        $profile = User::Find($id);

        // Return all information if user is SuperAdmin
//        if ($user->hasRole(1)) {
//            $profile = $profile->with("roles")->get();
//        }
//        return (new PermissionCollection($user->allPermissions()))->success()->setCode(200);


        $profile = new UserResource($profile);
        return $profile
            ->success()
            ->setCode(200)
            ->setMessage("User profile retrieved successfully");
    }


    // Modifier le profil
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'sometimes|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return BaseResource::error()
                ->setCode(400)
                ->setMessage("Data validation failed")
                ->setErrors($validator->errors());
        }

        if ($request->name) {
            $user->name = $request->name;
        }

        if ($request->email) {
            $user->email = $request->email;
        }

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return (new UserResource($user))
            ->success()
            ->setCode(200)
            ->setMessage("Profile updated successfully");
    }

    // Accéder aux publications de l'utilisateur
    public function userPosts()
    {
        $user = Auth::user();
        $posts = $user->posts; // Assurez-vous d'avoir défini la relation "posts" dans votre modèle User

        return (new UserCollection($posts))
            ->success()
            ->setCode(200)
            ->setMessage("User's posts retrieved successfully");
    }

    // Supprimer le compte
    public function deleteAccount()
    {
        $user = Auth::user();
        $user->delete();

        return BaseResource::error()
            ->success()
            ->setCode(200)
            ->setMessage("Account deleted successfully");
    }
}
