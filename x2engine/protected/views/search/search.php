<?php
/*********************************************************************************
 * The X2CRM by X2Engine Inc. is free software. It is released under the terms of 
 * the following BSD License.
 * http://www.opensource.org/licenses/BSD-3-Clause
 * 
 * X2Engine Inc.
 * P.O. Box 66752
 * Scotts Valley, California 95066 USA
 * 
 * Company website: http://www.x2engine.com 
 * Community and support website: http://www.x2community.com 
 * 
 * Copyright � 2011-2012 by X2Engine Inc. www.X2Engine.com
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * - Redistributions of source code must retain the above copyright notice, this 
 *   list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice, this 
 *   list of conditions and the following disclaimer in the documentation and/or 
 *   other materials provided with the distribution.
 * - Neither the name of X2Engine or X2CRM nor the names of its contributors may be 
 *   used to endorse or promote products derived from this software without 
 *   specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND 
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. 
 * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, 
 * INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, 
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, 
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF 
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE 
 * OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE.
 ********************************************************************************/

Yii::app()->clientScript->registerScript('contact-qtip', '
function refreshQtip() {
	$(".contact-name").each(function (i) {
		var contactId = $(this).attr("href").match(/\\d+$/);

		if(typeof contactId != null && contactId.length) {
			$(this).qtip({
				content: {
					text: "'.addslashes(Yii::t('app','loading...')).'",
					ajax: {
						url: yii.baseUrl+"/index.php/contacts/qtip",
						data: { id: contactId[0] },
						method: "get",
					}
				},
				style: {
				}
			});
		}
	});
}

$(function() {
	refreshQtip();
});
');
?>
<h1><?php echo Yii::t('app','Search Results'); ?></h1>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider' => $dataProvider,
	'baseScriptUrl'=>Yii::app()->request->baseUrl.'/themes/'.Yii::app()->theme->name.'/css/gridview',
	'columns' => array(
		array(
			'name' => Yii::t('app','Name'),
			'type' => 'raw',
			'value' => 'CHtml::link(CHtml::encode($data["name"]), "'.Yii::app()->request->baseUrl.'/index.php".$data["link"],$data["type"]=="Contact"?array("class"=>"contact-name"):"")', 
		),
		array(
			'name' => Yii::t('app','Type'),
			'type' => 'raw',
			'value' => '$data["type"]', 
		),
		array(
			'name' => Yii::t('app','Description'), 
			'type' => 'raw',
			'value' => 'Yii::app()->controller->truncateText(CHtml::encode($data["description"]),140)'
		),
        array(
			'name' => Yii::t('app','Assigned To'),
			'type' => 'raw',
			'value' => 'isset($data["assignedTo"])?$data["assignedTo"]:""', 
		),
	),
));
?>
