<div class="col-6 mx-auto">
    <form action="/forgot-password" method="post">
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
            <button type="submit" class="btn btn-primary">
                Submit
            </button>
        </div>
    </form>
</div>