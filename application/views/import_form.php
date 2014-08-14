<h2>Import Supporters</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('import/csv') ?>
    <input type="file" name="file" /><br /></br />
    <input type="submit" name="submit" value="Begin Import" />
</form>
