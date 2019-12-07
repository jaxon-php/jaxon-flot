<?php

// Register the template dir into the template renderer
jaxon()->template()->addNamespace('jaxon::flot', dirname(__DIR__) . '/templates');
// Register an instance of this plugin
jaxon_register_plugin(new \Jaxon\Flot\Plugin());
