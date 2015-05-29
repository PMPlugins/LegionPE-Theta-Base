<?php

/**
 * LegionPE
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

namespace legionpe\theta\queue;

use legionpe\theta\BasePlugin;
use legionpe\theta\Session;
use pocketmine\Player;

class WaitSessionCommandRunnable implements Runnable{
	/** @var BasePlugin */
	private $plugin;
	/** @var Player */
	private $player;
	/** @var string */
	private $cmdLine;
//	/** @var Session|null */
//	private $session = null;
	public function __construct(BasePlugin $plugin, Player $player, $cmdLine){
		$this->plugin = $plugin;
		$this->player = $player;
		$this->cmdLine = $cmdLine;
	}
	public function canRun(){
		return $this->plugin->getSession($this->player) instanceof Session;
	}
	public function run(){
		$this->plugin->getServer()->dispatchCommand($this->player, $this->cmdLine);
	}
}
