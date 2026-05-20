<?php

namespace App\Http\Controllers;

define("OK", 200);
define("CREATED", 201);
define("NO_CONTENT", 204);
define("FORBIDDEN", 403);
define("NOT_FOUND", 404);
define("INVALID_DATA", 422);
define("SERVER_ERROR", 500);
define('UNAUTHORIZED', 401);
define('REPEATED_REQUEST', 429);

abstract class Controller
{
    //
}
