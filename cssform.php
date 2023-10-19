<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }

        h2 {
            margin-top: 20px;
        }

        .container {
            margin: 0 auto;
            width: 50%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f5f5f5;
        }

        label {
            display: block;
            margin-top: 10px;
            text-align: left;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <h2>Registration Form</h2>

    <div class="container">
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
    </div>

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
