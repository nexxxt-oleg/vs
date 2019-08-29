<?php


namespace Artofbx\Yandexmetrika\Handlers;


use Bitrix\Main\EventManager;
use Bitrix\Main\Page\Asset;
use Artofbx\Yandexmetrika\Configuration;

class MetrikaHandler
{
    public static function register($moduleId)
    {
        EventManager::getInstance()->registerEventHandler('main', 'OnPageStart', $moduleId, __CLASS__, 'onPageStart');
    }

    public static function unRegister($moduleId)
    {
        EventManager::getInstance()->registerEventHandler('main', 'OnPageStart', $moduleId, __CLASS__, 'onPageStart');
    }

    public static function onPageStart()
    {
        $config = Configuration::getConfig();
        $options = \CUtil::PhpToJSObject(Configuration::getJsConfig($config));

        if (Configuration::isActive($config)) {

            Asset::getInstance()->addString("
            <script type=\"text/javascript\">
                (function (d, w, c) {(w[c] = w[c] || []).push(function() {
                    try {
                        w.yaCounter{$config['id']} = new Ya.Metrika({$options});
                    } 
                    catch(e) {}});
                    var n=d.getElementsByTagName(\"script\")[0],s = d.createElement(\"script\"),f=function () { n.parentNode.insertBefore(s, n); };s.type=\"text/javascript\";s.async=true;s.src=(d.location.protocol==\"https:\"?\"https:\":\"http:\")+\"//mc.yandex.ru/metrika/watch.js\";if(w.opera==\"[object Opera]\"){d.addEventListener(\"DOMContentLoaded\",f,false);}else{f();}})(document,window,\"yandex_metrika_callbacks\");
            </script>");

            EventManager::getInstance()->addEventHandler(
                'main',
                'OnEndBufferContent',
                function (&$content) use ($config) {
                    $content = str_replace("</body>",
                        "<noscript><div><img src=\"//mc.yandex.ru/watch/{$config['id']}?ut=noindex\" style=\"position:absolute; left:-9999px;\" alt=\"\" /></div></noscript></body>",
                        $content);
                }
            );
        }
    }
}