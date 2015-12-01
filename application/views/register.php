<div class="container">
    <div class="row">
        <div class="col-md-7">
            <div class="page-header"><h1>Register new account</h1></div>
            <?php if ($errors): ?>
                <div class="alert alert-danger">
                    <ul>
                        <li> <?= implode($errors, '</li><li>') ?></li>
                    </ul>
                </div>
            <?php endif; ?>
            <form action="<?= base_url('register') ?>" method="POST" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-3">First name</label>
                    <div class="col-sm-7">
                        <input type="text" name="firstname" value="<?php echo set_value('firstname'); ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Last name</label>
                    <div class="col-sm-7">
                        <input type="text" name="lastname" value="<?php echo set_value('lastname'); ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Email</label>
                    <div class="col-sm-7">
                        <input type="email" name="email" value="<?php echo set_value('email'); ?>" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Mobile Number</label>
                    <div class="col-sm-7">
                        <input type="number" name="contact_number" value="<?php echo set_value('contact_number'); ?>" class="form-control" />
                    </div>
                </div>
                <hr/>
                <div class="form-group">
                    <label class="control-label col-sm-3">Password</label>
                    <div class="col-sm-7">
                        <input type="password" name="password" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3">Confirm Password</label>
                    <div class="col-sm-7">
                        <input type="password" name="confirm_password" class="form-control" />
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-sm-10 text-right">
                        <a class="btn btn-default">Go back</a>
                        <button type="submit" class="btn btn-primary">Sign up!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
