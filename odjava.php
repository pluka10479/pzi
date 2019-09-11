<?php

// Isprazni sve sesijske varijable i uništi sesiju
session_start();
session_unset();
session_destroy();

// Preusmjeri na početnu strancu
header('Location: index.php');
