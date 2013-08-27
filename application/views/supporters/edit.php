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

    <input type="submit" name="submit" value="Update Supporter" />

</form>



