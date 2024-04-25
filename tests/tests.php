<?php

require_once __DIR__ . '/testframework.php';

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../modules/database.php';
require_once __DIR__ . '/../modules/page.php';

$testFramework = new TestFramework();

// test 1: check database connection
function testDbConnection() {
    global $testFramework, $config;
    $db = new Database($config['db']['path']);
    $testFramework->assertTrue($db != null, 'Database connection should be established');
}

// test 2: test count method
function testDbCount() {
    global $testFramework, $config;
    $db = new Database($config['db']['path']);
    $count = $db->Count('page');
    $testFramework->assertTrue($count >= 0, 'Count should be zero or more');
}

// test 3: test create method
function testDbCreate() {
    global $testFramework, $config;
    $db = new Database($config['db']['path']);
    $id = $db->Create('page', ['title' => 'Test Page', 'content' => 'Test Content']);
    $testFramework->assertTrue($id > 0, 'New page should have a valid ID');
}

// test 4: test read method
function testDbRead() {
    global $testFramework, $config;
    $db = new Database($config['db']['path']);
    $page = $db->Read('page', 1);
    $testFramework->assertTrue($page != null, 'Should retrieve a page');
}

// test 5: test update method
function testDbUpdate() {
    global $testFramework, $config;
    $db = new Database($config['db']['path']);
    $db->Update('page', 1, ['title' => 'Updated Title', 'content' => 'Updated Content']);
    $updatedPage = $db->Read('page', 1);
    $testFramework->assertTrue($updatedPage['title'] == 'Updated Title', 'Title should be updated');
}

// test 6: test delete method
function testDbDelete() {
    global $testFramework, $config;
    $db = new Database($config['db']['path']);
    $db->Delete('page', 1);
    $page = $db->Read('page', 1);
    $testFramework->assertTrue($page == null, 'Page should be deleted');
}

// Test for class Page
function testPageRender() {
    global $testFramework;
    $page = new Page(__DIR__ . '/../templates/index.tpl');
    ob_start();
    $page->Render(['title' => 'Test Title', 'content' => 'Test Content']);
    $output = ob_get_clean();
    $testFramework->assertTrue(strpos($output, 'Test Title') !== false, 'Output should contain the title');
}

// add tests
$testFramework->add('Database connection', 'testDbConnection');
$testFramework->add('Table count', 'testDbCount');
$testFramework->add('Data create', 'testDbCreate');
$testFramework->add('Data read', 'testDbRead');
$testFramework->add('Data update', 'testDbUpdate');
$testFramework->add('Data delete', 'testDbDelete');
$testFramework->add('Page render', 'testPageRender');

// run tests
$testFramework->run();

echo $testFramework->getResult();
