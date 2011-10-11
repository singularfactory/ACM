<?php

/**
 * BasePurchaseOrder
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property enum $status
 * @property string $code
 * @property string $remarks
 * @property date $activation_date
 * @property Doctrine_Collection $Items
 * 
 * @method integer             getId()              Returns the current record's "id" value
 * @method enum                getStatus()          Returns the current record's "status" value
 * @method string              getCode()            Returns the current record's "code" value
 * @method string              getRemarks()         Returns the current record's "remarks" value
 * @method date                getActivationDate()  Returns the current record's "activation_date" value
 * @method Doctrine_Collection getItems()           Returns the current record's "Items" collection
 * @method PurchaseOrder       setId()              Sets the current record's "id" value
 * @method PurchaseOrder       setStatus()          Sets the current record's "status" value
 * @method PurchaseOrder       setCode()            Sets the current record's "code" value
 * @method PurchaseOrder       setRemarks()         Sets the current record's "remarks" value
 * @method PurchaseOrder       setActivationDate()  Sets the current record's "activation_date" value
 * @method PurchaseOrder       setItems()           Sets the current record's "Items" collection
 * 
 * @package    bna_green_house
 * @subpackage model
 * @author     Eliezer Talon <elitalon@inventiaplus.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePurchaseOrder extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('purchase_order');
        $this->hasColumn('id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('status', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'pending',
              1 => 'processing',
              2 => 'ready',
              3 => 'sent',
             ),
             ));
        $this->hasColumn('code', 'string', 40, array(
             'type' => 'string',
             'length' => 40,
             ));
        $this->hasColumn('remarks', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('activation_date', 'date', null, array(
             'type' => 'date',
             ));


        $this->index('purchase_order_status', array(
             'fields' => 
             array(
              0 => 'status',
             ),
             ));
        $this->option('type', 'INNODB');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('PurchaseItem as Items', array(
             'local' => 'id',
             'foreign' => 'purchase_order_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}