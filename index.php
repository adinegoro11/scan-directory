<?php
session_start();
$_SESSION = [];
echo "Input Path: ";
$path = fopen("php://stdin", "r");
$path = trim(fgets($path));


checking_directory($path);
print_r($_SESSION);

die();
session_destroy();

function input_string($string = null)
{
    $_SESSION['data'][] = $string;
}

function checking_directory($target)
{
    if (is_dir($target)) {
        $files = glob($target . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned

        foreach ($files as $file) {
            if (is_file($file)) {
                $content = file($file);
                if (count($content) == 0) {
                    continue;
                }
                input_string($content[0]);
            }
            checking_directory($file);
        }
    }
}

function countArray()
{
    $result = [];
    $i = 0;
    foreach ($_SESSION['data'] as $key => $value) {


        if (!in_array($value, $result, true)) {
            $result[] = [
                'string' => $value,
                'total' => 1,
            ];
        } elseif ($value == $result[$i]['string']) {
            $result[$i]['total'] += 1;
        }

        $i++;
    }

}

