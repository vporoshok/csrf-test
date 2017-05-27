<?php
    const SECRET = "SOME SECRET";

    session_start();
    $sender = $_SESSION['email'];
    if (strlen($sender) === 0) {
        http_response_code(401);
        echo('Unauthorized');
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'];
        $tokenSplit = explode(':', $token);
        if (count($tokenSplit) !== 3 || $tokenSplit[1] !== $sender) {
            http_response_code(400);
            echo('Bad CSRF token');
            exit();
        }
        $token = sprintf('%s:%s:', $tokenSplit[0], $tokenSplit[1]);
        $hash = sha1($token . SECRET);
        if ($hash !== $tokenSplit[2]) {
            http_response_code(400);
            echo('Bad CSRF token');
            exit();
        }
        if (time() - intval($tokenSplit[0]) > 600) {
            echo('CSRF token expired. Please try again');
        } else {
            $message = $_POST['message'];
            $receiver = $_POST['receiver'];
            echo("Send $message to $receiver");
            $message = '';
            $receiver = '';
        }
    }
    $token = sprintf('%d:%s:', time(), $sender);
    $token .= sha1($token . SECRET);
?>
<p>Hello, <?php echo($sender) ?>!</p>
<form method="post">
    <input type="hidden" name="csrf_token" value="<?php echo($token) ?>">
    <input name="message" placeholder="message" value="<?php echo($message) ?>"><br>
    <input name="receiver" placeholder="receiver" value="<?php echo($receiver) ?>"><br>
    <button>Send</button>
</form>
