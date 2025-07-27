<div class="modal-backdrop" onclick="closeModal(event)">
    <div class="modal-content" onclick="event.stopPropagation()">
        <button class="close-btn" onclick="closeModal()">×</button>
        <h2>Are you sure you want to logout?</h2>

        <form method="post" action="/logout" style="margin-top: 1rem;">
            <button type="submit" style="background: #e74c3c; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px;">Yes, Logout</button>
            <button type="button" onclick="closeModal()" style="margin-left: 1rem; background: #ccc; padding: 0.5rem 1rem; border: none; border-radius: 4px;">No</button>
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
        text-align: center;
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
</style>