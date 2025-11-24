window.addEventListener("load", () => {
    document.body.classList.add("page-loaded");
});

// Scroll to transformations on hero button click
const seeBtn = document.getElementById("seeTransformations");
if (seeBtn) {
    seeBtn.addEventListener("click", () => {
        const target = document.getElementById("cases");
        if (target) target.scrollIntoView({ behavior: "smooth" });
    });
}

// Before/After sliders
document.querySelectorAll(".ba-container").forEach(container => {
    const slider = container.querySelector(".ba-slider");
    if (!slider) return;

    const updatePos = (value) => {
        const clamped = Math.max(0, Math.min(100, value));
        container.style.setProperty("--pos", clamped + "%");
    };

    slider.addEventListener("input", (e) => {
        updatePos(e.target.value);
    });

    // Optional: drag on desktop by clicking anywhere in the container
    container.addEventListener("pointerdown", (e) => {
        const rect = container.getBoundingClientRect();
        const move = (event) => {
            const relativeX = event.clientX - rect.left;
            const percentage = (relativeX / rect.width) * 100;
            updatePos(percentage);
            slider.value = percentage;
        };
        move(e);
        const up = () => {
            window.removeEventListener("pointermove", move);
            window.removeEventListener("pointerup", up);
        };
        window.addEventListener("pointermove", move);
        window.addEventListener("pointerup", up);
    });
});

// Animated stats
const counters = document.querySelectorAll(".stat-number");

function animateCounter(el) {
    const targetStr = el.dataset.target;
    if (!targetStr) return;
    const decimals = targetStr.includes(".")
        ? targetStr.split(".")[1].length
        : 0;
    const target = parseFloat(targetStr);
    const duration = 1800;
    const startTime = performance.now();

    function update(now) {
        const progress = Math.min((now - startTime) / duration, 1);
        const value = target * progress;
        el.textContent = value.toFixed(decimals);
        if (progress < 1) {
            requestAnimationFrame(update);
        }
    }
    requestAnimationFrame(update);
}

if ("IntersectionObserver" in window) {
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.4 }
    );

    counters.forEach((c) => observer.observe(c));
} else {
    // Fallback if IntersectionObserver is not supported
    counters.forEach((c) => animateCounter(c));
}