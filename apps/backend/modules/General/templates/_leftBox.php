<table class="left_box">
  <tr>
    <th colspan="2">Salud Online - ADMIN</th>
  </tr>
  <tr><td></td></tr>
  <tr>
    <td>Current Visits:</td>
    <td><?php echo $visits ?></td>
  </tr>
  <tr><td></td></tr>
  <tr><td></td></tr>
  <tr>
    <th colspan="2">Last Visit</th>
  </tr>
  <tr><td></td></tr>
  <tr>
    <td>Remote Address</td>
    <td><b><?php echo $lastVisit->getRemoteAddress() ?></b></td>
  </tr>
  <tr>
    <td>HTTP User Agent</td>
    <td><b><small><?php echo $lastVisit->getHttpUserAgent() ?></small></b></td>
  </tr>
  <tr>
    <td>Datetime</td>
    <td><b><?php echo $lastVisit->getDatetime() ?></b></td>
  </tr>
  <tr><td></td></tr>
  <tr>
    <th colspan="2">Salud Online Version</th>
  </tr>
  <tr><td></td></tr>
  <tr>
    <td>Version</td>
    <td><b>1.0</b></td>
  </tr>
  <tr><td></td></tr>
  <tr><td></td></tr>
</table>
