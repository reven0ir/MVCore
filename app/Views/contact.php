<div class="container">

    <div class="row">

        <div class="col-md-6 offset-md-3">

            <h1>Contact form page</h1>

            <form action="" method="post">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control <?= get_validation_class('name', $errors ?? []) ?>" placeholder="John Johnson" value="<?= old('name') ?>">
                    <?= get_errors('name', $errors ?? []) ?>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control <?= get_validation_class('username', $errors ?? []) ?>" placeholder="john_johnson" value="<?= old('username') ?>">
                    <?= get_errors('username', $errors ?? []) ?>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" id="email" class="form-control <?= get_validation_class('email', $errors ?? []) ?>" placeholder="name@example.com" value="<?= old('email') ?>">
                    <?= get_errors('email', $errors ?? []) ?>
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
