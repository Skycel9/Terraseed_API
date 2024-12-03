<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthorizationException;
use App\Exceptions\NotFoundException;
use App\Http\Resources\BaseResource;
use App\Http\Resources\UserCollection;
use App\Models\Relation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RelationController extends Controller
{

    public function getFollowing() {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $following = $user->following;

        return (new UserCollection($following))
            ->success()
            ->setCode(200)
            ->setMessage("The list of users you are following loaded successfully");
    }

    public function getFollowers() {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $followers = $user->followers;

        return (new UserCollection($followers))
            ->success()
            ->setCode(200)
            ->setMessage("The list of users following you loaded successfully");
    }

    public function getPending() {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $pending = $user->invites;

        return (new UserCollection($pending))
            ->success()
            ->setCode(200)
            ->setMessage("The list of users you have sent invitations to loaded successfully");
    }

    public function getRequested() {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $requested = $user->requested;

        return (new UserCollection($requested))
            ->success()
            ->setCode(200)
            ->setMessage("The list of users you have send invitation from loaded successfully");
    }

    public function getBlacklist() {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $blacklist = $user->blacklisted;

        return (new UserCollection($blacklist))
            ->success()
            ->setCode(200)
            ->setMessage("The list of users you are blacklisted loaded successfully");
    }


    public function follow(int $id) {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $target = User::find($id);
        if (!$target) throw new NotFoundException("The user you are trying to follow does not exist", json_encode(["not_found" => "The user you are trying to follow does not exist"]));
        if ($user->id == $target->id) throw new AuthorizationException("You cannot follow yourself", json_encode(["authorization" => "You cannot follow yourself"]));

        $invite = Relation::where('requester_id', $user->id)
            ->where('user_target_id', $target->id)
            ->whereIn('relation_status', ['accept', 'pending'])
            ->first();

        $this->checkIfBlocked($user->id, $target->id);
        $pending = $this->checkIfPending($user->id, $target->id);

        if ($pending) {
            // TODO : We keep this like that ?
            // When I want to follow a user, if this user has already want to follow me auto accept his invite and follow
            Relation::create([
                "relation_status" => "accept",
                "requester_id" => $user->id,
                "user_target_id" => $target->id,
            ]);
            return $this->accept($pending->id)->setMessage("This user has already invite you. You have accept his request and follow.");
        }

        if (!$invite) {
            $invite = Relation::create([
                'relation_status' => 'pending',
                'requester_id' => $user->id,
                'user_target_id' => $target->id,
            ]);
        }

        if (!$invite->wasRecentlyCreated) {
            return (new BaseResource([]))
                ->error()
                ->setCode(409)
                ->setMessage("The user has already been invited or followed");
        }

        return (new UserCollection([$target]))
            ->success()
            ->setCode(200)
            ->setMessage("The user has received your invitation");
    }

    public function unfollow(int $id) {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $target = User::find($id);
        if (!$target) throw new NotFoundException("The user you are trying to unfollow does not exist", json_encode(["not_found" => "The user you are trying to unfollow does not exist"]));

        $relation = Relation::where("user_target_id", $target->id)
            ->where("requester_id", $user->id)
            ->whereIn('relation_status', ['accept', 'pending'])
            ->first();

        if (!$relation) {
            return (new BaseResource([]))
                ->error()
                ->setCode(409)
                ->setMessage("You're not following this user");
        }

        $relation->delete();

        return (new BaseResource([]))
            ->success()
            ->setCode(200)
            ->setMessage("You have unfollow the user");
    }


    public function block(int $id) {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $target = User::find($id);
        if (!$target) throw new NotFoundException("The user you are trying to block does not exist", json_encode(["not_found" => "The user you are trying to block does not exist"]));
        if ($user->id == $target->id) throw new AuthorizationException("You cannot block yourself", json_encode(["authorization" => "You cannot block yourself"]));

        $blocked = Relation::where("requester_id", $user->id)
            ->where("user_target_id", $target->id)
            ->where("relation_status", "blocked")
            ->first();

        if (!$blocked) {
            $blocked = Relation::create([
                'relation_status' => 'blocked',
                'requester_id'=> $user->id,
                'user_target_id' => $target->id,
            ]);
        }

        if (!$blocked->wasRecentlyCreated) {
            return (new BaseResource([]))
                ->error()
                ->setCode(409)
                ->setMessage("You're already blocking this user");
        }

        return (new BaseResource([]))
            ->success()
            ->setCode(200)
            ->setMessage("You have been block the user");


    }

    public function unblock(int $id) {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $target = User::find($id);
        if (!$target) throw new NotFoundException("The user you are trying to unblock does not exist", json_encode(["not_found" => "The user you are trying to unblock does not exist"]));

        $relation = Relation::where("requester_id", $user->id)
            ->where("user_target_id", $target->id)
            ->where("relation_status", "blocked")
            ->first();

        if (!$relation) {
            return (new BaseResource([]))
                ->error()
                ->setCode(409)
                ->setMessage("You're not blocked this user");
        }

        $relation->delete();

        return (new BaseResource([]))
            ->success()
            ->setCode(200)
            ->setMessage("You have unblock the user");
    }


    public function accept(int $id) {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $relation = Relation::find($id);
        if (!$relation) throw new NotFoundException("The relation you are trying to accept does not exist", json_encode(["not_found" => "The relation you are trying to accept does not exist. The user has probably delete his request."]));
        if ($relation->relation_status != 'pending') throw new AuthorizationException("You cannot accept this request", json_encode(["authorization" => "This request is not pending."]));
        if ($relation->user_target_id !== $user->id) throw new AuthorizationException("You cannot accept this request", json_encode(["authorization" => "You're not the target of this request."]));

        $relation->relation_status = 'accept';

        $relation->save();

        return (new BaseResource([]))
            ->success()
            ->setCode(200)
            ->setMessage("You have accept the user's follow request");
    }

    public function reject(int $id) {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $relation = Relation::find($id);
        if (!$relation) throw new NotFoundException("The relation you are trying to reject does not exist", json_encode(["not_found" => "The relation you are trying to reject does not exist. The user has probably delete his request."]));
        if ($relation->relation_status != 'pending') throw new AuthorizationException("You cannot reject this request", json_encode(["authorization" => "This request is not pending."]));
        if ($relation->user_target_id !== $user->id) throw new AuthorizationException("You cannot reject this request", json_encode(["authorization" => "You're not the target of this request."]));

        $relation->delete();

        return (new BaseResource([]))
            ->success()
            ->setCode(200)
            ->setMessage("You have rejected the user's follow request");
    }


    private function checkIfBlocked($userId, $targetId)
    {
        $relation = Relation::where(function ($query) use ($userId, $targetId) {
            $query->where('requester_id', $userId)
                ->where('user_target_id', $targetId)
                ->where('relation_status', 'blocked');
        })->orWhere(function ($query) use ($userId, $targetId) {
            $query->where('requester_id', $targetId)
                ->where('user_target_id', $userId)
                ->where('relation_status', 'blocked');
        })->first();

        if ($relation) {
            //  Check who has blocked other
            if ($relation->requester_id == $userId) {
                throw new AuthorizationException("You have blocked this user.");
            } elseif ($relation->user_target_id == $userId) {
                throw new AuthorizationException("An error occured. You can't follow this user.");
            }
        }

        return false;
    }

    private function checkIfPending($userId, $targetId) {
        return Relation::where(function ($query) use ($userId, $targetId) {
            $query->where('requester_id', $userId)
                ->where('user_target_id', $targetId)
                ->where('relation_status', 'pending');
        })->orWhere(function ($query) use ($userId, $targetId) {
            $query->where('requester_id', $targetId)
                ->where('user_target_id', $userId)
                ->where('relation_status', 'pending');
        })->first();
    }
}
