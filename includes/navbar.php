<nav class="navbar">
    <div class="navbar-brand">
        <a href="/myProjectOfApexPlanet/">📋 Task Tracker</a>
    </div>
    <div class="navbar-menu">
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="/myProjectOfApexPlanet/todos/view.php">My Tasks</a>
            <a href="/myProjectOfApexPlanet/todos/create.php">Add Task</a>
            <?php if($_SESSION['role'] == 'admin'): ?>
                <a href="/myProjectOfApexPlanet/admin/dashboard.php">Admin</a>
            <?php endif; ?>
            <a href="/myProjectOfApexPlanet/logout.php">Logout</a>
        <?php else: ?>
            <a href="/myProjectOfApexPlanet/login.php">Login</a>
            <a href="/myProjectOfApexPlanet/register.php">Register</a>
        <?php endif; ?>
    </div>
</nav>