<?php
require_once 'config/app.php';
session_destroy();
redirect('index.php');