<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="page-header"><h1><?= $complaint['title'] ?></h1></div>
            <?php if ($infos): ?>
                <div class="alert alert-info">
                    <ul>
                        <li> <?= implode($infos, '</li><li>') ?></li>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if ($errors): ?>
                <div class="alert alert-danger">
                    <ul>
                        <li> <?= implode($errors, '</li><li>') ?></li>
                    </ul>
                </div>
            <?php endif; ?>
            <table class="table table-striped">
                <tr>
                    <td>Category</td>
                    <td>
                        <?php if ($complaint['category'] === 'p'): ?>
                            Public Disturbance
                        <?php elseif ($complaint['category'] === 'e'): ?>
                            Environmental
                        <?php else: ?>
                            Traffic
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><?= $complaint['description'] ?></td>
                </tr>
                <tr>
                    <td>Location</td>
                    <td><?= $complaint['location'] ?></td>
                </tr>
                <tr>
                    <td>Barangay</td>
                    <td><?= $complaint['barangay'] ?></td>
                </tr>
                <tr>
                    <td>Poster</td>
                    <td><a href="#"><?= $complaint['poster_name'] ?></a></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><?= $complaint['status'] ?></td>
                </tr>
                <tr>
                    <td>Action</td>
                    <td>
                        <?php if($complaint['status'] === 'Pending'): ?>
                            <a href="<?= base_url("super-admin/complaint/edit?id={$complaint['id']}")?>" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i>Edit</a>
                            <a href="<?= base_url("super-admin/complaint/accept?id={$complaint['id']}")?>" class="btn btn-xs btn-info"><i class="fa fa-check"></i>Accept</a>
                            <a href="<?= base_url("super-admin/complaint/delete?id={$complaint['id']}")?>" class="btn btn-xs btn-danger"><i class="fa fa-times"></i>Decline</a>
                        <?php elseif($complaint['status'] === 'Ongoing'): ?>
                            <a href="<?= base_url("super-admin/complaint/edit?id={$complaint['id']}")?>" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i>Edit</a>
                            <a href="<?= base_url("super-admin/complaint/solved?id={$complaint['id']}")?>" class="btn btn-xs btn-info"><i class="fa fa-check"></i>Mark as Solved</a>
                            <a href="<?= base_url("super-admin/complaint/delete?id={$complaint['id']}")?>" class="btn btn-xs btn-danger"></i>Delete</a>
                        <?php elseif($complaint['status'] === 'Solved'): ?>
                            <a href="<?= base_url("super-admin/complaint/edit?id={$complaint['id']}")?>" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i>Edit</a>
                            <a href="<?= base_url("super-admin/complaint/delete?id={$complaint['id']}")?>" class="btn btn-xs btn-danger"></i>Delete</a>
                        <?php else: ?>
                            <span class="label label-warning">Archived</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <img src="<?= $complaint['image_filename']?>" height="200" width="500"/>
        </div>
    </div>
</div>