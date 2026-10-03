function unlockNextLevel() {
    const btn = document.getElementById("nextBtn");
    btn.disabled = false;
    btn.classList.remove("disabled");
    btn.classList.add("active");
    btn.innerHTML = "🚀 Move to Next Level";
    btn.onclick = () => {
        window.location.href = "upgrade_level.php";
    };
}
