<?php
/**
 * @author Basic App Dev Team <dev@basic-app.com>
 * @license MIT
 * @link https://basic-app.com
 */
namespace BasicApp\Log;

abstract class BaseLogMigration extends \BasicApp\Migration\BaseMigration
{

    protected $table;

    public function getFields() : array
    {
    }

    public function getDefaultFields() : array
    {
        return [
            'id' => $this->primaryKey()->toArray(),
            'created' => $this->created()->toArray(),
            'message' => $this->string()->default(null)->toArray(),
            'context' => $this->text(65535)->default(null)->toArray()
        ];
    }

    public function beforeCreateTable()
    {
    }

    public function beforeDropTable()
    {
    }

    public function up()
    {
        $this->forge->addField(array_merge(
            $this->getDefaultFields(), 
            $this->getFields()
        ));
        
        $this->forge->addKey('id', true);

        $this->forge->addKey('message', false, false);

        $this->beforeCreateTable();

        $this->forge->createTable($this->table, true);
    }

    public function down()
    {
        $this->beforeDropTable();

        $this->forge->dropTable($this->table, true);
    }

}