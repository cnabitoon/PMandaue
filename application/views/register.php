<div class="row">
    <div class="col-sm-4 col-sm-offset-4">
        <div class="panel panel-primary">
            <div class="panel-heading"><i class="glyphicon glyphicon-log-in pull-right"></i>Create an account</div>
            <form action="<?= base_url('register') ?>" method="POST">
                <div class="panel-body">
                    <?php if ($errors): ?>
                        <div class="alert alert-danger">
                            <ul>
                                <li> <?= implode($errors, '</li><li>') ?></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" value="<?php echo set_value('username'); ?>" class="form-control" required="" />
                    </div>
                    <div class="form-group">
                        <label>First name</label>
                        <input type="text" name="firstname" value="<?php echo set_value('firstname'); ?>" class="form-control" required="" />
                    </div>
                    <div class="form-group">
                        <label>Last name</label>
                        <input type="text" name="lastname" value="<?php echo set_value('lastname'); ?>" class="form-control" required="" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?php echo set_value('email'); ?>" class="form-control" required="" />
                    </div>
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input type="number" name="contact_number" value="<?php echo set_value('contact_number'); ?>" class="form-control" required="" />
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required="" />
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control" required="" />
                    </div>
                    <hr>
                        <div class="btn-toolbar clearfix">
                            <button type="submit" class="btn btn-primary pull-right">Sign up!</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

