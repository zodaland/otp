<?php
    date_default_timezone_set('Asia/Seoul');

    include "./lib/ga.php";
	include "./config/config.php";

    $ga = new PHPGangsta_googleAuthenticator();

    $timeCurrent = floor(time() / 30);
    $timeBefore = floor((time() - 30) / 30);
    $timeAfter = floor((time() + 30) / 30);

    $codeCurrent = $ga->getCode(SECRET_KEY, $timeCurrent);
    $codeBefore = $ga->getCode(SECRET_KEY, $timeBefore);
    $codeAfter = $ga->getCode(SECRET_KEY, $timeAfter);

    $codeList = array($codeBefore, $codeCurrent, $codeAfter);
    $input = substr($_SERVER['SCRIPT_NAME'], 1);

    if (in_array($input, $codeList)) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, HOOK_URL);
        curl_setopt($ch, CURLOPT_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_VERIFYPEER, 0);

        $response = curl_exec($ch);
        curl_close($ch);
	
        if ($response) {
            echo "hello";
        }
    } else {
        header("HTTP/1.0 404 Not Found");
        exit;
    }
?>
