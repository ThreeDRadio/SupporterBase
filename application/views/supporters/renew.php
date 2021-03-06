<h2>Renew Membership/Subscription</h2>
    <label for="first_name">First Name:</label>
    <input id="first_name" type="input" name="last_name" disabled value="<?php echo $supporter_info['first_name']; ?>" /><br />
    <label for="last_name">Last Name:</label>
    <input id="last_name" type="input" name="last_name" disabled value="<?php echo $supporter_info['last_name']; ?>" /><br />

<h3>Renewal Information</h3>

<?php echo validation_errors(); ?>

<?php echo form_open('supporters/renew'.'/'. $supporter_info['supporter_id']) ?>


    <label for="expiration_year">Expiration Date:</label>
    <input id="expiration_day" type="input" name="expiration_day" value="<?php echo $new_expiration_day; ?>" /> / 
    <input id="expiration_month" type="input" name="expiration_month" value="<?php echo $new_expiration_month; ?>" /> / 
    <input id="expiration_year" type="input" name="expiration_year" value="<?php echo $new_expiration_year; ?>" /><br />

    <label for="type">Supporter Type:</label>
<?php
$options = array(
    'sub'  => 'Subscription',
    'sub_concession'    => 'Concession Subscription',
    'member'   => 'Member',
    'member_concession' => 'Concession Member',
    'probationary' => 'Probationary/Trainee',
    'band' => 'Band',
    'honourary' => 'Honourary',
    'life' => 'Life'
);

if (empty($supporter_info['type'])) {
    echo form_dropdown('type', $options, 'sub');
}
else {
    echo form_dropdown('type', $options, $supporter_info['type']);
}

?>
<br /><br />
<input id="payment_processed" type="checkbox" name="payment_processed" value="1" /> 
<label for="payment_processed">Payment Processed</label><br />

<br />
<label for="note">Note:</label><br>
<textarea name="note" rows="3" cols="100"></textarea><br />
Note can be used for giveaway information, tshirt orders, etc.
<br /> <br />

    <input type="submit" name="submit" value="Renew" />
    
</form>



