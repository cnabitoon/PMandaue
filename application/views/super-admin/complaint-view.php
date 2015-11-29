<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="page-header"><h1><?= $complaint['title'] ?></h1></div>

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
                            <a class="btn btn-xs btn-info"><i class="fa fa-check"></i>Accept</a>
                            <a class="btn btn-xs btn-danger"><i class="fa fa-times"></i>Decline/Delete</a>
                        <?php elseif($complaint['status'] === 'Ongoing'): ?>
                            <a class="btn btn-xs btn-info"><i class="fa fa-pencil"></i>Edit</a>
                            <a class="btn btn-xs btn-info"><i class="fa fa-check"></i>Mark as Solved</a>
                            <a class="btn btn-xs btn-danger"><i class="fa fa-times"></i>Delete</a>
                        <?php elseif($complaint['status'] === 'Solved'): ?>
                            <a class="btn btn-xs btn-info"><i class="fa fa-pencil"></i>Edit</a>
                            <a class="btn btn-xs btn-danger"><i class="fa fa-times"></i>Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <img src="<?= $complaint['image_filename']?>" height="200" width="500"/>
        </div>
    </div>
</div>