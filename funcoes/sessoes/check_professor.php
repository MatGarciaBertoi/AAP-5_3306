<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['tipo'] !== 'professor') {
  die("Acesso negado.");
}