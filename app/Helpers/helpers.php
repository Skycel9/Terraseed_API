<?php

if (!function_exists("gcd")) {
    function gcd($a, $b) {
        return ($a % $b) ? gcd($b, $a % $b) : $b;
    }
}

if (!function_exists("ratio")) {
    function ratio( $x, $y = null ){
        $arr = $x;
        if (is_array($x) && count($x) === 2) {
            $x = current(array_slice($arr, 0, 1));
            $y = current(array_slice($arr, 1, 1));
        }
        $gcd = gcd($x, $y);
        return ($x/$gcd).':'.($y/$gcd);
    }
}

if (!function_exists("strToUrl")) {
    function strToUrl(string $str): string {

        // Replace quote by dash
        $str = preg_replace("/(\w)'(\w)/", '$1-$2', $str);

        // Replace special chars with ASCII equivalent if exists
        $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);

        // Remove non-alphanumeric chars then replace spaces by dash
        $str = preg_replace('/[^a-zA-Z0-9\s-]/', '', $str);
        $str = preg_replace('/\s+/', '-', trim($str));

        return strtolower($str);
    }
}

if (!function_exists("getParentTopic")) {
    function getParentTopic(Post|Comment|Topic|Attachment|null $el): Post|Comment|Topic|Attachment|null {
        if ($el instanceof Attachment || $el instanceof Comment || $el instanceof Post) {
            return getParentTopic($el->parent);
        } elseif ($el instanceof Topic) {
            return $el;
        }
        return null;
    }
}