<?php

session_start();
session_destroy();

header("Location: http://localhost".dirname($_SERVER["PHP_SELF"])."/login.html");
				die();
?>