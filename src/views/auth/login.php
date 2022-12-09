<div class="col-6 mx-auto">
    <form action="/login" method="post">
        <?php if ($_SESSION['login_error']) { ?>
            <div style="display: block" class="invalid-feedback">
                Failed to login
            </div>
        <?php } ?>
        <div>
            <label for="email">
                Email
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
            <input type="password" name="password" id="password" class="form-control <?php isset($_SESSION['login_form_errors']['password']['errors']) ? 'is-invalid' : '' ?>" type="text">
            <?php if (isset($_SESSION['login_form_errors']['password']['errors'])) { ?>
                <div style="display: block" class="invalid-feedback active">
                    <?php foreach ($_SESSION['login_form_errors']['password']['errors'] as $error)  echo $error . '<br>' ?>
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