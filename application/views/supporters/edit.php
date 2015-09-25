<h2>Edit Supporter</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('supporters/edit'.'/'. $supporter_info['supporter_id']) ?>

    <label for="first">First Name:</label>
    <input type="input" name="first" value="<?php echo $supporter_info['first_name'];?>" /><br />

    <label for="last">Last Name:</label>
    <input type="input" name="last"  value="<?php echo $supporter_info['last_name'];?>" /><br />

    <label for="address1">Address Line 1:</label>
    <input type="input" name="address1"  value="<?php echo $supporter_info['address1'];?>" /><br />

    <label for="address2">Address Line 2:</label>
    <input type="input" name="address2"  value="<?php echo $supporter_info['address2'];?>" /><br />

    <label for="town">Town/Suburb</label>
    <input type="input" name="town"  value="<?php echo $supporter_info['town'];?>" /><br />

    <label for="state">State:</label>
    <input type="input" name="state"  value="<?php echo $supporter_info['state'];?>" /><br />

    <label for="postcode">Postcode:</label>
    <input type="input" name="postcode"  value="<?php echo $supporter_info['postcode'];?>" /><br />

    <label for="country">Country:</label>
    <input type="input" name="country" value="Australia" /><br />

    <label for="phone">Phone:</label>
    <input type="input" name="phone"  value="<?php echo $supporter_info['phone_mobile'];?>" /><br />

    <label for="email">Email:</label>
    <input type="input" name="email"  value="<?php echo $supporter_info['email'];?>" /><br />

    <label for="email">Prefer Email:</label>
    <input type="checkbox" name="prefer_email" /><br />

<hr>
<h3>Danger Zone:</h3>

    <label for="excluded">Exclude: </label>
    <input type="checkbox" name="excluded" value="1" <?php echo (($supporter_info['excluded'] == 1) ? " checked" : ""); ?> /><br />

<hr>

    <input type="submit" name="submit" value="Update Supporter" />

</form>

<h2>Subscription History</h2>
<table>
<tr><th>Expiration Date</th><th width="100">Type</th><th width="100">Payment</th><th width="100">Sub Pack</th><th>Note</th></tr>
<?php
foreach ($subscriptions as $sub) {
    echo '<tr><td width="120">';
    echo strftime("%d/%m/%y", $sub['expiration_date']);
    echo '</td><td>' . $sub['type'] . '</td>'; 
    echo '</td><td>' . (($sub['payment_processed'] == 1) ? 'PAID' : 'NOT PAID') . '</td>'; 
    echo '</td><td>' . (($sub['pack_sent'] == 1) ? 'SENT' : 'NOT SENT') . '</td>'; 
    echo '</td><td>' . $sub['note'] . '</td>'; 
    
    echo '</tr>';
}
?>
</table>

<h2>Notes</h2>
<table>
<tr><th>Meta</th><th>Note</th></tr>
<?php
foreach ($notes as $note) {
    echo '<tr><td width="120">';
    echo strftime("%d/%m/%y", $note['time']);
    echo '</td><td>' . $note['note'] . '</td></tr>';
}
?>
</table>

<?php echo form_open('supporters/add_note'.'/'. $supporter_info['supporter_id']) ?>
    <label for="note"><h3>New Note:</h3></label><br>
    <textarea name="note" rows="3" cols="100"></textarea><br />
    <input type="submit" name="submit" value="New Note" />

</form>


