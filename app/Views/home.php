<div class="container">
    <h1>Home page</h1>

    <?php //echo session()->get('name', 'Unknown'); ?>

    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <h3><a href="#"><?= $post['title']; ?></a> | <a href="<?= base_url('/posts/edit?id=' . $post['id']) ?>">EDIT</a> | <a href="<?= base_url('/posts/delete?id=' . $post['id']) ?>">DELETE</a></h3>
        <?php endforeach; ?>
    <?php endif; ?>

</div>
