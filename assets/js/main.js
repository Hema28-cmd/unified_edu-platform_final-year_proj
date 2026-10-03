document.addEventListener("DOMContentLoaded", function () {

    const counters = document.querySelectorAll(".counter");
    const stats = document.getElementById("stats");
    let started = false;

    function animateCounter(counter) {
        const target = Number(counter.dataset.target);
        let count = 0;
        const increment = Math.ceil(target / 30); // FAST

        const timer = setInterval(() => {
            count += increment;
            if (count >= target) {
                counter.innerText = target;
                clearInterval(timer);
            } else {
                counter.innerText = count;
            }
        }, 30);
    }

    function startCounters() {
        if (started) return;
        counters.forEach(counter => animateCounter(counter));
        started = true;
    }

    window.addEventListener("scroll", () => {
        const top = stats.getBoundingClientRect().top;
        if (top < window.innerHeight) {
            startCounters();
        }
    });

    // Trigger if already visible
    if (stats.getBoundingClientRect().top < window.innerHeight) {
        startCounters();
    }

});

