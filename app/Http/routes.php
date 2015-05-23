<?php

$ns = 'App\Http\Controllers\\';

$app->post('/'                 , $ns.'SlackController@listen');
$app->post('polls/create'      , $ns.'PollController@create');
$app->get('polls/{id}/edit'    , $ns.'PollController@edit');
$app->put('polls/{id}/edit'    , $ns.'PollController@update');
