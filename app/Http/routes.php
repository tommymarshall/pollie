<?php

$to = 'App\Http\Controllers\\';

$app->post('/'                 , $to.'SlackController@listen');
$app->post('polls/create'      , $to.'PollController@create');
$app->get('polls/{id}/edit'    , $to.'PollController@edit');
$app->put('polls/{id}/edit'    , $to.'PollController@update');
$app->get('polls/{id}/results' , $to.'PollController@results');
