<?php

namespace App\Http\Controllers;

use App\Exceptions\AuthorizationException;
use App\Http\Resources\BaseResource;
use App\Http\Resources\TopicCollection;
use App\Http\Resources\TopicResource;
use App\Models\Subscription;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index() {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $subscriptions = $user->subscriptions;

        if (!$subscriptions) throw new AuthorizationException("You are not subscribed to any topics", json_encode(["authorization" => "You need to be subscribed to a topic to access this resource"]));

        return (new TopicCollection($subscriptions))
            ->success()
            ->setCode(200)
            ->setMessage("Subscriptions retrieved successfully");
    }

    public function subscribe(Request $request, int $id) {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $topic = Topic::find($id);
        if (!$topic) throw new AuthorizationException("Topic not found", json_encode(["not_found" => "The topic you are trying to subscribe to does not exist"]));

        $subscription = Subscription::where("user_id", $user->id)
            ->where("topic_id", $topic->id)
            ->first();

        if (!$subscription) {
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'topic_id' => $topic->id,
            ]);
        }

        if (!$subscription->wasRecentlyCreated)  {
            return (new BaseResource([]))
                ->error()
                ->setCode(409)
                ->setMessage("You are already subscribed to this topic");
        }

        return (new TopicResource($topic))
            ->success()
            ->setCode(200)
            ->setMessage("You have successfully subscribed to this topic");
    }

    public function unsubscribe(Request $request, int $id) {
        $user = Auth::user();
        if (!$user) throw new AuthorizationException("You are not authenticated", json_encode(["authorization" => "You need to be authenticated to access this resource"]));

        $topic = Topic::find($id);
        if (!$topic) throw new AuthorizationException("Topic not found", json_encode(["not_found" => "The topic you are trying to unsubscribe from does not exist"]));

        $subscription = Subscription::where("user_id", $user->id)
            ->where("topic_id", $topic->id)
            ->first();

        if (!$subscription) {
            return (new BaseResource([]))
                ->error()
                ->setCode(409)
                ->setMessage("You are not subscribed to this topic");
        }

        $subscription->delete();

        return (new TopicResource($topic))
            ->success()
            ->setCode(200)
            ->setMessage("You have successfully unsubscribed from this topic");
    }

}
