<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */

$this->title = Yii::t('app', 'Import Group Shift');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Group Shifts'), 'url' => ['index']];
?>
<div class="card card-custom">
<div class="card-body">

	<div class="row">
		<div class="package-form col-md-6">

			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

			<div class="form-group">
			<?php 
				echo FileInput::widget([
					'id' => 'package-file',
					'name' => 'package-file',
					'options' => ['accept' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
					'pluginOptions' => [
						'showPreview' => false,
					],
				]);
			?>
			</div>

			<?php ActiveForm::end(); ?>

		</div>
	</div>

	<p>Format file excel yang didukung: </p>
	<div class="row">
		<div class="col-md-12">
			<table class="table table-bordered table-condensed table-excel font-size-sm text-muted text-center" style="background: #fff">
				<tr>
					<th width="40px" style="background: #e7e7e7">&nbsp;</th>
					<th class="bg-light">A</th>
					<th class="bg-light">B</th>
					<th class="bg-light">C</th>
					<th class="bg-light">D</th>
				</tr>
				<tr class="data-header">
					<th class="bg-light">1</th>
					<th style="background:#ff06">Tanggal</th>
					<th style="background:#ff06">Shift Pagi</th>
					<th style="background:#ff06">Shift Sore</th>
					<th style="background:#ff06">Shift Malam</th>
				</tr>
				<tr>
					<th class="bg-light">2</th>
					<td>2023-01-01</td>
					<td>A</td>
					<td>B</td>
					<td>C</td>
				</tr>
				<tr>
					<th class="bg-light">3</th>
					<td>2023-01-02</td>
					<td>A</td>
					<td>B</td>
					<td>C</td>
				</tr>
			</table>
		</div>
	</div>

	<p>
		Keterangan:
		<ul>
			<li>Data dimulai pada row 2 dan seterusnya (row 1 sebagai header).</li>
			<li>Format data kolom Tanggal berupa YYYY-MM-DD.</li>
		</ul>
	</p>

</div>
</div>