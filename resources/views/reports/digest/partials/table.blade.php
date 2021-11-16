<?php

$City=['Москва','Санкт-Петербург','Казань','Чебоксары','Нижний Новгород'];
$Table_one=[];
$Table_two=[];
$Table_three = [];

foreach ($report['search']->items as $record){
	foreach ($City as $town){
		if($town == $record['city']){
			$Table_one[$town][] = $record;
		}
	}
}


foreach ($report['media']->items as $record){
	foreach ($City as $town){
		if($town == $record['city']){
			$Table_two[$town][] = $record;
		}
	}
}


foreach ($City as $town){
	$OverAll['leads'] = 0;
	$OverAll['activations'] = 0;
	$OverAll['cost'] = 0;
	$OverAll['cpl'] = 0;
	$OverAll['cpa'] = 0;
	$OverAll['coverage']=0;
	$OverAll['to_click']=0;
	$OverAll['to_lead']=0;
	$OverAll['to_activ']=0;

	if(isset($Table_one[$town])){
		for($i =0,$iMax=count($Table_one[$town]); $i < $iMax; $i++){
			$OverAll['leads']=$OverAll['leads']+$Table_one[$town][$i]['leads'];
			$OverAll['activations']=$OverAll['activations']+$Table_one[$town][$i]['activations'];
			$OverAll['cost']=$OverAll['cost']+$Table_one[$town][$i]['cost'];
			$OverAll['cpl']=$OverAll['cpl']+$Table_one[$town][$i]['cpl'];
			$OverAll['cpa']=0;
			$OverAll['coverage']=$OverAll['coverage']+$Table_one[$town][$i]['coverage'];
			$OverAll['to_click']=$OverAll['to_click']+$Table_one[$town][$i]['clicks'];
			$OverAll['to_lead']=$OverAll['to_lead']+$Table_one[$town][$i]['leads'];
			$OverAll['to_activ']=$OverAll['to_activ']+$Table_one[$town][$i]['activations'];
		}
	}
	$Table_one[$town]['overall']['leads']=$OverAll['leads'];
	$Table_one[$town]['overall']['activations']=$OverAll['activations'];
	$Table_one[$town]['overall']['cost']=$OverAll['cost'];
	$Table_one[$town]['overall']['cpl']=$OverAll['cpl'];
	$Table_one[$town]['overall']['cpa']=$OverAll['cpa'];
	$Table_one[$town]['overall']['coverage']=$OverAll['coverage'];
	$Table_one[$town]['overall']['to_click']=$OverAll['to_click'];
	$Table_one[$town]['overall']['to_lead']=$OverAll['to_lead'];
	$Table_one[$town]['overall']['to_activ']=$OverAll['to_activ'];

    $Table_one['Gtotal']['leads']=0;
    $Table_one['Gtotal']['activations']=0;
    $Table_one['Gtotal']['cost']=0;
    $Table_one['Gtotal']['cpl']=0;
    $Table_one['Gtotal']['cpa']=0;
    $Table_one['Gtotal']['coverage']=0;
    $Table_one['Gtotal']['to_click']=0;
    $Table_one['Gtotal']['to_lead']=0;
    $Table_one['Gtotal']['to_active']=0;

	if(isset($Table_two[$town])){

		for($t =0,$iMax=count($Table_two[$town]); $t < $iMax; $t++){
			$OverAll['leads']=$OverAll['leads']+$Table_two[$town][$t]['leads'];
			$OverAll['activations']=$OverAll['activations']+$Table_two[$town][$t]['activations'];
			$OverAll['cost']=$OverAll['cost']+$Table_two[$town][$t]['cost'];
			$OverAll['cpl']=$OverAll['cpl']+$Table_two[$town][$t]['cpl'];
			$OverAll['cpa']=0;
			$OverAll['coverage']=$OverAll['coverage']+$Table_two[$town][$t]['coverage'];
			$OverAll['to_click']=$OverAll['to_click']+$Table_two[$town][$t]['clicks'];
			$OverAll['to_lead']=$OverAll['to_lead']+$Table_two[$town][$t]['leads'];
			$OverAll['to_activ']=$OverAll['to_activ']+$Table_two[$town][$t]['activations'];
		}
	}
	$Table_two[$town]['overall']['leads']=$OverAll['leads']-$Table_one[$town]['overall']['leads'];
	$Table_two[$town]['overall']['activations']=$OverAll['activations']-$Table_one[$town]['overall']['activations'];
	$Table_two[$town]['overall']['cost']=$OverAll['cost']-$Table_one[$town]['overall']['cost'];
	$Table_two[$town]['overall']['cpl']=0;
	$Table_two[$town]['overall']['cpa']=0;
	$Table_two[$town]['overall']['coverage']=$OverAll['coverage']-$Table_one[$town]['overall']['coverage'];
	$Table_two[$town]['overall']['to_click']=$OverAll['to_click']-$Table_one[$town]['overall']['to_click'];
	$Table_two[$town]['overall']['to_lead']=$OverAll['to_lead']-$Table_one[$town]['overall']['to_lead'];
	$Table_two[$town]['overall']['to_activ']=$OverAll['to_activ']-$Table_one[$town]['overall']['to_activ'];

    $Table_two['Gtotal']['leads']=0;
    $Table_two['Gtotal']['activations']=0;
    $Table_two['Gtotal']['cost']=0;
    $Table_two['Gtotal']['cpl']=0;
    $Table_two['Gtotal']['cpa']=0;
    $Table_two['Gtotal']['coverage']=0;
    $Table_two['Gtotal']['to_click']=0;
    $Table_two['Gtotal']['to_lead']=0;
    $Table_two['Gtotal']['to_active']=0;

    $Table_three['Gtotal']['leads']=0;
    $Table_three['Gtotal']['activations']=0;
    $Table_three['Gtotal']['cost']=0;
    $Table_three['Gtotal']['cpl']=0;
    $Table_three['Gtotal']['cpa']=0;
    $Table_three['Gtotal']['coverage']=0;
    $Table_three['Gtotal']['to_click']=0;
    $Table_three['Gtotal']['to_lead']=0;
    $Table_three['Gtotal']['to_active']=0;


}

