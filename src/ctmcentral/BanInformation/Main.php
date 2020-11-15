<?php
declare(strict_types=1);
namespace ctmcentral\BanInformation;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\OfflinePlayer;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Main extends PluginBase {
	private CONST FORMAT = "l, F j H:i:s T";

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool {
		$player = $this->getServer()->getPlayer($args[0]) ?? new OfflinePlayer($this->getServer(), $args[0]);
		$sender->sendMessage(TextFormat::GREEN . "--- Ban record of " . $player->getName() . " ---");
		foreach($this->getServer()->getNameBans()->getEntries() as $entry) {
			if($entry->getName() === $player->getName()) {
				$sender->sendMessage(TextFormat::YELLOW . "Creation: " . $entry->getCreated()->format(self::FORMAT));
				$sender->sendMessage(TextFormat::YELLOW . "Expires: " . ($entry->getExpires() ? $entry->getExpires()->format(self::FORMAT) : "Forever"));
				$sender->sendMessage(TextFormat::YELLOW . "Reason: " . $entry->getReason());
				$sender->sendMessage(TextFormat::YELLOW . "Staff: " . $entry->getSource());
				$sender->sendMessage("---");
			}
		}
		if($player instanceof Player) {
			foreach($this->getServer()->getIPBans()->getEntries() as $entry) {
				if($entry->getName() === $player->getAddress()) {
					$sender->sendMessage(TextFormat::YELLOW . "Creation: " . $entry->getCreated()->format(self::FORMAT));
					$sender->sendMessage(TextFormat::YELLOW . "Expires: " . ($entry->getExpires() ? $entry->getExpires()->format(self::FORMAT) : "Forever"));
					$sender->sendMessage(TextFormat::YELLOW . "Reason: " . $entry->getReason());
					$sender->sendMessage(TextFormat::YELLOW . "Staff: " . $entry->getSource());
					$sender->sendMessage("---");
				}
			}
		}
		return true;
	}
}