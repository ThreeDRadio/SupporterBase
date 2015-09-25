<h2>Add Supporter</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('supporters/add') ?>

    <label for="first">First Name:</label>
    <input type="input" name="first" /><br />

    <label for="last">Last Name:</label>
    <input type="input" name="last" /><br />

    <label for="address1">Address Line 1:</label>
    <input type="input" name="address1" /><br />

    <label for="address2">Address Line 2:</label>
    <input type="input" name="address2" /><br />

    <label for="town">Town/Suburb</label>
    <input type="input" name="town" /><br />

    <label for="state">State:</label>
    <input type="input" name="state" /><br />

    <label for="postcode">Postcode:</label>
    <input type="input" name="postcode" /><br />

    <label for="country">Country:</label>
    <input type="input" name="country" value="Australia" /><br />

    <label for="phone">Phone:</label>
    <input type="input" name="phone" /><br />

    <label for="email">Email:</label>
    <input type="input" name="email" /><br />

    <label for="email">Prefer Email:</label>
    <input type="checkbox" name="prefer_email" /><br />

    <input type="submit" name="submit" value="Add Supporter" />

</form>


