<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
if (!isConnect()) {
	throw new Exception('{{401 - Accès non autorisé}}');
}

$deamon_statut =  conso::deamon_info();
if($deamon_statut['state'] == 'nok'){
				log::add('conso_trame', 'debug', 'Chargement du Panel - Deamon non lancée - Redemarre le Deamon');
				conso::deamon_stop();
				conso::deamon_start();
}
			//conso_tools::CheckOptionIsValid();
$cron = cron::byClassAndFunction('conso', 'StartDeamon');

if (is_object($cron)) {
	sendVarToJS('refreshTime', $cron->getDeamonSleepTime());
}

include_file('3rdparty', 'bootstrap-select/dist/css/bootstrap-select', 'css', 'conso');
include_file('3rdparty', 'datetimepicker/jquery.datetimepicker', 'css', 'conso');
//include_file('3rdparty', 'datetimepicker/jquery.datetimepicker', 'css', 'conso');
//include_file('3rdparty', 'datetimepicker/jquery.datetimepicker', 'css', 'conso');
include_file('3rdparty', 'datatable/datatable', 'css', 'conso');
include_file('desktop', 'ionicons', 'css', 'conso');
include_file('desktop', 'panel', 'css', 'conso');
/*Theme*/
include_file('desktop/css/theme', 'style', 'css', 'conso');
include_file('desktop/css/theme', 'font-awesome', 'css', 'conso');

/* Set Variable Thème couleur Jeedom*/
$versionjeedom = "V0";
$versionplugin = "V3.xx";
$versiondate = "V4.3";
if (jeedom::version() < "4.0.0") {
	//echo "V3";
	$versionjeedom = "V3";
	sendVarToJS('bgmodalcolorvar', "var(--bg-modal-color)");
	sendVarToJS('txtcolor', "var(--sc-lightTxt-color) !important");
	sendVarToJS('important', "!important");
	echo '<style type="text/css">
	.highcharts-axis-labels text tspan {fill: var(--sc-lightTxt-color) !important;}
	.highcharts-legend-item:not(.highcharts-legend-item-hidden) text{fill: var(--sc-lightTxt-color) !important;}
	#gauge .highcharts-yaxis-labels > text {fill: #484343 !important;}
	#widget_statBox .highcharts-label > text {fill: var(--sc-lightTxt-color) !important;}
	#widget_statBox .carousel-caption {fill: var(--sc-lightTxt-color) !important;}
	.container {width: 1300px;}
	</style>';
} else {
	//echo "V4";
	$versionjeedom = "V4";
	sendVarToJS('bgmodalcolorvar', "var(--bg-modal-color)");
	sendVarToJS('txtcolor', "var(--link-color) !important");
	sendVarToJS('important', "!important");
	echo '<style type="text/css">
	.highcharts-axis-labels text tspan {fill: var(--txt-color) !important;}
	.highcharts-yaxis-labels > text {fill: var(--txt-color) !important;}
	#gauge .highcharts-yaxis-labels > text {fill: #484343 !important;}
	#widget_statBox .highcharts-label > text {fill: var(--txt-color) !important;}
	#widget_statBox .carousel-caption {fill: var(--txt-color) !important;}
	.container {width: 1300px;}
	</style>';
}

if (jeedom::version() >= "4.4.0") {
	$versiondate = "V4.4";
	sendVarToJS('txtcolor', "var(--link-color) ");
	sendVarToJS('important', "");
}
else {
	$versiondate = "V4.3";
}

/*Thème*/
sendVarToJS('stylecss', 'cssdefault');
sendVarToJS('versiontheme',$versionjeedom);
sendVarToJS('versionplugin',$versionplugin);
sendVarToJS('versiondate',$versiondate);
/*Devise*/
sendVarToJS('Devise', config::byKey('Devise', 'conso'));
sendVarToJS('dispTemp', config::byKey('dispTemp', 'conso',false));

/*Get timeZone*/
$timezonebis=config::byKey('timezone', 'core', '0');
sendVarToJS('timezonebis',$timezonebis);
/*Active ou non la prevision si il existe des données de l année -1  */
sendVarToJS('active_prevision', true);
/*Date abonnement de l'onglet outils*/
sendVarToJS('date_abo', config::byKey('date_abo', 'conso', '01-01'));

//$sql = 'ALTER TABLE `test`.`conso_periode` ADD COLUMN `libelle` VARCHAR(255) NULL AFTER `position`; ';
//$result =  DB::Prepare($sql,  array(), DB::FETCH_TYPE_ALL);
$eqLogics = eqLogic::byType('conso');

