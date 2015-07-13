<?php namespace App;

use GuzzleHttp\Client;

class Slacker {

    protected $slack_api = 'https://slack.com/api/';

    protected $client;

    protected $channel;

    protected $text;

    protected $method = 'chat.postMessage';

    public function construct()
    {
        $this->client = Client(['base_uri' => $this->slack_api]);
    }

    public function to($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    public function text($text)
    {
        $this->text = is_array($text) ? implode("\n", $text) : $text;

        return $this;
    }

    public function method($method)
    {
        $this->method = $method;

        return $this;
    }

    public function send()
    {
        $this->client->post($this->method, [
            'body' => [
                'token'   => getenv('SLACK_TOKEN'),
                'channel' => $this->channel,
                'text'    => $this->text,
            ]
        ]);
    }
}


