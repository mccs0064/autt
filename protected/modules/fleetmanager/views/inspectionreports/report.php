<div class="head-container">
    <h3 class="report-head">Vehicle Inspection Report (<?php echo $model->vehicle->vehicle_reg;;?>)</h3>
</div>
<table>
    <tr>
        <td><p class="label">Registration Number:</p></td>
        <td><?php echo $model->vehicle->vehicle_reg;;?></td>
    </tr>
    <tr>
        <td><p class="label">Driver:</p></td>
        <td><p><?php echo $model->driver->full_name;?></p></td>
    </tr>
    <tr>
        <td><p class="label">Inspection Status:</p></td>
        <td><?php echo $model->status;?></td>
    </tr>

    <tr>
        <td><p class="label">Due Date:</p></td>
        <td><p><?php echo date('jS F,Y H:i:s A',strtotime($model->due_date));?></p></td>
    </tr>
    <tr>
        <td><p class="label">Submitted Date:</p></td>
        <td><p><?php echo date('jS F,Y H:i:s A',strtotime($model->submitted_date));?></p></td>
    </tr>

    <?php if($model->inspection_type=='Quartlery'):?>
        <tr>
            <td><p class="label">Notification Date:</p></td>
            <td><p><?php echo date('jS F,Y H:i:s A',strtotime($model->notification_date));?></p></td>
        </tr>
    <?php endif;?>
    <?php if(!empty($model->notes)):?>
    <tr>
        <td><p class="label">Inspection Notes:</td>
        <td><?php echo $model->notes;?></p></td>
    </tr>
    <?php endif;?>
    <?php if(!empty($model->image1)):?>
        <tr>
            <td class="label"><p>Inspection Image 1:</p></td>
            <td>
                <img  class="img-responsive" src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/<?php echo $model['directory_name']; ?>/<?php echo $model['image1']; ?>"/>
            </td>
        </tr>
    <?php endif;?>
    <?php if(!empty($model->image2)):?>
        <tr>
            <td><p class="label">Inspection Image 2:</p></td>
            <td>
                <img  class="img-responsive" src="<?php echo Yii::app()->request->baseUrl; ?>/uploads/<?php echo $model['directory_name']; ?>/<?php echo $model['image2']; ?>"/>
            </td>
        </tr>
    <?php endif;?>
</table>

<div>
    <div class="row">
    <?php
    $checklistItems = $model->inspectionChecklists;
    if (!empty($checklistItems)):
        foreach ($checklistItems as $item):?>
            <div class="col-xs-12">
                <div class="row">
                    <span class="col-xs-4"><?php echo $item['item_name']; ?></span>
                    <span class="col-xs-4">
                        <?php if ($item['is_done']): ?>
                           <span>Inspection Completed</span>
                        <?php else: ?>
                            <span>Inspection Not Done</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>

        <?php endforeach;
    endif;
    ?>

</div>
</div>

<style>
    body
    {
        font-family: 'Arial';
        font-size: 15px;
    }
.label
{
    width: 200px;
    padding: 10px 10px;


}
    img
    {
        max-width: 300px;
        max-height: 300px;
        margin-bottom:20px;
    }
    .head-container
    {
        text-align: center;
    }
    .report-head
    {
        font-weight: bold;
        text-transform: uppercase;
    }
</style>