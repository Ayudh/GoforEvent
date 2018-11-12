<?php

class db
{
  // private $host="localhost";
  // private $user="u782278152_gfe";
  // private $pwd="Goforevent@2k18";
  // private $dbname="u782278152_ieee";
  private $host="localhost";
  private $user="mysqladmin";
  private $pwd="mysqladmin";
  private $dbname="cse_ashv18";

  public function connect()
  {
    $mysql_connect_str = "mysql:host=$this->host;dbname=$this->dbname";
    $conn = new PDO($mysql_connect_str, $this->user, $this->pwd);
    return $conn;
  }
}