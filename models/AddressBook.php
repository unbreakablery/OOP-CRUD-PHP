<?php
namespace Anthony;

class AddressBook
{

    private $ds;

    private $name, $relationship, $phone, $address, $city, $zip;

    function __construct()
    {
        require_once __DIR__ . '/../lib/DataSource.php';
        $this->ds = new DataSource();
    }

    /**
     * set methods
     *
     */
    public function setName($name) {
        $this->name = htmlspecialchars(trim($name));
    }

    public function setRelationship($relationship) {
        $this->relationship = htmlspecialchars(trim($relationship));
    }

    public function setPhone($phone) {
        $this->phone = htmlspecialchars(trim($phone));
    }

    public function setAddress($address) {
        $this->address = htmlspecialchars(trim($address));
    }

    public function setCity($city) {
        $this->city = htmlspecialchars(trim($city));
    }

    public function setZip($zip) {
        $this->zip = htmlspecialchars(trim($zip));
    }

    /**
     * to get all contacts
     *
     * @return array all contacts list
     */
    public function getAll($sort = 'id', $order = 'ASC')
    {
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            header('Location: ./error.php?message=' . urlencode('You have to login firstly.'));
            exit;
        }

        $sql = "SELECT * FROM addressbook WHERE user_id = ? ORDER BY $sort $order";
        $paramType = 's';
        $paramValue = array(
            $_SESSION['user_id']
        );
        $contacts = $this->ds->select($sql, $paramType, $paramValue);
        return $contacts;
    }

    /**
     * to get blank contact
     *
     * @return array blank contact
     */
    public function getBlankAddress() {
        return [
            'name' => '', 
            'relationship' => '',
            'phone' => '', 
            'address' => '', 
            'city' => '',
            'zip' => ''
        ];
    }

    /**
     * to get contact by ID
     *
     * @return array contact
     */
    public function getAddressById($id) {
        $sql = "SELECT * FROM addressbook WHERE id = ?";
        $paramType = 's';
        $paramValue = array(
            $id
        );
        $contact = $this->ds->select($sql, $paramType, $paramValue);
        return $contact[0];
    }

    /**
     * to create contact
     *
     * @return array response
     */
    public function create() {
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            header('Location: ./error.php?message=' . urlencode('You have to login firstly.'));
            exit;
        }

        $sql = "INSERT INTO addressbook (user_id, name, relationship, phone, address, city, zip) VALUES(?, ?, ?, ?, ?, ?, ?)";
        
        $paramType = 'sssssss';
        $paramValue = array(
            $_SESSION['user_id'],
            $this->name,
            $this->relationship,
            $this->phone,
            $this->address,
            $this->city,
            $this->zip
        );
        $userId = $this->ds->insert($sql, $paramType, $paramValue);
        if (! empty($userId)) {
            $response = array(
                "status" => "success",
                "message" => "New contact saved successfully."
            );
        } else {
            $response = array(
                "status" => "danger",
                "message" => "Error while saving."
            );
        }

        return $response;
    }

    /**
     * to upate contact
     *
     * @return void
     */
    public function update($id) {
        $sql  = "UPDATE addressbook SET name = ?, relationship = ?, phone = ?, address = ?, city = ?, zip = ? WHERE id = ?";
        $paramType = 'sssssss';
        $paramValue = array(
            $this->name,
            $this->relationship,
            $this->phone,
            $this->address,
            $this->city,
            $this->zip,
            $id
        );
        $this->ds->execute($sql, $paramType, $paramValue);
    }

    /**
     * to delete contact
     *
     * @return void
     */
    public function delete($id) {
        $sql = "DELETE FROM addressbook WHERE id = ?";
        $paramType = 's';
        $paramValue = array(
            $id
        );
        $this->ds->execute($sql, $paramType, $paramValue);
    }
}
