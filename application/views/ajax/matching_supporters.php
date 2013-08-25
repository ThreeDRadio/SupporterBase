<supporters>
<?php foreach ($matches as $supporter): ?>
    <supporter>
        <supporter_id><?php echo $supporter['supporter_id'] ?></supporter_id>
        <first_name><?php echo $supporter['first_name'] ?></first_name>
        <last_name><?php echo $supporter['last_name'] ?></last_name>
        <address1><?php echo $supporter['address1'] ?></address1>
        <address2><?php echo $supporter['address2'] ?></address2>
        <town><?php echo $supporter['town'] ?></town>
        <postcode><?php echo $supporter['postcode'] ?></postcode>
        <state><?php echo $supporter['state'] ?></state>
        <phone><?php echo $supporter['phone'] ?></phone>
        <email><?php echo $supporter['email'] ?></email>
    </supporter>

<?php endforeach; ?>
</supporters>
