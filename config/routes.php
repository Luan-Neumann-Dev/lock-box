<?php

use App\Controllers\IndexController;
use App\Controllers\LoginController;
use App\Controllers\LogoutController;
use App\Controllers\Notas;
use App\Controllers\RegisterController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\GuestMiddleware;
use Core\Route;

(new Route)
    // GUEST ROUTES
    ->get('/', IndexController::class, GuestMiddleware::class)
    ->get('/login', [LoginController::class, 'index'], GuestMiddleware::class)
    ->post('/login', [LoginController::class, 'login'], GuestMiddleware::class)
    ->get('/registrar', [RegisterController::class, 'index'], GuestMiddleware::class)
    ->post('/registrar', [RegisterController::class, 'register'], GuestMiddleware::class)

    // AUTH ROUTES
    ->get('/notas', Notas\IndexController::class, AuthMiddleware::class)
    ->get('/notas/criar', [Notas\CriarController::class, 'index'], AuthMiddleware::class)
    ->post('/notas/criar', [Notas\CriarController::class, 'store'], AuthMiddleware::class)
    ->put('/nota', Notas\AtualizarController::class, AuthMiddleware::class)
    ->delete('/nota', Notas\DeletarController::class, AuthMiddleware::class)

    ->get('/confirmar', [Notas\VisualizarController::class, 'confirmar'], AuthMiddleware::class)
    ->post('/mostrar', [Notas\VisualizarController::class, 'mostrar'], AuthMiddleware::class)
    ->get('/esconder', [Notas\VisualizarController::class, 'esconder'], AuthMiddleware::class)

    ->get('/logout', LogoutController::class, AuthMiddleware::class)

    ->run();
