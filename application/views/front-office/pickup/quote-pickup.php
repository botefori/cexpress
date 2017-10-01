
<div id="ct-left" ng-controller="packetController">
          <div id="quotation_result" ng-show="packets.isErrorsExists()">
		          <div class="legend-header">
				    <h3>Quotation Error(s)</h3>
				  </div>
					<table class="table">
						<tbody>
						  <tr ng-repeat="error in packets.quotationErrorsList()" >
							 <td>{{error.article}}</td>
							 <td>{{error.service}}</td>
							 <td>{{error.means}}</td>
							 <td>{{error.error_msg}}</td>
						  </td>
						  </tr>
						</tbody>
					  </table>
		  </div>
		  <form role="form" novalidate name="quote_pickup_one"  data-toggle="validator" class="form-verticale">
		        <fieldset>
				   <div class="legend-header">
				    <h3>Paramètres d'enlèvement</h3>
				   </div>
				   <div class="form-group prev_overflox" id="pickup_setup">
				   <div class="control-group pieces-region">
					   <div class="controls form-inline">
						   <label class="control-label col-xs-2" for="service">Servics </label>
						   <select class="form-control col-xs-3 float" 
						           id="service" required 
								   ng-change="packets.serviceChanged(packets.selectedService,2)"
								   ng-model="packets.selectedService.ServiceID">
								   <option value="" disabled selected style='display:none;'>   Select service   </option>
							       <option ng-selected="{{service.ServiceID == packets.selectedService.ServiceID}}" ng-repeat="service in packets.services()" value="{{ service.ServiceID }}">{{ service.ServiceName }}</option>
						   </select>
						   <span ng-show="quote_pickup_one.service.$error.required"></span>
						   <label class="control-label col-xs-2 float" for="means">Moyens </label>
						   <select class="form-control col-xs-3" 
						           id="means" 
								   required 
								   ng-change="packets.meansChanged(packets.selectedMeans,2)"
								   ng-model="packets.selectedMeans.MeansID">
							  <option value="" selected style='display:none;'>    Select mean  </option>
							  <option ng-selected="{{mean.MeansID == packets.selectedMeans.MeansID}}" ng-repeat="mean in packets.means()" value="{{ mean.MeansID }}">{{ mean.Designation }}</option>
						   </select>
						   <span ng-show="quote_pickup_one.means.$error.required"></span>
					   </div>
				   </div>
				   </div>
				</fieldset>
		    </form>
			<form role="form" novalidate  data-toggle="validator" name="quote_pickup_two" class="form-verticale" style="display:{{packets.dispFormsTag}}">
		        <fieldset>
				   <div class="legend-header">
				    <h3>Origine & Designation Packet</h3>
				   </div>
				   <div class="form-group prev_overflox" id="pickup_setup">
				   <div class="control-group pieces-region">
					   <div class="controls form-inline">
						   <label class="control-label col-xs-2" for="service">packet origin </label>
						   <select class="form-control col-xs-3 float" 
						           id="stateOrgin" 
								   required
                                   ng-change="packets.originChanged(packets.selectedStateOrigin,2)"							   
								   ng-model="packets.selectedStateOrigin.id">
							  <option value="" selected style='display:none;'>Please select origin</option>
						      <option ng-selected="{{stateOrigin.id == packets.selectedStateOrigin.id}}" ng-repeat="stateOrigin in packets.states()" value="{{ stateOrigin.id }}">{{ stateOrigin.nom_fr_fr }}</option>
						   </select>
						   <span ng-show="quote_pickup_two.stateOrgin.$error.required"></span>
						   <label class="control-label col-xs-2 float" for="stateDesination">Packet Designation </label>
						   <select class="form-control col-xs-3" 
						           id="stateDesination" 
								   required
								   ng-change="packets.desinationChanged(packets.selectedStateDesination,2)"
								   ng-model="packets.selectedStateDesination.id">
							  <option value="" selected style='display:none;'>Please select destination</option>
						      <option ng-selected="{{StateDesination.id == packets.selectedStateDesination.id}}" ng-repeat="StateDesination in packets.states()" value="{{ StateDesination.id }}">{{ StateDesination.nom_fr_fr }}</option>
						   </select>
						   <span ng-show="quote_pickup_two.stateDesination.$error.required"></span>
					   </div>
				   </div>
				   </div>
				</fieldset>
		    </form>
			
			<form role="form" novalidate data-toggle="validator" name="packet_form" class="form-verticale" style="display:{{packets.dispFormsTag}}">
		        <fieldset>
				   <div class="legend-header">
				    <h3>Paramètre Packet</h3>
				   </div>
				   <div class="form-group prev_overflox"  ng-repeat="piece in packets.pieces()">
				      <div class="control-group  pieces-region">
					   <div class="controls" ng-switch="{{piece.bntadd}}">
					       <label class="control-label article_lab aline_left" for="articles">Articles </label>
					       <select class="form-control article_name  aline_left" 
						           id="articles" 
								   ng-model="piece.ArticleID" 
								   ng-change="packets.updateDetailsDisplay(piece)">
							 <option ng-selected="{{article.ArticleID == piece.ArticleID}}" ng-repeat="article in packets.articles" value="{{ article.ArticleID }}">{{ article.Designation }}</option>
						   </select>
						   <label style="display:{{piece.displayed}}" class="control-label article_lab aline_left" for="pdesignation">Contenu </label>
						   <input style="display:{{piece.displayed}}" type="text" class="form-control article_name aline_left"  id="pdesignation" required placeholder="votre piece" ng-model="piece.Designation"/>  
						   <span ng-show="packet_form.pdesignation.$error.required"></span>
						   <button ng-switch-when="true" type="button" id="add_pieces" ng-click="packets.addAPiece()" class="btn btn-primary aline_left">add+</button>
                           <button ng-switch-when="false" type="button" id="add_removes" class="btn btn-primary aline_left" ng-click="packets.removeAPiece(piece)">supp</button>	
					   </div>
					  </div>
					   <div class="clear">
					   </div>
					   <div class="control-group pieces-region" style="display:{{piece.displayed}}">
					      <label class="control-label article_lab aline_left" for="weight">Poids </label>
					      <input type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" class="form-control small-number aline_left" required id="weight"  ng-model="piece.Weight"/>
				          <span ng-show="packet_form.weight.$error.required"></span>
						  <label class="control-label article_lab aline_left" for="lenght">Longueur </label>
					      <input type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" class="form-control small-number aline_left" required id="lenght"  ng-model="piece.lenght"/>
				          <span ng-show="packet_form.lenght.$error.required"></span>
						  <label class="control-label article_lab aline_left aline_left" for="width">Largeur </label>
					      <input type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" class="form-control small-number aline_left" required id="width"  ng-model="piece.width"/>
					      <span ng-show="packet_form.width.$error.required"></span>
						  <label class="control-label article_lab aline_left" for="height">Hauteur </label>
					      <input type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" class="form-control small-number aline_left" required id="height"  ng-model="piece.height"/>			  
					      <span ng-show="packet_form.height.$error.required"></span>
					  </div>
				  </div>
				</fieldset>
		    </form>
		
		  <div id="btn-Quickquote" style="display:{{packets.dispFormsTag}}">
		      <button  type="submit" ng-disabled="!packets.isPiecesValid() || quote_pickup_one.$invalid || quote_pickup_two.$invalid" class="btn btn-primary" ng-click="packets.setQuotationData()"> NEXT </button>
		  </div>
</div>
   