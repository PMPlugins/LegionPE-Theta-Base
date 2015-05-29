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

namespace legionpe\theta;

use legionpe\theta\query\LoginQuery;
use legionpe\theta\queue\LoginRunnable;
use legionpe\theta\queue\Queue;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\server\QueryRegenerateEvent;
use pocketmine\utils\TextFormat;

class BaseListener implements Listener{
	/** @var BasePlugin */
	private $main;
	public function __construct(BasePlugin $main){
		$this->main = $main;
	}
	public function onPreLogin(PlayerPreLoginEvent $event){
		$player = $event->getPlayer();
		$login = new LoginQuery($this->main, $player->getName(), $player->getAddress(), $player->getClientId());
		$this->main->queueFor($player->getId(), true, Queue::QUEUE_SESSION)->pushToQueue(new LoginRunnable($this->main, $login, $player->getId()));
	}
	public function onQueryRegen(QueryRegenerateEvent $event){
		$event->setWorld($this->main->query_world());
		$this->main->getPlayersCount($total, $max);
		$event->setPlayerCount($total);
		$event->setMaxPlayerCount($max);
		$event->setPlayerList([]);
		$event->setServerName(TextFormat::clean($this->main->getServer()->getNetwork()->getName()));
	}
}
