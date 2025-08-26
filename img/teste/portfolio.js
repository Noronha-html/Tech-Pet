document.getElementById("year").textContent = new Date().getFullYear();

const navToggle = document.getElementById("navToggle");
const mobileNav = document.getElementById("mobileNav");
function toggleNav() {
  const open = document.body.classList.toggle("nav-open");
  mobileNav.setAttribute("aria-hidden", String(!open));
}
navToggle.addEventListener("click", toggleNav);

window.addEventListener("resize", () => {
  if (window.innerWidth > 880 && document.body.classList.contains("nav-open")) {
    document.body.classList.remove("nav-open");
    mobileNav.setAttribute("aria-hidden", "true");
  }
});
