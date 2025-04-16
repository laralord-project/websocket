# Laralord WebSocket

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/laralord-project/websocket/blob/main/LICENSE)
[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Tests](https://github.com/laralord-project/websocket/actions/workflows/test.yaml/badge.svg?branch=main)](https://github.com/laralord-project/websocket/actions/workflows/test.yaml)
![Docker Image Version](https://img.shields.io/docker/v/laralordproject/websocket)

**Laralord WebSocket** is an open-source Laravel project providing a multi-tenant WebSocket solution with a Pusher-like API. Built on [Laravel Reverb](https://laravel.com/docs/reverb), 
it offers real-time communication and includes a CRUD API for application management. Deploy it standalone—no need to install Reverb in your app. 
This project is part of the [Laralord Project](https://laralord.dev) ecosystem. 

---

## Features

- **Multi-Tenancy**: Isolate WebSocket connections and data for multiple tenants.
- **Pusher-Compatible API**: Seamlessly integrate with Pusher clients for real-time messaging.
- **Laravel Reverb**: Leverage Laravel’s native WebSocket server for performance and simplicity.
- **Application Management**: CRUD API to create, read, update, and delete applications.
- **Open-Source**: Free to use and contribute under the MIT license.

---

## Requirements

- PHP 8.2 or higher
- Laravel 11.x
- Composer
- A database (PostgreSQL, Redis etc.)

---

## Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/laralord-project/websocket.git
   cd websocket
   ```
2. **Create .env files**
   ```bash 
   cp .env.example .env
   # the env file below need to configure laralord server 
   cp .env.server.example .env.server
   ```
3. **Start docker containers**
   ```bash
      docker compose up -d websocket
   ```
4. After microservice up and running it expose the two ports default IP is 10.5.0.1 
   - port: 8080 - for websocket connections 
   - port: 8000 - for applications CRUD API 

# Application Management API

### Base URL
`http://localhost:8000/api`

### Authentication
All endpoints require Bearer token authentication:
```http
Authorization: Bearer your_api_token_here
```

### Routes
| Method       | Endpoint                            | Controller Action                   | Description                       |
|--------------|-------------------------------------|-------------------------------------|-----------------------------------|
| `GET`        | `/applications`                    | `WebsocketAppController@index`      | List all applications             |
| `POST`       | `/applications`                    | `WebsocketAppController@store`      | Create a new application          |
| `GET`        | `/applications/{application}`      | `WebsocketAppController@show`       | Retrieve a specific application   |
| `PUT/PATCH`  | `/applications/{application}`      | `WebsocketAppController@update`     | Update a specific application     |
| `DELETE`     | `/applications/{application}`      | `WebsocketAppController@destroy`    | Delete a specific application     |


### Endpoints
#### 1. List All Applications

   `GET /applications`

#### Example Request:
```bash
curl -X GET http://localhost:8000/api/applications \
  -H "Authorization: Bearer your_api_token_here"
```
#### Example Response:
```json
{
  "data": [
    {
      "id": "237467559627198718",
      "name": "test-app",
      "app_key": "w7YCZe2lYJulvSX1rWeyukBCcnlkCxlb",
      "app_secret": "7acxDi3qtGSRdPtJCp01uk8sqE6DXmiQ",
      "ping_interval": 60,
      "allowed_origins": ["*"],
      "max_message_size": 10000,
      "options": null,
      "created_at": "2025-04-16T06:51:18.000000Z",
      "updated_at": "2025-04-16T06:51:18.000000Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "total": 1,
    "per_page": 15
  },
  "status": "success"
}
```
#### 2. Create Application
**`POST /applications`**

**Parameters:**

| Name | Type   | Required | Description          |
|------|--------|----------|----------------------|
| name | string | Yes      | Application name     |

**Example Request:**
```bash
curl -X POST http://localhost:8000/api/applications \
  -H "Authorization: Bearer your_api_token_here" \
  -H "Content-Type: application/json" \
  -d '{"name": "test-app"}'
```
#### Example Response:
```json
{
   "data": {
      "id": "237467559627198718",
      "name": "test-app",
      "app_key": "w7YCZe2lYJulvSX1rWeyukBCcnlkCxlb",
      "app_secret": "7acxDi3qtGSRdPtJCp01uk8sqE6DXmiQ",
      "created_at": "2025-04-16T06:51:18.000000Z",
      "updated_at": "2025-04-16T06:51:18.000000Z"
   },
   "status": "success"
}
```

#### 3. Get Application Details
**`GET /applications/{id}`**

**Path Parameters:**

| Name | Type   | Description               |
|------|--------|---------------------------|
| id   | string | Application ID to retrieve |

**Example Request:**
```bash
curl -X GET http://localhost:8000/api/applications/237467559627198718 \
  -H "Authorization: Bearer your_api_token_here" \
  -H "Accept: application/json"
```
#### Example Response:
```json
{
   "data": {
      "id": "237467559627198718",
      "name": "test-app",
      "app_key": "w7YCZe2lYJulvSX1rWeyukBCcnlkCxlb",
      "app_secret": "7acxDi3qtGSRdPtJCp01uk8sqE6DXmiQ",
      "created_at": "2025-04-16T06:51:18.000000Z",
      "updated_at": "2025-04-16T06:51:18.000000Z"
   },
   "status": "success"
}
```
#### 3. Delete Application
**`DELETE /applications/{id}`**

**Path Parameters:**

| Name | Type   | Description              |
|------|--------|--------------------------|
| id   | string | Application ID to delete |

**Example Request:**
```bash
curl -X GET http://localhost:8000/api/applications/237467559627198718 \
  -H "Authorization: Bearer your_api_token_here" \
  -H "Accept: application/json"
```
#### Example Response:
```json
{
   "data": {
      "id": "237467559627198718",
      "name": "test-app",
      "app_key": "w7YCZe2lYJulvSX1rWeyukBCcnlkCxlb",
      "app_secret": "7acxDi3qtGSRdPtJCp01uk8sqE6DXmiQ",
      "created_at": "2025-04-16T06:51:18.000000Z",
      "updated_at": "2025-04-16T06:51:18.000000Z"
   },
   "status": "success"
}
```

## Usages

### 1. Install the required JavaScript client
```bash 
   npm install laravel-echo pusher-js
```

