<?php include('scripts.php'); ?>
<style type="text/css">

.clear {
    clear: both;
}
.tree-genealogy {
    height: 700px;
    overflow: auto;
    width: 600px;
}
.controller-node-con {
    min-width: 413px;
}
.tree-controller, .tree-controller-in {
    height: 48px;
    width: 28px;
}
.tree-controller-dash, .tree-controller-dashplus, .tree-controller-dashminus {
    background: url("http://www.abfxtrader.com/ablive/nimages/network/gentree/images/leaf_h.png") repeat-x scroll 0 24px transparent;
    float: left;
    margin-left: 16px;
    width: 12px;
}
.tree-controller-wrap, .tree-controller-l-wrap {
    margin-left: 28px;
}
.tree-controller-wrap {
    background: url("http://www.abfxtrader.com/ablive/nimages/network/gentree/images/leaf.png") repeat-y scroll 16px 0 transparent;
}
.tree-controller-tplus-line, .tree-controller-lplus-line, .tree-controller-tminus-line, .tree-controller-lminus-line, .tree-controller-t-line, .tree-controller-l-line {
    float: left;
    margin-left: 16px;
    width: 12px;
}
.tree-controller-lplus-line, .tree-controller-lminus-line, .tree-controller-l-line {
    background: url("http://www.abfxtrader.com/ablive/nimages/network/gentree/images/leaf.png") repeat-y scroll 0 0 transparent;
    float: left;
    height: 24px;
}
.tree-controller-lplus-right, .tree-controller-tplus-right, .tree-controller-tminus-right, .tree-controller-lminus-right, .tree-controller-l-right, .tree-controller-t-right {
    background: url("http://www.abfxtrader.com/ablive/nimages/network/gentree/images/leaf_h.png") repeat-x scroll 0 24px transparent;
    float: left;
    width: 12px;
}
.tree-controller-dash img, .tree-controller-dashplus img, .tree-controller-dashminus img, .tree-controller-tminus-right img, .tree-controller-lminus-right img, .tree-controller-tplus-right img, .tree-controller-lplus-right img {
    margin-left: -4px;
}
img.tree-minus-button, img.tree-plus-button {
    margin-top: 20px;
}
img.tree-minus-button:hover, img.tree-plus-button:hover {
    cursor: pointer;
}
.node-info-raw {
    height: 48px;
    overflow: hidden;
    width: 385px;
}
</style>

<!--<script type="text/javascript" language="javascript">
    $(function() {
        $("#sponsorTree").treeview({
            url: "/member/manipulateSponsorTree_old"
        });
    });
</script>-->

<div class="ewallet_li">
	<a target="_self" class="navcontainer" href="/member/sponsorTree" style="color: rgb(134, 197, 51);">
        <?php echo __('Sponsor Genealogy'); ?>
    </a>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
    <a target="_self" class="navcontainer" href="/member/placementTree" style="color: rgb(0, 93, 154);">
        <?php echo __('Placement Genealogy'); ?>
    </a>
    &nbsp;&nbsp;
    <img src="/images/arrow_blue_single_tab.gif">
    &nbsp;&nbsp;
    <a target="_self" class="navcontainer" href="/member/placementTree?p=stat" style="color: rgb(0, 93, 154);">
        <?php echo __('Downline Stats'); ?>
    </a>
</div>

<div class="clear"></div>
<br>
<span class="txt_title"><?php echo __('Genealogy for your Member ID') . ": <b>" . $distinfo->getDistributorCode(); ?></b></span>

<?php if ($sf_flash->has('successMsg')): ?>
    <div class="ui-widget">
        <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
             class="ui-state-highlight ui-corner-all">
            <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                          class="ui-icon ui-icon-info"></span>
                <strong><?php echo $sf_flash->get('successMsg') ?></strong></p>
        </div>
    </div>
    <?php endif; ?>
<?php if ($sf_flash->has('errorMsg')): ?>
    <div class="ui-widget">
        <div style="margin-top: 10px; margin-bottom: 10px; padding: 0 .7em;"
             class="ui-state-error ui-corner-all">
            <p style="margin: 10px"><span style="float: left; margin-right: .3em;"
                                          class="ui-icon ui-icon-alert"></span>
                <strong><?php echo $sf_flash->get('errorMsg') ?></strong></p>
        </div>
    </div>
