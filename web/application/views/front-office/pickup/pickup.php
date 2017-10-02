   <div class="row">
      <div class="col-md-2">
	  </div>
	  <div class="col-md-8" id="middle-page">
	    <div class="ct_header">
		     <h3>
			  Schedule 
			  <span>Pickup</span>
			 </h3>
		</div>
		
	    <div class="col-md-7" id="ct-left" ng-controller="packetController">
		    <div id="quotation_result" style="display:{{packets.dispTotalAmount}}">
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
							 <td>Total à payer</td>
					         <td> {{packets.collectionAmount}}</td>
						  </tr>
						</tbody>
					  </table>
			</div>
		    <form role="form"  data-toggle="validator" class="form-verticale" style="display:{{packets.dispFormsTag}}">
		        <fieldset>
				   <div class="legend-header">
				    <h3>Paramètres d'enlèvement</h3>
				   </div>
				   <div class="form-group prev_overflox" id="pickup_setup">
				   <div class="control-group pieces-region">
					   <div class="controls form-inline">
						   <label class="control-label col-xs-2" for="service">Servics </label>
						   <select class="form-control col-xs-3 float" id="service" ng-model="packetController.packetsPickupData.ServiceID">
							  <option value="" disabled selected style='display:none;'>   Select service   </option>
							  <option ng-repeat="service in packets.services" value="{{ service.ServiceID }}">{{ service.ServiceName }}</option>
						   </select>
						   <label class="control-label col-xs-2 float" for="means">Moyens </label>
						   <select class="form-control col-xs-3" id="means" ng-model="packetController.packetsPickupData.MeansID">
							  <option value="" selected style='display:none;'>    Select mean  </option>
							  <option ng-repeat="mean in packets.means" value="{{ mean.MeansID }}">{{ mean.Designation }}</option>
						   </select>
					   </div>
				   </div>
				   </div>
				</fieldset>
		    </form>
			<form class="form-horizontal" role="form" data-toggle="validator" style="display:{{packets.dispFormsTag}}">
		        <fieldset id="detailsFieldset">
				   <div class="legend-header">
				    <h3>Quelles sont les details du colis ?</h3>
				   </div>
				  <div class="form-group prev_overflox"  ng-repeat="piece in packets.pieces()">
				      <div class="control-group  pieces-region">
					   <div class="controls form-inline" ng-switch="{{piece.bntadd}}">
					       <label class="control-label col-xs-2 float" for="articles">Articles </label>
					       <select class="form-control col-xs-3 float" id="articles" ng-model="piece.ArticleID" ng-change="packets.updateDetailsDisplay(piece)">
							 <option ng-repeat="article in packets.articles" value="{{ article.ArticleID }}">{{ article.Designation }}</option>
						   </select>
						   <div style="display:{{piece.displayed}}">
						   <label class="control-label col-xs-2  float" for="pdesignation">Contenu </label>
						   <input type="text" class="form-control col-xs-3 float"  id="pdesignation" placeholder="votre piece" ng-model="piece.Designation"/>  
						   </div>
						   <button ng-switch-when="true" type="button" id="add_pieces" ng-click="packets.addAPiece()" class="btn btn-primary float">add+</button>
                           <button ng-switch-when="false" type="button" id="add_removes" class="btn btn-primary float" ng-click="packets.removeAPiece(piece)">supp</button>	
					   </div>
					  </div>
					   <div class="clear">
					   </div>
					   <div class="control-group pieces-region" style="display:{{piece.displayed}}">
					     <div class="controls form-inline">
					      <label class="control-label col-xs-2" for="weight">Poids </label>
					      <input type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" class="form-control small-number col-xs-2 float" id="weight"  ng-model="piece.Weight"/>
				          <label class="control-label col-xs-2" for="height">Longueur </label>
					      <input type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" class="form-control small-number col-xs-2 float" id="lenght"  ng-model="piece.lenght"/>
				          <label class="control-label col-xs-2" for="width">Largeur </label>
					      <input type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" class="form-control small-number col-xs-2 float" id="width"  ng-model="piece.width"/>
					      <label class="control-label col-xs-2" for="height">Hauteur </label>
					      <input type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" class="form-control small-number col-xs-2 float" id="height"  ng-model="piece.height"/>			  
				         </div>
					   </div>
				  </div>
				</fieldset>
			</form>
			<form role="form" data-toggle="validator" class="form-verticale" style="display:{{packets.dispFormsTag}}">
		        <fieldset>
				  <div class="legend-header">
				    <h3>Quelle est la destination de cet envoi ?</h3>
				   </div>
				  <div class="form-group col-md-6 left-box">
				    <label class="control-label" for="consignee">société ou nom</label>
				    <input type="text"  class="form-control"  id="consignee" placeholder="société ou nom" ng-model="packetController.packetsPickupData.consignee" />
				    <label class="control-label" for="consignee-contact">Nom de contact</label>
				    <input type="text"  class="form-control"  id="consignee-contact" placeholder="nom de contact" ng-model="packetController.packetsPickupData.consigneeCcontact"/>
					<label class="control-label" for="state">Pays *</label>	
					<select class="form-control"  id="state" ng-model="packetController.packetsPickupData.consigneeState">
					    <option value="" disabled selected style='display:none;'>Please select origin</option>
						<option ng-repeat="state in packets.states()" value="{{ state.id }}">{{ state.nom_fr_fr }}</option>
					</select>
					<label class="control-label" for="addline1">Addresse- ligne 1</label>
				    <input type="text"  class="form-control"  id="addline1" placeholder="" ng-model="packetController.packetsPickupData.consigneeAddline1"/>
					<label class="control-label" for="addline2">Addresse- ligne 2</label>
				    <input type="text"  class="form-control"  id="addline2" placeholder="" placeholder="" ng-model="packetController.packetsPickupData.consigneeAddline2"/>
				 </div>
				  <div class="form-group  col-md-6 right-box">
				    <label class="control-label" for="postalCode">Code Postale</label>
				    <input type="text"  class="form-control small-number" pattern="^[0-9]{5,5}$" data-error="Code postale pas correct" required id="postalCode" placeholder="Code Postale" ng-model="packetController.packetsPickupData.consigneePostalcode"/>
					<label class="control-label" for="city">Select destination *</label>
					<select class="form-control" id="consignee-city" ng-model="packetController.packetsPickupData.consigneeCity">
						<option value="" disabled selected style='display:none;'>Select city</option>
						<option ng-repeat="city in packets.cities" value="{{ city.cp }}">{{ city.nom }}</option>
					</select>
					<label class="control-label" for="phone">Téléphone</label>
				    <input type="text"  class="form-control small-phone"  id="phone" pattern="^(\d\d\s){4}(\d\d)$" data-error="Ce numéro de téléphone n\'est pas correct"  required placeholder="XX XX XX XX XX" ng-model="packetController.packetsPickupData.consigneePhone"/>
					<label class="control-label" for="email">Email</label>
				    <input type="email"  class="form-control" id="email" data-error="Saisissez une addresse email correct" required placeholder="xyz@address.com" ng-model="packetController.packetsPickupData.consigneeEmail"/>
				  </div> 
			    </fieldset>
		        <fieldset>
				  <div class="legend-header">
				    <h3>Quelle est la provenance de l'envoi ?</h3>
				   </div>
				  <div class="form-group col-md-6 left-box">
				    <label class="control-label" for="consignor">société ou nom</label>
				    <input type="text"  class="form-control" id="consignor" placeholder="société ou nom" ng-model="packetController.packetsPickupData.consignor"/>
				    <label class="control-label" for="consignor-contact">Nom de contact</label>
				    <input type="text"  class="form-control" id="consignor-contact" placeholder="nom de contact" ng-model="packetController.packetsPickupData.consignorContact" />
					<label class="control-label" for="consignor-state">Pays *</label>	
					<select class="form-control" id="consignor-state" ng-model="packetController.packetsPickupData.consignorState">
					    <option value="" disabled selected style='display:none;'>Please select origin</option>
						<option ng-repeat="state in packets.states()" value="{{ state.id }}">{{ state.nom_fr_fr }}</option>
					</select>
					<label class="control-label" for="consignor-addline1">Addresse- ligne 1</label>
				    <input type="text"  class="form-control" id="consignor-addline1" placeholder="" ng-model="packetController.packetsPickupData.consignorAddline1" />
					<label class="control-label" for="consignor-addline2">Addresse- ligne 2</label>
				    <input type="text"  class="form-control" id="consignor-addline2" placeholder="" ng-model="packetController.packetsPickupData.consignorAddline2"/>
				  </div>
				  <div class="form-group col-md-6 right-box">
				    <label class="control-label" for="consignor-postalCode">Code Postale</label>
				    <input type="text"  class="form-control small-number" pattern="^[0-9]{5,5}$" data-error="Code postale pas correct" required id="consignor-postalCode" placeholder="Code Postale" ng-model="packetController.packetsPickupData.consignorPostalCode"/>
					<label class="control-label" for="consignor-city">Select destination *</label>
					<select class="form-control" id="consignor-city" ng-model="packetController.packetsPickupData.consignorCity">
						<option value="" disabled selected style='display:none;'>Select city</option>
						<option ng-repeat="city in packets.cities" value="{{ city.cp }}">{{ city.nom }}</option>
					</select>
					<label class="control-label" for="consignor-phone">Téléphone</label>
				    <input type="text"  class="form-control small-phone" id="consignor-phone" pattern="^(\d\d\s){4}(\d\d)$" data-error="Ce numéro de téléphone n\'est pas correct"  required placeholder="XX XX XX XX XX" ng-model="packetController.packetsPickupData.consignorPhone"/>
					<label class="control-label" for="consignor-email">Email</label>
				    <input type="email"  class="form-control" id="consignor-email" data-error="Saisissez une addresse email correct" required placeholder="xyz@address.com" ng-model="packetController.packetsPickupData.consignorEmail" />
				  </div>
				</fieldset>
				<div id="btn-shedule">
				  <button  type="submit" class="btn btn-primary" ng-click="packets.planePickup(packetController.packetsPickupData)">SHEDULE</button>
				  <button  type="submit" class="btn btn-primary">RESET</button>
				</div>
			</form>  
		</div>
		
		<div class="col-md-1" id="recpBox" ng-controller="packetController">
		
		</div>
	  </div>
	  <div class="col-md-2">
	  </div>
   </div>
   <div class="row">
   </div>
</div>
<?php if(base_url()!="http://localhost/"){ ?>
    <script src="<?php echo base_url(); ?>scripts/cexpress-clients.js"></script>
<?php } else{ ?>
    <script src="<?php echo base_url(); ?>scripts/cexpress/cexpress-clients.js"></script>
<?php } ?>
