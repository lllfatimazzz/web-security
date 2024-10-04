<?php
include "core.php";
head();

if (isset($_POST['database_host'])) {
    $_SESSION['database_host'] = addslashes($_POST['database_host']);
} else {
    $_SESSION['database_host'] = '';
}
if (isset($_POST['database_username'])) {
    $_SESSION['database_username'] = addslashes($_POST['database_username']);
} else {
    $_SESSION['database_username'] = '';
}
if (isset($_POST['database_password'])) {
    $_SESSION['database_password'] = addslashes($_POST['database_password']);
} else {
    $_SESSION['database_password'] = '';
}
if (isset($_POST['database_name'])) {
    $_SESSION['database_name'] = addslashes($_POST['database_name']);
} else {
    $_SESSION['database_name'] = '';
}
?>

<center>
    <h6 class="text-xl font-medium text-gray-700">Enter your database connection details. If you’re not sure about them, contact your hosting provider.</h6>
</center>
<hr class="my-4" />

<form method="post" action="" class="space-y-4">

    <div class="flex items-center space-x-4">
        <label class="w-1/3 text-right font-medium text-gray-700">Database Host: </label>
        <div class="w-2/3">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fas fa-database text-gray-400"></i>
                </span>
                <input type="text" name="database_host" class="pl-10 pr-3 py-2 border rounded-md w-full" placeholder="localhost" value="<?php echo $_SESSION['database_host']; ?>" required>
            </div>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <label class="w-1/3 text-right font-medium text-gray-700">Database Name: </label>
        <div class="w-2/3">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fas fa-list-alt text-gray-400"></i>
                </span>
                <input type="text" name="database_name" class="pl-10 pr-3 py-2 border rounded-md w-full" placeholder="security" value="<?php echo $_SESSION['database_name']; ?>" required>
            </div>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <label class="w-1/3 text-right font-medium text-gray-700">Database Username: </label>
        <div class="w-2/3">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fas fa-user text-gray-400"></i>
                </span>
                <input type="text" name="database_username" class="pl-10 pr-3 py-2 border rounded-md w-full" placeholder="root" value="<?php echo $_SESSION['database_username']; ?>" required>
            </div>
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <label class="w-1/3 text-right font-medium text-gray-700">Database Password: </label>
        <div class="w-2/3">
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <i class="fas fa-key text-gray-400"></i>
                </span>
                <input type="text" name="database_password" class="pl-10 pr-3 py-2 border rounded-md w-full" placeholder="" value="<?php echo $_SESSION['database_password']; ?>">
            </div>
        </div>
    </div>

    <?php
    if (isset($_POST['submit'])) {
        $database_host = $_POST['database_host'];
        $database_name = $_POST['database_name'];
        $database_username = $_POST['database_username'];
        $database_password = $_POST['database_password'];

        @$db = mysqli_connect($database_host, $database_username, $database_password, $database_name);
        if (!$db) {
            echo '<div class="text-red-500 mt-4">Error establishing a database connection.</div>';
        } else {
            echo '<meta http-equiv="refresh" content="0; url=settings.php" />';
        }
    }
    ?>

    <input class="w-full py-2 bg-blue-600 text-white rounded-md cursor-pointer hover:bg-blue-700" type="submit" name="submit" value="Next" />
</form>

<?php
// PHP Sessions check
$_SESSION['phpsess_check'] = "Test";
if (!isset($_SESSION['phpsess_check'])) {
    echo '<div class="text-red-500 mt-4">PHP Sessions are not enabled.</div>';
}

// PHP MySQLi check
if (!function_exists('mysqli_connect')) {
    echo '<div class="text-red-500 mt-4">PHP MySQLi extension is not enabled.</div>';
}

// PHP cURL check
if (!extension_loaded('curl')) {
    echo '<div class="text-red-500 mt-4">PHP cURL extension is not enabled.</div>';
}

if (!function_exists('json_decode')) {
    echo '<div class="text-red-500 mt-4">PHP json_decode function is not enabled.</div>';
}

footer();
?>
