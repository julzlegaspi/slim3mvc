<?php
//add trailing slash at the end of url
/*$app->add(function ($request, $response, $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) != '/') {
        $uri = $uri.'/';
        return $response->withRedirect((string)$uri, 301);
    }
    return $next($request, $response);
});*/

$app->get('/', 'TodoController:index')->setName('home');

$app->post('/success', 'TodoController:testcsrf')->setName('test.csrf');