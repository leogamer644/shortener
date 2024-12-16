<?php
    $url = escapeshellarg($_POST['shorten']);

    // Debug
    echo $url;

    // Execute the C program with the provided input
    $command = "./shortener.out $url";
    $output = shell_exec($command);

    // Display the output from the C program
    echo "<h1>Result:</h1>";
    echo "<pre>shortener.leogamer644.com/".$output."</pre>";
?>
