<div class="row">
    <div class="col-sm-6">
        <image src="<?= base_url('assets/image/map.png') ?>" style="border: 3px solid #999999;"/>
    </div>	
    <div class="col-sm-5" style="margin:10px;">
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
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading">Emergency Numbers</div>

                    <!-- List group -->
                    <ul class="list-group">
                        <li class="list-group-item">ERUF 166</li>
                        <li class="list-group-item">Fire Department 160</li>
                        <li class="list-group-item">SWAT 166</li>
                        <li class="list-group-item">REACT 515-4455</li>
                        <li class="list-group-item">VECO (Power Sevices) 230-8326</li>
                        <li class="list-group-item">MCWD (Water Sevices) 412-1836</li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading">Announcements</div>
                    <div class="panel-body">
                        <p>October 3, 2015</p>
                        <p>There is a Maintenance on October 23, 2015.</p>
                    </div>
                    <div class="panel-body">
                        <p>September 27, 2015</p>
                        <p>System was Updated.</p>
                    </div>
                    <div class="panel-body">
                        <p>September 20, 2015</p>
                        <p>Some of design on website were changed.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>