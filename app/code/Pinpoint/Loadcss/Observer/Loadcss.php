<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Pinpoint\Loadcss\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Asset\Repository;
use Magento\Framework\App\View\Asset\Publisher;

class Loadcss implements ObserverInterface
{
	/**
    * @var CustomerSession
    */
    protected $_customerSession;
	protected $_assetRepository;
    protected $_publisher;
	
	/**
     * Add constructor.
     * @param CustomerSession $customerSession
	 * @param Repository $assetRepository
     * @param Publisher $publisher
     */
    public function __construct(Session $customerSession,
								Repository $assetRepository,
                                Publisher $publisher
                                
    ) {
        $this->_customerSession = $customerSession;
        $this->_assetRepository = $assetRepository;
        $this->_publisher = $publisher;
    }

    /**
     * Append css in head tag
     * Get source URL from asset display into header part.
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(Observer $observer)
    {
        if (!$this->_customerSession->isLoggedIn()) {
            return;
        }
        $assetRep  = $this->_assetRepository;
		$createAssetRep = $assetRep->createAsset('css/loadcss.css', ['module' => 'Pinpoint_Loadcss', 'area' => 'frontend']);
        $this->_publisher->publish($createAssetRep);
        $sourceUrl    = $createAssetRep->getSourceUrl();
        $response = $observer->getEvent()->getData('response');
		//this will add custom CSS, in the HTML tag in the head section of your website
        $headerLink = '<link  rel="stylesheet" type="text/css"  media="all" href="' . $sourceUrl . '" />';
        $response->setBody(preg_replace('/<\/head>/', $headerLink . '</head>', $response->getBody(), 1));
    }
}