<?php
class Query {
    public function __construct() {
        $this->debug = defined('DEBUG') && DEBUG === true;
        $this->having = '';
    }
    
    /* DELETE */
    public function delete($table) {
        // delete_from() alias
        return self::delete_from($table);
    }
    
    public function delete_from($table) {
        $this->delete_from = $table;
        return $this;
    }
    
    public function get_deleted() {
        return self::get_affected();
    }
    
    /* INSERT */
    public function get_insert_id($select = '') {
        // alias for get_inserted_id()
        return self::get_inserted_id($select);
    }
    
    public function get_inserted($select = '') {
        // alias for get_inserted_id()
        return self::get_inserted_id($select);
    }
    
    public function get_inserted_id($select = '') {
        $this->inserted = mysql_insert_id();
        if ('' == $select && 'insert_multiple' != $this->query_type) {
            return $this->inserted;
        }
        else {
            switch ($this->query_type) {
                case 'insert_multiple':
                    $where_equal_to =
                        array(
                            '`id` >= ' . $this->inserted
                        );
                    break;
                default:
                    $where_equal_to =
                        array(
                            '`id`' => $this->inserted
                        );
                    $limit = isset($limit)?$limit:1;
                    self::limit($limit);
                    break;
            }
            // use select
            self::select($select);
            self::from($this->table);
            self::where_equal_to($where_equal_to);
            self::_get_select_query();
            return self::_run_select();
        }
    }
    
    public function insert($table, $keys_and_values, $on_duplicate_key_update = '', $insert_options = '') {
        // insert_into() alias
        return self::insert_into($table, $keys_and_values, $on_duplicate_key_update, $insert_options);
    }
    
    public function insert_ignore($table, $keys_and_values, $on_duplicate_key_update = '') {
        return self::insert_into($table, $keys_and_values, $on_duplicate_key_update, 'IGNORE');
    }
    
    public function insert_into($table, $keys_and_values, $on_duplicate_key_update = '', $insert_options = '') {
        self::_set_table($table);
        self::_set_keys_and_values($keys_and_values);
        $insert_keys = array();
        $insert_values = array();
        foreach ($keys_and_values as $key => $value) {
            $insert_keys[] = $key;
            if (is_null($value)) {
                $insert_values[] = 'NULL';
            }
            elseif (is_int($key)) {
                $insert_values[] = $value;
            }
            elseif (is_array($value)) {
                foreach ($value as $k => $v) {
                    $insert_values[] = sprintf('%s',mysql_real_escape_string($v));
                }
            }
            else {
                $insert_values[] = sprintf('"%s"',mysql_real_escape_string($value));
            }
        }
        self::_set_keys($insert_keys);
        self::_set_values($insert_values);
        self::_on_duplicate_key_update($on_duplicate_key_update);
        $this->insert_into = "\n".
            'INSERT ' . (empty($insert_options)?'':$insert_options.' ') . 'INTO ' . $table.' (' . "\n" .
                "\t" . implode(',' . "\n\t", $insert_keys) . "\n" .
            ')' . "\n" .
            'VALUES (' . "\n" .
                "\t" . implode(',' . "\n\t", $insert_values) . "\n" .
            ')' . "\n" .
            $this->on_duplicate_key_update.
            '';
        return $this;
    }
    
    /* INSERTS */
    public function inserts($table, $keys, $values) {
        // insert_multiple() alias
        return self::insert_multiple($table, $keys, $values);
    }
    
    public function insert_multiple($table, $keys, $values, $on_duplicate_key_update = '') {
        self::_set_table($table);
        $insert_keys = $keys;
        $insert_values = array();
        foreach ($values as $v) {
            $vs = array();
            if (is_array($v)) {
                foreach ($v as $value) {
                    $vs[] = (!is_null($value)?sprintf('"%s"', mysql_real_escape_string($value)):'NULL');
                }
                $insert_values[] = '('.implode(',', $vs) . ')';
            }
            else {
                $insert_values[] = '('.mysql_real_escape_string($v) . ')';
            }
        }
        self::_set_keys($insert_keys);
        self::_set_values($insert_values);
        self::_on_duplicate_key_update($on_duplicate_key_update);
        $this->insert_into = "\n".
            'INSERT INTO ' . $table.'(' . "\n" .
                "\t" . implode(',' . "\n\t", $insert_keys) . "\n" .
            ')' . "\n" .
            'VALUES' . "\n" .
                "\t" . implode(',' . "\n\t", $insert_values) . "\n" .
            $this->on_duplicate_key_update.
            '';
        return $this;
    }
    
    /* REPLACE */
    public function get_replaced() {
        return self::get_affected();
    }
    
    public function replace($table, $keys_and_values) {
        $replace_keys = array();
        $replace_values = array();
        foreach ($keys_and_values as $key => $value) {
            $replace_keys[] = $key;
            $replace_values[] = (!is_null($value)?sprintf('"%s"',mysql_real_escape_string($value)):'NULL');
        }
        $this->replace_into = "\n".
            'REPLACE INTO ' . $table.' (' . "\n" .
                "\t" . implode(',' . "\n\t", $replace_keys) . "\n" .
            ')' . "\n" .
            'VALUES (' . "\n" .
                "\t" . implode(',' . "\n\t", $replace_values) . "\n" .
            ')' . "\n" .
            '';
        return $this;
    }
    
    public function replace_into($table, $keys_and_values) {
        return self::replace($table, $keys_and_values);
    }
    
    /* SELECT */
    public function count() {
        // alias for get_selected_count()
        return self::get_selected_count();
    }
    
    public function get_selected_count() {
        return $this->results;
    }
    
