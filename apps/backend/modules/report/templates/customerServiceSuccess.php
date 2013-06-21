<table>
    <tr>
        <td>Id</td>
        <td>Title</td>
    </tr>

    <?php foreach ($mlmCustomerEnquirys as $mlmCustomerEnquiry) { ?>
    <tr>
        <td><?php echo $mlmCustomerEnquiry->getEnquiryId() ?></td>
        <td><?php echo $mlmCustomerEnquiry->getTitle() ?></td>
    </tr>
    <?php } ?>
</table>