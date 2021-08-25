<?php
namespace \Utility;

function generateHash($password, $salt = null) {
    if ($salt == null) {
        $salt = substr(md5(uniqid(rand(), true)), 0, 9);
    } else {
        $salt = substr($salt, 0, 9);
    }
    return $salt . sha1($password . $salt);
}

function array_to_object($array) {
    return (object) $array;
}

function object_to_array($object) {
    return (array) $object;
}

function redirectTo($url) {
    echo "<script>window.location.replace('$url')</script>";
}

function cleanUsername($username) {
    return preg_replace('/[^a-zA-Z0-9_\.]+/', '', $username);
}

function createDirectory($path) {
    if (!is_dir($path)) {
        umask(0);
        mkdir($path, 0777);
        return true;
    } else {
        return false;
    }
}

/**
 * Convert a camelized string to a lowercase, underscored string.
 *
 * @param string $s string to convert
 * @return string
 */
function uncamelize($s) {
    $normalized = '';

    for ($i = 0, $n = strlen($s); $i < $n; ++$i) {
        if (ctype_alpha($s[$i]) && (strtoupper($s[$i]) === $s[$i]))
            $normalized .= '_' . strtolower($s[$i]);
        else
            $normalized .= $s[$i];
    }
    return trim($normalized, ' _');
}

/**
 * Turn a string into its camelized version.
 *
 * @param string $s string to convert
 * @return string
 */
function camelize($s) {
    $s = preg_replace('/[_-]+/', '_', trim($s));
    $s = str_replace(' ', '_', $s);

    $camelized = '';

    for ($i = 0, $n = strlen($s); $i < $n; ++$i) {
        if ($s[$i] == '_' && $i + 1 < $n)
            $camelized .= strtoupper($s[++$i]);
        else
            $camelized .= $s[$i];
    }

    $camelized = trim($camelized, ' _');

    if (strlen($camelized) > 0)
        $camelized[0] = strtolower($camelized[0]);

    return $camelized;
}

/**
 * Calculate birthdate from age.
 *
 * @param int $age 
 * @return date
 */
function calculate_birth_date($age) {
    $year = (date("Y") - $age);
    $month = date("m");
    $day = date("d");
    return date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
}

/**
 * Calculate age.
 *
 * @param int $birthDate 
 * @return int
 */
function calculate_age($birthDate) {
    $year = date("Y");//Current Year
    $birthDate = date_parse_from_format(DateTime::ISO8601, $birthDate);
    $y = $birthDate['year'];
    $age=$year-$y;
    return $age;
}

/**
 * Checkes whether a string is a valid email.
 *
 * @param int $age 
 * @return date
 */

function validateEMail($string) {
    if (!empty($string) && preg_match("/^([a-zA-Z0-9\.\_\-]+)@([a-zA-Z0-9\.\-]+\.[A-Za-z][A-Za-z]+)$/", $string)) {
        return true;
    } else {
        return false;
    }
}
//Uploaded photo thumbnail file name manipulation
function get_photo_base_filename($image_name) {
    return str_replace("thumbnail_1_", "", $image_name);
}

function get_thumbnail_2($image_name) {
    return empty($image_name) ? '' : 'thumbnail_2_'.str_replace("thumbnail_1_", "", $image_name);
}

