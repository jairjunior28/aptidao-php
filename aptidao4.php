<?php
function validatePassword($password) {
  // Verifica se a senha tem pelo menos 8 caracteres
  if (strlen($password) < 8) {
      return false;
  }

  // Verifica se a senha tem pelo menos uma letra maiúscula
  if (!preg_match('/[A-Z]/', $password)) {
      return false;
  }

  // Verifica se a senha tem pelo menos uma letra minúscula
  if (!preg_match('/[a-z]/', $password)) {
      return false;
  }

  // Verifica se a senha tem pelo menos um número
  if (!preg_match('/[0-9]/', $password)) {
      return false;
  }

  // Verifica se a senha tem pelo menos um caractere especial
  if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $password)) {
      return false;
  }

  // Retorna verdadeiro se todas as verificações passarem
  return true;
}

function sanitizeInput($input) {
  // Remove espaços em branco extras no início e no fim
  $input = trim($input);

  // Remove caracteres perigosos
  $input = stripslashes($input);
  $input = htmlspecialchars($input);

  return $input;
}

// Exemplo de uso
$password = "Senha@123";
if (validatePassword($password)) {
  echo "Senha válida.\n";
} else {
  echo "Senha inválida.\n";
}

$input = "<script>alert('Hello');</script>";
$sanitizedInput = sanitizeInput($input);
echo "Entrada sanitizada: " . $sanitizedInput . "\n";

?>
