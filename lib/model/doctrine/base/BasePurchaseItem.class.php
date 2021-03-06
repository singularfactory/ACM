<?php

/**
 * BasePurchaseItem
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property enum $status
 * @property enum $product
 * @property integer $product_id
 * @property string $code
 * @property integer $amount
 * @property string $remarks
 * @property integer $purchase_order_id
 * @property integer $supervisor_id
 * @property PurchaseOrder $PurchaseOrder
 * @property sfGuardUser $Supervisor
 * 
 * @method integer       getId()                Returns the current record's "id" value
 * @method enum          getStatus()            Returns the current record's "status" value
 * @method enum          getProduct()           Returns the current record's "product" value
 * @method integer       getProductId()         Returns the current record's "product_id" value
 * @method string        getCode()              Returns the current record's "code" value
 * @method integer       getAmount()            Returns the current record's "amount" value
 * @method string        getRemarks()           Returns the current record's "remarks" value
 * @method integer       getPurchaseOrderId()   Returns the current record's "purchase_order_id" value
 * @method integer       getSupervisorId()      Returns the current record's "supervisor_id" value
 * @method PurchaseOrder getPurchaseOrder()     Returns the current record's "PurchaseOrder" value
 * @method sfGuardUser   getSupervisor()        Returns the current record's "Supervisor" value
 * @method PurchaseItem  setId()                Sets the current record's "id" value
 * @method PurchaseItem  setStatus()            Sets the current record's "status" value
 * @method PurchaseItem  setProduct()           Sets the current record's "product" value
 * @method PurchaseItem  setProductId()         Sets the current record's "product_id" value
 * @method PurchaseItem  setCode()              Sets the current record's "code" value
 * @method PurchaseItem  setAmount()            Sets the current record's "amount" value
 * @method PurchaseItem  setRemarks()           Sets the current record's "remarks" value
 * @method PurchaseItem  setPurchaseOrderId()   Sets the current record's "purchase_order_id" value
 * @method PurchaseItem  setSupervisorId()      Sets the current record's "supervisor_id" value
 * @method PurchaseItem  setPurchaseOrder()     Sets the current record's "PurchaseOrder" value
 * @method PurchaseItem  setSupervisor()        Sets the current record's "Supervisor" value
 * 
 * @package    ACM
 * @subpackage model
 * @author     
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePurchaseItem extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('purchase_item');
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
             ),
             ));
        $this->hasColumn('product', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'strain',
              1 => 'culture_medium',
              2 => 'genomic_dna',
             ),
             ));
        $this->hasColumn('product_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('code', 'string', 40, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 40,
             ));
        $this->hasColumn('amount', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('remarks', 'string', null, array(
             'type' => 'string',
             ));
        $this->hasColumn('purchase_order_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('supervisor_id', 'integer', null, array(
             'type' => 'integer',
             ));


        $this->index('purchase_item_status', array(
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
        $this->hasOne('PurchaseOrder', array(
             'local' => 'purchase_order_id',
             'foreign' => 'id',
             'onDelete' => 'cascade'));

        $this->hasOne('sfGuardUser as Supervisor', array(
             'local' => 'supervisor_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $saleable0 = new Saleable();
        $this->actAs($timestampable0);
        $this->actAs($saleable0);
    }
}