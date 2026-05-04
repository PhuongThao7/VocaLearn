<?php
// Load Config
require_once '../app/config/config.php';

// Load Core Libraries
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/App.php';

// Start Session
session_start();

// Init Core Library
$init = new App();