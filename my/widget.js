var container = document.getElementById('widget');
var result = document.createElement('div');
var form = document.createElement('form');

form.innerHTML = '<input name="message"><br><input name="receiver"><br><button>Send</button>';

form.addEventListener('submit', e => {
    e.preventDefault();

    var data = new FormData(form);
    var req = new XMLHttpRequest();

    req.open('post', 'http://localhost:4000/form.php');
    req.addEventListener('loadend', e => {
        result.innerHTML = req.statusText;
        if (req.status === 200) {
            form.reset();
        }
    });
    req.send();
});

container.appendChild(result);
container.appendChild(form);
