<?php
// member.php
// Página reutilizável com array de membros + HTML/CSS/JS polidos.
// Uso: member.php?member=frontend  (ou backend, designer)

function e($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$members = [
    'frontend' => [
        'name' => 'Arthur Fernandes',
        'title' => 'Desenvolvedor Front-end',
        'bio' => 'Especialista em interfaces interativas, componentes reutilizáveis e otimização de performance. Gosta de transformar designs em experiências fluidas.',
        // skills podem ser strings ou arrays ['name'=>..., 'level'=>NN]
        'skills' => ['HTML', 'CSS', 'JavaScript', 'React', 'Acessibilidade'],
        'email' => 'arthur.p.fernandes.31@gmail.com',
    ],
    'backend' => [
        'name' => 'Felipe Noronha',
        'title' => 'Desenvolvedor Back-end',
        'bio' => 'Foca em arquiteturas escaláveis, APIs robustas e integrações seguras. gosta de trabalhar com bancos de dados e solucionar problemas complexos no servidor.',
        'skills' => ['PHP', 'Node.js', 'SQL', 'APIs REST', 'Docker'],
        'email' => 'felipe.dariva07@gmail.com',
    ],
    'designer' => [
        'name' => 'Lucas Martini',
        'title' => 'Designer',
        'bio' => 'Cria identidades visuais e interfaces centradas no usuário, unindo estética e usabilidade. Trabalha com prototipação rápida e design systems para entregar soluções consistentes e escaláveis..',
        'skills' => ['Figma', 'UX', 'UI', 'Prototipagem', 'Design System'],
        'email' => 'martinilucas2021@gmail.com'
    ]
];

$requested = isset($_GET['member']) ? strtolower(trim($_GET['member'])) : 'frontend';
if (!array_key_exists($requested, $members)) {
    $requested = 'frontend';
}
$m = $members[$requested];

// mapeamento de nível padrão para skills (caso user não informe level)
$default_levels = [
    'html' => 95, 'css' => 92, 'javascript' => 88, 'react' => 82, 'acessibilidade' => 75,
    'php' => 85, 'node.js' => 82, 'sql' => 80, 'apis rest' => 86, 'docker' => 78,
    'figma' => 90, 'ux' => 88, 'ui' => 86, 'prototipagem' => 80, 'design system' => 78
];

switch ($requested) {
  case 'frontend':
    $photoCandidate = '1000079117.png';
    break;
  case 'backend':
    $photoCandidate = '1000079112.png';
    break;
  case 'designer':
    $photoCandidate = '1000079116.png';
    break;
  default:
    $photoCandidate = 'photo.jpg';
    break;
}

// determina caminho da foto: procura por [frontend|backend|designer].jpg ou usa photo.jpg
//$photoCandidate = $requested . '.jpg';
//$photoPath = file_exists(/*__DIR__ .*/ './img-t/' . $photoCandidate) ? $photoCandidate : 'photo.jpg';
$imgDir = 'img-t/';
$serverPath = __DIR__ . DIRECTORY_SEPARATOR . $imgDir . $photoCandidate;
$photoPath = file_exists($serverPath) ? $imgDir . $photoCandidate : 'photo.jpg';
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>
    <?php echo e($m['name'] . ' — ' . $m['title']); ?>
  </title>
  <link rel="stylesheet" href="membro.css">
</head>

<body>
  <div class="wrap">
    <header class="header">
      <nav><a class="page-title" href="portfolio.php">Página principal</a></nav>
    </header>

    <main class="main">
      <article class="profile" data-email="<?php echo e($m['email']); ?>">
        <div class="profile-card">
          <div class="photo-block">
            <img src="<?php echo e($photoPath); ?>" alt="Foto de <?php echo e($m['name']); ?>" class="photo"
              onerror="this.style.display='none'; document.querySelector('.photo-fallback').style.display='flex'">
            <div class="photo-fallback" aria-hidden="true" style="display:none">
              <svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Avatar">
                <defs>
                  <linearGradient id="g" x1="0" x2="1">
                    <stop offset="0" stop-color="#6f3dff" />
                    <stop offset="1" stop-color="#00d1ff" />
                  </linearGradient>
                </defs>
                <rect width="120" height="120" rx="18" fill="url(#g)" />
                <circle cx="60" cy="44" r="26" fill="#fff" opacity="0.95" />
                <rect x="20" y="78" width="80" height="18" rx="9" fill="#fff" />
              </svg>
            </div>
          </div>

          <div class="profile-info">
            <h1 class="name">
              <?php echo e($m['name']); ?>
            </h1>
            <p class="role">
              <?php echo e($m['title']); ?>
            </p>
            <p class="bio">
              <?php echo e($m['bio']); ?>
            </p>

            <div class="meta">
              <div class="meta-item">
                <strong id="skill-count">
                  <?php echo count($m['skills']); ?>
                </strong>
                <span>Habilidades</span>
              </div>
              <div class="meta-item">
                <strong>Contato</strong>
                <span><a class="mailto" href="mailto:<?php echo e($m['email']); ?>">
                    <?php echo e($m['email']); ?>
                  </a></span>
              </div>
            </div>

            <div class="actions">
              <!--a id="email-cta" class="btn" href="portfolio.php#contact">Enviar e-mail</a-->
            </div>
          </div>
        </div>
      </article>

      <aside class="skills-block" aria-labelledby="skillsTitle">
        <h2 id="skillsTitle">Principais habilidades</h2>
        <ul class="skills-list">
          <?php
          // renderiza skills; aceita string ou array ['name'=>..., 'level'=>NN]
          foreach ($m['skills'] as $skill) {
              if (is_array($skill)) {
                  $name = $skill['name'];
                  $level = isset($skill['level']) ? (int)$skill['level'] : ($default_levels[strtolower($skill['name'])] ?? 75);
              } else {
                  $name = $skill;
                  $key = strtolower($name);
                  $level = isset($default_levels[$key]) ? $default_levels[$key] : 75;
              }
              $level = max(0, min(100, (int)$level));
          ?>
          <li data-level="<?php echo e($level); ?>">
            <span class="skill">
              <?php echo e($name); ?>
            </span>
            <span class="pct">
              <?php echo e($level); ?>%
            </span>
            <div class="bar">
              <div class="bar-fill" style="width:0%;"></div>
            </div>
          </li>
          <?php } ?>
        </ul>
      </aside>
    </main>

    <footer class="footer">
      <span>&copy; <span id="year"></span>
    </footer>
  </div>

  <script src="membro.js" defer></script>
</body>

</html>