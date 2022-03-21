<?php

use Jaxon\Flot\Plugin;
use Jaxon\Utils\Template\Engine as TemplateEngine;

// Register the template dir into the template renderer
jaxon()->di()->set(Plugin::class, function($c) {
    $xTemplateEngine = $c->g(TemplateEngine::class);
    $xTemplateEngine->addNamespace('jaxon::flot', realpath(__DIR__ . '/../templates'));
    return new Plugin($xTemplateEngine);
});
// Register an instance of this plugin
jaxon()->registerPlugin(Plugin::class, Plugin::NAME);
