<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthorizationException;
use App\Exceptions\NotFoundException;
use App\Http\Resources\AttachmentCollection;
use App\Http\Resources\BaseResource;
use App\Http\Resources\CommentCollection;
use App\Http\Resources\PostCollection;
use App\Http\Resources\TagCollection;
use App\Http\Resources\TopicCollection;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends Controller
{
    public function index() {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization"=> "You need to be authenticated to access this resource"]));

        $this->authorize("viewAny", User::class);

        return (new UserCollection($user))
            ->success()
            ->setCode(200)
            ->setMessage("Users listed successfully");
    }

    // === Get Profile ===
    public function getProfile(int $id = null) {
        $user = User::Find(Auth::id());
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization"=> "You need to be authenticated to access this resource"]));

        $this->authorize("view", $user);

        $profile = User::Find($id) ?? $user;
        if (!$profile) throw new AuthorizationException("User not found", json_encode(["not_found"=> "The user you are looking for does not exist"]));

        $profile = new UserResource($profile);
        return $profile
            ->success()
            ->setCode(200)
            ->setMessage("User profile retrieved successfully");
    }


    // === User Action ===

    public function register(Request $request)
    {
        $this->authorize("create", User::class);

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

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials = [
            'user_email' => $credentials['email'], // Email
            'password' => $credentials["password"], // Laravel mappe automatiquement sur "password"
        ];

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

    public function updateProfile(Request $request, int|null $id = null) {
        $user = Auth::user();

        $this->authorize("update", $user);

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'sometimes|string|min:8|confirmed',
        ]);

        if ($id) {
            $user = User::find($id);
            if (!$user) throw new NotFoundException("Not found", json_encode(["not_found"=> "The user you are looking for does not exist"]));
        }

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

    public function deleteAccount(int|null $id = null) {
        $user = Auth::user();

        $this->authorize("delete", $user);

        if ($id) {
            $user = User::find($id);
            if (!$user) throw new NotFoundException("Not found", json_encode(["not_found"=> "The user you are looking for does not exist"]));
        }

        $user->delete();

        return BaseResource::error()
            ->success()
            ->setCode(200)
            ->setMessage("Account deleted successfully");
    }


    // === Get content by user ===

    public function getPosts(int|null $id = null) {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization"=> "You need to be authenticated to access this resource"]));

        $author = $user;
        if ($id) {
            $author = User::find($id);
            if (!$author) throw new AuthorizationException("User not found", json_encode(["not_found"=> "The user you are looking for does not exist"]));
        }

        $posts = $author->posts;

        if (count($posts) <= 0) {
            return (new BaseResource([]))
                ->success()
                ->setCode(200)
                ->setMessage("User has publish posts");
        }

        return (new PostCollection($posts))
            ->success()
            ->setCode(200)
            ->setMessage("User's posts retrieved successfully");
    }

    public function getComments(int|null $id = null) {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization"=> "You need to be authenticated to access this resource"]));

        $author = $user;
        if ($id) {
            $author = User::find($id);
            if (!$author) throw new AuthorizationException("User not found", json_encode(["not_found"=> "The user you are looking for does not exist"]));
        }

        $comments = $author->comments;

        if (count($comments) <= 0) {
            return (new BaseResource([]))
                ->success()
                ->setCode(200)
                ->setMessage("User has publish comments");
        }

        return (new CommentCollection($comments))
            ->success()
            ->setCode(200)
            ->setMessage("User's comments retrieved successfully");
    }

    public function getTopics(int|null $id = null) {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $author = $user;
        if ($id) {
            $author = User::find($id);
            if (!$author) throw new AuthorizationException("User not found", json_encode(["not_found" => "The user you are looking for does not exist"]));
        }

        $topics = $author->topics;

        if (count($topics) <= 0) {
            return (new BaseResource([]))
                ->success()
                ->setCode(200)
                ->setMessage("User has create any topics");
        }

        return (new TopicCollection($topics))
            ->success()
            ->setCode(200)
            ->setMessage("User's topics retrieved successfully");
    }

    public function getAttachments(int|null $id = null) {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $author = $user;
        if ($id) {
            $author = User::find($id);
            if (!$author) throw new AuthorizationException("User not found", json_encode(["not_found" => "The user you are looking for does not exist"]));
        }

        $attachments = $author->attachments;

        if (count($attachments) <= 0) {
            return (new BaseResource([]))
                ->success()
                ->setCode(200)
                ->setMessage("User has upload any attachments");
        }

        return (new AttachmentCollection($attachments))
            ->success()
            ->setCode(200)
            ->setMessage("User's attachments retrieved successfully");
    }

    public function getTags(int|null $id = null) {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $author = $user;
        if ($id) {
            $author = User::find($id);
            if (!$author) throw new AuthorizationException("User not found", json_encode(["not_found" => "The user you are looking for does not exist"]));
        }

        $tags = $author->tags;

        if (count($tags) <= 0) {
            return (new BaseResource([]))
                ->success()
                ->setCode(200)
                ->setMessage("User has tag any posts");
        }

        return (new TagCollection($tags))
            ->success()
            ->setCode(200)
            ->setMessage("User's tags retrieved successfully");
    }

    public function getLikes(int|null $id = null) {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $author = $user;
        if ($id) {
            $author = User::find($id);
            if (!$author) throw new AuthorizationException("User not found", json_encode(["not_found" => "The user you are looking for does not exist"]));
        }

        $likes = $author->likes;

        if (count($likes) <= 0) {
            return (new BaseResource([]))
                ->success()
                ->setCode(200)
                ->setMessage("User has liked any posts");
        }

        return (new PostCollection($likes))
            ->success()
            ->setCode(200)
            ->setMessage("User's likes retrieved successfully");
    }
}
