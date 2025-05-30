<div class="container">

    <div class="row">

        <div class="col-md-6 offset-md-3">

            <h1>Sign Up</h1>

            <form method="post" action="<?= base_url('/register') ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control <?= get_validation_class('name', $errors ?? []) ?>" placeholder="Name" value="<?= old('name') ?>">
                    <?= get_errors('name', $errors ?? []) ?>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control <?= get_validation_class('email', $errors ?? []) ?>" placeholder="Email" value="<?= old('email') ?>">
                    <?= get_errors('email', $errors ?? []) ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control <?= get_validation_class('password', $errors ?? []) ?>" placeholder="Password">
                    <?= get_errors('password', $errors ?? []) ?>
                </div>

                <div class="mb-3">
                    <label for="repassword" class="form-label">Confirm Password</label>
                    <input type="password" name="repassword" id="repassword" class="form-control <?= get_validation_class('repassword', $errors ?? []) ?>" placeholder="Confirm Password">
                    <?= get_errors('repassword', $errors ?? []) ?>
                </div>

                <button type="submit" class="btn btn-primary">Sign Up</button>

            </form>

        </div>

    </div>
</div>
