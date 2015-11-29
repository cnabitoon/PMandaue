<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="page-header"><h1>Edit Complaint</h1></div>
            <?php if ($errors): ?>
                <div class="alert alert-danger">
                    <ul>
                        <li> <?= implode($errors, '</li><li>') ?></li>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="<?= base_url("super-admin/complaint/edit?id={$complaint['id']}") ?>" method="POST" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-3">Category</label>
                    <div class="col-sm-7">
                        <?= form_dropdown('category', ['e' => 'Environmental', 't' => 'Traffic', 'p' => 'Public Disturbance'], $complaint['category'], 'class="form-control"') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Title</label>
                    <div class="col-sm-7">
                        <input type="text" name="title" value="<?= $complaint['title']?>" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Description</label>
                    <div class="col-sm-7">
                        <textarea name="description" class="form-control" rows="4" style="resize: none"><?= $complaint['description']?></textarea>
                    </div>
                </div>
                <img src="<?= $complaint['image_filename']?>" height="100" width="200"/>
                <div class="form-group">
                    <label class="control-label col-sm-3">Change Picture</label>
                    <div class="col-sm-7">
                        <input type="file" name="image" />
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-10 text-right">
                        <a class="btn btn-default">Go back</a>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>