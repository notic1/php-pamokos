<div class="col-6 mx-auto">
    <form action="/books/create" method="post">
        <div>
            <label for="author">
                Author
            </label>
            <input name="author" id="author" class="form-control <?php isset($_SESSION['login_form_errors']['author']['errors']) ? 'is-invalid' : '' ?>" type="text">
            <?php if (isset($_SESSION['login_form_errors']['author']['errors'])) { ?>
                <div style="display: block" class="invalid-feedback active">
                    <?php foreach ($_SESSION['login_form_errors']['author']['errors'] as $error)  echo $error . '<br>' ?>
                </div>
            <?php } ?>
        </div>

        <div>
            <label for="Title">
                Title
            </label>
            <input name="title" id="title" class="form-control <?php isset($_SESSION['login_form_errors']['title']['errors']) ? 'is-invalid' : '' ?>" type="text">
            <?php if (isset($_SESSION['login_form_errors']['title']['errors'])) { ?>
                <div style="display: block" class="invalid-feedback active">
                    <?php foreach ($_SESSION['login_form_errors']['title']['errors'] as $error)  echo $error . '<br>' ?>
                </div>
            <?php } ?>
        </div>

        <div>
            <label for="year_released">
                Year released
            </label>
            <input name="year_released" id="year_released" type="date" class="form-control <?php isset($_SESSION['login_form_errors']['year_released']['errors']) ? 'is-invalid' : '' ?>" type="text">
            <?php if (isset($_SESSION['login_form_errors']['year_released']['errors'])) { ?>
                <div style="display: block" class="invalid-feedback active">
                    <?php foreach ($_SESSION['login_form_errors']['year_released']['errors'] as $error)  echo $error . '<br>' ?>
                </div>
            <?php } ?>
        </div>

        <div>
            <label for="quantity">
                Quantity
            </label>
            <input name="quantity" id="quantity" class="form-control <?php isset($_SESSION['login_form_errors']['quantity']['errors']) ? 'is-invalid' : '' ?>" type="text">
            <?php if (isset($_SESSION['login_form_errors']['quantity']['errors'])) { ?>
                <div style="display: block" class="invalid-feedback active">
                    <?php foreach ($_SESSION['login_form_errors']['quantity']['errors'] as $error)  echo $error . '<br>' ?>
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