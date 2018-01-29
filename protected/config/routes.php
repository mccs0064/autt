<?php

return
        array(
            '/logout'=>'/site/logout',
            '/terms'=>'/fleetmanager/pages/terms',
            '/subscription'=>'/fleetmanager/pages/subscription',
            '/privacypolicy'=>'/fleetmanager/pages/privacypolicy',
            '<controller:\w+>/<id:\d+>' => '<controller>/view',
            '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
);
