<?php

/*
 * Copyright (c) 2021-2023 AIPTU
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/AIPTU/NoSprint
 */

declare(strict_types=1);

namespace aiptu\nosprint;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerToggleSprintEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use function in_array;
use function is_array;
use function is_string;
use function trim;

class NoSprint extends PluginBase implements Listener {
	private const CONFIG_VERSION = 1.2;

	private const MODE_NONE = 0;
	private const MODE_BLACKLIST = 1;
	private const MODE_WHITELIST = 2;

	private string $message;
	private int $mode;
	/** @var array<string> */
	private array $worlds = [];

	public function onEnable() : void {
		$this->saveDefaultConfig();
		try {
			$this->loadConfig();
		} catch (\Throwable $e) {
			$this->getLogger()->error('An error occurred while loading the configuration: ' . $e->getMessage());
			$this->getServer()->getPluginManager()->disablePlugin($this);
			return;
		}

		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}

	public function onPlayerToggleSprint(PlayerToggleSprintEvent $event) : void {
		$player = $event->getPlayer();

		if ($event->isCancelled() || $player->hasPermission('nosprint.bypass')) {
			return;
		}

		$worldName = $player->getWorld()->getFolderName();

		if (!$this->checkWorld($worldName)) {
			$player->setSprinting(false);
			$player->sendPopup($this->message);
			$event->cancel();
		}
	}

	/**
	 * Check if the player's current world is allowed for sprinting based on the configured mode.
	 */
	private function checkWorld(string $worldName) : bool {
		if ($this->mode === self::MODE_NONE) {
			return true;
		}

		if ($this->mode === self::MODE_BLACKLIST) {
			return !in_array($worldName, $this->worlds, true);
		}

		return in_array($worldName, $this->worlds, true);
	}

	/**
	 * Load and validate the plugin's configuration.
	 *
	 * @throws \InvalidArgumentException
	 */
	private function loadConfig() : void {
		$this->checkConfig();

		$config = $this->getConfig();

		$message = $config->get('message');
		if (!is_string($message) || trim($message) === '') {
			throw new \InvalidArgumentException("Config error: 'message' must be a non-empty string");
		}
		$this->message = TextFormat::colorize($message);

		match ($config->getNested('worlds.mode')) {
			'none' => $this->mode = self::MODE_NONE,
			'blacklist' => $this->mode = self::MODE_BLACKLIST,
			'whitelist' => $this->mode = self::MODE_WHITELIST,
			default => throw new \InvalidArgumentException('Invalid mode selected, must be either "none," "blacklist," or "whitelist"!'),
		};

		$worlds = $config->getNested('worlds.list');
		if (!is_array($worlds)) {
			throw new \InvalidArgumentException("Config error: 'worlds.list' must be an array");
		}

		$validWorlds = [];
		foreach ($worlds as $world) {
			if (!is_string($world) || trim($world) === '') {
				throw new \InvalidArgumentException("Config error: 'worlds.list' must contain non-empty strings");
			}

			$worldManager = $this->getServer()->getWorldManager();
			if ($worldManager->isWorldGenerated($world)) {
				$validWorlds[] = $world;
			} else {
				$this->getLogger()->warning("World '{$world}' listed in the config does not exist or is not generated. Ignoring it.");
			}
		}

		$this->worlds = $validWorlds;
	}

	/**
	 * Checks and manages the configuration for the plugin.
	 * Generates a new configuration if an outdated one is provided and backs up the old config.
	 */
	private function checkConfig() : void {
		$config = $this->getConfig();

		if (!$config->exists('config-version') || $config->get('config-version', self::CONFIG_VERSION) !== self::CONFIG_VERSION) {
			$this->getLogger()->warning('An outdated config was provided; attempting to generate a new one...');

			$oldConfigPath = Path::join($this->getDataFolder(), 'config.old.yml');
			$newConfigPath = Path::join($this->getDataFolder(), 'config.yml');

			$filesystem = new Filesystem();
			try {
				$filesystem->rename($newConfigPath, $oldConfigPath);
			} catch (IOException $e) {
				$this->getLogger()->critical('An error occurred while attempting to generate the new config: ' . $e->getMessage());
				$this->getServer()->getPluginManager()->disablePlugin($this);
				return;
			}

			$this->reloadConfig();
		}
	}
}
