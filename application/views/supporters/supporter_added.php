<h2>Supporter Added!</h2>

<h3>Supporter Details</h3>
<table>
<tr><td><b>Supporter ID:</b></td><td><?php echo $supporter_id ;?></td></tr>
<tr><td><b>Name:</b></td><td><?php echo $first_name . " " . $last_name;?></td></tr>
<tr><td><b>Address:</b></td><td>
<?php echo $address1. "<br>";?>
<?php if(!empty($address2)) {
    echo $address2. "<br>";
}
?>
<?php echo "$town $state $postcode<br>";?>
</td></tr>
<tr><td><b>Email:</b></td><td><?php echo $email;?></td></tr>
<tr><td><b>Phone:</b></td><td><?php echo $phone_mobile;?></td></tr>
</table>
<a href="<?php echo site_url('supporters/renew/' . $supporter_id); ?>">Renew This Supporter</a><br />
<a href="<?php echo site_url('supporters/add'); ?>">Add Another</a><br />
