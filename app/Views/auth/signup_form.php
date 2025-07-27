<div class="modal-backdrop" onclick="closeModal(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <button class="close-btn" onclick="closeModal()">×</button>
        <h2>Sign Up</h2>

        <div id="signup-message" style="margin-bottom: 1rem; font-weight: bold;"></div>

        <form id="signupForm">
            <label for="firstname">First Name</label>
            <input type="text" name="firstname" required>

            <label for="lastname">Last Name</label>
            <input type="text" name="lastname" required>

            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" required>

            <label for="password_confirm">Confirm Password</label>
            <input type="password" name="password_confirm" required>

            <button type="submit">Sign Up</button>
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

    document.querySelector('#signupForm')?.addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);

        const response = await fetch('/signup', {
            method: 'POST',
            body: formData
        });
    });
</script>
