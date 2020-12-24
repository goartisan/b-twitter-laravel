<?php
    $avatar = $user->avatar ? '/storage/media/'.$user->id.'/avatar/avatar.'.$user->avatar : '';
?>
<div class="right-user" id="{{'right-user-'.$user->id}}">
    <!-- avatar -->
    <a class='avatar' href="{{'/profile/tweets/'.$user->username}}">
        <img src={{$avatar}} onerror="this.style.display='none'" />
        <i class='fa fa-user'></i>
    </a>
    <div class='top'>
        <!-- fullname -->
        <span class='fullname'>{{$user->fullname}}</span>
        <!-- username -->
        <span class='username'>{{'@'.$user->username}}</span>
    </div>
    <!-- follow button -->
    <div class='bottom'>
        @if ($user->is_followed)
            <button class="{{'btn btn-default follow-button active'}}" onclick="followUser({{$user->id}})"></button>
        @else
            <button class="{{'btn btn-default follow-button'}}" onclick="followUser({{$user->id}})"></button>
        @endif
    </div>
</div>

@include('home/right_user_style')
