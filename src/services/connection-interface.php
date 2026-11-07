<?php

// Quería intentar un strategy pattern pero no ha funcionado muy bien en php ya que no es tipado
interface Connection_interface
{
    public function getConnection(): PDO;
}