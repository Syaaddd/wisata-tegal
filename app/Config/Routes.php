<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', static function($routes){

    $routes->group('', ['filter'=>'cifilter:auth'], static function($routes){
        // $routes->view('example-page', 'example-page');
        $routes->get('home', 'AdminController::index', ['as' => 'admin.home']);
        $routes->get('logout', 'AdminController::logoutHandler', ['as' => 'admin.logout']);
        $routes->get('profile', 'AdminController::profile', ['as' => 'admin.profile']);
        // $routes->post('update-personal-picture', 'AdminController::updatePersonalPicture', ['as' => 'update-personal-picture']);
        $routes->post('update-personal-picture', 'AdminController::updatePersonalPicture', ['as' => 'update-personal-picture']);
        $routes->post('update-personal-details', 'AdminController::updatePersonalDetails', ['as' => 'update-personal-details']);
        $routes->post('change-password', 'AdminController::changePassword', ['as' => 'change-password']);
    });

    $routes->group('', ['filter'=>'cifilter:guest'], static function($routes){
        // $routes->view('example-auth', 'example-auth');
        $routes->get('login', 'AuthController::loginForm', ['as' => 'admin.login.form']);
        $routes->post('login', 'AuthController::loginHandler', ['as' => 'admin.login.handler']);
        $routes->get('forgot-password', 'AuthController::forgotForm', ['as' => 'admin.forgot.form']);
        $routes->post('forgot-password','AuthController::sendPasswordResetLink',['as'=>'admin.send_password_reset_link']);
        $routes->get('password/reset/(:any)', 'AuthController::resetPassword/$1', 
        ['as' => 'admin.reset-password']);
    });
});