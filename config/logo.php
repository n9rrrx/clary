<?php

/**
 * Logo configuration for emails and PDFs
 * 
 * For local development: Uses base64 embedded image (works in PDF, may not work in all email clients)
 * For production: Update APP_URL in .env and ensure the logo is publicly accessible
 */

$logoPath = public_path('logos/logo-clary-spider.png');

// Check if file exists
if (!file_exists($logoPath)) {
    return null;
}

// For emails: Use base64 data URI (Gmail may block this, but other clients support it)
// The PDF template uses public_path() which works with GD extension
return 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
