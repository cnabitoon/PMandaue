<div class="container">
    <div class="row">
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <h3><span class="label label-warning">Miscellaneous</span></h3>
                <li class="<?php if ($type === 'Hotlines') : echo 'active'; endif;?>" role="presentation"><a href="<?= base_url("super-admin/miscellaneous?type=hotlines") ?>">Hotlines</a></li>
                <li class="<?php if ($type === 'Announcements') : echo 'active';endif;?>" role="presentation"><a href="<?= base_url("super-admin/miscellaneous?type=announcements") ?>">Announcements</a></li>
            </ul>
        </div>

        <div class="col-md-9">
        <?php if ($errors): ?>
                <div class="alert alert-danger">
                    <ul>
                        <li> <?= implode($errors, '</li><li>') ?></li>
                    </ul>
                </div>
        <?php endif; ?>
            <div class="page-header"><h1><?= $type ?></h1></div>
            <table class="table table-striped">
                <table class="table table-striped">
                    <?php if($type == 'Hotlines'):?>
                    <a href="<?= base_url("super-admin/miscellaneous/add_hotline") ?>" class="btn btn-xs btn-danger"></i>Add Hotine</a>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Number</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($miscellaneous as $m): ?>
                            <tr>
                                <td><?= $m['title'] ?></td>
                                <td><?= $m['number'] ?></td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i>Edit</a>
                                    <a href="<?= base_url("super-admin/miscellaneous/delete_hotline?id={$m['id']}") ?>" class="btn btn-xs btn-danger"></i>Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                    <?php elseif($type == 'Announcements'):?>
                    <a href="<?= base_url("super-admin/miscellaneous/add_announcement") ?>" class="btn btn-xs btn-danger"></i>Add Announcement</a>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($miscellaneous as $m): ?>
                            <tr>
                                <td><?= $m['title'] ?></td>
                                <td><?= $m['description'] ?></td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i>Edit</a>
                                    <a href="<?= base_url("super-admin/miscellaneous/delete_announcement?id={$m['id']}") ?>" class="btn btn-xs btn-danger"></i>Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                    <?php endif; ?>
                </table>
            </table>
        </div>
    </div>
</div>