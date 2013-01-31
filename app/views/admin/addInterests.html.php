<?php
		
?>

<div id="interestsWrapper" class="wrapper">
<legend> Manage Interests </legend>

	<ul id="myTab" class="nav nav-tabs">
    		<li class="" id="managehowsLink"><a href="#managehows" data-toggle="tab" id="managehowstab">How</a></li>
            <li class="active" id="managewhatsLink"><a href="#managewhats" data-toggle="tab" id="managewhatstab">What</a></li>
    </ul>
    
    <div id="myTabContent" class="tab-content">
              <div class="tab-pane fade " id="managehows">
              	<div style="margin-bottom : 10px;"><a href="#createHowModal" title="Create New How" data-toggle="modal" data-target="#createHowModal" id="createHow" class="btn"> <i class="icon-plus-sign"> </i> New How </a></div>
              	<div class="well" id="managehowscontent"></div>
              </div>
              <div class="tab-pane fade in active" id="managewhats">
              	<div style="margin-bottom : 10px;">
              		<a href="#createWhatModal" title="Create New What" data-toggle="modal" data-target="#createWhatModal" id="createWhat" class="btn"> <i class="icon-plus-sign"> </i> New What </a>
              		
              	</div>
              	<div class="well" id="managewhatscontent"></div>
              </div>
              
              <div class="tab-pane fade" id="managewhichs">
              	<div style="margin-bottom : 10px;">
              		<ul class="breadcrumb" id="manageWhichsBreadcrumbs" style="margin-bottom: 5px;">
              			<li id="manageWheresBreadcrumb" class="active"><a id="backToWhats" title="Back To Whats" class="" href="/admin/managecategories/whats"><i class="icon-circle-arrow-left"></i> Whats</a> / <?php echo $args[1]; ?> / Whichs</li>
            		</ul>
              	
              		<a href="#createWhichModal" title="Create New Which" data-toggle="modal" data-target="#createWhichModal" id="createWhich" class="btn"> <i class="icon-plus-sign">  </i> New Which</a>
              		
              	</div>
              	<div class="well" id="managewhichscontent"></div>
              </div>
              
              <div class="tab-pane fade" id="managewheres">
              	<div style="margin-bottom : 10px;">
              		<ul class="breadcrumb" id="manageWheresBreadcrumbs" style="margin-bottom: 5px;">
              			<li id="manageWheresBreadcrumb" class="active"><a id="backToWhats" title="Back To Whats" class="" href="/admin/managecategories/whats"><i class="icon-circle-arrow-left"></i> Whats </a> / <?php echo $args[1]; ?> / Wheres</li>
            		</ul>
              	
              		<a href="#createWhereModal" title="Create New Where" data-toggle="modal" data-target="#createWhereModal" id="createWhere" class="btn"> <i class="icon-plus-sign"> </i> New Where  </a>
              		
              	</div>
              	<div class="well" id="managewherescontent"></div>
              </div>
    </div> <!-- end myTabContent div -->
    
    <input type="hidden" id="editId" />
    <input type = "hidden" id="enabled" value = <?php if(count($args) == 1) echo $args[0]; else foreach($args as $arg) echo $arg."/"; ?> />
    
</div> <!-- end interestsWrapper div -->

<!-- Modal create Hows -->
<div id="createHowModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Create New How</h4>
  </div>
  <div class="modal-body">
  <center>
    <form id="frmNewHow" class="frmNewHow">
    				<input type="text" id="txtHowName" class="txtHowName" placeholder="Enter How Name" style="display : block;" />
    				<input type="submit" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" value="Create" id="createHowSubmit" />
    </form>
  </div>
  <div class="modal-footer">
  <div id="alertCreateHow"></div>
  </div>
</div>


<!-- Modal create Whats -->
<div id="createWhatModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Create New What</h4>
  </div>
  <div class="modal-body">
  <center>
    <form id="frmNewWhat" class="frmNewWhat">
    				<input type="text" id="txtWhatName" class="txtWhatName" placeholder="Enter What Name" style="display : block;" />
    				<input type="submit" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" value="Create" id="createWhatSubmit" />
    </form>
  </div>
  <div class="modal-footer">
  	 <div id="alertCreateWhat"></div>
  </div>
</div>

<!-- Modal edit Hows -->
<div id="editHowModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Rename How</h4>
  </div>
  <div class="modal-body">
  <center>
    <form id="frmEditHow" class="frmEditHow">
    				<input type="text" id="txtEditHowName" class="txtEditHowName" placeholder="Enter How Name" style="display : block;" />
    				<input type="submit" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" value="Submit" id="editHowSubmit" />
    </form>
  </div>
  <div class="modal-footer">
  <div id="alertEditHow"></div>
  </div>
</div>

<!-- Modal edit Whats -->
<div id="editWhatModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Rename What</h4>
  </div>
  <div class="modal-body">
  <center>
    <form id="frmEditWhat" class="frmEditWhat">
    				<input type="text" id="txtEditWhatName" class="txtEditWhatName" placeholder="Enter What Name" style="display : block;" />
    				<input type="submit" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" value="Submit" id="editWhatSubmit" />
    </form>
  </div>
  <div class="modal-footer">
  	 <div id="alertEditWhat"></div>
  </div>
</div>


<!-- Modal create Whichs -->
<div id="createWhichModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Create New Which</h4>
  </div>
  <div class="modal-body">
  <center>
    <form id="frmNewWhich" class="frmNewWhich">
    				<input type="text" id="txtWhichName" class="txtWhichName" placeholder="Enter Which Name" style="display : block;" />
    				<input type="submit" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" value="Create" id="createWhichSubmit" />
    </form>
  </div>
  <div class="modal-footer">
  <div id="alertCreateWhich"></div>
  </div>
</div>

<!-- Modal edit Whichs -->
<div id="editWhichModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Rename Which</h4>
  </div>
  <div class="modal-body">
  <center>
    <form id="frmEditWhich" class="frmEditWhich">
    				<input type="text" id="txtEditWhichName" class="txtEditWhichName" placeholder="Enter Which Name" style="display : block;" />
    				<input type="submit" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" value="Submit" id="editWhichSubmit" />
    				<input type="hidden" id="oldWhich" />
    </form>
  </div>
  <div class="modal-footer">
  	 <div id="alertEditWhich"></div>
  </div>
</div>

<!-- Modal create Wheres -->
<div id="createWhereModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Create New Where</h4>
  </div>
  <div class="modal-body">
  <center>
    <form id="frmNewWhere" class="frmNewWhere">
    				<input type="text" id="txtWhereName" class="txtWhereName" placeholder="Enter Where Name" style="display : block;" />
    				<input type="submit" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" value="Create" id="createWhereSubmit" />
    </form>
  </div>
  <div class="modal-footer">
  <div id="alertCreateWhere"></div>
  </div>
</div>

<!-- Modal edit Wheres -->
<div id="editWhereModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 id="myModalLabel">Rename Where</h4>
  </div>
  <div class="modal-body">
  <center>
    <form id="frmEditWhere" class="frmEditWhere">
    				<input type="text" id="txtEditWhereName" class="txtEditWhereName" placeholder="Enter Where Name" style="display : block;" />
    				<input type="submit" class="btn btn-primary" data-dismiss="modal" aria-hidden="true" value="Submit" id="editWhereSubmit" />
    				<input type="hidden" id="oldWhere" />
    </form>
  </div>
  <div class="modal-footer">
  	 <div id="alertEditWhere"></div>
  </div>
</div>