<?php
namespace App\Enums;

enum Keys : string {
    case USER = 'user'; 
    case ADMIN = 'admin'; 
    case ADMINS = 'admins'; 

    case VIGILE = 'vigile';
    case VIGILES = 'vigiles';

    case APPRENANT  = 'apprenant';
    case APPRENANTS  = 'apprenants';

    case PROMOTIONS = 'promotions';
    case ROLE = 'role';
    case ERROR='error';
    case LOGIN_REQUIRED ='login_required';
    case INVALID_CREDENTIALS ='invalid_credentials';
    case NOT_FOUND = 'not_found';
    case INTERNAL_ERROR='internal_error';
    case ID_ANNEE  = 'idAnnee';
    case DEBUT  = 'debut';
    case FIN  = 'fin';
    case NOMBRE_APPRENANT  = 'nombre_apprenant';
    case NOM  = 'nom';
    case IMAGE  = 'image';
    
    case USERNAME = 'username';
    case LOGIN = 'login';
    case PASSWORD = 'password';
    case ERROR_MESSAGE= 'errorMessage';
    case ERROR_ERROR = 'error/error';

    case MODEL_FUNCTION = 'modelFunctions';
    case READ_DATA = 'readData';
    case WRITE_DATA = 'writeData';

    case USER_MODEL_FUNCTION = 'userModelFunctions';
    case FIND_USER_BY_CREDENTIALS = 'findUserByCredentials';

    //Pour le router
    case CONTROLLER = 'controller';
    case AUTH = 'auth';
    case ACTION = 'action';
    case LOGIN_FORM = 'loginForm';
    case AUTHENTICATE = 'authenticate';
    case LOUGOUT = 'logout';
    case DASHBOARD = 'dashboard';
    case FORGORT_PASSWORD = 'forgot_password';
    case RESET_PASSWORD = 'reset_password';
    case AJOUTER_PROMOTION = 'ajouter_promotion';
    case REFERENTIELS = 'referentiels';

}