$power = (count($eqLogics) == 0 ? 6 : conso::getPower($eqLogics[0]->getId()));
$type_abo = (count($eqLogics) == 0 ? 'HCHP' : conso::getAbo($eqLogics[0]->getId()));
$type = (count($eqLogics) == 0 ? 'electricity' : conso::getType($eqLogics[0]->getId()));
$eqLogic_default = $eqLogics[0]->getId();

foreach ($eqLogics as $eqLogic) {
	if ((int)$eqLogic->getConfiguration('default') > 0 && $eqLogic->getIsEnable() == 1) {
		$power = conso::getPower($eqLogic->getId());
		$type_abo = conso::getAbo($eqLogic->getId());
		$type = conso::getType($eqLogic->getId());
		$eqLogic_default = $eqLogic->getId();
	}
}

$display = ($type_abo == 'HCHP' OR $type_abo == 'TEMPO' ? '' : 'displaynone');
$title = ($type_abo == 'HCHP' OR $type_abo == 'TEMPO' ? 'HP' : '');
if ($type == 'water') $title = 'M3';

$btnreturn = config::byKey('btn_return', 'conso', false);
$datesynchro = config::byKey('date_update_conso_jour', 'conso', date("d-m-Y H:i:s"));

sendVarToJS('ismobile', false);
sendVarToJS('eqType', 'conso');
sendVarToJS('datesynchro', $datesynchro);
sendVarToJS('abo_power', $power);
sendVarToJS('type_abo', $type_abo);
sendVarToJS('display', $display);
sendVarToJS('type', $type);
sendVarToJS('widgetId', $id=$_GET["widget"]);
sendVarToJS('idequipement', $_GET["id"]);
?>
	<div id="menu">
		<select id="conso_ecq">
			<?php
			$id=$_GET["id"];
				echo '<option data-id="' . $id . '" value=' . $id . ' ></option>';
			?>
		</select>
	</div>
	<div id="div_VerifParam" style="display: none;margin:5px 0px;"></div>
	<div id="error_abo_id_tva" style="margin:5px 0px;display: none;"></div>
	<div class="row row-overflow" id="div_conso">
		<input type="hidden" value="<?php echo $datesynchro ?>" id="datesynchro">
		<?php

		include_once("panel_dashboard.php");
		include_once(__DIR__."/../../../conso/core/php/panel_temperature.php");
		include_once(__DIR__."/../../../conso/core/class/conso_panel.class.php");
		//include_once(__DIR__."/../../../conso/desktop/php/statistique/periode/panel_graph_periode.php");
		//include_once(__DIR__."/../../../conso/desktop/php/statistique/categorie/panel_graph_categorie.php");
		//include_once(__DIR__."/../../../conso/desktop/php/statistique/synthese/panel_graph_synthese.php");
		//include_once("conso.php");

		?>
	</div>

<?php
include_file('3rdparty', 'bootstrap-select/dist/js/bootstrap-select', 'js', 'conso');
include_file('3rdparty', 'bootstrap-select/dist/js/bootstrap-select.min', 'js', 'conso');
include_file('3rdparty', 'datatable/datatable', 'js', 'conso');
include_file('3rdparty', 'circles/circles.min', 'js', 'conso');
include_file('desktop', 'gauge', 'js', 'conso');
include_file('desktop', 'bib_graph', 'js', 'conso');
include_file('desktop', 'panel_temperature', 'js', 'conso');
include_file('desktop', 'panel_dashboard', 'js', 'conso');
include_file('desktop', 'pie', 'js', 'conso');
include_file('desktop', 'panel', 'js', 'conso');
include_file('desktop', 'statistique/categorie/panel_graph_categorie', 'js', 'conso');
include_file('desktop', 'statistique/periode/panel_graph_periode', 'js', 'conso');
include_file('desktop', 'statistique/synthese/panel_graph_synthese', 'js', 'conso');
include_file('3rdparty', 'jqueryflip/jquery.flip.min', 'js', 'conso');
//include_file('3rdparty', 'datetimepicker/jquery.datetimepicker', 'js', 'conso');
include_file('desktop', 'widget', 'js', 'consoWidget');
?>

<script type="text/javascript">
	setTimeout(() => { document.getElementById("conso_dashboard").style.overflow = "visible"; }, 1000);
</script>
