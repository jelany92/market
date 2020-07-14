<?php

namespace common\tests\unit\models;

use common\fixtures\AdminUserFixture;
use common\fixtures\AuthItemChildFixture;
use common\fixtures\AuthItemFixture;
use common\models\auth\AuthItem;
use common\models\auth\AuthItemChild;

/**
 * Login form test
 */
class AuthItemTest extends \Codeception\Test\Unit
{
    /**
     * @var \common\tests\UnitTester
     */
    protected $tester;

    /**
     * @return array
     */
    public function _fixtures()
    {
        return ['user'       => ['class'    => AdminUserFixture::class,
                                 'dataFile' => codecept_data_dir() . 'admin_user.php'],
                'auth'       => ['class'    => AuthItemFixture::class,
                                 'dataFile' => codecept_data_dir() . 'auth_data.php'],
                'auth_child' => ['class'    => AuthItemChildFixture::class,
                                 'dataFile' => codecept_data_dir() . 'auth_child_data.php'],];
    }

    /**
     * checks getAuthObject method of AuthItem
     */
    public function testGetAuthObjectFirstTime()
    {
        $model = AuthItem::find()
                         ->where(['name' => 'praktikantTask'])
                         ->one();
        // do some simple check , here:
        $this->assertEquals(AuthItem::TYPE_TASK, $model->type);
        /** @var $model $authItem */
        $model->getAuthObject();

        //'authObject should have been created in AuthItem object'
        $this->assertNotNull($model->authObject);

        // check description
        $this->assertEquals($model->description, $model->getAuthObject()->description);
    }

    public function testUpdateAuthItem()
    {
        /** @var model $authItem */
        $model = AuthItem::find()
                         ->where(['name' => 'praktikantTask'])
                         ->one();
        $this->assertNotNull($model);
        $old_description    = $model->description;
        $model->description = 'some new description';
        $model->update();
        $this->assertNotEquals($old_description, $model->description);
        $changedModel = AuthItem::find()
                                ->where(['name' => 'praktikantTask'])
                                ->one();
        $this->assertEquals($model->description, $changedModel->description);
    }

    /**
     * checks whether child action 'user-stamm.login' is assigned to parent 'praktikantTask'
     */
    public function testGetAssigned()
    {
        /** @var model $authItem */
        $model = AuthItem::find()
                         ->where(['name' => 'praktikantTask'])
                         ->one();
        $this->assertNotNull($model);

        $method = $this->getMethod("common\models\auth\AuthItem", "getAssigned");
        // invoke private static method 'getAssigned' to be tested
        $result = $method->invokeArgs(null, [$model]); // array of AuthItemChild objects
        // prepare check
        $childList = AuthItemChild::find()
                                  ->where(['=', 'auth_item_child.parent', $model->name])
                                  ->all();

        $this->assertNotNull($result);

        // check result: compare result with handmade child list filtered by $model
        // there should be only one entry in $result since there should be only one single parent
        $this->assertEquals(count($result), 1);
        $assigned             = $result[0]->name;
        $assignedInChildTable = $childList[0]->child;
        $this->assertEquals($assigned, $assignedInChildTable);
        // check assignment value
        $this->assertEquals($assignedInChildTable, 'user-stamm.login');
    }


    public function testGetAssignableListForPermissionCustomerLogin()
    {
        /** @var model $authItem */
        $model = AuthItem::find()
                         ->where(['name' => 'user-stamm.login'])
                         ->one();
        // this is a permission, so to it there must not be assigned ANYTHING
        // returned list should be empty

        $assignables = AuthItem::getAssignableList($model);

        // expected results
        $this->assertArrayNotHasKey('Rolle', $assignables);
        $this->assertArrayNotHasKey('Aufgabe', $assignables);
        $this->assertArrayNotHasKey('Recht', $assignables);

    }

