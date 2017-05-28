<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dataRaw = file_get_contents('php://input');
        $data = json_decode($dataRaw, true);
        var_dump($data);
        $_SESSION['email'] = $data['email'];
        header('Location: /form.php');
        exit();
    }
?>
<form name="login">
    <input name="email">
    <button>Login</button>
</form>
<script>
    var form = document.forms.namedItem('login');

    form.addEventListener('submit', e => {
        e.preventDefault();
        var email = form.querySelector('input[name="email"]');

        var data = {
            email: email.value
        };
        var req = new XMLHttpRequest();

        req.open('POST', '/login.php');
        req.setRequestHeader('Content-Type', 'application/json');
        req.addEventListener('readystatechange', e => {
            if (req.readyState !== req.DONE) {
                return;
            }
            if (req.status === 200) {
                window.location = '/form.php';
            }
        });
        req.send(JSON.stringify(data));
    });
</script>
