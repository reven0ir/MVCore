<div class="container">
    <h1>Home page</h1>

    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <h3><?= $post['title']; ?></h3>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