    public function get_selected() {
        // returns an array of the SELECT result(s)
        if (isset($this->limit) && 1==$this->limit) {
            // for use when selecting with limit(1)
            $result = array();
            while($this->result && $result[] = mysql_fetch_assoc($this->result)){}
            array_pop($result);
            $results = array();
            foreach ($result as $values) {
                $results = $values;
            }
        }
        else {
            // for use when selecting with no limit or a limit > 1
            $results = array();
            while($this->result && $results[] = mysql_fetch_assoc($this->result)){}
            array_pop($results);
        }
        
        unset($this->limit);
        unset($this->result);
        return $results;
    }
    
    public function select($select = '*') {
        // SELECT Retrieves fields from one or more tables.
        $this->select = $select;
        return $this;
    }
    
    public function select_from($select, $table) {
        // alias for select() instead of using both select() && from()
        self::select($select);
        self::from($table);
        return $this;
    }
    
    /* UPDATE */
    public function get_updated() {
        return self::get_affected();
    }
    
    public function set($set) {
        $this->set = $set;
        return $this;
    }
    
    public function update($update, $set = array()) {
        $this->update = $update;
        if (!empty($set)) {
            self::set($set);
        }
        return $this;
    }
    
    /* Get helpers */
    private function _set_keys($keys) {
        $this->keys = $keys;
    }
    
    private function _set_keys_and_values($keys_and_values) {
        $this->keys_and_values = $keys_and_values;
    }
    
    private function _set_table($table) {
        $this->table = $table;
    }
    
    private function _set_values($values) {
        $this->values = $values;
    }
    
    /* Query helpers */
    public function distinct($distinct) {
        $this->distinct = $distinct;
        return $this;
    }
    
    public function from($from) {
        // FROM target the specifed tables.
        $this->from = $from;
        return $this;
    }
    
    public function get_affected() {
        // Returns number of affected rows by the last INSERT, UPDATE, REPLACE or DELETE
        return mysql_affected_rows();
    }
    
    public function group_by($group_by) {
        $this->group_by = $group_by;
        return $this;
    }
    
    public function having($having = '', $comparison = '=', $boolean_operator = 'AND') {
        // HAVING Used with GROUP BY to specify the criteria for the grouped records.
        if (empty($having)) {
            $this->having = '';
        }
        else {
            if (!is_array($having)) {
                $this->having =
                    'HAVING' . "\n" .
                        "\t" . $having . "\n" .
                        '';
            }
            else {
                $array = array();
                
                foreach ($having as $k => $v) {
                    if (is_array($v)) {
                        foreach ($v as $key => $value) {
                            $array[] = sprintf($k . ' NOT LIKE "%%%s%%"', mysql_real_escape_string($value));
                        }
                    }
                    else {
                        $array[] = sprintf($k . ' NOT LIKE "%%%s%%"', mysql_real_escape_string($v));
                    }
                }
                
                $this->having =
                    'HAVING' . "\n" .
                        "\t" . implode(' ' . $boolean_operator . "\n\t", $array) . "\n" .
                        '';
            }
        }
        
        return $this;
    }
    
    public function inner_join($inner_join) {
        $this->inner_join = $inner_join;
        return $this;
    }
    
    public function limit($limit) {
        // LIMIT Limit the number of records selected or deleted.
        $this->limit = (int)$limit;
        return $this;
    }
    
    public function offset($offset) {
        $this->offset = (int)$offset;
        return $this;
    }
    
    public function order_by($order_by) {
        $this->order_by = $order_by;
        return $this;
    }
    
    public function page($page) {
        $this->page = (int)$page;
        return $this;
    }
    
    public function range($limit, $offset) {
        // alias instead of using both limit() && offset()
        self::limit($limit);
        self::offset($offset);
        return $this;
    }
    
    public function where_between($where_between) {
        $this->where_between = $where_between;
        return $this;
    }
    
    public function where_equal($where_equal) {
        // alias for where_equal_to()
        return self::where_equal_to($where_equal);
    }
    
    public function where_equal_or($where_equal_or) {
        $this->where_equal_or = $where_equal_or;
        return $this;
    }
    
    public function where_equal_to($where_equal_to) {
        $this->where_equal_to = $where_equal_to;
        return $this;
    }
    
    public function where_greater_than($where_greater_than) {
        $this->where_greater_than = $where_greater_than;
        return $this;
    }
    
    public function where_greater_than_or_equal_to($where_greater_than_or_equal_to) {
        $this->where_greater_than_or_equal_to = $where_greater_than_or_equal_to;
        return $this;
    }
    
    public function where_in($where_in) {
        $this->where_in = $where_in;
        return $this;
    }
    
    public function where_less_than($where_less_than) {
        $this->where_less_than = $where_less_than;
        return $this;
    }
    
    public function where_less_than_or_equal_to($where_less_than_or_equal_to) {
        $this->where_less_than_or_equal_to = $where_less_than_or_equal_to;
        return $this;
    }
    
    public function where_like($where_like) {
        return self::where_like_both($where_like);
    }
    
    public function where_like_after($where_like_after) {
        $this->where_like_after = $where_like_after;
        return $this;
    }
    
    public function where_like_before($where_like_before) {
        $this->where_like_before = $where_like_before;
        return $this;
    }
    
    public function where_like_both($where_like_both) {
        $this->where_like_both = $where_like_both;
        return $this;
    }
    
    public function where_like_binary($where_like_binary) {
        $this->where_like_binary = $where_like_binary;
        return $this;
    }
    
    public function where_like_or($where_like_or) {
        $this->where_like_or = $where_like_or;
        return $this;
    }
    
    public function where_not_equal_or($where_not_equal_or) {
        $this->where_not_equal_or = $where_not_equal_or;
        return $this;
    }
    
    public function where_not_equal_to($where_not_equal_to) {
        $this->where_not_equal_to = $where_not_equal_to;
        return $this;
    }
    
    public function where_not_in($where_not_in) {
        $this->where_not_in = $where_not_in;
        return $this;
    }
    
    public function where_not_like($where_not_like) {
        $this->where_not_like = $where_not_like;
        return $this;
    }
    
