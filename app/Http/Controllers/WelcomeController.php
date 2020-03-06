<?php

namespace App\Http\Controllers;

use OpenGraph;
use Twitter;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        $title = config('app.name', 'tootlog');

        OpenGraph::setSiteName($title);
        OpenGraph::setDescription('Mastodon log archives service.');
        OpenGraph::setTitle($title);
        OpenGraph::setUrl(route('welcome'));
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addImage(url('/avatars/original/missing.png'));

        Twitter::setTitle($title);
        Twitter::setType('summary');

        return view('welcome');
    }
}
