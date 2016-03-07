<?php

namespace WellFollowed\AppBundle\Base;

/**
 * Class ErrorCode
 * @description Regroupe les erreurs que peut produire l'application.
 * @package WellFollowed\AppBundle\Base
 */
abstract class ErrorCode
{
    const UNKNOWN_ERROR = "Erreur inconnue";

    // User
    const USER_EXISTS = "L'utilisateur existe déjà.";
    const UNAUTHORIZED = "Non autorisé.";
    const NOT_FOUND = "Resource non trouvée.";
    const CLIENT_EXISTS = "Le client existe déjà.";

    // InstitutionType
    const INSTITUTION_TYPE_EXISTS = "Le type d'établissement existe déjà.";

    const INSTITUTION_EXISTS = "L'établissement existe déjà.";

    // Model
    const NO_MODEL_PROVIDED = "Aucun model envoyé.";
    const AN_ID_MUST_BE_PROVIDED = "Un identifiant doit être fournit.";

    // Sensor
    const NO_SENSOR_NAME_SPECIFIED = "Aucun non de capteur spécifié.";
    const NO_DATE_SPECIFIED = "Aucune date spécifiée.";
    const NO_VALUE_SPECIFIED = "Aucune valeur spécifiée.";
    const NO_CLIENT = "Aucun client spécifié.";

    // Experiment
    const NO_EXPERIMENT_EVENT_SPECIFIED = "Aucun évènement spécifié pour l'expérience.";
}