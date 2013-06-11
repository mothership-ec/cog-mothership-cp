<?php

namespace Message\Mothership\ControlPanel\EventListener;

use Message\Cog\Event\Event;
use Message\Cog\Event\EventListener as BaseListener;
use Message\Cog\Event\SubscriberInterface;

use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;

class RegisterAssets extends BaseListener implements SubscriberInterface
{
	static public function getSubscribedEvents()
	{
		#return array('modules.load.success' => array(
		#	array('registerAssets')
		#));
	}

	public function registerAssets(Event $event)
	{
		#$this->_services['asset.manager']->set('test',
		#	new FileAsset('/Users/joe/Sites/cog/modules/cog-mothership-cp/src/Message/Mothership/ControlPanel/View/_assets/css/basic.css')
		#);

		// NOTE: all of this makes much more sense in a view. oh can't we do it there somehow?
		$cpCollection = new AssetCollection(array(
			new FileAsset('/Users/joe/Sites/cog/modules/cog-mothership-cp/src/Message/Mothership/ControlPanel/View/_assets/css/basic.css'),
			new FileAsset('/Users/joe/Sites/cog/modules/cog-mothership-cp/src/Message/Mothership/ControlPanel/View/_assets/css/fonts.css')
		));

		foreach ($cpCollection as $dunno) {
			#var_dump($dunno);
		}

		#var_dump($cpCollection->getTargetPath());
		$this->_services['asset.manager']->set('ms_cp_css', $cpCollection);
	}
}