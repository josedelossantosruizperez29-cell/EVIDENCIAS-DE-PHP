<?php
// ============================================================
// FRONT CONTROLLER — Única puerta de entrada de la aplicación
// Todas las URLs pasan por aquí.
// ============================================================

// 1. Cargar las clases del núcleo
require_once __DIR__ . '/core/View.php';
require_once __DIR__ . '/core/Router.php';

// 2. Crear el router y despachar la petición
$router = new Router();
$router->despachar();
