<?php

?>

<div id="interestsWrapper" class="wrapper">
<legend> Manage Interests </legend>

	<ul id="myTab" class="nav nav-tabs">
    		<li class="active"><a href="#managehows" data-toggle="tab" id="managehowstab">How</a></li>
            <li class=""><a href="#managewheres" data-toggle="tab" id="managewherestab">Where</a></li>
    </ul>
    
    <div id="myTabContent" class="tab-content">
              <div class="tab-pane fade in active" id="managehows">
              	<div style="margin-bottom : 10px;"><a href="#createHowModal" title="Create New How" data-toggle="modal" data-target="#createHowModal" id="createHow" class="btn"> <i class="icon-plus-sign"> </i> </a></div>
              	<div class="well" id="managehowscontent"></div>
              </div>
              <div class="tab-pane fade" id="managewheres">
              	<div style="margin-bottom : 10px;"><a href="#createWhereModal" title="Create New Where" data-toggle="modal" data-target="#createWhereModal" id="createWhere" class="btn"> <i class="icon-plus-sign"> </i> </a></div>
              	<div class="well" id="managewherescontent"></div>
              </div>
    </div>
    <input type="hidden" id="editId" />
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
  <div id="alertCreatHow"></div>
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
    				<input type="submit" class="btn btn-success" data-dismiss="modal" aria-hidden="true" value="Create" id="createWhereSubmit" />
    </form>
  </div>
  <div class="modal-footer">
  	 <div id="alertCreatWhere"></div>
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
    				<input type="submit" class="btn btn-success" data-dismiss="modal" aria-hidden="true" value="Submit" id="editWhereSubmit" />
    </form>
  </div>
  <div class="modal-footer">
  	 <div id="alertEditWhere"></div>
  </div>
</div>

