
    <p><a href="<?php echo site_url('users/add') ?>">Add User</a></p>

    <p><a href="<?php echo site_url('supporters/add') ?>">Add Supporter</a></p>

    <p><a href="<?php echo site_url('supporters/find') ?>">Find Supporter</a></p>

<h2>Stats</h2>

<p><b>Current Members:</b> <?php echo $activeMembers; ?> <a href="<?php echo site_url('export/current_members') ?>">Export</a><br />
<p><b>Unrenewed Members:</b> <?php echo $expiredMembers; ?></p>

<p><b>Current Subscribers:</b> <?php echo $activeSubs; ?><br />
<p><b>Unrenewed Subscribers:</b> <?php echo $expiredSubs; ?></p>