?>



<table class="table table-bordered table-sm table-striped report-table context mb-3 mt-2"  style="font-size: small;
white-space: nowrap;display: none ">
	<thead align="center">
		<tr>
			<th>&nbsp;</th>
			<th colspan="8" >Контекст</th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th colspan="5" style="background-color: #dbe9d5" >KPI</th>
			<th colspan="3" style="background-color: #f0cecd" >Конверсии</th>
		</tr>
		<tr>
			<th>&nbsp;</th>
			<th  style="background-color: #dbe9d5">Лиды</th>
			<th  style="background-color: #dbe9d5">Активации</th>
			<th  style="background-color: #dbe9d5">Затраты</th>
			<th  style="background-color: #dbe9d5">CPL</th>
			<th  style="background-color: #dbe9d5">CPA</th>
			<th style="background-color: #f0cecd">Показы в клики</th>
			<th style="background-color: #f0cecd">Клики в лиды</th>
			<th style="background-color: #f0cecd">Лиды в Акт</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($City as $town):?>
	<tr>
		<td style="background-color: #d1e2f1">
			<?=$town?>
		</td>
		<td align="center">
            <?php echo($Table_one[$town]['overall']['leads']);
                  $Table_one['Gtotal']['leads']=$Table_one['Gtotal']['leads']+$Table_one[$town]['overall']['leads'];
                  ?> </td>
		<td align="center"><?php
            echo($Table_one[$town]['overall']['activations']);
            $Table_one['Gtotal']['activations']=$Table_one['Gtotal']['activations']+$Table_one[$town]['overall']['activations'];
            ?></td>
		<td align="center">{{ App\Helpers\TextHelper::numberFormat($Table_one[$town]['overall']['cost']) }}</td>
		<?php if($Table_one[$town]['overall']['leads'] > 0):?>
				<td align="center"><?php
                    $cpl= round($Table_one[$town]['overall']['cost']/$Table_one[$town]['overall']['leads']);
                    $Table_one['Gtotal']['cost']=$Table_one['Gtotal']['cost']+$Table_one[$town]['overall']['cost'];
                    $Table_one['Gtotal']['cpl']=$Table_one['Gtotal']['cpl']+$cpl;
                    echo(App\Helpers\TextHelper::numberFormat($Table_one[$town]['overall']['cost']/$Table_one[$town]['overall']['leads']));?> </td>
		<?php else:?>
				<td align="center">-</td>
		<?php endif; ?>
		<?php if ($Table_one[$town]['overall']['to_activ'] >0):?>
				<td align="center"><?php
                    $cpa= round($Table_one[$town]['overall']['cost']/$Table_one[$town]['overall']['to_activ']);
                    $Table_one[$town]['overall']['cpa']=$cpa;
                    $Table_one['Gtotal']['cpa']=$Table_one['Gtotal']['cpa']+$cpa;
                    echo (App\Helpers\TextHelper::numberFormat
                    ($Table_one[$town]['overall']['cost']/$Table_one[$town]['overall']['activations']));?></td>
		<?php else:?>
				<td align="center">-</td>
		<?php endif; ?>
		<?php if($Table_one[$town]['overall']['coverage'] > 0):?>
			<td align="center">
                <?php

                $Table_one[$town]['overall']['cpl']=round($Table_one[$town]['overall']['to_click']/$Table_one[$town]['overall']['coverage']*100,2);
                echo $Table_one[$town]['overall']['cpl'];
                $Table_one['Gtotal']['coverage']=$Table_one['Gtotal']['coverage']+round
                    ($Table_one[$town]['overall']['to_click']/$Table_one[$town]['overall']['coverage']*100,2);?> %</td>
		<?php else:?>
			<td align="center">-</td>
		<?php endif; ?>
		<?php if($Table_one[$town]['overall']['to_click'] > 0):?>
			<td align="center"><?php

                echo round($Table_one[$town]['overall']['leads']/$Table_one[$town]['overall']['to_click']*100,2);
                $Table_one['Gtotal']['to_click']=$Table_one['Gtotal']['to_click']+round($Table_one[$town]['overall']['leads']/$Table_one[$town]['overall']['to_click']*100,2);
                ?> %</td>
		<?php else:?>
			<td align="center">-</td>
		<?php endif; ?>
		<?php if($Table_one[$town]['overall']['leads']) :?>
			<td align="center"><?php
                echo round($Table_one[$town]['overall']['to_activ']/$Table_one[$town]['overall']['leads']*100,2);
                $Table_one['Gtotal']['to_lead']=$Table_one['Gtotal']['to_lead']+round
                    ($Table_one[$town]['overall']['to_activ']/$Table_one[$town]['overall']['leads']*100,2);
                ?>
                %</td>
		<?php else:?>
			<td align="center">-</td>
		<?php endif; ?>
	</tr>
	<?php endforeach; ?>
    <tr align="center">
        <td>Итого</td><td><?=$Table_one['Gtotal']['leads']?></td>
                        <td><?=$Table_one['Gtotal']['activations']?></td>
                        <td><?=(App\Helpers\TextHelper::numberFormat($Table_one['Gtotal']['cost']))?></td>
                        <td><?=(App\Helpers\TextHelper::numberFormat($Table_one['Gtotal']['cost']/$Table_one['Gtotal']['leads']))?></td>
                        <td><?=(App\Helpers\TextHelper::numberFormat($Table_one['Gtotal']['cost']/$Table_one['Gtotal']['activations']))?></td>
                        <td><?=(App\Helpers\TextHelper::numberFormat($Table_one['Gtotal']['coverage']/5,2))?> %</td>
                        <td><?=(App\Helpers\TextHelper::numberFormat($Table_one['Gtotal']['to_click']/5,2))?> %</td>
                        <td><?=(App\Helpers\TextHelper::numberFormat($Table_one['Gtotal']['to_lead']/5,2))?> %</td>

    </tr>
	</tbody>
