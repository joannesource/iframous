<?php
/**
 * Launch with : 
 *                php -S localhost:8080 example.php
 */

require __DIR__ . '/vendor/autoload.php';

/**
 * Available routes.
 */
class ExampleRoutes {

    const HOME         = '/tagger';
    const FRAME_TAGGED = '/tagger/tagged';
    const FRAME_TAGS   = '/tagger/tags';
    const FRAME_INPUT  = '/tagger/input';
    const ADD          = '/tagger/add/([a-z0-9_\-]+)';
    const POST_ADD     = '/tagger/add';
    const REMOVE       = '/tagger/remove/([a-z0-9_\-]+)';
    const ADD_TPL      = '/tagger/add/:tag';
    const REMOVE_TPL   = '/tagger/remove/:tag';

}

/**
 * Demo storage.
 */
$db = new \Iframous\JsonStorage(__DIR__);

if (!$db->isPopulated()) {
    $db->populate('tags', ['orange', 'pineapple', 'banana']);
    $db->populate('tagged', ['8989' => ['banana']]);
    $db->populate('reverse_tagged', ['banana' => ['8989']]);
}

/**
 * Tagger configuration.
 */
$conf = new \Iframous\TaggerConf;
$conf->setAddUrlTpl(ExampleRoutes::ADD_TPL);
$conf->setRemoveUrlTpl(ExampleRoutes::REMOVE_TPL);
$conf->setPostAddRoute(ExampleRoutes::POST_ADD);
$conf->setSelectableElements($db->getAll('tags'));
$conf->setSelectedElements($db->get('tagged', '8989'));
$conf->setTaggedFrameUrl(ExampleRoutes::FRAME_TAGGED);
$conf->setTagsFrameUrl(ExampleRoutes::FRAME_TAGS);
$conf->setInputFrameUrl(ExampleRoutes::FRAME_INPUT);

$tagger = new \Iframous\Tagger($conf);


/* Request routing */

// Create a Router
$router = new \Iframous\ExampleRouter;

// Custom 404 Handler
$router->set404(function () {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo '404, route not found!';
});

// Before Router Middleware
$router->before('GET', '/.*', function () {
    header('X-Powered-By: bramus/router');
});

$router->get(ExampleRoutes::HOME, function () use(&$tagger) {
    echo 'Tagger';
    $tagger->show();
});

$router->get(ExampleRoutes::FRAME_TAGGED, function () use(&$tagger) {
    echo 'Tagged: ';
    $tagger->showSelectedTags();
});

$router->get(ExampleRoutes::FRAME_TAGS, function () use(&$tagger) {
    echo 'Tags: ';
    $tagger->showSelectableTags();
});

$router->get(ExampleRoutes::FRAME_INPUT, function () use(&$tagger) {
    echo 'Input :';
    $tagger->showNewTagInput();
});

$router->get(ExampleRoutes::ADD, function ($name) use(&$db) {
    $proper_name = str_replace('-', ' ', $name);
    $db->append('tagged', '8989', $proper_name);
    $db->removeVal('reverse_tagged', $proper_name, '8989');
    header('location: ' . ExampleRoutes::FRAME_TAGGED);
});

$router->get(ExampleRoutes::REMOVE, function ($name) use(&$db) {
    $proper_name = str_replace('-', ' ', $name);
    $db->removeVal('tagged', '8989', $proper_name);
    $db->removeVal('reverse_tagged', $proper_name, '8989');
    header('location: ' . ExampleRoutes::FRAME_TAGGED);
});
$router->post(ExampleRoutes::POST_ADD, function() use(&$db) {
    $proper_name = $_POST['tag'];
    $db->appendVal('tags', $proper_name);
    $db->append('tagged', '8989', $proper_name);
    $db->append('reverse_tagged', $proper_name, '8989');
    header('location: ' . ExampleRoutes::FRAME_TAGGED);
});

$router->run();
