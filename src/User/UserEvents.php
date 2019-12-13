<?php

namespace App\User;

final class UserEvents
{
    public const USER_AUTHENTICATED = 'user_authenticated';
    public const USER_CREATED = 'user_registered';
    public const USER_MODIFIED = 'user_modified';
    public const USER_PASSWORD_CHANGED = 'user_password_changed';
    public const USER_EMAIL_CHANGED = 'user_email_changed';
    public const USER_CHAR_REMOVAL_CODE_CHANGED = 'user_char_removal_code_changed';
    public const USER_EMAIL_CHANGE_REQUESTED = 'user_email_change_requested';
    public const USER_EMAIL_CHANGE_SUCCESS = 'user_email_change_success';
    public const RESET_PASSWORD_TOKEN_REQUESTED = 'user_reset_password_token_requested';
    public const RESET_PASSWORD_TOKEN_SUCCESS = 'user_reset_password_token_success';
}
