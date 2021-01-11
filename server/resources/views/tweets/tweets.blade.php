<?php
    $links = array('', '', '', '');
    $url = url()->current();
    if (strrpos($url, '/profile/tweets/')) $links[0] = 'active';
    else if (strrpos($url, '/profile/with_replies/')) $links[1] = 'active';
    else if (strrpos($url, '/profile/media/')) $links[2] = 'active';
    else if (strrpos($url, '/profile/likes/')) $links[3] = 'active';

    $auth = '';
    if (Session::get('auth')) $auth = Session::get('auth');
?>
<div class="tweets">
    @if ($links[3] != 'active')
        <div class="header">
            <ul class="tweets_ul">
                <li class="li_tweets {{$links[0]}}" onclick="get_tweets()">
                    <a href="{{ '/profile/tweets/' . $profile->username }}">Tweets</a>
                </li>
                <li class="li_replies {{$links[1]}}" onclick="get_replies()">
                    <a href="{{ '/profile/with_replies/' . $profile->username }}">Tweets & replies</a>
                </li>
                <li class="li_media {{$links[2]}}" onclick="get_media()">
                    <a href="{{ '/profile/media/' . $profile->username }}">Media</a>
                </li>
            </ul>
        </div>
    @endif
    <div class="body">
        @if ($pinnedTweets && $pinnedTweets->count() > 0)
            <ul class="pinned-tweets">
                @foreach ($pinnedTweets as $pt)
                    <li>@include('tweets/tweet', ['tweet' => $pt])</li>
                @endforeach
            </ul>
        @endif
        <ul>
            @foreach ($tweets as $t)
                <li>@include('tweets/tweet', ['tweet' => $t])</li>
            @endforeach
        </ul>
    </div>
    <div class="footer" onclick="backToTop()">
        <span>Back to Top</span>
    </div>
</div>

@include('tweets/tweets_style')
