<?php

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

    require_once dirname(__FILE__).'/../../../core/php/core.inc.php';
    include_file('core', 'authentification', 'php');
    if (!isConnect()) {
        include_file('desktop', '404', 'php');
        die();
    }
?>
<div class="form-group">
    <label class="col-lg-4 control-label" >{{Protocole si détection d'une URL ? : }}</label>
    <div class="col-lg-3">
    <select id="sel_object" class="configKey form-control" data-l1key="ProtocoleURL">
        <option value="0">{{Http}}</option>
        <option value="1">{{Https}}</option>
    </select>
    </div>
</div>
</br>
</br>
<div class="form-group">
    <label class="col-lg-4 control-label" >{{Mode Debug : }}</label>
    <div class="col-lg-3">
        <input type="checkbox" class="configKey" data-l1key="modeDebug">
    </div>
</div>
</br>
</br>
<div class="form-group">
    <label class="col-lg-4 control-label" >{{Utilisation iframe : }}</label>
    <div class="col-lg-3">
        <input type="checkbox" class="configKey" data-l1key="UseIframe">
    </div>
</div>
