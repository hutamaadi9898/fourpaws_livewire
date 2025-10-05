<?php

return [
    'upload_disk' => env('MEMORIAL_UPLOAD_DISK', 'memorials'),

    'temporary_url_ttl' => env('MEMORIAL_UPLOAD_URL_TTL', 900),

    'subdomain_routing_enabled' => env('MEMORIAL_SUBDOMAIN_ROUTING', true),
];
