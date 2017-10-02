<div ng-controller="trackingCtrl" class="col-sm-5 col-md-5">
    <div>
        <table id="tab-packets" class="table table-bordered">
         <thead><th>Tracking code</th><th>Status</th></thead>
	     <tbody>
	          <tr ng-repeat="pkt in adminservice.packetList" ng-click="adminservice.selectPacket(pkt)" ng-class="{packetselected : pkt.PacketID === adminservice.selectedPacket.PacketID }">
	            <td>{{ pkt.TrackingCode }}</td>
	            <td>{{ pkt.DesignationStatus }}</td>                        
	          </tr>
         </tbody>
	   </table>
	   <nav>
	     <ul class="pagination">
             <li class="precitem">
                <a ng-click="adminservice.getPackets(adminservice.precPage)" arial-albel="Previous"><span arial-hidden="true">&laquo;</span></a>
             </li>
	         <li  ng-repeat="packet in adminservice.pagesNumber() track by $index" ng-attr-class="{{packet===adminservice.currentSelectedPage ? 'active' : 'rien'}}">
	                <a ng-click="adminservice.getPackets(packet)" >{{packet}}</a>
	         </li>
	         <li class="nextitem">
	            <a ng-click="adminservice.getPackets(adminservice.nextPage)"><span arial-hidden="true">&raquo;</span></a>
	         </li>
	     </ul>
	    </nav>
    </div>
</div>
<div class="col-md-3" ng-controller="packetUpdateCtrl">
	<form role="form" class="form-verticale">
		<fieldset>
			<div class="form-group">
			  <label for="packetid">Tracking code</label>
			  <input type="text" ng-model="adminservice.selectedPacket.TrackingCode" class="form-control" id="packetid" placeholder="tracking code" />
			  <label for="service">Service</label>
			  <select class="form-control" 
					  id="service" required 
					  ng-change="adminservice.serviceChanged(adminservice.selectedService)"
					  ng-model="adminservice.selectedPacket.ServiceID">
					  <option value="" disabled selected style='display:none;'>   Select service   </option>
					  <option ng-selected="{{service.ServiceID == adminservice.selectedPacket.ServiceID}}" ng-repeat="service in adminservice.services()" value="{{ service.ServiceID }}">{{ service.ServiceName }}</option>
			  </select>
			  <label for="AddressLine1">Packet status</label>
			  <select class="form-control" 
					  id="service" required 
					  ng-change="adminservice.statusChanged(adminservice.selectedStatus)"
					  ng-model="adminservice.selectedPacket.StatusID">
					  <option value="" disabled selected style='display:none;'>   Select status   </option>
					  <option ng-selected="{{status.StatusID == adminservice.selectedPacket.StatusID}}" ng-repeat="status in adminservice.status()" value="{{ status.StatusID }}">{{ status.DesignationStatus }}</option>
			  </select>
			</div>
		    <button id="updatePackets" type="submit" ng-click="adminservice.updatePackets(adminservice.selectedPacket)" class="btn btn-primary">Update packet</button>
		</fieldset>
	</form>
</div>