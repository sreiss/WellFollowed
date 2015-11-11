<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 09/11/2015
 * Time: 00:03
 */

namespace WellFollowedBundle\Base;

/**
 * Class ErrorCode
 * @description Regroupe les erreurs que peut produire l'application.
 * @package WellFollowedBundle\Base
 */
class ErrorCode
{
    const UNKNOWN_ERROR = "UNKNOWN_ERROR";

    // User
    const USER_EXISTS = "USER_EXISTS";
    const UNAUTHORIZED = "UNAUTHORIZED";
}