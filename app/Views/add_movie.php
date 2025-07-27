<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <?php if (session()->getFlashdata('errors')): ?>
        <div style="background-color: #ffe6e6; color: #cc0000; padding: 1rem; border: 1px solid #cc0000; border-radius: 5px; margin-bottom: 1rem;">
            <strong>There were some problems with your submission:</strong>
            <ul style="margin-top: 0.5rem;">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url("user/$user_id/addMovie") ?>" style="max-width: 500px; margin: 0 auto;">
        <div style="margin-bottom: 1rem;">
            <label for="title" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Title</label>
            <input type="text" name="title" id="title" value="<?= old('title') ?>" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label for="description" style="display: block; font-weight: bold; margin-bottom: 0.5rem;">Description</label>
            <textarea name="description" id="description" style="width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; height: 120px;"><?= old('description') ?></textarea>
        </div>

        <button type="submit" style="padding: 0.75rem 1.5rem; background-color: #4a90e2; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem;">
            Add Movie
        </button>
    </form>
<?= $this->endSection() ?>