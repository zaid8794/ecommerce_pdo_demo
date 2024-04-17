<?php
require_once "Db.php";
class Crud extends Db
{
    public function insert($table_name, $data)
    {
        if (!empty($data)) {
            $fields = $placeholder = [];
            foreach ($data as $field => $value) {
                $fields[] = $field;
                $placeholder[] = ":{$field}";
            }
        }

        $sql = "INSERT INTO {$table_name} (" . implode(',', $fields) . ") VALUES (" . implode(',', $placeholder) . ")";
        $stmt = $this->db->prepare($sql);

        try {
            $this->db->beginTransaction();
            $stmt->execute($data);
            $this->db->commit();
            if ($stmt) {
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function get($table_name, $offset, $records_per_page)
    {
        $sql = "SELECT * FROM $table_name LIMIT $offset, $records_per_page";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function custom_get($table_name, $where = '')
    {
        $sql = "SELECT * FROM $table_name ";
        if (!empty($where)) {
            $sql .= $where;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function update($table_name, $data, $where)
    {
        if (!empty($data)) {
            $fields = '';
            $x = 1;
            $fieldscount = count($data);
            foreach ($data as $field => $value) {
                $fields .= "{$field}=:{$field}";
                if ($x < $fieldscount) {
                    $fields .= ", ";
                }
                $x++;
            }
        }
        $sql = "UPDATE $table_name SET {$fields} $where";
        $stmt = $this->db->prepare($sql);
        try {
            $this->db->beginTransaction();
            $stmt->execute($data);
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $this->db->rollback();
        }
    }

    public function delete($table_name, $where)
    {
        $sql = "DELETE FROM $table_name $where";
        $stmt = $this->db->prepare($sql);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            $this->db->rollback();
        }
    }

    public function pagination($table_name, $no_of_records_per_page)
    {
        $query = "SELECT COUNT(*) FROM $table_name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $total_records = $stmt->fetchColumn();
        $total_pages = ceil($total_records / $no_of_records_per_page);
        return $total_pages;
    }

    public function slugify($text, $slug_url, $table_name)
    {
        $text = preg_replace('/[^a-z0-9]+/i', '-', strtolower($text));
        $query = "SELECT $slug_url FROM $table_name WHERE $slug_url LIKE '$text%'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();
            foreach ($result as $row) {
                $data[] = $row[$slug_url];
            }
            if (in_array($text, $data)) {
                $count = 0;
                while (in_array(($text . '-' . ++$count), $data));
                $text = $text . '-' . $count;
            }
        }
        return $text;
    }
}
