<h2>Supporter Renewed!</h2>
<a href="<?php echo site_url('supporters/find'); ?>">Renew Another</a>

<h3>Supporter Details</h3>
<table>
<tr><td><b>Supporter ID:</b></td><td><?php echo $supporter_info['supporter_id'] ;?></td></tr>
<tr><td><b>Name:</b></td><td><?php echo $supporter_info['first_name'] . " " . $supporter_info['last_name'];?></td></tr>
<tr><td><b>Address:</b></td><td>
<?php echo $supporter_info['address1'] . "<br>";?>
<?php if(!empty($supporter_info['address2'])) {
    echo $supporter_info['address2'] . "<br>";
}
?>
<?php echo "$supporter_info[town] $supporter_info[state] $supporter_info[postcode]<br>";?>
</td></tr>
<tr><td><b>Email:</b></td><td><?php echo $supporter_info['email'] ;?></td></tr>
<tr><td><b>Phone:</b></td><td><?php echo $supporter_info['phone_mobile'] ;?></td></tr>
</table>
