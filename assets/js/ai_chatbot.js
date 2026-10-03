const botBox = document.getElementById("ai-bot-box");
const botBtn = document.getElementById("ai-bot-btn");
const messages = document.getElementById("ai-bot-messages");

botBtn.onclick = toggleBot;

function toggleBot(){
  botBox.style.display = botBox.style.display === "flex" ? "none" : "flex";
}

function sendMessage(){
  const input = document.getElementById("botText");
  const text = input.value.trim();
  if(text === "") return;

  messages.innerHTML += `<div class="bot-msg user">${text}</div>`;
  input.value = "";

  setTimeout(() => {
    messages.innerHTML += `<div class="bot-msg bot">${getBotReply(text)}</div>`;
    messages.scrollTop = messages.scrollHeight;
  }, 600);
}

function getBotReply(msg){
  msg = msg.toLowerCase();

  if(msg.includes("course")) return "You can find courses in the Courses section.";
  if(msg.includes("login")) return "Use your registered email and password to login.";
  if(msg.includes("admin")) return "Admins can manage users, courses, and reports.";
  if(msg.includes("help")) return "I'm here to assist you with learning and navigation.";

  return "I'm an AI assistant designed to help students learn and navigate the platform.";
}
