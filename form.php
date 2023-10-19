<?php
$user = "root";
$password = "jude7733";
$database = "mediDB";
$table = "user";
$success_message = "";
$users = [];

try {
    $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        // Insert the data into the database
        $stmt = $db->prepare("INSERT INTO $table (email, password) VALUES (?, ?)");
        if ($stmt->execute([$email, $password])) {
            $success_message = "Registration successful. You can now log in.";
        } else {
            echo "Insert failed: " . implode(", ", $stmt->errorInfo());
        }
    }

    // Fetch existing users
    $stmt = $db->query("SELECT email FROM $table");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration Form</title>
</head>

<body>
    <h2>Registration Form</h2>
    <?php if (!empty($success_message)): ?>
        <p>
            <?php echo $success_message; ?>
        </p>
    <?php endif; ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Register">
    </form>

    <h2>Existing Users</h2>
    <?php if (!empty($users)): ?>
        <table>
            <tr>
                <th>Email</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <?php echo $user['email']; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No existing users found.</p>
    <?php endif; ?>
</body>

</html>