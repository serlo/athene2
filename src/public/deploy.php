<?php set_time_limit(1200); ?>
<?php putenv('HOME=' . __DIR__ . '/../../'); ?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>GIT DEPLOYMENT SCRIPT</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
<pre>
 .  ____  .    ____________________________
 |/      \|   |                            |
[| <span style="color: #FF0000;">&hearts; &hearts;</span> |]  | Git Deployment Script v0.1 |
 |___==___|  / &copy; oodavid 2012 |
              |____________________________|
    <?php
    /**
     * GIT DEPLOYMENT SCRIPT
     * Used for automatically deploying websites via github or bitbucket, more deets here:
     *        https://gist.github.com/1809044
     */

    // The commands
    $commands = array(
        "echo $PWD",
        "whoami",
        "git pull --ff",
        "git status",
        "rm " . __DIR__ . "/../data/twig -rf",
        "cd " . __DIR__ . "/../../bin/;sh build.sh",
        "cd " . __DIR__ . "/../assets/;npm cache clean",
        "cd " . __DIR__ . "/../assets/;npm install",
        "cd " . __DIR__ . "/../assets/;npm update",
        "pm2 dump && pm2 kill",
        "pm2 start \"" . __DIR__ . "/../assets/node_modules/athene2-editor/server/server.js\" > /dev/null 2>/dev/null &",
        "cd " . __DIR__ . "/../assets/;bower cache clean",
        "cd " . __DIR__ . "/../assets/;bower install",
        "cd " . __DIR__ . "/../assets/;bower update",
        "cd " . __DIR__ . "/../assets/;grunt build",
        "rm " . __DIR__ . "/assets/* -rf",
        "cd " . __DIR__ . "/../../;php composer.phar update -o"
    );

    // Run the commands for output
    $output = '';
    foreach ($commands AS $command) {
        // Run it
        $tmp = shell_exec($command);

        // Fallback on error
        if ($tmp === null) {
            $tmp = exec($command);
        }

        // Output
        $output = "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{$command}\n</span>";
        $output .= htmlentities(trim($tmp)) . "\n";
        echo $output;
        flush();
        ob_flush();
    }

    // Make it pretty for manual user access (and why not?)
    ?>
</pre>
</body>
</html>