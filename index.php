<?php
$configfile = 'config.php';
if (!file_exists($configfile)) {
    echo '<meta http-equiv="refresh" content="0; url=install" />';
    exit();
}

include "config.php";

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['sec-username'])) {
    $uname = $_SESSION['sec-username'];
    if ($uname == $settings['username']) {
        echo '<meta http-equiv="refresh" content="0; url=dashboard.php" />';
        exit;
    }
}

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_SPECIAL_CHARS);
$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

$error = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Antonov_WEB">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#000000">
    <title>Login Box</title>

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.png">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen <?php echo $settings['dark_mode'] == 1 ? 'dark' : ''; ?>">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white">
            Forensic Attribution of Cyber Attackers Using Advanced Detection
        </h1>

        <form action="" method="post">
            <div class="space-y-4">
                <?php
                if (isset($_POST['signin'])) {
                    $ip = addslashes(htmlentities($_SERVER['REMOTE_ADDR']));
                    if ($ip == "::1") {
                        $ip = "127.0.0.1";
                    }
                    @$date = @date("d F Y");
                    @$time = @date("H:i");

                    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
                    $password = hash('sha256', $_POST['password']);

                    if ($username == $settings['username'] && $password == $settings['password']) {

                        $checklh = $mysqli->query("SELECT id FROM `psec_logins` WHERE `username`='$username' AND ip='$ip' AND date='$date' AND time='$time' AND successful='1'");
                        if (mysqli_num_rows($checklh) == 0) {
                            $log = $mysqli->query("INSERT INTO `psec_logins` (username, ip, date, time, successful) VALUES ('$username', '$ip', '$date', '$time', '1')");
                        }

                        $_SESSION['sec-username'] = $username;

                        echo '<meta http-equiv="refresh" content="0;url=dashboard.php">';
                    } else {
                        $checklh = $mysqli->query("SELECT id FROM `psec_logins` WHERE `username`='$username' AND ip='$ip' AND date='$date' AND time='$time' AND successful='0'");
                        if (mysqli_num_rows($checklh) == 0) {
                            $log = $mysqli->query("INSERT INTO `psec_logins` (username, ip, date, time, successful) VALUES ('$username', '$ip', '$date', '$time', '0')");
                        }

                        echo '
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800">
                            <i class="fas fa-exclamation-circle"></i> The entered <strong>Username</strong> or <strong>Password</strong> is incorrect.
                        </div>';
                        $error = 1;
                    }
                }
                ?>
                <div class="space-y-2">
                    <div>
                        <input type="text" name="username" class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-white <?php echo $error == 1 ? 'border-red-500' : ''; ?>" placeholder="Username" <?php echo $error == 1 ? 'autofocus' : ''; ?> required>
                    </div>
                    <div>
                        <input type="password" name="password" class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 dark:bg-gray-700 dark:text-white" placeholder="Password" required>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" checked>
                        <label for="remember" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">Remember Me</label>
                    </div>
                    <button type="submit" name="signin" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-blue-500 dark:hover:bg-blue-600">
                        <i class="fas fa-sign-in-alt"></i>&nbsp;Sign In
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
