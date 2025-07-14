# WireGate Filament Demo

## Project Description

**WireGate Filament Demo** is a device management system with integrated health monitoring, built on modern technology stack.

### Functional Capabilities

#### 🖥️ Device Management
- **CRUD operations**: Create, read, update and delete devices
- **Administrative panel**: Modern interface based on Filament for data management
- **Filtering**: Filtering using Meilisearch

#### 📊 Health Monitoring
- **Automatic assessment**: The system automatically calculates device health status based on:
  - First deployment date
  - Expected lifecycle (in years, months or days)
- **Status grading**: Devices are classified by categories:
  - **Perfect** — excellent condition
  - **Good** — good condition  
  - **Fair** — satisfactory condition
  - **Poor** — poor condition
  - **N/A** — no data

#### 🔍 Search and Analytics
- **API endpoints**: JSON API for integration with external systems
  - `/devices/health-json` — health status statistics
  - `/devices/list-json` — list of all devices
- **Widgets**: Statistics visualization in administrative panel

### Technology Stack

- **Backend**: Laravel 11 (PHP 8.3)
- **Administrative panel**: Filament 3
- **Search**: Meilisearch with Laravel Scout
- **Database**: MySQL 8.4
- **Containerization**: Docker Compose
- **Web server**: Nginx
- **Mail service**: Mailpit for testing

### Architecture

The project follows clean architecture principles:
- **Repository Pattern** — data access abstraction
- **Service Layer** — business logic in services
- **Dependency Injection** — dependency injection
- **Searchable Models** — integration with search engine

### Quick Start

```bash
# Clone and setup
git clone <repository>
cd wiregate_filament_demo

# Start environment
make install


# Access application
http://localhost/admin/login
```
Test creds:
test@example.com
password

### Containers

- **app** — PHP 8.3 with Laravel
- **web** — Nginx web server  
- **db** — MySQL or sqlite
- **workspace** — CLI environment for development
- **mailpit** — mail service for testing
- **meilisearch** — search engine

