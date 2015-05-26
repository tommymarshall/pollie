<?php

$ns = 'App\Http\Controllers\\';

$app->get('/', function(){
    return view('home');
});

$app->post('/'            , $ns.'SlackController@listen');
$app->post('polls/create' , $ns.'PollController@create');
$app->get('polls/{id}'    , $ns.'PollController@edit');
$app->put('polls/{id}'    , $ns.'PollController@update');
$app->get('pin'           , $ns.'AuthController@form');
$app->post('pin'          , $ns.'AuthController@login');
$app->get('bye'           , $ns.'AuthController@logout');
