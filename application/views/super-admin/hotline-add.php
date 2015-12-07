<div class="row">
    <div class="col-sm-4 col-sm-offset-4">
        <div class="panel panel-primary">
            <div class="panel-heading"><i class="glyphicon glyphicon-log-in pull-right"></i>Add Hotline</div>
            <form action="#" method="POST">
                <div class="panel-body">
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
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required=""/>
                    </div>
                    <div class="form-group">
                        <label>Number</label>
                        <input type="text" name="number" class="form-control" required=""/>
                    </div>
                    <div class="btn-toolbar clearfix">
                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>