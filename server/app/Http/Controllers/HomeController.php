<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\TweetRepositoryInterface;
use App\Repositories\FollowRepositoryInterface;

class HomeController extends Controller
{
    protected $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepositoryInterface,
        TweetRepositoryInterface $tweetRepositoryInterface,
        FollowRepositoryInterface $followRepositoryInterface
    ) {
        $this->userRepository = $userRepositoryInterface;
        $this->tweetRepository = $tweetRepositoryInterface;
        $this->followRepository = $followRepositoryInterface;
    }

    /**
     * get the timeline for the public or auth user
     *
     * @param Request $request
     * @return JSON ['tweets', 'pagination', 'hashtag', 'auth', 'users']
     */
    public function getTimeline(Request $request)
    {
        // get pagination object
        $pagination = $request->get('pagination');
        $pagination->link = '/home';

        // get auth id
        $authId = $request->get('auth_id');

        if (empty($authId)) {
            /**
             * get the timeline for the public
             */
            // set number of tweets and retweets in pagination
            $pagination->total = $this->tweetRepository->countTweetsAndRetweets();
            // get tweets and retweets in all users
            $tweets = $this->tweetRepository->getTweetsAndRetweetsForTimeline([], 0, $pagination);
            // get users in random order
            $users = $this->userRepository->getInRandomOrder(10);
        } else {
            /**
             * get the timeline for auth user
             */
            // get user ids that are followed by auth id
            $userIds = $this->followRepository->getFollowingIds($authId);
            // push auth id to user ids
            array_push($userIds, $authId);
            // count tweets and retweets by user ids, and set number in pagination
            $pagination->total = $this->tweetRepository->countTweetsAndRetweets($userIds);
            // get tweets and retweets by user ids
            $tweets = $this->tweetRepository->getTweetsAndRetweetsForTimeline($userIds, $authId, $pagination);
            // get users in random order
            $users = $this->userRepository->getInRandomOrder(10, $authId);
        }

        // get auth profile
        $profile = $authId ? $this->userRepository->findProfile(['users.id' => $authId]) : null;

        return view('home.home', [
            'tweets' => $tweets, 'pagination' => $pagination, 'hashtag' => '',
            'auth' => $profile, 'users' => $users,
        ]);
    }

    /**
     * get the timeline for the hashtag
     *
     * @param Request $request
     * @param String $hashtag
     * @return JSON ['tweets', 'pagination', 'hashtag', 'auth', 'users']
     */
    public function getTimelineForHashtag(Request $request, $hashtag)
    {
        // get pagination object
        $pagination = $request->get('pagination');
        $pagination->link = '/home/hashtag/' . $hashtag;

        // get auth id
        $authId = $request->get('auth_id');

        // set number of tweets that have the hashtag in text
        $pagination->total = $this->tweetRepository->countTweetsByHashtag($hashtag);

        // get tweets by hashtag
        $tweets = $this->tweetRepository->getTweetsByHashtag($hashtag, $pagination);

        // get users in random order
        $users = $this->userRepository->getInRandomOrder(10, $authId);

        // get auth profile
        $profile = $authId ? $this->userRepository->findProfile(['users.id' => $authId]) : null;

        return view('home.home', [
            'tweets' => $tweets, 'pagination' => $pagination, 'hashtag' => $hashtag,
            'auth' => $profile, 'users' => $users,
        ]);
    }
}
