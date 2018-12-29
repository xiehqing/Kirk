<?php
namespace core;
/**
 * 创建工具类
 * Class CreateTool
 * @package core
 */
class CreateTool {
    /**
     * @param array $data
     *      $data['app_tag']
     *      $data['table_name']
     *      $data['db']
     *      $data['pk']
     */
    public function createDao($data){
        $app_tag = strtolower($data['app_tag']);
        $table_name = strtolower($data['table_name']);
        $db = strtolower($data['db'])?:'kirk';
        $pk = strtolower($data['pk'])?:'id';
        $appTag = ucfirst($app_tag);
        $dao_name = ucfirst($table_name);
        $namespace = "Dao\{$appTag}\{$dao_name}";
        $dao_content = <<<EOL
<?php
namespace {$namespace};
use Dao_CacheDao;
class {$dao_name} extends Dao_CacheDao {

    public function get_db_name() {
        return '{$db}';
    }

    public function get_table_name() {
        return '{$table_name}';
    }

    public function get_pk_id() {
        return '{$pk}';
    }
}
EOL;
        $dir = "./core/class/dao/{$app_tag}";
        $dir  = strtolower($dir);

        if(!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        $path = $dir.'/'.$dao_name.'.php';

        file_put_contents($path,$dao_content);
    }

    public function createBll($data){
        $app_tag = strtolower($data['app_tag']);
        $table_name = strtolower($data['table_name']);
        $appTag = ucfirst($app_tag);
        $dao_name = $bll_name = ucfirst($table_name);
        $namespace = "Bll\{$appTag}\{$bll_name}";
        $bll_content = <<<EOL
<?php
namespace {$namespace};
use Bll;

class {$bll_name} extends Bll {


    private function get_dao() {
        \$dao = new \\{$dao_name}();
        return \$dao;
    }
    
    /**
     * 插入数据
     * @param \$data
     * @return bool
     */
    public function insertData(\$data){
        return \$this->get_dao()->insert(\$data);
    }
}
EOL;
        $dir = "./core/class/bll/{$app_tag}";
        $dir  = strtolower($dir);
        if(!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        $path = $dir.'/'.$bll_name.'.php';
        file_put_contents($path,$bll_content);
        echo 'success';
    }
}