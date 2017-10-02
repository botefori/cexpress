
	  <div class="ct-left">
		   <div  ng-controller="trackingPacketCtrl">
			  <form role="form" novalidate  data-toggle="validator" class="form-verticale">
		        <fieldset>
				   <div class="legend-header">
				    <h3>Fill Tracking Data</h3>
				   </div>
				   <div class="controls" id="track_data">
						   <label  class="control-label article_lab aline_left" for="pdesignation">Entrer le code</label>
						   <input  type="text" class="form-control article_name aline_left"  ng-model="packetStatusData.Datas.PacketID"/>  
						   <button type="button" id="add_pieces" ng-click="packetStatusData.trackPacket(packetStatusData.Datas)" class="btn btn-primary aline_left">Submit</button>
				  </div>
				</fieldset>
		      </form>
			  <div id="quotation_result" style="display:{{packetStatusData.dispTotalAmount}}">
		          <div class="legend-header">
				    <h3>Packet tracking historique</h3>
				  </div>
				  <table class="table">
						<tbody>
						  <tr ng-repeat="historique in packetStatusData.tranckingHistoriQ()" >
							 <td>{{historique.Comment}}</td>
							 <td>{{historique.Date}}</td>
						  </tr>
						</tbody>
				  </table>
			  </div>
			  <div id="quotation_result" style="display:{{packetStatusData.dispTotalAmount}}">
		          <div class="legend-header">
				    <h3>Packet details</h3>
				  </div>
				  <table class="table">
						<tbody>
						  <tr ng-repeat="piece in packetStatusData.trackedDataList()" >
							 <td>{{piece.Designation}}</td>
							 <td>{{piece.Amount}}</td>
						  </td>
						  </tr>
						  <tr>
							 <td>Total à payer</td>
							 <td> {{packetStatusData.collectionAmount}}</td>
						  </tr>
						  <tr ng-if="packetStatusData.packetStatus">
							 <td>Status</td>
							 <td> {{packetStatusData.packetStatus}}</td>
						  </tr>
						  <tr ng-if="packetStatusData.trackerrormessage">
							 <td>Erreur db</td>
							 <td> {{packetStatusData.trackerrormessage}}</td>
						  </tr>
						</tbody>
				  </table>
			  </div>
		   </div>
	  </div>


