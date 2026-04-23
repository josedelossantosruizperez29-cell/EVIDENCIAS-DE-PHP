<?php
// ============================================================
// FRONT CONTROLLER — Único punto de entrada
// ============================================================
// TODO 1: Carga core/View.php con require_once y __DIR__
require_once __DIR__ . '/core/View.php';

// TODO 2: Carga core/Router.php con require_once y __DIR__
require_once __DIR__ . '/core/Router.php';

// TODO 3: Crea una instancia del Router y llama a despachar()
$router = new Router();
$router->despachar();
