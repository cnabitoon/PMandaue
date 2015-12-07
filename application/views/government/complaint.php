<div class="container">
    <div class="row">
        <div class="col-md-3">
            <ul class="nav nav-pills nav-stacked">
                <h3><span class="label label-warning">Complaints</span></h3>
                <li class="<?php if($type === 'Pending') : echo 'active'; endif; ?>" role="presentation"><a href="<?= base_url("government/complaint?type=pending")?>">Pending</a></li>
                <li class="<?php if($type === 'Ongoing') : echo 'active'; endif; ?>" role="presentation"><a href="<?= base_url("government/complaint?type=ongoing")?>">Ongoing</a></li>
                <li class="<?php if($type === 'Solved') : echo 'active'; endif; ?>" role="presentation"><a href="<?= base_url("government/complaint?type=solved")?>">Solved</a></li>
            </ul>
            <ul class="nav nav-pills nav-stacked">
                <h3><span class="label label-warning">Archives</span></h3>
                <li class="<?php if($type === 'Deleted - Declined') : echo 'active'; endif; ?>" role="presentation"><a href="<?= base_url("government/complaint?type=deleted-declined")?>">Deleted - Declined</a></li>
                <li class="<?php if($type === 'Deleted - Spam') : echo 'active'; endif; ?>" role="presentation"><a href="<?= base_url("government/complaint?type=deleted-spam")?>">Deleted - Spam</a></li>
                <li class="<?php if($type === 'Deleted - Ongoing') : echo 'active'; endif; ?>" role="presentation"><a href="<?= base_url("government/complaint?type=deleted-ongoing")?>">Deleted - Ongoing</a></li>
                <li class="<?php if($type === 'Deleted - Solved') : echo 'active'; endif; ?>" role="presentation"><a href="<?= base_url("government/complaint?type=deleted-solved")?>">Deleted - Solved</a></li>
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
            <div class="page-header"><h1><?= $type?> Complaints</h1></div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Posted on</th>
                        <th>Location</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($complaints as $c): ?>
                        <tr>
                            <td><?= $c['title'] ?></td>
                            <td><img src="<?= base_url("uploads/{$c['image_filename']}")?>" width="50" height="30"></td>
                            <td>
                                <?php if( $c['category'] === 'p'):?>
                                    Public Disturbance
                                <?php elseif($c['category'] === 'e'):?>
                                       Environmental
                                <?php else:?>
                                       Traffic
                                <?php endif;?>
                            </td>
                            <td><?= datetime_convert($c['datetime_posted']) ?></td>
                            <td><?= $c['location'] ?></td>
                            <td>
                                <a href="<?= base_url("government/complaint/view?id={$c['id']}")?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> View</a>
                                <!--<a class="btn btn-xs btn-danger"><i class   ="fa fa-times"></i> Delete</a>-->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>