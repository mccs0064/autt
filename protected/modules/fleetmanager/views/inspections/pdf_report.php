<div class="row">
    <div class="col-xs-2">
        <img src="<?php echo Yii::app()->request->baseUrl; ?>/img/autium-header-logo-green.png" class="img-responsive">
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <h3>Inspection Report Detail</h3>
    </div>
</div>

<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-2 cell-bg">
            <p><strong>Report ID:</strong></p>
            <p>INS000-<?php echo $model->id;?></p>
        </div>
        <div class="col-xs-2 cell-bg">
            <p><strong>Vehicle:</strong></p>
            <p>
                <?php $vehicle=$model->vehicle;
                $driver=Driver::model()->findByPk($model->driver_id);
                ?>
                <?php echo $vehicle->make." - ".$vehicle->model." - ".$vehicle->vehicle_reg;?>
            </p>
        </div>
        <div class="col-xs-3 cell-bg">
            <p><strong>Date Submission:</strong></p>
            <p><?php echo date('d M Y',strtotime($model->submitted_date));?> (<?php echo date('h:i',strtotime($model->submitted_date));?>)
            </p>
        </div>
        <div class="col-xs-3 cell-bg">
            <p><strong>Driver Name:</strong></p>
            <?php
            $driver_str=$model->user_type=='Fleet Manager'?'Fleet Manager':$driver->autium_id." : ".$driver->full_name;
            ?>
            <p><?php echo $driver_str;?>
            </p>
        </div>
        <div class="col-xs-2 cell-bg" style="border-right: 1px solid">
            <p><strong>Defects:</strong></p>
            <p><?php echo DailyInspectionReport::getTotalDefects($model->id);?>
            </p>
        </div>

    </div>
</div>

<br/><br/>
<div>
    <?php $items=$model->inspectionReportItems()->getData();?>
    <div class="table-responsive" id="accidents-grid">
        <div class="summary"></div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th id="accidents-grid_cid">Defect  Id</th>
                <th id="accidents-grid_cdefect_name">Defect  Name</th>
                <th id="accidents-grid_cdefect">Defect</th>
                <th id="accidents-grid_cnotes">Notes</th></tr>
            </thead>
            <tbody>
            <?php foreach($items as $item):?>
            <tr class="odd">
                <td class="v-align-middle">DEF-000<?php echo $item->id;?></td>
                <td class="v-align-middle"><?php echo $item->name;?></td>
                <td class="v-align-middle <?php echo $item->inspected=='1'?'bg-red':'';?>"><?php echo $item->inspected=='1'?'Yes':'No';?></td>
                <td class="v-align-middle"><?php echo $item->notes;?></td>
            </tr>
<?php endforeach;?>
           </tbody>
        </table>
    </div>

</div>
<?php $this->renderPartial('_styling');?>
<style>
    .table thead tr th
    {
        font-size: 10px !important;
    }
    .table tbody tr td
    {
        font-size: 10px !important;
    }
    p
    {
        font-size: 10px !important;
    }
    .v-align-middle
    {
        padding: 5px !important;
    }
</style>