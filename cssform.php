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
        if (isset($_POST['email']) && isset($_POST['password'])) {
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
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Registration Form</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Bootstrap Table Sorter CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.18.3/dist/bootstrap-table.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.18.3/dist/extensions/sortable/bootstrap-table-sortable.min.js"></script>
</head>

<body>
    <div class="container">
        <h2 class="mt-5">Registration Form</h2>

        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success mt-3">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mt-4">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>

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
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['email']; ?></td>
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
        $(document).ready(function() {
            $('table').bootstrapTable();
        });
    </script>
</body>

</html>
