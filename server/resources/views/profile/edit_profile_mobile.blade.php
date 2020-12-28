<style>
@media screen and (min-width: 960px) {
    .edit-profile .mobile {
        display: none;
    }
}

@media screen and (max-width: 960px) {
    .edit-profile .nav, .edit-profile .nav .container {
        width: 100%;
        background: rgba(0, 0, 0, 0);
        box-shadow: 0px 0px 0px;
        z-index: 10;
    }

    .edit-profile {
        margin: 0px;
    }

    .edit-profile .desktop {
        display: none;
    }

    .edit-profile .bg {
        padding-top: 30%;
    }

    .edit-profile .bg img {
        left: -15%;
        width: auto;
        height: 100%;
    }

    .edit-profile .nav .container > .avatar {
        position: absolute;
        left: 7.5px;
        top: -50px;
        width: 100px;
        height: 100px;
        z-index: 100;
    }

    .edit-profile .bg .message {
        top: 55%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .edit-profile .bg .message i {
        font-size: 22px;
    }

    .edit-profile .bg .message span {
        display: none;
    }

    .edit-profile .nav {
        padding-right: 15px;
    }

    .edit-profile .nav .button {
        height: 30px;
        line-height: 15px;
    }

    .edit-profile .nav .avatar .message i {
        font-size: 20px;
    }

    .edit-profile .nav .avatar .message span {
        display: none;
    }

    .edit-profile .nav .container button {
        right: 15px;
    }

    .edit-profile .container {
        width: 100%;
        padding: 0px;
        margin: 0px;
        z-index: 0;
    }

    .edit-profile .main > div.row {
        position: relative;
        width: 100%;
        padding: 0px;
        margin: 0px;
    }

    .edit-profile .main > div > .left {
        position: relative;
        width: 100%;
        background: #fff;
        padding: 0px 15px;
        margin: 0px;
        margin-top: -60px;
        padding-top: 60px;
        padding-bottom: 10px;
        z-index: 0;
        border: 0px solid;
        background: #fff;
    }
}
</style>
