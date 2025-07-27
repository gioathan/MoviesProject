<?= $this->extend('layout') ?>

<?= $this->section('content') ?>
    <div style="flex: 3;">
        <h2><?= $user_id ? "User's Movies (" . $user_name . ")" : "All Movies" ?></h2>

        <ul class="movie-list">
            <?php foreach ($movies as $movie): ?>
                <li class="movie-card">
                    <div class="movie-header">
                        <h3><?= esc($movie['title']) ?></h3>
                        <span class="movie-date"><?= date('F j, Y', strtotime($movie['published_at'])) ?></span>
                    </div>

                    <p class="movie-desc"><?= esc($movie['description']) ?></p>

                    <div class="movie-footer">
                        <div class="left-meta">
                            👍 <?= $movie['likes'] ?> &nbsp; | &nbsp; 👎 <?= $movie['hates'] ?>

                            <?php if (session()->has('user_id') && session('user_id') != $movie['user_id']): ?>
                            &nbsp; | &nbsp;
                            <a href="javascript:void(0)" 
                            class="like-link <?= $movie['user_reaction'] === 'like' ? 'reacted' : '' ?>" 
                            data-movie-id="<?= $movie['id'] ?>">Like</a>
                            &nbsp;|&nbsp;
                            <a href="javascript:void(0)" 
                            class="hate-link <?= $movie['user_reaction'] === 'hate' ? 'reacted' : '' ?>" 
                            data-movie-id="<?= $movie['id'] ?>">Hate</a>
                        <?php endif; ?>
                        </div>
                        <div class="right-meta">
                            Created by: 
                            <a href="<?= base_url("user/" . $movie['user_id']) ?>">
                                <?= esc($movie['firstname'] . ' ' . $movie['lastname']) ?>
                            </a>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>


    <style>
        .movie-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .movie-card {
            border: 2px solid #ccc;
            border-radius: 8px;
            padding: 1rem;
            background-color: #fff;
            position: relative;
        }

        .movie-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .movie-header h3 {
            margin: 0;
            font-size: 1.2rem;
            color: #333;
        }

        .movie-date {
            font-size: 0.9rem;
            color: #666;
        }

        .movie-desc {
            margin: 0.5rem 0 1rem;
            color: #444;
            font-size: 1rem;
        }

        .movie-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            color: #555;
            border-top: 1px solid #eee;
            padding-top: 0.5rem;
        }

        .movie-footer a {
            color: #4a90e2;
            text-decoration: none;
            font-weight: bold;
        }

        .movie-footer a:hover {
            text-decoration: underline;
        }

        .reacted {
            background-color: #d6ebff;
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
        }
</style>

<script>
    document.querySelectorAll('.like-link, .hate-link').forEach(link => {
    link.addEventListener('click', async function () {
        const movieId = this.dataset.movieId;
        const reaction = this.classList.contains('like-link') ? 'like' : 'hate';

        try {
            const res = await fetch('/movie/react', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ movie_id: movieId, reaction })
            });
            const data = await res.json();

            if (data.status === 'success') {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        } catch (error) {
            alert('Network error.');
        }
    });
});
</script>


<?= $this->endSection() ?>

