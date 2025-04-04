<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiCollection;
use App\Http\Requests\Applications\{Create, Get, Index, Update};
use App\Http\Resources\ApiResource;
use App\Models\WebsocketApp;

class WebsocketAppController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Index $request)
    {
        return ApiCollection::make(WebsocketApp::paginate());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Create $request, WebsocketApp $websocketApp)
    {
        $websocketApp->fill($request->validated());
        $websocketApp->save();

        return ApiResource::make($websocketApp);
    }

    /**
     * Display the specified resource.
     */
    public function show(Get $request, WebsocketApp $websocketApp)
    {
        return ApiResource::make($websocketApp);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, WebsocketApp $websocketApp)
    {
        $websocketApp->fill($request->validated());
        $websocketApp->save();

        return ApiResource::make($websocketApp);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebsocketApp $websocketApp)
    {
        $websocketApp->delete();

        return $websocketApp;
    }
}
