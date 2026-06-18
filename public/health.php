<?php
// Simple health check - bypasses Laravel entirely
// Used by Railway to verify the PHP server is running
http_response_code(200);
header('Content-Type: text/plain');
echo 'OK';