</table >

<table  class="table table-bordered table-sm table-striped report-table  mt-3" style="font-size: small;
white-space:nowrap; display: none " >
    <thead align="center">
    <tr>
        <th>&nbsp;</th>
        <th colspan="8" >Медийка</th>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th colspan="5" style="background-color: #dbe9d5" >KPI</th>
        <th colspan="3" style="background-color: #f0cecd" >Конверсии</th>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th  style="background-color: #dbe9d5">Лиды</th>
        <th  style="background-color: #dbe9d5">Активации</th>
        <th  style="background-color: #dbe9d5">Затраты</th>
        <th  style="background-color: #dbe9d5">CPL</th>
        <th  style="background-color: #dbe9d5">CPA</th>
        <th style="background-color: #f0cecd">Показы в клики</th>
        <th style="background-color: #f0cecd">Клики в лиды</th>
        <th style="background-color: #f0cecd">Лиды в Акт</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($City as $town):?>
            <tr>
        <td style="background-color: #d1e2f1">
            <?=$town?>
        </td>
        <td align="center">
            <?php echo($Table_two[$town]['overall']['leads']);
            $Table_two['Gtotal']['leads']=$Table_two['Gtotal']['leads']+$Table_two[$town]['overall']['leads'];
            ?></td>
        <td align="center"><?php
            echo($Table_two[$town]['overall']['activations']);
            $Table_two['Gtotal']['activations']=$Table_two['Gtotal']['activations']+$Table_two[$town]['overall']['activations'];
            ?></td>
        <td align="center">{{ App\Helpers\TextHelper::numberFormat($Table_two[$town]['overall']['cost']) }}</td>
        <?php if($Table_two[$town]['overall']['leads'] > 0):?>
        <td align="center"><?php
            $cpl= round($Table_two[$town]['overall']['cost']/$Table_two[$town]['overall']['leads'],2);
            $Table_two['Gtotal']['cost']=$Table_two['Gtotal']['cost']+$Table_two[$town]['overall']['cost'];
            $Table_two['Gtotal']['cpl']=$Table_two['Gtotal']['cpl']+$cpl;
            echo(App\Helpers\TextHelper::numberFormat
            ($Table_two[$town]['overall']['cost']/$Table_two[$town]['overall']['leads']));?> </td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
        <?php if ($Table_two[$town]['overall']['to_activ'] >0):?>
        <td align="center"><?php
            $cpa= round($Table_two[$town]['overall']['cost']/$Table_two[$town]['overall']['to_activ'],2);
            $Table_two[$town]['overall']['cpa']=$cpa;
            $Table_two['Gtotal']['cpa']=$Table_two['Gtotal']['cpa']+$cpa;
            echo(App\Helpers\TextHelper::numberFormat
            ($Table_two[$town]['overall']['cost']/$Table_two[$town]['overall']['activations']));?></td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
        <?php if($Table_two[$town]['overall']['coverage'] > 0):?>
        <td align="center">
            <?php


            echo round($Table_two[$town]['overall']['to_click']/$Table_two[$town]['overall']['coverage']*100,2);
            $Table_two['Gtotal']['coverage']=$Table_two['Gtotal']['coverage']+round
                ($Table_two[$town]['overall']['to_click']/$Table_two[$town]['overall']['coverage']*100,2);?> %</td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
        <?php if($Table_two[$town]['overall']['to_click'] > 0):?>
        <td align="center"><?php

            echo round($Table_two[$town]['overall']['leads']/$Table_two[$town]['overall']['to_click']*100,2);
            $Table_two['Gtotal']['to_click']=$Table_two['Gtotal']['to_click']+round($Table_two[$town]['overall']['leads']/$Table_two[$town]['overall']['to_click']*100,2);
            ?> %</td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
        <?php if($Table_two[$town]['overall']['leads']) :?>
        <td align="center"><?php
            echo round($Table_two[$town]['overall']['to_activ']/$Table_two[$town]['overall']['leads']*100,2);
            $Table_two['Gtotal']['to_lead']=$Table_two['Gtotal']['to_lead']+round
                ($Table_two[$town]['overall']['to_activ']/$Table_two[$town]['overall']['leads']*100,2);
            ?>
            %</td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
    </tr>
        <?php endforeach; ?>
            <tr align="center">
        <td>Итого</td>
        <td><?=$Table_two['Gtotal']['leads']?></td>
        <td><?=$Table_two['Gtotal']['activations']?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_two['Gtotal']['cost']))?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_two['Gtotal']['cost']/$Table_two['Gtotal']['leads'],2))?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_two['Gtotal']['cost']/$Table_two['Gtotal']['activations'],2))?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_two['Gtotal']['coverage']/5,2))?> %</td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_two['Gtotal']['to_click']/5,2))?> %</td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_two['Gtotal']['to_lead']/5,2))?> %</td>

    </tr>
    </tbody>


