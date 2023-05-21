Quick Start
===========

After following the instructions under :doc:`installation`, go to your ``app.php`` and add your models and pages like so:

.. code:: php

    <?php
    // app.php
    ...
    \SeoBakery\SeoBakeryPlugin::NAME => [
        'pages' => ['home', 'about', 'contact']
        'behaviorModels' => ['Articles']
    ],
    ...

With the above configuration, the plugin will attach the proper behaviors and components auto-magically.

.. tip::
    Read :doc:`configuration` to see what your options are for a more advance configuration.
