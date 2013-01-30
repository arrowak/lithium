<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2013, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

/**
 * The routes file is where you define your URL structure, which is an important part of the
 * [information architecture](http://en.wikipedia.org/wiki/Information_architecture) of your
 * application. Here, you can use _routes_ to match up URL pattern strings to a set of parameters,
 * usually including a controller and action to dispatch matching requests to. For more information,
 * see the `Router` and `Route` classes.
 *
 * @see lithium\net\http\Router
 * @see lithium\net\http\Route
 */
use lithium\net\http\Router;
use lithium\core\Environment;

/**
 * With globalization enabled a localized route is configured by connecting a
 * continuation route. Once the route has been connected, all the other
 * application routes become localized and may now carry a locale.
 *
 * Requests to routes like `/en/posts/edit/1138` or `/fr/posts/edit/1138` will
 * carry a locale, while `/posts/edit/1138` keeps on working as it did before.
 */
if ($locales = Environment::get('locales')) {
	$template = '/{:locale:' . join('|', array_keys($locales)) . '}/{:args}';
	Router::connect($template, array(), array('continue' => true));
}

/**
 * Here, we are connecting `'/'` (the base path) to controller called `'Pages'`,
 * its action called `view()`, and we pass a param to select the view file
 * to use (in this case, `/views/pages/home.html.php`; see `app\controllers\PagesController`
 * for details).
 *
 * @see app\controllers\PagesController
 */
Router::connect('/', 'Pages::view');

// routes for User Connections 

Router::connect('/searchUser','Connections::search');
Router::connect('/connect','Connections::connect');
Router::connect('/connections','Connections::getConnections');

// routes for Groups
Router::connect('/addGroup','Connections::addGroup');
Router::connect('/getPrivateGroups', 'Connections::getPrivateGroups');
Router::connect('/getPublicGroups', 'Connections::getPublicGroups');
Router::connect('/addUserToPublicGroup', 'Connections::addUserToPublicGroup');
Router::connect('/removeUserFromPublicGroup', 'Connections::removeUserFromPublicGroup');
Router::connect('/getMembers', 'Connections::getMembers');
Router::connect('/searchGroup', 'Connections::searchGroup');
Router::connect('/myGroups', 'Connections::userGroups');
Router::connect('/deleteGroup', 'Connections::deleteGroup');

// routes for logout module
Router::connect('/logout', 'Login::delete');
Router::connect('/logout/{:args}','Login::delete');


// routes for error pages
Router::connect('/loginError', 'ErrorPages::loginerror');


Router::connect('/login', 'Login::login');

// routes for login module
Router::connect('/admin', 'Admin::manage');


// routes for registartion module
Router::connect('/register', 'Login::login');
Router::connect('/register/{:args}', 'User::register');
Router::connect('/success/{:args}', 'User::success');
Router::connect('/welcome', 'User::welcome');
Router::connect('/participate', 'User::participate');
Router::connect('/profile','User::profile');

// routes for forgotten password
Router::connect('/getLink','User::getLink');
Router::connect('/forgot', 'User::forgot');
Router::connect('/forgotpassword/{:args}','User::forgotpassword');
Router::connect('/updatePassword', 'User::updatePassword');

// routes for admin control for interests management
Router::connect('/admin/managecategories/{:args}','Admin::addInterests');
Router::connect('/admin/getHows','Admin::getHows');
Router::connect('/admin/getWheres','Admin::getWheres');
Router::connect('/admin/getWhichs','Admin::getWhichs');
Router::connect('/admin/deleteHow','Admin::deleteHow');
Router::connect('/admin/deleteWhere','Admin::deleteWhere');
Router::connect('/admin/deleteWhich','Admin::deleteWhich');
Router::connect('/admin/createHow','Admin::createHow');
Router::connect('/admin/createWhere','Admin::createWhere');
Router::connect('/admin/editHow','Admin::editHow');
Router::connect('/admin/editWhere','Admin::editWhere');

/**
 * Connect the rest of `PagesController`'s URLs. This will route URLs like `/pages/about` to
 * `PagesController`, rendering `/views/pages/about.html.php` as a static page.
 */
Router::connect('/pages/{:args}', 'Pages::view');

/**
 * Add the testing routes. These routes are only connected in non-production environments, and allow
 * browser-based access to the test suite for running unit and integration tests for the Lithium
 * core, as well as your own application and any other loaded plugins or frameworks. Browse to
 * [http://path/to/app/test](/test) to run tests.
 */
if (!Environment::is('production')) {
	Router::connect('/test/{:args}', array('controller' => 'lithium\test\Controller'));
	Router::connect('/test', array('controller' => 'lithium\test\Controller'));
}

/**
 * ### Database object routes
 *
 * The routes below are used primarily for accessing database objects, where `{:id}` corresponds to
 * the primary key of the database object, and can be accessed in the controller as
 * `$this->request->id`.
 *
 * If you're using a relational database, such as MySQL, SQLite or Postgres, where the primary key
 * is an integer, uncomment the routes below to enable URLs like `/posts/edit/1138`,
 * `/posts/view/1138.json`, etc.
 */
// Router::connect('/{:controller}/{:action}/{:id:\d+}.{:type}', array('id' => null));
// Router::connect('/{:controller}/{:action}/{:id:\d+}');

/**
 * If you're using a document-oriented database, such as CouchDB or MongoDB, or another type of
 * database which uses 24-character hexidecimal values as primary keys, uncomment the routes below.
 */
// Router::connect('/{:controller}/{:action}/{:id:[0-9a-f]{24}}.{:type}', array('id' => null));
// Router::connect('/{:controller}/{:action}/{:id:[0-9a-f]{24}}');

/**
 * Finally, connect the default route. This route acts as a catch-all, intercepting requests in the
 * following forms:
 *
 * - `/foo/bar`: Routes to `FooController::bar()` with no parameters passed.
 * - `/foo/bar/param1/param2`: Routes to `FooController::bar('param1, 'param2')`.
 * - `/foo`: Routes to `FooController::index()`, since `'index'` is assumed to be the action if none
 *   is otherwise specified.
 *
 * In almost all cases, custom routes should be added above this one, since route-matching works in
 * a top-down fashion.
 */
Router::connect('/{:controller}/{:action}/{:args}');

?>