    private function _on_duplicate_key_update($on_duplicate_key_update) {
        $this->on_duplicate_key_update = '';
        if (''!==$on_duplicate_key_update && is_array($on_duplicate_key_update)) {
            $update = array();
            foreach ($on_duplicate_key_update as $k => $v) {
                if (is_null($v)) {
                    $update[] = $k.' = NULL';
                }
                elseif (is_int($k)) {
                    $update[] = $v;
                }
                elseif (is_array($v)) {
                    foreach ($v as $key => $value) {
                        if (is_null($value)) {
                            $update[] = $k.' = NULL';
                        }
                        elseif (is_int($k)) {
                            $update[] = $value;
                        }
                        else {
                            $update[] = sprintf($k.' = "%s"',mysql_real_escape_string($value));
                        }
                    }
                }
                else {
                    $update[] = sprintf($k.' = "%s"',mysql_real_escape_string($v));
                }
            }
            $this->on_duplicate_key_update =
                'ON DUPLICATE KEY UPDATE ' . "\n" .
                    "\t" . implode(',' . "\n\t", $update)."\n";
        }
    }
    
    /* GET */
    public function get($use_limit = false) {
        // returns select, insert or update query
        if (self::_get_delete_query()) {
            return $this->delete_query;
        }
        elseif (self::_get_insert_query()) {
            return $this->insert_query;
        }
        elseif (self::_get_select_query($use_limit)) {
            return $this->select_query;
        }
        elseif (self::_get_replace_query()) {
            return $this->replace_query;
        }
        elseif (self::_get_update_query()) {
            return $this->update_query;
        }
        elseif (self::_get_insert_multiple()) {
            return $this->insert_multiple_query;
        }
        else {
            return false;
        }
    }
    
    private function _get_distinct() {
        // FINISH
    }
    
    private function _get_delete_from() {
        return
            'DELETE FROM' . "\n" .
                "\t" . $this->delete_from . "\n" .
                '';
    }
    
    private function _get_delete_query() {
        if (isset($this->delete_from)) {
            $this->query_type = 'delete';
            $this->delete_query = "\n".
                self::_get_delete_from().
                self::_get_where().
                self::_get_order_by().
                self::_get_limit().
                '';
            return true;
        }
        return false;
    }
    
    private function _get_from() {
        if (isset($this->from)) {
            return
                'FROM' . "\n" .
                    "\t" . $this->from . "\n" .
                    '';
        }
        else {
            return '';
        }
    }
    
    private function _get_group_by() {
        // GROUP BY Determines how the records should be grouped.
        if (isset($this->group_by)) {
            if (is_array($this->group_by)) {
                $this->group_by = implode(',' . "\n\t", $this->group_by);
            }
            return
                'GROUP BY' . "\n" .
                    "\t" . $this->group_by . "\n" .
                    '';
        }
    }
    
    private function _get_inner_join() {
        if (isset($this->inner_join)) {
            return
                'INNER JOIN' . "\n" .
                    "\t" . $this->inner_join . "\n" .
                    '';
        }
    }
    
    private function _get_insert_query() {
        if (isset($this->insert_into)) {
            $this->query_type = 'insert_into';
            $this->insert_query = $this->insert_into;
            return true;
        }
        elseif (isset($this->insert_ignore_into)) {
            $this->query_type = 'insert_ignore_into';
            $this->insert_query = $this->insert_ignore_into;
            return true;
        }
        return false;
    }
    
    private function _get_insert_multiple() {
        if (isset($this->insert_multiple)) {
            $this->query_type = 'insert_multiple';
            $this->insert_multiple_query = $this->insert_multiple;
            return true;
        }
        return false;
    }
    
    private function _get_join() {
        // FINISH
        return self::_get_inner_join();
    }
    
    private function _get_limit() {
        if (!isset($this->limit)) {
            return '';
        }
        else {
            if (isset($this->offset)) {
                return
                    'LIMIT' . "\n" .
                        "\t" . $this->offset.', ' . $this->limit . "\n" .
                        '';
            }
            return
                'LIMIT' . "\n" .
                    "\t" . $this->limit . "\n" .
                    '';
        }
    }
    
    private function _get_order_by() {
        // ORDER BY to order the records.
        if (
            !isset($this->order_by) ||
            empty($this->order_by)
            ) {
            return '';
        }
        else {
            if (is_array($this->order_by)) {
                $this->order_by = implode(',' . "\n\t", $this->order_by);
            }
            return
                'ORDER BY' . "\n" .
                    "\t" . $this->order_by . "\n" .
                    '';
        }
    }
    
    private function _get_results() {
        $this->results = mysql_num_rows($this->result);
    }
    
    private function _get_replace_query() {
        if (isset($this->replace_into)) {
            $this->query_type = 'replace_into';
            $this->replace_query = $this->replace_into;
            return true;
        }
        return false;
    }
    
    private function _get_select() {
        if (is_array($this->select)) {
            $selects = array();
            foreach ($this->select as $k => $v) {
                if (false!==strpos($k,'%s')) {
                    $selects[] = sprintf($k,mysql_real_escape_string($v));
                }
                else {
                    $selects[] = $v;
                }
            }
            return
                'SELECT' . "\n" .
                    "\t" . implode(',' . "\n\t", $selects) . "\n" .
                    '';
        }
        elseif (empty($this->select)) {
            return
                'SELECT' . "\n" .
                    "\t" . '*' . "\n" .
                    '';
        }
        else {
            return
                'SELECT' . "\n" .
                    "\t" . $this->select . "\n" .
                    '';
        }
    }
    
    private function _get_select_query($use_limit = null) {
        if (isset($this->select)) {
            $this->query_type = 'select';
            $this->select_query = "\n".
                self::_get_select().
                self::_get_from().
                self::_get_join().
                self::_get_where().
                self::_get_group_by().
                $this->having .
                self::_get_order_by().
                ($use_limit || (!isset($this->page) && !isset($this->offset)) ? self::_get_limit() : '').
                '';
                                
            return true;
        }
        return false;
    }
    