</table>


<table  class="table table-bordered table-sm table-striped report-table all mt-3"  style="font-size: small; white-space: nowrap">
    <thead align="center">
    <tr>
        <th>&nbsp;</th>
        <th colspan="8" >Общая</th>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th colspan="5" style="background-color: #dbe9d5" >KPI</th>
        <th colspan="3" style="background-color: #f0cecd" >Конверсии</th>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th  style="background-color: #dbe9d5">Лиды</th>
        <th  style="background-color: #dbe9d5">Активации</th>
        <th  style="background-color: #dbe9d5">Затраты</th>
        <th  style="background-color: #dbe9d5">CPL</th>
        <th  style="background-color: #dbe9d5">CPA</th>
        <th style="background-color: #f0cecd">Показы в клики</th>
        <th style="background-color: #f0cecd">Клики в лиды</th>
        <th style="background-color: #f0cecd">Лиды в Акт</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($City as $town):?>

    <tr>
        <td style="background-color: #d1e2f1">
            <?=$town?>
        </td>
        <td align="center">
            <?php echo($Table_two[$town]['overall']['leads']+$Table_one[$town]['overall']['leads']);
            ?>
        </td>
        <td align="center">
            <?=$Table_two[$town]['overall']['activations']+$Table_one[$town]['overall']['activations']?></td>
        <td align="center">{{ App\Helpers\TextHelper::numberFormat
        ($Table_two[$town]['overall']['cost']+$Table_one[$town]['overall']['cost']) }}</td>
        <?php ?>
        <td align="center"><?php
            $cpl=($Table_two[$town]['overall']['cost']+$Table_one[$town]['overall']['cost'])/($Table_two[$town]['overall']['leads']+$Table_one[$town]['overall']['leads']);

            echo(App\Helpers\TextHelper::numberFormat($cpl));
            ?></td>
        <?php ?>

        <?php  ?>



        <td align="center"><?php
            $cpa=($Table_two[$town]['overall']['cost']+$Table_one[$town]['overall']['cost'])/($Table_two[$town]['overall']['activations']+$Table_one[$town]['overall']['activations']);
            echo (App\Helpers\TextHelper::numberFormat($cpa));?></td>


        <td align="center"><?=
            round(($Table_two[$town]['overall']['to_click']/$Table_two[$town]['overall']['coverage'] +
                    $Table_one[$town]['overall']['to_click']/$Table_one[$town]['overall']['coverage'])
                *100,2)?> %</td>


        <td align="center">
            <?=round(($Table_two[$town]['overall']['leads']/$Table_two[$town]['overall']['to_click']+
                    $Table_one[$town]['overall']['leads']/$Table_one[$town]['overall']['to_click'])*100,2)?> %</td>


        <td align="center">
            <?=round(($Table_two[$town]['overall']['to_activ']/$Table_two[$town]['overall']['leads']+
                    $Table_one[$town]['overall']['to_activ']/$Table_one[$town]['overall']['leads'])*100,2)?> %</td>

    </tr>
    <?php endforeach; ?>
    <tr align="center">
        <td>Итого</td>
        <td><?=$Table_two['Gtotal']['leads']+$Table_one['Gtotal']['leads']?></td>
        <td><?=$Table_two['Gtotal']['activations']+$Table_one['Gtotal']['activations']?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_two['Gtotal']['cost']+$Table_one['Gtotal']['cost']))?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat(($Table_two['Gtotal']['cost']+$Table_one['Gtotal']['cost'])/($Table_two['Gtotal']['leads']+$Table_one['Gtotal']['leads'])))
            ?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat(($Table_two['Gtotal']['cost']+$Table_one['Gtotal']['cost'])/($Table_two['Gtotal']['activations']+$Table_one['Gtotal']['activations'])))
                ?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat
            ($Table_two['Gtotal']['coverage']/5+$Table_one['Gtotal']['coverage']/5,2))?> %</td>
        <td><?=(App\Helpers\TextHelper::numberFormat
            ($Table_two['Gtotal']['to_click']/5+$Table_one['Gtotal']['to_click']/5,2))?> %</td>
        <td><?=(App\Helpers\TextHelper::numberFormat
            ($Table_two['Gtotal']['to_lead']/5+$Table_one['Gtotal']['to_lead']/5,2))?> %</td>
    </tr>
    </tbody>

