<script>
// tweet events
const tweetEvents = {
    postLike: (tweetId) => {
        if(!auth) {
            window.location.href = '/login';
            return;
        }
        const tweet = $('.tweet-'+tweetId);
        const icon = tweet.find('.like-icon');
        if (icon.hasClass('requesting')) return;
        icon.addClass('requesting');
        var numLikes = tweet.find('.like-icon span').html();
        if (!numLikes) numLikes = 0;
        if (!icon.hasClass('active')) {
            // like
            numLikes++;
            icon.find('i').addClass('fa-heart');
            icon.find('i').removeClass('fa-heart-o');
        } else {
            // unlike
            if (numLikes > 0) numLikes--;
            icon.find('i').removeClass('fa-heart');
            icon.find('i').addClass('fa-heart-o');
        }
        tweet.find('.like-icon span').html(numLikes);
        checkActivity(icon);
        $.ajax({
            type: 'POST',
            url: '/likes',
            data: {"_token": "{{ csrf_token() }}", tweet_id: tweetId},
            success: (res) => {
                if (res.isLiked) {
                    // liked
                    icon.addClass('active');
                    icon.find('i').addClass('fa-heart');
                    icon.find('i').removeClass('fa-heart-o');
                } else {
                    // unliked
                    icon.removeClass('active');
                    icon.find('i').removeClass('fa-heart');
                    icon.find('i').addClass('fa-heart-o');
                }
            },
            complete: () => { icon.removeClass('requesting'); },
        });
    },

    postRetweet: (tweetId) => {
        if(!auth) {
            window.location.href = '/login';
            return;
        }
        const tweet = $('.tweet-'+tweetId);
        const icon = tweet.find('.retweet-icon');
        if (icon.hasClass('requesting')) return;
        icon.addClass('requesting');
        var numRetweets = tweet.find('.retweet-icon span').html();
        if (!numRetweets) numRetweets = 0;
        if (!icon.hasClass('active')) {
            // retweet
            numRetweets++;
        } else if (numRetweets > 0) {
            // unretweet
            numRetweets--;
        }
        tweet.find('.retweet-icon span').html(numRetweets);
        checkActivity(icon);
        $.ajax({
            type: 'POST',
            url: '/retweets',
            data: {"_token": "{{ csrf_token() }}", tweet_id: tweetId},
            success: (res) => {
                if (res.isRetweeted) {
                    // retweeted
                    tweet.find('.retweet-icon i').addClass('active');
                    icon.addClass('active');
                } else {
                    // unretweeted
                    icon.removeClass('active');
                }
            },
            complete: () => { icon.removeClass('requesting'); },
        });
    }
}

// follow events
const followEvents = {
    followProfile: (userId) => {
        if (!auth) {
            window.location.href = '/login';
            return;
        }
        const button = $('.profile .follow');
        if (button.hasClass('requesting')) return;
        button.addClass('requesting');
        checkActivity(button);
        $.ajax({
            type: 'POST',
            url: '/follows',
            data: {"_token": "{{ csrf_token() }}", followed_id: userId},
            success: (res) => {
                numFollowers = $('.profile-followers').html();
                if (res.isFollowed) {
                    // followed
                    button.addClass('active');
                    numFollowers++;
                } else {
                    // unfollowed
                    button.removeClass('');
                    if (numFollowers > 0) numFollowers--;
                }
                $('.profile-followers').html(numFollowers);
            },
            complete: () => { button.removeClass('requesting'); },
        });
    },

    followUserInProfile: (userId) => {
        if (!auth) {
            window.location.href = '/login';
            return;
        }
        const button = $('#user-' + userId + ' .user-follow-button');
        if (button.hasClass('requesting')) return;
        button.addClass('requesting');
        checkActivity(button);
        $.ajax({
            type: 'POST',
            url: '/follows',
            data: {"_token": "{{ csrf_token() }}", followed_id: userId},
            success: (res) => {
                if (res.isFollowed) {
                    // followed
                    button.addClass('active');
                } else {
                    // unfollowed
                    button.removeClass('active');
                }
            },
            complete: () => { button.removeClass('requesting'); },
        });
    },

    followUserInHome: (userId) => {
        if (!auth) {
            window.location.href = '/login';
            return;
        }
        const button = $('#right-user-' + userId + ' .follow-button');
        if (button.hasClass('requesting')) return;
        button.addClass('requesting');
        checkActivity(button);
        $.ajax({
            type: 'POST',
            url: '/follows',
            data: {"_token": "{{ csrf_token() }}", followed_id: userId},
            success: (res) => {
                let numFollowing = $('.home .num-following').html();
                if (res.isFollowed) {
                    // followed
                    button.addClass('active');
                    numFollowing++;
                } else {
                    // unfollowed
                    button.removeClass('active');
                    if(numFollowing > 0) {
                        numFollowing--;
                    }
                }
                $('.home .num-following').html(numFollowing);
            },
            complete: () => { button.removeClass('requesting'); },
        });
    },
};

function checkActivity(button) {
    if (!button.hasClass('active')) {
        button.addClass('active');
    } else {
        button.removeClass('active');
    }
}
</script>