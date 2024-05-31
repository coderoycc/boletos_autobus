<?php // propietario -> user principal
namespace App\Models;

use App\Config\Accesos;
use App\Config\Database;
use PDO;

class User {
  private $con;
  public int $id;
  public string $fullname;
  public string $username;
  public string $role;
  public string $password;
  public int $status;

  // public string $color; // color de menu
  public function __construct($db = null, $id_user = null) {
    $this->objectNull();
    if ($db) {
      $this->con = $db;
      if ($id_user != null) {
        $sql = "SELECT * FROM users WHERE id = :id_user";
        $stmt = $this->con->prepare($sql);
        $stmt->execute(['id_user' => $id_user]);
        $row = $stmt->fetch();
        if ($row) {
          $this->load($row);
        }
      }
    }
  }

  public function objectNull() {
    $this->id = 0;
    $this->fullname = '';
    $this->username = '';
    $this->role = '';
    $this->password = '';
    $this->status = 0;
  }
  public function resetPass() {
    if ($this->con == null)
      return false;
    try {
      $sql = "UPDATE users SET password = :password WHERE id = :id_user";
      $stmt = $this->con->prepare($sql);
      $pass = hash('sha256', $this->username);
      return $stmt->execute(['password' => $pass, 'id_user' => $this->id]);
    } catch (\Throwable $th) {
      return false;
    }
  }
  public function newPass($newPass) { /// cambio de password
    if ($this->con == null)
      return false;
    try {
      $sql = "UPDATE users SET password = :password WHERE id = :id_user";
      $stmt = $this->con->prepare($sql);
      $pass = hash('sha256', $newPass);
      return $stmt->execute(['password' => $pass, 'id_user' => $this->id]);
    } catch (\Throwable $th) {
      return false;
    }
  }
  public function save() {
    if ($this->con == null)
      return -1;
    try {
      $resp = 0;
      $this->con->beginTransaction();
      if ($this->id == 0) { //insert
        $sql = "INSERT INTO users (username, fullname, role, password) VALUES (:user, :first_name, :role, :password)";
        $params = ['user' => $this->username, 'first_name' => $this->fullname, 'role' => $this->role, 'password' => $this->password];
        $stmt = $this->con->prepare($sql);
        $res = $stmt->execute($params);
        if ($res) {
          $this->con->commit();
          $this->id = $this->con->lastInsertId();
          $resp = $this->id;
        } else {
          $resp = -1;
          $this->con->rollBack();
        }
      } else { // update
        $sql = "UPDATE users SET username = :username, fullname = :fullname, role = :role WHERE id = :id";
        $params = ['username' => $this->username, 'fullname' => $this->fullname, 'role' => $this->role, 'id' => $this->id];
        $stmt = $this->con->prepare($sql);
        if ($stmt->execute($params)) {
          $this->con->commit();
          $resp = $this->id;
        } else {
          $this->con->rollBack();
          $resp = -1;
        }
      }
      return $resp;
    } catch (\Throwable $th) {
      print_r($th);
      $this->con->rollBack();
      return -1;
    }
  }

  public function load($row) {
    $this->id = $row['id'];
    $this->fullname = $row['fullname'];
    $this->username = $row['username'];
    $this->role = $row['role'];
    $this->password = $row['password'];
    $this->status = $row['status'] ?? 0;
  }
  public function delete() {
    if ($this->con == null)
      return false;
    try {
      $this->con->beginTransaction();
      $sql = "DELETE FROM users WHERE id = :id";
      $stmt = $this->con->prepare($sql);
      $stmt->execute(['id' => $this->id]);
      $this->con->commit();
      return 1;
    } catch (\Throwable $th) {
      $this->con->rollBack();
      return -1;
    }
  }

  public static function usernameExist($user, $pin = null): bool {
    if ($pin) {
      $con = Database::getInstanceByPin($pin);
      $sql = "SELECT * FROM users WHERE username = ? OR cellphone = ?;";
      $stmt = $con->prepare($sql);
      $stmt->execute([$user, $user]);
      $row = $stmt->fetch();
      if ($row) {
        return true;
      } else {
        return false;
      }
    } else return false;
  }
  public static function exist($user_login, $pass, $con): User {
    $user = new User($con, null);
    if ($con) {
      $sql = "SELECT * FROM users WHERE username = ? AND password = ?;";
      $passHash = hash('sha256', $pass);
      $stmt = $con->prepare($sql);
      $stmt->execute([$user_login, $passHash]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($row)
        $user->load($row);
    }
    return $user;
  }
  public static function all_users($con) {
    $res = [];
    try {
      $sql = "SELECT * FROM users;";
      $stmt = $con->prepare($sql);
      $stmt->execute();
      $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      var_dump($th);
    }
    return $res;
  }
  public static function all_residents($con, $params = []) {
    $res = [];
    try {
      $sql = "SELECT * FROM tblUsers a LEFT JOIN tblResidents b ON a.id_user = b.user_id LEFT JOIN tblDepartments c ON b.department_id = c.id_department WHERE a.role = 'resident'";

      $stmt = $con->prepare($sql);
      $stmt->execute();
      $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\Throwable $th) {
      //throw $th;
      var_dump($th);
    }
    return $res;
  }
}
