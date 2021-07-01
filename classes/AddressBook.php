<?php
class AddressBook {
    private $table = 'addressbook';

    private $name, $phone, $address, $city;

    public function setName($name) {
        $this->name = $name;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getAll($sort = 'id', $order = 'ASC') {
        $sql = "SELECT * FROM $this->table ORDER BY $sort $order";
        $stmt = DB::prepared($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        if($stmt-> rowCount() > 0) {
            return $result;
        } else {
            return null;
        }
    }

    public function update($id) {
        $sql  = "UPDATE $this->table SET name=:name, phone=:phone, address=:address, city=:city WHERE id=:id";
        $stmt = DB::prepared($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':city', $this->city);
        return $stmt->execute();
    }

    public function getAddressById($id) {
        $sql = "SELECT * FROM $this->table WHERE id=:id";
        $stmt = DB::prepared($sql);
        $stmt -> bindParam(':id', $id);
        $stmt -> execute();
        return $stmt->fetch();
    }

    public function create() {
        $sql = "INSERT INTO $this->table(name, phone, address, city) VALUES(:name, :phone, :address, :city)";
        $stmt = DB::prepared($sql);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':city', $this->city);
        return $stmt->execute();
    }

    public function getBlankAddress() {
        return ['name' => '', 'phone' => '', 'address' => '', 'city' => ''];
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id=:id";
        $stmt = DB::prepared($sql);
        $stmt -> bindParam(':id', $id);
        return $stmt->execute();
    }
}
