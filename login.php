<?php
$user = "root";
$password = "jude7733";
$database = "mediDB";
$table = "user";
$success_message = "";
$error_message = "";
$users = [];
$isLoggedIn = false; // Variable to track if the user is logged in
$medicines = [];

try {
    $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $email = $_POST['email'];
            $password = md5($_POST['password']);

            // Check if the user is trying to log in
            if (isset($_POST['login'])) {
                $stmt = $db->prepare("SELECT email FROM $table WHERE email = ? AND password = ?");
                $stmt->execute([$email, $password]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    $success_message = "Logged in as: " . $user['email'];
                    $isLoggedIn = true; // Set to true when the user is logged in
                } else {
                    $error_message = "Login failed. Invalid email or password.";
                }
            } elseif (isset($_POST['register'])) {
                // Check if the email already exists
                $stmt = $db->prepare("SELECT email FROM $table WHERE email = ?");
                $stmt->execute([$email]);
                $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($existingUser) {
                    $error_message = "Registration failed. This email is already registered.";
                } else {
                    // Insert the data into the database (for registration)
                    $stmt = $db->prepare("INSERT INTO $table (email, password) VALUES (?, ?)");
                    if ($stmt->execute([$email, $password])) {
                        $success_message = "Registration successful. You can now log in.";
                    } else {
                        echo "Insert failed: " . implode(", ", $stmt->errorInfo());
                    }
                }
            }
        }

        // Handle delete action
        if (isset($_POST['delete'])) {
            $userId = $_POST['delete'];
            $stmt = $db->prepare("SELECT email FROM $table WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $email = $user['email'];
                $stmt = $db->prepare("DELETE FROM $table WHERE id = ?");
                if ($stmt->execute([$userId])) {
                    $success_message = "User with email '$email' deleted successfully.";
                }
            }
        }
    }

    // Fetch existing users in descending order of 'id'
    $stmt = $db->query("SELECT id, email FROM $table ORDER BY id DESC");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch medicines and side effects for logged-in users
    if ($isLoggedIn) {
        $stmt = $db->query("SELECT medicines, side_effects FROM mediTable");
        $medicines = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration and Login Form</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Bootstrap Table Sorter CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.18.3/dist/extensions/sortable/bootstrap-table-sortable.min.js"></script>
</head>

<body>
    <div class="container">
        <h2 class="mt-5">Registration and Login Form</h2>

        <?php if ($isLoggedIn): ?>
            <div class="alert alert-success mt-3">
                <?php echo $success_message; ?>
            </div>
        <?php else: ?>
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger mt-3">
                    <?php echo $error_message; ?>
                </div>
            <?php elseif (!empty($success_message)): ?>
                <div class="alert alert-info mt-3">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (!$isLoggedIn): ?>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-4">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" name="login" class="btn btn-primary">Login</button>
                <button type="submit" name="register" class="btn btn-success">Register</button>
            </form>
        <?php else: ?>
            <p class="mt-4">Logged in as:
                <?php echo $success_message; ?>
            </p>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-2">
                <button type="submit" name="logout" class="btn btn-danger">Logout</button>
            </form>
        <?php endif; ?>

        <h2 class="mt-5">Medicines and Side Effects</h2>
        <?php if ($isLoggedIn): ?>
            <?php if (!empty($medicines)): ?>
                <table class="table table-bordered table-striped mt-3">
                    <thead class="thead-dark">
                        <tr>
                            <th>Medicines</th>
                            <th>Side Effects</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($medicines as $medicine): ?>
                            <tr>
                                <td>
                                    <?php echo $medicine['medicines']; ?>
                                </td>
                                <td>
                                    <?php echo $medicine['side_effects']; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No medicines and side effects found.</p>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Existing Users table -->
        <h2 class="mt-5">Existing Users</h2>
        <?php if (!empty($users)): ?>
            <table class="table table-bordered table-striped mt-3" data-toggle="table">
                <thead class="thead-dark">
                    <tr>
                        <th data-field="id" data-sortable="true">ID</th>
                        <th data-field="email" data-sortable="true">Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td>
                                <?php echo $user['id']; ?>
                            </td>
                            <td>
                                <?php echo $user['email']; ?>
                            </td>
                            <td>
                                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                    <input type="hidden" name="delete" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No existing users found.</p>
        <?php endif; ?>
    </div>

    <!-- Add Bootstrap JS (optional) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Initialize Bootstrap Table Sorter -->
    <script>
        $(document).ready(functio n() {
            $('table').bootstrapTable();
        });
    </script>
</body>

</html>