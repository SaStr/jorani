<div class="row-fluid">
    <div class="span12">
        
<h1>Balance of leaves</h1>

<div class="row-fluid">
    <div class="span4">
        <label for="txtEntity">Select the entity</label>
        <div class="input-append">
        <input type="text" id="txtEntity" name="txtEntity" />
        <button id="cmdSelectEntity" class="btn btn-primary">Select</button>
        </div>
    </div>
    <div class="span8">
        <div class="pull-right">    
            <label class="checkbox">
                <input type="checkbox" id="chkIncludeChildren" checked /> Include sub-departments
            </label>
            &nbsp;
            <button class="btn btn-primary" id="cmdLaunchReport"><i class="icon-file icon-white"></i>&nbsp; Launch</button>
            <button class="btn btn-primary" id="cmdExportReport"><i class="icon-file icon-white"></i>&nbsp; Export</button>
        </div>
    </div>
</div>

<div class="row-fluid">
    <div class="span6">&nbsp;</div>
    <div class="span3">
        
    </div>
</div>


<div id="reportResult"></div>

<div class="row-fluid">
	<div class="span12">&nbsp;</div>
</div>

<div id="frmSelectEntity" class="modal hide fade">
    <div class="modal-header">
        <a href="#" onclick="$('#frmSelectEntity').modal('hide');" class="close">&times;</a>
         <h3>Select an entity</h3>
    </div>
    <div class="modal-body" id="frmSelectEntityBody">
        <img src="<?php echo base_url();?>assets/images/loading.gif">
    </div>
    <div class="modal-footer">
        <a href="#" onclick="select_entity();" class="btn secondary">OK</a>
        <a href="#" onclick="$('#frmSelectEntity').modal('hide');" class="btn secondary">Cancel</a>
    </div>
</div>

<script type="text/javascript">

var entity = -1; //Id of the selected entity
var text; //Label of the selected entity

function select_entity() {
    entity = $('#organization').jstree('get_selected')[0];
    text = $('#organization').jstree().get_text(entity);
    $('#txtEntity').val(text);
    $("#frmSelectEntity").modal('hide');
}

$(document).ready(function() {
    $("#frmSelectEntity").alert();
    
    $("#cmdSelectEntity").click(function() {
        $("#frmSelectEntity").modal('show');
        $("#frmSelectEntityBody").load('<?php echo base_url(); ?>organization/select');
    });
    
    $('#cmdExportReport').click(function() {
        var rtpQuery = '<?php echo base_url();?>reports/balance/export';
        if (entity != -1) {
            rtpQuery += '?entity=' + entity;
        } else {
            rtpQuery += '?entity=0';
        }
        if ($('#chkIncludeChildren').prop('checked') == true) {
            rtpQuery += '&children=true';
        } else {
            rtpQuery += '&children=false';
        }
        document.location.href = rtpQuery;
    });
    
    $('#cmdLaunchReport').click(function() {
        var ajaxQuery = '<?php echo base_url();?>reports/balance/execute';
        if (entity != -1) {
            ajaxQuery += '?entity=' + entity;
        } else {
            ajaxQuery += '?entity=0';
        }
        if ($('#chkIncludeChildren').prop('checked') == true) {
            ajaxQuery += '&children=true';
        } else {
            ajaxQuery += '&children=false';
        }
        $('#reportResult').html("<img src='<?php echo base_url();?>assets/images/loading.gif' />");
        
        $.ajax({
          url: ajaxQuery
        })
        .done(function( data ) {
              $('#reportResult').html(data);
        });

    });
});
</script>