    private function _get_set() {
        $sets = array();
        $set_equals = array();
        
        foreach ($this->set as $k => $v) {
            if (is_null($v)) {
                $set_equals[] = $k . ' = NULL';
            }
            elseif (is_int($k)) {
                $set_equals[] = $v;
            }
            elseif (is_int($v)) {
                $set_equals[] = sprintf($k . ' = %s', mysql_real_escape_string($v));
            }
            else {
                $set_equals[] = sprintf($k . ' = "%s"', mysql_real_escape_string($v));
            }
        }
        
        $sets[] = implode(', ' . "\n\t", $set_equals);
        
        return
            'SET' . "\n" .
                "\t" . implode(',' . "\n\t", $sets) . "\n" .
                '';
    }
    
    private function _get_update() {
        return
            'UPDATE' . "\n" .
                "\t" . $this->update . "\n" .
                '';
    }
    
    private function _get_update_query() {
        if (isset($this->update)) {
            $this->query_type = 'update';
            $this->update_query = "\n".
                self::_get_update().
                self::_get_set().
                self::_get_where().
                self::_get_limit().
                '';
            return true;
        }
        return false;
    }
    
    private function _get_where() {
        $wheres = array();
        $where_greater_than = self::_get_where_greater_than();
        $where_greater_than_or_equal_to = self::_get_where_greater_than_or_equal_to();
        $where_in = self::_get_where_in();
        $where_less_than = self::_get_where_less_than();
        $where_less_than_or_equal_to = self::_get_where_less_than_or_equal_to();
        $where_equal_or = self::_get_where_equal_or();
        $where_equal_to = self::_get_where_equal_to();
        $where_not_in = self::_get_where_not_in();
        $where_not_equal_or = self::_get_where_not_equal_or();
        $where_not_equal_to = self::_get_where_not_equal_to();
        $where_like_after = self::_get_where_like_after();
        $where_like_before = self::_get_where_like_before();
        $where_like_both = self::_get_where_like_both();
        $where_like_or = self::_get_where_like_or();
        $where_not_like = self::_get_where_not_like();
        $where_like_binary = self::_get_where_like_binary();
        if (!empty($where_greater_than)) {
            $wheres[] = $where_greater_than;
        }
        if (!empty($where_in)) {
            $wheres[] = $where_in;
        }
        if (!empty($where_greater_than_or_equal_to)) {
            $wheres[] = $where_greater_than_or_equal_to;
        }
        if (!empty($where_less_than)) {
            $wheres[] = $where_less_than;
        }
        if (!empty($where_less_than_or_equal_to)) {
            $wheres[] = $where_less_than_or_equal_to;
        }
        if (!empty($where_equal_or)) {
            $wheres[] = $where_equal_or;
        }
        if (!empty($where_equal_to)) {
            $wheres[] = $where_equal_to;
        }
        if (!empty($where_not_equal_or)) {
            $wheres[] = $where_not_equal_or;
        }
        if (!empty($where_not_in)) {
            $wheres[] = $where_not_in;
        }
        if (!empty($where_not_equal_to)) {
            $wheres[] = $where_not_equal_to;
        }
        if (!empty($where_like_after)) {
            $wheres[] = $where_like_after;
        }
        if (!empty($where_like_before)) {
            $wheres[] = $where_like_before;
        }
        if (!empty($where_like_both)) {
            $wheres[] = $where_like_both;
        }
        if (!empty($where_like_or)) {
            $wheres[] = $where_like_or;
        }
        if (!empty($where_not_like)) {
            $wheres[] = $where_not_like;
        }
        if (!empty($where_like_binary)) {
            $wheres[] = $where_like_binary;
        }
        if (empty($wheres)) {
            return '';
        }
        else {
            return
                'WHERE' . "\n" .
                    "\t" . implode('AND' . "\n\t", $wheres) . "\n" .
                    '';
        }
    }
    
    private function _get_where_between() {
        // FINISH
        // BETWEEN Checks for values between a range
    }
    
    private function _get_where_equal_or() {
        if (
            !isset($this->where_equal_or) ||
            !is_array($this->where_equal_or) ||
            empty($this->where_equal_or)
            ) {
            return '';
        }
        else {
            $where_equal_or = array();
            foreach ($this->where_equal_or as $k => $v) {
                if (is_null($v)) {
                    $where_equal_or[] = $k.' IS NULL';
                }
                elseif (is_int($k)) {
                    $where_equal_or[] = $v;
                }
                elseif (is_array($v)) {
                    foreach ($v as $key => $value) {
                        if (is_null($value)) {
                            $where_equal_or[] = $k.' IS NULL';
                        }
                        elseif (is_int($k)) {
                            $where_equal_or[] = $value;
                        }
                        else {
                            $where_equal_or[] = sprintf($k.' = "%s"',mysql_real_escape_string($value));
                        }
                    }
                }
                else {
                    $where_equal_or[] = sprintf($k.' = "%s"',mysql_real_escape_string($v));
                }
            }
            return
                '(' . "\n" .
                    "\t\t" . implode(' OR' . "\n\t\t", $where_equal_or) . "\n" .
                    "\t" .
                ') ';
        }
    }
    
    private function _get_where_equal_to() {
        // = Equal to
        if (
            !isset($this->where_equal_to) ||
            !is_array($this->where_equal_to) ||
            empty($this->where_equal_to)
            ) {
            return '';
        }
        else {
            $where_equal_to = array();
            foreach ($this->where_equal_to as $k => $v) {
                if (is_null($v)) {
                    $where_equal_to[] = $k . ' IS NULL';
                }
                elseif (is_int($k)) {
                    $where_equal_to[] = $v;
                }
                elseif (is_int($v)) {
                    $where_equal_to[] = sprintf($k . ' = %s',mysql_real_escape_string($v));
                }
                elseif (is_array($v)) {
                    foreach ($v as $key => $value) {
                        $where_equal_to[] = sprintf($k . ' = "%s"', mysql_real_escape_string($value));
                    }
                }
                else {
                                                
                             
                    $where_equal_to[] = sprintf($k . ' = "%s"',mysql_real_escape_string($v));
                }
            }
            return implode(' AND' . "\n\t", $where_equal_to) . ' ';
        }
    }
    