<?php endif; ?>

<?php echo form_tag('member/sponsorTree', 'id=sponsorForm') ?>

<br>
<strong><?php echo __('Search By Username') ?></strong>&nbsp;:&nbsp; <input size="20" name="fullName" id="txtFullName" value="<?php echo $fullName?>">&nbsp;<button><?php echo __('Search') ?></button>
</form>

<br>

<link rel='stylesheet' type='text/css' media='screen' href='/css/network/gentree.css'/>

<script type="text/javascript">
$(document).ready(function(){
	$('img.tree-minus-button').live('click', function(){
		$(this).attr('class', 'tree-plus-button');
		var nodeId = $(this).parent().parent().next().attr('id').replace(/^node\-id\-/, '');
		$('#node-wrapper-'+nodeId).slideUp(200);
		$(this).attr('src', '/css/network/plus.png');
	});

	$('img.tree-plus-button').live('click', function(){
		$(this).attr('class', 'tree-minus-button');
		var nodeId = $(this).parent().parent().next().attr('id').replace(/^node\-id\-/, '');
		if($('#node-wrapper-'+nodeId).attr('class').match(/ajax\-more/)){
			$('#node-wrapper-'+nodeId).removeClass('ajax-more');
			ajaxLoadNode(nodeId);
		}
		$('#node-wrapper-'+nodeId).slideDown(200);
		$(this).attr('src', '/css/network/minus.png');
	});

	function ajaxLoadNode(nodeId){
		$('#node-wrapper-'+nodeId).html('<img src="/css/network/spinner.gif">');
		$.ajax({
			url: '/member/manipulateSponsorTree?root='+nodeId,
			type: 'post',
			dataType: 'html',
			error: function(){
				debug('error loading nodes for ' + nodeId);
			},
			success: function(data){
				$('#node-wrapper-'+nodeId).html(data);
			},
			complete: function(){
			}
		});
	}

	function debug(str){
		alert(str);
	}
});
</script>
<div class="tree-genealogy">
    <?php
        $treeLine = "tree-controller-lplus-line";
        $treeLine2 = "tree-controller-lplus-right";
        $treeLineNoChild = "tree-controller-t-line";
        $treeLineNoChild2 = "tree-controller-t-right";
        $treeControllerWrap = "tree-controller-wrap";
        $img = "<img class='tree-plus-button' src='/css/network/plus.png'>";
        if ($idx == $count) {
            $treeLineNoChild = "tree-controller-l-line";
            $treeLineNoChild2 = "tree-controller-l-right";
            $treeControllerWrap = "tree-controller-l-wrap";
        }

        if ($hasChild) {
        } else {
            $img = "";
            $treeLine = $treeLineNoChild;
            $treeLine2 = $treeLineNoChild2;
        }
    ?>
    <div class="<?php echo $treeControllerWrap;?>">
        <div class="controller-node-con">
            <div class="tree-controller <?php echo $treeLine;?>">
                <div class="tree-controller-in <?php echo $treeLine2;?>">
                    <?php echo $img; ?>
                </div>
            </div>
            <div id="node-id-<?php echo $distinfo->getDistributorId();?>" class="node-info-raw">
                <div class="node-info">
                    <span class="user-rank"><img src="/css/network/<?php echo $headColor; ?>_head.png"></span>
                    <span class="user-id"><?php echo $distinfo->getDistributorCode(); ?></span>
                    <span class="user-joined"><?php echo __('Joined'); ?> <?php echo date('Y-m-d', strtotime($distinfo->getActiveDatetime())); ?></span>
                    <span class="user-joined"><?php echo __($distinfo->getRankCode()); ?></span>
                </div>
            </div>
        </div>
        <?php
        if ($hasChild) {
        ?>
        <div class=" ajax-more" id="node-wrapper-<?php echo $distinfo->getDistributorId();?>"></div>
        <?php } ?>
    </div>
</div>