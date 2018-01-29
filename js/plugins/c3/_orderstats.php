<?php
$standard_percent = 0;
if ($total_orders) {
    $standard_percent = ($standard_orders / $total_orders) * 100;
}

$custom_percent = 0;
$inactive_jobs = 0;

if ($total_orders) {
    $custom_percent = ($custom_orders / $total_orders) * 100;
}
?>

<div class="row graph-row">
    <div class="left-column">
        <div>
            <h3>Order Stats</h3>
        </div>
        <div class="ring">
            <div class="rounded-skill" data-scale-color="false" data-line-width="5" data-bar-color="<?php echo Yii::app()->commons->getRandomColor(); ?>" data-size="125" data-percent="<?php echo ($total_orders) ? '100' : '0'; ?>" data-width="5" data-animate="3000">
                <span><?php echo CHtml::encode($total_orders); ?></span>
            </div>
        </div>
        <div class="ring">
            <div class="rounded-skill" data-scale-color="false" data-line-width="5" data-bar-color="<?php echo Yii::app()->commons->getRandomColor(); ?>" data-size="125" data-percent="<?php echo $standard_percent; ?>" data-width="5" data-animate="3000">
                <span><?php echo CHtml::encode($standard_orders); ?></span>
            </div>
        </div>
        <div class="ring">
            <div class="rounded-skill" data-scale-color="false" data-line-width="5" data-bar-color="<?php echo Yii::app()->commons->getRandomColor(); ?>" data-size="125" data-percent="<?php echo $custom_percent; ?>" data-width="5" data-animate="3000">
                <span><?php echo CHtml::encode($custom_orders); ?></span>
            </div>
        </div>

    </div>
    <div class="right-column">
        <div>
            <h3>Users</h3>
        </div>
        <div class="ring" style="width:100%;">
            <div class="rounded-skill" data-scale-color="false" data-line-width="5" data-bar-color="<?php echo Yii::app()->commons->getRandomColor(); ?>" data-size="125" data-percent="<?php echo ($users) ? '100' : '0'; ?>" data-width="5" data-animate="3000">
                <span><?php echo CHtml::encode($users); ?></span>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

