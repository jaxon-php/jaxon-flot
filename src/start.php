<?php

// Register the template dir into the template renderer
jaxon()->di()->set(Jaxon\Flot\Plugin::class, function($c) {
    $xTemplateEngine = $c->g(Jaxon\Utils\Template\Engine::class);
    $xTemplateEngine->addNamespace('jaxon::flot', realpath(__DIR__ . '/../templates'));
    return new Jaxon\Flot\Plugin($xTemplateEngine);
});
// Register an instance of this plugin
jaxon()->registerPlugin(Jaxon\Flot\Plugin::class, 'flot');
