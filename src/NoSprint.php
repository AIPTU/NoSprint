<?php

/*
 *
 * Copyright (c) 2021 AIPTU
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

declare(strict_types=1);

namespace aiptu\nosprint;

use pocketmine\plugin\PluginBase;
use pocketmine\world\World;
use function in_array;
use function rename;

final class NoSprint extends PluginBase
{
	private const CONFIG_VERSION = 1.0;

	private const MODE_BLACKLIST = 0;
	private const MODE_WHITELIST = 1;

	private int $mode;

	private TypedConfig $typedConfig;

	public function onEnable(): void
	{
		$this->checkConfig();

		$this->getServer()->getPluginManager()->registerEvents(new EventHandler($this), $this);
	}

	public function getTypedConfig(): TypedConfig
	{
		return $this->typedConfig;
	}

	public function checkWorld(World $world): bool
	{
		if ($this->mode === self::MODE_BLACKLIST) {
			return !(in_array($world->getFolderName(), $this->getTypedConfig()->getStringList('worlds.list'), true));
		}

		return in_array($world->getFolderName(), $this->getTypedConfig()->getStringList('worlds.list'), true);
	}

	private function checkConfig(): void
	{
		$this->saveDefaultConfig();

		if (!$this->getConfig()->exists('config-version') || ($this->getConfig()->get('config-version', self::CONFIG_VERSION) !== self::CONFIG_VERSION)) {
			$this->getLogger()->warning('An outdated config was provided attempting to generate a new one...');
			if (!rename($this->getDataFolder() . 'config.yml', $this->getDataFolder() . 'config.old.yml')) {
				$this->getLogger()->critical('An unknown error occurred while attempting to generate the new config');
				$this->getServer()->getPluginManager()->disablePlugin($this);
			}
			$this->reloadConfig();
		}

		$this->typedConfig = new TypedConfig($this->getConfig());

		match ($this->getTypedConfig()->getString('worlds.mode', 'blacklist')) {
			'blacklist' => $this->mode = self::MODE_BLACKLIST,
			'whitelist' => $this->mode = self::MODE_WHITELIST,
			default => throw new \InvalidArgumentException('Invalid mode selected, must be either "blacklist" or "whitelist"!'),
		};
	}
}
