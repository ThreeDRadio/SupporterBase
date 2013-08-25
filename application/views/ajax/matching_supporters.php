<supporters>
<?php foreach ($matches as $supporter): ?>
    <supporter>
        <supporter_id><?php echo $supporter['supporter_id'] ?></supporter_id>
        <first_name><?php echo $supporter['first_name'] ?></first_name>
        <last_name><?php echo $supporter['last_name'] ?></last_name>
    </supporter>

<?php endforeach; ?>
</supporters>
