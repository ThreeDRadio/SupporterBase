<h2>Find User</h2>


    <label for="last_name">Last Name:</label>
    <input id="last_name" type="input" name="last_name" /><br />

<h3>Matches</h3>
<div id="matches"></div>

<script>
$('input#last_name').keyup(function() {
    if ($('input#last_name').val().length >= 2) {
        $.ajax({
            url: "<?php echo site_url('supporters/ajaxFindSupporterByLastName') ?>/" + encodeURIComponent($('input#last_name').val()),
                success: function( data ) {
                    xmlDoc = $.parseXML(data);
                    $xml = $(xmlDoc);
                    text = '<table width="100%"><tr><th>Name</th><th>Address</th><th>Email</th><th>Phone</th><th>Type</th><th>Status</th><th>Control</th></tr>';
                    $xml.children().children().each(function() {
                        id = $(this).children('supporter_id').text();
                        firstName = $(this).children('first_name').text();
                        lastName = $(this).children('last_name').text();
                        address1 = $(this).children('address1').text();
                        address2 = $(this).children('address2').contents();
                        town = $(this).children('town').text();
                        state = $(this).children('state').text();
                        postcode = $(this).children('postcode').text();
                        email = $(this).children('email').text();
                        phone = $(this).children('phone').text();
                        stat = $(this).children('status').text();
                        type = $(this).children('type').text();

                        text += '<tr><td>' + firstName + ' ' + lastName + '</td><td>' + address1 + ', ';
                        if (address2.text().length > 0) {
                            text += address2 + ', ';
                        }
                        text += town + ' ' + state + ' ' + postcode + '</td>';
                        text += '<td>' + email + '</td>';
                        text += '<td>' + phone + '</td>';
                        text += '<td>' + type + '</td>';
                        text += '<td>' + stat + '</td>';
                        text += '<td><a href="<?php echo site_url('supporters/renew')?>/' + id + '">Renew</a>';
                        text += ' | <a href="<?php echo site_url('supporters/edit')?>/' + id + '">Edit</a></td>';
                        text += '</tr>';

                    });
                    text += '</table>';
                    $( "#matches" ).html(text);
                }
        });
    }
else {
    $('#matches').text("");
}
});
</script>
