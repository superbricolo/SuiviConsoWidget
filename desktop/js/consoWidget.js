
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



/*
 * Fonction pour l'ajout de commande, appellé automatiquement par plugin.template
 */
function addCmdToTable(_cmd) {
 
}

$("#consoWidget_type").change(function(){
	if($("#consoWidget_type").val() == "url"){
		$("#consoWidget_proxy").show();
		$("#labelUrl").show();
		$("#labelCode").hide();
		$(".consoWidget_proxy_info").hide();
	} else {
		$("#consoWidget_proxy").hide();
		$("#labelUrl").hide();
		$("#labelCode").show();
		$(".consoWidget_proxy_info").show();
	}
});



