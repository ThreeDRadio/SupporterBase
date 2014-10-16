<script>

function packSent(transactionID) {
    //alert("<?php echo site_url('supporters/ajaxSetSubscriberPackSent') ?>/" + transactionID);
    $.ajax({url: "<?php echo site_url('supporters/ajaxSetSubscriberPackSent') ?>/" + transactionID,
        success:function(result) {
            $("#pack"+transactionID).html(result);
        }}
    )
}
</script>

<h2>Subscriber Processing</h2>

<table width="80%" border="1"><tr><th>Sub ID</th><th>Transaction ID</th><th>Name</th><th>Payment</th><th>Sub Pack</th></tr>

<?php

foreach ($supporters as $supporter) {

    echo '<tr>';
    echo '<td>' . $supporter['supporter_id'] . '</td>';
    echo '<td>' . $supporter['transaction_id'] . '</td>';
    echo '<td>' . $supporter['first_name']. ' ' . $supporter['last_name'] . '</td>';
    if (isset($supporter['type'])) {
        if ($supporter['payment_processed']) {
            echo '<td><font color="#008800">Paid</td>';
        }
        else {
            echo '<td><font color="#CC0000">Unpaid</font> ';
            echo '<button>Mark Paid</button>';
            echo '</td>';
        }

        if ($supporter['pack_sent']) {
            echo '<td><font color="#008800">Sent</td>';
        }
        else {
            echo '<td id="pack'. $supporter['transaction_id'] . '"><font color="#CC0000">Unsent</font> ';
            echo '<button onclick="packSent('. $supporter['transaction_id'] . ')">Mark Sent</button>';
            echo '</td>';
        }

    }
    else {
        echo '<td></td><td></td><td></td><td></td>';
    }

    echo '</tr>';
}
?>

</table>

