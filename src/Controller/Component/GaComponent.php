<?php
namespace App\Controller\Component;

require APP . 'Vendor' . DS . 'php-qa' . DS . 'autoload.php';

use Cake\Controller\Component;
use UnitedPrototype\GoogleAnalytics;

class GaComponent extends Component
{
    const UAID         = 'UA-62653331-1';
    const SCOPE        = 'auto';
    const VISUAL_TITLE = 'CAKE3';

    public function track($page = '')
    {
        // Initilize GA Tracker
        $tracker = new GoogleAnalytics\Tracker(self::UAID, self::SCOPE);

        // Assemble Visitor information
        // (could also get unserialized from database)
        $visitor = new GoogleAnalytics\Visitor();
        $visitor->setIpAddress($_SERVER['REMOTE_ADDR']);
        $visitor->setUserAgent($_SERVER['HTTP_USER_AGENT']);
        $visitor->setScreenResolution('1024x768');

        // Assemble Session information
        // (could also get unserialized from PHP session)
        $session = new GoogleAnalytics\Session();

        // Assemble Page information
        $page = new GoogleAnalytics\Page($page);
        $page->setTitle(self::VISUAL_TITLE);

        // Track page view
        $tracker->trackPageview($page, $session, $visitor);
    }
}
