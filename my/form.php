<?php
    session_start();
    $sender = $_SESSION['email'];
    if (strlen($sender) === 0) {
        http_response_code(401);
        echo('Unauthorized');
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $message = $_POST['message'];
        $receiver = $_POST['receiver'];
        echo("Send $message to $receiver");
    }
?>
<p>Hello, <?php echo($sender) ?>!</p>
<form method="post">
    <input name="message" placeholder="message"><br>
    <input name="receiver" placeholder="receiver"><br>
    <button>Send</button>
</form>
