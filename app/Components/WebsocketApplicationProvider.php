<?php

namespace App\Components;

use App\Models\WebsocketApp;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use Laravel\Reverb\Application;
use Laravel\Reverb\Contracts\ApplicationProvider;

class WebsocketApplicationProvider implements ApplicationProvider
{
    const APP_PROVIDER_NAME='database';

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return WebsocketApp::all()->map(fn(WebsocketApp $app) => $app->application);
    }


    /**
     * @inheritDoc
     */
    public function findById(string $id): Application
    {
        return WebsocketApp::findOrFail($id)->application;
    }


    /**
     * @inheritDoc
     */
    public function findByKey(string $key): Application
    {
        return WebsocketApp::where('app_key', $key)->firstOrFail()->application;
    }
}
