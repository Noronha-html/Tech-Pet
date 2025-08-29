// member.js — animações simples e comportamento do formulário
document.addEventListener('DOMContentLoaded', () => {
  // ano do rodapé
  const yearEl = document.getElementById('year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  // inicializa barras de habilidade (usa data-level de cada li)
  const skillItems = document.querySelectorAll('.skills-list li');
  const skillCount = document.getElementById('skill-count');
  if (skillCount) skillCount.textContent = skillItems.length;

  // animar largura das .bar-fill
  skillItems.forEach((li, idx) => {
    const level = parseInt(li.getAttribute('data-level') || '0', 10);
    const fill = li.querySelector('.bar-fill');
    const pct = li.querySelector('.pct');
    if (pct) pct.textContent = `${level}%`;
    if (fill) {
      // pequena animação em cascata
      setTimeout(() => {
        fill.style.width = Math.max(0, Math.min(100, level)) + '%';
      }, 120 * idx);
    }
  });

  // formulário: abre mailto com corpo e campos preenchidos
  const form = document.getElementById('contactForm');
  if (form) {
    form.addEventListener('submit', (ev) => {
      ev.preventDefault();
      const profile = document.querySelector('.profile');
      const memberEmail = profile ? profile.getAttribute('data-email') : '';
      const name = document.getElementById('name').value.trim();
      const email = document.getElementById('email').value.trim();
      const subject = document.getElementById('subject').value.trim();
      const message = document.getElementById('message').value.trim();

      const bodyLines = [
        `Nome: ${name}`,
        `E-mail do remetente: ${email}`,
        '',
        message
      ];
      const body = encodeURIComponent(bodyLines.join('\n'));
      const mailto = `mailto:${encodeURIComponent(memberEmail)}?subject=${encodeURIComponent(subject)}&body=${body}`;
      window.location.href = mailto;
    });
  }

const profile = document.querySelector('.profile');
const emailLink = profile ? profile.getAttribute('data-email') : '';
if (emailLink) {
  const anchor = document.querySelector('.mailto');
  if (anchor) anchor.href = `mailto:${emailLink}`;
}
})