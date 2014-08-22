
<table width="100%"><tr><th>ID</th><th>Name</th><th>Address</th><th>Email</th><th>Phone</th><th>Type</th><th>Expiry</th><th>Payment</th><th>Posted</th><th>Control</th></tr>

<?php

foreach ($supporters as $supporter) {

    echo '<tr>';
    echo '<td>' . $supporter['supporter_id'] . '</td>';
    echo '<td>' . $supporter['first_name']. ' ' . $supporter['last_name'] . '</td>';
    echo '<td>' . $supporter['address1']. ', ' . $supporter['address2'] . ' ' . $supporter['town']. '</td>';
    echo '<td>' . $supporter['email'] . '</td>';
    echo '<td>' . $supporter['phone_mobile'] . '</td>';
    if (isset($supporter['type'])) {
        echo '<td>' . $supporter['type'] . '</td>';

        echo '<td>' . strftime('%d/%m/%y', $supporter['expiration_date']) . '</td>';

        echo '<td>' . (($supporter['payment_processed']) ? 'Paid' : 'Unpaid') . '</td>';
        echo '<td>' . (($supporter['pack_sent']) ? 'Sent' : 'Unsent') . '</td>';
    }
    else {
        echo '<td></td><td></td><td></td><td></td>';
    }

    echo '<td><a href="' . site_url('supporters/renew') . '/' . $supporter['supporter_id'] . '">Renew</a>';
    echo ' | <a href="' . site_url('supporters/edit') . '/' . $supporter['supporter_id'] . '">Edit</a></td>';

    echo '</tr>';
}
?>

</table>

