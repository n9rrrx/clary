<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to Clary - Multi-Tenant Agency Client Management Platform',
        'version' => '1.0.0',
        'api_status' => 'active',
        'documentation' => 'See README.md and GETTING_STARTED.md for complete documentation',
        'api_endpoints' => [
            'clients' => url('/api/clients'),
            'projects' => url('/api/projects'),
            'tasks' => url('/api/tasks'),
            'invoices' => url('/api/invoices'),
        ],
        'getting_started' => [
            'quick_start' => 'Access the API at /api/* endpoints',
            'list_clients' => 'GET /api/clients',
            'create_client' => 'POST /api/clients',
            'documentation_file' => 'GETTING_STARTED.md',
        ],
        'multi_tenancy' => [
            'status' => 'enabled',
            'note' => 'This is a multi-tenant platform. API endpoints work on central domain. For tenant-specific access, configure a tenant domain.',
        ],
        'health_check' => url('/up'),
    ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
});