    public function testGetAssignableListForCustomerTask()
    {
        /** @var model $authItem */
        $model = AuthItem::find()
                         ->where(['name' => 'customerTask'])
                         ->one();
        // this is a task, so to it there may be assigned:
        // - a task
        // - a permission , here: user-stamm.*
        // --------------------- TEST STEP END ----------------------

        $assignables = AuthItem::getAssignableList($model);

        // expected results
        $this->assertArrayNotHasKey('Rolle', $assignables);
        $this->assertArrayHasKey('Aufgabe', $assignables);
        $this->assertArrayHasKey('Recht', $assignables);
        // expected result: praktikantTask, maxTask (task)
        //                  user-stamm.login, user-stamm.* (permission)
        $tasks = $assignables['Aufgabe'];

        $this->assertEquals(count($tasks), 2);
        $this->assertTrue(in_array('praktikantTask', $tasks));
        $this->assertTrue(in_array('maxTask', $tasks));

        $perms = $assignables['Recht'];

        // permissions left: user-stamm.* and user-stamm.login might be assigned
        $this->assertEquals(count($perms), 2);
        $this->assertTrue(in_array('user-stamm.*', $perms));
        $this->assertTrue(in_array('user-stamm.login', $perms));
    }

    public function testGetAssignableListForRoleCustomerManager()
    {
        /** @var model $authItem */
        $model = AuthItem::find()
                         ->where(['name' => 'customerManager'])
                         ->one();
        // this is a role, so there may be assigned:
        // - a (sub-)role, here 'praktikant'
        // - a task , here customerTask
        // - a permission , here: user-stamm.*
        $assignables = AuthItem::getAssignableList($model);

        // expected results
        $this->assertArrayHasKey('Rolle', $assignables);
        $this->assertArrayHasKey('Aufgabe', $assignables);
        $this->assertArrayHasKey('Recht', $assignables);

        $roles = $assignables['Rolle'];
        // there are the roles admin, customerManager and praktikant
        // since admin never can be assigned (highest)
        // customerManager is ruled out since an object must not be assigned to itself
        // thus praktikant is the only one left
        $this->assertEquals(count($roles), 1);
        $this->assertTrue(in_array('praktikant', $roles));


        $tasks = $assignables['Aufgabe'];

        // customerTask and praktikantTask is already assigned
        // thus they must not be in the list
        // maxTask is the only task left
        $this->assertEquals(count($tasks), 1);
        $this->assertTrue(in_array('maxTask', $tasks));

        $perms = $assignables['Recht'];

        // permissions left: user-stamm.* and user-stamm.login might be assigned
        $this->assertEquals(count($perms), 2);
        $this->assertTrue(in_array('user-stamm.*', $perms));
        $this->assertTrue(in_array('user-stamm.login', $perms));
    }

    public function testGetNotYetAssignedWrongType()
    {
        /** @var model $authItem */
        $model = AuthItem::find()
                         ->where(['name' => 'praktikantTask'])
                         ->one();
        // can not assign role to task
        $this->setExpectedException('Exception');
        AuthItem::getNotYetAssigned($model, [AuthItem::TYPE_ROLE]);
    }

    public function testGetNotYetAssigned()
    {
        /** @var model $authItem */
        $model = AuthItem::find()
                         ->where(['name' => 'praktikantTask'])
                         ->one();

        $list = AuthItem::getNotYetAssigned($model, [AuthItem::TYPE_PERMISSION]);

        // Permission user-stamm.* is the only one which is left:
        $this->assertEquals($list[0]->name,'user-stamm.*');
    }

    public function testGetAuthObjectCreateTask () {
        // create model with task data
        $TASK_NAME = 'handleUserTask';
        $model = new AuthItem();
        $model->setScenario(AuthItem::SCENARIO_CREATE);
        $model->name = $TASK_NAME;
        $model->description = "any description";
        $model->type = AuthItem::TYPE_TASK;
        $authObject = $model->getAuthObject();
        // check if authObject is properly set
        $this->assertEquals($authObject->name, $TASK_NAME);
        $this->assertEquals($authObject->type, AuthItem::TYPE_TASK);
        $this->assertEquals($authObject->description, $model->description);
    }

    public function testHasNoChildren () {
        // create model with task data
        $TASK_NAME = 'customerTask';
        $model = new AuthItem();
        $model->name = $TASK_NAME;
        $model->description = "any description";
        $model->type = AuthItem::TYPE_TASK;
        $hasChildren = $model->hasChildren($model->name);
        $this->assertFalse($hasChildren);
    }
    public function testHasChildren () {
        // create model with task data
        $TASK_NAME = 'praktikantTask';
        $model = new AuthItem();
        $model->name = $TASK_NAME;
        $model->description = "any description";
        $model->type = AuthItem::TYPE_TASK;
        $hasChildren = $model->hasChildren($model->name);
        $this->assertTrue($hasChildren);
    }


    // helper for invoking private static methods
    protected static function getMethod($className, $methodName)
    {
        $class  = new \ReflectionClass($className);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
    }

}
