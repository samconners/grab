<!DOCTYPE html>
<html>
    <head>
        <title>Database Login</title>
        <link href="app.css" rel="stylesheet" type="text/css">
        <link href="../jquery-ui-1.11.4.custom/jquery-ui.min.css" rel="stylesheet" type="text/css">
        <script src="../jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
        <script src="../jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
        <script>
            $(function(){
                $("input[type=submit]").button();
            });
        </script>
    </head>
    <body>
        <div id="loginWidget" class="ui-widget">
            <h1 class="ui-widget-header">New User</h1>

            <?php
            if ($error) {
                print "<div class=\"ui-state-error\">$error</div>\n";
            }
            ?>

            <form action="createuser.php" method="POST">

                <input type="hidden" name="action" value="do_create">

                <div class="stack">
                    <label for="username">User name:</label>
                    <input type="text" id="username" name="username" class="ui-widget-content ui-corner-all" autofocus value="<?php print $username; ?>" required>
                </div>

                <div class="stack">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="ui-widget-content ui-corner-all" required>
                </div>
                
                <div class="stack">
                    <label for="confirmPass">Confirm Password:</label>
                    <input type="password" id="confirmPass" name="confirmPass" class="ui-widget-content ui-corner-all" required>
                </div>

                <div class="stack">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
    </body>
</html>