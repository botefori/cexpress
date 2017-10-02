<div  id="ct-left" ng-controller="packetController">
<form role="form" data-toggle="validator" name="pickup_destination" class="form-verticale" style="display:{{packets.dispFormsTag}}">
		        <fieldset>
				  <div class="legend-header">
				    <h3>Quelle est la destination de cet envoi ?</h3>
				   </div>
				  <div class="form-group col-md-6 left-box">
				    <label class="control-label" for="consignee">société ou nom</label>
				    <input type="text"  class="form-control"  id="consignee" placeholder="société ou nom" required ng-model="packets.packetDestination.consignee" />
					<span ng-show="pickup_destination.consignee.$error.required" class="help-inline">Required</span>
					<label class="control-label" for="addline1">Addresse- ligne 1</label>
				    <input type="text"  class="form-control"  id="addline1"  required ng-model="packets.packetDestination.consigneeAddline1"/>
					<span ng-show="pickup_destination.addline1.$error.required" class="help-inline">Required</span>
					<label class="control-label" for="addline2">Addresse- ligne 2</label>
				    <input type="text"  class="form-control"  id="addline2" required ng-model="packets.packetDestination.consigneeAddline2"/>
				    <span ng-show="pickup_destination.addline2.$error.required" class="help-inline">Required</span>
				</div>
				  <div class="form-group  col-md-6 right-box">
				    <label class="control-label" for="postalCode">Code Postale</label>
				    <input type="text"  class="form-control small-number" pattern="^[0-9]{5,5}$" data-error="Code postale pas correct" required id="postalCode" placeholder="Code Postale" ng-model="packets.packetDestination.consigneePostalcode"/>
					<span ng-show="pickup_destination.postalCode.$error.required" class="help-inline">Required</span>
					<label class="control-label" for="phone">Téléphone</label>
				    <input type="text"  class="form-control small-phone"  id="phone" pattern="^(\d\d\s){4}(\d\d)$" data-error="Ce numéro de téléphone n\'est pas correct"  required placeholder="XX XX XX XX XX" ng-model="packets.packetDestination.consigneePhone"/>
					<span ng-show="pickup_destination.phone.$error.required" class="help-inline">Required</span>
					<label class="control-label" for="email">Email</label>
				    <input type="email"  class="form-control" id="email" data-error="Saisissez une addresse email correct" required placeholder="xyz@address.com" ng-model="packets.packetDestination.consigneeEmail"/>
				    <span ng-show="pickup_destination.email.$error.required" class="help-inline">Required</span>
				  </div> 
			    </fieldset>
				<div id="btn-shedule">
				  <button  type="submit" ng-disabled="pickup_destination.$invalid" class="btn btn-primary" ng-click="packets.planePickup()">SHEDULE</button>
				</div>
</form> 
</div> 