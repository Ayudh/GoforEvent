<?php

class db
{
  private $host="localhost";
  private $user="u616229738_event";
  private $pwd="Goforevent@1";
  private $dbname="u616229738_gofor";
  // private $host="localhost";
  // private $user="mysqladmin";
  // private $pwd="mysqladmin";
  // private $dbname="cse_ashv18";

  public function connect()
  {
    $mysql_connect_str = "mysql:host=$this->host;dbname=$this->dbname";
    $conn = new PDO($mysql_connect_str, $this->user, $this->pwd);
    return $conn;
  }
}