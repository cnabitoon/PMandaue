<div class="row">
    <div class="col-sm-4 col-sm-offset-4">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="glyphicon glyphicon-lock pull-right"></i>Login</div>
            <form action="<?= base_url('login') ?>" method="POST">
                <div class="panel-body">
                    <?php if ($errors): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <li> <?= implode($errors, '</li><li>') ?></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" name="email" value="<?php echo set_value('email'); ?>" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="redirect" value="<?= $redirect ?>" class="form-control"/>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="btn-toolbar clearfix">
                        <button type="submit" class="btn btn-success pull-right">Sign in</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>