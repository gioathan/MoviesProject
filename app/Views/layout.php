<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movie World</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 1rem 2rem;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }

        .auth-links a {
            margin-left: 0.5rem;
        }

        main {
            display: flex;
        }

        .content {
            flex: 3;
            padding-right: 2rem;
        }

        .sidebar {
            flex: 1;
            background-color: #f5f5f5;
            padding: 1rem;
            border-left: 1px solid #ddd;
        }

        .sidebar h3 {
            margin-top: 0;
        }
    </style>
</head>
<body>

<?php
use CodeIgniter\Router\Router;

$uri = service('uri');
$currentUri = $uri->getSegment(1);
$secondUri = $uri->getTotalSegments() >= 3 ? $uri->getSegment(3) : '';
?>

<header>
    <a href="<?= base_url() ?>" class="title">Movie World</a>
    <div class="auth-links">
        <?php if (session()->has('user_id')): ?>
            <span>Welcome back <a href="<?= base_url("user/" . session('user_id')) ?>"><?= esc(session('user_name')) ?></a></span>
            <a href="javascript:void(0)" onclick="showModal('logout')">Logout</a>
        <?php else: ?>
            <a href="javascript:void(0)" onclick="showModal('login')">Log in</a> or
            <a href="javascript:void(0)" onclick="showModal('signup')">Sign up</a>
        <?php endif; ?>
    </div>
</header>

<main>
    <div class="content">
        <?= $this->renderSection('content') ?>
    </div>

    <?php if (!($currentUri === 'user' && $secondUri && $secondUri === 'addMovie')): ?>
        <aside class="sidebar">
            <?= view('sidebar') ?>
        </aside>
    <?php endif; ?>
</main>

</body>

<script>
function showModal(type) {
    fetch('/' + type)
        .then(res => res.text())
        .then(html => {
            const modal = document.createElement('div');
            modal.id = "dynamicModal";
            modal.innerHTML = html;
            document.body.appendChild(modal);
        });
}

function closeModal() {
    const modal = document.getElementById('dynamicModal');
    if (modal) modal.remove();
}

// Handle login form submission
document.addEventListener('submit', function (e) {
    if (e.target.id === 'loginForm') {
        e.preventDefault();
        const formData = new FormData(e.target);
        fetch('/login', {
            method: 'POST',
            body: formData
        }).then(res => res.json())
          .then(data => {
              if (data.status === 'success') {
                const messageBox = document.getElementById('login-message');
                messageBox.textContent = data.message || 'Login successful!';
                messageBox.style.color = 'green';

                setTimeout(() => {
                    location.reload();
                }, 1000);
              } else {
                const messageBox = document.getElementById('login-message');
                messageBox.textContent = data.message;
                messageBox.style.color = 'red';
              }
          });
    }

    if (e.target.id === 'signupForm') {
        e.preventDefault();
        const formData = new FormData(e.target);
        fetch('/signup', {
            method: 'POST',
            body: formData
        }).then(res => res.json())
          .then(data => {
              if (data.status === 'success') {
                const messageBox = document.getElementById('signup-message');
                messageBox.textContent = data.message;
                messageBox.style.color = 'green';

                setTimeout(() => {
                    location.reload();
                }, 1000);
              } else {
                  const errBox = document.getElementById('signup-message');
                  errBox.innerHTML = '';
                  errBox.style.color = 'red';
                  for (let field in data.errors) {
                      errBox.innerHTML += `<div>${data.errors[field]}</div>`;
                  }
              }
          });
    }
});
</script>
</html>
