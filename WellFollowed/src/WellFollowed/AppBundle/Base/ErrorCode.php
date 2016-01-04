<?php
/**
 * Created by PhpStorm.
 * User: sreiss
 * Date: 09/11/2015
 * Time: 00:03
 */

namespace WellFollowed\AppBundle\Base;

/**
 * Class ErrorCode
 * @description Regroupe les erreurs que peut produire l'application.
 * @package WellFollowed\AppBundle\Base
 */
abstract class ErrorCode
{
    const UNKNOWN_ERROR = "UNKNOWN_ERROR";

    // User
    const USER_EXISTS = "USER_EXISTS";
    const UNAUTHORIZED = "UNAUTHORIZED";
    const NOT_FOUND = "NOT_FOUND";

    // InstitutionType
    const INSTITUTION_TYPE_EXISTS = "INSTITUTION_TYPE_EXISTS";

    const INSTITUTION_EXISTS = "INSTITUTION_EXISTS";

    // Model
    const NO_MODEL_PROVIDED = "NO_MODEL_PROVIDED";
    const AN_ID_MUST_BE_PROVIDED = "AN_ID_MUST_BE_PROVIDED";

    // Sensor
    const NO_SENSOR_NAME_SPECIFIED = "NO_SENSOR_NAME_SPECIFIED";
    const NO_DATE_SPECIFIED = "NO_DATE_SPECIFIED";
    const NO_VALUE_SPECIFIED = "NO_VALUE_SPECIFIED";
}