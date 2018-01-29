<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/onoff.css"
      media="screen, projection"/>
<div class="table-responsive" id="fleet-manager-driver-grid">
    <div class="summary">Template Loaded: <?php echo $template->template_name;?></div>
    <table class="table table-hover table-condensed">
        <thead>
        <tr>
            <th>Defect ID</th>
            <th>Defect Name</th>
            <th>Notes</th>
            <th>Defect Found</th>
        </tr>
        </thead>
        <tbody id="defect-rows">
        <?php if(!empty($templateItems)):
            foreach ($templateItems as $item):
                $this->renderPartial('_defectitem',array('id'=>$item['id'],'name'=>$item['name'],'visible'=>$item['visible'],'db_id'=>'1'));
            endforeach;
        endif;?>
        </tbody>
    </table>
</div>
