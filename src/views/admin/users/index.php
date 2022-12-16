<div class="col-10 mx-auto">

    <div class="card">
        <div class="card-header d-flex justify-content-between align--items-center">
            <span>
                users
            </span>
            <a class="btn btn-primary" href="/admin/users/create">
                +
            </a>
        </div>
        <div class="card-body">
            <table class="w-100 table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Is active</th>
                        <th>Is Admin</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->users as $user) { ?>
                        <tr>
                            <td><?= $user->id ?></td>
                            <td><?= $user->name ?></td>
                            <td><?= $user->email ?></td>
                            <td><?= (bool)$user->is_active ? '<span class="text-success"> true </span>' : '<span class="text-danger"> false </span>'?></td>
                            <td><?= (bool)$user->is_admin ? '<span class="text-success"> true </span>' : '<span class="text-danger"> false </span>' ?></td>
                            <td>
                                <a class="btn btn-warning" href="/admin/users/edit?id=<?= $user->id ?>">
                                    Edit
                                </a>
                                <form action="/admin/users/delete" method="POST">
                                    <input type="hidden" name="id" value="<?= $user->id ?>">
                                    <button class="btn btn-danger" type="submit">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>