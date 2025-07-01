function hideMessage() {
    if (document.querySelector(".floating-window")) {
        document.querySelector(".floating-window").classList.add('closed');
    }
}

window.addEventListener("DOMContentLoaded", function() {
        setTimeout(hideMessage, 1500);
    }, false);
