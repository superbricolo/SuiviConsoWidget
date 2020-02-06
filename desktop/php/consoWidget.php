<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
sendVarToJS('eqType', 'consoWidget');
$eqLogics = eqLogic::byType('consoWidget');
?>

<div class="row row-overflow">
    <div class="col-lg-2 col-md-3 col-sm-4">
        <div class="bs-sidebar">
            <ul id="ul_eqLogic" class="nav nav-list bs-sidenav">
                <a class="btn btn-default eqLogicAction" style="width : 100%;margin-top : 5px;margin-bottom: 5px;" data-action="add"><i class="fa fa-plus-circle"></i> {{Ajouter}}</a>
                <li class="filter" style="margin-bottom: 5px;"><input class="filter form-control input-sm" placeholder="{{Rechercher}}" style="width: 100%"/></li>
                <?php
foreach ($eqLogics as $eqLogic) {
	echo '<li class="cursor li_eqLogic" data-eqLogic_id="' . $eqLogic->getId() . '"><a>' . $eqLogic->getHumanName() . '</a></li>';
}
?>
            </ul>
        </div>
    </div>

        <div class="col-lg-10 col-md-9 col-sm-8 eqLogicThumbnailDisplay" style="border-left: solid 1px #EEE; padding-left: 25px;">
        <legend>{{consoWidget}}
        </legend>

            <div class="eqLogicThumbnailContainer">
                      <div class="cursor eqLogicAction" data-action="add" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >
           <center>
            <i class="fa fa-plus-circle" style="font-size : 7em;color:#94ca02;"></i>
        </center>
        <span style="font-size : 1.1em;position:relative; top : 23px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;color:#94ca02"><center>Ajouter</center></span>
    </div>
                <?php
foreach ($eqLogics as $eqLogic) {
	echo '<div class="eqLogicDisplayCard cursor" data-eqLogic_id="' . $eqLogic->getId() . '" style="background-color : #ffffff; height : 200px;margin-bottom : 10px;padding : 5px;border-radius: 2px;width : 160px;margin-left : 10px;" >';
	echo "<center>";
	echo '<img src="plugins/consoWidget/plugin_info//consoWidget_icon.png" height="105" width="95" />';
	echo "</center>";
	echo '<span style="font-size : 1.1em;position:relative; top : 15px;word-break: break-all;white-space: pre-wrap;word-wrap: break-word;"><center>' . $eqLogic->getHumanName(true, true) . '</center></span>';
	echo '</div>';
}
?>
            </div>
        </div>

    <div class="col-lg-10 col-md-9 col-sm-8 eqLogic" style="border-left: solid 1px #EEE; padding-left: 25px;display: none;">
        <form class="form-horizontal">
            <fieldset>
                <legend><i class="fa fa-arrow-circle-left eqLogicAction cursor" data-action="returnToThumbnailDisplay"></i> {{Général}}  <i class='fa fa-cogs eqLogicAction pull-right cursor expertModeVisible' data-action='configure'></i></legend>
                <div class="form-group">
                    <label class="col-sm-3 control-label">{{Nom de l'équipement}}</label>
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
                    <label class="col-sm-3 control-label" >{{Activer}}</label>
                    <div class="col-sm-1">
                        <input type="checkbox" class="eqLogicAttr " data-l1key="isEnable" size="16" checked/>
                    </div>
                    <label class="col-sm-3 control-label" >{{Visible}}</label>
                    <div class="col-sm-1">
                        <input type="checkbox" class="eqLogicAttr " data-l1key="isVisible" checked/>
                    </div>
                </div>
            </fieldset>
        </form>


	       <div class="form-group">
                    <label class="col-sm-3 control-label">{{Type de widget}}</label>
                    <div class="col-sm-3">
                        <select id="consoWidget_type"  class="eqLogicAttr configuration form-control" data-l1key="configuration" data-l2key="type_consoWidget">
                           <option value="url">{{URL}}</option>
                           <option value="htmlCode">{{code HTML}}</option>
                       </select>
                   </div>
               </div>
		<br/>
		<br/>
		<div id="consoWidget_proxy" class="form-group">
                    <label class="col-sm-3 control-label">{{Utiliser jeedom en proxy}}</label>
                    <div class="col-sm-3">
                        <input type="checkbox" class="eqLogicAttr" data-l1key="configuration" data-l2key="proxify" />
                   </div>
               </div>
		<br/>
		<br/>

	       <div class="form-group">
                    <label id="labelUrl" class="col-sm-3 control-label">{{URL}}</label>
                    <label id="labelCode" class="col-sm-3 control-label">{{Code Html}}</label>
                    <div class="col-sm-3">
			<textarea rows="10" class="eqLogicAttr configuration form-control" data-l1key="configuration" data-l2key="consoWidget_code" name="consoWidgeturl"></textarea>
                   </div>
		<span class="">{{utilisez #timestamp# qui est remplacé par le timestamp courant pour &eacute;viter le cache.}}</span>
		<span class="consoWidget_proxy_info"><br/>{{Prefixez les URL par #proxy# pour les faire passer par le proxy. Exemple : &lt;img src="#proxy#https://www.jeedom.com/site/logo.png" /&gt;}}</span>
		<span class="consoWidget_proxy_info"><br/>{{ #cmdN# sera remplac&eacute; par la commande N. Exemple : #cmd12# #cmd13# affiche les commandes 12 et 13 (si ce sont les commandes on et off d'un interrupteur cela affiche l'interrupteur) }}</span>
		<span class="consoWidget_proxy_info"><br/>{{ Les function javascriptd suivantes sont &eacute;galement disponible: consoWidget_cmd(id,value); consoWidget_startScenario(id); consoWidget_stopScenario(id);. Les commandes jquery ($.get(), $.post()...) sont &eacute;galement utilisable pour faire des appels ajax via le proxy. Consultez la documentation pour voir des exemples.}}</span>
               </div>
		</br>
		</br>
		<br/>
      <div class="form-group">
        <label class="col-sm-4 control-label">{{Fr&eacute;quence de rafra&icirc;chissement}}</label>
        <div class="col-sm-2">
          <input class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="freq" type="number" />
        </div>
        <span class="">{{en secondes. 0 pour aucun rafra&icirc;chissement}}</span>
      </div>
	<br/>
      <div class="form-group">
        <label class="col-sm-4 control-label">{{Largeur}}</label>
        <div class="col-sm-2">
          <input class="eqLogicAttr form-control" data-l1key="display" data-l2key="width" type="text" ></input>
        </div>
      </div>
	<br/>
	<br/>
      <div class="form-group">
        <label class="col-sm-4 control-label">{{Hauteur}}</label>
        <div class="col-sm-2">
          <input class="eqLogicAttr form-control" data-l1key="display" data-l2key="height" type="text" />
        </div>
      </div>
	<br/>
	<br/>

        <form class="form-horizontal">
            <fieldset>
                <div class="form-actions">
                    <a class="btn btn-danger eqLogicAction" data-action="remove"><i class="fa fa-minus-circle"></i> {{Supprimer}}</a>
                    <a class="btn btn-success eqLogicAction" data-action="save"><i class="fa fa-check-circle"></i> {{Sauvegarder}}</a>
                </div>
            </fieldset>
        </form>

    </div>
</div>

<?php include_file('desktop', 'consoWidget', 'js', 'consoWidget');?>
<?php include_file('core', 'plugin.template', 'js');?>
