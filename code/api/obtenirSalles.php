<?php
require_once(PATH_MODELS."UserDAO.php");
echo json_encode((new UserDAO(false, $_SESSION['login']))->getAllSalle());