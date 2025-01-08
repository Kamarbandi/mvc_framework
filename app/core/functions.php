<?php

/**
 * @param mixed $stuff - The variable to be displayed.
 * @return void
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
function show(mixed $stuff)
{
	echo "<pre>";
	print_r($stuff);
	echo "</pre>";
}

/**
 * @param string $str - The string to be escaped.
 * @return string
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
function esc(string $str): string
{
	return htmlspecialchars($str);
}

/**
 * @param $path
 * @return void
 * @author Azad Kamarbandi <azadkamarbandi@gmail.com>
 */
function redirect($path): void
{
    $url = ROOT . "/" . ltrim($path, '/');
    header("Location: " . $url);
    die;
}
