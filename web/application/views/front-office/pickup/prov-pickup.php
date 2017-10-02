<div  id="ct-left" ng-controller="packetController">
<form role="form" data-toggle="validator" name="pickup_origine" class="form-verticale" style="display:{{packets.dispFormsTag}}">
		        <fieldset>
				  <div class="legend-header">
				    <h3>Quelle est la provenance de l'envoi ?</h3>
				   </div>
				  <div class="form-group col-md-6 left-box">
				    <label class="control-label" for="consignor">société ou nom</label>
				    <input type="text"  class="form-control" id="consignor" placeholder="société ou nom" required ng-model="packets.packetOrigin.consignor"/>
					<span ng-show="pickup_origine.consignor.$error.required" class="help-inline">Required</span>
					<label class="control-label" for="addline1">Addresse- ligne 1</label>
				    <input type="text"  class="form-control" id="addline1" placeholder="" required ng-model="packets.packetOrigin.consignorAddline1" />
					<span ng-show="pickup_origine.addline1.$error.required" class="help-inline">Required</span>
					<label class="control-label" for="addline2">Addresse- ligne 2</label>
				    <input type="text"  class="form-control" id="addline2" placeholder="" required ng-model="packets.packetOrigin.consignorAddline2"/>
				    <span ng-show="pickup_origine.addline2.$error.required" class="help-inline">Required</span>
				  </div>
				  <div class="form-group col-md-6 right-box">
				    <label class="control-label" for="consignor-postalCode">Code Postale</label>
				    <input type="text" id="codePostal"  class="form-control small-number" pattern="^[0-9]{5,5}$" data-error="Code postale pas correct" required placeholder="Code Postale" ng-model="packets.packetOrigin.consignorPostalCode"/>
					<span ng-show="pickup_origine.codePostal.$error.required" class="help-inline">Required</span>
					<label class="control-label" for="consignor-phone">Téléphone</label>
				    <input type="text" id="phone"  class="form-control small-phone" pattern="^(\d\d\s){4}(\d\d)$" data-error="Ce numéro de téléphone n\'est pas correct"  required placeholder="XX XX XX XX XX" ng-model="packets.packetOrigin.consignorPhone"/>
					<span ng-show="pickup_origine.phone.$error.required" class="help-inline">Required</span>
					<label class="control-label" for="email">Email</label>
				    <input type="email" id="email"  class="form-control" id="consignor-email" data-error="Saisissez une addresse email correct" required placeholder="xyz@address.com" ng-model="packets.packetOrigin.consignorEmail" />
				    <span ng-show="pickup_origine.email.$error.required" class="help-inline">Required</span>
				 </div>
				</fieldset>
				<div id="btn-shedule">
				  <button  type="submit" ng-disabled="pickup_origine.$invalid" class="btn btn-primary" ng-click="packets.setOrigin()"> NEXT </button>  
				</div>
</form> 
</div> 