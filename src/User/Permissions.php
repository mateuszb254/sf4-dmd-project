<?php

namespace App\User;

/**
 * This class contains all available permissions those can be assigned to RoleGroup
 */
final class Permissions
{
    // articles
    public const ARTICLE_CAN_BROWSE_SECTION = 'ROLE_CAN_BROWSE_ARTICLE_SECTION';
    public const ARTICLE_CAN_ADD = 'ROLE_CAN_ADD_ARTICLE';
    public const ARTICLE_CAN_EDIT = 'ROLE_CAN_EDIT_ARTICLE';
    public const ARTICLE_CAN_DELETE = 'ROLE_CAN_DELETE_ARTICLE';

    //promotion
    public const PROMOTION_CAN_ADD = 'ROLE_CAN_ADD_PROMOTION';
    public const PROMOTION_CAN_EDIT = 'ROLE_CAN_EDIT_PROMOTION';
    public const PROMOTION_CAN_DELETE = 'ROLE_CAN_DELETE_PROMOTION';
    public const PROMOTION_COUPON_CAN_BROWSE = 'ROLE_CAN_BROWSE_PROMOTION_COUPON_SECTION';
    public const PROMOTION_COUPON_CAN_GENERATE = 'ROLE_CAN_GENERATE_PROMOTION_COUPON';
    public const PROMOTION_COUPON_CAN_DELETE = 'ROLE_CAN_DELETE_PROMOTION_COUPON';

    //users
    public const USER_CAN_BROWSE_SECTION = 'ROLE_CAN_BROWSE_USER_SECTION';
    public const USER_CAN_EDIT_USER = 'ROLE_CAN_EDIT_USER';
    public const USER_CAN_DELETE_USER = 'ROLE_CAN_DELETE_USER';
    public const USER_CAN_BAN_USER = 'ROLE_CAN_BAN_USER';

    //support
    public const SUPPORT_CAN_BROWSE_SECTION = 'SUPPORT_CAN_BROWSE_SECTION';
    public const SUPPORT_CAN_CLOSE_TICKET = 'SUPPORT_CAN_CLOSE_TICKET';
}
