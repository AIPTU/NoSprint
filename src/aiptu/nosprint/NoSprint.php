<?php

declare(strict_types=1);

namespace aiptu\nosprint;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerToggleSprintEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use function gettype;
use function in_array;
use function rename;

final class NoSprint extends PluginBase implements Listener
{
	public function onEnable(): void
	{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);

		$this->checkConfig();
	}

	public function onPlayerToggleSprint(PlayerToggleSprintEvent $event): void
	{
		if ($event->isCancelled()) {
			return;
		}

		$player = $event->getPlayer();

		if (!in_array($player->getWorld()->getFolderName(), $this->getConfig()->getAll()['blacklisted-worlds'], true)) {
			return;
		}

		if ($player->hasPermission('nosprint.bypass')) {
			return;
		}

		if ($player->isSprinting()) {
			$player->setSprinting(false);
		}

		$player->sendMessage(TextFormat::colorize($this->getConfig()->get('message', "&cYou can't sprint in this world")));
		$event->cancel();
	}

	private function checkConfig(): void
	{
		$this->saveDefaultConfig();

		if ($this->getConfig()->get('config-version', 1) !== 1) {
			$this->getLogger()->notice('Your configuration file is outdated, updating the config.yml...');
			$this->getLogger()->notice('The old configuration file can be found at config.old.yml');

			rename($this->getDataFolder() . 'config.yml', $this->getDataFolder() . 'config.old.yml');

			$this->reloadConfig();
		}

		foreach ([
			'message' => 'string',
			'blacklisted-worlds' => 'array',
		] as $option => $expectedType) {
			if (($type = gettype($this->getConfig()->getNested($option))) !== $expectedType) {
				throw new \TypeError("Config error: Option ({$option}) must be of type {$expectedType}, {$type} was given");
			}
		}
	}
}
