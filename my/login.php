<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $_SESSION['email'] = $_POST['email'];
        header('Location: /form.php');
        exit();
    }
?>
<form method="post">
    <input name="email">
    <button>Login</button>
</form>
