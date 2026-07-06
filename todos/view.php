<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
require '../db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: /myProjectOfApexPlanet/login.php");
    exit();
}
$user_id = $_SESSION['user_id'];

// Get all todos
$stmt = $pdo->prepare("SELECT * FROM todos WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$user_id]);
$todos = $stmt->fetchAll();

// Count stats
$total = count($todos);
$completed = count(array_filter($todos, fn($t) => $t['status'] == 'completed'));
$pending = $total - $completed;
?>
<?php require '../includes/header.php'; ?>
<?php require '../includes/navbar.php'; ?>

<div class="container">
    <div class="page-header">
        <h2>My Tasks</h2>
        <a href="create.php" class="btn btn-success">+ Add New Task</a>
    </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Tasks</div>
            <div class="stat-value stat-blue"><?php echo $total; ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Completed</div>
            <div class="stat-value stat-green"><?php echo $completed; ?></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Pending</div>
            <div class="stat-value stat-amber"><?php echo $pending; ?></div>
        </div>
    </div>

    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>

    <?php if($total > 0): ?>
        <?php foreach($todos as $todo): ?>
        <div class="todo-item <?php echo $todo['status']=='completed' ? 'completed' : ''; ?>">
            <div style="flex:1">
                <div class="todo-title <?php echo $todo['status']=='completed' ? 'done' : ''; ?>">
                    <?php echo htmlspecialchars($todo['title']); ?>
                </div>
                <?php if($todo['description']): ?>
                <div class="todo-desc">
                    <?php echo htmlspecialchars($todo['description']); ?>
                </div>
                <?php endif; ?>
            </div>
            <span class="badge badge-<?php echo $todo['status']; ?>">
                <?php echo $todo['status'] == 'completed' ? 'Completed' : 'Pending'; ?>
            </span>
            <div style="display:flex; gap:6px">
                <a href="edit.php?id=<?php echo $todo['id']; ?>" 
                   class="btn btn-warning btn-sm">Edit</a>
                <a href="/myProjectOfApexPlanet/todos/delete.php?id=<?php echo $todo['id']; ?>" 
                   class="btn btn-danger btn-sm"
                   onclick="return confirmDelete()">Delete</a>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-state">
            <h3>No tasks yet!</h3>
            <p>Click "Add New Task" to get started!</p>
            <a href="create.php" class="btn btn-primary">+ Add Your First Task</a>
        </div>
    <?php endif; ?>
</div>

<?php require '../includes/footer.php'; ?>