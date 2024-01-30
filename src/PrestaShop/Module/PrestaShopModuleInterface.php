<?php

namespace Oksydan\Falconize\PrestaShop\Module;

interface PrestaShopModuleInterface
{
    /**
     * Connect module to a hook.
     *
     * @param string|array $hook_name Hook name
     * @param array|null $shop_list List of shop linked to the hook (if null, link hook to all shops)
     *
     * @return bool result
     */
    public function registerHook($hook_name, $shop_list = null); // we can't type hint because of PrestaShop core Module class

    /**
     * Unregister module from hook.
     *
     * @param int|string $hook_id Hook name or hook id
     * @param array|null $shop_list List of shop
     *
     * @return bool result
     */
    public function unregisterHook($hook_id, $shop_list = null); // we can't type hint because of PrestaShop core Module class
}
