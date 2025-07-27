<div class="sort-box">
    <?php if (session()->has('user_id')): ?>
        <a href="<?= base_url('user/' . session()->get('user_id') . '/addMovie') ?>" 
           style="
               display: inline-block;
               margin-bottom: 1rem;
               padding: 0.5rem 1rem;
               background-color: #4a90e2;
               color: white;
               border-radius: 5px;
               text-decoration: none;
               font-weight: bold;
               text-align: center;
           ">
            + Add Movie
        </a>
    <?php endif; ?>

    <h4>Sort by</h4>
    <form method="get" id="sortForm">
        <label><input type="radio" name="sort_by" value="likes" <?= $sort_by === 'likes' ? 'checked' : '' ?>> Likes</label><br>
        <label><input type="radio" name="sort_by" value="hates" <?= $sort_by === 'hates' ? 'checked' : '' ?>> Hates</label><br>
        <label><input type="radio" name="sort_by" value="recent" <?= $sort_by === 'recent' ? 'checked' : '' ?>> Date</label>
    </form>
</div>

<style>
    .sort-box {
    background: white;
    border: 1px solid #ccc;
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    margin-bottom: 1rem;
}

.sort-box h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1.1rem;
    border-bottom: 1px solid #eee;
    padding-bottom: 0.3rem;
}

.sort-box label {
    display: block;
    margin: 0.3rem 0;
    font-weight: normal;
    cursor: pointer;
}

</style>

<script>
    document.querySelectorAll('#sortForm input[type="radio"]').forEach(el => {
        el.addEventListener('change', () => {
            document.getElementById('sortForm').submit();
        });
    });
</script>