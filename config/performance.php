<?php

return [
    // Increase execution time for heavy operations
    'timeout' => env('SCRIPT_EXECUTION_TIMEOUT', 300),
    
    // Memory limit for PHP
    'memory_limit' => env('MEMORY_LIMIT', '256M'),
];
