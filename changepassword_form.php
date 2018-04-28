<!DOCTYPE html>
<html>
    <head>
        <title>Change Password</title>
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
            <h1 class="ui-widget-header">Change Password</h1>

            <?php
            if ($error) {
                print "<div class=\"ui-state-error\">$error</div>\n";
            }
            ?>

            <form action="changepassword.php" method="POST">

                <input type="hidden" name="action" value="do_change">

                <div class="stack">
                    <label for="oldPassword" class="changeLabel">Old Password:</label>
                    <input type="password" id="oldPassword" name="oldPassword" class="ui-widget-content ui-corner-all" required>
                </div>

                <div class="stack">
                    <label for="newPassword" class="changeLabel">New Password:</label>
                    <input type="password" id="newPassword" name="newPassword" class="ui-widget-content ui-corner-all" required>
                </div>
                
                <div class="stack">
                    <label for="confirmPass" class="changeLabel">Confirm New Password:</label>
                    <input type="password" id="confirmPass" name="confirmPass" class="ui-widget-content ui-corner-all" required>
                </div>

                <div class="stack">
                    <input type="submit" value="Submit">
                </div>
            </form>
        </div>
    </body>
</html>