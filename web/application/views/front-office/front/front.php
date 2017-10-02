<div class="row">
      <div class="col-md-2"> 
	  </div>
	  <div class="col-md-8">
	     <div id="pickup-stapes" ng-controller="packetController">
		   <ul>
		       <li title="1" pk-stapes>Pickup</li>
		       <li title="2" pk-stapes>
			     <em>1</em>
				 <span>Votre<br/> colis</>
			   </li>
			   <li title="3" pk-stapes>
			     <em>2</em>
				 <span>Votre<br/> envoi</>
			   </li>
			   <li title="4" pk-stapes>
			      <em>3</em>
				  <span>Récapitulatif</>
			   </li>
		   </ul>
		 </div>
	     <div id="pk-left" ng-view></div>
		 <div id="pk-right">
		    <div id="quotation_summary" ng-controller="packetController">
			    <div>
				  <span class="ttle-sum">Votre carte : </span><ngcart-summary templateUrl="<?php echo base_url(); ?>templates/ngCart/summary.html"></ngcart-summary>
				</div>
				<div>
				  <span class="ttle-sum"><span><ngcart-checkout service="paypal" templateUrl="<?php echo base_url(); ?>templates/ngCart/checkout.html" settings="packets.settings"></ngcart-checkout> 
				</div>
		  </div>
	  </div>
	  <div class="col-md-2">
	  </div>
</div>
<div class="row">
</div>
</div> 

