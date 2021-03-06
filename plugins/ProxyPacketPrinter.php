<?php
/**
 * The plugin with the catchiest and most concise name!
 * Prints packets that pass through the proxy. Surprise!
 *
 * @var Plugin $this
 */
use Phpcraft\
{Event\ProxyClientPacketEvent, Event\ProxyServerPacketEvent, Plugin};
$this->on(function(ProxyClientPacketEvent &$e)
{
	$packet_class = $e->packetId->getClass();
	if($packet_class)
	{
		$offset = $e->client->downstream->read_buffer_offset;
		try
		{
			$packet = call_user_func($packet_class."::read", $e->client->downstream);
			echo "S -> C: $packet\n";
		}
		catch(Exception $ex)
		{
			echo "S -> C: {$e->packetId->name}\n";
			throw $ex;
		}
		finally
		{
			$e->client->downstream->read_buffer_offset = $offset;
		}
	}
	else
	{
		echo "S -> C: {$e->packetId->name}\n";
	}
})
	 ->on(function(ProxyServerPacketEvent &$e)
	 {
		 $recipient = ($e->server ? "S" : "P");
		 $packet_class = $e->packetId->getClass();
		 if($packet_class)
		 {
			 $offset = $e->client->read_buffer_offset;
			 try
			 {
				 $packet = call_user_func($packet_class."::read", $e->client);
				 echo "C -> $recipient: $packet\n";
			 }
			 catch(Exception $ex)
			 {
				 echo "C -> $recipient: {$e->packetId->name}\n";
				 throw $ex;
			 }
			 finally
			 {
				 $e->client->read_buffer_offset = $offset;
			 }
		 }
		 else
		 {
			 echo "C -> $recipient: {$e->packetId->name}\n";
		 }
	 });
