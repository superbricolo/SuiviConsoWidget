<?Php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class consoWidget extends eqLogic {
	/*     * *************************Attributs****************************** */



	/*     * ***********************Methode static*************************** */
	public static function event() {
		die('event');
	}

	/*
	 * Fonction exécutée automatiquement toutes les minutes par Jeedom
	 public static function cron() {

	 }
	 */


	/*
	 * Fonction exécutée automatiquement toutes les heures par Jeedom
	 public static function cronHourly() {

	 }
	 */

	/*
	 * Fonction exécutée automatiquement tous les jours par Jeedom
	 public static function cronDayly() {

	 }
	 */



	/*     * *********************Méthodes d'instance************************* */

	public function preInsert() {
		$this->setIsEnable(1);
		$this->setIsVisible(1);
	}

	public function postInsert() {

		$this->setDisplay('width',"480px");
		$this->setDisplay('height',"370px");
		$this->setConfiguration('freq',0);
		$this->save();
	}

	public function preSave() {
	}

	public function postSave() {
		$refresh = $this->getCmd(null, 'refresh');
		if (!is_object($refresh)) {
			$refresh = new cmd();
			$refresh->setLogicalId('refresh');
			$refresh->setIsVisible(1);
			$refresh->setName(__('Rafraichir', __FILE__));
		}
		$refresh->setType('action');
		$refresh->setSubType('other');
		$refresh->setEqLogic_id($this->getId());
		$refresh->save();
	}


	public function preUpdate() {

	}

	public function postUpdate() {

	}

	public function preRemove() {

	}

	public function postRemove() {

	}

	public function widgetPossibility($_key = '', $_default = true) {
		return array('custom' => true);
	}


	public function getCode(){
		$proxy = '/plugins/consoWidget/core/class/proxy/miniProxy.php?';
		if($this->getConfiguration('proxify')){
			$urlProxy = $proxy;
		}
		$code = $this->getConfiguration('type_consoWidget') == 'url' ?  '<iframe width="100%" height="100%" src="'.$urlProxy.$this->getConfiguration('consoWidget_code').'" frameborder="0"></iframe>' : $this->getConfiguration('consoWidget_code');
		$code = str_replace('#timestamp#', time(), $code);
		$code = str_replace('#proxy#', $proxy, $code);
		preg_match_all("/#cmd([0-9]+)#/", $code, $matches, PREG_SET_ORDER);
		foreach($matches as $match){
			$code = str_replace('#cmd'.$match[1].'#', cmd::byId($match[1])->toHtml(), $code);
		}

		return $code;
	}
	
	public function toHtml($_version = 'dashboard') {
		$replace = $this->preToHtml($_version, array(), true);

		//log::add('consoWidget', 'debug','ici'.print_r($replace,1));
		if (!is_array($replace)) {
			return $replace;
		}
		$version = jeedom::versionAlias($_version);

		$replace['#eqLogic_class#'] = 'eqLogic_layout_default';
		/*$replace['#width#'] = $this->getDisplay('width', 'auto');
		$replace['#height#'] = $this->getDisplay('height', 'auto');
		$replace['#name_display#'] = $this->getName();
		$replace['#object_name#'] = '';
		$replace['#eqLink#'] = $this->getLinkToConfiguration();
		$replace['#uid#'] = 'eqLogic' . $this->getId() . self::UIDDELIMITER . mt_rand() . self::UIDDELIMITER;
		*/
		$replace['#cmd#'] = $this->toHtmlCmd($_version,  $replace['#background-color#'] == 'transparent');
		$replace['#refresh_id#'] = $this->getCmd(null, 'Refresh')->getId();;
		$replace['#timer#'] = ($this->getConfiguration('freq') > 0) ? 'setInterval(refresh'.$replace['#uid#'].','.$this->getConfiguration('freq').'000);' : '';
			//$templ = getTemplate('core', $version, 'eqLogic');
		$templ = getTemplate('core', $version, 'main', 'consoWidget');
		return $this->postToHtml($_version, template_replace($replace, $templ));
	}








	 public function toHtmlCmd($_version = 'dashboard', $transparent = false) {
		$top = $transparent ? 0 : 30;
		return ' <div class="code" style="position:absolute; top:'.$top.'px;left:0px;right:0px;bottom:0px; width:100%; height:100%; background-color: white; color: black;">
			'.$this->getCode().'
			</div> ';
	 }
	 

	public static function dependancy_info(){ 
		log::add('consoWidget', 'debug','dependancy_info');
		$return = array();
		$return['state'] = 'ok';
		$requiredExtensions = ['curl', 'mbstring'];
		foreach($requiredExtensions as $requiredExtension) {
			if (!extension_loaded($requiredExtension)) {
				$return['state'] = 'nok';
				log::add('consoWidget', 'error','dependancy '.$requiredExtension.' is missing');
			}
		}
		if(file_exists('/etc/apache2/sites-enabled/000-default.conf')){
			if( strpos(file_get_contents('/etc/apache2/sites-enabled/000-default.conf'),'miniProxy.php') == false) {
				$return['state'] = 'nok';
				log::add('consoWidget', 'error','rewrite rule not installed is missing');
			}
		}
		$return['log'] = 'consoWidget_update';
		$return['progress_file'] = '/tmp/compilation_consoWidget_in_progress';
		log::add('consoWidget', 'debug','dependancy_info2');
		if(file_exists('/var/www/html/log/consoWidget_update') && file_exists('/tmp/compilation_consoWidget_in_progress')){
		log::add('consoWidget', 'debug','dependancy_info3');
			exec('sudo bash -c "cat /var/www/html/log/consoWidget_update |grep -v "Preparing" | wc -l > /tmp/compilation_consoWidget_in_progress"');
		}	
		return $return;
	}
	public static function dependancy_install() {
		if (file_exists('/tmp/compilation_consoWidget_in_progress')) {
			return;
		}
		log::remove('consoWidget_update');
		$cmd = 'sudo /bin/bash ' . dirname(__FILE__) . '/../install.sh';
		$cmd .= ' > ' . log::getPathToLog('consoWidget_update') . ' 2>&1 &';
		exec($cmd);
	}
}

class consoWidgetCmd extends cmd {
	/*     * *************************Attributs****************************** */


	/*     * ***********************Methode static*************************** */


	/*     * *********************Methode d'instance************************* */

	/*
	 * Non obligatoire permet de demander de ne pas supprimer les commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
	*/
	public function dontRemoveCmd() {
		if ($this->getLogicalId() == 'refresh') {
			return true;
		}
		return false;
	}


	public function execute($_options = array()) {
		if ($this->getLogicalId() == 'refresh') {
			return $this->getEqLogic()->getCode();
		}

	}


}

?>
