<?php

echo ' 
<!--Central panel -->						
<section id="cart_panel">
  <h3 style="color: #cd9976ee;">'.strtoupper(date('l d F')).'</h3>
  <h4>CHARGE</h4>
  <textarea  style="color: green;" disabled="true" placeholder='
  .'MK'.number_format($charge,2).'></textarea>	
	<h4>CHANGE</h4>
	<textarea style="color: red;" disabled="true" placeholder='
	.'MK'.number_format($change,2).'
	></textarea>	
	<table>
	 <caption><h4>ITEMS IN CART</h4></caption>
    <thead>					   	
		 <tr>
	    <th>ID NUMBER</th>									
      <th>NAME</th>																			
			<th>PRICE</th>																			
			<th>QUANTITY</th>																			
			<th>AMOUNT</th>																			
		 </tr>
		</thead>
		<tbody>';
		  foreach ($items_in_cart as $item): echo
		  '<tr>
			 <td>'. $item['item_id'].'</td>
			 <td>'. $item['item_name'].'</td>
			 <td>'. $item['item_price'].'</td>
			 <td>'. $item['item_quantity'].'</td>
			 <td>'. $item['item_amount'].'</td>
			</tr>';
			endforeach; echo
			'</tbody>															
	</table>
</section>
';
?>