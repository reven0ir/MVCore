<div class="container">

    <div class="row">

        <div class="col-md-6 offset-md-3">

            <h1>Create post</h1>

            <form action="<?= base_url('/posts/store') ?>" method="post">

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control <?= get_validation_class('title', $errors ?? []) ?>" placeholder="Title" value="<?= old('title') ?>">
                    <?= get_errors('title', $errors ?? []) ?>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control <?= get_validation_class('slug', $errors ?? []) ?>" placeholder="Slug" value="<?= old('slug') ?>">
                    <?= get_errors('slug', $errors ?? []) ?>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" id="content" class="form-control <?= get_validation_class('content', $errors ?? []) ?>" rows="3"><?= old('content') ?></textarea>
                    <?= get_errors('content', $errors ?? []) ?>
                </div>

                <button type="submit" class="btn btn-primary">Send</button>

            </form>

        </div>

    </div>
</div>
