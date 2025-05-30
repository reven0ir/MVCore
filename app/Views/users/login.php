<div class="container">

    <div class="row">

        <div class="col-md-6 offset-md-3">

            <h1>Sign In</h1>

            <form method="post" action="<?= base_url('/login') ?>">

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control <?= get_validation_class('email', $errors ?? []) ?>" placeholder="Email">
                    <?= get_errors('email', $errors ?? []) ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control <?= get_validation_class('password', $errors ?? []) ?>" placeholder="Password">
                    <?= get_errors('password', $errors ?? []) ?>
                </div>

                <button type="submit" class="btn btn-primary">Sign In</button>

            </form>

        </div>

    </div>
</div>
