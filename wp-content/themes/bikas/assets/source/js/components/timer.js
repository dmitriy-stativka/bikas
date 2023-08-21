const counter = document.querySelector('.counter');
const dataSeconds = counter?.getAttribute('data-seconds');

function formatTime(seconds) {
    const hours = Math.floor(seconds / 3600);
    const minutes = Math.floor((seconds % 3600) / 60);
    const remainingSeconds = seconds % 60;

    return `${hours.toString().padStart(2, '0')} : ${minutes.toString().padStart(2, '0')} : ${remainingSeconds.toString().padStart(2, '0')}`;
}

function countdownTimer(totalSeconds) {
    let secondsLeft = totalSeconds;

    const timerInterval = setInterval(() => {
        counter.innerHTML = formatTime(secondsLeft);
        secondsLeft--;

        if (secondsLeft < 0) {
            clearInterval(timerInterval);
            console.log("Время истекло!");
            localStorage.removeItem('timerRemaining');
        } else {
            localStorage.setItem('timerRemaining', secondsLeft);
        }
    }, 1000);
}

if (counter) {
    const totalSeconds = +dataSeconds;

    let savedRemainingSeconds = localStorage.getItem('timerRemaining');
    if (savedRemainingSeconds !== null) {
        countdownTimer(savedRemainingSeconds);
    } else {
        countdownTimer(totalSeconds);
    }
}
