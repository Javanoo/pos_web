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
	 <caption><h4>'; echo '('. (($items_in_cart != null) ? 
	                             count($items_in_cart) : '0');
	  echo ') ITEMS</h4></caption>
    <thead>					   	
		 <tr>
	    <th>ITEM ID</th>									
      <th>NAME</th>																			
			<th>PRICE</th>																			
			<th>QUANTITY</th>																			
			<th>AMOUNT</th>	
			<th>EDIT</th>
			<th>REMOVE</th>																			
		 </tr>
		</thead>
		<tbody>';
		 if($items_in_cart != null)
		  foreach ($items_in_cart as $item): echo
		  '<tr>
		   <form action="" method="POST">
		   <input hidden="true" type="text" name="edited_id" value="'.$item["trans_id"].'">
			 <td>'. $item["item_id"].'</td>
			 <td class="td_center">'. $item['item_name'].'</td>
			 <td class="td_center">'. $item['item_price'].'</td>
			 <td class="td_center"><input type="text" name="quantity" contenteditable="true" value="'.
			   $item['item_quantity'].'" 
			   style="text-align: center; width:50px; border:none; font-family:outfit; font-size:1rem"></input></td>
			 <td class="td_center">'. $item['item_amount'].'</td>
			 <td><button type="submit" id="edit" name="table_action" value="edit">↻</input></td>
			 <td><button type="submit" id="edit" name="table_action" value="remove">➖</input></td>
			 </form>
			</tr>';
			endforeach; echo
			'</tbody>															
	</table>
</section>
';
?>