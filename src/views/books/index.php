<div class="col-10 mx-auto">

    <div class="card">
        <div class="card-header d-flex justify-content-between align--items-center">
            <span>
                Books
            </span>
            <a class="btn btn-primary" href="/books/create">
                +
            </a>
        </div>
        <div class="card-body">
            <table class="w-100 table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Author</th>
                        <th>Title</th>
                        <th>Year released</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->books as $book) { ?>
                        <tr>
                            <td><?= $book->id ?></td>
                            <td><?= $book->author ?></td>
                            <td><?= $book->title ?></td>
                            <td><?= $book->year_released ?></td>
                            <td><?= $book->quantity ?></td>
                            <td>
                                <?php if (App\Models\User::isAdmin()) { ?>
                                    <a class="btn btn-warning" href="/books/edit?id=<?= $book->id ?>">
                                        Edit
                                    </a>
                                    <form action="/books/delete" method="POST">
                                        <input type="hidden" name="id" value="<?= $book->id ?>">
                                        <button class="btn btn-danger" type="submit">
                                            Delete
                                        </button>
                                    </form>
                                <?php } else { ?>
                                    <form action="/books/reserve" method="POST">
                                        <input type="hidden" name="id" value="<?= $book->id ?>">
                                        <button class="btn btn-success" type="submit">
                                            Reserve book
                                        </button>
                                    </form>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>