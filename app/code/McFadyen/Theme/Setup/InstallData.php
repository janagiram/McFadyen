<?php
/*
 *
 *  * Author: Janagiram Ramakrishnan
 *  * Email: janagirammca@gmail.com
 *
 */


namespace McFadyen\Theme\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\Store;

/**
 * @codeCoverageIgnore
 * @SuppressWarnings(PHPMD)
 */
class InstallData implements InstallDataInterface
{
    const THEME_NAME = 'MCFADYEN/test';

    /**
     * @var \Magento\Theme\Model\Config
     */
    private $config;

    /**
     * @var \Magento\Theme\Model\ResourceModel\Theme\CollectionFactory
     */
    private $collectionFactory;

    /**
     * InstallData constructor.
     * @param \Magento\Theme\Model\ResourceModel\Theme\CollectionFactory $collectionFactory
     * @param \Magento\Theme\Model\Config $config
     */
    public function __construct(
        \Magento\Theme\Model\ResourceModel\Theme\CollectionFactory $collectionFactory,
        \Magento\Theme\Model\Config                                $config
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->config = $config;
    }


    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->assignTheme();

        $setup->endSetup();
    }

    /**
     * Assign Theme
     *
     * @return void
     */
    protected function assignTheme()
    {
        $themes = $this->collectionFactory->create()->loadRegisteredThemes();
        /**
         * @var \Magento\Theme\Model\Theme $theme
         */
        foreach ($themes as $theme) {
            if ($theme->getCode() == self::THEME_NAME) {
                $this->config->assignToStore(
                    $theme,
                    [Store::DEFAULT_STORE_ID],
                    ScopeConfigInterface::SCOPE_TYPE_DEFAULT
                );
            }
        }
    }
}
