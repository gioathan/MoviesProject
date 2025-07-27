<div class="modal-backdrop" onclick="closeModal(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <?php if (isset($validation) && $validation->getErrors()): ?>
            <div style="color: red; font-weight: bold; margin-bottom: 1rem;">
                <?php foreach ($validation->getErrors() as $error): ?>
                    <div><?= $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <button class="close-btn" onclick="closeModal()">×</button>
        <h2>Login</h2>

        <div id="login-message" style="margin-bottom: 1rem; font-weight: bold;"></div>

        <form id="loginForm">
            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <button type="submit">Log In</button>
        </form>
    </div>
</div>

<style>
    .modal-backdrop {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        width: 100%;
        max-width: 400px;
        position: relative;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
    }

    form {
        display: flex;
        flex-direction: column;
    }

    label {
        margin-top: 1rem;
        margin-bottom: 0.3rem;
        font-weight: bold;
    }

    input {
        padding: 0.5rem;
        font-size: 1rem;
    }

    button[type="submit"] {
        margin-top: 1.5rem;
        padding: 0.75rem;
        background: #4a90e2;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 1rem;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background: #357abd;
    }
</style>

<script>
    function closeModal(event) {
        if (!event || event.target.classList.contains('modal-backdrop')) {
            document.querySelector('.modal-backdrop')?.remove();
        }
    }

    document.querySelector('#loginForm')?.addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        const response = await fetch('/login', {
            method: 'POST',
            body: formData
        });
    });
</script>
