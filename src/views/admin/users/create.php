<div class="col-6 mx-auto">
    <form action="/admin/users/create" method="post">
        <div>
            <label for="name">
                name
            </label>
            <input name="name" id="name" class="form-control <?php isset($_SESSION['login_form_errors']['name']['errors']) ? 'is-invalid' : '' ?>" type="text">
            <?php if (isset($_SESSION['login_form_errors']['name']['errors'])) { ?>
                <div style="display: block" class="invalid-feedback active">
                    <?php foreach ($_SESSION['login_form_errors']['name']['errors'] as $error)  echo $error . '<br>' ?>
                </div>
            <?php } ?>
        </div>

        <div>
            <label for="email">
                email
            </label>
            <input name="email" id="email" class="form-control <?php isset($_SESSION['login_form_errors']['email']['errors']) ? 'is-invalid' : '' ?>" type="text">
            <?php if (isset($_SESSION['login_form_errors']['email']['errors'])) { ?>
                <div style="display: block" class="invalid-feedback active">
                    <?php foreach ($_SESSION['login_form_errors']['email']['errors'] as $error)  echo $error . '<br>' ?>
                </div>
            <?php } ?>
        </div>

        <div>
            <label for="password">
                Password
            </label>
            <input name="password" id="password" class="form-control <?php isset($_SESSION['login_form_errors']['password']['errors']) ? 'is-invalid' : '' ?>" type="password">
            <?php if (isset($_SESSION['login_form_errors']['password']['errors'])) { ?>
                <div style="display: block" class="invalid-feedback active">
                    <?php foreach ($_SESSION['login_form_errors']['password']['errors'] as $error)  echo $error . '<br>' ?>
                </div>
            <?php } ?>
        </div>

        <div>
            <label for="password">
                Password confirmation
            </label>
            <input name="password-confirmation" id="password-confirmation" class="form-control <?php isset($_SESSION['login_form_errors']['password']['errors']) ? 'is-invalid' : '' ?>" type="password">
            <?php if (isset($_SESSION['login_form_errors']['password']['errors'])) { ?>
                <div style="display: block" class="invalid-feedback active">
                    <?php foreach ($_SESSION['login_form_errors']['password']['errors'] as $error)  echo $error . '<br>' ?>
                </div>
            <?php } ?>
        </div>

        <div>
            <label for="is_active">
                Is active
            </label>
            <input name="is_active" id="is_active" value="1" class="form-check-input <?php isset($_SESSION['login_form_errors']['is_active']['errors']) ? 'is-invalid' : '' ?>" type="checkbox">
            <?php if (isset($_SESSION['login_form_errors']['is_active']['errors'])) { ?>
                <div style="display: block" class="invalid-feedback active">
                    <?php foreach ($_SESSION['login_form_errors']['is_active']['errors'] as $error)  echo $error . '<br>' ?>
                </div>
            <?php } ?>
        </div>

        <div>
            <label for="is_admin">
                Is admin
            </label>
            <input name="is_admin" id="is_admin" value="1" class="form-check-input <?php isset($_SESSION['login_form_errors']['is_admin']['errors']) ? 'is-invalid' : '' ?>" type="checkbox">
            <?php if (isset($_SESSION['login_form_errors']['is_admin']['errors'])) { ?>
                <div style="display: block" class="invalid-feedback active">
                    <?php foreach ($_SESSION['login_form_errors']['is_admin']['errors'] as $error)  echo $error . '<br>' ?>
                </div>
            <?php } ?>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </div>
    </form>
</div>