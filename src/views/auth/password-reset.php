<div class="col-6 mx-auto">
    <form action="/forgot-password/form" method="post">
        <input name="token" type="hidden" value="<?= $_GET['token'] ?>">
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
            <label for="password-confirmation">
                Password Confirmation
            </label>
            <input type="password" name="password-confirmation" id="password-confirmation" class="form-control <?php isset($_SESSION['login_form_errors']['name']['errors']) ? 'is-invalid' : '' ?>" type="text">
        </div>
        <div>
            <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </div>
    </form>
</div>