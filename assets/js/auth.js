// Small friendly animation
document.addEventListener("DOMContentLoaded", () => {
    const card = document.querySelector(".auth-card");
    card.style.transform = "scale(0.95)";
    setTimeout(() => {
        card.style.transform = "scale(1)";
    }, 100);
});
