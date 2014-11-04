<?php
  if (!empty($projects)) {

  }
?>

<div class="row">
  <div class="large-6 columns large-centered">
    <h1 class="text-center"><?php echo $client[0]['company'] ?></h1>
  </div>
</div>

<?php $this->load->view('widgets/client-subnav');?>

    <div ng-app="projectApp" ng-controller="ProjectController">

    <div class="row">
  		<div class="medium-3 medium-centered columns text-center">
  			<div id="plus-button" class="svg-container">
  				<a ng-click="showProjectForm()" ng-model="pform" class="plus-button">
  					<svg version="1.1" viewBox="0 0 100 100" class="svg-content">
  					<path fill-rule="evenodd" clip-rule="evenodd" fill="#fff" d="M50,0C22.4,0,0,22.4,0,50s22.4,50,50,50s50-22.4,50-50S77.6,0,50,0
  						z M68.6,51.8H51.5v17.4c0,0.8-0.7,1.5-1.5,1.5s-1.5-0.7-1.5-1.5V51.8H30.6c-0.8,0-1.5-0.7-1.5-1.5s0.7-1.5,1.5-1.5h17.9V31.2
  						c0-0.8,0.7-1.5,1.5-1.5s1.5,0.7,1.5,1.5v17.6h17.1c0.8,0,1.5,0.7,1.5,1.5S69.4,51.8,68.6,51.8z"></path>
  					</svg>
  				</a>
  			</div>
  		</div>
  	</div>

    <div class="row">
      <div class="columns small-12">
           <hr>
      </div>
    </div>

    <div class="row" ng-include="getProjectForm()" ng-show="pform"></div>

    <!--<div class="row project" ng-repeat="prj in project_object | orderBy:'project_id':true" ng-include="getProjectTemplate()"></div>-->
    <div class="row project" ng-repeat="prj in project_object | orderBy:'project_id':true track by $index" ng-include="getProjectTemplate()"></div>

    <div class="row">
      <div class="small-12 medium-12 large-4 columns large-centered">
        <div id="revealModal" class="reveal-modal small" data-reveal>
          <div id="form-errors"></div>
          <div id="loadingImg"><img src="<?php echo base_url();?>assets/images/ajax-loader.gif" alt="loading" /></div>
          <div id="form-wrap">

            <div ng-include="getTaskTimer()"></div>

          </div>
        </div>
      </div>
    </div>
  </div>