</table>
<?php

$City=['Москва','Санкт-Петербург','Казань','Чебоксары','Нижний Новгород'];
$Table_one=[];
$Table_two=[];
$Table_three = [];

foreach ($report['search']->items as $record){
    foreach ($City as $town){
        if($town == $record['city']){
            $Table_one[$town][] = $record;
        }
    }
}


foreach ($report['media']->items as $record){
    foreach ($City as $town){
        if($town == $record['city']){
            $Table_two[$town][] = $record;
        }
    }
}


foreach ($City as $town){
    $OverAll['leads'] = 0;
    $OverAll['activations'] = 0;
    $OverAll['cost'] = 0;
    $OverAll['cpl'] = 0;
    $OverAll['cpa'] = 0;
    $OverAll['coverage']=0;
    $OverAll['to_click']=0;
    $OverAll['to_lead']=0;
    $OverAll['to_activ']=0;

    if(isset($Table_one[$town])){
        for($i =0,$iMax=count($Table_one[$town]); $i < $iMax; $i++){
            $OverAll['leads']=$OverAll['leads']+$Table_one[$town][$i]['leads'];
            $OverAll['activations']=$OverAll['activations']+$Table_one[$town][$i]['activations'];
            $OverAll['cost']=$OverAll['cost']+$Table_one[$town][$i]['cost'];
            $OverAll['cpl']=$OverAll['cpl']+$Table_one[$town][$i]['cpl'];
            $OverAll['cpa']=0;
            $OverAll['coverage']=$OverAll['coverage']+$Table_one[$town][$i]['coverage'];
            $OverAll['to_click']=$OverAll['to_click']+$Table_one[$town][$i]['clicks'];
            $OverAll['to_lead']=$OverAll['to_lead']+$Table_one[$town][$i]['leads'];
            $OverAll['to_activ']=$OverAll['to_activ']+$Table_one[$town][$i]['activations'];
        }
    }
    $Table_one[$town]['overall']['leads']=$OverAll['leads'];
    $Table_one[$town]['overall']['activations']=$OverAll['activations'];
    $Table_one[$town]['overall']['cost']=$OverAll['cost'];
    $Table_one[$town]['overall']['cpl']=$OverAll['cpl'];
    $Table_one[$town]['overall']['cpa']=$OverAll['cpa'];
    $Table_one[$town]['overall']['coverage']=$OverAll['coverage'];
    $Table_one[$town]['overall']['to_click']=$OverAll['to_click'];
    $Table_one[$town]['overall']['to_lead']=$OverAll['to_lead'];
    $Table_one[$town]['overall']['to_activ']=$OverAll['to_activ'];

    $Table_one['Gtotal']['leads']=0;
    $Table_one['Gtotal']['activations']=0;
    $Table_one['Gtotal']['cost']=0;
    $Table_one['Gtotal']['cpl']=0;
    $Table_one['Gtotal']['cpa']=0;
    $Table_one['Gtotal']['coverage']=0;
    $Table_one['Gtotal']['to_click']=0;
    $Table_one['Gtotal']['to_lead']=0;
    $Table_one['Gtotal']['to_active']=0;

    if(isset($Table_two[$town])){

        for($t =0,$iMax=count($Table_two[$town]); $t < $iMax; $t++){
            $OverAll['leads']=$OverAll['leads']+$Table_two[$town][$t]['leads'];
            $OverAll['activations']=$OverAll['activations']+$Table_two[$town][$t]['activations'];
            $OverAll['cost']=$OverAll['cost']+$Table_two[$town][$t]['cost'];
            $OverAll['cpl']=$OverAll['cpl']+$Table_two[$town][$t]['cpl'];
            $OverAll['cpa']=0;
            $OverAll['coverage']=$OverAll['coverage']+$Table_two[$town][$t]['coverage'];
            $OverAll['to_click']=$OverAll['to_click']+$Table_two[$town][$t]['clicks'];
            $OverAll['to_lead']=$OverAll['to_lead']+$Table_two[$town][$t]['leads'];
            $OverAll['to_activ']=$OverAll['to_activ']+$Table_two[$town][$t]['activations'];
        }
    }
    $Table_two[$town]['overall']['leads']=$OverAll['leads']-$Table_one[$town]['overall']['leads'];
    $Table_two[$town]['overall']['activations']=$OverAll['activations']-$Table_one[$town]['overall']['activations'];
    $Table_two[$town]['overall']['cost']=$OverAll['cost']-$Table_one[$town]['overall']['cost'];
    $Table_two[$town]['overall']['cpl']=0;
    $Table_two[$town]['overall']['cpa']=0;
    $Table_two[$town]['overall']['coverage']=$OverAll['coverage']-$Table_one[$town]['overall']['coverage'];
    $Table_two[$town]['overall']['to_click']=$OverAll['to_click']-$Table_one[$town]['overall']['to_click'];
    $Table_two[$town]['overall']['to_lead']=$OverAll['to_lead']-$Table_one[$town]['overall']['to_lead'];
    $Table_two[$town]['overall']['to_activ']=$OverAll['to_activ']-$Table_one[$town]['overall']['to_activ'];

    $Table_two['Gtotal']['leads']=0;
    $Table_two['Gtotal']['activations']=0;
    $Table_two['Gtotal']['cost']=0;
    $Table_two['Gtotal']['cpl']=0;
    $Table_two['Gtotal']['cpa']=0;
    $Table_two['Gtotal']['coverage']=0;
    $Table_two['Gtotal']['to_click']=0;
    $Table_two['Gtotal']['to_lead']=0;
    $Table_two['Gtotal']['to_active']=0;

    $Table_three['Gtotal']['leads']=0;
    $Table_three['Gtotal']['activations']=0;
    $Table_three['Gtotal']['cost']=0;
    $Table_three['Gtotal']['cpl']=0;
    $Table_three['Gtotal']['cpa']=0;
    $Table_three['Gtotal']['coverage']=0;
    $Table_three['Gtotal']['to_click']=0;
    $Table_three['Gtotal']['to_lead']=0;
    $Table_three['Gtotal']['to_active']=0;


}

