<?php

namespace ScoreYa\Cinderella\Core\Composer;

use Composer\Script\Event;

/**
 * @author Alexander Miehe <thelex@beamscore.com>
 *
 * @codeCoverageIgnore
 */
class HerokuEnvironment
{
    /**
     * Populate Heroku environment
     *
     * @param Event $event Event
     */
    public static function populateEnvironment(Event $event)
    {
        $url = getenv('MONGOLAB_URI'); // If Mongolab is chosen

        if ($url !== false) {

            $urlPath = parse_url($url, PHP_URL_PATH);

            putenv("SYMFONY__DATABASE_SERVER=" . $url);
            putenv("SYMFONY__DATABASE_NAME=" . substr($urlPath, 1));

            $io = $event->getIO();
            $io->write('MONGOLAB_URI=' . getenv('MONGOLAB_URI'));
        }
    }
}
