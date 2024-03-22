<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('eqType', 'consoWidget');
$eqLogics = eqLogic::byType('consoWidget');
?>


<div class="row row-overflow">
    <div class="col-xs-12 eqLogicThumbnailDisplay">
        <legend><i class="fas fa-cog"></i>  {{Gestion}}</legend>
            <div class="eqLogicThumbnailContainer">
                <div class="cursor eqLogicAction logoSecondary">
                    <a href="index.php?v=d&m=conso&p=conso"><img  style="margin-top:-32px;" src="plugins/conso/plugin_info/conso_icon.png" width="75" height="75" style="min-height:75px !important;" />
                    <br />
                    <span>{{Suivi Conso}}</span></a>
                </div>

                <div class="cursor eqLogicAction logoPrimary" data-action="add">
                    <i class="fas fa-plus-circle"></i>
                    <br>
                    <span>{{Ajouter}}</span>
                </div>
                <div class="cursor eqLogicAction logoSecondary" data-action="gotoPluginConf">
                    <i class="fas fa-wrench"></i>
                    <br>
                    <span>{{Configuration}}</span>
                </div>
            </div>
        <legend><i class="fas fa-table"></i> {{Suivi Conso Widget}}</legend>
        <input class="form-control" placeholder="{{Rechercher}}" id="in_searchEqlogic" />
        <div class="eqLogicThumbnailContainer">
        <?php
            foreach ($eqLogics as $eqLogic) {
                $opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
                echo '<div class="eqLogicDisplayCard cursor '.$opacity.'" data-eqLogic_id="' . $eqLogic->getId() . '">';
                echo '<img src="plugins/consoWidget/plugin_info/consoWidget_icon.png"/>';
                echo '<br>';
                echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
                echo '</div>';
            }
        ?>
    </div>
</div>

<div class="col-xs-12 eqLogic" style="display: none;">
	<div class="input-group pull-right" style="display:inline-flex">
		<span class="input-group-btn">
			<a class="btn btn-default btn-sm eqLogicAction roundedLeft" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a><a class="btn btn-default btn-sm eqLogicAction" data-action="copy"><i class="fas fa-copy"></i> {{Dupliquer}}</a><a class="btn btn-sm btn-success eqLogicAction" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a><a class="btn btn-danger btn-sm eqLogicAction roundedRight" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
		</span>
	</div>
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
        <li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-tachometer-alt"></i> {{Equipement}}</a></li>
    </ul>
    <div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
        <div role="tabpanel" class="tab-pane active" id="eqlogictab">
            <br/>
            <form class="form-horizontal">
                <fieldset>
                <div class="form-group">
                <label class="col-sm-3 control-label">{{Nom de l'équipement template}}</label>
                <div class="col-sm-3">
                    <input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
                    <input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement template}}"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" >{{Objet parent}}</label>
                <div class="col-sm-3">
                    <select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
                        <option value="">{{Aucun}}</option>
                        <?php
                            foreach (jeeObject::all() as $object) {
                                echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
                            }
                            ?>
                   </select>
               </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">{{Catégorie}}</label>
                <div class="col-sm-8">
                    <?php
                        foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
                            echo '<label class="checkbox-inline">';
                            echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
                            echo '</label>';
                        }
                    ?>
                </div>
            </div>
       	    <div class="form-group">
		    <label class="col-sm-3 control-label"></label>
		        <div class="col-sm-9">
			        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked/>{{Activer}}</label>
			        <label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked/>{{Visible}}</label>
                </div>
                <br/>
                <br/>
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Équipement Suivi Conso}}</label>
                    <div class="col-sm-3">
                        <select id="consoWidget_type"  class="eqLogicAttr configuration form-control" data-l1key="configuration" data-l2key="idequip">
                        <?php
                            $eqLogicsconso = eqLogic::byType('conso');

                            echo '<option selected value="">Non Config</option>';
                            foreach ($eqLogicsconso as $eqLogic) {
                                if ($eqLogic->getIsEnable() == 1) {
                                    echo '<option value='.$eqLogic->getId().' >'.$eqLogic->getName().'</option>';
                                }
                            }
                        ?>
                       </select>
                   </div>
               </div>
               <br/>
               <br/>
               <div class="form-group">
                    <label class="col-sm-3 control-label">{{Type de widget}}</label>
                    <div class="col-sm-3">
                        <select id="consoWidget_type"  class="eqLogicAttr configuration form-control" data-l1key="configuration" data-l2key="type_consoWidget">
                           <option value="1">{{Tableau prix}}</option>
                           <option value="2">{{Tableau consommation}}</option>
                           <option value="3">{{Gauge puissance}}</option>
                           <option value="4">{{Tableau variation}}</option>
                           <option value="5">{{Consommation du jour}}</option>
                           <?php
                                $eqLogicsconso = eqLogic::byType('conso');
                                if(count($eqLogicsconso) > 1) {
                                    echo '<option value="6">{{Statistiques}}</option>';
                                }
                            ?>
                           <option value="7">{{7 derniers jours}}</option>
                           <option value="8">{{4 dernières semaines}}</option>
                           <option value="9">{{12 derniers mois}}</option>
                           <option value="10">{{7 derniers jours Euro}}</option>
                           <option value="11">{{4 dernières semaines Euro}}</option>
                           <option value="12">{{12 derniers mois Euro}}</option>
                           <option value="13">{{12 derniers mois TTC}}</option>
                           <option value="14">{{Degré jour unifié par an}}</option>
						   <option value="15">{{Pluriannuel}}</option>
						   <option value="16">{{Pluriannuel en € (HT)}}</option>
                       </select>
                   </div>
               </div>
        </div>
</div>

<?php include_file('desktop', 'consoWidget', 'js', 'consoWidget');?>
<?php include_file('core', 'plugin.template', 'js');?>
