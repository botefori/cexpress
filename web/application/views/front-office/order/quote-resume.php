<div ng-show="packets.isPacket=true" id="quotation_result" ng-controller="packetController">
		<div class="legend-header">
		    <h3>Shipment results</h3>
		</div>
		<table class="table">
			<tbody>
				<tr ng-repeat="piece in packets.recapDataList()" >
					<td>{{piece.Designation}}</td>
					<td>{{piece.Amount}}</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td><button type="button"  ng-click="packets.validateQuotation()" class="btn btn-primary aline_left">Validate packet</button></td>
				</tr>
			</tbody>
</table>