<table>
    <tr>
        <td>Id</td>
        <td>Message</td>
    </tr>

    <?php foreach ($mlmCustomerEnquiryDetails as $mlmCustomerEnquiry) { ?>
    <tr>
        <td><?php echo $mlmCustomerEnquiry->getDetailId() ?></td>
        <td><?php echo $mlmCustomerEnquiry->getMessage() ?></td>
    </tr>
    <?php } ?>
</table>