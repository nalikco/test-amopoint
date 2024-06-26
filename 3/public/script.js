const serverUrl = 'https://third-test-amopoint-fbd84a20b9c4.herokuapp.com';

function sendPostRequest(url) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log('Sent.');
        }
    };
    xhr.send();
}

document.addEventListener('DOMContentLoaded', function () {
    sendPostRequest(serverUrl + "/handle.php");
});
