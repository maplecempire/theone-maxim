<?php
// auto-generated by sfPropelCrud
// date: 2013/06/18 11:00:47
?>
<h1>imeRegistration</h1>

<table>
<thead>
<tr>
  <th>Ime</th>
  <th>Full name</th>
  <th>Full name chinese</th>
  <th>Distributor code</th>
  <th>Passport number</th>
  <th>Nationality</th>
  <th>Mobile no</th>
  <th>Email</th>
  <th>Dist</th>
  <th>Account</th>
  <th>Account type</th>
  <th>Qty</th>
  <th>Sub total</th>
  <th>Status code</th>
  <th>Created by</th>
  <th>Created on</th>
  <th>Updated by</th>
  <th>Updated on</th>
</tr>
</thead>
<tbody>
<?php foreach ($ime_registrations as $ime_registration): ?>
<tr>
    <td><?php echo link_to($ime_registration->getImeId(), 'imeRegistration/show?ime_id='.$ime_registration->getImeId()) ?></td>
      <td><?php echo $ime_registration->getFullName() ?></td>
      <td><?php echo $ime_registration->getFullNameChinese() ?></td>
      <td><?php echo $ime_registration->getDistributorCode() ?></td>
      <td><?php echo $ime_registration->getPassportNumber() ?></td>
      <td><?php echo $ime_registration->getNationality() ?></td>
      <td><?php echo $ime_registration->getMobileNo() ?></td>
      <td><?php echo $ime_registration->getEmail() ?></td>
      <td><?php echo $ime_registration->getDistId() ?></td>
      <td><?php echo $ime_registration->getAccountId() ?></td>
      <td><?php echo $ime_registration->getAccountType() ?></td>
      <td><?php echo $ime_registration->getQty() ?></td>
      <td><?php echo $ime_registration->getSubTotal() ?></td>
      <td><?php echo $ime_registration->getStatusCode() ?></td>
      <td><?php echo $ime_registration->getCreatedBy() ?></td>
      <td><?php echo $ime_registration->getCreatedOn() ?></td>
      <td><?php echo $ime_registration->getUpdatedBy() ?></td>
      <td><?php echo $ime_registration->getUpdatedOn() ?></td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>

<?php echo link_to ('create', 'imeRegistration/create') ?>
