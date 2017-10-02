<div ng-show="packets.isPacket=true" id="quotation_result" ng-controller="packetController">
		<div class="legend-header">
		    <h3>Shipment results</h3>
		</div>
		<table class="table">
			<tbody>
				<tr ng-repeat="piece in packets.recapDataList()" >
					<td>{{piece.Designation}}</td>
					<td>{{piece.Amount}}</td>
					<td> <ngcart-addtocart templateUrl="<?php echo base_url(); ?>templates/ngCart/addtocart.html" id="{{piece.PiecesID}}" name="{{piece.Designation}}" price="{{piece.Amount}}" quantity="1">Add to Cart</ngcart-addtocart></td>
				</tr>
			</tbody>
</table>