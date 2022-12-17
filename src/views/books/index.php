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
            <form class="row" method="GET">
                <div class="col">
                    <input id="query" value="<?= isset($_GET['query']) ? $_GET['query'] : '' ?>" placeholder="Search" name="query" class="form-control" type="text">
                </div>
                <div class="col">
                    <button id="submit" type="submit" class="btn btn-secondary">
                        Submit
                    </button>
                </div>
            </form>

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
                <tbody id="table-body">
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
                                        <button class="btn btn-success <?= $book->book_taken ? 'disabled' : '' ?> " type="submit">
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
        <nav aria-label="Page navigation example" class="d-flex justify-content-center">
            <ul id="paginator" class="pagination">
                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                <li class="page-item"><a class="page-link" href="?query=<?= $_GET['query'] ?>&page=1">...</a></li>
                <?php foreach ($this->paginator as $key => $page) { ?>
                    <li class="page-item">
                        <a class="page-link <?= $page ? 'active' : '' ?>" href="?query=<?= $_GET['query'] ?>&page=<?= $key ?>">
                            <?= $key ?>
                        </a>
                    </li>
                <?php } ?>
                <li class="page-item"><a class="page-link" href="?query=<?= $_GET['query'] ?>&page=<?= $this->pages ?>">...</a></li>
                <li class="page-item"><a class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#query').keyup(async (e) => {
            e.preventDefault();
            const query = $('#query').val()
            let post = $.post('/books/search', {
                query: query
            });

            let data = await post.done(function(data) {
                
                return (data);

            });

            let tableBody = $('#table-body');
            
            data = JSON.parse(data)[0];
            let html = '<tbody id="table-body">';
            data.books.map((value, index) => {
                html = html + `<tr><td>${value.id}</td><td>${value.author}</td><td>${value.title}</td><td>${value.year_released}</td><td>${value.quantity}</td><td>actions</td></tr>`
            });
            html = html + '</tbody>';
            
            tableBody.replaceWith(html);

            const paginator = $('#paginator');
            let paginatorHtml = '<ul id="paginator" class="pagination">';

            data.paginator.map((value, index) => {
                
                paginatorHtml += `<li class="page-item">
                        <a class="page-link ${value.is_active ? 'active' : ''}" href="?query=${query}&page=${value.page}">
                            ${value.page}
                        </a>
                    </li>`;
            });

            paginatorHtml += '</ul>';
            paginator.replaceWith(paginatorHtml);
        });
    })
</script>