var currentBid = document.getElementById("currentBid");
var bidAmount = document.getElementById("bidAmount");

// 24 hours from now
let endTime = Date.now() + 86400000;

function updateTimer() {
    let now = Date.now();
    let remaining = endTime - now;

    if (remaining <= 0) {
        document.getElementById("countdown").textContent = "EXPIRED";
        return;
    }

    let hours = Math.floor((remaining / (1000 * 60 * 60)) % 24);
    let minutes = Math.floor((remaining / (1000 * 60)) % 60);
    let seconds = Math.floor((remaining / 1000) % 60);

    document.getElementById("countdown").textContent =
        `${hours.toString().padStart(2, "0")}:` +
        `${minutes.toString().padStart(2, "0")}:` +
        `${seconds.toString().padStart(2, "0")}`;
}

setInterval(updateTimer, 1000);
updateTimer();

function placeBid() {
    let current = parseInt(currentBid.textContent);
    let userBid = parseInt(bidAmount.value);

    if (isNaN(userBid) || userBid <= 0) {
        alert("Enter a positive number!");
        return;
    }

    currentBid.textContent = current + userBid;
    bidAmount.value = "";
}
