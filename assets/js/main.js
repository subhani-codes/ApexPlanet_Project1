// Confirm before deleting
function confirmDelete() {
    return confirm("Are you sure you want to delete this task?");
}

// Auto hide alerts after 3 seconds
document.addEventListener("DOMContentLoaded", function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            alert.style.display = 'none';
        }, 3000);
    });
});