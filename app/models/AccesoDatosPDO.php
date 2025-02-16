<?php

class AccesoDatos
{
    private static $modelo = null;
    private $dbh = null;

    public static function getModelo()
    {
        if (self::$modelo == null) {
            self::$modelo = new AccesoDatos();
        }
        return self::$modelo;
    }

    private function __construct()
    {
        try {
            $dsn = "mysql:host=" . DB_SERVER . ";dbname=" . DATABASE . ";charset=utf8";
            $this->dbh = new PDO($dsn, DB_USER, DB_PASSWD);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión " . $e->getMessage();
            exit();
        }
    }

    public static function closeModelo()
    {
        if (self::$modelo != null) {
            $obj = self::$modelo;
            $obj->dbh = null;
            self::$modelo = null;
        }
    }
    public function EmailNoRepetido(string $email, int $id = null): bool
    {
        $query = "SELECT COUNT(*) FROM Clientes WHERE email = :email";
        if ($id !== null) {
            $query .= " AND id != :id";
        }

        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(':email', $email);
        if ($id !== null) {
            $stmt->bindParam(':id', $id);
        }
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count == 0;
    }

    public function numClientes(): int
    {
        $result = $this->dbh->query("SELECT id FROM Clientes");
        $num = $result->rowCount();
        return $num;
    }

    public function getClientes($primero, $cuantos): array
    {
        $tuser = [];
        $stmt_usuarios = $this->dbh->prepare("select * from Clientes " . $_SESSION['organizacion'] . "limit $primero,$cuantos");
        $stmt_usuarios->setFetchMode(PDO::FETCH_CLASS, 'Cliente');

        if ($stmt_usuarios->execute()) {
            while ($user = $stmt_usuarios->fetch()) {
                $tuser[] = $user;
            }
        }
        return $tuser;
    }

    public function getCliente(int $id)
    {
        $cli = false;
        $stmt_cli = $this->dbh->prepare("select * from Clientes where id=:id");
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $stmt_cli->bindParam(':id', $id);
        if ($stmt_cli->execute()) {
            if ($obj = $stmt_cli->fetch()) {
                $cli = $obj;
            }
        }
        return $cli;
    }

    public function getClienteSiguiente(int $id)
    {
        $cli = false;
        $stmt_cli = $this->dbh->prepare("select * from Clientes where id>:id limit 1");
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $stmt_cli->bindParam(':id', $id);
        if ($stmt_cli->execute()) {
            if ($obj = $stmt_cli->fetch()) {
                $cli = $obj;
            }
        }
        return $cli;
    }

    public function getClienteAnterior(int $id)
    {
        $cli = false;
        $sql = "SELECT * FROM Clientes WHERE id < :id ORDER BY id DESC LIMIT 1";
        $stmt_cli = $this->dbh->prepare($sql);
        $stmt_cli->setFetchMode(PDO::FETCH_CLASS, 'Cliente');
        $stmt_cli->bindParam(':id', $id);
        if ($stmt_cli->execute()) {
            if ($obj = $stmt_cli->fetch()) {
                $cli = $obj;
            }
        }
        return $cli;
    }

    public function modCliente($cli): bool
    {
        $stmt_moduser = $this->dbh->prepare("update Clientes set first_name=:first_name,last_name=:last_name" .
            ",email=:email,gender=:gender, ip_address=:ip_address,telefono=:telefono WHERE id=:id");
        $stmt_moduser->bindValue(':first_name', $cli->first_name);
        $stmt_moduser->bindValue(':last_name', $cli->last_name);
        $stmt_moduser->bindValue(':email', $cli->email);
        $stmt_moduser->bindValue(':gender', $cli->gender);
        $stmt_moduser->bindValue(':ip_address', $cli->ip_address);
        $stmt_moduser->bindValue(':telefono', $cli->telefono);
        $stmt_moduser->bindValue(':id', $cli->id);
        $stmt_moduser->execute();
        $resu = ($stmt_moduser->rowCount() == 1);
        return $resu;
    }

    public function addCliente($cli): bool
    {
        $stmt_crearcli = $this->dbh->prepare(
            "INSERT INTO `Clientes`( `first_name`, `last_name`, `email`, `gender`, `ip_address`, `telefono`)" .
            "Values(?,?,?,?,?,?)"
        );
        $stmt_crearcli->bindValue(1, $cli->first_name);
        $stmt_crearcli->bindValue(2, $cli->last_name);
        $stmt_crearcli->bindValue(3, $cli->email);
        $stmt_crearcli->bindValue(4, $cli->gender);
        $stmt_crearcli->bindValue(5, $cli->ip_address);
        $stmt_crearcli->bindValue(6, $cli->telefono);
        $stmt_crearcli->execute();
        $resu = ($stmt_crearcli->rowCount() == 1);
        return $resu;
    }

    public function borrarCliente(int $id): bool
    {
        $stmt_boruser = $this->dbh->prepare("delete from Clientes where id =:id");
        $stmt_boruser->bindValue(':id', $id);
        $stmt_boruser->execute();
        $resu = ($stmt_boruser->rowCount() == 1);
        return $resu;
    }

    public function verificarRol($login, $password): ?int
    {
        $stmt = $this->dbh->prepare("SELECT rol FROM User WHERE login = :login AND password = SHA2(:password, 256)");
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['rol'];
        } else {
            return null;
        }
    }
    public function getUltimoClienteId()
    {
        $this->stmt = $this->dbh->prepare("SELECT id FROM Clientes ORDER BY id DESC LIMIT 1");
        $this->stmt->execute();
        $row = $this->stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['id'] : null;
    }


    public function __clone()
    {
        trigger_error('La clonación no permitida', E_USER_ERROR);
    }
}