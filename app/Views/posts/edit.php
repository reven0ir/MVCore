<div class="container">

    <div class="row">

        <div class="col-md-6 offset-md-3">

            <h1>Create post</h1>

            <form action="<?= base_url('/posts/update') ?>" method="post">

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="<?= h($post['title']) ?>">
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="<?= h($post['slug']) ?>">
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" id="content" class="form-control" rows="3"><?= h($post['content']) ?></textarea>
                </div>

                <input type="hidden" name="id" value="<?= $post['id']; ?>">

                <button type="submit" class="btn btn-primary">Save</button>

            </form>

        </div>

    </div>
</div>
