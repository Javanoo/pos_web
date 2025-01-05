<?php
echo  '
<!--left most panel -->
<section id="left_panel">
  <ul>
    <li><a href="/pos_web/sales" id='."$status1".
    '>sales</a></li>											
    <li><a href="/pos_web/sales?history=on" id='."$status2".
    '>history</a></li>											
    <li><a href="/pos_web/sales?settings=on" id='."$status3".
    '>settings</a></li>											
    <li class="bottom"><a href="/pos_web/sales?logout=on" id='."$status4".
    '>logout</a></li>											
  </ul>						
</section>';
?>