<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get('Admin/Login',["as"=>"Login", "uses"=>"AjaxController@Login"]);
$router->post('Admin/LoginUser',["as"=>"LoginUser", "uses"=>"AjaxController@LoginUser"]);
$router->group(['prefix' => 'Admin', 'middleware'=> 'auth'], function () use ($router) {
    $router->get('/Dashboard',["as"=>"Dashboard", "uses"=>"AjaxController@Dashboard"]);


    $router->get('/Contact',["as"=>"Contact", "uses"=>"AjaxController@Contact"]);
    $router->post('/ContactCreate',["as"=>"ContactCreate", "uses"=>"AjaxController@ContactCreate"]);
    $router->get('/ContactFetch',["as"=>"ContactFetch", "uses"=>"AjaxController@ContactFetch"]);
    $router->get('/ContactDelete', ["as" => "ContactDelete", "uses" => "AjaxController@ContactDelete"]);
    $router->post('/ContactEdit', ["as" => "ContactEdit", "uses" => "AjaxController@ContactEdit"]);


        $router->post('/SendMail', [
            'as' => 'SendMail',
            'uses' => 'MailController@SendMail'
        ]);


        $router->get('/getContactHeaders',["as"=>"getContactHeaders", "uses"=>"ExcelController@getContactHeaders"]);
        $router->get('/getRowData',["as"=>"getRowData", "uses"=>"ExcelController@getRowData"]);

        $router->post('/BulkInsert',["as"=>"BulkInsert", "uses"=>"BulkController@BulkInsert"]);
        $router->get('/BulkDelete',["as"=>"BulkDelete", "uses"=>"BulkController@BulkDelete"]);


});
