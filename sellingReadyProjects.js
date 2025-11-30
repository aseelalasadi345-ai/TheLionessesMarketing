function startCountdown() {
    var timers = document.querySelectorAll(".timer");

    timers.forEach(function(timer) {
        var days = timer.getAttribute("data-days") || 6;
        var endTime = Date.now() + days * 24 * 60 * 60 * 1000;

        setInterval(function() {
            var timeRem = endTime - Date.now(); 

            if (timeRem <= 0) {
                timer.textContent = "0d : 0h : 0m : 0s";
                return;
            }

            var d = Math.floor(timeRem / (1000 * 60 * 60 * 24));
            var h = Math.floor(timeRem / (1000 * 60 * 60)) % 24;
            var m = Math.floor(timeRem / (1000 * 60)) % 60;
            var s = Math.floor(timeRem / 1000) % 60;

            timer.textContent = d + "d : " + h + "h : " + m + "m : " + s + "s";
        }, 1000);
    });
}

startCountdown();