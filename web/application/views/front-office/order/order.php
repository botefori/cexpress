   <div class="row">
      <div class="col-md-2">
	  </div>
	  <div class="col-md-8" id="middle-page">
	    <div class="ct_header">
		     <h3>
			  QUICK 
			  <span>QUOTE</span>
			 </h3>
		</div>
		<div  ng-controller="freightCtrl">
		      <div id="quotation_result" style="display:{{freights.dispTotalAmount}}">
		          <div class="legend-header">
				    <h3>Quotation results</h3>
				  </div>
					<table class="table">
						<tbody>
						  <tr ng-repeat="piece in freights.quotationResulttaList()" >
							 <td>{{piece.Designation}}</td>
							 <td>{{piece.Amount}}</td>
						  </td>
						  </tr>
						  <tr>
							 <td>Total à payer</td>
							 <td> {{freights.collectionAmount}}</td>
						  </tr>
						</tbody>
					  </table>
			  </div>
		  <form role="form" novalidate  data-toggle="validator" class="form-verticale" style="display:{{freights.dispFormsTag}}">
		        <fieldset>
				   <div class="legend-header">
				    <h3>Paramètres d'enlèvement</h3>
				   </div>
				   <div class="form-group prev_overflox" id="pickup_setup">
				   <div class="control-group pieces-region">
					   <div class="controls form-inline">
						   <label class="control-label col-xs-2" for="service">Servics </label>
						   <select class="form-control col-xs-3 float" id="service" ng-model="freightCtrl.freightQuoteData.ServiceID">
							  <option value="" disabled selected style='display:none;'>   Select service   </option>
							  <option ng-repeat="service in freights.services" value="{{ service.ServiceID }}">{{ service.ServiceName }}</option>
						   </select>
						   <label class="control-label col-xs-2 float" for="means">Moyens </label>
						   <select class="form-control col-xs-3" id="means" ng-model="freightCtrl.freightQuoteData.MeansID">
							  <option value="" selected style='display:none;'>    Select mean  </option>
							  <option ng-repeat="mean in freights.means" value="{{ mean.MeansID }}">{{ mean.Designation }}</option>
						   </select>
					   </div>
				   </div>
				   </div>
				</fieldset>
		    </form>
			<form role="form" novalidate  data-toggle="validator" class="form-verticale" style="display:{{freights.dispFormsTag}}">
		        <fieldset>
				   <div class="legend-header">
				    <h3>Origine & Designation Packet</h3>
				   </div>
				   <div class="form-group prev_overflox" id="pickup_setup">
				   <div class="control-group pieces-region">
					   <div class="controls form-inline">
						   <label class="control-label col-xs-2" for="service">packet origin </label>
						   <select class="form-control col-xs-3 float" id="service" ng-model="freightCtrl.freightQuoteData.consignorState">
							  <option value="" disabled selected style='display:none;'>Please select origin</option>
						      <option ng-repeat="state in freights.states()" value="{{ state.id }}">{{ state.nom_fr_fr }}</option>
						   </select>
						   <label class="control-label col-xs-2 float" for="means">Packet Designation </label>
						   <select class="form-control col-xs-3" id="means" ng-model="freightCtrl.freightQuoteData.consigneeState">
							  <option value="" disabled selected style='display:none;'>Please select origin</option>
						      <option ng-repeat="state in freights.states()" value="{{ state.id }}">{{ state.nom_fr_fr }}</option>
						   </select>
					   </div>
				   </div>
				   </div>
				</fieldset>
		    </form>
			
			<form role="form" novalidate data-toggle="validator" class="form-verticale" style="display:{{freights.dispFormsTag}}">
		        <fieldset>
				   <div class="legend-header">
				    <h3>Paramètre Packet</h3>
				   </div>
				   <div class="form-group prev_overflox"  ng-repeat="piece in freights.pieces()">
				      <div class="control-group  pieces-region">
					   <div class="controls" ng-switch="{{piece.bntadd}}">
					       <label class="control-label article_lab aline_left" for="articles">Articles </label>
					       <select class="form-control article_name  aline_left" id="articles" ng-model="piece.ArticleID" ng-change="freights.updateDetailsDisplay(piece)">
							 <option ng-repeat="article in freights.articles" value="{{ article.ArticleID }}">{{ article.Designation }}</option>
						   </select>
						   <label style="display:{{piece.displayed}}" class="control-label article_lab aline_left" for="pdesignation">Contenu </label>
						   <input style="display:{{piece.displayed}}" type="text" class="form-control article_name aline_left"  id="pdesignation" placeholder="votre piece" ng-model="piece.Designation"/>  
						   <button ng-switch-when="true" type="button" id="add_pieces" ng-click="freights.addAPiece()" class="btn btn-primary aline_left">add+</button>
                           <button ng-switch-when="false" type="button" id="add_removes" class="btn btn-primary aline_left" ng-click="freights.removeAPiece(piece)">supp</button>	
					   </div>
					  </div>
					   <div class="clear">
					   </div>
					   <div class="control-group pieces-region" style="display:{{piece.displayed}}">
					      <label class="control-label article_lab aline_left" for="weight">Poids </label>
					      <input type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" class="form-control small-number aline_left" id="weight"  ng-model="piece.Weight"/>
				          <label class="control-label article_lab aline_left" for="height">Longueur </label>
					      <input type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" class="form-control small-number aline_left" id="lenght"  ng-model="piece.lenght"/>
				          <label class="control-label article_lab aline_left aline_left" for="width">Largeur </label>
					      <input type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" class="form-control small-number aline_left" id="width"  ng-model="piece.width"/>
					      <label class="control-label article_lab aline_left" for="height">Hauteur </label>
					      <input type="number" ng-pattern="/^[0-9]+(\.[0-9]{1,2})?$/" step="0.01" class="form-control small-number aline_left" id="height"  ng-model="piece.height"/>			  
					   </div>
				  </div>
				</fieldset>
		    </form>
		
		  <div id="btn-Quickquote" style="display:{{freights.dispFormsTag}}">
			  <button  type="submit" ng-click="freights.makeQuotation(freightCtrl.freightQuoteData)" class="btn btn-primary">QUOTE & BOOK</button>
		  </div>
		</div>
	 </div>
	  <div class="col-md-2">
	  </div>
   </div>
   <div class="row">
   </div>
</div>