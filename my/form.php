<?php
    session_start();
    $sender = $_SESSION['email'];
    if (strlen($sender) === 0) {
        http_response_code(401);
        echo('Unauthorized');
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dataRaw = file_get_contents('php://input');
        $data = json_decode($dataRaw, true);
        $message = $data['message'];
        $receiver = $data['receiver'];
        echo("Send $message to $receiver");
    }
?>
<p id="state"></p>
<form name="send">
    <input name="message" placeholder="message"><br>
    <input name="receiver" placeholder="receiver"><br>
    <button>Send</button>
</form>
<script>
    var form = document.forms.namedItem('send');
    var state = document.getElementById('state');

    form.addEventListener('submit', e => {
        e.preventDefault();
        var message = form.querySelector('input[name="message"]');
        var receiver = form.querySelector('input[name="receiver"]');

        var data = {
            message: message.value,
            receiver: receiver.value
        };
        var req = new XMLHttpRequest();

        req.open('POST', '/form.php');
        req.setRequestHeader('Content-Type', 'application/json');
        req.addEventListener('readystatechange', e => {
            if (req.readyState !== req.DONE) {
                return;
            }
            if (req.status === 200) {
                state.innerHTML = `Send ${message.value} to ${receiver.value}`;
                message.value = '';
                receiver.value = '';
            }
        });
        req.send(JSON.stringify(data));
    });
</script>
