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
		<form role="form" method="Post" data-toggle="validator" class="form-verticale">
	    <div class="col-md-7" id="ct-left" ng-controller="packetController">
		        <fieldset>
				   <div class="legend-header">
				    <h3>Paramètres d'enlèvement</h3>
				   </div>
				   <div class="form-group col-md-6 left-box">
					   <label class="control-label" for="service">Select service</label>
					   <select class="form-control" id="service" ng-model="packetController.packetsPickupData.ServiceID">
						  <option value="" disabled selected style='display:none;'>Select service</option>
						  <option ng-repeat="service in packets.services" value="{{ service.ServiceID }}">{{ service.ServiceName }}</option>
					   </select>
					   <label class="control-label" for="content-mdl">Moyens </label>
					   <select class="form-control" id="means" ng-model="packetController.packetsPickupData.MeansID">
						  <option value="" disabled selected style='display:none;'>Select mean</option>
						  <option ng-repeat="mean in packets.means" value="{{ mean.MeansID }}">{{ mean.Designation }}</option>
					   </select>
					   <label class="control-label" for="enter">Articles </label>
					   <select class="form-control" id="articles" ng-model="packetController.packetsPickupData.ArticleID" ng-change="packetController.updateDetailsDisplay()">
						  <option value=""  selected >Select article</option>
						  <option ng-repeat="article in packets.articles" value="{{ article.ArticleID }}">{{ article.Designation }}</option>
					   </select>
					   <label class="control-label" for="content-mdl">Contenu </label>
					   <input type="text" class="form-control" id="content-mdl" placeholder="nature du colis" ng-model="packetController.packetsPickupData.Content"/>
				   </div>
				   <div class="form-group  col-md-6 right-box">
				      
				   </div>
				</fieldset>
		        <fieldset id="detailsFieldset">
				   <div class="legend-header">
				    <h3>Quelles sont les details du colis ?</h3>
				   </div>
				   <div class="form-group col-md-7">
					   <label class="control-label" for="weight">Poids </label>
					   <input type="text" class="form-control small-number" id="weight" required placeholder="Poids" ng-model="packetController.packetsPickupData.Weight"/>
				       <label class="control-label" for="height">Longueur </label>
					   <input type="text" class="form-control small-number" id="lenght" placeholder="Longueur" ng-model="packetController.packetsPickupData.lenght"/>
				       <label class="control-label" for="width">Largeur </label>
					   <input type="text" class="form-control small-number" id="width" placeholder="Largeur" ng-model="packetController.packetsPickupData.width"/>
					   <label class="control-label" for="height">Hauteur </label>
					   <input type="text" class="form-control small-number" id="height" placeholder="Hauteur" ng-model="packetController.packetsPickupData.height"/>
				   </div>
				</fieldset>
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
					<label class="control-label" for="addline3">Addresse- ligne 3</label>
				    <input type="text"  class="form-control"  id="addline3" placeholder="" placeholder="" ng-model="packetController.packetsPickupData.consigneeAddline3"/>
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
					<label class="control-label" for="consignor-addline3">Addresse- ligne 3</label>
				    <input type="text"  class="form-control" id="consignor-addline2" placeholder="" ng-model="packetController.packetsPickupData.consignorAddline3"/>
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
				  
		</div>
		</form>
		<div class="col-md-1" id="recpBox" ng-controller="packetController">
		    <div class="recapheader">
			  <h3>Votre Colis</h3>
			</div>
			<table class="table">
			    <tbody>
				  <tr>
				     <td>Poids unitaire</td>
					 <td>{{packets.recapDatas.Weight}} g</td> 
				  </tr>
				  <tr>
				     <td>Produit</td>
					 <td>{{packets.recapDatas.Designation}}</td>
				  </td>
				  <tr>
				     <td>Longueur</td>
					 <td>{{packets.recapDatas.Lenght}} cm</td>
				  </td>
				  <tr>
				     <td>Largeur</td>
					 <td>{{packets.recapDatas.Width}} cm</td>
				  </td>
				  <tr>
				     <td>Hauteur</td>
					 <td>{{packets.recapDatas.Height}} cm</td>
				  </td>
				  <tr>
				     <td>Fraies</td>
					 <td>{{packets.recapDatas.AmountCollection}}</td>
				  </td>
				</tbody>
			  </table>
		</div>
	  </div>
	  <div class="col-md-2">
	  </div>
   </div>
   <div class="row">
   </div>
</div>
<script src="<?php echo base_url(); ?>scripts/cexpress-clients.js"></script>