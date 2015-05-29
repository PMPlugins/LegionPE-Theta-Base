<?php

/**
 * LegionPE-Theta
 * Copyright (C) 2015 PEMapModder
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

namespace legionpe\theta\query;

use legionpe\theta\BasePlugin;
use legionpe\theta\config\Settings;

class ReportStatusQuery extends AsyncQuery{
	private $players;
	public function __construct(BasePlugin $plugin){
		parent::__construct($plugin);
		$this->players = count($plugin->getServer()->getOnlinePlayers());
	}
	public function getQuery(){
		$myid = Settings::$LOCALIZE_ID;
		return "UPDATE server_status SET last_online=unix_timestamp(),online_players=$this->players WHERE server_id=$myid;";
	}
	public function getResultType(){
		return self::TYPE_RAW;
	}
	protected function reportDebug(){
		return false;
	}
}