?>
<table class="table table-bordered table-sm table-striped report-table context mb-3 mt-2"  style="font-size: small;white-space: nowrap; ">
    <thead align="center">
    <tr>
        <th>&nbsp;</th>
        <th colspan="8" >Контекст</th>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th colspan="5" style="background-color: #dbe9d5" >KPI</th>
        <th colspan="3" style="background-color: #f0cecd" >Конверсии</th>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th  style="background-color: #dbe9d5">Лиды</th>
        <th  style="background-color: #dbe9d5">Активации</th>
        <th  style="background-color: #dbe9d5">Затраты</th>
        <th  style="background-color: #dbe9d5">CPL</th>
        <th  style="background-color: #dbe9d5">CPA</th>
        <th style="background-color: #f0cecd">Показы в клики</th>
        <th style="background-color: #f0cecd">Клики в лиды</th>
        <th style="background-color: #f0cecd">Лиды в Акт</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($City as $town):?>
    <tr>
        <td style="background-color: #d1e2f1">
            <?=$town?>
        </td>
        <td align="center">
            <?php echo($Table_one[$town]['overall']['leads']);
            $Table_one['Gtotal']['leads']=$Table_one['Gtotal']['leads']+$Table_one[$town]['overall']['leads'];
            ?> </td>
        <td align="center"><?php
            echo($Table_one[$town]['overall']['activations']);
            $Table_one['Gtotal']['activations']=$Table_one['Gtotal']['activations']+$Table_one[$town]['overall']['activations'];
            ?></td>
        <td align="center">{{ App\Helpers\TextHelper::numberFormat($Table_one[$town]['overall']['cost']) }}</td>
        <?php if($Table_one[$town]['overall']['leads'] > 0):?>
        <td align="center"><?php
            $cpl= round($Table_one[$town]['overall']['cost']/$Table_one[$town]['overall']['leads']);
            $Table_one['Gtotal']['cost']=$Table_one['Gtotal']['cost']+$Table_one[$town]['overall']['cost'];
            $Table_one['Gtotal']['cpl']=$Table_one['Gtotal']['cpl']+$cpl;
            echo(App\Helpers\TextHelper::numberFormat($Table_one[$town]['overall']['cost']/$Table_one[$town]['overall']['leads']));?> </td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
        <?php if ($Table_one[$town]['overall']['to_activ'] >0):?>
        <td align="center"><?php
            $cpa= round($Table_one[$town]['overall']['cost']/$Table_one[$town]['overall']['to_activ']);
            $Table_one[$town]['overall']['cpa']=$cpa;
            $Table_one['Gtotal']['cpa']=$Table_one['Gtotal']['cpa']+$cpa;
            echo (App\Helpers\TextHelper::numberFormat
            ($Table_one[$town]['overall']['cost']/$Table_one[$town]['overall']['activations']));?></td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
        <?php if($Table_one[$town]['overall']['coverage'] > 0):?>
        <td align="center">
            <?php

            $Table_one[$town]['overall']['cpl']=round($Table_one[$town]['overall']['to_click']/$Table_one[$town]['overall']['coverage']*100,2);
            echo $Table_one[$town]['overall']['cpl'];
            $Table_one['Gtotal']['coverage']=$Table_one['Gtotal']['coverage']+round
                ($Table_one[$town]['overall']['to_click']/$Table_one[$town]['overall']['coverage']*100,2);?> %</td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
        <?php if($Table_one[$town]['overall']['to_click'] > 0):?>
        <td align="center"><?php

            echo round($Table_one[$town]['overall']['leads']/$Table_one[$town]['overall']['to_click']*100,2);
            $Table_one['Gtotal']['to_click']=$Table_one['Gtotal']['to_click']+round($Table_one[$town]['overall']['leads']/$Table_one[$town]['overall']['to_click']*100,2);
            ?> %</td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
        <?php if($Table_one[$town]['overall']['leads']) :?>
        <td align="center"><?php
            echo round($Table_one[$town]['overall']['to_activ']/$Table_one[$town]['overall']['leads']*100,2);
            $Table_one['Gtotal']['to_lead']=$Table_one['Gtotal']['to_lead']+round
                ($Table_one[$town]['overall']['to_activ']/$Table_one[$town]['overall']['leads']*100,2);
            ?>
            %</td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
    </tr>
    <?php endforeach; ?>
    <tr align="center">
        <td>Итого</td><td><?=$Table_one['Gtotal']['leads']?></td>
        <td><?=$Table_one['Gtotal']['activations']?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_one['Gtotal']['cost']))?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_one['Gtotal']['cost']/$Table_one['Gtotal']['leads']))?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_one['Gtotal']['cost']/$Table_one['Gtotal']['activations']))?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_one['Gtotal']['coverage']/5,2))?> %</td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_one['Gtotal']['to_click']/5,2))?> %</td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_one['Gtotal']['to_lead']/5,2))?> %</td>

    </tr>
    </tbody>
