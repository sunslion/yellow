<?php
class DatabaseEvent extends Event{
    private function getMemData($mem,$action){
        $keys = array();
        $all_items = $mem->getextendedstats('items');
        foreach ($all_items as $op => $v){
            if (isset($all_items[$op]['items'])) {
                $items = $all_items[$op]['items'];
                foreach ($items as $n => $item){
                    $str = $mem->getextendedstats('cachedump',$n,0);
                    $line = $str[$op];
                    if (is_array($line) && count($line) >0) {
                        foreach ($line as $key => $value){
                            if (empty($action)) {
                                $keys[] = $key;
                            }elseif (strrpos($key, $action) !== false) {
                                $keys[] = $key;
                            }
                        }
                    }
                }
            }
        }
        return $keys;
    }
    public function listen($mem = NULL,$action='') {
        $keys = $this->getMemData($mem->handler, $action);
        $count = count($keys);
        if ($count > 1) {
            $prefix = $mem->options['prefix'];
            foreach ($keys as $k) {
                $k = str_replace($prefix, '', $k);
                if($this->update($k,$mem)){
                    $mem->_unset($k);
                }
            }
        }
    }
    protected function update($key = '',$mem = NULL) {
        global $conn;
        $val = $mem->get($key);var_dump($val);
        if (!empty($val)) {
            $t = $val['t'];
            $set = count($val['set'])>1 ? implode(' , ', $val['set']):$val['set'][0];
            $where = count($val['w'])>1 ? implode(' and ', $val['w']):$val['w'][0];
            
            $sql = "UPDATE {$t} SET {$set} WHERE {$where};";
            $rs = $conn->execute($sql);
            if ($rs) {
                return true;
            }
        }
        return false;
    }
    
    public function insert(){
        
    }
}