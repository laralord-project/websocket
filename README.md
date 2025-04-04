# Laralord WebSocket

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/laralord-project/websocket/blob/main/LICENSE)
[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://php.net)
[![Tests](https://github.com/laralord-project/websocket/actions/workflows/test.yaml/badge.svg?branch=main)](https://github.com/laralord-project/websocket/actions/workflows/test.yaml)

**Laralord WebSocket** is an open-source Laravel project providing a multi-tenant WebSocket solution with a Pusher-like API. Built on [Laravel Reverb](https://laravel.com/docs/reverb), it offers real-time communication and includes a CRUD API for application management. Deploy it standalone—no need to install Reverb in your app. This project is part of the [Laralord Project](https://laralord.dev) ecosystem.

---

## Features

- **Multi-Tenancy**: Isolate WebSocket connections and data for multiple tenants.
- **Pusher-Compatible API**: Seamlessly integrate with Pusher clients for real-time messaging.
- **Laravel Reverb**: Leverage Laravel’s native WebSocket server for performance and simplicity.
- **Application Management**: CRUD API to create, read, update, and delete applications.
- **Open-Source**: Free to use and contribute under the MIT license.

---

## Requirements

- PHP 8.1 or higher
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
2. **Create .env file**