</table >

<table  class="table table-bordered table-sm table-striped report-table  mt-3" style="font-size: small; white-space:nowrap; " >
    <thead align="center">
    <tr>
        <th>&nbsp;</th>
        <th colspan="8" >Медийка</th>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th colspan="5" style="background-color: #dbe9d5" >KPI</th>
        <th colspan="3" style="background-color: #f0cecd" >Конверсии</th>
    </tr>
    <tr>
        <th>&nbsp;</th>
        <th  style="background-color: #dbe9d5">Лиды</th>
        <th  style="background-color: #dbe9d5">Активации</th>
        <th  style="background-color: #dbe9d5">Затраты</th>
        <th  style="background-color: #dbe9d5">CPL</th>
        <th  style="background-color: #dbe9d5">CPA</th>
        <th style="background-color: #f0cecd">Показы в клики</th>
        <th style="background-color: #f0cecd">Клики в лиды</th>
        <th style="background-color: #f0cecd">Лиды в Акт</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($City as $town):?>
    <tr>
        <td style="background-color: #d1e2f1">
            <?=$town?>
        </td>
        <td align="center">
            <?php echo($Table_two[$town]['overall']['leads']);
            $Table_two['Gtotal']['leads']=$Table_two['Gtotal']['leads']+$Table_two[$town]['overall']['leads'];
            ?></td>
        <td align="center"><?php
            echo($Table_two[$town]['overall']['activations']);
            $Table_two['Gtotal']['activations']=$Table_two['Gtotal']['activations']+$Table_two[$town]['overall']['activations'];
            ?></td>
        <td align="center">{{ App\Helpers\TextHelper::numberFormat($Table_two[$town]['overall']['cost']) }}</td>
        <?php if($Table_two[$town]['overall']['leads'] > 0):?>
        <td align="center"><?php
            $cpl= round($Table_two[$town]['overall']['cost']/$Table_two[$town]['overall']['leads'],2);
            $Table_two['Gtotal']['cost']=$Table_two['Gtotal']['cost']+$Table_two[$town]['overall']['cost'];
            $Table_two['Gtotal']['cpl']=$Table_two['Gtotal']['cpl']+$cpl;
            echo(App\Helpers\TextHelper::numberFormat
            ($Table_two[$town]['overall']['cost']/$Table_two[$town]['overall']['leads']));?> </td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
        <?php if ($Table_two[$town]['overall']['to_activ'] >0):?>
        <td align="center"><?php
            $cpa= round($Table_two[$town]['overall']['cost']/$Table_two[$town]['overall']['to_activ'],2);
            $Table_two[$town]['overall']['cpa']=$cpa;
            $Table_two['Gtotal']['cpa']=$Table_two['Gtotal']['cpa']+$cpa;
            echo(App\Helpers\TextHelper::numberFormat
            ($Table_two[$town]['overall']['cost']/$Table_two[$town]['overall']['activations']));?></td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
        <?php if($Table_two[$town]['overall']['coverage'] > 0):?>
        <td align="center">
            <?php


            echo round($Table_two[$town]['overall']['to_click']/$Table_two[$town]['overall']['coverage']*100,2);
            $Table_two['Gtotal']['coverage']=$Table_two['Gtotal']['coverage']+round
                ($Table_two[$town]['overall']['to_click']/$Table_two[$town]['overall']['coverage']*100,2);?> %</td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
        <?php if($Table_two[$town]['overall']['to_click'] > 0):?>
        <td align="center"><?php

            echo round($Table_two[$town]['overall']['leads']/$Table_two[$town]['overall']['to_click']*100,2);
            $Table_two['Gtotal']['to_click']=$Table_two['Gtotal']['to_click']+round($Table_two[$town]['overall']['leads']/$Table_two[$town]['overall']['to_click']*100,2);
            ?> %</td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
        <?php if($Table_two[$town]['overall']['leads']) :?>
        <td align="center"><?php
            echo round($Table_two[$town]['overall']['to_activ']/$Table_two[$town]['overall']['leads']*100,2);
            $Table_two['Gtotal']['to_lead']=$Table_two['Gtotal']['to_lead']+round
                ($Table_two[$town]['overall']['to_activ']/$Table_two[$town]['overall']['leads']*100,2);
            ?>
            %</td>
        <?php else:?>
        <td align="center">-</td>
        <?php endif; ?>
    </tr>
    <?php endforeach; ?>
    <tr align="center">
        <td>Итого</td>
        <td><?=$Table_two['Gtotal']['leads']?></td>
        <td><?=$Table_two['Gtotal']['activations']?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_two['Gtotal']['cost']))?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_two['Gtotal']['cost']/$Table_two['Gtotal']['leads'],2))?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_two['Gtotal']['cost']/$Table_two['Gtotal']['activations'],2))?></td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_two['Gtotal']['coverage']/5,2))?> %</td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_two['Gtotal']['to_click']/5,2))?> %</td>
        <td><?=(App\Helpers\TextHelper::numberFormat($Table_two['Gtotal']['to_lead']/5,2))?> %</td>

    </tr>
    </tbody>


</table>