    private function _get_where_greater_than() {
        // > greater than
        if (
            !isset($this->where_greater_than) ||
            !is_array($this->where_greater_than) ||
            empty($this->where_greater_than)
            ) {
            return '';
        }
        else {
            $where_greater_than = array();
            foreach ($this->where_greater_than as $k => $v) {
                if (is_null($v)) {
                    $where_greater_than[] = $k.' IS NULL';
                }
                elseif (is_int($k)) {
                    $where_greater_than[] = $v;
                }
                elseif (is_int($v)) {
                    $where_greater_than[] = sprintf($k.' > %s',mysql_real_escape_string($v));
                }
                else {
                    $where_greater_than[] = sprintf($k.' > "%s"',mysql_real_escape_string($v));
                }
            }
            return implode(' AND' . "\n\t", $where_greater_than) . ' ';
        }
    }
    
    private function _get_where_greater_than_or_equal_to() {
        // >= greater than or equal to
        if (
            !isset($this->where_greater_than_or_equal_to) ||
            !is_array($this->where_greater_than_or_equal_to) ||
            empty($this->where_greater_than_or_equal_to)
            ) {
            return '';
        }
        else {
            $where_greater_than_or_equal_to = array();
            foreach ($this->where_greater_than_or_equal_to as $k => $v) {
                if (is_null($v)) {
                    $where_greater_than_or_equal_to[] = $k.' IS NULL';
                }
                elseif (is_int($k)) {
                    $where_greater_than_or_equal_to[] = $v;
                }
                elseif (is_int($v)) {
                    $where_greater_than_or_equal_to[] = sprintf($k.' >= %s',mysql_real_escape_string($v));
                }
                else {
                    $where_greater_than_or_equal_to[] = sprintf($k.' >= "%s"',mysql_real_escape_string($v));
                }
            }
            return implode(' AND' . "\n\t", $where_greater_than_or_equal_to) . ' ';
        }
    }
    
    private function _get_where_in() {
        // IN Checks for values in a list
        if (
            !isset($this->where_in) ||
            !is_array($this->where_in) ||
            empty($this->where_in)
            ) {
            return '';
        }
        else {
            $where_in = array();
            
            foreach ($this->where_in as $k => $v) {
                if (is_null($v)) {
                    $where_in[] = $k . ' IS NULL';
                }
                elseif (is_int($k)) {
                    $where_in[] = $v;
                }
                elseif (is_int($v)) {
                    $where_in[] = sprintf($k . ' IN(%s)', mysql_real_escape_string($v));
                }
                elseif (is_array($v)) {
                    $values = array();
                    foreach ($v as $value) {
                        $values[] = '"' . mysql_real_escape_string($value) . '"';
                    }
                    $where_in[] = sprintf($k . ' IN(%s)', implode(', ', $values));
                }
                else {
                    $where_in[] = sprintf($k . ' IN(%s)', mysql_real_escape_string($v));
                }
            }
            
            return implode(' AND' . "\n\t", $where_in) . ' ';
        }
    }
    
    private function _get_where_less_than() {
        // < Less than
        if (
            !isset($this->where_less_than) ||
            !is_array($this->where_less_than) ||
            empty($this->where_less_than)
            ) {
            return '';
        }
        else {
            $where_less_than = array();
            foreach ($this->where_less_than as $k => $v) {
                if (is_null($v)) {
                    $where_less_than[] = $k.' IS NULL';
                }
                elseif (is_int($k)) {
                    $where_less_than[] = $v;
                }
                elseif (is_int($v)) {
                    $where_less_than[] = sprintf($k.' < %s',mysql_real_escape_string($v));
                }
                else {
                    $where_less_than[] = sprintf($k.' < "%s"',mysql_real_escape_string($v));
                }
            }
            return implode(' AND' . "\n\t", $where_less_than) . ' ';
        }
    }
    
    private function _get_where_less_than_or_equal_to() {
        // <= Less than or equal to
        if (
            !isset($this->where_less_than_or_equal_to) ||
            !is_array($this->where_less_than_or_equal_to) ||
            empty($this->where_less_than_or_equal_to)
            ) {
            return '';
        }
        else {
            $where_less_than_or_equal_to = array();
            foreach ($this->where_less_than_or_equal_to as $k => $v) {
                if (is_null($v)) {
                    $where_less_than_or_equal_to[] = $k.' IS NULL';
                }
                elseif (is_int($k)) {
                    $where_less_than_or_equal_to[] = $v;
                }
                elseif (is_int($v)) {
                    $where_less_than_or_equal_to[] = sprintf($k.' <= %s',mysql_real_escape_string($v));
                }
                else {
                    $where_less_than_or_equal_to[] = sprintf($k.' <= "%s"',mysql_real_escape_string($v));
                }
            }
            return implode(' AND' . "\n\t", $where_less_than_or_equal_to) . ' ';
        }
    }
    
