<?php

namespace App\Constant;

abstract class DefaultConfig {
    const DEFAULT_PAGE_SIZE = 10;
    const FALLBACK_IMAGE_PATH = '/images/img_no_image.svg';
    const FALLBACK_USER_AVATAR_PATH = '/images/default-user-avatar.png';
    const DEFAULT_USER_PASSWORD = 'A123123';
    const MAX_NUMBER = 999999999999;
    const OTP_CODE = '123456';
    const YOUTUBE_AUTOPLAY_EMBED_SRC = 'https://www.youtube.com/embed/{youtubeId}?rel=0&autoplay=1&enable_js=1&enablejsapi=1&mute=2';
    const TEST_POSTPONE_MAX_TIME = 30; // minutes
}
