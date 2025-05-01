<?php 
namespace App\Enums;

enum View : string{
    case LOGIN = 'login';
    case PROMOTIONS = 'promotions';
    case ADMIN_DASHBOARD = "admin/dashboard";

    case ADMIN_DASHBOARD_2 = "admin_dashboard";
    case VIGILE_DASHBOARD = "vigile_dashboard";
    case APPRENAMT_DASHBOARD = "apprenant_dashboard";
    case AUTCH_FORGOT_PASSWORD = "auth/forgot-password";


    case APPRENANT_DASHBOARD = "apprenant/dashboard";
    case ADMIN_AJOUTER_PROMOTION = "admin/ajoutPromotion";
    case ADMIN_LISTE_PROMOTION = "admin/listePromotion";
    case ROUTE_PROMOTIONS = "Location: index.php?route=promotions";
    case AUTH_LOGIN= 'auth/login';
    case REFERENTIELS_DASHBOARD= "referentiels/dashboard";
}