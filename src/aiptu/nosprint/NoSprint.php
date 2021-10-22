<?php

declare(strict_types=1);

namespace aiptu\nosprint;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerToggleSprintEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use function gettype;
use function in_array;

class NoSprint extends PluginBase implements Listener
{
    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->checkConfig();
    }

    public function onPlayerToggleSprint(PlayerToggleSprintEvent $event): void
    {
        $player = $event->getPlayer();

        if ($event->isCancelled()) {
            return;
        }
        if ($player->hasPermission('nosprint.bypass')) {
            return;
        }
        if (!in_array($player->getLevelNonNull()->getFolderName(), $this->getConfig()->getAll()['blacklisted-worlds'], true)) {
            return;
        }
        if ($player->isSprinting()) {
            $player->setSprinting(!$player->isSprinting());
        }
        $event->setCancelled();
        $player->sendMessage(TextFormat::colorize($this->getConfig()->get('message', "&cYou can't sprint in this world")));
    }

    private function checkConfig(): void
    {
        $this->saveDefaultConfig();
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
