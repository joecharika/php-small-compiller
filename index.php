<?php
$output = "";
$input = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = $_POST["run"];

    preg_match("/<\?php(.*?)\?>/s", $input, $code);

    $output = eval($code[1]);

    $fileName = __DIR__ . '\\' . uniqid() . '.php';
    $fileHandle = fopen($fileName, 'w+');
    fwrite($fileHandle, $input);
    $fileName = realpath($fileName);
    $output = shell_exec('php -l "' . $fileName . '"');
    $syntaxError = preg_replace("/Errors parsing.*$/", "", $output, -1, $count);
    fclose($fileHandle);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
</head>
<body>
<form method="post">
    <textarea name="run" id="" cols="30" rows="10"></textarea>
    <button type="submit">Run Code</button>
</form>
<div>
    <h3>Input</h3>
    <pre>
        <?= $input ?>
    </pre>
</div>
<div>
    <h3>Output</h3>
    <pre>
        <?= $output ?>
    </pre>
</div>
</body>
</html>
