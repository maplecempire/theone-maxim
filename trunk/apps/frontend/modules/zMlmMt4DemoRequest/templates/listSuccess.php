<?php
// auto-generated by sfPropelCrud
// date: 2012/11/12 16:07:08
?>
<h1>zMlmMt4DemoRequest</h1>

<table>
<thead>
<tr>
  <th>Request</th>
  <th>First name</th>
  <th>Email</th>
  <th>Status code</th>
  <th>Created by</th>
  <th>Created on</th>
  <th>Updated by</th>
  <th>Updated on</th>
  <th>Country</th>
  <th>Phone number</th>
  <th>Last name</th>
  <th>Title</th>
  <th>Live demo</th>
  <th>Address1</th>
  <th>Address2</th>
  <th>Agree of business</th>
  <th>Risk disclosure</th>
  <th>Country of citizen</th>
  <th>Dob day</th>
  <th>Dob month</th>
  <th>Dob year</th>
  <th>Ref</th>
  <th>Passport</th>
  <th>Subject</th>
</tr>
</thead>
<tbody>
<?php foreach ($mlm_mt4_demo_requests as $mlm_mt4_demo_request): ?>
<tr>
    <td><?php echo link_to($mlm_mt4_demo_request->getRequestId(), 'zMlmMt4DemoRequest/show?request_id='.$mlm_mt4_demo_request->getRequestId()) ?></td>
      <td><?php echo $mlm_mt4_demo_request->getFirstName() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getEmail() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getStatusCode() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getCreatedBy() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getCreatedOn() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getUpdatedBy() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getUpdatedOn() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getCountry() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getPhoneNumber() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getLastName() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getTitle() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getLiveDemo() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getAddress1() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getAddress2() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getAgreeOfBusiness() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getRiskDisclosure() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getCountryOfCitizen() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getDobDay() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getDobMonth() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getDobYear() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getRefId() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getPassport() ?></td>
      <td><?php echo $mlm_mt4_demo_request->getSubject() ?></td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>

<?php echo link_to ('create', 'zMlmMt4DemoRequest/create') ?>
