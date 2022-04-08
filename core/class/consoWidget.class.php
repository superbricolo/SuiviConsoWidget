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
		$debugConf = '';
		$ip = $_SERVER['HTTP_HOST'];
		$code = '';
		if (filter_var($ip, FILTER_VALIDATE_IP)) {
			if (config::byKey('modeDebug', 'consoWidget') == 1) {
				$code = '<div width="100%" height="10%" style="background-color: #262626; color: #acacac;">           DEBUG 1: http://'. $_SERVER['HTTP_HOST'].'/</div>
				<embed width="100%" height="90%" src="http://'.$_SERVER['HTTP_HOST'].'/index.php?v=d&m=consoWidget&p=widget&id='.$this->getConfiguration('idequip').'&widget='.$this->getConfiguration('type_consoWidget').'" frameborder="0"></embed>';
			} else {
				$code = ' <embed width="100%" height="100%" src="http://'.$_SERVER['HTTP_HOST'].'/index.php?v=d&m=consoWidget&p=widget&id='.$this->getConfiguration('idequip').'&widget='.$this->getConfiguration('type_consoWidget').'" frameborder="0"></embed>';
			};
		} else {
			$external = "";
			if (config::byKey('externalComplement', 'core') != ""){
				$external = '/'.config::byKey('externalComplement', 'core');
			}
			if (config::byKey('ProtocoleURL', 'consoWidget') == 1) {
				if (config::byKey('modeDebug', 'consoWidget') == 1) {
					if ($external == "") {
						$code = '<div width="100%" height="10%" style="background-color: #262626; color: #acacac;">           DEBUG 2: https://'. $_SERVER['HTTP_HOST'].'/</div>
						<embed width="100%" height="90%" src="https://'.$_SERVER['HTTP_HOST'].'/index.php?v=d&m=consoWidget&p=widget&id='.$this->getConfiguration('idequip').'&widget='.$this->getConfiguration('type_consoWidget').'" frameborder="0"></embed>';
					} else {
						$code = '<div width="100%" height="10%" style="background-color: #262626; color: #acacac;">           DEBUG 3: https://'. $_SERVER['HTTP_HOST'].$external.'/</div>
						<embed width="100%" height="90%" src="https://'.$_SERVER['HTTP_HOST'].$external.'/index.php?v=d&m=consoWidget&p=widget&id='.$this->getConfiguration('idequip').'&widget='.$this->getConfiguration('type_consoWidget').'" frameborder="0"></embed>';
					}
				} else {
					if ($external == "") {
						$code = ' <embed width="100%" height="100%" src="https://'.$_SERVER['HTTP_HOST'].'/index.php?v=d&m=consoWidget&p=widget&id='.$this->getConfiguration('idequip').'&widget='.$this->getConfiguration('type_consoWidget').'" frameborder="0"></embed>';
					} else {
						$code = ' <embed width="100%" height="100%" src="https://'.$_SERVER['HTTP_HOST'].$external.'/index.php?v=d&m=consoWidget&p=widget&id='.$this->getConfiguration('idequip').'&widget='.$this->getConfiguration('type_consoWidget').'" frameborder="0"></embed>';
					}
				};
			} else {
				if (config::byKey('modeDebug', 'consoWidget') == 1) {
					if ($external == "") {
						$code = '<div width="100%" height="10%" style="background-color: #262626; color: #acacac;">           DEBUG 4: http://'. $_SERVER['HTTP_HOST'].'/</div>
						<object width="100%" height="90%" data="http://'.$_SERVER['HTTP_HOST'].'/index.php?v=d&m=consoWidget&p=widget&id='.$this->getConfiguration('idequip').'&widget='.$this->getConfiguration('type_consoWidget').'" frameborder="0"></object>';
							log::add('consoWidget', 'debug','http://'.$_SERVER['HTTP_HOST'].'/index.php?v=d&m=consoWidget&p=widget&id='.$this->getConfiguration('idequip').'&widget='.$this->getConfiguration('type_consoWidget'));
					} else {
						$code = '<div width="100%" height="10%" style="background-color: #262626; color: #acacac;">           DEBUG 5: http://'. $_SERVER['HTTP_HOST'].$external.'/</div>
						<embed width="100%" height="90%" src="http://'.$_SERVER['HTTP_HOST'].$external.'/index.php?v=d&m=consoWidget&p=widget&id='.$this->getConfiguration('idequip').'&widget='.$this->getConfiguration('type_consoWidget').'" frameborder="0"></embed>';
					}
				} else {
					if ($external == "") {
						$code = ' <embed width="100%" height="100%" src="http://'.$_SERVER['HTTP_HOST'].'/index.php?v=d&m=consoWidget&p=widget&id='.$this->getConfiguration('idequip').'&widget='.$this->getConfiguration('type_consoWidget').'" frameborder="0"></embed>';
					} else {
						$code = ' <embed width="100%" height="100%" src="http://'.$_SERVER['HTTP_HOST'].$external.'/index.php?v=d&m=consoWidget&p=widget&id='.$this->getConfiguration('idequip').'&widget='.$this->getConfiguration('type_consoWidget').'" frameborder="0"></embed>';
					}
				};
			}
		}

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
		$replace['#width#'] = $this->getDisplay('width', 'auto');
		$replace['#height#'] = $this->getDisplay('height', 'auto');
		$replace['#cmd#'] = $this->toHtmlCmd($_version,  false);
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