    private function _get_where_like_after() {
        if (
            !isset($this->where_like_after) ||
            !is_array($this->where_like_after) ||
            empty($this->where_like_after)
            ) {
            return '';
        }
        else {
            $where_like_after = array();
            foreach ($this->where_like_after as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $key => $value) {
                        $where_like_after[] = sprintf($k.' LIKE "%s%%"', mysql_real_escape_string($value));
                    }
                }
                else {
                    $where_like_after[] = sprintf($k.' LIKE "%s%%"', mysql_real_escape_string($v));
                }
            }
            return implode(' AND' . "\n\t", $where_like_after) . ' ';
        }
    }
    
    private function _get_where_like_before() {
        if (
            !isset($this->where_like_before) ||
            !is_array($this->where_like_before) ||
            empty($this->where_like_before)
            ) {
            return '';
        }
        else {
            $where_like_before = array();
            foreach ($this->where_like_before as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $key => $value) {
                        $where_like_before[] = sprintf($k.' LIKE "%%%s"', mysql_real_escape_string($value));
                    }
                }
                else {
                    $where_like_before[] = sprintf($k.' LIKE "%%%s"', mysql_real_escape_string($v));
                }
            }
            return implode(' AND' . "\n\t", $where_like_before) . ' ';
        }
    }
    
    private function _get_where_like_both() {
        if (
            !isset($this->where_like_both) ||
            !is_array($this->where_like_both) ||
            empty($this->where_like_both)
            ) {
            return '';
        }
        else {
            $where_like_both = array();
            foreach ($this->where_like_both as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $key => $value) {
                        $where_like_both[] = sprintf($k.' LIKE "%%%s%%"', mysql_real_escape_string($value));
                    }
                }
                else {
                    $where_like_both[] = sprintf($k.' LIKE "%%%s%%"', mysql_real_escape_string($v));
                }
            }
            return implode(' AND' . "\n\t", $where_like_both) . ' ';
        }
    }
    
    private function _get_where_like_binary() {
        if (
            !isset($this->where_like_binary) ||
            !is_array($this->where_like_binary) ||
            empty($this->where_like_binary)
            ) {
            return '';
        }
        else {
            $where_like_binary = array();
            foreach ($this->where_like_binary as $k => $v) {
                if (!is_null($v)) {
                    $where_like_binary[] = sprintf($k.' LIKE BINARY "%s"',mysql_real_escape_string($v));
                }
            }
            return implode(' AND' . "\n\t", $where_like_binary) . ' ';
        }
    }
    
    private function _get_where_like_or() {
        if (
            !isset($this->where_like_or) ||
            !is_array($this->where_like_or) ||
            empty($this->where_like_or)
            ) {
            return '';
        }
        else {
            $where_like_or = array();
            foreach ($this->where_like_or as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $key => $value) {
                        $where_like_or[] = sprintf($k.' LIKE "%%%s%%"',mysql_real_escape_string($value));
                    }
                }
                else {
                    $where_like_or[] = sprintf($k.' LIKE "%%%s%%"',mysql_real_escape_string($v));
                }
            }
            return
                '(' . "\n" .
                    "\t\t" . implode(' OR' . "\n\t\t", $where_like_or) . "\n" .
                    "\t" .
                ') ';
        }
    }
    
    private function _get_where_not_equal_or() {
        // <> Not equal to
        // != Not equal to
        if (
            !isset($this->where_not_equal_or) ||
            !is_array($this->where_not_equal_or) ||
            empty($this->where_not_equal_or)
            ) {
            return '';
        }
        else {
            $where_not_equal_or = array();
            foreach ($this->where_not_equal_or as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $key => $value) {
                        $where_not_equal_or[] = sprintf($k.' <> "%%%s%%"',mysql_real_escape_string($value));
                    }
                }
                else {
                    $where_not_equal_or[] = sprintf($k.' <> "%%%s%%"',mysql_real_escape_string($v));
                }
            }
            return
                '(' . "\n" .
                    "\t\t" . implode(' OR' . "\n\t\t", $where_not_equal_or) . "\n" .
                    "\t" .
                ') ';
        }
    }
    
    private function _get_where_not_equal_to() {
        // <> Not equal to
        // != Not equal to
        if (
            !isset($this->where_not_equal_to) ||
            !is_array($this->where_not_equal_to) ||
            empty($this->where_not_equal_to)
            ) {
            return '';
        }
        else {
            $where_not_equal_to = array();
            foreach ($this->where_not_equal_to as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $key => $value) {
                        $where_not_equal_to[] = is_null($value) ? $key . ' IS NOT NULL' : sprintf($k . ' != "%s"', mysql_real_escape_string($value));
                    }
                }
                else {
                    $where_not_equal_to[] = is_null($v) ? $k . ' IS NOT NULL' : sprintf($k . ' != "%s"', mysql_real_escape_string($v));
                }
            }
            return
                '(' . "\n" .
                    "\t\t" . implode(' AND' . "\n\t\t", $where_not_equal_to) . "\n" .
                    "\t" .
                ') ';
        }
    }
    
    private function _get_where_not_in() {
        // NOT IN Ensures the value is not in the list
        if (
            !isset($this->where_not_in) ||
            !is_array($this->where_not_in) ||
            empty($this->where_not_in)
            ) {
            return '';
        }
        else {
            $where_not_in = array();
            
            foreach ($this->where_not_in as $key => $values) {
                if (is_array($values)) {
                    $vs = array();
                    foreach ($values as $k => $v) {
                        if (is_null($v)) {
                            $vs[] = 'NULL';
                        }
                        elseif (is_int($v)) {
                            $vs[] = $v;
                        }
                        else {
                            $vs[] = sprintf('"%s"', mysql_real_escape_string($v));
                        }
                    }
                    $where_not_in[] =
                        $key . ' NOT IN (' . "\n\t\t" .
                            implode(', ' . "\n\t\t", $vs) . "\n\t" .
                        ')';
                }
                else {
                    $where_not_in[] =
                        $key . ' NOT IN (' . "\n\t\t" .
                            $values . "\n\t" .
                        ')';
                }
            }
            
            return implode(' AND' . "\n\t", $where_not_in) . ' ';
        }
    }
    
    private function _get_where_not_like() {
        // NOT LIKE Used to compare strings
        if (
            !isset($this->where_not_like) ||
            !is_array($this->where_not_like) ||
            empty($this->where_not_like)
            ) {
            return '';
        }
        else {
            $where_not_like = array();
            foreach ($this->where_not_like as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $key => $value) {
                        $where_not_like[] = sprintf($k.' NOT LIKE "%%%s%%"',mysql_real_escape_string($value));
                    }
                }
                else {
                    $where_not_like[] = sprintf($k.' NOT LIKE "%%%s%%"',mysql_real_escape_string($v));
                }
            }
            return implode(' AND' . "\n\t", $where_not_like) . ' ';
        }
    }
    
    private function _key_value($key, $value, $operator = '=') {
        $value = (substr($value, 0, 1) == '!' ? substr($value, 1) : '"' . $value . '"');
        return sprintf($key . $operator . ' %s ', mysql_real_escape_string($value));
    }
    
    /* RUN */
    public function run() {
        // runs query, returns mysql result
        if (self::get()) {
            $function = '_run_' . $this->query_type;
            switch ($this->query_type) {
                case 'delete':
                case 'insert_ignore_into':
                case 'insert_into':
                case 'insert_multiple':
                case 'replace_into':
                case 'update':
                    return self::$function();
                    break;
                case 'select':
                    if (!(isset($this->page) || isset($this->offset))) {
                        // no pagination
                        return self::$function();
                    }
                    else {
                        // with pagination
                        if (self::$function()) {
                            // for pagination:
                            $this->perpage = $this->limit; // for get_perpage()
                            $this->total = $this->results; // for get_total()
                            // calculate pages
                            $this->pages = (int)ceil($this->results / $this->limit);
                            // set offset
                            if (!isset($this->offset)) {
                                self::offset(($this->page * $this->limit) - $this->limit);
                            }
                            else {
                                // calculate page using offset and perpage
                                // determine on what page the offset would be on
                                for($page = 1; $page <= $this->pages; $page++) {
                                    if ($this->offset - 1 < $page * $this->perpage) {
                                        $this->page = $page;
                                        break;
                                    }
                                }
                            }
                            // update select query with limit now that pages is set
                            self::_get_select_query(true);
                            // run select query with updated limit and offset
                            return self::_run_select();
                                                        
                        }
                    }
                    break;
                default:
                    die('err: bad query type:' . $this->query_type);
                    break;
            }
                        
        }
        
        return false;
    }
    
    private function _run_delete() {
        return self::_run_query($this->delete_query);
    }
    
    private function _run_insert_ignore_into() {
        return self::_run_query($this->insert_query);
    }
    
    private function _run_insert_into() {
        return self::_run_query($this->insert_query);
    }
    
    private function _run_insert_multiple() {
        return self::_run_query($this->insert_multiple_query);
    }
    
    private function _run_replace_into() {
        return self::_run_query($this->replace_into);
    }
    
    private function _run_select() {
        return self::_run_query($this->select_query);
    }
    
    private function _run_update() {
        return self::_run_query($this->update_query);
    }
    
    private function _run_query($query) {
        $this->result = mysql_query($query);
        
        if (!$this->result) {
            $this->mysql_error = mysql_error();
            
            if ($this->debug) {
                $this->error = 'Error in query: ' . $this->mysql_error;
            }
            else {
                $this->error = 'Error in query.';
            }
            
            if (function_exists('error')) {
                error($this->error);
            }
            
            die($this->error);
        }
        
        switch ($this->query_type) {
            case 'delete':
                return self::get_affected();
            case 'insert_into':
                return self::get_inserted_id();
            case 'insert_multiple':
                return true;
            case 'replace_into':
                return self::get_affected();
            case 'select':
                self::_get_results();
                if ($this->result && $this->results > 0) {
                    return $this->result;
                }
                return false;
            case 'update':
                return self::get_affected();
        }
    }
    
    /* SHOW */
    public function show() {
        if (headers_sent()) {
            echo '<pre>';
            echo self::get(true);
            echo '</pre>';
        }
        else {
            header('Content-Type: text/plain');
            echo self::get(true);
        }
        return $this;
    }
    
    /* DISPLAY */
    public function display() {
        // show() alias
        return self::show();
    }
    
    /* PAGINATION */
    public function get_page() {
        return $this->page;
    }
    
    public function get_pages() {
        return $this->pages;
    }
    
    public function get_perpage() {
        return $this->perpage;
    }
    
    public function get_total() {
        return $this->total;
    }
    
    public  function ge_fetch_array($sql)
		{
			$res=mysql_query($sql) or die("query is wrong");
			$table = array();
			if(mysql_num_rows($res)>0)
			{
				
						$i = 0;
        				while($table[$i] = mysql_fetch_array($res)) 
            				$i++;
        				unset($table[$i]);                                                                                  
					
			}
				
			
				mysql_free_result($res);
				return $table;
			
		}
		public  function ge_fetch_assoc($sql)
		{
			$res=mysql_query($sql) or die("query is wrong");
			$table = array();
			if(mysql_num_rows($res)>0)
			{
				
						$i = 0;
        				while($table[$i] = mysql_fetch_assoc($res)) 
            				$i++;
        				unset($table[$i]);                                                                                  
					
			}
				
			
				mysql_free_result($res);
				return $table;
			
		}
		public  function ge_fetch_row($sql)
		{
			$res=mysql_query($sql) or die("query is wrong");
			$table = array();
			if(mysql_num_rows($res)>0)
			{
        				$table = mysql_fetch_array($res);
			}
				mysql_free_result($res);
				return $table;
			
		}
		public  function ge_fetch_column($sql,$column=0)
		{
			$res=mysql_query($sql) or die("query is wrong");
			$table = array();
			if(mysql_num_rows($res)>0)
			{
			 	   while($array = mysql_fetch_array($res)){
			 	       $table[] = $array[$column];
			 	   } 
        				
			}
				mysql_free_result($res);
				return $table;
			
		}
		
		public  function ge_insert($table, $inserts) 
		{
			$values = array_map('mysql_real_escape_string', array_values($inserts));
			$keys = array_keys($inserts);
			//echo 'INSERT INTO `'.$table.'` (`'.implode('`,`', $keys).'`) VALUES (\''.implode('\',\'', $values).'\')';   
			return self::ge_query('INSERT INTO `'.$table.'` (`'.implode('`,`', $keys).'`) VALUES (\''.implode('\',\'', $values).'\')');
		}
		public  function ge_update($table,$array,$Pkey,$PKval)
		{
			foreach($array as $key => $value) {
    			$update.="`".trim($key)."`='".trim($value)."',";    
			}
			$update=substr($update,0,strlen($update)-1);
			return self::ge_query("UPDATE `".$table."` SET ".$update." WHERE `".$Pkey."`='".$PKval."'");
		}
		public  function ge_update_cond($table,$array,$cond)
		{
			foreach($array as $key => $value) {
    			$update.="`".trim($key)."`='".trim($value)."',";    
			}
			$update=substr($update,0,strlen($update)-1);
			return self::ge_query("UPDATE `".$table."` SET ".$update." WHERE ".$cond);
		}
		public  function ge_delete($table,$cond)
		{
			foreach($array as $key => $value) {
    			$update.="`".trim($key)."`='".trim($value)."',";    
			}
			$update=substr($update,0,strlen($update)-1);
			return self::ge_query("DELETE FROM `".$table." WHERE ".$cond);
		}
		public  function ge_table($table)
		{
			$sql = "SHOW COLUMNS FROM $table";
			$ts = mysql_query($sql);
			$cts = mysql_num_rows($ts);
			while($ats = mysql_fetch_array($ts))
			{
				if($ats['Key'] == "PRI")
				{
					$Primkey=$ats['Field'];
				}
			}
			
			echo "<table width='100%'>";
			$res=mysql_query("Select * from `$table`");
			if(mysql_num_rows($res)>0)
			{
				echo "<tr>";
				
					for($i=0;$i<mysql_num_fields($res);$i++)
						echo "<th>". mysql_field_name($res,$i)."</th>";
				
					echo "<th><a href='?key=$Primkey&action=edit' >EDIT</a></th><th><a href='?key=$Primkey&action=delete'>Delete</a></th>";
				echo "</tr>";

				
				echo "<tr>";
				while($array=mysql_fetch_array($res))
				{
					for($i=0;$i<mysql_num_fields($res);$i++)
						echo "<td>".$array[$i]."</td>";
				}
				echo "</tr>";
			}
			echo "<table>";	
		}
		
		public  function secureGET($key)
    	{
        	$_GET[$key] = htmlspecialchars(stripslashes($_GET[$key]));
        	$_GET[$key] = str_ireplace("script", "blocked", $_GET[$key]);
       		$_GET[$key] = mysql_escape_string($_GET[$key]);
			$_GET[$key] = mysql_real_escape_string($_GET[$key]);
			$_GET[$key] = preg_replace("/[^a-zA-Z0-9 s]/", "", $_GET[$key]);
			
        	return $_GET[$key];
    	}
   
    	public  function securePOST($key)
    	{
        	$_POST[$key] = htmlspecialchars(stripslashes($_POST[$key]));
       	 	$_POST[$key] = str_ireplace("script", "blocked", $_POST[$key]);
        	$_POST[$key] = mysql_escape_string($_POST[$key]);
			$_POST[$key] = preg_replace("/[^a-zA-Z0-9 s]/", "", $_POST[$key]);
        	return $_POST[$key];
    	}
		
		public  function secureREQUEST($key)
    	{
        	$_REQUEST[$key] = htmlspecialchars(stripslashes($_REQUEST[$key]));
       	 	$_REQUEST[$key] = str_ireplace("script", "blocked", $_REQUEST[$key]);
        	$_REQUEST[$key] = mysql_escape_string($_REQUEST[$key]);
			$_REQUEST[$key] = preg_replace("/[^a-zA-Z0-9 s]/", "", $_REQUEST[$key]);
        	return $_REQUEST[$key];
    	}
		
		public  function removeSpecChar($val)
		{
			$val = preg_replace("/[^a-zA-Z0-9 ._s]/", "", $val);
			return $val;
		}
		public  function ge_query($string)
		{
			
			$result = mysql_query($string);
		
			if ($result == false)
			{
				error_log("SQL error: ".mysql_error()."\n\nOriginal query: $string\n");
				// Remove following line from production servers 
				die("SQL error: ".mysql_error()."\b<br>\n<br>Original query: $string \n<br>\n<br>");
			}
			return $result;
		}

		public  function ge_fetch_list($sql)
		{
			// this public  function require presence of good_query() public  function
			$result = self::ge_query($sql);
			
			if($lst = mysql_fetch_row($result))
			{
				mysql_free_result($result);
				return $lst;
			}
			mysql_free_result($result);
			return false;
		}

		public  function ge_value($sql)
		{
			// this public  function require presence of good_query_list() public  function
			$lst = self::ge_fetch_list($sql);
			return is_array($lst)?$lst[0]:false;
		}
		public  function ge_values($sql)
		{
			// this public  function require presence of good_query_list() public  function
			$lst = self::ge_fetch_list($sql);
			return is_array($lst)?$lst:false;
		}
		
		public  function ge_generate_id($prefix,$length = 5)
		{
		
		  $password = str_replace(' ', '', $prefix);
		  $possible = '0123456789bcdfghjkmnpqrstvwxyz'; 
			
		  $i = 0; 
		  while ($i < $length)
			{ 
			$password .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
			}
		
		  return $password;
		
		}
		
		public  function ge_checkfild($table,$fild,$value)
		{
			global $sqlfun;
            
            $res=$sqlfun->ge_value("select COUNT(*) from `".$table."` where `".$fild."`='".$value."'");
			if($res)
				return false;
			else
				return true;
		}
    
}
?>