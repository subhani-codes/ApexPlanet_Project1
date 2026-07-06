<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// If already logged in → go to todos
if(isset($_SESSION['user_id'])){
    header("Location: /myProjectOfApexPlanet/todos/view.php");
    exit();
}

require 'db.php';
$error = "";
$success = "";

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if(empty($username) || empty($email) || empty($password)){
        $error = "All fields are required!";
    } elseif($password !== $confirm_password){
        $error = "Passwords do not match!";
    } elseif(strlen($password) < 6){
        $error = "Password must be at least 6 characters!";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if($stmt->rowCount() > 0){
            $error = "Username already exists!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users 
                                  (username, email, password) 
                                   VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hashed_password]);
            $success = "Registration successful! You can now login.";
        }
    }
}
?>
<?php require 'includes/header.php'; ?>
<?php require 'includes/navbar.php'; ?>

<div class="auth-container">
    <div class="auth-box">
        <h2>Create Account</h2>

        <?php if($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="alert alert-success">
                <?php echo $success; ?>
                <a href="login.php">Login here</a>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" 
                       placeholder="Enter username" required/>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" 
                       placeholder="Enter email" required/>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" 
                       placeholder="Min 6 characters" required/>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" 
                       placeholder="Repeat password" required/>
            </div>
            <button type="submit" class="btn btn-primary btn-block">
                Register
            </button>
        </form>

        <p style="text-align:center; margin-top:16px; font-size:14px">
            Already have an account? 
            <a href="login.php" style="color:#3b82f6">Login here</a>
        </p>
    </div>
</div>

<?php require 'includes/footer.php'; ?>