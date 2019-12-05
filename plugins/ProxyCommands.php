<?php
/**
 * The plugin provides the /proxy:connect and /proxy:disconnect commands to the Phpcraft proxy.
 *
 * @var Plugin $this
 */
use Phpcraft\
{Account, ChatComponent, ClientConnection, Plugin};
$this->registerCommand("connect", function(ClientConnection $sender, string $address, string $account_arg = "")
{
	global $account;
	$account_instance = $account;
	$join_specs = [];
	if($account_arg != "")
	{
		$sender->sendMessage("Resolving username...");
		$json = json_decode(file_get_contents("https://apimon.de/mcuser/".$account), true);
		$account_instance = new Account($account_arg);
		if($json && !empty($json["id"]))
		{
			$join_specs = [
				"1.1.1.1",
				$json["id"]
			];
		}
		else
		{
			$sender->sendMessage(ChatComponent::text("$account_arg is not a registered Minecraft account, so the UUID can't be provided to the server.")->yellow());
		}
	}
	global $server;
	$server->connectDownstream($sender, $address, $account_instance, $join_specs);
})
	 ->registerCommand("disconnect", function(ClientConnection $sender)
	 {
		 global $server;
		 $server->connectToIntegratedServer($sender);
	 });