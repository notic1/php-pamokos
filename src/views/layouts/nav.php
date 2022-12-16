<nav class="navbar navbar-expand-lg navbar-light bg-light mb-5">
  <a class="navbar-brand mx-3" href="#">Library management</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarNav">
    <ul class="navbar-nav float-right">
      <li class="nav-item active">
        <a class="nav-link" href="/">Home <span class="sr-only"></span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/books">Books <span class="sr-only"></span></a>
      </li>
    </ul>

    <ul class="navbar-nav float-right">
      <?php if (App\Models\User::authenticated()) { ?>
        <li class="nav-item">
          <a class="nav-link" href="/logout">Logout</a>
        </li>
      <?php } else { ?>
        <li class="nav-item active">
          <a class="nav-link" href="/login">Login <span class="sr-only"></span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/register">Register</a>
        </li>
      <?php } ?>
    </ul>
  </div>
</nav>