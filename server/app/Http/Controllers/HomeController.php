<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;
use App\Models\Retweet;
use App\Models\Follow;
use App\Models\User;

class HomeController extends Controller
{
    public function getTimeline(Request $request)
    {
        $authId = $request->session()->get('auth') ? $request->session()->get('auth')->id : null;

        if (empty($authId)) {
            /**
             * get the timeline for public
             */
            // get tweets and retweets in all users
            $tweets = Tweet::getTweets();
            $retweets = Retweet::getRetweets();
            $tweets = $tweets->concat($retweets);
            $tweets = $tweets->sortByDesc('time');

            // get users in random order
            $users = User::select(['id', 'username', 'fullname', 'avatar'])
                ->inRandomOrder()->limit(10)->get();
        } else {
            /**
             * get the timeline for auth user
             */
            // get user ids that are followed by auth id
            $userIds = Follow::where('follower_id', $authId)->pluck('followed_id')->toArray();
            // push auth id to user ids
            array_push($userIds, $authId);
            // get tweets and retweets by user ids
            $tweets = Tweet::getTweets($userIds, $authId);
            $retweets = Retweet::getRetweets($userIds, $authId);
            $tweets = $tweets->concat($retweets);
            $tweets = $tweets->sortByDesc('time');

            // get users in random order
            $users = User::select(['users.id', 'users.username', 'users.fullname', 'users.avatar'])
                ->selectRaw('case when f.follower_id = ' . $authId . ' then 1 else 0 end as is_followed')
                ->leftJoin('follows as f', function ($join) use ($authId) {
                    $join->on('users.id', '=', 'f.followed_id')->whereNull('f.deleted_at')->where('f.follower_id', $authId);
                })->groupBy('f.id')->groupBy('users.id')
                ->inRandomOrder()->limit(10)->get();
        }

        return view('home.home', ['tweets' => $tweets, 'users' => $users]);
    }
}
